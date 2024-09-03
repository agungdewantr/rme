<?php

namespace App\Livewire\Setting\Fee;

use App\Models\Action;
use App\Models\SipFee;
use Livewire\Component;
use Toaster;

class Index extends Component
{
    public $actions = [];

    public function mount()
    {
        $actions = Action::query()
            ->select('id', 'name')
            ->with([
                'sipFee' => function ($query) {
                    $query->select('id', 'sip_fee', 'non_sip_fee', 'action_id');
                }
            ])
            ->has('sipFee')
            ->get();
        foreach ($actions as $value) {
            $this->actions[] = [
                'temp_id' => rand(),
                'id' => $value->id,
                'sip_fee' => $value->sipFee?->sip_fee ?? 0,
                'non_sip_fee' => $value->sipFee?->non_sip_fee ?? 0,
            ];
        }
    }
    public function render()
    {
        return view('livewire.setting.fee.index', [
            'actionList' => Action::all(['id', 'name'])
        ]);
    }

    public function getActions()
    {
        $actions = Action::query()
            ->select('id', 'name')
            ->with([
                'sipFee' => function ($query) {
                    $query->select('id', 'sip_fee', 'non_sip_fee', 'action_id');
                }
            ])
            ->get();

        $this->actions = [];
        foreach ($actions as $value) {
            $this->actions[] = [
                'temp_id' => rand(),
                'id' => $value->id,
                'sip_fee' => $value->sipFee?->sip_fee ?? 0,
                'non_sip_fee' => $value->sipFee?->non_sip_fee ?? 0,
            ];
        }
    }

    // public function deleteRow($id)
    // {
    //     SipFee::where('id', $id)->delete();

    //     return $this->dispatch(
    //         'get-actions',
    //         items: Action::query()
    //             ->select('id', 'name')
    //             ->with([
    //                 'sipFee' => function ($query) {
    //                     $query->select('id', 'sip_fee', 'non_sip_fee', 'action_id');
    //                 }
    //             ])
    //             ->has('sipFee')
    //             ->get()
    //             ->toArray()
    //     );
    // }

    public function save()
    {
        if (is_array($this->actions)) {
            foreach ($this->actions as $a) {
                if(($a['id'] == '' || $a['id'] == null) || $a['sip_fee'] == '' ||  $a['non_sip_fee'] == ''){
                    Toaster::error('Pastikan tidak ada field kosong');
                    return;
                }
            }
            foreach ($this->actions as $a) {
                if(($a['id'] == '' || $a['id'] == null) || $a['sip_fee'] == '' ||  $a['non_sip_fee'] == ''){
                    Toaster::error('Pastikan tidak ada field kosong');
                    return;
                }
                $action = Action::find($a['id']);
                if ($action) {
                    $action->sipFee()->updateOrCreate([
                        'action_id' => $action->id
                    ], [
                        'sip_fee' => $a['sip_fee'],
                        'non_sip_fee' => $a['non_sip_fee'],
                    ]);
                }
            }
        }

        Toaster::success('Berhasil disimpan');
        return $this->redirectRoute('doctor-fee.index');
    }
}
