<div class="card-body">
    <div class="d-flex justify-content-between align-items-center">
        <p class="h6">Laborate</p>

    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laborates as $index => $laborate)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td wire:ignore>
                            <select class="form-control" x-data="{
                                laborateId: @entangle('laborates.' . $index . '.item_id').live
                            }" x-init="() => {
                                $($el).select2({
                                    placeholder: 'Pilih Laborate',
                                    width: '100%',
                                    theme: 'bootstrap-5',
                                });
                            
                                $($el).on('change', function() {
                                    laborateId = $el.value
                                })
                            
                                $($el).val(laborateId).trigger('change');
                            }">
                                <option value="">Pilih Laborate</option>
                                @foreach ($laborateOptions as $laborateOption)
                                    <option value="{{ $laborateOption->id }}">{{ $laborateOption->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" wire:model.blur="laborates.{{ $index }}.qty"
                                class="form-control">
                        </td>
                        <td>
                            <input type="text" wire:model="laborates.{{ $index }}.price" class="form-control"
                                readonly>
                        </td>
                        <td>
                            <input type="text" wire:model.blur="laborates.{{ $index }}.discount"
                                class="form-control">
                        </td>
                        <td>
                            <input type="text" wire:model="laborates.{{ $index }}.total" class="form-control"
                                readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger"
                                wire:click="remove({{ $laborate['temp_id'] }})">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" align="center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <button type="button" class="btn btn-sm btn-primary mb-2" wire:click="add">Tambah</button>
</div>

@assets
    <style>
        table td {
            position: relative;
        }

        table td input,
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
