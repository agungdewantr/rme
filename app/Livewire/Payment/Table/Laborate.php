<?php

namespace App\Livewire\Payment\Table;

use App\Models\Laborate as ModelsLaborate;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Laborate extends Component
{
    #[Modelable]
    public $laborates = [];

    public function updated($property)
    {
        if (str_contains($property, 'item_id')) {
            $index = explode('.', $property)[1];
            $laborateId = $this->laborates[$index]['item_id'];
            $laborate = ModelsLaborate::find($laborateId);
            // dd($index, $laborateId, $laborate->price);
            if ($laborate) {
                $this->laborates[$index] = [
                    // ...$this->laborates,
                    // $index => [
                    ...$this->laborates[$index],
                    'price' => number_format($laborate->price, 0, '.', '.'),
                    'total' => number_format($laborate->price, 0, '.', '.')
                    // ]
                ];
            }
        } else {
            $index = explode('.', $property)[1];
            // dd($index, $laborateId, $laborate->price);
            $this->laborates[$index] = [
                // ...$this->laborates,
                // $index => [
                ...$this->laborates[$index],
                'price' => number_format(str_replace('.', '', $this->laborates[$index]['price']), 0, '.', '.'),
                'total' => number_format($this->laborates[$index]['qty'] * str_replace('.', '', $this->laborates[$index]['price']) - $this->laborates[$index]['discount'], 0, '.', '.')
                // ]
            ];
        }

        $this->dispatch('set-laborates', $this->laborates);

        // $this->dispatch(
        //     'grand-total-change',
        //     totalLaborate: array_reduce($this->laborates, fn ($a, $b) => $a + str_replace('.', '', $b['total']), 0)
        // );
    }

    public function render()
    {
        return view('livewire.payment.table.laborate', [
            'laborateOptions' => ModelsLaborate::where('type', 'Eksternal')->get()
        ]);
    }

    public function add()
    {
        $temp_id = rand();
        $this->laborates[$temp_id] = [
            'temp_id' => rand(),
            'item_id' => '',
            'qty' => 1,
            'price' => 0,
            'discount' => 0,
            'total' => 0,
        ];
    }

    public function remove($index)
    {
        $temp = $this->laborates;
        $this->laborates = [];
        foreach ($temp as $key => $value) {
            if ($value['temp_id'] !== $index) {
                $this->laborates[$key] = $value;
            }
        }
        unset($this->laborates[$index]);
        $this->dispatch('set-laborates', $this->laborates);
    }
}
