<x-slot:title>
    Laporan Dokter
</x-slot:title>


<x-report-layout :type="$type" :date="$date" :branch="$branch_id" :poli="$poli" :doctor="$doctor_id"
                 :reporttypedrug="$report_type_drug" :iskumulatif="$is_kumulatif">

    <div class="card">
        <div class="card-body">
            <div class="gap-2 mb-3 d-flex align-items-center">
                {{-- <div class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Cari" wire:model.live="search" aria-label="Username" aria-describedby="basic-addon1">
                </div> --}}
                <div wire:ignore class="tw-max-w-[300px] input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-calendar-days"></i>
                    </span>
                    <input type="text" date-picker name="" id="" class="form-control">
                </div>
                @if ($type = 'Lap. per Dokter')
                    <div class="input-group" style="width:300px">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-filter"></i>
                        </span>
                        <select class="form-select select2 @error('doctor_id') is-invalid @enderror" id="doctor_id"
                                name="doctor_id" aria-label="Default select example" wire:model.live="doctor_id">
                            <option value="" selected>Pilih Dokter</option>
                            @foreach ($doctors as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select class="form-select select2 @error('doctor_id') is-invalid @enderror" id="doctor_id"
                                name="doctor_id" aria-label="Default select example"
                                wire:model.live="estimated_arrival">
                            <option value="" selected>Semua Kedatangan</option>
                            <option value="Poli Pagi">Poli Pagi</option>
                            <option value="Poli Sore">Poli Sore</option>
                        </select>
                    </div>
                    <div>
                        <select name="" class="form-select" id="" wire:model.live="branch_id">
                            <option value="">Semua Cabang</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live='is_kumulatif'
                            id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Kumulatif
                        </label>
                    </div>
                @endif
            </div>
            <p class="h5">Laporan Jasa Medis Dokter (Laporan Harian)</p>
            @if ($date)
                Tanggal :
                {{ Carbon\Carbon::parse($date[0])->format('d-m-Y') . ' - ' . Carbon\Carbon::parse($date[1])->format('d-m-Y') }}
                <br>
            @endif
            @if ($doctor)
                <span class="tw-font-bold"> {{ $doctor->healthWorker->name }}</span> <br>
                {{ 'No. SIP ' . $doctor->healthWorker->practice_license ?? '-' }}
            @endif
            @foreach ($branchTransactions as $branchName => $transactions)
            @php
                $total = 0;
            @endphp
            @if($transactions != [])
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Dokter</th>
                        <th>Cabang</th>
                        <th>Poli</th>
                        <th>Tindakan</th>
                        <th>Harga (Rp)</th>
                        <th>Jumlah</th>
                        <th>Total</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $item)
                    <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $item['date'] }}</td>
                            <td>{{$item['doctor']}}</td>
                            <td>{{ $item['branch'] }}</td>
                            <td>{{ $item['poli'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>Rp.
                                {{ number_format($item['price'], 0, '.', '.') }}
                            </td>
                            <td>{{ $item['qty'] }}</td>
                            <td>Rp.
                                {{ number_format($item['total'], 0, '.', '.') }}
                            </td>
                        </tr>
                    @endforeach
                    <td colspan="8" class="text-end fw-bold">Grand Total</td>
                    <td class="fw-bold">
                        <div class="d-flex justify-content-between">
                            <span>Rp.</span>
                            <span>{{ number_format(collect($transactions)->sum('total') ?? 0, 0, '.', '.')  }}</span>
                        </div>
                    </td>
                </tbody>
            </table>
            @endif
            @endforeach

        </div>
    </div>
</x-report-layout>

@assets
<link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
<script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
@endassets

@script
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    flatpickr($wire.$el.querySelector('[date-picker]'), {
        mode: 'range',
        onClose: (selectedDates) => {
            $wire.$set('date', selectedDates)
        }
    })

    $('.select2').select2({
        theme: 'bootstrap-5',
    });
    $('#doctor_id').on('change', function (e) {
        var data = $('#doctor_id').select2("val");
        $wire.$set('doctor_id', data);
    });
</script>
@endscript
