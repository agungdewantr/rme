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
                @php
                $i = 1;
            @endphp
                @foreach ($oldFamily as $of)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$of->name}}</td>
                    <td>{{$of->relationship}}</td>
                    <td>{{$of->disease_name}}</td>
                    <td></td>
                </tr>
                @endforeach
                @foreach ($familyIllness as $key => $f)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $f->where('field', 'name')->first()->value }}</td>
                        <td>{{ $f->where('field', 'relationship')->first()->value}}</td>
                        <td>{{ $f->where('field', 'disease_name')->first()->value}}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $key }})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                @if ($familyIllness->count() == 0 && $oldFamily->count() == 0)
                    <tr>
                        <td colspan="5" align="center">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <button wire:ignore class="btn btn-sm btn-primary"
        wire:click="$dispatch('openModal', {component:'first-entry.family-illness-modal-create', arguments:{patient_id:{{$patient_id}}}})">Tambah</button>
</div>
