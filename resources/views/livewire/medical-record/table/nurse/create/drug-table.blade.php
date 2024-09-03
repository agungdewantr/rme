<div class="col-md-4">
    <p class="h5">Resep</p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Aturan Pakai</th>
                <th>Cara Pakai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($drugs as $key=>$d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->where('field', 'name')->first()->value }}</td>
                    <td>{{ $d->where('field', 'total')->first()->value }}</td>
                    <td>{{ $d->where('field', 'rule')->first()->value }}</td>
                    <td>{{ $d->where('field', 'how_to_use')->first()->value }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $key }})">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" align="center">Data tidak ada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <button class="btn btn-primary btn-sm"
        wire:click="$dispatch('openModal', {component:'medical-record.table.nurse.create.drug-create'})">Tambah</button>
</div>
