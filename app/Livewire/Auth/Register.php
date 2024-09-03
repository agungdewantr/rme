<?php

namespace App\Livewire\Auth;

use App\Models\Patient;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Propaganistas\LaravelPhone\PhoneNumber;

class Register extends Component
{
    #[Validate('required', as: 'Nama')]
    public $name;

    #[Validate('required|unique:patients|size:16|string', as: 'NIK')]
    public $nik;

    #[Validate('required|unique:patients', as: 'Nomor Handphone')]
    public $phone_number;

    #[Validate('required|unique:users|email:rfc,dns', as: 'Email')]
    public $email;

    #[Validate('required|confirmed', as: 'Password')]
    public $password;

    public $password_confirmation;

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.auth.register');
    }

    public function save()
    {
        $this->validate();

        try {
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = bcrypt($this->password);
            $user->role_id = 3;
            $user->save();

            $phone_number = new PhoneNumber($this->phone_number, 'ID');

            $lastPatient = Patient::latest()->first();
            $patient = new Patient();
            if ($lastPatient == null) {
                $patient->patient_number = 'P.' . date('m') . '.' . '0001';
            } else {
                $patient->patient_number = 'P.' . date('m') . '.' . str_pad((int)explode('.', $lastPatient->patient_number)[2] + 1, 4, "0", STR_PAD_LEFT);
            }
            $patient->nik = $this->nik;
            $patient->phone_number = $phone_number->formatE164();
            $patient->name = $this->name;
            $patient->user_id = $user->id;
            $patient->save();

            return $this->redirect('/', navigate: true);
        } catch (\Throwable $th) {
            $this->dispatch('toast', 'error', 'Gagal daftar. Silakan coba beberapa saat lagi');
        }
    }
}
