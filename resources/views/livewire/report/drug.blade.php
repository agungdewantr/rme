<x-report-layout :type="$type" :date="$date" :branch="$branch_id" :reporttypedrug="$report_type_drug" :poli="$poli"
    :doctor="$doctor_id" :estimatedarrival="$estimated_arrival" :iskumulatif="$is_kumulatif">
    <div class="card">
        <div class="card-body">
            <div class="flex-wrap gap-2 mb-3 d-flex align-items-center">
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
                @if ($type = 'Lap. Obat')
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
                    <div class="input-group" style="width:300px">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-filter"></i>
                        </span>
                        <select class="form-select @error('report_type_drug') is-invalid @enderror"
                            id="report_type_drug" name="report_type_drug" aria-label="Default select example"
                            wire:model.live="report_type_drug">
                            <option value="" selected>Pilih Jenis Laporan</option>
                            <option value="Bulanan">Bulanan</option>
                            <option value="Harian">Harian</option>
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
                    <select class="form-select @error('doctor_id') is-invalid @enderror"
                        aria-label="Default select example" wire:model.live="estimated_arrival">
                        <option value="" selected>Semua Kedatangan</option>
                        <option value="Poli Pagi">Poli Pagi</option>
                        <option value="Poli Sore">Poli Sore</option>
                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model.live='is_kumulatif'
                        id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Kumulatif
                    </label>
                </div>
            </div>
            <p class="h5">Laporan Penjualan Obat</p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Poli</th>
                            <th>Obat</th>
                            <th>Jenis Pembelian</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($table as $item)
                            <tr>
                                <td>{{ $item['tanggal'] }}
                                </td>
                                <td>{{ $item['poli'] ?? '-' }}</td>
                                <td>{{ $item['obat'] }} {{ $item['is_discount'] == 1 ? '(Disc)' : '' }}</td>
                                <td>{{ $item['is_langsung'] == 1 ? 'Obat Langsung' : 'Obat Resep' }}</td>
                                <td class="text-end">{{ $item['jumlah'] }}</td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp.</span>
                                        <span>{{ number_format($item['harga'] ?? 0, $item['is_discount'] == 1 ? 9 : 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp.</span>
                                        <span> {{ number_format($item['total'] ?? 0, 0, '.', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <td colspan="6" class="text-end fw-bold">Grand Total</td>
                        <td class="fw-bold">
                            <div class="d-flex justify-content-between">
                                <span>Rp.</span>
                                <span>{{ number_format($table->sum('total') ?? 0, 0, '.', '.') }}</span>
                            </div>
                        </td>
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
            // dateFormat: "Y-m",
            // plugins: [
            //     new monthSelectPlugin({
            //         shorthand: true, // Use shorthand notation like "Jan", "Feb", etc.
            //         dateFormat: "Y-m", // Format for displayed dates
            //         altFormat: "F Y" // Format for input value
            //     })
            // ],
            onClose: (selectedDates) => {
                $wire.$set('date', selectedDates)
            }
        })
    </script>
@endscript
