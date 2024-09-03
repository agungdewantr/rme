<?php

namespace App\Livewire\HealthWorker;

use App\Models\HealthWorker;
use App\Models\User;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;
use Propaganistas\LaravelPhone\PhoneNumber;

class Create extends ModalComponent
{
    #[Validate('required', as: 'Nama Nakes')]
    public $name;

    #[Validate('required|boolean', as: 'Jenis Kelamin')]
    public $gender;

    #[Validate('required|phone:ID', as: 'Handphone')]
    public $phone_number;

    #[Validate('required|in:Dokter,Perawat', as: 'Posisi')]
    public $position;

    #[Validate('required|email:rfc,dns|unique:users', as: 'Email')]
    public $email;

    #[Validate('nullable', as: 'Izin Praktek')]
    public $practice_license;

    #[Validate('required', as: 'Alamat')]
    public $address;

    #[Validate('required|boolean', as: 'Status')]
    public $status;

    public function render()
    {
        $this->authorize('create', HealthWorker::class);
        return view('livewire.health-worker.create');
    }

    public function save()
    {
        $this->validate();

        $this->authorize('create', HealthWorker::class);
        $phone_number = new PhoneNumber($this->phone_number, 'ID');
        try {
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = bcrypt(12345678);
            if ($this->position == 'Perawat') {
                $user->role_id = 5;
            } else {
                $user->role_id = 2;
            }
            $user->save();
            $healthWorker = new HealthWorker();
            $healthWorker->name = $this->name;
            $healthWorker->address = $this->address;
            $healthWorker->email = $this->email;
            $healthWorker->practice_license = $this->practice_license;
            $healthWorker->status = $this->status;
            $healthWorker->position = $this->position;
            $healthWorker->phone_number = $phone_number->formatE164();
            $healthWorker->gender = $this->gender;
            $healthWorker->user_id  = $user->id;
            $healthWorker->save();


            Toaster::success('Tenaga Kesehatan berhasil dibuat');
            $this->dispatch('health-worker-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::success('Gagal buat. Coba beberapa saat lagi');
        }
    }
}
