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
            @php
                $i = 1;
            @endphp
            @foreach ($patient->illnessHistories ?? [] as $ih)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$ih->name}}</td>
                    <td>{{$ih->pivot->therapy}}</td>
                    <td></td>
                </tr>

            @endforeach
            @foreach ($illness as $key => $il)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $illness_histories->where('id',$il->where('field', 'illness_history_id')->first()->value)->first()->name }}</td>
                    <td>{{ $il->where('field', 'therapy')->first()->value}}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $key }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            @if ($illness->count() == 0 && !isset($patient->illnessHistories))
                <tr>
                    <td colspan="5" align="center">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
    </div>
    <button class="btn btn-sm btn-primary"
        wire:click="$dispatch('openModal', {component:'first-entry.illness-modal-create'})">Tambah</button>
</div>
