<div>
    <div class="row">
        <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Akun</th>
                    <th>Supplier</th>
                    <th>Referensi</th>
                    <th width="160">Keterangan</th>
                    <th>Nominal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailOutcomes as $key => $do)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$account->where('id', $do->where('field', 'account_id')->first()->value)->first()->name}}</td>
                    <td>{{$supplier->where('id', $do->where('field', 'supplier_id')->first()->value)->first()->name}}</td>
                    <td>{{$stockEntry->where('id', $do->where('field', 'stock_entry_id')->first()->value)->first()->stock_entry_number}}</td>
                    <td>{{$do->where('field', 'note')->first()->value}}</td>
                    <td>{{number_format($do->where('field', 'nominal')->first()->value,0,',','.')}}</td>
                    <td><button class="tw-text-red-800" wire:click="delete({{ $key }})"><i class="fa-regular fa-trash-can"></i></button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    {{-- <button type="button" wire:click="$dispatch('openModal', {component:'outcome.table.create.create-detail' })" class="btn btn-sm btn-primary mb-2">Add Item</button> --}}
</div>
