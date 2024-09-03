<x-slot:title>
    Daftar Laborate
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laborate</li>
    </x-slot:breadcrumbs>

    {{-- @if (auth()->user()->role_id !== 2) --}}
    <x-slot:button>
        <button class="btn btn-primary" wire:click="$dispatch('openModal', {component:'laborate.create'})"><i
                class="fa-solid fa-plus" wire:loading.class="d-none"></i>
            <div class="spinner-border spinner-border-sm" wire:loading role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            Laborate
        </button>
    </x-slot:button>
    {{-- @endif --}}

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-start gap-2 align-items-center mb-3">
                <div class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Cari" wire:model.live="search"
                        aria-label="Nama" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tipe Lab</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laborates as $item)
                            <tr>
                                <td>{{ ($laborates->currentpage() - 1) * $laborates->perpage() + $loop->index + 1 }}
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->type }}</td>
                                <td>Rp{{ number_format($item->price, 0, '.', '.') }}</td>
                                <td>
                                    <button
                                        wire:click="$dispatch('openModal', {component:'laborate.edit', arguments:{id:'{{ $item->id }}'}})"
                                        class="btn btn-warning text-white me-2 btn-sm">
                                        <i class="fa-solid fa-pen" wire:loading.class="d-none"></i>
                                        <div class="spinner-border spinner-border-sm" wire:loading role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </button>
                                    <button class="btn btn-danger me-2 btn-sm"
                                        wire:click="$dispatch('openModal', {component:'laborate.delete', arguments:{id:'{{ $item->id }}'}})">
                                        <i class="fa-solid fa-trash" wire:loading.class="d-none"></i>
                                        <div class="spinner-border spinner-border-sm" wire:loading role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
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
            {{ $laborates->links() }}
        </div>
    </div>
</x-page-layout>
