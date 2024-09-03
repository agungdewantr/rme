<div class="card-body">
    <div class="d-flex justify-content-between align-items-center">
        <p class="h6">{{ $type == 'drug' ? 'Obat' : 'Tindakan' }}</p>

    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($itemsSelected ?? [] as $index=>$row)
                    <tr wire:key="{{ $row['temp_id'] }}" x-data="{
                        itemId: @entangle('itemsSelected.' . $index . '.item_id').live,
                    }">
                        <td>{{ $loop->iteration }}</td>
                        <td style="width:250px" wire:ignore>
                            <select name="drug_action_id" class="form-select" x-init="() => {
                                $($el).select2({
                                    placeholder: 'Pilih {{ $type == 'drug' ? 'Obat/Alkes' : 'Tindakan' }}',
                                    width: '100%',
                                    theme: 'bootstrap-5',
                                })
                                $($el).on('change', function() {
                                    itemId = $el.value
                                    console.log(itemId)
                                })
                                $($el).val(itemId).trigger('change');
                            }">
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" placeholder="0"
                                wire:model.blur="itemsSelected.{{ $index }}.qty">
                        </td>
                        <td style="vertical-align: middle">{{ $row['uom'] }}</td>
                        <td style="vertical-align: middle">{{ $row['type'] }}</td>
                        <td style="vertical-align: middle">Rp{{ $row['price'] }}</td>
                        <td><input type="text" placeholder="Rp0"
                                wire:model.blur="itemsSelected.{{ $index }}.discount"
                                x-on:focus="
                                if (!$event.target.value.includes('Rp')) {
                                    $event.target.value = 'Rp' + $event.target.value;
                                }">
                        </td>
                        {{-- <input type="text" placeholder="Rp0" wire:model.lazy="discount" x-on:blur="$wire.discount = 'Rp' + $event.target.value"> --}}
                        <td style="vertical-align: middle">Rp{{ $row['total'] }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger"
                                wire:click="remove({{ $row['temp_id'] }})">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </td>
                    </tr>


                @empty
                    <tr>
                        <td colspan="9" align="center">Tidak ada data</td>
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
