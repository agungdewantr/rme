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
                        href="{{ route('report.print', ['type' => $type, 'date' => $date, 'branch' => $branch, 'item_id' => $item, 'isDownload' => true, 'batch' => $batch]) }}">Pdf</a>
                </li>
                <li><a class="dropdown-item" href="#" wire:click="export">Excel</a></li>
            </ul>
        </div>
        <a href="{{ route('report.print', ['type' => $type, 'date' => $date, 'branch' => $branch, 'item_id' => $item, 'isDownload' => false, 'batch' => $batch]) }}"
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
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a wire:navigate href="{{ route('stock.balance') }}" class="dropdown-item">Lap. Stock Balance</a>
                </li>
                <li><a wire:navigate class="dropdown-item" href="{{ route('stock.ledger') }}">Lap. Stock Ledger</a></li>
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
@endassets

@script
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        flatpickr($wire.$el.querySelector('[date-picker]'), {
            "locale": "id",
            mode: 'range',
            onClose: (selectedDates, dateStr) => {
                console.log(selectedDates, dateStr);
                if (selectedDates.length > 1) {
                    $wire.$set('date', selectedDates)
                }
            },
            defaultDate: ['{{ date('Y-m-01') }}', '{{ date('Y-m-t') }}']
        })
    </script>
@endscript
