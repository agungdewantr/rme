<div class="">
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
            @forelse ($medicalRecord->drugMedDevs as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->pivot->total }}</td>
                    <td>{{ $d->pivot->rule }}</td>
                    <td>{{ $d->pivot->how_to_use }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $d->pivot->id }})">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">Data tidak ada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <button class="btn btn-primary btn-sm"
        wire:click="$dispatch('openModal', {component:'medical-record.table.doctor.drug-create', arguments:{medical_record_id:{{ $medicalRecord->id }}}})">Tambah</button>
</div>
