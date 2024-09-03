<x-slot:title>
    Daftar Obat dan Alkes
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Obat dan Alkes</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <a href="{{ route('drug-and-med-dev.create') }}" class="btn btn-primary" wire:navigate><i
                class="fa-solid fa-plus"></i> Obat dan Alkes</a>
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
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Minimal Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($drugAndMedDevs as $item)
                            <tr>
                                <td>{{ ($drugAndMedDevs->currentpage() - 1) * $drugAndMedDevs->perpage() + $loop->index + 1 }}
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->category->name ?? '-' }}</td>
                                <td>{{ $item->uom }}</td>
                                <td>{{ $item->min_stock }}</td>
                                <td>Rp{{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($item->selling_price, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('drug-and-med-dev.edit', $item->uuid) }}" wire:navigate
                                        class="btn btn-warning me-2 btn-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm"
                                        wire:click="$dispatch('openModal', {component:'drug-and-med-dev.delete-modal', arguments:{uuid:'{{ $item->uuid }}'}})">
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
            {{ $drugAndMedDevs->links() }}
        </div>
    </div>
</x-page-layout>
