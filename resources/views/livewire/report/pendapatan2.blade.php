<x-slot:title>
    Laporan Per Pendapatan
</x-slot:title>
<x-report-layout :type="$type" :date="$date" :branch="$branch_id" :poli="$poli" :doctor="$doctor_id"
    :reporttypedrug="$report_type_drug">
    <div class="card">
        <div class="card-body">
            <div class="d-flex gap-2 align-items-center mb-3">
                <div wire:ignore class="tw-max-w-[300px] input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-calendar-days"></i>
                    </span>
                    <input type="text" date-picker name="" id="" class="form-control">
                </div>
                @if ($type = 'Lap. Pendapatan')
                    <div class="input-group" style="width:300px">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-filter"></i>
                        </span>
                        <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id"
                            name="branch_id" aria-label="Default select example" wire:model.live="branch_id">
                            <option value="" selected>Semua Cabang</option>
                            @foreach ($branches as $b)
                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id"
                            name="branch_id" aria-label="Default select example" wire:model.live="estimated_arrival">
                            <option value="" selected>Semua Kedatangan</option>
                            <option value="Poli Pagi">Poli Pagi</option>
                            <option value="Poli Sore">Poli Sore</option>
                        </select>
                    </div>
                @endif
            </div>
            <p class="h5">Laporan Pendapatan</p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Cabang</th>
                            <th>Tindakan</th>
                            <th>Laborate</th>
                            <th>Obat</th>
                            {{-- <th>Obat Langsung</th> --}}
                            <th>Pembayaran Tunai</th>
                            <th>Pembayaran EDC</th>
                            <th>Pembayaran Transfer</th>
                            <th>Pembayaran QRIS</th>
                            {{-- <th>Uang Tunai Akumulatif</th> --}}
                            <th>Pendapatan Harian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grand_total = 0;
                            $sum_action = 0;
                            $sum_laborate = 0;
                            $sum_drug = 0;
                            $sum_cash = 0;
                            $sum_edc = 0;
                            $sum_transfer = 0;
                            $sum_harian = 0;
                            $sum_qris = 0;
                        @endphp
                        @foreach ($reports as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->branch }}</td>
                                <td>Rp. {{ number_format($item->total_action, 0, '.', '.') }}</td>
                                <td>Rp. {{ number_format($item->total_laborate, 0, '.', '.') }}</td>
                                <td>Rp. {{ number_format($item->total_drug, 0, '.', '.') }}</td>
                                {{-- <td>Rp. number_format($item->total_ds, 0, '.', '.') </td> --}}
                                <td>Rp. {{ number_format($item->total_cash, 0, '.', '.') }}</td>
                                <td>Rp. {{ number_format($item->total_edc, 0, '.', '.') }}</td>
                                <td>Rp. {{ number_format($item->total_transfer, 0, '.', '.') }}</td>
                                <td>Rp. {{ number_format($item->total_qris, 0, '.', '.') }}</td>
                                {{-- <td> {{ number_format($item->accumulativeCash, 0, '.', '.') }} --}}
                                </td>
                                <td>Rp.
                                    {{ number_format($item->total_cash + $item->total_edc + $item->total_transfer + $item->total_qris, 0, '.', '.') }}
                                </td>
                            </tr>
                            @php
                                $grand_total += $item->total_cash + $item->total_edc + $item->total_transfer + $item->total_qris;
                                $sum_action += $item->total_action;
                                $sum_laborate += $item->total_laborate;
                                $sum_drug += $item->total_drug;
                                $sum_cash += $item->total_cash;
                                $sum_edc += $item->total_edc;
                                $sum_harian += $item->total_cash - $item->total_outcome_cash;
                                $sum_transfer += $item->total_transfer;
                                $sum_qris += $item->total_qris;
                            @endphp
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Grand Total</td>
                            <td class="fw-bold">Rp. {{ number_format($sum_action ?? 0, 0, '.', '.') }}</td>
                            <td class="fw-bold">Rp. {{ number_format($sum_laborate ?? 0, 0, '.', '.') }}</td>
                            <td class="fw-bold">Rp. {{ number_format($sum_drug ?? 0, 0, '.', '.') }}</td>
                            <td class="fw-bold">Rp. {{ number_format($sum_cash ?? 0, 0, '.', '.') }}</td>
                            <td class="fw-bold">Rp. {{ number_format($sum_edc ?? 0, 0, '.', '.') }}</td>
                            <td class="fw-bold">Rp. {{ number_format($sum_transfer ?? 0, 0, '.', '.') }}</td>
                            <td class="fw-bold">Rp. {{ number_format($sum_qris ?? 0, 0, '.', '.') }}</td>
                            {{-- <td class="fw-bold">Rp.  {{ number_format($reports[0]->accumulativeCash ?? 0, 0, '.', '.') }}</td> --}}
                            <td class="fw-bold">Rp. {{ number_format($grand_total ?? 0, 0, '.', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
        $('#poli').on('change', function(e) {
            var data = $('#poli').select2("val");
            $wire.$set('poli', data);
        });
    </script>
@endscript
