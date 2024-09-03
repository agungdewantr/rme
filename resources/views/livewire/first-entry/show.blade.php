<x-slot:title>
    Daftar Asesmen Awal
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('first-entry.index') }}" wire:navigate>Asesmen Awal</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Asesmen Awal</li>
    </x-slot:breadcrumbs>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <span
                        class="tw-bg-blue-100 tw-text-blue-800 tw-text-s tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-gray-700 tw-dark:text-blue-400 tw-border tw-border-blue-400">Waktu
                        Asesmen Awal : {{ $firstEntry->time_stamp }}</span>
                    <p class="h6 mt-3">Data Pasien</p>
                    <div class="row">
                        <div class="col">
                            <table>
                                <tr>
                                    <td class="tw-text-nowrap">Nomor RM</td>
                                    <td>: {{ $firstEntry->patient->patient_number }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Nama</td>
                                    <td>: {{ ucwords(strtolower($firstEntry->patient->name)) }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Tanggal Lahir</td>
                                    <td>:
                                        {{ Carbon\Carbon::parse($firstEntry->patient->dob)->format('d M Y') . ' (' . $age->format('%y tahun') . ')' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Nomor Telepon</td>
                                    <td>: {{ $firstEntry->patient->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Golongan Darah</td>
                                    <td>: {{ $firstEntry->patient->blood_type }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Pekerjaan</td>
                                    <td>: {{ ucwords(strtolower($firstEntry->patient->job->name ?? '-')) }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Alamat</td>
                                    <td>: {{ $firstEntry->patient->address }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Email</td>
                                    <td>: {{ $firstEntry->patient->user->email }}</td>
                                </tr>
                            </table>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-start">
                                        {{-- <button class="btn btn-primary"
                                        wire:click="$dispatch('openModal', {component:'payment.modal.medical-history', arguments:{user_id:{{ $user_id ?? 0 }}}})">
                                        Lihat Rekam Medis
                                    </button> --}}
                                    <button type="button" class="tw-btn tw-bg-[#68FFA1] tw-text-black tw-px-4 tw-py-2 tw-rounded tw-mt-8"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Lihat Medical History
                                    </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                Medical History</h1>
                                                            <p class="m-0">Sudah {{ $medicalRecords->count() }}
                                                                kali pemeriksaan
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
                                                                    @forelse ($medicalRecords ?? [] as $mr)
                                                                        <tr>
                                                                            <td>
                                                                                <p>
                                                                                    Cabang :
                                                                                    {{ $mr->registration->branch->name }}
                                                                                </p>
                                                                                <p>{{ \Carbon\Carbon::parse($mr->date)->format('d/m/Y') }}
                                                                                </p>
                                                                                <p>Dokter {{ $mr->doctor?->name }}
                                                                                </p>
                                                                            </td>
                                                                            <td>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <p>Subjective:</p>
                                                                                        <p>{{ $mr->subjective_summary }}
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        @php
                                                                                            try {
                                                                                                $imt = number_format(
                                                                                                    $mr->weight /
                                                                                                        pow(
                                                                                                            $mr->height /
                                                                                                                100,
                                                                                                            2,
                                                                                                        ),
                                                                                                    '0',
                                                                                                    ',',
                                                                                                    '.',
                                                                                                );
                                                                                            } catch (\Throwable $th) {
                                                                                                $imt = 0;
                                                                                            }
                                                                                            if ($imt >= 40.0) {
                                                                                                $imtStatus =
                                                                                                    'Obese Class III';
                                                                                            } elseif (
                                                                                                $imt >= 35.0 &&
                                                                                                $imt <= 39.99
                                                                                            ) {
                                                                                                $imtStatus =
                                                                                                    'Obese Class II';
                                                                                            } elseif (
                                                                                                $imt >= 30.0 &&
                                                                                                $imt <= 34.99
                                                                                            ) {
                                                                                                $imtStatus =
                                                                                                    'Obese Class I';
                                                                                            } elseif (
                                                                                                $imt >= 25.0 &&
                                                                                                $imt <= 29.99
                                                                                            ) {
                                                                                                $imtStatus =
                                                                                                    'Overweight';
                                                                                            } elseif (
                                                                                                $imt >= 18.5 &&
                                                                                                $imt <= 24.99
                                                                                            ) {
                                                                                                $imtStatus = 'Normal';
                                                                                            } elseif (
                                                                                                $imt >= 17.0 &&
                                                                                                $imt <= 18.49
                                                                                            ) {
                                                                                                $imtStatus =
                                                                                                    'Underweight';
                                                                                            } elseif (
                                                                                                $imt >= 16.0 &&
                                                                                                $imt <= 16.99
                                                                                            ) {
                                                                                                $imtStatus =
                                                                                                    'Severely Underweight';
                                                                                            } else {
                                                                                                $imtStatus =
                                                                                                    'Very Severely Underweight';
                                                                                            }
                                                                                        @endphp
                                                                                        <p>Objective:</p>
                                                                                        <div>
                                                                                            <p>{{ $mr->objective_summary }}
                                                                                            </p>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <p>Asesmen:</p>
                                                                                        <p>{{ $mr->assessment_summary ?? '-' }}
                                                                                        </p>
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
                                                                                        <p>Keterangan
                                                                                            Tambahan/Laporan Hasil
                                                                                            Tindakan:</p>
                                                                                        <p>{{ $mr->other_summary ?? '-' }}
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div
                                                                                            class="d-flex align-items-start">
                                                                                            @foreach ($mr->usgs as $u)
                                                                                                <a href="{{ asset('storage/' . $u->file) }}"
                                                                                                    class="btn btn-primary btn-sm"
                                                                                                    noreferer noopener
                                                                                                    target="_blank">Lihat
                                                                                                    File</a>
                                                                                            @endforeach

                                                                                            {{-- <p>Hasil USG:</p>

                                                                                            <div class="row">
                                                                                                <div
                                                                                                    class="col-md-6">
                                                                                                    <p>FL:{{ $mr->fl }}
                                                                                                    </p>
                                                                                                    <p>FHR:{{ $mr->fhr }}
                                                                                                    </p>
                                                                                                    <p>EFW:{{ $mr->efw }}
                                                                                                    </p>
                                                                                                    <p>AC:{{ $mr->ac }}
                                                                                                    </p>
                                                                                                    <p>GA:{{ $mr->ga }}
                                                                                                    </p>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="col-md-6">
                                                                                                    <p>GS:{{ $mr->gs }}
                                                                                                    </p>
                                                                                                    <p>CRL:{{ $mr->crl }}
                                                                                                    </p>
                                                                                                    <p>BPD:{{ $mr->bpd }}
                                                                                                    </p>

                                                                                                </div>
                                                                                                </p>
                                                                                            </div> --}}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="row">
                                                                                            <div class="col-md-3">
                                                                                                <div>
                                                                                                    <span
                                                                                                        class="text-primary">Obat
                                                                                                        :</span>
                                                                                                    <br>
                                                                                                    @foreach ($mr->drugMedDevs as $a)
                                                                                                        {{ '- ' . $a->name }}
                                                                                                        <br>
                                                                                                    @endforeach
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <div>
                                                                                                    <span
                                                                                                        class="text-primary">Tindakan
                                                                                                        :</span>
                                                                                                    <br>
                                                                                                    @foreach ($mr->actions as $a)
                                                                                                        {{ '- ' . $a->name }}
                                                                                                        <br>
                                                                                                    @endforeach
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <div>
                                                                                                    <span
                                                                                                        class="text-primary">Laborate
                                                                                                        :</span>
                                                                                                    <br>
                                                                                                    @foreach ($mr->laborate as $a)
                                                                                                        {{ '- ' . $a->name }}
                                                                                                        <br>
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
                                                                                <p>Perawat {{ $mr->nurse?->name }}
                                                                                </p>
                                                                            </td>
                                                                            <td>
                                                                                <div class="row">
                                                                                    {{-- @if ($mr->date_lab)
                                                                                        <p>Hasil lab:</p>

                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <p>Goldar:{{ $mr->blood_type }}
                                                                                                </p>
                                                                                                <p>Hemoglobin
                                                                                                    Umum:{{ $mr->hemoglobin }}
                                                                                                </p>
                                                                                                <p>HIV:{{ $mr->hiv }}
                                                                                                </p>
                                                                                                <p>Reduksi
                                                                                                    Urine:{{ $mr->urine_reduction }}
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <p>Gula Darah
                                                                                                    Acak:{{ $mr->random_blood_sugar }}
                                                                                                </p>
                                                                                                <p>HBSAG:{{ $mr->hbsag }}
                                                                                                </p>
                                                                                                <p>Syphilis:{{ $mr->syphilis }}
                                                                                                </p>
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
                            </div>
                        </div>
                    </div>
                </div>
                @if($firstEntry->patient->status_pernikahan == 'Menikah')
                <div class="col-md-4 mt-4">
                    <p class="h6 mt-3">Data Suami Pasien</p>
                    <div class="row">
                        <div class="col">
                            <table>
                                <tr>
                                    <td class="tw-text-nowrap">Nama</td>
                                    <td>: {{ ucwords(strtolower($firstEntry->patient->husbands_name)) }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Tanggal Lahir</td>
                                    <td>:
                                        {{ $firstEntry->patient->husbands_birth_date ? Carbon\Carbon::parse($firstEntry->patient->husbands_birth_date)->format('d M Y') . ' (' . $age_husband->format('%y tahun') . ')' : '-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Nomor Telepon</td>
                                    <td>: {{ $firstEntry->patient->husbands_phone_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Pekerjaan</td>
                                    <td>: {{ ucwords(strtolower($firstEntry->patient->husbands_job ?? '-')) }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Alamat</td>
                                    <td>: {{ $firstEntry->patient->husbands_address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Kewarganegaraan</td>
                                    <td>: {{ $firstEntry->patient->husbands_citizenship ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Lama Pernikahan</td>
                                    <td>: {{ $firstEntry->patient->age_of_marriage ? $firstEntry->patient->age_of_marriage . ' tahun' : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Keterangan</td>
                                    <td>: {{ $firstEntry->patient->husbands_note ?? '-' }}</td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
                @endif



                <div class="col-md-4 mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="doctor_id" class="form-label">Nama Perawat</label>
                                <input type="text" class="form-control" disabled name="" id=""
                                    value="{{ $firstEntry->nurse->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        {{-- @if (auth()->user()->role_id == 5) --}}
                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                                <label for="doctor_id" class="form-label">Nama Dokter</label>
                                <input type="text" class="form-control" disabled name="" id=""
                                    value="{{ $firstEntry->doctor->name }}">
                            </div>

                        </div> --}}
                        {{-- @endif --}}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            {{-- <livewire:first-entry.table.create.obstetri-table /> --}}
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="h6">Status obstetri</p>

                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center" width=8%>Kehamilan ke-</th>
                                <th class="text-center">Jenis Persalinan</th>
                                <th width="160">Jenis Kelamin</th>
                                <th width="13%">BB Lahir</th>
                                {{-- <th width="200">Tanggal Lahir Anak</th> --}}
                                <th width="160">Usia Anak</th>
                                <th>Keterangan Klinik</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $gender = ['Perempuan', 'Laki-Laki', 'Keguguran', 'Hamil INI'];
                            @endphp
                            @forelse ($firstEntry->patient->obstetri as $o)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $o->type_of_birth }}</td>
                                    <td>{{ is_null($o->gender) ? '-' : ($o->gender == 1 ? 'Laki-laki' : ($o->gender == 0 ? 'Perempuan' : ($o->gender == 2 ? 'Keguguran' : ($o->gender == 3 ? 'Hamil INI' : ($o->gender == 5 ? 'IUFD' : '-'))))) }}
                                    </td>
                                    <td>{{ $o->weight ?? 0 }} gr</td>
                                    {{-- <td>{{ $o->birth_date }}</td> --}}
                                    {{-- <td>{{ \Carbon\Carbon::parse($o->birth_date)->diff(\Carbon\Carbon::now())->format('%y tahun %m bulan') }} --}}
                                    <td>{{ $o->age ?? 0 }} tahun</td>
                                    </td>
                                    <td>{{ $o->clinical_information }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" align="center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="hpht" class="form-label">HPHT</label>
                        <input type="text" class="form-control"
                            value="{{ Carbon\Carbon::parse($firstEntry->hpht)->format('d-m-Y') }}" disabled>
                        @error('hpht')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="edd" class="form-label">Tafsiran Persalinan</label>
                        <input type="text"
                            class="form-control @error('interpretation_childbirth') is-invalid @enderror"
                            value="{{ Carbon\Carbon::parse($firstEntry->edd)->format('d-m-Y') }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="edd" class="form-label">Usia Kehamilan</label>
                        <input type="text" class="form-control" disabled
                            value="{{ \Carbon\Carbon::parse($firstEntry->hpht)->diffInWeeks(\Carbon\Carbon::now()) }} minggu {{ \Carbon\Carbon::parse($firstEntry->hpht)->diffInDays(\Carbon\Carbon::now()) % 7 }} hari
                        ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="main_complaint" class="form-label">Riwayat Keluhan Sekarang/Keluhan Saat
                            Ini</label>
                        <textarea id="main_complaint" name="main_complaint" disabled class="form-control">{{ $firstEntry->main_complaint }}</textarea>
                        @error('main_complaint')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="main_complaint" class="form-label">Perhatian Khusus</label>
                        <textarea id="" name="specific_attention" class="form-control" disabled>{{ $firstEntry->specific_attention }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div>
                        <div class="d-flex justify-content-between">
                            <h6 class="h6">Riwayat Penyakit Terdahulu</h6>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Penyakit Terdahulu</th>
                                        <th>Terapi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($firstEntry->patient->illnessHistories as $key => $i)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $i->name }}</td>
                                            <td>{{ $i->pivot->therapy }}</td>
                                        </tr>
                                    @endforeach
                                    @if ($firstEntry->patient->illnessHistories->count() == 0)
                                        <tr>
                                            <td colspan="5" align="center">Tidak ada data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div>
                        <div class="d-flex justify-content-between">
                            <h6 class="h6">Riwayat Penyakit Keluarga</h6>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Hubungan</th>
                                        <th>Nama Penyakit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($firstEntry->patient->familyIlnessHistories as $key => $f)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $f->name }}</td>
                                            <td>{{ $f->relationship }}</td>
                                            <td>{{ $f->disease_name }}</td>
                                        </tr>
                                    @endforeach
                                    @if ($firstEntry->patient->familyIlnessHistories->count() == 0)
                                        <tr>
                                            <td colspan="5" align="center">Tidak ada data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div>
                        <div class="d-flex justify-content-between">
                            <h6 class="h6">Riwayat Alergi</h6>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Alergi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($firstEntry->patient->allergyHistories as $key => $a)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $a->name }}</td>
                                        </tr>
                                    @endforeach
                                    @if ($firstEntry->patient->allergyHistories->count() == 0)
                                        <tr>
                                            <td colspan="5" align="center">Tidak ada data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Pemeriksaan FIsik --}}
    <div class="card mb-3">
        <div class="card-body" x-data="{
            showLab: false,
            bmi: '',
            bmi_status: '',
        }">
            <div class="row">
                <div class="col">
                    <div class="col-12">
                        <p class="h6">Pemeriksaan Fisik</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="patient_awareness" class="form-label">Kesadaran Pasien</label>
                                <input type="text" class="form-control"
                                    value="{{ $firstEntry->patient_awareness }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="body_temperature" class="form-label">Suhu Tubuh</label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control @error('body_temperature') is-invalid @enderror"
                                        id="body_temperature" value="{{ $firstEntry->body_temperature }}" disabled>
                                    <span class="input-group-text" id="basic-addon1">
                                        <sup>o</sup>C
                                    </span>
                                    @error('body_temperature')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="height" class="form-label">Tinggi Badan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('height') is-invalid @enderror"
                                        id="height" value="{{ $firstEntry->height }}" disabled
                                        x-on:change="(e)=>{
                                                            if(height>0 && weight>0){
                                                                bmi = Number.parseFloat(weight/((height/100)*(height/100))).toFixed(2)
                                                                if(parseInt(bmi)>=40.0){
                                                                    bmi_status = 'Obese Class III'
                                                                }else if(parseInt(bmi)>=35.00 && parseInt(bmi)<=39.99){
                                                                    bmi_status = 'Obese Class II'
                                                                }else if(parseInt(bmi)>=30.00 && parseInt(bmi)<=34.99){
                                                                    bmi_status = 'Obese Class I'
                                                                }else if(parseInt(bmi)>=25.00 && parseInt(bmi)<=29.99){
                                                                    bmi_status = 'Overweight'
                                                                }else if(parseInt(bmi)>=18.50 && parseInt(bmi)<=24.99){
                                                                    bmi_status = 'Normal'
                                                                }else if(parseInt(bmi)>=17.00 && parseInt(bmi)<=18.49){
                                                                    bmi_status = 'Underweight'
                                                                }else if(parseInt(bmi)>=16.00 && parseInt(bmi)<=16.99){
                                                                    bmi_status = 'Severely Underweight'
                                                                }else{
                                                                    bmi_status = 'Very Severely Underweight'
                                                                }
                                                            }
                                                        }">
                                    <span class="input-group-text" id="basic-addon1">
                                        cm
                                    </span>
                                    @error('height')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="weight" class="form-label">Berat Badan</label>
                                <div class="input-group">
                                    <input type="text" pattern="[0-9.]*" value="{{ $firstEntry->weight }}"
                                        disabled class="form-control @error('weight') is-invalid @enderror"
                                        id="weight">
                                    <span class="input-group-text" id="basic-addon1">
                                        /kg
                                    </span>
                                    @error('weight')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sistole" class="form-label">Sistole</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('sistole') is-invalid @enderror"
                                        id="sistole" value="{{ $firstEntry->sistole }}" disabled>
                                    <span class="input-group-text" id="basic-addon1">
                                        /mmHg
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="diastole" class="form-label">Diastole</label>
                                <div class="input-group">
                                    <input type="text" value="{{ $firstEntry->diastole }}" disabled
                                        class="form-control @error('diastole') is-invalid @enderror" id="diastole">
                                    <span class="input-group-text" id="basic-addon1">
                                        /mmHg
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pulse" class="form-label">Nadi</label>
                                <div class="input-group">
                                    <input type="text" value="{{ $firstEntry->pulse }}" disabled
                                        class="form-control @error('pulse') is-invalid @enderror" id="pulse">
                                    <span class="input-group-text" id="basic-addon1">
                                        /menit
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="respiratory_frequency" class="form-label">Frekuensi
                                    Pernafasan</label>
                                <div class="input-group">
                                    <input
                                        type="text"class="form-control @error('respiratory_frequency') is-invalid @enderror"
                                        id="respiratory_frequency" value="{{ $firstEntry->respiratory_frequency }}"
                                        disabled>
                                    <span class="input-group-text" id="basic-addon1">
                                        /menit
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bmi" class="form-label">BMI / IMT</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="pulse"
                                        value="{{ $firstEntry->weight && $firstEntry->height ? round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) : 0 }}"
                                        disabled>
                                    <span class="input-group-text" id="basic-addon1">
                                        kg/m<sup>2</sup>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bmi_status" class="form-label">BMI / IMT Status</label>
                                <input type="text" class="form-control" id="pulse" disabled
                                    @if ($firstEntry->weight && $firstEntry->height) @if (round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) >= 40.0) value="Obese Class III"
                                            @elseif (round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) >= 35.0 &&
                                                    round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) <= 39.99)
                                            value="Obese Class II"
                                            @elseif (round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) >= 30.0 &&
                                                    round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) <= 34.99)
                                            value="Obese Class I"
                                            @elseif (round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) >= 25.0 &&
                                                    round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) <= 29.99)
                                            value="Overweight"
                                            @elseif (round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) >= 18.5 &&
                                                    round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) <= 24.99)
                                            value="Normal"
                                            @elseif (round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) >= 17.0 &&
                                                    round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) <= 18.49)
                                            value="Underweight"
                                            @elseif (round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) >= 16.0 &&
                                                    round($firstEntry->weight / pow($firstEntry->height / 100, 2), 2) <= 16.99)
                                            value="Severely Underweight"
                                            @else
                                            value="Very Severely Underweight" @endif
                                @else value="Very Severely Underweight" @endif
                                >
                            </div>
                        </div>

                        <div class="col col-12">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Keterangan
                                    Tambahan</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $firstEntry->description_physical }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                {{ $firstEntry->date_lab ? 'checked disabled' : '' }} id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Hasil Lab
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-1 {{ !$firstEntry->date_lab ? 'tw-invisible' : '' }}">
                        <div class="mb-3">
                            <label for="date_lab" class="form-label">Tanggal Pemeriksaan Lab</label>
                            <input type="text" date-picker
                                class="form-control @error('date_lab') is-invalid @enderror"
                                value="{{ Carbon\Carbon::parse($firstEntry->date_lab)->format('d-m-Y') }}" disabled>
                        </div>
                    </div>
                    <template x-if="{{ $firstEntry->date_lab }}">
                        <table class="table">
                            <tr>
                                <th>Pemeriksaan</th>
                                <th>Hasil</th>
                                <th>Nilai Rujukan</th>
                                <th>Satuan</th>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">Hematologi</td>
                            </tr>
                            <tr>
                                <td>Golongan Darah</td>
                                <td style="border: 1px solid">
                                    <input type="text"
                                        class="form-control-sm form-control tw-max-w-24 @error('blood_type') is-invalid @enderror"
                                        id="blood_type" value="{{ $firstEntry->blood_type }}" disabled>
                                    @error('blood_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Gula Darah Acak</td>
                                <td style="border: 1px solid">
                                    <input type="text"
                                        class="form-control-sm form-control tw-max-w-24 @error('random_blood_sugar') {{ (int) $firstEntry->random_blood_sugar < 80 || (int) $firstEntry->random_blood_sugar > 120 ? 'text-danger' : '' }} is-invalid @enderror"
                                        id="random_blood_sugar" value="{{ $firstEntry->random_blood_sugar }}"
                                        disabled>
                                    @error('random_blood_sugar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td>80-120</td>
                                <td>mg/dL</td>
                            </tr>
                            <tr>
                                <td>Hemoglobin (Umum)</td>
                                <td style="border: 1px solid">
                                    <input type="text"
                                        class="form-control-sm form-control tw-max-w-24 {{ (int) $firstEntry->hemoglobin < 12 || (int) $firstEntry->hemoglobin > 16 ? 'text-danger' : '' }} @error('hemoglobin') is-invalid @enderror"
                                        id="hemoglobin" value="{{ $firstEntry->hemoglobin }}" disabled>
                                    @error('hemoglobin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td>P: 12.0-16.0</td>
                                <td>mg/dL</td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">Serologi</td>
                            </tr>
                            <tr>
                                <td>HBSAG</td>
                                <td style="border: 1px solid">
                                    <input type="text"
                                        class="form-control-sm form-control tw-max-w-24 {{ $firstEntry->hbsag != 'Negatif' ? 'text-danger' : '' }} @error('hbsag') is-invalid @enderror"
                                        id="hbsag" value="{{ $firstEntry->hbsag }}" disabled>
                                    @error('hbsag')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td>Negatif</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>HIV</td>
                                <td style="border: 1px solid">
                                    <input type="text"
                                        class="form-control-sm form-control tw-max-w-24 {{ $firstEntry->hiv != 'Non Reaktif' ? 'text-danger' : '' }} @error('hiv') is-invalid @enderror"
                                        id="hiv" value="{{ $firstEntry->hiv }}" disabled>
                                    @error('hiv')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td>Non Reaktif</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Syphilis</td>
                                <td style="border: 1px solid">
                                    <input type="text"
                                        class="form-control-sm form-control tw-max-w-24 {{ $firstEntry->syphilis != 'Non Reaktif' ? 'text-danger' : '' }} @error('syphilis') is-invalid @enderror"
                                        id="syphilis" value="{{ $firstEntry->syphilis }}" disabled>
                                    @error('syphilis')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td>Non Reaktif</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">Urinalisa</td>
                            </tr>
                            <tr>
                                <td>Reduksi Urine</td>
                                <td style="border: 1px solid">
                                    <input type="text"
                                        class="form-control-sm form-control tw-max-w-24 {{ $firstEntry->urine_reduction != 'Negatif' ? 'text-danger' : '' }} @error('urine_reduction') is-invalid @enderror"
                                        id="urine_reduction" value="{{ $firstEntry->urine_reduction }}" disabled>
                                    @error('urine_reduction')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td>Negatif</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Protein Urine</td>
                                <td style="border: 1px solid">
                                    <input type="text"
                                        class="form-control-sm form-control tw-max-w-24 {{ $firstEntry->urine_protein != 'Negatif' ? 'text-danger' : '' }} @error('urine_protein') is-invalid @enderror"
                                        id="urine_protein" value="{{ $firstEntry->urine_protein }}" disabled>
                                    @error('urine_protein')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td>Negatif</td>
                                <td></td>
                            </tr>
                        </table>
                    </template>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row mt-3">
                <h6 class="h6">Status Generalis</h6>
                <div class="col-md-6">
                    <div class="row">
                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                                <label for="neck" class="form-label">Kesadaran Pasien</label>
                                <input type="text" class="form-control" id="patient_awareness"
                                    wire:model="patient_awareness" disabled value="{{$firstEntry->patient_awareness}}">
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="neck" class="form-label">Leher</label>
                                <input type="text" class="form-control" id="neck" disabled
                                    value="{{ $firstEntry->neck }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="head" class="form-label">Kepala</label>
                                <input type="text" class="form-control" id="head" disabled
                                    value="{{ $firstEntry->head }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="chest" class="form-label">Dada</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $firstEntry->chest }}" id="chest">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eye" class="form-label">Mata</label>
                                <input type="text" class="form-control" id="eye" disabled
                                    value="{{ $firstEntry->eye }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="abdomen" class="form-label">Abdomen</label>
                                <input type="text" class="form-control" id="abdomen" disabled
                                    value="{{ $firstEntry->abdomen }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="heart" class="form-label">Jantung</label>
                                <input type="text" class="form-control" id="heart" disabled
                                    value="{{ $firstEntry->heart }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="extremities" class="form-label">Ekstremitas</label>
                                <input type="text" class="form-control" id="extremities" disabled
                                    value="{{ $firstEntry->extremities }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lungs" class="form-label">Paru</label>
                                <input type="text" class="form-control" id="lungs" disabled
                                    value="{{ $firstEntry->lungs }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="skin" class="form-label">Kulit</label>
                                <input type="text" class="form-control" id="skin" disabled
                                    value="{{ $firstEntry->skin }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="py-5">
        <ul class="timeline">
            @foreach ($logs as $log)
                <li class="timeline-item mb-3">
                    <h5 class="efw-bold tw-text-xs">{{ $log->author }}</h5>
                    <p class="text-muted mb-2 fw-bold tw-text-xs">{{ $log->created_at->format('j F Y H:i:s') }}</p>
                    <p class="text-muted tw-text-xs">
                        {{ $log->log }}
                    </p>
                </li>
            @endforeach
        </ul>
    </section>

</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    </link>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/dayjs/dayjs.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
    <style>
        .timeline {
            border-left: 1px solid black;
            position: relative;
            list-style: none;
        }

        .timeline .timeline-item {
            position: relative;
        }

        .timeline .timeline-item:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .timeline-item:after {
            background-color: black;
            left: -38px;
            border-radius: 50%;
            height: 11px;
            width: 11px;
            content: "";
        }
    </style>
@endassets
