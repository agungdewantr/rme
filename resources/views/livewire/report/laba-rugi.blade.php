<x-slot:title>
    Laporan Dokter
</x-slot:title>


<x-report-layout :type="$type" :date="$date" :branch="$branch_id" :poli="$poli" :doctor="$doctor_id" :reporttypedrug="$report_type_drug" >
    <div class="card">
        <div class="card-body">
            <div class="d-flex gap-2 align-items-center mb-3">
                <div class="tw-max-w-[300px] input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-calendar-days"></i>
                    </span>
                    <input type="text" date-picker name="" id="date_laba_rugi" class="form-control">
                </div>
            </div>
            <p class="h5">Laporan Laba Rugi</p>
            <table class="table table-striped" style="width: 60%;">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="40%">Nama Akun</th>
                        <th width="15%">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td>Pendapatan</td>
                        <td>Rp. {{number_format(($income_action ?? 0), 0, '.', '.')}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Penjualan Obat</td>
                        <td>Rp. {{number_format(($income_drug ?? 0), 0, '.', '.')}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-end fw-bold">Total Pendapatan</td>
                        <td class="fw-bold">Rp. {{number_format(($income_action + $income_drug ?? 0), 0, '.', '.')}}</td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Pembelian Obat</td>
                        <td>Rp. {{number_format(($outcome_drug ?? 0), 0, '.', '.')}}</td>
                    </tr>
                    @foreach ($outcome as $item)
                        <tr>
                            <td>{{!isset(explode('-', $item->name)[1]) ? '-' : explode('-', $item->name)[0]}}</td>
                            <td>{{!isset(explode('-', $item->name)[1]) ? $item->name  : explode('-', $item->name)[1]}}</td>
                            <td>Rp. {{number_format(($item->total ?? 0), 0, '.', '.')}}</td>
                        </tr>
                    @endforeach
                    <td colspan="2" class="text-end fw-bold text-primary">Laba / Rugi</td>
                    <td class="fw-bold text-primary">Rp. {{number_format((($income_action + $income_drug) - ($outcome_drug+$outcome->sum('total')) ?? 0), 0, '.', '.')}}</td>
                </tbody>
            </table>
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
            },
            defaultDate : null
        })

        $('.select2').select2({
            theme: 'bootstrap-5',
        });
        $('#doctor_id').on('change', function(e) {
            var data = $('#doctor_id').select2("val");
            $wire.$set('doctor_id', data);
        });
    </script>
@endscript
