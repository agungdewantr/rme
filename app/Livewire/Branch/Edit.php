<?php

namespace App\Livewire\Branch;

use App\Models\Branch;
use App\Models\OperationalHour;
use App\Models\Poli;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
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
    public ?Branch $branch;

    public $days = [
        'senin' => ['status' => true, 'data' => []],
        'selasa' => ['status' => true, 'data' => []],
        'rabu' => ['status' => true, 'data' => []],
        'kamis' => ['status' => true, 'data' => []],
        'jumat' => ['status' => true, 'data' => []],
        'sabtu' => ['status' => true, 'data' => []],
        'minggu' => ['status' => true, 'data' => []],
    ];

    public function addRow($day)
    {
        $this->days = [...$this->days, $day => [...$this->days[$day], 'data' => [...$this->days[$day]['data'], ['poli' => null, 'open' => null, 'close' => null, 'id' => rand()]]]];
    }

    public function deleteRow($day, $id)
    {
        $operationHour = OperationalHour::find($id);
        if ($operationHour) {
            $operationHour->delete();
        }
        $this->days = [...$this->days, $day => [...$this->days[$day], 'data' => array_filter($this->days[$day]['data'], fn ($value) => $value['id'] != $id)]];
    }


    public function mount($uuid)
    {
        $branch = Branch::with('poli', 'operationHour')->where('uuid', $uuid)->first();
        $operationHour = OperationalHour::where('branch_id', $branch->id)->get()->groupBy('day');
        $this->poli = $branch->poli->pluck('name');

        if ($operationHour->count() == 0) {
            foreach ($this->days as $day => $value) {
                $this->days[$day]['status'] = true; // Keeping status as false
                $this->days[$day]['data'][] = [
                    'poli' => null,
                    'open' => null,
                    'close' => null,
                    'id' => null,
                ];
            }
        } else {
            foreach ($operationHour as $key => $oh) {
                $day = $key;
                $status = true;
                foreach ($oh as $o) {
                    if ($o->active == false) {
                        $status = false;
                    }
                    $this->days[$day]['status'] = $status;
                    $this->days[$key]['data'][] = [
                        'poli' => $o->shift,
                        'open' => $o->open,
                        'close' => $o->close,
                        'id' => $o->id,
                    ];
                }
            }
        }
        $this->branch = $branch;
        $this->name = $branch->name;
        $this->status = $branch->is_active;
        $this->address = $branch->address;
        $this->phone_number = $branch->phone_number;
    }



    public function render()
    {
        return view('livewire.branch.edit', [
            'polis' => Poli::where('is_active', true)->get()

        ]);
    }

    public function save()
    {
        $this->validate();
        try {
            \DB::beginTransaction();
            $this->branch->name = $this->name;
            $this->branch->is_active = $this->status;
            $this->branch->address = $this->address;
            $this->branch->phone_number = $this->phone_number;
            $this->branch->save();
            $this->branch->poli()->sync(Poli::whereIn('name', $this->poli)->pluck('id'));

            foreach ($this->days as $key => $day) {
                $status = null;
                foreach ($day as $key2 => $d) {
                    if (!is_array($d)) {
                        $status = $d;
                    } else {
                        foreach ($d as $key3 => $x) {
                            $data = [
                                'open' => $x['open'],
                                'close' => $x['close'],
                                'shift' => $x['poli'],
                                'day' => $key,
                                'active' => $status,
                                'branch_id' => $this->branch->id
                            ];
                            if (isset($x['id'])) {
                                $data['id'] = $x['id'];
                            }
                            OperationalHour::upsert(
                                [$data],
                                ['id'],
                                // Columns to update if a conflict is detected
                                ['open', 'close', 'shift', 'day', 'active']
                            );
                        }
                    }
                }
            }
            \DB::commit();
            Toaster::success('Cabang berhasil diubah');
            return $this->redirectRoute('branch.index', navigate: true);
        } catch (\Throwable $th) {
            \DB::rollback();
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
