<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;
use App\Models\Registration;

class Queue extends Component
{
    public $queue_number = 0;
    public $name = "";
    public $running_text;
    public $photo;

    public function mount()
    {
        $this->running_text = Setting::whereField('running_text')->first()->value ?? null;
        $this->photo = Setting::whereField('header_logo')->first()->value ?? null;
    }

    public function render()
    {
        return view('livewire.queue');
    }

    public function getPatient($queue_number)
    {
        //TODO: Ganti branch id biar dinamis kayak skp atau simpeg
        $registration = Registration::with('user')->where('queue_number', $queue_number)->where('branch_id', 1)->where('date', date('Y-m-d'))->first();
        if ($registration) {
            $this->queue_number = str_pad($queue_number, 2, "0", STR_PAD_LEFT);
            $this->name = $registration->user->name;
        } else {
            $this->queue_number = str_pad($queue_number, 2, "0", STR_PAD_LEFT);
            $this->name = "";
        }
    }
}
