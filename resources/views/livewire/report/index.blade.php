<x-slot:title>
    Laporan Dokter
</x-slot:title>
<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laporan</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <div class="dropdown">
            <button class="btn dropdown-toggle text-decoration-none" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-title="Download" aria-expanded="false">
                <span class="text-success"><i class="fa-solid fa-download"></i></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">Pdf</a></li>
                <li><a class="dropdown-item" href="#">Excel</a></li>
            </ul>
        </div>
        <a href=""
            class="text-decoration-none" data-bs-toggle="tooltip"
            x-on:click="(e)=>{
                e.stopImmediatePropagation()
            }"
            data-bs-placement="bottom" target="_blank" wire:click="print" data-bs-title="Cetak">
            <span class="text-warning"><i class="fa-solid fa-print fa-fw"></i></span>
        </a>
        <div class="dropdown">
            <button class="btn dropdown-toggle text-decoration-none" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="text-primary"><i class="fa-solid fa-ellipsis-vertical"></i></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><button class="dropdown-item" wire:click="report_type('Lap. Pendapatan')">Lap. Pendapatan</button></li>
                <li><a class="dropdown-item" href="#" wire:click="report_type('Lap. per Tindakan')">Lap. per Tindakan</a></li>
                <li><a class="dropdown-item" href="#" wire:click="report_type('Lap. per Dokter')">Lap. per Dokter</a></li>
            </ul>
        </div>
    </x-slot:button>


    @if($type == 'Lap. per Tindakan')
    <livewire:report.per-tindakan2 />
    @endif

</x-page-layout>

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
        $('#doctor_id').on('change', function(e) {
            var data = $('#doctor_id').select2("val");
            $wire.$set('doctor_id', data);
        });
    </script>
@endscript
