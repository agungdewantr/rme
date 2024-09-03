<x-slot:title>
    Daftar Poli
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Poli</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <button class="btn btn-primary" x-on:click="Livewire.dispatch('openModal', {component:'poli.create'})"><i
                class="fa-solid fa-plus"></i>
            Poli</button>
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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Poli</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($polis as $item)
                        <tr>
                            <td>{{ ($polis->currentpage() - 1) * $polis->perpage() + $loop->index + 1 }}
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{$item->is_active ? 'Aktif' : 'Non Aktif'}}</td>
                            <td>
                                <button class="btn btn-warning me-2 btn-sm"
                                    wire:click="$dispatch('openModal', {component:'poli.edit', arguments:{uuid:'{{ $item->uuid }}'}})">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-danger btn-sm"
                                    wire:click="$dispatch('openModal', {component:'poli.delete', arguments:{uuid:'{{ $item->uuid }}'}})">
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
            {{ $polis->links() }}
        </div>
    </div>
</x-page-layout>
