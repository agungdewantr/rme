<x-report-layout :type="$type" :date="$date" :branch="$branch_id" poli="" :doctor="$doctor_id" reporttypedrug=""
    :search="$search">
    <div class="card">
        <div class="card-body">
            <div class="d-flex gap-2 align-items-center mb-3">
                <div wire:ignore class="tw-max-w-[300px] input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-calendar-days"></i>
                    </span>
                    <input type="text" date-picker name="" id="" class="form-control">
                </div>
                @if ($type = 'Lap. per Pasien')
                    <div class="mb-3 mt-3">
                        <input type="text" class="form-control" id="search"
                            wire:model.live.debounce.500ms="search" placeholder="Cari">
                    </div>
                    <div class="mb-3 mt-3">
                        <select name="" class="form-select" id="" wire:model.live="doctor_id">
                            <option value="">Semua Dokter</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="mb-3 mt-3">
                    <select name="" class="form-select" id="" wire:model.live="branch_id">
                        <option value="">Semua Cabang</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <p class="h5">Laporan Pendapatan Per Pasien</p>
<!-- Blade Template with Bootstrap Grid -->
<div class="container">
    <div class="row">
        @foreach ($transactionsByDoctor as $doctorId => $data)
            @if($data['doctor_name'])
                <div class="col-md-4 col-sm-6 col-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <p class="card-text">{{$data['doctor_name']. ': '. $data['total_transactions']. ' Pasien'}}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Poli</th>
                            <th>Tindakan</th>
                            <th>Laborate</th>
                            <th>Obat</th>
                            <th>Disc (Rp)</th>
                            <th>Total</th>
                            <th>Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $t)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($t->date)->format('d-m-Y') }}</td>
                                <td>{{ ucwords(strtolower($t->patient->name)) }}</td>
                                <td>{{ $t->doctor?->name }}</td>
                                <td>{{ $t->poli->name }}</td>
                                <td>
                                    @foreach ($t->actions as $a)
                                        <p class="tw-m-0">{{ $a->name }}</p>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($t->laborates as $l)
                                        <p class="tw-m-0">{{ $l->name }}</p>
                                    @endforeach
                                <td>
                                    @foreach ($t->drugMedDevs as $d)
                                        <p class="tw-m-0">{{ $d->name }} - {{ $d->pivot->qty }}
                                            {{ $d->uom }}</p>
                                    @endforeach
                                </td>
                                <td>Rp{{ number_format($t->actions->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                                        $t->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                                        $t->laborates->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)), 0, '.', '.') }}
                                </td>
                                <td>Rp{{ number_format(
                                    $t->actions->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)) +
                                        $t->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->selling_price ?? 0)) +
                                        $t->laborates->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)),
                                    0,
                                    '.',
                                    '.',
                                ) }}
                                </td>
                                <td>Rp{{ number_format(
                                    ($t->actions->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)) +
                                        $t->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->selling_price ?? 0)) +
                                        $t->laborates->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0))) -
                                        ($t->actions->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                                        $t->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                                        $t->laborates->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0))),
                                    0,
                                    '.',
                                    '.',
                                ) }}
                                </td>
                            </tr>
                            @if ($loop->iteration == $transactions->count())
                                <tr>
                                    <td colspan="7" align="right">Grand Total</td>
                                    <td>Rp{{ number_format($transactions->reduce(fn($e, $f) => $e + ($f->actions->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                                    $f->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0))) + $f->laborates->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)))
                                    , 0, '.', '.') }}
                                    </td>
                                    <td>Rp{{ number_format($transactions->reduce(fn($e, $f) => $e + ($f->actions->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)) + $f->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->selling_price ?? 0)) + $f->laborates->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)))), 0, '.', '.') }}
                                    </td>
                                    <td>Rp{{ number_format(($transactions->reduce(fn($e, $f) => $e + ($f->actions->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)) + $f->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->selling_price ?? 0)) + $f->laborates->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0))))) -
                                    ($transactions->reduce(fn($e, $f) => $e + ($f->actions->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                                    $f->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0))) + $f->laborates->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)))), 0, '.', '.') }}
                                    </td>

                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="10" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                </table>
            </div>
        </div>
    </div>
</x-report-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
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
