<div>
    <div class="d-flex justify-content-between">
        <p class="h6">Hasil Lab</p>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Pemeriksaan</th>
                <th>Tanggal</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medicalRecord->checks as $oc)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $oc->type }}</td>
                    <td>{{ $oc->date }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $oc->file) }}" class="text-link" noreferer noopener
                            target="_blank">Lihat File</a>
                    </td>
                    <td>
                    </td>
                </tr>
            @endforeach
            @foreach ($checks as $key => $c)
                <tr>
                    <td>{{ $loop->iteration + count($medicalRecord->checks) }}</td>
                    <td>{{ $c->where('field', 'type')->first()->value }}</td>
                    <td>{{ $c->where('field', 'date')->first()->value }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $c->where('field', 'file')->first()->value) }}" class="text-link"
                            noreferer noopener target="_blank">Lihat File</a>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $key }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            @if (count($medicalRecord->checks) == 0 && $checks->count() == 0)
                <tr>
                    <td colspan="5" align="center">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
    <button class="btn btn-sm btn-primary"
        wire:click="$dispatch('openModal', {component:'medical-record.check-modal-create'})">Tambah</button>
</div>
