<x-slot:title>
    Daftar Cabang
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cabang</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <a href="{{ route('branch.create') }}" class="btn btn-primary" wire:navigate><i
            class="fa-solid fa-plus"></i>
        Cabang</a>
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
                        <th>Nama Cabang</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($branches as $item)
                        <tr>
                            <td>{{ ($branches->currentpage() - 1) * $branches->perpage() + $loop->index + 1 }}
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->is_active ? 'Aktif' : 'Tidak Aktif'}}</td>
                            <td>
                                <a class="btn btn-warning me-2 btn-sm"
                                    href="{{ route('branch.edit', $item->uuid) }}" wire:navigate>
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <button class="btn btn-danger btn-sm"
                                    wire:click="$dispatch('openModal', {component:'branch.delete', arguments:{uuid:'{{ $item->uuid }}'}})">
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
            {{ $branches->links() }}
        </div>
    </div>
</x-page-layout>
