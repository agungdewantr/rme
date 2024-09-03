<x-slot:title>
    Daftar Asesmen Awal
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Asesmen Awal</li>
    </x-slot:breadcrumbs>

    @if (auth()->user()->role_id !== 2)
        <x-slot:button>
            <a href="{{ route('first-entry.create') }}" class="btn btn-primary" wire:navigate><i
                    class="fa-solid fa-plus"></i>
                Asesmen Awal</a>
        </x-slot:button>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-start gap-2 align-items-center mb-3">
                <div wire:ignore class="tw-max-w-[300px] input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-calendar-days"></i>
                    </span>
                    <input type="text" date-picker name="" id="" class="form-control">
                </div>
                <div class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Cari" wire:model.live="search"
                        aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor RM</th>
                            <th>Tanggal</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal Lahir</th>
                            <th>HPHT</th>
                            <th>Usia Kehamilan</th>
                            <th>Perkiraan Persalinan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($firstEntry as $item)
                            <tr>
                                <td>{{ ($firstEntry->currentpage() - 1) * $firstEntry->perpage() + $loop->index + 1 }}
                                </td>
                                <td>{{ $item->patient->patient_number }}</td>
                                <td>{{ $item->time_stamp }}</td>
                                <td>{{ ucwords(strtolower($item->patient->name)) ?? '-' }}</td>
                                <td>{{ $item->patient->dob }}</td>
                                <td>{{ $item->hpht ? \Carbon\Carbon::parse($item->hpht)->format('d-m-Y') : '-' }}</td>
                                <td>{{ floor(\Carbon\Carbon::now()->diffInWeeks(\Carbon\Carbon::parse($item->hpht))) }}
                                    minggu
                                    {{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($item->hpht)) % 7 }} hari
                                </td>
                                <td>{{ $item->hpht? \Carbon\Carbon::parse($item->hpht)->addDays(280)->format('d-m-Y'): '-' }}
                                </td>
                                <td>
                                    @if (auth()->user()->role_id != 2)
                                        <a href="{{ $item->patient->registration->count() > 0 ? route('medical-record.create', $item->patient->registration->first()->uuid) : '#' }}"
                                            wire:navigate class="btn btn-sm !tw-bg-green-500" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom"
                                            data-bs-title="{{ $item->patient->registration->count() > 0 ? 'Buat CPPT' : 'Tidak memiliki data booking' }}">
                                            <i class="fa-solid fa-clipboard-check text-black"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('first-entry.show', $item->uuid) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" data-bs-title="Detail" wire:navigate
                                        class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @can('update', $item)
                                        <a class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" data-bs-title="Edit"
                                            href="{{ route('first-entry.edit', $item->uuid) }}" wire:navigate>
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    <a class="btn btn-secondary btn-sm me-2" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" data-bs-title="Print"
                                        href="{{ route('first-entry.print', $item->uuid) }}" target="_blank">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $firstEntry->links() }}
            </div>
        </div>
    </div>
</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
@endassets

@script
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        flatpickr($wire.$el.querySelector('[date-picker]'), {
            mode: 'range',
            // onClose: (selectedDates) => {
            //     $wire.$set('date', selectedDates)
            // }
            onClose: function(selectedDates, dateStr, instance) {
                $wire.$set('date', dateStr.split(' to ').map(date => new Date(date).toISOString()));
            },
        })
    </script>
@endscript
