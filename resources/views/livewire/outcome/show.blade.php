<x-slot:title>
    Detail Pengeluaran
</x-slot:title>

<x-page-layout>
    <div>
        <x-slot:breadcrumbs>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('outcome.index') }}" wire:navigate>Pengeluaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pengeluaran</li>
        </x-slot:breadcrumbs>

        <div class="card mb-3" x-data="outcome">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">ID Pengeluaran</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{$outcome->code}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Jenis Pembayaran</label>
                                    <input type="text" class="form-control" disabled value="{{$outcome->payment_method}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Tanggal</label>
                                    <div wire:ignore class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                        <input type="text" date-picker name="date" value="{{$outcome->date}}" id="date"
                                            class="form-control @error('date') is-invalid @enderror" disabled>
                                        @error('date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" disabled value="{{$outcome->category}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="branch_id" class="form-label">Cabang</label>
                                        <input type="text" class="form-control" disabled value="{{$outcome->branch->name ?? '-'}}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Supplier</label>
                                        <input type="text" class="form-control" disabled value="{{$outcome->supplier->name ?? '-'}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Akun</label>
                                        <input type="text" class="form-control" disabled value="{{$outcome->account->name ?? '-'}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Nominal</label>
                                        <input type="text" class="form-control" disabled value="{{number_format($outcome->nominal,0,',','.')}}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">Keterangan</label>
                                        <textarea name="note" id="note" class="form-control" disabled>{{$outcome->note}}</textarea>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div>
                    {{-- <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Referensi</th>
                                    <th>Item</th>
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($outcome->detailOutcome as $do)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$do->stockEntry->stock_entry_number}}</td>
                                    <td>
                                        @foreach ($do->stockEntry->items as $i)
                                            <p>{{$i->name}}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($do->stockEntry->items as $i)
                                            <p>{{$i->uom}}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($do->stockEntry->items as $i)
                                            <p>{{$i->pivot->qty}}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($do->stockEntry->items as $i)
                                            <p>{{$i->pivot->new_price}}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$do->stockEntry->items->reduce(function ($carry, $item) {
                                            return $carry + ($item->pivot->qty * $item->pivot->new_price);
                                        }, 0)}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        </div>

                    </div> --}}
                    {{-- <div class="tw-flex tw-justify-end"> --}}
                        {{-- <span class="tw-col-2 tw-bg-blue-100 tw-text-blue-800 tw-text-s tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-gray-700 tw-dark:text-blue-400 tw-border tw-border-blue-400">
                            Total Nominal : {{$outcome->detailOutcome ? 'Rp. ' . number_format($outcome->detailOutcome->sum('nominal'), 0, '.', '.') : 'Rp. 0' }}
                        </span>
                    </div> --}}

            </div>
            </div>

        </div>
        <section class="py-5">
            <ul class="timeline">
                @foreach ($logs as $log)
                    <li class="timeline-item mb-3">
                        <h5 class="efw-bold tw-text-xs">{{ $log->author }}</h5>
                        <p class="text-muted mb-2 fw-bold tw-text-xs">{{ $log->created_at->format('j F Y H:i:s') }}</p>
                        <p class="text-muted tw-text-xs">
                            {{ $log->log }}
                        </p>
                    </li>
                @endforeach
            </ul>
        </section>
</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>

    <style>
        .timeline {
            border-left: 1px solid black;
            position: relative;
            list-style: none;
        }

        .timeline .timeline-item {
            position: relative;
        }

        .timeline .timeline-item:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .timeline-item:after {
            background-color: black;
            left: -38px;
            border-radius: 50%;
            height: 11px;
            width: 11px;
            content: "";
        }
    </style>
@endassets
