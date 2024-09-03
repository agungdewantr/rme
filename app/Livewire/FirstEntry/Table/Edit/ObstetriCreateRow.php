<?php

namespace App\Livewire\FirstEntry\Table\Edit;

use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ObstetriCreateRow extends Component
{
    public $obstetri;
    public $iteration;
    public $weight;
    public $gender;
    public $clinical_information;
    public $birth_date;
    public $type_of_birth;
    public $age;
    public $created_at;

    public function mount($obstetri, $iteration)
    {
        $this->iteration = $iteration;
        $this->obstetri = $obstetri;
        $this->weight = $obstetri->weight;
        $this->gender = $obstetri->gender ?? NULL;
        $this->clinical_information = $obstetri->clinical_information;
        $this->age = $obstetri->age;
        $this->type_of_birth = $obstetri->type_of_birth;
        $this->created_at = $obstetri->created_at;
        // $this->age = Carbon::parse($this->birth_date)->diff(Carbon::now())->format('%y tahun %m bulan');
    }

    public function updated($property)
    {
        if($property == 'weight'){
            if(($this->weight >= 2147483647 && filter_var($this->weight, FILTER_VALIDATE_INT))){
                Toaster::error('Berat badan melebihi batas maksimal karakter');
                return;
            }
            $this->obstetri->weight = $this->weight == '' ? NULL : $this->weight;
             $this->obstetri->save();
        }
        if($property == 'gender'){
            if($this->gender == ''){
                Toaster::error('gender Tidak boleh kosong');
                return;
            }
            $this->obstetri->gender = $this->gender ??  NULL;
             $this->obstetri->save();
        }
        if($property == 'clinical_information'){
            $this->obstetri->clinical_information = $this->clinical_information;
             $this->obstetri->save();
        }
        if($property == 'age'){
            $this->obstetri->age = $this->age;
             $this->obstetri->save();
        }
        if($property == 'type_of_birth'){
            if($this->type_of_birth == ''){
                Toaster::error('Jenis Persalinan Tidak boleh kosong');
                return;
            }
            $this->obstetri->type_of_birth = $this->type_of_birth;
             $this->obstetri->save();
        }

    }

    public function render()
    {
        return view('livewire.first-entry.table.edit.obstetri-create-row');
    }

    public function delete()
    {
        $this->obstetri->delete();
        $this->dispatch('refresh-first-entry-edit');
    }
}
