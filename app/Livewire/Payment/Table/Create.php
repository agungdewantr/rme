<?php

namespace App\Livewire\Payment\Table;

use App\Models\Action;
use App\Models\DrugMedDev;
use App\Models\TmpData;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Symfony\Component\Console\Output\ConsoleOutput;

class Create extends Component
{
    #[Modelable]
    public $itemsSelected = [];
    public $total;
    public $type;

    public function mount($total, $type)
    {
        $this->total = $total;
        $this->type = $type;
        // $this->itemsSelected = $itemsSelected;
    }

    public function updated($property)
    {
        $console = new ConsoleOutput();
        if (str_contains($property, 'item_id')) {
            $index = explode('.', $property)[1];
            $itemId = $this->itemsSelected[$index]['item_id'];
            $console->writeln($index . ' index');
            $item = null;
            if ($this->type == 'drug') {
                $item = DrugMedDev::find($itemId);
            } else {
                $item = Action::find($itemId);
            }
            // dd($index, $laborateId, $laborate->price);
            if ($item) {
                $price = $this->type == 'drug' ? $item->selling_price : $item->price;
                $this->itemsSelected = [
                    ...$this->itemsSelected,
                    $index => [
                        ...$this->itemsSelected[$index],
                        'uom' => $item->uom ?? '-',
                        'type' => $item->type ?? '-',
                        'price' => number_format($price, 0, '.', '.'),
                        'total' => number_format($price * $this->itemsSelected[$index]['qty'], 0, '.', '.')
                    ]
                ];
            }
            $console->writeln(json_encode($this->itemsSelected));
        } else {
            $index = explode('.', $property)[1];
            // dd($index, $laborateId, $laborate->price);
            $this->itemsSelected = [
                ...$this->itemsSelected,
                $index => [
                    ...$this->itemsSelected[$index],
                    'price' => number_format(str_replace('.', '', $this->itemsSelected[$index]['price']), 0, '.', '.'),
                    'total' => number_format(
                        $this->itemsSelected[$index]['qty'] *
                            str_replace('.', '', $this->itemsSelected[$index]['price']) -
                            str_replace('Rp', '', $this->itemsSelected[$index]['discount']),
                        0,
                        '.',
                        '.'
                    )
                ]
            ];
        }

        if ($this->type == 'drug') {
            $this->dispatch('set-drugmeddevs', $this->itemsSelected);
        } else {
            $this->dispatch('set-actions', $this->itemsSelected);
        }
    }

    public function render()
    {
        $items = [];
        if ($this->type == 'drug') {
            $items = DrugMedDev::all();
        } else {
            $items = Action::all();
        }
        return view('livewire.payment.table.create', [
            'items' => $items
        ]);
    }

    public function add()
    {
        $this->itemsSelected[] = [
            'temp_id' => rand(),
            'item_id' => '',
            'qty' => 1,
            'uom' => '-',
            'type' => '-',
            'price' => 0,
            'discount' => 0,
            'total' => 0,
        ];
    }

    public function remove($temp_id)
    {
        $console = new ConsoleOutput();
        // unset($this->itemsSelected[$index]);
        $temp = $this->itemsSelected;
        $this->itemsSelected = [];
        foreach ($temp as $key => $value) {
            if ($value['temp_id'] !== $temp_id) {

                $this->itemsSelected[] = $value;
            }
        }
        $console->writeln(json_encode($this->itemsSelected));
        if ($this->type == 'drug') {
            $this->dispatch('set-drugmeddevs', $this->itemsSelected);
        } else {
            $this->dispatch('set-actions', $this->itemsSelected);
        }
    }
}
