<?php

namespace App\Livewire\Poli;

use App\Models\CheckUp;
use App\Models\Poli;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Edit extends ModalComponent
{
    public ?Poli $poli;
    #[Validate('required')]
    public $name;
    public $is_active;
    public $checkups = [];
    public function mount($uuid)
    {
        $poli = Poli::with('checkups')->where('uuid',$uuid)->first();
        $this->poli = $poli;
        $this->name = $poli->name;
        $this->is_active = $poli->is_active;
        $this->checkups = !empty($poli->checkups) ? $poli->checkups->toArray() : [];


    }
    public function render()
    {
        return view('livewire.poli.edit');
    }

    public function save()
    {
        $this->validate();
        try {
            $this->poli->name = $this->name;
            $this->poli->is_active = $this->is_active;
            $this->poli->save();

            if(is_array(($this->checkups))){
                foreach ($this->checkups as $c) {
                    $checkup = CheckUp::find($c['id']);
                    if($checkup){
                        $checkup->name = $c['name'];
                        $checkup->is_active = $c['is_active'];
                        $checkup->save();
                    }else{
                        $checkup = new CheckUp();
                        $checkup->name = $c['name'];
                        $checkup->is_active = $c['is_active'];
                        $checkup->poli_id = $this->poli->id;
                        $checkup->save();
                    }
                }
            }

            Toaster::success('Poli berhasil diubah');
            $this->dispatch('poli-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }

    #[On('poli-edit')]
    public function refresh()
    {
    }

    public function addCheckup()
    {
        $checkup = new CheckUp();
        $checkup->poli_id = $this->poli->id;
        $checkup->name = '';
        $checkup->is_active = true;
        $checkup->save();
        $this->dispatch('poli-edit');
        $this->dispatch('$refresh');
    }

    public function deleteRow($id)
    {
        CheckUp::where('id', $id)->delete();
        if(count($this->poli->checkups) > 0){
            return $this->dispatch(
                'get-checkup',
                items: $this->poli->checkups->toArray()
            );
        }else{
            $filtered_array = array_filter($this->checkups, function ($item) use ($id) {
                return $item['id'] !== $id;
            });

            $this->checkups = array_values($filtered_array);

            return $this->dispatch(
                'get-checkup',
                items: $this->checkups
            );
        }
    }

}
