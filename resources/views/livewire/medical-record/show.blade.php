<x-slot:title>
    Detail Rekam Medis
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('medical-record.index') }}" wire:navigate>CPPT</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail CPPT</li>
    </x-slot:breadcrumbs>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="h6">Data Pasien</p>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table>
                                    <tr>
                                        <td class="tw-text-nowrap">Nomor RM</td>
                                        <td>: {{ $firstEntry->patient->patient_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-text-nowrap">Nama</td>
                                        <td>: {{ ucwords(strtolower($user->name)) }}</td>
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
                                        <td>: {{ $user->email ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($firstEntry->patient->status_pernikahan == 'Menikah')
                    <p class="h6 mt-2">Data Suami Pasien</p>
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
                                {{-- <button class="btn btn-primary"
                                    wire:click="$dispatch('openModal', {component:'payment.modal.medical-history', arguments:{user_id:{{ $user_id ?? 0 }}}})">
                                    Lihat Rekam Medis
                                </button> --}}
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
                                                    <p class="m-0">Sudah {{ $medicalRecords->count() }}
                                                        kali pemeriksaan
                                                    </p>
                                                </div>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                                                        $imtStatus =
                                                                                            'Normal';
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
                                                                                            noreferer
                                                                                            noopener
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
                    <div class="table-responsive">
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
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="hpht" class="form-label">HPHT</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $firstEntry && $firstEntry->hpht ? \Carbon\Carbon::parse($firstEntry->hpht)->format('d-m-Y') : null }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="interpretation_childbirth" class="form-label">Tafsiran Persalinan</label>
                                <input type="text"
                                    value="{{ $firstEntry && $firstEntry->hpht? \Carbon\Carbon::parse($firstEntry->hpht)->addDays(280)->format('d-m-Y'): null }}"
                                    class="form-control" id="interpretation_childbirth" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="age_childbirth" class="form-label">Usia Kehamilan</label>
                                <input type="text" class="form-control" disabled id="age_childbirth"
                                    value="{{ floor(\Carbon\Carbon::now()->diffInWeeks(\Carbon\Carbon::parse($firstEntry->hpht))) . ' minggu ' . \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($firstEntry->hpht)) % 7 . ' hari' }}
                                ">
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
                {{-- <div class="col-md-4">
                    <p class="h6">Riwayat Penyakit</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($medicalRecord->illnessHistories as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" align="center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <p class="h6">Riwayat Alergi</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($medicalRecord->allergyHistories as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" align="center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- <div class="card mb-3">
        <div class="card-body">
            <div class="row mt-3">
                <h6 class="h6">Status Generalis</h6>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="neck" class="form-label">Leher</label>
                                <input type="text" class="form-control" disabled value="{{ @$firstEntry->neck }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="head" class="form-label">Kepala</label>
                                <input type="text" class="form-control" disabled value="{{ @$firstEntry->head }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="chest" class="form-label">Dada</label>
                                <input type="text" class="form-control" disabled value="{{ @$firstEntry->chest }}"
                                    id="chest">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="eye" class="form-label">Mata</label>
                                <input type="text" class="form-control" disabled value="{{ @$firstEntry->eye }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="abdomen" class="form-label">Abdomen</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ @$firstEntry->abdomen }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="heart" class="form-label">Jantung</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ @$firstEntry->heart }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="extremities" class="form-label">Ekstremitas</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ @$firstEntry->extremities }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="lungs" class="form-label">Paru</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ @$firstEntry->lungs }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="skin" class="form-label">Kulit</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ @$firstEntry->skin }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                {{-- <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Keluhan Utama</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $firstEntry->main_complaint }}</textarea>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-6">

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
                                    @foreach ($firstEntry->patient->familyIlnessHistories ?? [] as $key => $f)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $f->name }}</td>
                                            <td>{{ $f->relationship }}</td>
                                            <td>{{ $f->disease_name }}</td>
                                        </tr>
                                    @endforeach
                                    @if ($firstEntry)
                                        @if ($firstEntry->patient->familyIlnessHistories->count() == 0)
                                            <tr>
                                                <td colspan="5" align="center">Tidak ada data</td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">Tidak ada data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="d-flex justify-content-between">
                            <h6 class="h6">Riwayat Alergi</h6>

                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Alergi</th>
                                    <th>Tanda & Gejala</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($firstEntry->patient->allergyHistories ?? [] as $key => $a)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $a->name }}</td>
                                        <td>{{ $a->pivot->indication }}</td>
                                    </tr>
                                @endforeach
                                @if ($firstEntry)
                                    @if ($firstEntry->patient->allergyHistories->count() == 0)
                                        <tr>
                                            <td colspan="5" align="center">Tidak ada data</td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td colspan="5" align="center">Tidak ada data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div>
                        <div class="d-flex justify-content-between">
                            <h6 class="h6">Riwayat Penyakit Terdahulu</h6>

                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyakit Terdahulu</th>
                                    <th>Terapi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($firstEntry->patient->illnessHistories ?? [] as $key => $i)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $i->name }}</td>
                                        <td>{{ $i->pivot->therapy }}</td>
                                    </tr>
                                @endforeach
                                @if ($firstEntry)
                                    @if ($firstEntry->patient->illnessHistories->count() == 0)
                                        <tr>
                                            <td colspan="5" align="center">Tidak ada data</td>
                                        </tr>
                                    @endif
                                @else
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
    {{-- <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Nomor MR</label>
                                <input type="text" class="form-control" id="address" disabled
                                    placeholder="Otomatis dari sistem"
                                    value="{{ $medicalRecord->medical_record_number }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="text" class="form-control" id="date"
                                    value="{{ Carbon\Carbon::parse($medicalRecord->date)->format('d-m-Y') }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Perawat</label>
                                <input type="text" class="form-control" id="date"
                                    value="{{ $medicalRecord->nurse->name }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card mb-3">
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-subjective" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true"><i class="fa-solid fa-s"></i> Subjective</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-objective" type="button" role="tab"
                        aria-controls="pills-profile" aria-selected="false"><i class="fa-solid fa-o"></i>
                        Objective</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-assessment" type="button" role="tab"
                        aria-controls="pills-profile" aria-selected="false"><i class="fa-solid fa-a"></i>
                        Assessment</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-plan" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false"><i class="fa-solid fa-p"></i> Plan</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-subjective" role="tabpanel"
                    aria-labelledby="pills-home-tab" tabindex="0">
                    <p class="h6">Anamnesa</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="subjective_summary" class="form-label">Subjective</label>
                                <textarea type="text" class="form-control" disabled id="subjective_summary" rows="5">{{ $medicalRecord->subjective_summary }}</textarea>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="mb-3">
                                <label for="gravida" class="form-label">Gravida</label>
                                <input type="text" class="form-control" disabled id="gravida"
                                    value="{{ $medicalRecord->gravida }}">
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="hpht" class="form-label">HPHT</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ \Carbon\Carbon::parse($medicalRecord->hpht)->format('d-m-Y') }}">
                            </div>

                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="para" class="form-label">Para</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $medicalRecord->para }}">
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="interpretation_childbirth" class="form-label">Tafsiran Persalinan</label>
                                <input type="text"
                                    value="{{ \Carbon\Carbon::parse($medicalRecord->hpht)->addDays(280)->format('d-m-Y') }}"
                                    class="form-control" id="interpretation_childbirth" disabled>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="abbortion" class="form-label">Abortion/Misscarriage</label>
                                <input type="text" class="form-control" disabled id="abbortion"
                                    value="{{ $medicalRecord->abbortion }}">
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="age_childbirth" class="form-label">Usia Kehamilan</label>
                                <input type="text" class="form-control" disabled id="age_childbirth"
                                    value="{{ floor(\Carbon\Carbon::now()->diffInWeeks(\Carbon\Carbon::parse($medicalRecord->hpht))) . ' minggu ' . \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($medicalRecord->hpht)) % 7 . ' hari' }}
                                    ">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <div class="mb-3" @class(['d-none' => $medicalRecord->para == 0])>
                                <label for="hidup" class="form-label">Hidup</label>
                                <input type="text" class="form-control" disabled id="hidup"
                                    value="{{ $medicalRecord->hidup }}">
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <div class="mb-3" @class(['d-none' => $medicalRecord->para == 0])>
                                <label for="birth_description" class="form-label">Rincian</label>
                                <input type="text" disabled value="{{ $medicalRecord->birth_description }}"
                                    class="form-control" id="birth_description">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Riwayat Penyakit</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $medicalRecord->illnessHistories->pluck('name')->join(', ') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Riwayat Alergi</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $medicalRecord->allergyHistories->pluck('name')->join(', ') }}">
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Keluhan Utama</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $medicalRecord->registration->complaints ?? null }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Riwayat Lainnya</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $medicalRecord->other_history }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <h6 class="h6">Riwayat Vaksin</h6>

                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Vaksin</th>
                                        <th>Jenis/Merk Vaksin</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($medicalRecord->user->vaccines as $ov)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ov->name }}</td>
                                            <td>{{ $ov->brand }}</td>
                                            <td>{{ $ov->date }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" align="center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                            </table>
                        </div> --}}
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-objective" role="tabpanel" aria-labelledby="pills-profile-tab"
                    tabindex="0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-12">
                                <p class="h6">Pemeriksaan Fisik</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="patient_awareness" class="form-label">Kesadaran Pasien</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $medicalRecord->patient_awareness }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="body_temperature" class="form-label">Suhu Tubuh</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->body_temperature }}" disabled
                                                id="body_temperature">
                                            <span class="input-group-text" id="basic-addon1">
                                                <sup>o</sup>C
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="height" class="form-label">Tinggi Badan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="height" disabled
                                                value="{{ $medicalRecord->height }}">
                                            <span class="input-group-text" id="basic-addon1">
                                                cm
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="weight" class="form-label">Berat Badan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" disabled
                                                value="{{ $medicalRecord->weight }}" id="weight">
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
                                            <input type="text" class="form-control" disabled
                                                value="{{ $medicalRecord->sistole }}" id="sistole">
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
                                            <input type="text" disabled value="{{ $medicalRecord->diastole }}"
                                                class="form-control" id="diastole">
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
                                            <input type="text" class="form-control" disabled
                                                value="{{ $medicalRecord->pulse }}" id="pulse">
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
                                            <input type="text" class="form-control" disabled
                                                value="{{ $medicalRecord->respiratory_frequency }}"
                                                id="respiratory_frequency">
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
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->weight && $medicalRecord->height ? round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) : 0 }}"
                                                id="bmi" disabled>
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
                                            @if ($medicalRecord->weight && $medicalRecord->height) @if (round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) >= 40.0) value="Obese Class III"
                                            @elseif (round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) >= 35.0 &&
                                                    round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) <= 39.99)
                                            value="Obese Class II"
                                            @elseif (round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) >= 30.0 &&
                                                    round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) <= 34.99)
                                            value="Obese Class I"
                                            @elseif (round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) >= 25.0 &&
                                                    round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) <= 29.99)
                                            value="Overweight"
                                            @elseif (round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) >= 18.5 &&
                                                    round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) <= 24.99)
                                            value="Normal"
                                            @elseif (round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) >= 17.0 &&
                                                    round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) <= 18.49)
                                            value="Underweight"
                                            @elseif (round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) >= 16.0 &&
                                                    round($medicalRecord->weight / pow($medicalRecord->height / 100, 2), 2) <= 16.99)
                                            value="Severely Underweight"
                                            @else
                                            value="Very Severely Underweight" @endif
                                        @else value="Very Severely Underweight" @endif>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Keterangan
                                            Tambahan</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $medicalRecord->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- <div class="col-12">
                                <p class="h6">Hasil USG</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ga" class="form-label">Gestational Age (GA)</label>
                                        <input type="text" class="form-control" disabled id="ga"
                                            value="{{ $medicalRecord->ga }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gs" class="form-label">Gestational Sac (GS)</label>
                                        <input type="text" class="form-control" disabled id="gs"
                                            value="{{ $medicalRecord->gs }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="crl" class="form-label">Crown Rump Length (CRL)</label>
                                        <input type="text" class="form-control" disabled id="crl"
                                            value="{{ $medicalRecord->crl }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bpd" class="form-label">Biparietal Diameter (BPD)</label>
                                        <input type="text" class="form-control" disabled id="bpd"
                                            value="{{ $medicalRecord->bpd }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="ac" class="form-label">Abdominal Circumferencial
                                            (AC)</label>
                                        <input type="text" class="form-control" disabled id="ac"
                                            value="{{ $medicalRecord->ac }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="hc" class="form-label">Femur Lenght (FL)</label>
                                        <input type="text" class="form-control" disabled id="hc"
                                            value="{{ $medicalRecord->fl }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="fhr" class="form-label">Fetal Hearth Rate (FHR)</label>
                                        <input type="text" class="form-control" disabled id="fhr"
                                            value="{{ $medicalRecord->fhr }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="fw" class="form-label">Estimated Fetal Weight (EFW)</label>
                                        <input type="text" class="form-control" disabled id="fw"
                                            value="{{ $medicalRecord->efw }}">
                                    </div>
                                </div>
                            </div> --}}
                            @if ($medicalRecord->date_lab != null)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date_lab" class="form-label">Tanggal Pemeriksaan</label>
                                        <input type="text" class="form-control" disabled id="date_lab"
                                            value="{{ $medicalRecord->date_lab }}">
                                    </div>
                                </div>
                            </div>
                                <div class="col-12">
                                    <table class="table w-100">
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
                                            <td style="min-width: 100px">
                                                <input type="text" disabled
                                                    class="form-control-sm form-control tw-max-w-24" id="blood_type"
                                                    value="{{ $medicalRecord->blood_type }}">
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Gula Darah Acak</td>
                                            <td style="min-width: 100px">
                                                <input type="text" disabled
                                                    class="form-control-sm form-control {{ (int) $medicalRecord->random_blood_sugar < 80 || (int) $medicalRecord->random_blood_sugar > 120 ? 'text-danger' : '' }} tw-max-w-24"
                                                    id="random_blood_sugar"
                                                    value="{{ $medicalRecord->random_blood_sugar }}">
                                            </td>
                                            <td>80-120</td>
                                            <td>mg/dL</td>
                                        </tr>
                                        <tr>
                                            <td>Hemoglobin (Umum)</td>
                                            <td style="min-width: 100px">
                                                <input type="text" disabled
                                                    class="form-control-sm form-control tw-max-w-24"
                                                    {{ (int) $medicalRecord->hemoglobin < 12 || (int) $medicalRecord->hemoglobin > 16 ? 'text-danger' : '' }}
                                                    id="hemoglobin" value="{{ $medicalRecord->hemoglobin }}">
                                            </td>
                                            <td>P: 12.0-16.0</td>
                                            <td>mg/dL</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="center">Serologi</td>
                                        </tr>
                                        <tr>
                                            <td>HBSAG</td>
                                            <td style="min-width: 100px">
                                                <input type="text" disabled
                                                    class="form-control-sm form-control tw-max-w-24"
                                                    {{ $medicalRecord->hbsag != 'Negatif' ? 'text-danger' : '' }}
                                                    id="hbsag" value="{{ $medicalRecord->hbsag }}">
                                            </td>
                                            <td>Negatif</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>HIV</td>
                                            <td style="min-width: 100px">
                                                <input type="text" disabled
                                                    class="form-control-sm form-control tw-max-w-24 {{ $medicalRecord->hiv != 'Non Reaktif' ? 'text-danger' : '' }}"
                                                    id="hiv" value="{{ $medicalRecord->hiv }}">
                                            </td>
                                            <td>Non Reaktif</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Syphilis</td>
                                            <td style="min-width: 100px">
                                                <input type="text" disabled
                                                    class="form-control-sm form-control tw-max-w-24 {{ $medicalRecord->syphilis != 'Non Reaktif' ? 'text-danger' : '' }}"
                                                    id="syphilis" value="{{ $medicalRecord->syphilis }}">
                                            </td>
                                            <td>Non Reaktif</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="center">Urinalisa</td>
                                        </tr>
                                        <tr>
                                            <td>Reduksi Urine</td>
                                            <td style="min-width: 100px">
                                                <input type="text" disabled
                                                    class="form-control-sm form-control tw-max-w-24 {{ $medicalRecord->urine_reduction != 'Negatif' ? 'text-danger' : '' }}"
                                                    id="urine_reduction"
                                                    value="{{ $medicalRecord->urine_reduction }}">
                                            </td>
                                            <td>Negatif</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Protein Urine</td>
                                            <td style="min-width: 100px">
                                                <input type="text" disabled
                                                    class="form-control-sm form-control tw-max-w-24 {{ $medicalRecord->urine_protein != 'Negatif' ? 'text-danger' : '' }}"
                                                    id="urine_protein" value="{{ $medicalRecord->urine_protein }}">
                                            </td>
                                            <td>Negatif</td>
                                            <td></td>
                                        </tr>
                                        {{-- <tr>
                                        <td>pH</td>
                                        <td style="min-width: 100px">
                                            <input type="text" disabled
                                                class="form-control-sm form-control tw-max-w-24" id="ph"
                                                value="{{ $medicalRecord->ph }}">
                                        </td>
                                        <td>4,6 - 8,0</td>
                                        <td></td>
                                    </tr> --}}
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-md-6">
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
                                    @forelse ($medicalRecord->usgs as $ou)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ou->usg_id }}</td>
                                            <td>{{ $ou->date }}</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $ou->file) }}" class="text-link"
                                                    noreferer noopener target="_blank">Lihat File</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" align="center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> --}}


                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <p class="h6">Hasil Lab</p>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pemeriksaan</th>
                                        <th>Tanggal</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($medicalRecord->checks as $oc)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $oc->type }}</td>
                                            <td>{{ $oc->date }}</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $oc->file) }}" class="text-link"
                                                    noreferer noopener target="_blank">Lihat File</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" align="center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-assessment" role="tabpanel" aria-labelledby="pills-profile-tab"
                    tabindex="0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Diagnosa</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $medicalRecord->diagnose }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Kesimpulan</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $medicalRecord->summary }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-plan" role="tabpanel" aria-labelledby="pills-profile-tab"
                    tabindex="0">
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12">
                                    {{-- <div class="col-md-6"> --}}
                    {{-- <div class="mb-3">
                                        <label for="next_control" class="form-label">Catatan</label>
                                        <textarea type="text" class="form-control" disabled id="next_control" rows="5">{{ $medicalRecord->other_summary }}</textarea>
                                    </div> --}}
                    {{-- </div> --}}
                    {{-- <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="next_control" class="form-label">Periksa
                                                Berikutnya</label>
                                            <input type="text" class="form-control" disabled id="next_control"
                                                value="{{ \Carbon\Carbon::parse($medicalRecord->next_control)->format('d-m-Y') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="plan_note" class="form-label">Plan</label>
                                <textarea class="form-control" id="plan_note" rows="3" disabled>{{ $medicalRecord->plan_note }}</textarea>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
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
                        </div> --}}
                        {{-- <div class="col-md-4">
                        {{-- <div class="col-md-4">
                            <p class="h5">Laborate</p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lab</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ([] as $key=> $a)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $a->where('field', 'name')->first()->value }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="delete({{ $key }})">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" align="center">Data tidak ada</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <p class="h5">Obat</p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Obat</th>
                                        <th>Jumlah</th>
                                        <th>Aturan Pakai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($medicalRecord->drugMedDevs as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->name }}</td>
                                            <td>{{ $d->pivot->total }}</td>
                                            <td>{{ $d->pivot->rule }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" align="center">Data tidak ada</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        </div> --}}

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
