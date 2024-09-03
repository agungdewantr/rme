<x-slot:title>
    Daftar Tindakan
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tindakan</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <button class="btn btn-primary" x-on:click="Livewire.dispatch('openModal', {component:'action.create'})"><i
                class="fa-solid fa-plus"></i>
            Tindakan</button>
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
                        <th>Nama Tindakan</th>
                        <th>Kategori</th>
                        <th>Tarif Tindakan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($actions as $item)
                        <tr>
                            <td>{{ ($actions->currentpage() - 1) * $actions->perpage() + $loop->index + 1 }}
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>
                                <button class="btn btn-warning me-2 btn-sm"
                                    wire:click="$dispatch('openModal', {component:'action.edit', arguments:{uuid:'{{ $item->uuid }}'}})">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-danger btn-sm"
                                    wire:click="$dispatch('openModal', {component:'action.delete', arguments:{uuid:'{{ $item->uuid }}'}})">
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
            {{ $actions->links() }}
        </div>
    </div>
</x-page-layout>
