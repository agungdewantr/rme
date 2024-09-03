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
                @if ($type = 'Lap. Obat dan Tindakan')
                    <div class="input-group" style="width:300px">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-filter"></i>
                        </span>
                        <select class="form-select @error('poli') is-invalid @enderror" id="poli" name="poli"
                            aria-label="Default select example" wire:model.live="poli">
                            <option value="" selected>Pilih Poli</option>
                            <option value="Poli Kandungan">Poli Kandungan</option>
                            <option value="Poli Anak">Poli Anak</option>
                        </select>
                    </div>
                @endif
                <div>
                    <select name="" class="form-select" id="" wire:model.live="branch_id">
                        <option value="">Semua Cabang</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="" class="form-select" id="" wire:model.live="estimated_arrival">
                        <option value="">Semua Kedatangan</option>
                        <option value="Poli Pagi">Poli Pagi</option>
                        <option value="Poli Sore">Poli Sore</option>
                    </select>
                </div>
            </div>
            <p class="h5">Laporan Obat dan Tindakan</p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Poli</th>
                            <th>Tindakan/Obat</th>
                            <th>Jumlah</th>
                            <th>Harga (Rp)</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($table as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['date'] }}</td>
                                <td>{{ $item['poli'] }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>Rp. {{ number_format($item['price'], 0, '.', '.') }}</td>
                                <td>Rp. {{ number_format($item['total'], 0, '.', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6" class="text-end fw-bold">Grand Total</td>
                            <td class="fw-bold">Rp. {{ number_format($total_price ?? 0, 0, '.', '.') }}</td>
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
    </script>
@endscript
