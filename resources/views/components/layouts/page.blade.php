<div x-data="{ open: false }">
    <div class="overflow-x-hidden overflow-y-auto tw-px-2 tw-py-3 border-end tw-fixed tw-h-screen tw-bg-white"
        x-bind:style="open ? { width: '230px' } : { width: '64px' }" x-on:mouseenter="open = true"
        x-on:mouseleave="()=>{
            open = false
            $('#collapseExample').collapse('hide')
            $('#settings').collapse('hide')
            $('#reports').collapse('hide')
            $('#stock').collapse('hide')
        }"
        style="transition: all; transition-duration: 150ms">
        <a href="{{ route('dashboard') }}" wire:navigate>
            <div class="tw-w-[150px] mb-1 tw-pl-2" style="aspect-ratio:36/10">
                <img src="{{ asset('assets/img/logo_long.png') }}" alt="" class="mb-1 tw-object-cover">
            </div>
        </a>
        <a href="{{ route('dashboard') }}" wire:navigate wire:ignore
            class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('dashboard') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}">
            <i class="fa-solid fa-chart-pie fa-fw me-3 fa-xl"></i>Dashboard
        </a>
        @can('viewAny', App\Models\Registration::class)
            <a href="{{ route('registration.index') }}" wire:navigate wire:ignore
                class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('registration*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}">
                <i class="fa-solid fa-file-lines fa-fw me-3 fa-xl"></i>Booking
            </a>
        @endcan
        @can('viewAny', App\Models\Patient::class)
            <a href="{{ route('patient.index') }}" wire:navigate wire:ignore
                class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('patient*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}">
                <i class="fa-solid fa-users fa-fw me-3 fa-xl"></i>Data Pasien
            </a>
        @endcan
        <a href="{{ route('first-entry.index') }}" wire:navigate wire:ignore
            class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('first-entry*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}">
            <i class="fa-solid fa-stethoscope fa-fw me-3 fa-xl"></i>Asesmen Awal
        </a>
        @can('viewAny', App\Models\MedicalRecord::class)
            <a href="{{ route('medical-record.index') }}" wire:navigate wire:ignore
                class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('medical-record*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}">
                <i class="fa-solid fa-clipboard fa-fw me-3 fa-xl"></i>CPPT
            </a><br>
        @endcan
        @can('viewAny', App\Models\Transaction::class)
            <a href="{{ route('payment.index') }}"
                class="btn p-2 tw-block text-nowrap mb-1 {{ request()->routeIs('payment*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                wire:navigate wire:ignore>
                <i class="fa-solid fa-wallet fa-fw me-3 fa-xl"></i>Kasir
            </a>
        @endcan
        @can('viewAny', App\Models\Transaction::class)
            <a href="{{ route('outcome.index') }}"
                class="btn p-2 tw-block text-nowrap mb-1 {{ request()->routeIs('outcome*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                wire:navigate wire:ignore>
                <i class="fa-solid fa-money-bill-wave fa-fw me-3 fa-xl"></i>Pengeluaran
            </a>
        @endcan
        @can('report-read')
            <a class="btn p-2 text-nowrap mb-1" data-bs-toggle="collapse" href="#stock" role="button"
                aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-box-archive fa-fw me-3 fa-xl"></i>Stock
            </a>
            <div class="collapse ps-3" id="stock">
                <a href="{{ route('stock-entry.index') }}"
                    class="btn p-2 tw-block text-nowrap mb-1 {{ request()->routeIs('stock-entry.index') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-box-archive fa-fw me-3 fa-xl"></i>Stock Entry
                </a>
                <a href="{{ route('stock-transfer.index') }}"
                    class="btn p-2 tw-block text-nowrap mb-1 {{ request()->routeIs('stock-transfer.index') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-box-archive fa-fw me-3 fa-xl"></i>Stock Transfer
                </a>
            </div>
        @endcan
        @can('report-read')
            <a class="btn p-2 text-nowrap mb-1" data-bs-toggle="collapse" href="#reports" role="button"
                aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-file-invoice fa-fw me-3 fa-xl"></i>Laporan
            </a>
            <div class="collapse ps-3" id="reports">
                <a href="{{ route('report.clinic') }}"
                    class="btn p-2 tw-block text-nowrap mb-1 {{ request()->routeIs('report.clinic') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-file-invoice fa-fw me-3 fa-xl"></i>Laporan Klinik
                </a>
                <a href="{{ route('report.index') }}"
                    class="btn p-2 tw-block text-nowrap mb-1 {{ request()->routeIs('report.index') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-file-invoice fa-fw me-3 fa-xl"></i>Laporan Keuangan
                </a>
                <a href="{{ route('stock.balance') }}"
                    class="btn p-2 tw-block text-nowrap mb-1 {{ request()->routeIs('stock.balance') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-file-invoice fa-fw me-3 fa-xl"></i>Laporan Stock
                </a>
            </div>
        @endcan
        @can('viewAny', App\Models\Setting::class)
            <a class="btn p-2 text-nowrap mb-1" data-bs-toggle="collapse" href="#settings" role="button"
                aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-gears fa-fw me-3 fa-xl"></i>Settings
            </a>
            <div class="collapse ps-3" id="settings">
                <a href="{{ route('setting.index') }}"
                    class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('setting*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-gear fa-fw me-2 fa-xl"></i>General
                </a>
                <a href="{{ route('role.index') }}"
                    class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('role*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-shield-halved fa-fw me-2 fa-xl"></i>Role
                </a>
                <a href="{{ route('doctor-fee.index') }}"
                    class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('doctor-fee*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-money-bills fa-fw me-2 fa-xl"></i>Fee Dokter
                </a>
            </div>
        @endcan
        @if (Gate::allows('viewAny', App\Models\HealthWorker::class) ||
                Gate::allows('viewAny', App\Models\Action::class) ||
                Gate::allows('viewAny', App\Models\DrugMedDev::class))
            <a class="btn p-2 block text-nowrap mb-1" data-bs-toggle="collapse" href="#collapseExample" role="button"
                aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-regular fa-folder fa-fw me-3 fa-xl"></i>Master
            </a>
            <div class="collapse ps-3" id="collapseExample">
                <a href="{{ route('branch.index') }}"
                    class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('branch*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-regular fa-hospital fa-fw me-2 fa-xl"></i>Cabang
                </a><br>
                <a href="{{ route('poli.index') }}"
                    class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('poli*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-house-medical-circle-check fa-fw me-2 fa-xl"></i>Poli
                </a><br>
                @can('viewAny', App\Models\HealthWorker::class)
                    <a href="{{ route('health-worker.index') }}"
                        class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('health-worker*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                        wire:navigate wire:ignore>
                        <i class="fa-solid fa-user-doctor fa-fw me-2 fa-xl"></i>Tenaga Kesehatan
                    </a><br>
                @endcan
                @can('viewAny', App\Models\DrugMedDev::class)
                    <a href="{{ route('drug-and-med-dev.index') }}"
                        class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('drug-and-med-dev*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                        wire:navigate wire:ignore>
                        <i class="fa-solid fa-capsules fa-fw me-2 fa-xl"></i>Obat & Alkes
                    </a><br>
                @endcan
                @can('viewAny', App\Models\Action::class)
                    <a href="{{ route('action.index') }}"
                        class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('action*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                        wire:navigate wire:ignore>
                        <i class="fa-solid fa-pen-fancy fa-fw me-2 fa-xl"></i>Jenis Tindakan
                    </a><br>
                @endcan
                <a href="{{ route('laborate.index') }}"
                    class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('laborate*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-flask fa-fw me-2 fa-xl"></i>Laborate
                </a><br>
                <a href="{{ route('category-outcome.index') }}"
                    class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('category-outcome*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-layer-group fa-fw me-2 fa-xl"></i>Kategori Pengeluaran
                </a><br>
                <a href="{{ route('promo-event.index') }}"
                    class="btn p-2 block text-nowrap mb-1 {{ request()->routeIs('promo-event*') ? 'tw-bg-gradient-to-r tw-from-[#1B91FF] tw-to-[#68FFA1] w-100 text-start' : '' }}"
                    wire:navigate wire:ignore>
                    <i class="fa-solid fa-calendar-day fa-fw me-2 fa-xl"></i>Promo & Event
                </a><br>

            </div>
        @endif
    </div>
    <div x-bind:style="open ? 'padding-left: 230px' : 'padding-left: 64px'" class="tw-transition-all">
        <div
            class="w-100 p-3 border-bottom d-flex justify-content-end align-items-center gap-2 tw-bg-[#3182ce] tw-relative">
            <img src="{{ asset('assets/img/nav.png') }}" alt=""
                class="tw-object-cover tw-w-full tw-h-full tw-absolute tw-right-0">
            <div class="dropdown tw-bg-white tw-backdrop-blur-sm tw-bg-white/30 tw-rounded-lg tw-z-50">
                <button class="btn dropdown-toggle d-flex align-items-center" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-2">{{ auth()->user()->name }}</span>
                    <img src="https://picsum.photos/1920/1080"
                        style="width:32px; height:32px; object-fit: cover; object-position: center"
                        class="rounded-circle" alt="">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <button class="dropdown-item"
                            wire:click="$dispatch('openModal', {component:'profil.show'})">Ubah Profil</button>
                    </li>
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button class="dropdown-item" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="p-3 tw-sticky top-0 tw-z-10" x-data="clock">
            @if (isset($breadcrumbs))
                <div class="card mb-3">
                    <div
                        class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                {{ $breadcrumbs }}
                            </ol>
                        </nav>
                        <div class="d-flex align-items-center mt-2 mt-md-0">
                            <div class="me-2">
                                <h5 class="m-0">
                                    <span class="badge text-bg-secondary">
                                        <span>{{ auth()->user()->branch->name }}, </span>
                                        <span>{{ \Carbon\Carbon::now()->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY') }}</span>
                                        <span x-text="time"></span>
                                    </span>
                                </h5>
                            </div>
                            {{ $button ?? '' }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="px-3">
            {{ $slot }}
        </div>
    </div>
</div>

@script
    <script>
        Alpine.data('clock', () => ({
            init() {
                setInterval(() => {
                    this.time = new Date().toLocaleTimeString()
                }, 1000)
            },
            time: new Date().toLocaleTimeString(),
        }))
    </script>
@endscript
