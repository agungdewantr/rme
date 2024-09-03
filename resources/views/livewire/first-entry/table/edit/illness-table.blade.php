<div>
    <div class="d-flex justify-content-between">
        <h6 class="h6">Riwayat Penyakit Terdahulu</h6>

    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Penyakit Terdahulu</th>
                    <th>Terapi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($firstEntry->patient->illnessHistories as  $i)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $i->name }}</td>
                        <td>{{ $i->pivot->therapy}}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $i->pivot->id }})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                @if ($firstEntry->patient->illnessHistories->count() == 0)
                    <tr>
                        <td colspan="5" align="center">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <button class="btn btn-sm btn-primary"
        wire:click="$dispatch('openModal', {component:'first-entry.illness-modal-create', arguments:{isEdit:true, patient_id:{{ $firstEntry->patient->id }}}})">Tambah</button>
</div>
