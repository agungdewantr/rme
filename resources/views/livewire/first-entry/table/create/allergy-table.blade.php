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
                @php
                $i = 1;
            @endphp
                @foreach ($patient->allergyHistories ?? [] as $ah)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $ah->name }}</td>
                    <td>{{$ah->pivot->indication}} </td>
                    <td>
                    </td>
                </tr>
                @endforeach
                @foreach ($allergy as $key => $a)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $allergy_histories->where('id',$a->where('field', 'allergy_history_id')->first()->value)->first()->name }}</td>
                        <td>{{ $a->where('field', 'indication')->first()->value }}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $key }})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                @if ($allergy->count()  == 0 && !isset($patient->allergyHistories))
                    <tr>
                        <td colspan="5" align="center">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <button class="btn btn-sm btn-primary"
        wire:click="$dispatch('openModal', {component:'first-entry.allergy-modal-create'})">Tambah</button>
</div>
