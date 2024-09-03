<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="h6">Asuransi</p>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Asuransi</th>
                            <th>Nomor Asuransi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($insurances as $i)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $i->name }}</td>
                                <td>{{ $i->number }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        wire:click="destroy('{{ $i->uuid }}')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <td colspan="4" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <tr>
                    <button type="button" class="btn btn-sm btn-primary mb-2"
                    wire:click="$dispatch('openModal', {component:'patient.insurance-modal-edit', arguments:{uuid:'{{ $uuid }}'}})">Tambah</button>
                </tr>
            </div>
        </div>
    </div>
</div>
