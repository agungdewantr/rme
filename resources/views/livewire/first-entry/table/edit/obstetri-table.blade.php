<div class="card-body">
    <div class="d-flex justify-content-between align-items-center">
        <p class="h6">Status obstetri</p>

    </div>
    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No Kehamilan</th>
                <th>Jenis Persalinan</th>
                <th width="160">Jenis Kelamin</th>
                <th width="13%">BB Lahir</th>
                {{-- <th width="200">Tanggal Lahir Anak</th> --}}
                <th width="160">Usia Anak Sekarang</th>
                <th>Keterangan Tambahan/Komplikasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($obstetri as $o)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $o->type_of_birth }}</td>
                    <td>{{ is_null($o->gender) ? '-' : ($o->gender == 1 ? 'Laki-laki' : ($o->gender == 0 ? 'Perempuan' : ($o->gender == 2 ? 'Keguguran' : ($o->gender == 3 ? 'Hamil INI' :  ($o->gender == 5 ? 'IUFD' : '-')))))  }}</td>
                    <td>{{ $o->weight ?? 0 }} gr</td>
                    <td>{{ $o->birth_date }}</td>
                    <td>{{ $o->age  ?? 0  }} tahun
                    </td>
                    <td>{{ $o->clinical_information }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $o->id }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="9" align="center">Tidak ada data</td>
                </tr>
            @endforelse
            {{-- <livewire:first-entry.table.edit.obstetri-create-row  /> --}}
            <tr>
                <td class="fw-bold"><button type="button" class="btn btn-sm btn-primary mb-2"
                        wire:click="add">Tambah</button></td>
            </tr>
        </tbody>
    </table>
    </div>
</div>

@assets
    <style>
        table td {
            position: relative;
        }

        table td input,
        table td select {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            margin: 0;
            height: 100% !important;
            width: 100%;
            border-radius: 0 !important;
            border: none !important;
            padding: 5px;
            box-sizing: border-box;
        }
    </style>
@endassets
