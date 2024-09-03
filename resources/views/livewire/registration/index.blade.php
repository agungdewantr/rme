<x-slot:title>
    Daftar Pendaftaran
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Booking</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <button x-data="{ loading: false }" x-on:loading.window="(event)=>loading = event.detail.value" class="btn btn-primary"
            wire:click="$dispatch('openModal', {component:'registration.create'})" x-on:click="loading=true"
            :disabled="loading">
            <template x-if="loading">
                <i class="fa-solid fa-spinner tw-animate-spin"></i>
            </template>
            <template x-if="!loading">
                <i class="fa-solid fa-plus"></i>
            </template>
            Booking</button>
    </x-slot:button>

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
                <div class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-filter"></i>
                    </span>
                    <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id"
                        aria-label="Default select example" wire:model.live="branch_id">
                        <option value="" selected>Pilih Lokasi Klinik</option>
                        @foreach ($branches as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal Lahir</th>
                            <th>Poli Tujuan</th>
                            <th>Tujuan Pemeriksaan</th>
                            <th>Estimasi Jam Kedatangan</th>
                            <th>Tanggal Appointment</th>
                            <th>No Handphone</th>
                            <th>Poli</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($registrations as $item)
                            <tr>
                                <td>{{ ($registrations->currentpage() - 1) * $registrations->perpage() + $loop->index + 1 }}
                                </td>
                                <td>{{ @$item->user->patient->patient_number }}</td>
                                <td>{{ ucwords(strtolower(@$item->user->name)) }}</td>
                                <td> {{ isset($item->user->patient->dob) ? Carbon\Carbon::parse($item->user->patient->dob)->format('d-m-Y') : '-' }}
                                </td>
                                <td>{{ $item->poli }}</td>
                                <td>{{ $item->checkup ?? '-' }}</td>
                                {{-- <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td> --}}
                                <td>{{ $item->estimated_hour ?? '-' }}</td>
                                <td>{{ Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                <td>
                                    @if (isset($item->user->patient->phone_number))
                                        <a href="https://wa.me/{{ $item->user->patient->phone_number }}"
                                            target="_blank">
                                            {{ @$item->user->patient->phone_number }}
                                        </a>
                                    @else
                                        <p class="text-danger tw-text-sm">Tidak ada No handphone</p>
                                    @endif
                                </td>
                                <td>{{ $item->estimated_arrival }}</td>
                                <td>
                                    <button class="btn btn-warning me-2 btn-sm" x-data="{ loadingEdit: false }"
                                        x-on:click="loadingEdit=true"
                                        x-on:loading-edit.window="(event)=>loadingEdit = event.detail.value"
                                        wire:click="$dispatch('openModal', {component:'registration.edit', arguments:{uuid:'{{ $item->uuid }}'}})">
                                        <template x-if="loadingEdit">
                                            <i class="fa-solid fa-spinner tw-animate-spin"></i>
                                        </template>
                                        <template x-if="!loadingEdit">
                                            <i class="fa-solid fa-pen"></i>
                                        </template>
                                    </button>
                                    <button class="btn btn-danger btn-sm"
                                        wire:click="$dispatch('openModal', {component:'registration.delete', arguments:{uuid:'{{ $item->uuid }}'}})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $registrations->links() }}
        </div>
    </div>
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
        flatpickr($wire.$el.querySelector('[date-picker]'), {
            mode: 'range',
            onClose: (selectedDates) => {
                $wire.$set('date', selectedDates)
            }
        })
    </script>
@endscript
