<div>
    <div class="d-flex justify-content-between">
        <h6 class="h6">Riwayat Alergi</h6>

    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alergi</th>
                    <th>Tanda & Gejala</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($firstEntry->patient->allergyHistories as $a)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $a->name }}</td>
                        <td>{{$a->pivot->indication}}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $a->pivot->id }})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                @if ($firstEntry->patient->allergyHistories->count() == 0)
                    <tr>
                        <td colspan="5" align="center">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <button class="btn btn-sm btn-primary"
        wire:click="$dispatch('openModal', {component:'first-entry.allergy-modal-create',arguments:{isEdit:true, patient_id:{{ $firstEntry->patient->id }}}})">Tambah</button>
</div>
