<?php

namespace App\Livewire\HealthWorker;

use App\Models\HealthWorker;
use App\Models\User;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Propaganistas\LaravelPhone\PhoneNumber;
use Toaster;

class Edit extends ModalComponent
{
    #[Validate('required', as: 'Nama Nakes')]
    public $name;

    #[Validate('required|boolean', as: 'Jenis Kelamin')]
    public $gender;

    #[Validate('required|phone:ID', as: 'Handphone')]
    public $phone_number;

    #[Validate('required|in:Dokter,Perawat', as: 'Posisi')]
    public $position;

    #[Validate('required|email:rfc,dns', as: 'Email')]
    public $email;

    #[Validate('nullable', as: 'Izin Praktek')]
    public $practice_license;

    #[Validate('required', as: 'Alamat')]
    public $address;

    #[Validate('required|boolean', as: 'Status')]
    public $status;

    public ?HealthWorker $healthWorker;
    public function mount($uuid)
    {
        $healthWorker = HealthWorker::with('user')->where('uuid', $uuid)->first();
        $this->healthWorker = $healthWorker;
        $this->name = $healthWorker->name;
        $this->gender = $healthWorker->gender ? '1' : '0';
        $this->phone_number =  substr($healthWorker->phone_number, 3);
        $this->position = $healthWorker->position;
        $this->email = $healthWorker->email;
        $this->practice_license = $healthWorker->practice_license;
        $this->address = $healthWorker->address;
        $this->status = $healthWorker->status ? '1' : '0';
        $this->dispatch('loading-edit', false);
    }

    public function render()
    {
        $this->authorize('update', $this->healthWorker);
        return view('livewire.health-worker.edit');
    }

    public function save()
    {
        $this->validate();
        $this->authorize('update', $this->healthWorker);
        $phone_number = new PhoneNumber($this->phone_number, 'ID');
        try {
            $healthWorker = HealthWorker::find($this->healthWorker->id);
            $user = User::find($this->healthWorker->user_id);
            $healthWorker->name = $this->name;
            $healthWorker->address = $this->address;
            $healthWorker->email = $this->email;
            $healthWorker->practice_license = $this->practice_license;
            $healthWorker->status = $this->status;
            $healthWorker->position = $this->position;
            $healthWorker->phone_number = $phone_number->formatE164();
            $healthWorker->gender = $this->gender;
            $healthWorker->save();

            $user->name = $this->name;
            if ($user->email != $this->email) {
                $user->email = $this->email;
            }
            if ($this->position == 'Perawat') {
                $user->role_id = 5;
            } else {
                $user->role_id = 2;
            }
            $user->save();

            Toaster::success('Data Tenaga Kesehatan berhasil diubah');
            $this->dispatch('health-worker-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            dd($th);
            Toaster::success('Gagal ubah. Coba beberapa saat lagi');
        }
    }
}
