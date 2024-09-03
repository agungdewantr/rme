<x-slot:title>
    Dashboard
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item active">Home</li>
    </x-slot:breadcrumbs>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    type="button" role="tab" aria-controls="pills-home" aria-selected="true"><i
                    class="fa-solid fa-list"></i> Antrian
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                    type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><i
                    class="fa-solid fa-chart-line"></i> Dashboard
            </button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
             tabindex="0">

            <div
                class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 md:tw-grid-cols-3 lg:tw-grid-cols-4 xl:tw-grid-cols-5 tw-gap-5 mb-3">
                <div
                    class="tw-block tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow tw-hover:bg-gray-100 tw-dark:bg-gray-800 tw-dark:border-gray-700 tw-dark:hover:bg-gray-700">
                    <div class="tw-flex tw-items-center">
                        <div class="tw-flex-shrink-0">
                            <i class="fa-solid fa-person fa-3x"></i>
                        </div>
                        <div class="tw-flex tw-items-center tw-h-full tw-flex-1 tw-min-w-0 tw-ms-4">
                            <p class="tw-font-medium tw-text-xl tw-text-gray-900 tw-dark:text-white">
                                Pasien Baru
                            </p>
                        </div>
                        <div
                            class="tw-inline-flex tw-items-center tw-text-base tw-font-bold tw-text-gray-900 tw-dark:text-white">
                            <p class="h1">
                                {{ $registrations->pluck('user')->filter(function ($value) {
                                        return $value->patient->firstEntry->count() == 0 ||
                                            ($value->patient->firstEntry->count() == 1 &&
                                                str_contains($value->patient->firstEntry->sortByDesc('id')->first()?->time_stamp, date('Y-m-d')));
                                    })->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="tw-block tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow tw-hover:bg-gray-100 tw-dark:bg-gray-800 tw-dark:border-gray-700 tw-dark:hover:bg-gray-700">
                    <div class="tw-flex tw-items-center">
                        <div class="tw-flex-shrink-0">
                            <i class="fa-solid fa-user-group fa-3x"></i>
                        </div>
                        <div class="tw-flex tw-items-center tw-h-full tw-flex-1 tw-min-w-0 tw-ms-4">
                            <p class="tw-font-medium tw-text-xl tw-text-gray-900 tw-dark:text-white">
                                Pasien Lama
                            </p>
                        </div>
                        <div
                            class="tw-inline-flex tw-items-center tw-text-base tw-font-bold tw-text-gray-900 tw-dark:text-white">
                            <p class="h1">
                                {{ $registrations->pluck('user')->filter(function ($value) {
                                        return $value->patient->firstEntry->count() > 1 ||
                                            ($value->patient->firstEntry->count() == 1 &&
                                                !str_contains($value->patient->firstEntry->sortByDesc('id')->first()?->time_stamp, date('Y-m-d')));
                                    })->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="tw-block tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow tw-hover:bg-gray-100 tw-dark:bg-gray-800 tw-dark:border-gray-700 tw-dark:hover:bg-gray-700">
                    <div class="tw-flex tw-items-center">
                        <div class="tw-flex-shrink-0">
                            <i class="fa-solid fa-people-group fa-3x"></i>
                        </div>
                        <div class="tw-flex tw-items-center tw-h-full tw-flex-1 tw-min-w-0 tw-ms-4">
                            <p class="tw-font-medium tw-text-xl tw-text-gray-900 tw-dark:text-white">
                                Antrian
                            </p>
                        </div>
                        <div
                            class="tw-inline-flex tw-items-center tw-text-base tw-font-bold tw-text-gray-900 tw-dark:text-white">
                            <p class="h1">{{ $registrations->where('queue_number', '<>', null)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="tw-block tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow tw-hover:bg-gray-100 tw-dark:bg-gray-800 tw-dark:border-gray-700 tw-dark:hover:bg-gray-700">
                    <div class="tw-flex tw-items-center">
                        <div class="tw-flex-shrink-0">
                            <i class="fa-solid fa-user-pen fa-3x"></i>
                        </div>
                        <div class="tw-flex tw-items-center tw-h-full tw-flex-1 tw-min-w-0 tw-ms-4">
                            <p class="tw-font-medium tw-text-xl tw-text-gray-900 tw-dark:text-white">
                                Sudah Diperiksa
                            </p>
                        </div>
                        <div
                            class="tw-inline-flex tw-items-center tw-text-base tw-font-bold tw-text-gray-900 tw-dark:text-white">
                            <p class="h1">{{
                            auth()->user()->role_id == 2 ?
                            $registrations->where('medicalRecord', '<>', null)->whereIn('status',['Kasir','Selesai'])->count() :
                            $registrations->where('medicalRecord', '<>', null)->count()
                            }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="tw-block tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow tw-hover:bg-gray-100 tw-dark:bg-gray-800 tw-dark:border-gray-700 tw-dark:hover:bg-gray-700">
                    <div class="tw-flex tw-items-center">
                        <div class="tw-flex-shrink-0">
                            <i class="fa-solid fa-hospital-user fa-3x"></i>
                        </div>
                        <div class="tw-flex tw-items-center tw-h-full tw-flex-1 tw-min-w-0 tw-ms-4">
                            <p class="tw-font-medium tw-text-xl tw-text-gray-900 tw-dark:text-white">
                                Total Pasien
                            </p>
                        </div>
                        <div
                            class="tw-inline-flex tw-items-center tw-text-base tw-font-bold tw-text-gray-900 tw-dark:text-white">
                            <p class="h1">{{ $registrations->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row g-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body mt-4">
                            <div class="row g-4">
                                <div class="row">
                                    <div class="col-12 col-md-6 mt-2">
                                        <div class="input-group" style="width:100%;">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="Cari"
                                                   aria-label="search" aria-describedby="basic-addon1"
                                                   wire:model.live="search">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 text-md-end text-center">
                                        <button wire:click="resetQueue" class="btn btn-primary me-2 mt-2 mt-md-0">
                                            Reset Antrian
                                        </button>
                                        <a onclick="window.open('{{ route('queue') }}', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');"
                                           class="btn btn-primary me-2 mt-2 mt-md-0">
                                            Tampilkan Antrian
                                        </a>
                                        <a href="{{ route('patient.create') }}" wire:navigate
                                           class="btn btn-primary me-2 mt-2 mt-md-0">
                                            Pasien Baru
                                        </a>
                                        @if (auth()->user()->role_id != 2)
                                            <button
                                                wire:click="$dispatch('openModal', {component:'registration.create'})"
                                                class="btn btn-primary mt-2 mt-md-0">
                                                Daftar Booking
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="col-12 d-flex justify-content-between align-items-center">
                                    <div class="input-group" style="width:300px">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Cari" aria-label="Username" aria-describedby="basic-addon1" wire:model.live="search">
                                    </div>
                                    <div class="col-sm-auto col-md-auto col-lg-auto"> <!-- Tambahkan kelas responsif di sini -->
                                        <a href="{{ route('patient.create') }}" wire:navigate class="btn btn-primary me-2">
                                Pasien Baru
                                </a>
                            </div>
                            <div class="col-sm-auto col-md-auto col-lg-auto"> <!-- Tambahkan kelas responsif di sini -->
                                <button wire:click="$dispatch('openModal', {component:'registration.create'})" class="btn btn-primary me-2">
                                    Daftar Periksa
                                </button>
                            </div>
                        </div> --}}

                                <div class="tw-overflow-x-auto">
                                    <table class="tw-table-auto tw-min-w-full">
                                        <thead>
                                        <tr class="text-center">
                                            <th class="px-4 py-2 border">No</th>
                                            <th class="px-4 py-2 border">Nomor RM</th>
                                            <th class="px-4 py-2 border">Nama Pasien</th>
                                            <th class="px-4 py-2 border">Tanggal Lahir</th>
                                            <th class="px-4 py-2 border">Poli Tujuan</th>
                                            <th class="px-4 py-2 border">
                                                <select name="" wire:model.live="filter_branch"
                                                        class="form-select tw-min-w-fit" id="">
                                                    <option value="">Cabang</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}">{{ $branch->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            <th class="px-4 py-2 border">
                                                <select name="" wire:model.live="filter_estimasi"
                                                        class="form-select tw-min-w-fit" id="">
                                                    <option value="">Estimasi Kedatangan</option>
                                                    <option value="Poli Pagi">Poli Pagi</option>
                                                    <option value="Poli Sore">Poli Sore</option>
                                                </select>
                                            </th>
                                            <th class="px-4 py-2 border">No Handphone</th>
                                            <th class="px-4 py-2 border">
                                                <select name="" wire:model.live="filter_status"
                                                        class="form-select tw-min-w-fit" id="">
                                                    <option value="">Status</option>
                                                    <option value="Administrasi">Administrasi</option>
                                                    <option value="Pemeriksaan">Pemeriksaan</option>
                                                    <option value="Kasir">Kasir</option>
                                                    <option value="Selesai">Selesai</option>
                                                    <option value="Batal">Batal</option>
                                                </select>
                                            </th>
                                            <th class="px-4 py-2 border text-center">Antrian</th>
                                            <th class="px-4 py-2 border">Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($filtered_registrations as $item)
                                            <tr wire:click="$dispatch('openModal', {component:'registration.show', arguments:{uuid:'{{ $item->uuid }}'}})"
                                                class="transition duration-700 hover:tw-font-bold text-center {{ $item->status == 'Administrasi' ? 'tw-bg-[#F3E7FF] hover:tw-bg-[#E0D1FF]' : ($item->status == 'Pemeriksaan' ? 'tw-bg-[#D6E7FF] hover:tw-bg-[#B5D4FF]' : ($item->status == 'Kasir' ? 'tw-bg-[#FEFFDF] hover:tw-bg-[#d7fa78]' : ($item->status == 'Selesai' ? 'tw-bg-[#DDFFE4] hover:tw-bg-[#83eb9e]' : 'tw-bg-[#FFDDDD] hover:tw-bg-[#f79797]'))) }} tw-cursor-pointer">
                                                <td class="px-4 py-2 border">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="px-4 py-2 border">
                                                    {{ $item->user->patient->patient_number }}</td>
                                                <td class="px-4 py-2 text-start">
                                                    {{ isset($item->user->name) ? ucwords(strtolower($item->user->name)) : '-' }}
                                                    @php
                                                        $messages = [];
                                                        if (!$item->user->patient->husbands_name && $item->user->patient->status_pernikahan == 'Menikah') {
                                                            $messages[] = 'Lengkapi data suami pasien';
                                                        }
                                                        if (count($item->user->patient->firstEntry) == 0) {
                                                            $messages[] = 'Pasien belum memiliki data asesmen awal';
                                                        }
                                                        $infoMsg = implode('<br>', $messages);
                                                    @endphp
                                                    @if($infoMsg != '')
                                                        <sup class="text-danger tw-blink tw-text-xl custom-tooltip"
                                                             data-bs-toggle="tooltip" data-bs-placement="top"
                                                             data-bs-title="{!! $infoMsg !!}" data-bs-html="true"><i
                                                                class="fa-solid fa-circle-info"></i></sup>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2 border">{{ $item->user->patient->dob }}</td>
                                                <td class="px-4 py-2 border">{{ $item->poli }}
                                                    ({{ $item->checkup??'-' }})
                                                </td>
                                                <td class="px-4 py-2 border">{{ $item->branch->name }}</td>
                                                <td class="px-4 py-2 border">{{ @$item->estimated_arrival }}
                                                    ({{ $item->estimated_hour ?? '-' }})
                                                </td>
                                                <td class="px-4 py-2 border">
                                                    <a href="https://wa.me/{{ $item->user->patient->phone_number }}"
                                                       target="_blank">
                                                        {{ @$item->user->patient->phone_number }}
                                                    </a>
                                                </td>
                                                {{-- <td class="px-4 py-2 border"><span
                                                        class="
                                                {{ $item->finance_type == 'Asuransi' ? 'tw-bg-[#3D4FB2] tw-text-white tw-text-sm tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-blue-900 tw-dark:text-blue-300' : ($item->finance_type == 'BPJS' ? 'tw-bg-[#00891E] tw-text-white tw-text-sm tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-green-900 tw-dark:text-green-300' : 'tw-bg-pink-400 tw-text-pink-100 tw-text-sm tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-pink-900 tw-dark:text-pink-300') }}">{{ $item->finance_type }}</span> --}}
                                                {{--                                                </td>--}}
                                                <td> <span
                                                        class="{{ $item->status == 'Administrasi'
                                                                ? 'tw-bg-[#D6AEFF] tw-text-black tw-text-sm tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-blue-900 tw-dark:text-blue-300'
                                                                : ($item->status == 'Pemeriksaan'
                                                                    ? 'tw-bg-[#99D4FF] tw-text-black tw-text-sm tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-blue-900 tw-dark:text-blue-300'
                                                                    : ($item->status == 'Kasir'
                                                                        ? 'tw-bg-[#F7FC10] tw-text-black tw-text-sm tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-blue-900 tw-dark:text-blue-300'
                                                                        : ($item->status == 'Selesai'
                                                                            ? 'tw-bg-[#70FF8C] tw-text-black tw-text-sm tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-blue-900 tw-dark:text-blue-300'
                                                                            : 'tw-bg-[#FF5959] tw-text-black tw-text-sm tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-blue-900 tw-dark:text-blue-300'))) }}">
                                                            {{ $item->status }}</span></td>
                                                <td class="px-4 py-2 border">{{ $item->queue_number ?? '-' }}</td>
                                                <td class="px-4 py-2 border">
                                                    @if($item->status != 'Batal')
                                                        @if (!$item->queue_number && $item->status != 'Selesai')
                                                            <button wire:loading.attr="disabled"
                                                                    x-on:click="(e)=>{
                                                                    e.stopPropagation()
                                                                    $wire.assignQueue({{ $item->id }})
                                                                }">
                                                                <i class="fa-regular fa-square-plus"></i></button>
                                                        @endif
                                                        @if (auth()->user()->role_id != 2)
                                                            <a href="
                                                            @if (count($item->user->patient->firstEntry) == 0) {{ route('first-entry.create', $item->uuid) }}
                                                            @else
                                                            {{ route('first-entry.edit', $item->user->patient->firstEntry()->orderBy('id', 'desc')->first()->uuid) }} @endif
                                                            "
                                                               wire:navigate class="text-decoration-none"
                                                               data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                               x-on:click="(e)=>{
                                                                    e.stopImmediatePropagation()
                                                                }"
                                                               data-bs-title="Asesmen Awal">
                                                                <i class="fa-solid fa-stethoscope fa-fw"></i>
                                                            </a>
                                                        @endif
                                                        @if ($item->user->patient->firstEntry->count() != 0)
                                                            <a href="
                                                        @if ((auth()->user()->role_id == 5 || auth()->user()->role_id == 1) && $item->status == 'Administrasi') {{ route('medical-record.create', $item->uuid) }}
                                                        @elseif(
                                                            (auth()->user()->role_id == 5 || auth()->user()->role_id == 1) &&
                                                                $item->status != 'Administrasi' &&
                                                                $item?->medicalRecord?->count() > 0)
                                                        {{ route('medical-record.edit', $item->medicalRecord->uuid) }}
                                                        @elseif(auth()->user()->role_id == 2 && $item->status == 'Pemeriksaan' && $item->medicalRecord)
                                                        {{-- @elseif((auth()->user()->role_id == 2 || auth()->user()->role_id == 1) && ) --}}
                                                        {{ route('medical-record.edit', $item->medicalRecord->uuid) }}
                                                        @elseif(
                                                            (auth()->user()->role_id == 2 || auth()->user()->role_id == 1) &&
                                                                ($item->status == 'Kasir' || $item->status == 'Selesai') &&
                                                                $item->medicalRecord->count() > 0)
                                                        {{ route('medical-record.edit', $item->medicalRecord->uuid) }} @endif
                                                        "
                                                               wire:navigate class="text-decoration-none"
                                                               data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                               x-on:click="(e)=>{
                                                            e.stopImmediatePropagation()
                                                        }"
                                                               data-bs-title="{{ auth()->user()->role_id == 2 && $item->status == 'Administrasi' ? 'Belum ada CPPT Perawat' : 'CPPT' }}">
                                                                <i class="fa-solid fa-clipboard fa-fw"></i>
                                                            </a>
                                                        @endif
                                                        @if ($item->status == 'Administrasi' && auth()->user()->role_id != 2)
                                                            <button
                                                                x-on:click="(e)=>{
                                                        e.stopImmediatePropagation()
                                                        $wire.cancelQueue({{ $item->id }})
                                                    }"
                                                                class="text-decoration-none" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" data-bs-title="Batal">
                                                                <i class="fa-solid fa-xmark fa-fw text-danger"></i>
                                                            </button>
                                                        @endif
                                                        @if ($item->status == 'Selesai')
                                                            <a href="{{ route('payment.invoice', $item->medicalRecord->transaction->uuid) }}"
                                                               class="text-decoration-none" data-bs-toggle="tooltip"
                                                               x-on:click="(e)=>{
                                                                    e.stopImmediatePropagation()
                                                                }"
                                                               data-bs-placement="bottom" target="_blank"
                                                               data-bs-title="Cetak">
                                                                <i class="fa-solid fa-print fa-fw"></i>
                                                            </a>
                                                            {{-- <button wire:click="$dispatch('openModal', {component:'payment.invoice', arguments:{uuid:'{{$item->medicalRecord->transaction->uuid}}'}})" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Cetak">
                                            <i class="fa-solid fa-print fa-fw text-secondary"></i>
                                            </button> --}}
                                                        @endif
                                                        @if ($item->status == 'Kasir' && auth()->user()->role->id != 2)
                                                            <a wire:navigate
                                                               href="{{ route('payment.create', $item->medicalRecord->uuid ?? null) }}"
                                                               class="text-decoration-none" data-bs-toggle="tooltip"
                                                               x-on:click="(e)=>{
                                                                    e.stopImmediatePropagation()
                                                                }"
                                                               data-bs-placement="bottom" data-bs-title="Bayar">
                                                                <i class="fa-solid fa-wallet fa-fw text-warning"></i>
                                                            </a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" align="center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
             tabindex="0">...
        </div>
    </div>
    <div
        class="tw-fixed tw-top-0 tw-z-50 tw-right-0 tw-translate-y-24 tw-translate-x-14 hover:tw-translate-x-0 tw-transition-all tw-duration-100 tw-pr-2"
        x-data="queue">
        <div class="tw-flex tw-flex-col tw-gap-2 tw-p-2 tw-rounded tw-border tw-border-black tw-bg-white">
            <button class="btn" x-on:click="next">
                <i class="fa-solid fa-circle-chevron-right"></i>
            </button>
            <button class="btn" x-on:click="speak">
                <i class="fa-solid fa-volume-high"></i>
            </button>
            <button class="btn" x-on:click="reset">
                <i class="fa-solid fa-rotate-right"></i>
            </button>
        </div>
    </div>
</x-page-layout>

@assets
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
<style>
    @keyframes tw-blink {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0;
        }
    }

    .tw-blink {
        animation: tw-blink 1s infinite;
    }

    .tw-blink:hover {
        animation: none;
    }

    /* Mengubah warna background dan teks tooltip */
    .tooltip-inner {
        background-color: #dede06 !important; /* Warna latar belakang tooltip */
        color: rgb(37, 35, 34) !important; /* Warna teks tooltip */
    }

    /* Mengubah warna border tooltip */
    .tooltip-arrow::before {
        border-top-color: #dede06 !important; /* Warna border tooltip bagian atas */
        border-bottom-color: #dede06 !important; /* Warna border tooltip bagian bawah */
    }
</style>

@endassets

@script
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    Alpine.data('queue', () => ({
        queue_number: 0,
        init() {
            let queue = window.localStorage.getItem('queue')
            if (queue) {
                this.queue_number = queue
            }
        },
        next() {
            this.queue_number++
            window.localStorage.setItem('queue', this.queue_number)
        },
        reset() {
            this.queue_number = 0
            window.localStorage.setItem('queue', this.queue_number)
        },
        speak() {
            let speak = window.localStorage.getItem('speak')
            if (speak == 'true') {
                window.localStorage.setItem('speak', false)
            } else {
                window.localStorage.setItem('speak', true)
            }
        }
    }))
</script>
@endscript
