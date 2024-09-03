<x-slot:title>
    Daftar Pengeluaran
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengeluaran</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <a href="{{ route('outcome.create') }}" class="btn btn-primary" wire:navigate><i
                class="fa-solid fa-plus"></i>
            Pengeluaran</a>
    </x-slot:button>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-start gap-2 align-items-center mb-3">
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
                            <th>ID Pengeluaran</th>
                            <th>Cabang</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Total Value</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($outcomes as $item)
                            <tr>
                               <td>{{$loop->iteration}}</td>
                               <td>{{$item->code}}</td>
                               <td>{{$item->branch->name ?? '-'}}</td>
                               <td>{{Carbon\Carbon::parse($item->date)->format('d-m-Y')}}</td>
                               <td>{{$item->category}}</td>
                               <td>{{$item->note ?? '-'}}</td>
                               <td>{{'Rp. ' . number_format($item->nominal,0,'.','.')}}</td>
                                <td>
                                    <a href="{{ route('outcome.show', $item->uuid) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" data-bs-title="Detail" wire:navigate
                                        class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" data-bs-title="Edit" href="{{ route('outcome.edit', $item->uuid) }}"
                                        wire:navigate>
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $outcomes->links() }}
        </div>
    </div>
</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
@endassets

