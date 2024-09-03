<div>
    <div class="d-flex justify-content-between">
        <h6 class="h6">Riwayat Vaksin</h6>

    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Vaksin</th>
                <th>Jenis/Merk Vaksin</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($oldVaccines as $ov)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ov->name }}</td>
                    <td>{{ $ov->brand }}</td>
                    <td>{{ $ov->date }}</td>
                    <td>
                    </td>
                </tr>
            @endforeach
            @foreach ($vaccines as $key => $v)
                <tr>
                    <td>{{ $loop->iteration + $oldVaccines->count() }}</td>
                    <td>{{ $v->where('field', 'name')->first()->value }}</td>
                    <td>{{ $v->where('field', 'brand')->first()->value }}</td>
                    <td>{{ $v->where('field', 'date')->first()->value }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $key }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            @if ($vaccines->count() == 0 && $oldVaccines->count() == 0)
                <tr>
                    <td colspan="5" align="center">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
    <button class="btn btn-sm btn-primary"
        wire:click="$dispatch('openModal', {component:'medical-record.vaccine-modal-create'})">Tambah</button>
</div>
