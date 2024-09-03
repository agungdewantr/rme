<x-slot:title>
    Ubah Pembayaran
</x-slot:title>

<x-page-layout>
    <div x-data="editPayment">
        <x-slot:breadcrumbs>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('payment.index') }}" wire:navigate>Pembayaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah Pembayaran</li>
        </x-slot:breadcrumbs>
        @if ($notification)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ $notification }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- <div :key="rand()">
        @if ($notification)
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             x-on:livewire:load.window="$nextTick(() => show = true)"
             class="tw-z-50 tw-fixed tw-bottom-4 tw-right-4 tw-bg-red-500 tw-text-white tw-p-4 tw-rounded-lg tw-shadow-lg tw-transition-opacity tw-duration-100"
             x-transition:leave="tw-transition tw-ease-in tw-duration-300"
             x-transition:leave-start="tw-opacity-100"
             x-transition:leave-end="tw-opacity-0">
            <div class="tw-flex tw-items-center">
                <svg class="tw-w-6 tw-h-6 tw-mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20 10 10 0 010-20z"></path>
                </svg>
                <span>{{$notification}}</span>
            </div>
        </div>
        @endif
    </div> --}}

        <x-slot:button>
            <div class="d-flex">
                @if ($transaction_uuid)
                    <a href="{{ route('payment.invoice', $transaction_uuid) }}" target="_blank"
                        class="text-decoration-none btn btn-warning me-2" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-title="Cetak">
                        <i class="fa-solid fa-print fa-fw"></i>
                    </a>
                @endif
                <button class="btn btn-primary" id="savePayment" wire:click="save">Simpan</button>
            </div>
        </x-slot:button>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Nomor Invoice</label>
                            <input type="text" class="form-control" disabled placeholder="Otomatis dari sistem"
                                value="{{ $transaction->transaction_number }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <div wire:ignore class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </span>
                                <input type="text" name="date" readonly
                                    value="{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}"
                                    class="form-control @error('date') is-invalid @enderror">
                                @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" x-show="!purchase_drug">
                        <div class="d-flex justify-content-end" wire:ignore>
                            {{-- <button class="btn btn-primary"
                                wire:click="$dispatch('openModal', {component:'payment.modal.medical-history', arguments:{user_id:{{ $user_id ?? 0 }}}})">
                                Lihat Rekam Medis
                            </button> --}}
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Lihat Medical History
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Medical History</h1>
                                                <p class="m-0">Sudah {{ $medicalRecords->count() }} kali pemeriksaan
                                                </p>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="p-2">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Cabang<br>Tanggal<br>Dokter/Perawat</th>
                                                            <th>Rekam Medis</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($medicalRecords as $mr)
                                                            <tr>
                                                                <td>
                                                                    <p>Cabang : {{ $mr->registration->branch->name }}
                                                                    </p>
                                                                    <p>{{ \Carbon\Carbon::parse($mr->date)->format('d/m/Y') }}
                                                                    </p>
                                                                    <p>Dokter : {{ $mr->doctor?->name }}</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <p class="fw-bold">Subjective:</p><br>
                                                                            <p>{{ $mr->subjective_summary }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="fw-bold">Objective:</p><br>
                                                                            <p>{{ $mr->objective_summary }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="fw-bold">Asesmen:</p>
                                                                            <p>{{ $mr->assessment_summary ?? '-' }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p>
                                                                                <span
                                                                                    class="fw-bold">EDD:</span>{{ $mr->edd ? \Carbon\Carbon::parse($mr->edd)->format('d/m/Y') : '' }}
                                                                            </p>
                                                                            <p class="fw-bold">Hasil Lab
                                                                                Lainnya:</p>
                                                                            <p>{{ $mr->other_lab }}</p>
                                                                            <p class="fw-bold">Resep
                                                                                Luar:</p>
                                                                            <p>{{ $mr->other_recipe }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <p>Keterangan Tambahan/Laporan Hasil
                                                                                Tindakan:</p>
                                                                            <p>{{ $mr->other_summary ?? '-' }}</p>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="d-flex align-items-start">
                                                                                @foreach ($mr->usgs as $u)
                                                                                    <a href="{{ asset('storage/' . $u->file) }}"
                                                                                        class="btn btn-primary btn-sm"
                                                                                        noreferer noopener
                                                                                        target="_blank">Lihat File</a>
                                                                                @endforeach
                                                                                {{-- <p>Hasil USG:</p>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <p>FL:{{ $mr->fl }}</p>
                                                                                        <p>FHR:{{ $mr->fhr }}</p>
                                                                                        <p>EFW:{{ $mr->efw }}</p>
                                                                                        <p>AC:{{ $mr->ac }}</p>
                                                                                        <p>GA:{{ $mr->ga }}</p>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <p>GS:{{ $mr->gs }}</p>
                                                                                        <p>CRL:{{ $mr->crl }}</p>
                                                                                        <p>BPD:{{ $mr->bpd }}</p>

                                                                                    </div>
                                                                                </div> --}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div>
                                                                                        <span class="text-primary">Obat
                                                                                            :</span> <br>
                                                                                        @foreach ($mr->drugMedDevs as $a)
                                                                                            {{ '- ' . $a->name }} <br>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div>
                                                                                        <span
                                                                                            class="text-primary">Tindakan
                                                                                            :</span> <br>
                                                                                        @foreach ($mr->actions as $a)
                                                                                            {{ '- ' . $a->name }} <br>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div>
                                                                                        <span
                                                                                            class="text-primary">Laborate
                                                                                            :</span> <br>
                                                                                        @foreach ($mr->laborate as $a)
                                                                                            {{ '- ' . $a->name }} <br>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>{{ \Carbon\Carbon::parse($mr->date)->format('d/m/Y') }}
                                                                    </p>
                                                                    <p>Perawat : {{ $mr->nurse?->name }}</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        {{-- @if ($mr->date_lab)
                                                                            <p>Hasil lab:</p>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <p>Goldar:{{ $mr->blood_type }}</p>
                                                                                    <p>Hemoglobin
                                                                                        Umum:{{ $mr->hemoglobin }}</p>
                                                                                    <p>HIV:{{ $mr->hiv }}</p>
                                                                                    <p>Reduksi
                                                                                        Urine:{{ $mr->urine_reduction }}
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <p>Gula Darah
                                                                                        Acak:{{ $mr->random_blood_sugar }}
                                                                                    </p>
                                                                                    <p>HBSAG:{{ $mr->hbsag }}</p>
                                                                                    <p>Syphilis:{{ $mr->syphilis }}</p>
                                                                                    <p>Protein
                                                                                        Urine:{{ $mr->urine_protein }}
                                                                                </div>
                                                                                </p>
                                                                            </div>
                                                                        @endif --}}
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <p>Asesmen :</p>

                                                                                <p>{{ $mr->diagnose }}
                                                                                </p>
                                                                                <p>{{ $mr->summary }}
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <p class="fw-bold">Hasil
                                                                                    Lab
                                                                                    Lainnya:</p>
                                                                                <p>{{ $mr->other_lab }}
                                                                                </p>
                                                                                <p class="fw-bold">Resep
                                                                                    Luar:</p>
                                                                                <p>{{ $mr->other_recipe }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <p> Plan :</p>
                                                                            <p>{{ $mr->plan_note }}</p>
                                                                        </div>
                                                                        <div class="row">
                                                                            <p>Perhatian Khusus :</p>
                                                                            <p>{{ $mr->firstEntry->specific_attention ?? '-' }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="2">
                                                                    Tidak Ada
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" x-show="!purchase_drug">
                        <div class="mb-3">
                            <label for="medical_record_number" class="form-label">Nomor Rekam Medis</label>
                            <input type="text" class="form-control" id="medical_record_number"
                                wire:model="medical_record_number" disabled>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="mb-3">
                            <label for="doctor" class="form-label">Dokter</label>
                            <input type="text" class="form-control" id="doctor" wire:model="doctor_name" disabled>
                        </div>
                    </div> --}}
                    <div class="col-md-4" x-show="!purchase_drug">
                        <div class="mb-3">
                            <label for="doctor_id" class="form-label">Dokter</label>
                            <select class="form-select @error('doctor_id') is-invalid @enderror" name="doctor_id"
                                id="doctor_id" disabled wire:model.live="doctor_id">
                                <option value="">Pilih Dokter</option>
                                @foreach ($doctors as $p)
                                    <option value="{{ $p->id }}" {{ $p->id == $doctor_id ? 'selected' : '' }}>
                                        {{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="mb-3" wire:ignore>
                            <label for="user_id" class="form-label">Pasien</label>
                            <input type="text" class="form-control"
                                value="{{ ucwords(strtolower($transaction->patient->name)) }}" disabled>
                            @error('user_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK Pasien</label>
                            <input type="text" class="form-control" id="nik" wire:model="nik" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3" x-show="!purchase_drug">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="h6">Tindakan</p>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 2%">No</th>
                                <th>Nama</th>
                                <th style="width: 8%">Jumlah</th>
                                <th>Satuan</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th style="width: 12%">Diskon</th>
                                <th>Promo</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(action, index) in actions" :key="action.temp_id">
                                <tr>
                                    <td x-text="index+1"></td>
                                    <td style="width:250px" wire:ignore>
                                        <select name="drug_action_id" class="form-select" x-init="() => {
                                            $($el).select2({
                                                placeholder: 'Pilih Tindakan',
                                                width: '100%',
                                                theme: 'bootstrap-5',
                                            })
                                            $($el).on('change', function() {
                                                action.item_id = $el.value
                                                $wire.$call('getAction', action.temp_id, action.item_id)
                                            })
                                            if (action.item_id != '') {
                                                $($el).val(action.item_id).trigger('change');
                                            }
                                        }">
                                            <option value="">Pilih Tindakan</option>
                                            @foreach ($actionsOption as $action)
                                                <option value="{{ $action->id }}">{{ $action->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" placeholder="0"
                                            x-model="action.qty">
                                    </td>
                                    <td style="vertical-align: middle" x-text="action.uom"></td>
                                    <td style="vertical-align: middle" x-text="action.type"></td>
                                    <td style="vertical-align: middle"
                                        x-text="parseInt(action.price).toLocaleString('ID')">
                                    </td>
                                    <td><input class="form-control" type="text" placeholder="Rp0"
                                            x-model="action.discount">
                                    </td>
                                    <td>
                                        <div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    x-model="action.isPromo" x-bind:checked="action.isPromo"
                                                    id="flexSwitchCheckChecked">
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle"
                                        x-text="parseInt(action.qty*action.price-action.discount).toLocaleString('ID')">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            x-on:click="removeAction(action.temp_id)">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </td>
                                </tr>


                            </template>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8" style="text-align: right;">Total:</td>
                                <td colspan="2" x-text="actionTotal()"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <button type="button" class="btn btn-sm btn-primary mb-2" x-on:click="addAction">Tambah</button>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="h6">Obat dan Alkes</p>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 2%">No</th>
                                <th>Nama</th>
                                <th style="width: 5%">Jumlah</th>
                                <th style="width: 8%">Satuan</th>
                                <th style="width: 8%">Aturan Pakai</th>
                                <th style="width: 10%">Cara Pakai</th>
                                <th style="width: 5%">Harga</th>
                                <th style="width: 8%">Diskon</th>
                                <th style="width: 5%">Promo</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(drugMedDev, index) in drugMedDevs" :key="drugMedDev.temp_id">
                                <tr>
                                    <td x-text="index+1"></td>
                                    <td style="width:250px" wire:ignore>
                                        <select name="drug_action_id" class="form-select" x-init="() => {
                                            $($el).select2({
                                                placeholder: 'Pilih Obat/Alkes',
                                                width: '100%',
                                                theme: 'bootstrap-5',
                                            })
                                            $($el).on('change', function() {
                                                drugMedDev.item_id = $el.value
                                                $wire.$call('getDrugMedDev', drugMedDev.temp_id, drugMedDev.item_id)
                                            })
                                            if (drugMedDev.item_id != '') {
                                                $($el).val(drugMedDev.item_id).trigger('change');
                                            }
                                        }">
                                            <option value="">Pilih Obat/Alkes</option>
                                            @foreach ($drugMedDevsOption as $drugMedDev)
                                                <option value="{{ $drugMedDev->id }}">{{ $drugMedDev->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" placeholder="0"
                                            x-model="drugMedDev.qty">
                                    </td>
                                    <td style="vertical-align: middle" x-text="drugMedDev.uom"></td>
                                    <td style="vertical-align: middle" x-text="drugMedDev.rule"></td>
                                    <td style="vertical-align: middle" x-text="drugMedDev.type"></td>
                                    <td style="vertical-align: middle"
                                        x-text="parseInt(drugMedDev.price).toLocaleString('ID')">
                                    </td>
                                    <td><input class="form-control" type="text" placeholder="Rp0"
                                            x-model="drugMedDev.discount">
                                    </td>
                                    <td>
                                        <div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    x-model="drugMedDev.isPromo" x-bind:checked="drugMedDev.isPromo"
                                                    id="flexSwitchCheckChecked">
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle"
                                        x-text="parseInt(drugMedDev.qty*drugMedDev.price-drugMedDev.discount).toLocaleString('ID')">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            x-on:click="removeDrugMedDev(drugMedDev.temp_id)">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="9" style="text-align: right;">Total:</td>
                                <td colspan="2" x-text="drugMedDevTotal()"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <button type="button" class="btn btn-sm btn-primary mb-2" x-on:click="addDrugMedDev">Tambah</button>
            </div>
        </div>
        <div class="card mb-3" x-show="!purchase_drug">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="h6">Laborate</p>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Diskon</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(laborate, index) in laborates" :key="laborate.temp_id">
                                <tr>
                                    <td x-text="index+1"></td>
                                    <td wire:ignore>
                                        <select class="form-control" x-init="() => {
                                            $($el).select2({
                                                placeholder: 'Pilih Laborate',
                                                width: '100%',
                                                theme: 'bootstrap-5',
                                            });

                                            $($el).on('change', function() {
                                                laborate.item_id = $el.value
                                                $wire.$call('getLaborate', laborate.temp_id, laborate.item_id)
                                            })

                                            $($el).val(laborate.item_id).trigger('change');
                                        }">
                                            <option value="">Pilih Laborate</option>
                                            @foreach ($laboratesOption as $laborateOption)
                                                <option value="{{ $laborateOption->id }}">{{ $laborateOption->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" x-model="laborate.qty" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" x-model="parseInt(laborate.price).toLocaleString('ID')"
                                            class="form-control" readonly>
                                    </td>
                                    <td>
                                        <input type="text" x-model="laborate.discount" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text"
                                            x-model="parseInt(laborate.qty*laborate.price-laborate.discount).toLocaleString('ID')"
                                            class="form-control" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            x-on:click="removeLaborate(laborate.temp_id)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: right;">Total:</td>
                                <td colspan="2" x-text="laborateTotal()"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <button type="button" class="btn btn-sm btn-primary mb-2" x-on:click="addLaborate">Tambah</button>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="tw-grid tw-grid-cols-5 tw-gap-2">
                    <div class="tw-grid tw-grid-cols-3 tw-gap-2 tw-col-span-4">
                        <div class=""></div>
                        <template x-for="[key, paymentMethod] of Object.entries(paymentMethods)"
                            :key="key">
                            <template x-if="key == 'Cash'">
                                <div class="">
                                    <div class="">
                                        <label :for="key" x-text="'Pembayaran '+key">
                                        </label>
                                        <div class="input-group">
                                            <template x-if="key != 'Cash'">
                                                <select name="payment_method" class="form-select"
                                                    x-model="paymentMethod.bank">
                                                    <option value="">Pilih Bank</option>
                                                    <option value="Bank Mandiri">Bank Mandiri</option>
                                                    <option value="Bank BCA">Bank BCA</option>
                                                    <option value="Bank BNI">Bank BNI</option>
                                                    <option value="Bank BRI">Bank BRI</option>
                                                    <option value="Bank BSI">Bank BSI</option>
                                                    <option value="Bank Permata">Bank Permata</option>
                                                </select>
                                            </template>
                                            <input type="text" :id="key" class="form-control"
                                                x-model="paymentMethod.amount" value="" name="payment_amount"
                                                pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/\D/g, '');
                                                split   = (this.value).split(','),
                                                sisa     = split[0].length % 3,
                                                rupiah     = split[0].substr(0, sisa),
                                                ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
                                                if(ribuan){
                                                separator = sisa ? '.' : '';
                                                rupiah += separator + ribuan.join('.');
                                                }
                                                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                                                this.value = rupiah;">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </template>
                        <div class="">
                            <template x-for="[key, paymentMethod] of Object.entries(paymentMethods)"
                                :key="key">
                                <template x-if="key != 'Cash'">
                                    <div class="mb-2">
                                        <label :for="key" x-text="'Pembayaran '+key"></label>
                                        <div class="input-group">
                                            <select name="payment_method" class="form-select"
                                                x-model="paymentMethod.bank"
                                                x-on:change="(e) => {
                                                payment_amount = parseInt(($('#payment_amount').val()).replace(/[^0-9,]/g, '').replace(',', '.'))
                                                grand_total = parseInt(($('#grandTotal').val()).replace(/[^0-9,]/g, '').replace(',', '.'));

                                                if(payment_amount < grand_total){
                                                    cash = parseInt(($('#Cash').val()).replace(/[^0-9,]/g, '').replace(',', '.'));
                                                    paymentMethod.amount = grand_total - cash;
                                                }
                                                }">
                                                <option value="">Pilih Bank</option>
                                                <option value="Bank Mandiri">Bank Mandiri</option>
                                                <option value="Bank BCA">Bank BCA</option>
                                                <option value="Bank BNI">Bank BNI</option>
                                                <option value="Bank BRI">Bank BRI</option>
                                                <option value="Bank BSI">Bank BSI</option>
                                                <option value="Bank Permata">Bank Permata</option>
                                            </select>
                                            <input type="text" :id="key" class="form-control"
                                                x-model="paymentMethod.amount" value="" name="payment_amount"
                                                pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/\D/g, '') ;
                                                split   = (this.value).split(','),
                                                sisa     = split[0].length % 3,
                                                rupiah     = split[0].substr(0, sisa),
                                                ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
                                                if(ribuan){
                                                separator = sisa ? '.' : '';
                                                rupiah += separator + ribuan.join('.');
                                                }
                                                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                                                this.value = rupiah;
                                                ">
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                    <div class="tw-grid tw-grid-cols-1 tw-content-start tw-gap-2">
                        <div>
                            <label for="" class="fw-bold text-black">Grand Total</label>
                            <input type="text" id="grandTotal"
                                :value="parseInt(actions.reduce((a, b) => a + b.price * b.qty - b.discount, 0) + drugMedDevs
                                    .reduce((a,
                                        b) => a + b.price * b.qty - b.discount, 0) + laborates.reduce((a, b) => a +
                                        b
                                        .price * b.qty - b.discount, 0)).toLocaleString('ID')"
                                class="form-control w-100" aria-describedby="passwordHelpInline" readonly>
                        </div>

                        <div class="">
                            <label for="payment_amount" class="fw-bold">Jumlah Bayar</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="payment_amount" class="form-control"
                                    :value="parseInt(Object.values(paymentMethods).reduce((a, b) => a + parseInt(String(b
                                            .amount).replaceAll('.', '')), 0))
                                        .toLocaleString('ID')"
                                    name="payment_amount" pattern="[0-9]*" disabled>
                            </div>
                        </div>
                        <div class="">
                            <label for="kembalian" class="fw-bold">Kembalian</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="kembalian" class="form-control"
                                    :value="parseInt(Object.values(paymentMethods).reduce((a, b) => a + parseInt(String(b
                                            .amount).replaceAll('.', '')), 0) -
                                        (actions.reduce((a, b) => a + b.price * b.qty - b.discount, 0) + drugMedDevs
                                            .reduce((a,
                                                b) => a + b.price * b.qty - b.discount, 0) + laborates.reduce((a,
                                                    b) =>
                                                a +
                                                b
                                                .price * b.qty - b.discount, 0))).toLocaleString('ID')"
                                    disabled>
                            </div>
                        </div>
                    </div>
                </div>
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
        Alpine.data('editPayment', () => ({
            purchase_drug: @entangle('purchase_drug').live,
            paymentMethods: @entangle('paymentMethods'),
            laborates: @entangle('laborates'),
            drugMedDevs: @entangle('drugMedDevs'),
            actions: @entangle('actions'),
            kembalian: @entangle('kembalian'),
            grand_total: @entangle('grand_total'),
            actionTotal() {
                return this.actions.reduce((sum, action) => sum + (action.qty * action.price - action.discount),
                    0).toLocaleString('ID');
            },
            drugMedDevTotal() {
                return this.drugMedDevs.reduce((sum, drugMedDev) => sum + (drugMedDev.qty * drugMedDev.price -
                    drugMedDev.discount), 0).toLocaleString('ID');
            },
            laborateTotal() {
                return this.laborates.reduce((sum, laborate) => sum + (laborate.qty * laborate.price - laborate
                    .discount), 0).toLocaleString('ID');
            },
            init() {

                $('#user_id').select2({
                    theme: 'bootstrap-5',
                });
                $('#user_id').on('change', function(e) {
                    var data = $('#user_id').select2("val");
                    $wire.$set('user_id', data);
                });

                this.$watch('paymentMethods', () => {
                    this.kembalian = parseInt(Object.values(this.paymentMethods).reduce((a, b) => a +
                            parseInt(String(b.amount).replaceAll('.', '')), 0) -
                        (this.actions.reduce((a, b) => a + b.price * b.qty - b.discount, 0) + this
                            .drugMedDevs.reduce((a, b) => a + b.price * b.qty - b.discount, 0) +
                            this.laborates.reduce((a, b) => a + b.price * b.qty - b.discount, 0)))
                    this.grand_total = parseInt(this.actions.reduce((a, b) => a + b.price * b.qty - b
                        .discount, 0) + this.drugMedDevs.reduce((a, b) => a + b.price * b.qty -
                        b.discount, 0) + this.laborates.reduce((a, b) => a + b.price * b.qty - b
                        .discount, 0))
                });



                $wire.$on('refresh-select2', function(event) {
                    select2 = $('#user_id').data('select2');
                    select2.destroy;
                    select2.$element.find('option').remove();
                    $('#user_id').select2({
                        theme: 'bootstrap-5',
                    });
                    $('#user_id').append($('<option>', {
                        value: '',
                        text: 'Pilih Pasien',
                        selected: true // Menandai opsi ini sebagai terpilih secara default
                    }));
                    event.users.forEach(function(user) {
                        select2.$element.append(new Option(user.name, user.id,
                            false, false));
                    });

                    $('#user_id').on('change', function(e) {
                        var data = $('#user_id').select2("val");
                        $wire.$set('user_id', data);
                    });
                })

                $wire.$on('get-action-result', ({
                    item,
                    temp_id
                }) => {
                    this.actions = this.actions.map((action, index) => {
                        if (action.temp_id == temp_id) {
                            return {
                                ...action,
                                item_id: item.id,
                                uom: item.uom ?? '-',
                                type: item.type ?? '-',
                                isPromo: action.isPromo ?? false,
                                price: item.price,
                            }
                        }
                        return action
                    })
                })

                $wire.$on('get-drug-med-dev-result', ({
                    item,
                    temp_id
                }) => {
                    this.drugMedDevs = this.drugMedDevs.map((drugMedDev, index) => {
                        if (drugMedDev.temp_id == temp_id) {
                            return {
                                ...drugMedDev,
                                item_id: item.id,
                                uom: item.uom ?? '-',
                                type: drugMedDev.type ?? '-',
                                rule: drugMedDev.rule ?? '-',
                                isPromo: drugMedDev.isPromo ?? false,
                                price: item.selling_price,
                            }
                        }
                        return drugMedDev
                    })
                })

                $wire.$on('get-laborate-result', ({
                    item,
                    temp_id
                }) => {
                    this.laborates = this.laborates.map((laborate, index) => {
                        if (laborate.temp_id == temp_id) {
                            return {
                                ...laborate,
                                item_id: item.id,
                                price: item.price,
                            }
                        }
                        return laborate
                    })
                })
            },

            addAction() {
                this.actions.push({
                    temp_id: Math.floor(Math.random() * 1000) + 1,
                    item_id: '',
                    qty: 1,
                    uom: '-',
                    type: '-',
                    price: 0,
                    discount: 0,
                    total: 0
                });
            },

            removeAction(temp_id) {
                this.actions = this.actions.filter((action) => action.temp_id != temp_id);
            },

            addDrugMedDev() {
                this.drugMedDevs.push({
                    temp_id: Math.floor(Math.random() * 1000) + 1,
                    item_id: '',
                    qty: 1,
                    uom: '-',
                    type: '-',
                    rule: '-',
                    price: 0,
                    discount: 0,
                    total: 0
                });
            },

            removeDrugMedDev(temp_id) {
                this.drugMedDevs = this.drugMedDevs.filter((drugMedDev) => drugMedDev.temp_id != temp_id);
            },

            addLaborate() {
                this.laborates.push({
                    temp_id: Math.floor(Math.random() * 1000) + 1,
                    item_id: '',
                    qty: 1,
                    price: 0,
                    discount: 0,
                    total: 0
                });
            },

            removeLaborate(temp_id) {
                this.laborates = this.laborates.filter((laborate) => laborate.temp_id != temp_id);
            }
        }))
    </script>
@endscript
