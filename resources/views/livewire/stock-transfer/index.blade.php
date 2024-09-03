<x-slot:title>
    Daftar Stock Transfer
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Stock Transfer</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <a href="{{ route('stock-transfer.create') }}" wire:navigate class="btn btn-primary"><i class="fa-solid fa-plus"></i>
            Stock Transfer
        </a>
    </x-slot:button>

    <div class="card">
        <div class="card-body">
            <div class="gap-2 mb-3 d-flex justify-content-start align-items-center">
                <div class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Cari" wire:model.live="search"
                        aria-label="Nama" aria-describedby="basic-addon1">
                </div>
                <div class="">
                    <select name="" wire:model.live="filter_branch" class="form-select" id="">
                        <option value="">Semua Cabang</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Stock Transfer</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Total Item</th>
                            <th>Total Value</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stockTransfers as $item)
                            <tr>
                                <td>{{ ($stockTransfers->currentpage() - 1) * $stockTransfers->perpage() + $loop->index + 1 }}
                                </td>
                                <td>{{ $item->stock_transfer_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->items->count() }}</td>
                                <td>Rp{{ number_format($item->amount, 0, '.', '.') }}
                                </td>
                                <td>
                                    <a wire:navigate href="{{ route('stock-transfer.show', $item->uuid) }}"
                                        class="text-white btn btn-info me-2 btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    {{-- <button class="btn btn-danger btn-sm"
                                    wire:click="$dispatch('openModal', {component:'stock-transfer.delete', arguments:{uuid:'{{ $item->uuid }}'}})">
                                    <i class="fa-solid fa-trash"></i>
                                </button> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $stockTransfers->links() }}
        </div>
    </div>
</x-page-layout>
