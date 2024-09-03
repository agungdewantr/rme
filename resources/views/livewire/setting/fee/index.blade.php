<x-slot:title>
    Fee Dokter
</x-slot:title>

<x-page-layout>
    <form id="form" wire:submit="save" x-data="fee">
        <x-slot:button>
            <button class="btn btn-primary" wire:click="save">Simpan</button>
        </x-slot:button>

        <x-slot:breadcrumbs>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Fee Setting</li>
        </x-slot:breadcrumbs>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary" type="button" wire:click="getActions">Get Data</button>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th style="width: 600px">Tindakan</th>
                                        <th>Fee Dokter (SIP)</th>
                                        <th>Fee Dokter (Non SIP)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-if="actions.length">
                                        <template x-for="(action, index) in actions" :key="action.temp_id">
                                            <tr>
                                                <td x-text="index+1"></td>
                                                <td wire:ignore>
                                                    <select name="" id="" x-init="() => {
                                                        $($el).select2({
                                                            placeholder: 'Pilih Tindakan',
                                                            width: '100%',
                                                            theme: 'bootstrap-5',
                                                        })
                                                    
                                                        $($el).on('change', function(e) {
                                                            action.id = $el.value
                                                        })
                                                    
                                                        $($el).val(action.id).trigger('change');
                                                    }">
                                                        @foreach ($actionList as $a)
                                                            <option value="{{ $a->id }}">{{ $a->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" x-model="action.sip_fee">
                                                </td>
                                                <td>
                                                    <input type="text" x-model="action.non_sip_fee">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        x-on:click="deleteRow(action.temp_id)"><i
                                                            class="fa-solid fa-trash-can"></i></button>
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                    <template x-if="!actions.length">
                                        <tr>
                                            <td colspan="5" align="center">Tidak ada data</td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-sm btn-primary" type="button" x-on:click="addRow">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <style>
        table td {
            position: relative;
        }

        table td input[type=text],
        table td select {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            margin: 0;
            height: 100% !important;
            width: 100%;
            border-radius: 0 !important;
            border: none !important;
            padding: 5px;
            box-sizing: border-box;
        }
    </style>
@endassets

@script
    <script>
        Alpine.data('fee', () => ({
            actions: @entangle('actions'),

            addRow() {
                this.actions.push({
                    temp_id: Math.floor(Math.random() * 1000) + 1,
                    id: null,
                    name: null,
                    sip_fee: 0,
                    non_sip_fee: 0
                })
            },

            deleteRow(temp_id) {
                this.actions = this.actions.filter((action) => action.temp_id != temp_id);
            }
        }))
    </script>
@endscript
