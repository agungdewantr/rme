<x-slot:title>
    Daftar Tenaga Kesehatan
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tenaga Kesehatan</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <button class="btn btn-primary" x-on:click="Livewire.dispatch('openModal', {component:'health-worker.create'})"><i
                class="fa-solid fa-plus"></i>
            Tenaga
            Kesehatan</button>
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
                        aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Nakes</th>
                            <th>Posisi</th>
                            <th>Handphone</th>
                            <th>Email</th>
                            <th>Izin Praktek</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($healthWorkers as $item)
                            <tr>
                                <td>{{ ($healthWorkers->currentpage() - 1) * $healthWorkers->perpage() + $loop->index + 1 }}
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->position }}</td>
                                <td>{{ $item->phone_number }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->practice_license }}</td>
                                <td>{{ $item->status ? 'Aktif' : 'Non Aktif' }}</td>
                                <td>
                                    <button class="btn btn-warning me-2 btn-sm" x-data="{ loading: false }" x-on:click="loading=true"
                                        x-on:loading-edit.window="(event)=>loading = event.detail.value"
                                        wire:click="$dispatch('openModal', {component:'health-worker.edit', arguments:{uuid:'{{ $item->uuid }}'}})">
                                        <i class="fa-solid fa-pen" x-show="!loading"></i>
                                        <i class="fa-solid fa-spinner tw-animate-spin" x-show="loading"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm"
                                        wire:click="$dispatch('openModal', {component:'health-worker.delete', arguments:{uuid:'{{ $item->uuid }}'}})">
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
            {{ $healthWorkers->links() }}
        </div>
    </div>
</x-page-layout>
