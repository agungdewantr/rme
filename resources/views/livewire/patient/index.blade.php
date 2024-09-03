<x-slot:title>
    Daftar Pasien
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pasien</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <a href="{{ route('patient.create') }}" class="btn btn-primary" wire:navigate><i class="fa-solid fa-plus"></i>
            Pasien</a>
    </x-slot:button>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-start align-items-center mb-3">
                <div></div>
                <div class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Cari" wire:model.live="search"
                        aria-label="search" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor RM</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Pekerjaan</th>
                            <th>No Handphone</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $item)
                            <tr>
                                <td>{{ ($patients->currentpage() - 1) * $patients->perpage() + $loop->index + 1 }}</td>
                                <td>{{ $item->patient_number }}</td>
                                <td>{{ ucwords(strtolower($item->name)) }}</td>
                                <td>{{ $item->dob }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ $item->job->name ?? '-' }}</td>
                                <td>
                                    <a href="https://wa.me/{{ $item->phone_number }}" target="_blank">
                                        {{ @$item->phone_number }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('patient.show', $item->uuid) }}" class="btn btn-info btn-sm me-2"
                                        wire:navigate>
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('patient.edit', $item->uuid) }}" wire:navigate
                                        class="btn btn-warning btn-sm me-2">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a class="btn btn-secondary btn-sm me-2" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" data-bs-title="Print"
                                        href="{{ route('patient.print', $item->uuid) }}" target="_blank">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm"
                                        wire:click="$dispatch('openModal', {component:'patient.delete-modal', arguments:{uuid:'{{ $item->uuid }}'}})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $patients->links() }}
        </div>
    </div>
</x-page-layout>
