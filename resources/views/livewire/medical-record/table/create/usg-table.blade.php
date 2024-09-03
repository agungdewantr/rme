<div>
    <div class="d-flex justify-content-between">
        <p class="h6">Hasil USG</p>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>ID USG</th>
                <th>Tanggal</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medicalRecord->usgs as $ou)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ou->usg_id }}</td>
                    <td>{{ $ou->date }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $ou->file) }}" class="text-link" noreferer noopener
                            target="_blank">Lihat File</a>
                    </td>
                    <td>
                    </td>
                </tr>
            @endforeach
            @foreach ($usgs as $key => $u)
                <tr>
                    <td>{{ $loop->iteration + count($medicalRecord->usgs) }}</td>
                    <td>{{ $u->where('field', 'usg_id')->first()->value }}</td>
                    <td>{{ $u->where('field', 'date')->first()->value }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $u->where('field', 'file')->first()->value) }}" class="text-link"
                            noreferer noopener target="_blank">Lihat File</a>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $key }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            @if (count($medicalRecord->usgs) == 0 && $usgs->count() == 0)
                <tr>
                    <td colspan="5" align="center">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
    <button class="btn btn-sm btn-primary"
        wire:click="$dispatch('openModal', {component:'medical-record.usg-modal-create'})">Tambah</button>
</div>
