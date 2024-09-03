<x-slot:title>
    Daftar Promo
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Promo</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <button class="btn btn-primary" x-on:click="Livewire.dispatch('openModal', {component:'promo.create'})"><i
                class="fa-solid fa-plus"></i>
Promo & Event</button>
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
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Cover</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($promos as $item)
                        <tr>
                            <td>{{ ($promos->currentpage() - 1) * $promos->perpage() + $loop->index + 1 }}
                            </td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                @if($item->cover)
                                <img src="{{ asset('storage/' . $item->cover) }}" width="50px">
                                @endif

                        </td>
                            <td>
                                <button class="btn btn-warning me-2 btn-sm" x-data="{ loading: false }" x-on:click="loading=true"
                                    x-on:loading-edit.window="(event)=>loading = event.detail.value"
                                    wire:click="$dispatch('openModal', {component:'promo.edit', arguments:{uuid:'{{ $item->uuid }}'}})">
                                    <i class="fa-solid fa-pen" x-show="!loading"></i>
                                    <i class="fa-solid fa-spinner tw-animate-spin" x-show="loading"></i>
                                </button>
                                <button class="btn btn-danger btn-sm"
                                    wire:click="$dispatch('openModal', {component:'promo.delete', arguments:{uuid:'{{ $item->uuid }}'}})">
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
            {{ $promos->links() }}
        </div>
    </div>
</x-page-layout>

@assets
<link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
<script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
@endassets
