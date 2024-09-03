<?php

namespace App\Livewire\Profil;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class Show extends ModalComponent
{
    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $email;

    #[Validate('required')]
    public $password;

    #[Validate('required|same:password')]
    public $confirm_password;

    public function mount()
    {
        $this->name =  auth()->user()->name;
        $this->email =  auth()->user()->email;
    }

    public function render()
    {
        return view('livewire.profil.show');
    }

    public function save()
    {
        $this->validate();
        try {
            $user = User::whereId(auth()->user()->id)->first();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = bcrypt($this->password);
            $user->save();
            Toaster::success("Profil Berhasil diubah");
            $this->closeModal();
            return $this->redirect('/', navigate: true);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            Toaster::error('Profil gagal diubah');
        }
    }
}
