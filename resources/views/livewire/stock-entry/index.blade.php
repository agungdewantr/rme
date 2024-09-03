<x-slot:title>
    Daftar Stock Entry
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Stock Entry</li>
    </x-slot:breadcrumbs>

    {{-- @if (auth()->user()->role_id !== 2) --}}
    <x-slot:button>
        <a href="{{ route('stock-entry.create') }}" wire:navigate class="btn btn-primary"><i
                class="fa-solid fa-plus"></i>
            Stock Entry
        </a>
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
                        <th>ID Stock Entry</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th style="width: 10%">
                            <select name="" wire:model.live="filter_status"
                                    class="form-select" id="" style="width:100%">
                                <option value="">Status</option>
                                <option value="Lunas">Lunas</option>
                                <option value="Dibayar Sebagian">Dibayar Sebagian</option>
                                <option value="Hutang">Hutang</option>


                            </select></th>
                        <th>Cabang</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($stockEntries as $item)
                        <tr>
                            <td>{{ ($stockEntries->currentpage() - 1) * $stockEntries->perpage() + $loop->index + 1 }}
                            </td>
                            <td>{{ $item->stock_entry_number }}</td>
                            <td>{{ $item->purpose }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                            <td>{{ $item->details_count }}</td>
                            <td>Rp{{ number_format($item->grand_total, 0, '.', '.') }}
                            </td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->name_branch }}</td>
                            <td>
                                <a wire:navigate href="{{ route('stock-entry.show', $item->uuid) }}"
                                   class="btn btn-info text-white me-2 btn-sm">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
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
            {{ $stockEntries->links() }}
        </div>
    </div>
</x-page-layout>
