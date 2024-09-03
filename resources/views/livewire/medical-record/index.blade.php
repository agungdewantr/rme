<x-slot:title>
    Daftar Rekam Medis
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">CPPT</li>
    </x-slot:breadcrumbs>

    @if (auth()->user()->role_id !== 2)
    <x-slot:button>
        <a href="{{ route('medical-record.create') }}" class="btn btn-primary" wire:navigate><i
                class="fa-solid fa-plus"></i>
            CPPT</a>
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
                            {{-- <th>Poli Tujuan</th> --}}
                            <th>Usia Kehamilan</th>
                            <th>Perkiraan Persalinan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($medicalRecords as $item)
                            <tr>
                                <td>{{ ($medicalRecords->currentpage() - 1) * $medicalRecords->perpage() + $loop->index + 1 }}
                                </td>
                                <td>{{ $item->medical_record_number }}</td>
                                <td>{{ Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                <td>{{  ucwords(strtolower($item->user->patient->name)) ?? '-' }}</td>
                                <td>{{ isset($item->user->patient->dob) ? Carbon\Carbon::parse($item->user->patient->dob)->format('d-m-Y') : '-' }}
                                </td>
                                {{-- <td>{{ $item->registration->poli ?? '-' }}</td> --}}
                                <td>
                                    {{
                                        floor(
                                            \Carbon\Carbon::parse($item->date)
                                            ->diffInWeeks(\Carbon\Carbon::parse($item->firstEntry->hpht ?? null))
                                        )
                                    }}
                                    minggu
                                    {{
                                        \Carbon\Carbon::parse($item->date)
                                        ->diffInDays(\Carbon\Carbon::parse($item->firstEntry->hpht ?? null)) % 7
                                    }}
                                    hari
                                </td>

                                <td>{{ \Carbon\Carbon::parse($item->firstEntry->hpht ?? null)->addDays(280)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <a href="{{ route('medical-record.show', $item->uuid) }}" wire:navigate
                                        class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @if (\Carbon\Carbon::parse($item->created_at)->addDays(2)->gte(\Carbon\Carbon::now()))
                                        <a class="btn btn-warning me-2 btn-sm"
                                            href="{{ route('medical-record.edit', $item->uuid) }}" wire:navigate>
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $medicalRecords->links() }}
        </div>
    </div>
</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
@endassets

@script
    <script>
        flatpickr($wire.$el.querySelector('[date-picker]'), {
            mode: 'range',
            onClose: (selectedDates) => {
                $wire.$set('date', selectedDates)
            }
        })
    </script>
@endscript
