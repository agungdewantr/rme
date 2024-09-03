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
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $ou->id }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            @if ($medicalRecord->usgs->count() == 0)
                <tr>
                    <td colspan="5" align="center">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
    <button class="btn btn-sm btn-primary"
        wire:click="$dispatch('openModal', {component:'medical-record.usg-modal-create', arguments:{isEdit:true, medical_record_id:{{ $medicalRecord->id }}}})">Tambah</button>
</div>
