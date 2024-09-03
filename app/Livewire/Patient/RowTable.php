<?php

namespace App\Livewire\Patient;

use App\Models\Job;
use App\Models\Patient;
use Livewire\Component;
use Toaster;

class RowTable extends Component
{
    public $emergency_contact;
    public $name;
    public $address;
    public $relationship;
    public $phone_number;
    public $job;
    public $iteration;

    public function mount($emergency_contact, $iteration)
    {
        $this->iteration = $iteration;
        $this->emergency_contact = $emergency_contact;
        $this->address = $emergency_contact->address;
        $this->name = ucwords(strtolower($emergency_contact->name));
        $this->relationship = $emergency_contact->relationship;
        $this->phone_number = $emergency_contact->phone_number;
        $this->job = $emergency_contact->job;
    }

    public function updated($property)
    {
        if ($property == 'name') {
            if($this->name == ''){
                Toaster::error('Nama tidak boleh kosong');
                return;
            }
            $this->emergency_contact->name = $this->name;
            $this->emergency_contact->save();
        }
        if ($property == 'address') {
            if($this->address == ''){
                Toaster::error('Alamat tidak boleh kosong');
                return;
            }
            $this->emergency_contact->address = $this->address;
            $this->emergency_contact->save();
        }
        if ($property == 'relationship') {
            if($this->relationship == ''){
                Toaster::error('Hubungan tidak boleh kosong');
                return;
            }
            $this->emergency_contact->relationship = $this->relationship;
            $this->emergency_contact->save();
        }
        if ($property == 'phone_number') {
            if(strlen($this->phone_number) < 10){
                Toaster::error('Nomor telepon kontak darurat tidak sesuai format. Minimal 10 Angka');
                return;
            }
            $this->emergency_contact->phone_number = $this->phone_number;
            $this->emergency_contact->save();
        }
        if ($property == 'job') {
            $this->emergency_contact->job = $this->job;
            $this->emergency_contact->save();
        }
    }

    public function render()
    {
        return view('livewire.patient.row-table',[
            'jobs' => Job::all()
        ]);
    }

    public function delete()
    {
        $this->emergency_contact->delete();
        $this->dispatch('refresh-patient-edit');
    }

    public function setHusband()
    {
        $patient = Patient::find($this->emergency_contact->patient_id);

        if($this->job){
            if (is_numeric($this->job)) {
                $check_husbandjob = Job::find($this->job);
                if (!$check_husbandjob) {
                    $check_husbandjob = new Job();
                    $check_husbandjob->name = $this->job;
                    $check_husbandjob->save();
                }
            } else {
                $check_husbandjob = Job::where('name', $this->job)->first();
                if (!$check_husbandjob) {
                    $check_husbandjob = new Job();
                    $check_husbandjob->name = $this->job;
                    $check_husbandjob->save();
                }
            }
        }

        $patient->husbands_name = $this->name;
        $patient->husbands_address = $this->address;
        $patient->husbands_phone_number = $this->phone_number;
        $patient->husbands_job = $check_husbandjob->name;
        $patient->save();
        return $this->redirectRoute('patient.edit',$patient->uuid, navigate: true);
        // $this->dispatch('refresh-patient-edit');
    }
}
