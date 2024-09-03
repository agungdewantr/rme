<x-slot:title>
    {{ $type }}
</x-slot:title>


<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laporan</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <div class="dropdown">
            <button class="btn dropdown-toggle text-decoration-none" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Download"
                aria-expanded="false">
                <span class="text-success"><i class="fa-solid fa-download"></i></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" target="_blank"
                        href="{{ route('report.print', ['type' => $type, 'date' => $date, 'doctor' => $doctor, 'poli' => $poli, 'branch' => $branch,'estimatedarrival'=>$estimatedarrival, 'reporttypedrug' => $reporttypedrug,'iskumulatif' => $iskumulatif, 'isDownload' => true, 'search' => $search]) }}">Pdf</a>
                </li>
                <li><a class="dropdown-item" href="#" wire:click="export">Excel</a></li>
            </ul>
        </div>
        <a href="{{ route('report.print', ['type' => $type, 'date' => $date, 'doctor' => $doctor, 'poli' => $poli, 'branch' => $branch,'estimatedarrival'=>$estimatedarrival, 'reporttypedrug' => $reporttypedrug,'iskumulatif' => $iskumulatif, 'isDownload' => false, 'search' => $search]) }}"
            class="text-decoration-none" data-bs-toggle="tooltip"
            x-on:click="(e)=>{
                e.stopImmediatePropagation()
            }" data-bs-placement="bottom"
            target="_blank" data-bs-title="Cetak">
            <span class="text-warning"><i class="fa-solid fa-print fa-fw"></i></span>
        </a>
        <div class="dropdown">
            <button class="btn dropdown-toggle text-decoration-none" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
                <span class="text-primary"><i class="fa-solid fa-ellipsis-vertical"></i></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" wire:ignore>
                @if (request()->routeIs('report.clinic'))
                    <li><a class="dropdown-item" href="#" wire:click="report_type('Lap. Obat dan Tindakan')">Lap.
                            Obat dan
                            Tindakan</a></li>
                    <li><a class="dropdown-item" href="#" wire:click="report_type('Lap. per Tindakan')">Lap. per
                            Tindakan</a></li>
                    <li><a class="dropdown-item" href="#" wire:click="report_type('Lap. per Dokter')">Lap.
                            Dokter</a>
                    </li>
                    <li><a class="dropdown-item" href="#" wire:click="report_type('Lap. Obat')">Lap. Obat</a></li>
                @else
                    <li><button class="dropdown-item" wire:click="report_type('Lap. Pendapatan')">Lap.
                            Pendapatan</button>
                    </li>
                    <li><a href="#" wire:click="report_type('Lap. per Pasien')" class="dropdown-item">Lap.
                            Pendapatan Per Pasien</a>
                    </li>
                    @if (auth()->user()->id == 10 || auth()->user()->role_id == 1)
                        <li><a class="dropdown-item" href="#" wire:click="report_type('Lap. Laba Rugi')">Lap. Laba
                                Rugi</a></li>
                    @endif
                    <li><a class="dropdown-item" href="#" wire:click="report_type('Lap. Pengeluaran')">Lap.
                            Pengeluaran</a></li>
                @endif
            </ul>
        </div>
    </x-slot:button>

    {{ $slot }}

</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.min.css">
@endassets

@script
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        $('.select2').select2({
            theme: 'bootstrap-5',
        });
        $('#doctor_id').on('change', function(e) {
            var data = $('#doctor_id').select2("val");
            $wire.$set('doctor_id', data);
        });
    </script>
@endscript
