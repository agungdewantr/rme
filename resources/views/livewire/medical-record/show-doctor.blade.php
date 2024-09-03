<x-slot:title>
    Detail Rekam Medis
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" readonly wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('medical-record.index') }}" readonly wire:navigate>CPPT</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail CPPT</li>
    </x-slot:breadcrumbs>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="h6 fw-bold">Data Pasien</p>
                    <div class="row">
                        <div class="col">
                            <table>
                                <tr>
                                    <td class="tw-text-nowrap">Nomor RM</td>
                                    <td>: {{ $user->patient->patient_number }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Nama</td>
                                    <td>: {{ ucwords(strtolower($user->name)) }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Tanggal Lahir</td>
                                    <td>:
                                        {{ Carbon\Carbon::parse($user->patient->dob)->format('d M Y') . ' (' . $age->format('%y tahun') . ')' }}
                                    </td>
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
                    @if($firstEntry->patient->status_pernikahan == 'Menikah')
                    <p class="h6 mt-2 fw-bold">Data Suami Pasien</p>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
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
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-start">
                                <button type="button" class="tw-btn tw-bg-[#68FFA1] tw-text-black tw-px-4 tw-py-2 tw-rounded tw-mt-4"
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
                                                    <p class="m-0">Sudah {{ $oldMedicalRecords->count() }}
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
                                                            @forelse ($oldMedicalRecords ?? [] as $mr)
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
                                                                                                {{ '- ' . $a->name }} <span class="fst-italic">({{$a->pivot->total}}) {{$a->pivot->rule}}</span>
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
                                                                            {{-- @if ($mr->date_lab != null)
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
                                <input type="text" class="form-control"
                                    value="{{ $firstEntry && $firstEntry->hpht ? \Carbon\Carbon::parse($firstEntry->hpht)->format('d-m-Y') : null }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="interpretation_childbirth" class="form-label">Tafsiran Persalinan</label>
                                <input type="text" class="form-control "
                                    value="{{ $firstEntry && $firstEntry->hpht? \Carbon\Carbon::parse($firstEntry->hpht)->addDays(280)->format('d-m-Y'): null }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="age_childbirth" class="form-label">Usia Kehamilan</label>
                                <input type="text" class="form-control" disabled id="age_childbirth"
                                    value="{{ floor(\Carbon\Carbon::now()->diffInWeeks(\Carbon\Carbon::parse($firstEntry->hpht))) . ' minggu ' . floor(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($firstEntry->hpht))) % 7 . ' hari' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Perhatian Khusus</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $firstEntry->specific_attention }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Hasil Lab:
                            </label>
                            @if($firstEntry->date_lab)
                            <div class="row">
                                    <p>Tanggal Pemeriksaan : {{  \Carbon\Carbon::parse($firstEntry->date_lab)->format('d-m-Y') }}</p>
                                    <div class="col-md-6">
                                       <p> Goldar : {{ $firstEntry->blood_type ?? '-' }}</p>
                                       <p> Gula Darah Acak : {{ $firstEntry->random_blood_sugar ? $firstEntry->random_blood_sugar . 'mg/dL' : '-' }}</p>
                                       <p>Hemoglobin (Umum) : {{ $firstEntry->hemoglobin ? $firstEntry->hemoglobin . 'mg/dL' : '-' }}</p>
                                       <p>HBSAG : {{ $firstEntry->hbsag }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>HIV : {{ $firstEntry->hiv ?? '-' }}</p>
                                        <p>Syphilis : {{ $firstEntry->syphilis ?? '-' }}</p>
                                        <p>Reduksi Urine: {{ $firstEntry->urine_reduction ?? '-'}}</p>
                                        <p>Protein Urine: {{ $firstEntry->urine_protein ?? '-'}}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="row">
            <div class="col-md-4">
                <div class="card-body">
                    <p class="h5">SOAP</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Subjective</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled>{{ $subjective_summary }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Objective</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled>{{ $objective_summary }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Assessment</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled>{{ $assessment_summary }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Plan</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled>{{ $medicalRecord->other_summary }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            {{-- <div class="row">
                                <p class="h6">Hasil USG</p>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ga" class="form-label">Gestational Age (GA)</label>
                                        <input type="text" class="form-control @error('ga') is-invalid @enderror"
                                            id="ga" readonly value="{{ $medicalRecord->ga }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gs" class="form-label">Gestational Sac (GS)</label>
                                        <input type="text" class="form-control @error('gs') is-invalid @enderror"
                                            id="gs" readonly value="{{ $medicalRecord->gs }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="crl" class="form-label">Crown Rump Length (CRL)</label>
                                        <input type="text" class="form-control @error('crl') is-invalid @enderror"
                                            id="crl" readonly value="{{ $medicalRecord->crl }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bpd" class="form-label">Biparietal Diameter (BPD)</label>
                                        <input type="text" class="form-control @error('bpd') is-invalid @enderror"
                                            id="bpd" readonly value="{{ $medicalRecord->bpd }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ac" class="form-label">Abdominal Circumferencial
                                            (AC)</label>
                                        <input type="text" class="form-control @error('ac') is-invalid @enderror"
                                            id="ac" readonly value="{{ $medicalRecord->ac }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="fl" class="form-label">Femur Lenght (FL)</label>
                                        <input type="text" class="form-control @error('fl') is-invalid @enderror"
                                            id="fl" readonly value="{{ $medicalRecord->fl }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="fhr" class="form-label">Fetal Hearth Rate (FHR)</label>
                                        <input type="text" class="form-control @error('fhr') is-invalid @enderror"
                                            id="fhr" readonly value="{{ $medicalRecord->fhr }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="efw" class="form-label">Estimated Fetal Weight (EFW)</label>
                                        <input type="text" class="form-control @error('efw') is-invalid @enderror"
                                            id="efw" readonly value="{{ $medicalRecord->efw }}">
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- <div>
                            <div class="d-flex justify-content-between">
                                <p class="h6">Hasil USG</p>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID USG</th>
                                        <th>Tanggal</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medicalRecord->usgs as $ou)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ou->usg_id }}</td>
                                            <td>{{ $ou->date }}</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $ou->file) }}" class="text-link"
                                                    noreferer noopener target="_blank">Lihat File</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($medicalRecord->usgs->count() == 0)
                                        <tr>
                                            <td colspan="5" align="center">Tidak ada data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div> --}}

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card-body">
                    <p class="h5">Medical History</p>
                    <p class="text-primary">Sudah periksa {{ $oldMedicalRecords->count() }} kali</p>
                    <div style="max-height: 600px; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Cabang <br>Tanggal, <br>Dokter/Perawat</th>
                                    <th>Rekam Medis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($oldMedicalRecords ?? [] as $omr)

                                    <tr :key="rand()" style="border: 1px solid">
                                        <td>
                                            Cabang : {{ $omr->registration->branch->name }} <br>
                                            Tanggal : {{ Carbon\Carbon::parse($omr->date)->format('d-m-Y') }} <br>
                                            Dokter : {{ isset($omr->doctor) ? $omr->doctor->name : '' }} <br>

                                        </td>
                                        <td>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div>
                                                            <span class="text-primary">Subjective :</span> <br>
                                                            {{ $omr->subjective_summary ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div>
                                                            <span class="text-primary">Objective :</span> <br>
                                                            <table>
                                                                <tr>
                                                                    <td>TD</td>
                                                                    <td>: {{ $omr->sistole }}/{{ $omr->diastole }}
                                                                    </td>
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
                                                                @php
                                                                    try {
                                                                        $imt = number_format(
                                                                            $omr->weight / pow($omr->height / 100, 2),
                                                                            '0',
                                                                            ',',
                                                                            '.',
                                                                        );
                                                                    } catch (\Throwable $th) {
                                                                        $imt = 0;
                                                                    }
                                                                    if ($imt >= 40.0) {
                                                                        $imtStatus = 'Obese Class III';
                                                                    } elseif ($imt >= 35.0 && $imt <= 39.99) {
                                                                        $imtStatus = 'Obese Class II';
                                                                    } elseif ($imt >= 30.0 && $imt <= 34.99) {
                                                                        $imtStatus = 'Obese Class I';
                                                                    } elseif ($imt >= 25.0 && $imt <= 29.99) {
                                                                        $imtStatus = 'Overweight';
                                                                    } elseif ($imt >= 18.5 && $imt <= 24.99) {
                                                                        $imtStatus = 'Normal';
                                                                    } elseif ($imt >= 17.0 && $imt <= 18.49) {
                                                                        $imtStatus = 'Underweight';
                                                                    } elseif ($imt >= 16.0 && $imt <= 16.99) {
                                                                        $imtStatus = 'Severely Underweight';
                                                                    } else {
                                                                        $imtStatus = 'Very Severely Underweight';
                                                                    }
                                                                @endphp
                                                                <tr>
                                                                    <td>BMI</td>
                                                                    <td>: {{ $imt . '/' . $imtStatus }}</td>
                                                                </tr>
                                                            </table>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        {{-- <div>
                                                    <span class="text-primary">Hasil USG :</span> <br>
                                                    <table>
                                                        <tr>
                                                            @foreach ($omr->usgs as $u)
                                                                <a href="{{ asset('storage/' . $u->file) }}"
                                                                    class="btn btn-primary btn-sm" noreferer noopener
                                                                    target="_blank">Lihat File</a>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            <td>FL</td>
                                                            <td>: {{ $omr->fl }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>GS</td>
                                                            <td>: {{ $omr->gs }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>FHR</td>
                                                            <td>: {{ $omr->fhr }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>CRL</td>
                                                            <td>: {{ $omr->crl }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>EFW</td>
                                                            <td>: {{ $omr->efw }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>BPD</td>
                                                            <td>: {{ $omr->bpd }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>AC</td>
                                                            <td>: {{ $omr->ac }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>EDD</td>
                                                            <td>: {{ $omr->edd }}</td>
                                                        </tr>
                                                    </table>

                                                </div> --}}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div>
                                                            <span class="text-primary">Asesmen :</span> <br>
                                                            {{ $omr->assessment_summary ?? '-' }} <br>
                                                            {{ $omr->description }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div>
                                                            <span class="text-primary">Plan :</span> <br>
                                                            <p>{{ $omr->other_summary ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container">
                                                <div class="row">
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
                                                            <span class="text-primary">Obat :</span> <br>
                                                            @foreach ($omr->drugMedDevs as $a)
                                                                {{ '- ' . $a->name }} <span class="fst-italic">({{$a->pivot->total}}) {{$a->pivot->rule}}</span> <br>
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
                                            </div>

                                            <br><br>



                                        </td>
                                    </tr>
                                    <tr :key="rand()" style="border: 1px solid">
                                        <td>
                                            Tanggal : {{ Carbon\Carbon::parse($omr->date)->format('d-m-Y') }} <br>
                                            Perawat : {{ $omr->nurse->name ?? '' }} <br><br>

                                        </td>
                                        <td>
                                            <div class="container">
                                                <div class="row">
                                                    {{-- <div class="col-md-3">
                                                        <div>
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

                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-3">
                                                        <div>
                                                            <span class="text-primary">Asesmen :</span> <br>
                                                            {{ $omr->diagnose ?? '-' }} <br>
                                                            {{ $omr->summary }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div>
                                                            <span class="text-primary">Plan :</span> <br>
                                                            {{ $omr->plan_note ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div>
                                                            <span class="text-primary">Perhatian Khusus :</span> <br>
                                                            {{ $omr->firstEntry->specific_attention ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



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
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <p class="h5">Rencana Perawatan</p>
                    <div class="col-12">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="next_control" class="form-label">Periksa
                                    Berikutnya</label>
                                <input type="text" date-picker readonly wire:ignore
                                    class="form-control @error('next_control') is-invalid @enderror" id="next_control"
                                    value="{{ $medicalRecord->next_control }}" disabled>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <p class="h5">Tindakan</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($medicalRecord->actions as $a)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $a->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" align="center">Data tidak ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                    <div class="col-lg-4 col-md-6">
                        <p class="h5">Resep</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat</th>
                                    <th>Jumlah</th>
                                    <th>Aturan Pakai</th>
                                    <th>Cara Pakai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($medicalRecord->drugMedDevs as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->pivot->total }}</td>
                                        <td>{{ $d->pivot->rule }}</td>
                                        <td>{{ $d->pivot->how_to_use }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" align="center">Data tidak ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <p class="h5">Laborate</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lab</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($medicalRecord->laborate as $key=> $a)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $a->name }}</td>
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
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    {{ $medicalRecord->date_lab ? 'checked disabled' : '' }} id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Hasil Lab
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mt-1 {{ !$medicalRecord->date_lab ? 'tw-invisible' : '' }}">
                            <div class="mb-3">
                                <label for="date_lab" class="form-label">Tanggal Pemeriksaan Lab</label>
                                <input type="text" date-picker
                                    class="form-control @error('date_lab') is-invalid @enderror"
                                    value="{{ Carbon\Carbon::parse($medicalRecord->date_lab)->format('d-m-Y') }}"
                                    disabled>
                            </div>
                        </div>
                        <template x-if="{{ $medicalRecord->date_lab }}">
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
                                            id="blood_type" value="{{ $medicalRecord->blood_type }}" disabled>
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
                                            class="form-control-sm form-control tw-max-w-24 @error('random_blood_sugar') {{ (int) $medicalRecord->random_blood_sugar < 80 || (int) $medicalRecord->random_blood_sugar > 120 ? 'text-danger' : '' }} is-invalid @enderror"
                                            id="random_blood_sugar" value="{{ $medicalRecord->random_blood_sugar }}"
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
                                            class="form-control-sm form-control tw-max-w-24 {{ (int) $medicalRecord->hemoglobin < 12 || (int) $medicalRecord->hemoglobin > 16 ? 'text-danger' : '' }} @error('hemoglobin') is-invalid @enderror"
                                            id="hemoglobin" value="{{ $medicalRecord->hemoglobin }}" disabled>
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
                                            class="form-control-sm form-control tw-max-w-24 {{ $medicalRecord->hbsag != 'Negatif' ? 'text-danger' : '' }} @error('hbsag') is-invalid @enderror"
                                            id="hbsag" value="{{ $medicalRecord->hbsag }}" disabled>
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
                                            class="form-control-sm form-control tw-max-w-24 {{ $medicalRecord->hiv != 'Non Reaktif' ? 'text-danger' : '' }} @error('hiv') is-invalid @enderror"
                                            id="hiv" value="{{ $medicalRecord->hiv }}" disabled>
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
                                            class="form-control-sm form-control tw-max-w-24 {{ $medicalRecord->syphilis != 'Non Reaktif' ? 'text-danger' : '' }} @error('syphilis') is-invalid @enderror"
                                            id="syphilis" value="{{ $medicalRecord->syphilis }}" disabled>
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
                                            class="form-control-sm form-control tw-max-w-24 {{ $medicalRecord->urine_reduction != 'Negatif' ? 'text-danger' : '' }} @error('urine_reduction') is-invalid @enderror"
                                            id="urine_reduction" value="{{ $medicalRecord->urine_reduction }}"
                                            disabled>
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
                                            class="form-control-sm form-control tw-max-w-24 {{ $medicalRecord->urine_protein != 'Negatif' ? 'text-danger' : '' }} @error('urine_protein') is-invalid @enderror"
                                            id="urine_protein" value="{{ $medicalRecord->urine_protein }}" disabled>
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
