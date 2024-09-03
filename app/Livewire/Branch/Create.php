<?php

namespace App\Livewire\Branch;

use App\Models\Branch;
use App\Models\OperationalHour;
use App\Models\Poli;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Toaster;

class Create extends Component
{
    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $status = 'Aktif';
    #[Validate('required')]
    public $address;
    #[Validate('required')]
    public $phone_number;
    public $poli = [];
    public $days = [
        'senin' => ['status' => true, ['poli' => null, 'open' => null, 'close' => null, 'id' => 1]],
        'selasa' => ['status' => true, ['poli' => null, 'open' => null, 'close' => null, 'id' => 2]],
        'rabu' => ['status' => true, ['poli' => null, 'open' => null, 'close' => null, 'id' => 3]],
        'kamis' => ['status' => true, ['poli' => null, 'open' => null, 'close' => null, 'id' => 4]],
        'jumat' => ['status' => true, ['poli' => null, 'open' => null, 'close' => null, 'id' => 5]],
        'sabtu' => ['status' => true, ['poli' => null, 'open' => null, 'close' => null, 'id' => 6]],
        'minggu' => ['status' => true, ['poli' => null, 'open' => null, 'close' => null, 'id' => 7]],
    ];

    public function addRow($day) {
        $this->days[$day][] = ['poli' => null, 'open' => null, 'close' => null, 'id' => rand()];
    }

    public function deleteRow($day, $index, $id) {
        if (isset($this->days[$day][$index])) {
            unset($this->days[$day][$index]);
            // Re-index the array to maintain proper keys
            $this->days[$day] = array_values($this->days[$day]);
        }
    }



    public function render()
    {
        return view('livewire.branch.create',[
            'polis' => Poli::where('is_active', true)->get()
        ]);
    }


    public function save()
    {
        $this->validate();
        try {
            \DB::beginTransaction();

            $branch = new Branch();
            $branch->name = $this->name;
            $branch->address = $this->address;
            $branch->phone_number = $this->phone_number;
            $branch->is_active = $this->status == 'Aktif' ? true : false;
            $branch->save();

            $branch->poli()->attach(Poli::whereIn('name',$this->poli)->pluck('id'));

            foreach ($this->days as $key => $day) {

                $status = null;
                foreach($day as $key2 => $d){
                    if(!is_array($d)){
                        $status = $d;
                    }else{
                        $operational = new OperationalHour();
                        $operational->day = $key;
                        $operational->active = $status;
                        $operational->branch_id = $branch->id;
                        $operational->shift = $d['poli'];
                        $operational->open = $d['open'];
                        $operational->close = $d['close'];
                        $operational->save();
                    }
                }

            }
            \DB::commit();
            Toaster::success('Cabang berhasil dibuat');
            return $this->redirectRoute('branch.index', navigate: true);

        } catch (\Throwable $th) {
            \DB::rollback();
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');

        }
    }
}
