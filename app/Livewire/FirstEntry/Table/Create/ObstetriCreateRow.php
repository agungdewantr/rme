<?php

namespace App\Livewire\FirstEntry\Table\Create;

use App\Models\TmpData;
use Livewire\Component;

class ObstetriCreateRow extends Component
{
    public $tmpId;
    public $iteration;
    public $weight;
    public $gender;
    public $clinical_information;
    public $birth_date;
    public $type_of_birth;
    public $age;
    public function mount($tmpId, $iteration)
    {
        $this->tmpId = $tmpId;
        $this->iteration = $iteration;
    }

    public function updated()
    {
        if($this->weight != null){
            $tmpData = TmpData::whereTempId($this->tmpId)->whereField('weight')->first();
            if($tmpData){
                $tmpData->value = $this->weight;
                $tmpData->save();
            }
        }
        if($this->gender != null){
            $tmpData = TmpData::whereTempId($this->tmpId)->whereField('gender')->first();
            if($tmpData){
                $tmpData->value = $this->gender;
                $tmpData->save();
            }
        }
        if($this->clinical_information != null){
            $tmpData = TmpData::whereTempId($this->tmpId)->whereField('clinical_information')->first();
            if($tmpData){
                $tmpData->value = $this->clinical_information;
                $tmpData->save();
            }
        }
        if($this->age != null){
            $tmpData = TmpData::whereTempId($this->tmpId)->whereField('age')->first();
            if($tmpData){
                $tmpData->value = $this->age;
                $tmpData->save();
            }
        }
        if($this->type_of_birth != null){
            $tmpData = TmpData::whereTempId($this->tmpId)->whereField('type_of_birth')->first();
            if($tmpData){
                $tmpData->value = $this->type_of_birth;
                $tmpData->save();
            }
        }
    }
    public function render()
    {
        return view('livewire.first-entry.table.create.obstetri-create-row');
    }

    public function delete($id)
    {
        TmpData::whereTempId($id)->delete();
        $this->dispatch('obstetri-table-refresh');
    }
}
