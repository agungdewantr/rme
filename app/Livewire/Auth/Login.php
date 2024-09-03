<?php

namespace App\Livewire\Auth;

use App\Models\Patient;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Login extends Component
{
    #[Validate("required", as: "Email")]
    public $email_nik;

    #[Validate("required", as: "Password")]
    public $password;

    #[Layout("components.layouts.guest")]
    public function render()
    {
        return view("livewire.auth.login");
    }

    public function save()
    {
        $this->validate();

        $profile = Patient::with("user")
            ->where("nik", $this->email_nik)
            ->first();
        if (filter_var($this->email_nik, FILTER_VALIDATE_EMAIL)) {
            if (
                Auth::attempt([
                    "email" => $profile ? $profile->user->email : $this->email_nik,
                    "password" => $this->password,
                ])
            ) {
                Session::remove('url.intended');
                $this->dispatch('login');
                return;
                // return $this->redirectIntended("/dashboard");
            }
            Toaster::error("Email atau password Anda salah");
        } else {
            if ($profile) {
                if ($profile->nik == $this->email_nik && Hash::check($this->password, $profile->user->password)) {
                    Auth::login($profile->user);
                    Session::remove('url.intended');
                    return $this->redirectIntended("/dashboard");
                } else {
                    Toaster::error("email atau password Anda salah");
                }
            } else {
                Toaster::error("email yang anda masukkan tidak terdaftar");
            }
        }
    }
}
