<x-slot:title>
    Daftar Pembayaran
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <a href="{{ route('payment.create') }}" wire:navigate class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            Pembayaran
        </a>
    </x-slot:button>

    <div class="card">
        <div class="card-body">
            <div class="d-flex gap-2 align-items-center mb-3">
                <div class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Cari" wire:model.live="search"
                        aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div wire:ignore class="tw-max-w-[300px] input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-calendar-days"></i>
                    </span>
                    <input type="text" date-picker name="" id="" class="form-control">
                </div>
                <div>
                    <select name="" wire:model.live="branch_id" class="form-select" id="">
                        <option value="">Semua cabang</option>
                        @foreach ($branches as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Nota</th>
                            <th>Tanggal</th>
                            <th>Nama Pasien</th>
                            <th>Grand Total</th>
                            <th style="width: 12%">
                                <select name="" wire:model.live="filter_status" class="form-select"
                                    id="">
                                    <option value="">Jenis Pembayaran</option>
                                    @foreach ($paymentMethods as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $item)
                            <tr>
                                <td>{{ ($payments->currentpage() - 1) * $payments->perpage() + $loop->index + 1 }}
                                </td>
                                <td>{{ $item->transaction_number }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ ucwords(strtolower($item->patient->name)) }}</td>
                                <td>Rp{{ number_format(
                                    $item->actions->reduce(
                                        fn($carry, $item) => $carry +
                                            (intval($item['pivot']['qty']) * floatval($item['price']) - floatval($item['pivot']['discount'])),
                                        0,
                                    ) +
                                        $item->drugMedDevs->reduce(
                                            fn($carry, $item) => $carry +
                                                (intval($item['pivot']['qty']) * floatval($item['selling_price']) -
                                                    floatval($item['pivot']['discount'])),
                                            0,
                                        ) +
                                        $item->laborates->reduce(
                                            fn($carry, $item) => $carry +
                                                (intval($item['pivot']['qty']) * floatval($item['pivot']['price']) -
                                                    floatval($item['pivot']['discount'])),
                                            0,
                                        ),
                                    0,
                                    '.',
                                    '.',
                                ) }}
                                </td>
                                <td>
                                    @php
                                        foreach ($item->paymentMethods as $p) {
                                            if ($p->pivot->amount > 0) {
                                                echo $p->name . '<br>';
                                            }
                                        }
                                    @endphp
                                </td>
                                <td>Selesai</td>
                                <td>
                                    <a href="{{ route('payment.show', $item->uuid) }}" wire:navigate
                                        class="btn btn-info btn-sm me-2">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @if (\Carbon\Carbon::parse($item->created_at)->addDay() > \Carbon\Carbon::now())
                                        <a href="{{ route('payment.edit', $item->uuid) }}" wire:navigate
                                            class="btn btn-warning btn-sm me-2">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endif
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
            <div class="d-flex justify-content-end">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
@endassets

@script
    <script>
        flatpickr($wire.$el.querySelector('[date-picker]'), {
            mode: 'range',
            onClose: (selectedDates) => {
                $wire.$set('date', selectedDates)
            }
        })
    </script>
@endscript
