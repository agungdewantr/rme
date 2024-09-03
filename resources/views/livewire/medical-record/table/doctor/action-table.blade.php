<div class="col-md-4">
    <p class="h5">Tindakan</p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tindakan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($medicalRecord->actions as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->name }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $a->pivot->id }})">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center">Data tidak ada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <button class="btn btn-primary btn-sm"
        wire:click="$dispatch('openModal', {component:'medical-record.table.doctor.action-create', arguments:{medical_record_id:{{ $medicalRecord->id }}}})">Tambah</button>
</div>
