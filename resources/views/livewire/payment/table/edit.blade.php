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
                @forelse ($rows as $key=>$item)
                    <livewire:payment.table.create-row :tmpId="$key" :iteration="$loop->iteration" :key="$key"
                        :type_row="$type" />

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
