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
            @foreach ($vaccines as $ov)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ov->name }}</td>
                    <td>{{ $ov->brand }}</td>
                    <td>{{ $ov->date }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $ov->id }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            @if ($vaccines->count() == 0)
                <tr>
                    <td colspan="5" align="center">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
    <button class="btn btn-sm btn-primary"
        wire:click="$dispatch('openModal', {component:'medical-record.vaccine-modal-create', arguments:{isEdit:true, user_id:{{ $user_id }}}})">Tambah</button>
</div>
