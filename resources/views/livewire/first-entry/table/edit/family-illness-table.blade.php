<div>
    <div class="d-flex justify-content-between">
        <h6 class="h6">Riwayat Penyakit Keluarga</h6>

    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Hubungan</th>
                    <th>Nama Penyakit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($familyIllness as $f)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $f->name }}</td>
                        <td>{{ $f->relationship}}</td>
                        <td>{{ $f->disease_name}}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $f->id }})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                @if ($familyIllness->count() == 0)
                    <tr>
                        <td colspan="5" align="center">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <button class="btn btn-sm btn-primary"
        wire:click="$dispatch('openModal', {component:'first-entry.family-illness-modal-create', arguments:{isEdit:true, patient_id:{{ $patient_id }}}})">Tambah</button>
</div>
