<x-slot:title>
    Laporan Per Pengeluaran
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
                <div class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-filter"></i>
                    </span>
                    <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id"
                        aria-label="Default select example" wire:model.live="branch_id">
                        <option value="" selected>Pilih Cabang</option>
                        @foreach ($branches as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <p class="h5">Laporan Pengeluaran</p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Cabang</th>
                            @php
                            foreach ($categoryOutcomes as $c){
                                echo '<th>'.$c->name.'</th>';
                                ${'total' . $c->id} = 0;
                            }
                            @endphp
                            <th>Total Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($outcome as $item)
                            @php
                                $total += $item->total_nominal;
                            @endphp
                            <tr>
                                <td>{{ Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                <td>{{ $item->branch_name }}</td>
                                @php
                                    foreach ($categoryOutcomes as $c) {
                                        $columnName = str_replace([' ', '&', '@', '#', '$', '%', '^', '*', '(', ')'], '_', strtolower($c->name)) . '_total';
                                        echo '<td>'.'Rp.'.number_format($item->$columnName,0,'.','.') .'</td>';
                                        ${'total' . $c->id} += $item->$columnName;
                                    }
                                @endphp
                                <td>Rp. {{number_format($item->total_nominal,0,'.','.')}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-end fw-bold">Grand Total</td>
                            @php
                            foreach ($categoryOutcomes as $c) {
                                echo '<td class="fw-bold">Rp.' . number_format(${'total' . $c->id} ?? 0, 0, '.', '.') . '</td>';
                            }
                            @endphp
                            <td class="fw-bold">Rp. {{ number_format($total, 0, '.', '.') }}<td>
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
            },
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
