<x-slot:title>
    Daftar Rekam Medis
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('medical-record.index') }}" wire:navigate>Rekam Medis</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Rekam Medis</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <button class="btn btn-primary" wire:click="save">Simpan</button>
    </x-slot:button>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if ($user)
                        <span
                            class="tw-bg-blue-100 tw-text-blue-800 tw-text-s tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-gray-700 tw-dark:text-blue-400 tw-border tw-border-blue-400">Waktu
                            CPPT : {{ $timestamp }}</span>
                        <p class="h6">Data Pasien</p>
                        <div class="row">
                            <div class="col">
                                <table>
                                    <tr>
                                        <td class="tw-text-nowrap">Nama</td>
                                        <td>: <button
                                                wire:click="$dispatch('openModal', {component:'medical-record.detail-patient',arguments:{uuid:'{{ $user->patient->uuid }}'}})"
                                                class="text-info" title="Detail Pasien">{{ $user->name }}</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tw-text-nowrap">Usia</td>
                                        <td>: {{ $age->format('%y tahun') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-text-nowrap">Nomor Telepon</td>
                                        <td>: {{ $user->patient->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-text-nowrap">Golongan Darah</td>
                                        <td>: {{ $user->patient->blood_type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-text-nowrap">Pekerjaan</td>
                                        <td>: {{ ucwords(strtolower($user->patient->job->name ?? '-')) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-text-nowrap">Alamat</td>
                                        <td>: {{ $user->patient->address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-text-nowrap">Email</td>
                                        <td>: {{ $user->email ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="col-md-11 mt-3">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Nama Pasien</label>
                                <select class="form-select select2 @error('user_id') is-invalid @enderror"
                                    id="user_id" name="user_id" aria-label="Default select example"
                                    wire:model.live="user_id">
                                    <option selected>Pilih Nama Pasien</option>
                                    @foreach ($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }} -
                                            {{ $u->patient->nik }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <p class="h6">Riwayat Obstetri</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Kehamilan ke-</th>
                                <th>Jenis Persalinan</th>
                                <th>Jenis Kelamin</th>
                                <th>BB Lahir</th>
                                <th>Usia Anak Sekarang</th>
                                <th>Keterangan Tambahan/Komplikasi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obstetri ?? [] as $o)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $o->type_of_birth }}</td>
                                    <td>{{ is_null($o->gender) ? '-' : ($o->gender == 1 ? 'Laki-laki' : ($o->gender == 0 ? 'Perempuan' : ($o->gender == 2 ? 'Keguguran' : ($o->gender == 3 ? 'Hamil INI' : ($o->gender == 5 ? 'IUFD' : '-'))))) }}
                                    </td>
                                    <td>{{ $o->weight ?? 0 }} gr</td>
                                    <td>{{ $o->age ?? 0 }} tahun</td>
                                    <td>{{ $o->clinical_information }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" align="center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="hpht" class="form-label">HPHT</label>
                                <input type="text" date-picker disabled class="form-control"
                                    value="{{ $firstEntry ? \Carbon\Carbon::parse($firstEntry->hpht)->format('d-m-Y') : '' }}">
                                @error('hpht')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="interpretation_childbirth" class="form-label">Tafsiran Persalinan</label>
                                <input type="text" class="form-control" id="interpretation_childbirth"
                                    value="{{ $firstEntry? \Carbon\Carbon::parse($firstEntry->hpht)->addDays(280)->format('d-m-Y'): '' }}"
                                    disabled>
                                @error('interpretation_childbirth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="age_childbirth" class="form-label">Usia Kehamilan</label>
                                <input type="text" class="form-control" disabled id="age_childbirth"
                                    value="{{ $firstEntry ? floor(\Carbon\Carbon::now()->diffInWeeks(\Carbon\Carbon::parse($firstEntry->hpht))) . ' minggu ' . floor(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($firstEntry->hpht))) % 7 . ' hari' : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Perhatian Khusus</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $firstEntry ? $firstEntry->specific_attention : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <h6 class="h6">SOAP</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Subjective</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" wire:model="subjective_summary"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Objective</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" wire:model="objective_summary"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Assessment Utama</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" wire:model="assessment_summary"></textarea>
                        </div>
                    </div>
                    {{-- <div class="col-12">
                            <div class="mb-3" wire:ignore>
                                <label for="exampleFormControlTextarea1" class="form-label">Diagnosa Penyerta</label>
                                <select name="diagnose" id="diagnose" wire:model="diagnose"
                                    class="select2 form-control w-100">

                                </select>
                            </div>
                        </div> --}}
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Keterangan Tambahan / Laporan
                                Hasil Tindakan</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" wire:model="other_summary"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <livewire:medical-record.table.create.usg-table :user_id="$user->id ?? null" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" x-data="{ next_control: @entangle('next_control') }">
        <div class="col">
            <div class="card mb-3">
                <div class="card-body">
                    <p class="h5 mb-3">Plan</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="next_control" class="form-label">Periksa
                                        Berikutnya</label>
                                    <input type="text" date-picker wire:ignore
                                        class="form-control @error('next_control') is-invalid @enderror"
                                        id="next_control" x-model="next_control">
                                    @error('next_control')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <livewire:medical-record.table.nurse.create.action-table />
                        <livewire:medical-record.table.nurse.create.drug-table />
                        <livewire:medical-record.table.nurse.create.laborate-table />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <p class="h5">Medical History</p>
                <p class="text-primary">Sudah periksa {{ $oldMedicalRecords->count() }} kali</p>
                <table class="table">
                    <thead>
                        <tr>
                            Tanggal : <br>
                            <th>Tanggal, <br>Dokter/Perawat</th>
                            <th>Rekam Medis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($oldMedicalRecords ?? [] as $omr)
                            <tr :key="rand()">
                                <td>
                                    Dokter : {{ isset($omr->doctor) ? $omr->doctor->name : '' }} <br>
                                    Perawat : {{ $omr->nurse->name ?? '' }} <br><br>

                                </td>
                                <td>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div>
                                                    <span class="text-primary">Subjective :</span> <br>
                                                    {{ $omr->subjective_summary ?? '-' }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div>
                                                    <span class="text-primary">Objective :</span> <br>
                                                    <table>
                                                        <tr>
                                                            <td>TD</td>
                                                            <td>: {{ $omr->sistole }}/{{ $omr->diastole }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>BB</td>
                                                            <td>: {{ $omr->weight }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>TB</td>
                                                            <td>: {{ $omr->height }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>S</td>
                                                            <td>: {{ $omr->body_temperature }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>N</td>
                                                            <td>: {{ $omr->pulse }}</td>
                                                        </tr>
                                                    </table>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div>
                                                    @if ($omr->date_lab != null)
                                                        <span class="text-primary">Hasil Lab :</span> <br>
                                                        <table>
                                                            <tr>
                                                                <td>Goldar</td>
                                                                <td>: {{ $omr->blood_type }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gula Darah Acak</td>
                                                                <td>: {{ $omr->random_blood_sugar }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Hemoglobin Umum</td>
                                                                <td>: {{ $omr->hemoglobin }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>HBSAG</td>
                                                                <td>: {{ $omr->hbsag }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>HIV</td>
                                                                <td>: {{ $omr->hiv }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Syphilis</td>
                                                                <td>: {{ $omr->syphilis }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Reduksi Urine</td>
                                                                <td>: {{ $omr->urine_reduction }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Protein Urine</td>
                                                                <td>: {{ $omr->urine_protein }}</td>
                                                            </tr>
                                                        </table>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div>
                                                    <span class="text-primary">Asesmen :</span> <br>
                                                    {{ $omr->assessment_summary ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="container">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div>
                                                    Hasil USG : <br>
                                                    @foreach ($omr->usgs as $u)
                                                        <a href="{{ asset('storage/' . $u->file) }}"
                                                            class="btn btn-primary btn-sm" noreferer noopener
                                                            target="_blank">Lihat File</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div>
                                                    <span class="text-primary">Obat :</span> <br>
                                                    @foreach ($omr->drugMedDevs as $a)
                                                        {{ '- ' . $a->name }} <br>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div>
                                                    <span class="text-primary">Tindakan :</span> <br>
                                                    @foreach ($omr->actions as $a)
                                                        {{ '- ' . $a->name }} <br>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div>
                                                    <span class="text-primary">Laborate :</span> <br>
                                                    @foreach ($omr->laborate as $a)
                                                        {{ '- ' . $a->name }} <br>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <br><br>



                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" align="center">Data tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
@endassets

@script
    <script>
        let $user_id = $("#user_id");
        $user_id.select2({
            theme: 'bootstrap-5',
        });
        $user_id.on('change', function(e) {
            var data = $('#user_id').select2("val");
            $wire.$set('user_id', data);
        });

        flatpickr($wire.$el.querySelector('#next_control'), {
            dateFormat: "d-m-Y",
            "locale": "id",
            // altFormat: "d-m-Y",
            // onClose: function(selectedDates, dateStr, instance) {
            //     // $wire.$set('next_control', dateStr);
            //     },
            minDate: "today",
            defaultDate: new Date(),
            allowInput: true,
            dateFormat: "d-m-Y",
        });
    </script>
@endscript
