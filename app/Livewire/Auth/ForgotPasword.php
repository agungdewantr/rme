<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Str;

class ForgotPasword extends Component
{
    #[Validate("required", as: "Email")]
    public $email;
    #[Layout("components.layouts.guest")]
    public function render()
    {
        return view('livewire.auth.forgot-pasword');
    }

    public function save()
    {
        $this->validate();
        $user = User::where('email', $this->email)->first();
        if ($user) {
            $new_password = Str::random(10);
            $details = [
                'nama' => $user->name,
                'password' => $new_password,
            ];
            $user->password = bcrypt($new_password);
            $user->save();
            Mail::to($this->email)->send(new \App\Mail\MyTestMail($details));
            Toaster::success("Password baru berhasil dikirimkan ke email anda");
            return $this->redirect('/', navigate: true);
        } else {
            Toaster::error("Email yang anda masukkan tidak terdaftar di aplikasi kami");
        }
    }
}
