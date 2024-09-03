<x-slot:title>
    Daftar Rekam Medis
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('medical-record.index') }}" wire:navigate>CPPT</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah CPPT</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <button class="btn btn-primary" wire:loading.attr="disabled" wire:click="save">
            <i wire:loading class="fa-solid fa-spinner tw-animate-spin"></i>
            Simpan
        </button>
    </x-slot:button>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if ($user)
                        <span
                            class="tw-bg-blue-100 tw-text-blue-800 tw-text-s tw-font-medium tw-me-2 tw-px-2.5 tw-py-0.5 tw-rounded tw-dark:bg-gray-700 tw-dark:text-blue-400 tw-border tw-border-blue-400">Waktu
                            CPPT : {{ $timestamp }}</span>
                        <p class="h6 mt-3">Data Pasien</p>
                        <div class="row">
                            <div class="col">
                                <table>
                                    <tr>
                                        <td class="tw-text-nowrap">Nomor RM</td>
                                        <td>: {{ $user->patient->patient_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-text-nowrap">Nama</td>
                                        <td>: <button
                                                wire:click="$dispatch('openModal', {component:'medical-record.detail-patient',arguments:{uuid:'{{ $user->patient->uuid }}'}})"
                                                class="text-info"
                                                title="Detail Pasien">{{ ucwords(strtolower($user->name)) }}</button>
                                        </td>
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
                        @if($user->patient->status_pernikahan == 'Menikah')
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
                                                                                <br>
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
                                                                                    <p>Plan:</p>
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
                    @else
                        <div class="col-md-11">
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <div wire:ignore class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                    <input type="text" wire:model.live="date" date-picker name="date"
                                        id="date" class="form-control @error('date') is-invalid @enderror">
                                    @error('date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-11 mt-3">
                            <div class="mb-3" wire:ignore>
                                <label for="user_id" class="form-label">Nama Pasien</label>
                                <select class="form-select select2 @error('user_id') is-invalid @enderror"
                                    id="user_id" name="user_id" style="width: 100%"
                                    aria-label="Default select example" wire:model.live="user_id">
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
                                <input type="text" date-picker disabled class="form-control"
                                    value="{{ $firstEntry && $firstEntry->hpht ? \Carbon\Carbon::parse($firstEntry->hpht)->format('d-m-Y') : '' }}">
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
                                    value="{{ $firstEntry && $firstEntry->hpht? \Carbon\Carbon::parse($firstEntry->hpht)->addDays(280)->format('d-m-Y'): '' }}"
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Perhatian Khusus</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $firstEntry ? $firstEntry->specific_attention : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Hasil Lab:
                                @if($user)
                                <button type="button"   data-bs-toggle="modal" data-bs-target="#editHasilLabModal"
                                    data-bs-placement="bottom" data-bs-title="Edit Hasil Lab" class="tw-bg-yellow-500 tw-text-black tw-text-xs tw-px-2 tw-py-1 tw-rounded">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                @endif
                            </label>
                            @if($user && $firstEntry->date_lab)
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

                <div class="modal fade" id="editHasilLabModal" tabindex="-1" aria-labelledby="exampleModalLabel" wire:ignore data-bs-backdrop="static" data-bs-keyboard="false"
                x-data="{
                    blood_type: @entangle('blood_type_fe'),
                    random_blood_sugar: @entangle('random_blood_sugar_fe'),
                    hemoglobin: @entangle('hemoglobin_fe'),
                    hbsag: @entangle('hbsag_fe'),
                    hiv: @entangle('hiv_fe'),
                    syphilis: @entangle('syphilis_fe'),
                    urine_reduction: @entangle('urine_reduction_fe'),
                    urine_protein: @entangle('urine_protein_fe'),
                    updateLabFirstEntry() {
                        $wire.updateLabFirstEntry();
                        $('#editHasilLabModal').modal('hide');
                    }
                }">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Form Edit Hasil Lab</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mt-1">
                                    <div class="mb-3">
                                        <label for="date_lab" class="form-label">Tanggal Pemeriksaan Lab</label>
                                        <input type="text" date-picker
                                               class="form-control @error('date_lab_fe') is-invalid @enderror" id="date_lab_fe"
                                               wire:model="date_lab_fe">
                                        @error('date_lab_fe')
                                               <div class="invalid-feedback">
                                                   {{ $message }}
                                               </div>
                                        @enderror
                                    </div>
                                </div>
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
                                            <select class="form-select @error('blood_type') is-invalid @enderror"
                                                    id="blood_type" name="blood_type" aria-label="Default select example"
                                                    wire:model="blood_type">
                                                <option selected>Pilih Golongan darah</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="Belum diidentifikasi">Belum diidentifikasi</option>
                                            </select>
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
                                                   class="form-control-sm form-control tw-max-w-24 @error('random_blood_sugar') is-invalid @enderror"
                                                   id="random_blood_sugar" x-model="random_blood_sugar" pattern="[0-9.]*"
                                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                                   :class="{ 'text-danger': random_blood_sugar < 80 || random_blood_sugar > 120 }">
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
                                                   class="form-control-sm form-control tw-max-w-24 @error('hemoglobin') is-invalid @enderror"
                                                   id="hemoglobin" x-model="hemoglobin" pattern="[0-9.]*"
                                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                                   :class="{ 'text-danger': hemoglobin < 12 || hemoglobin > 16 }">
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
                                            <select name="hbsag" id="hbsag" x-model="hbsag"
                                                    class="form-control @error('hbsag') is-invalid @enderror"
                                                    :class="{ 'text-danger': hbsag == 'Reaktif' }">
                                                <option value="">Pilih HBSAG</option>
                                                <option value="Reaktif">Reaktif</option>
                                                <option value="Non Reaktif">Non Reaktif</option>
                                                <option value="Belum Dilakukan">Belum Dilakukan</option>
                                            </select>
                                            {{-- <input type="text"
                                                                class="form-control-sm form-control tw-max-w-24 @error('hbsag') is-invalid @enderror"
                                                                id="hbsag" wire:model="hbsag"> --}}
                                            @error('hbsag')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </td>
                                        <td>Non Reaktif</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>HIV</td>
                                        <td style="border: 1px solid">
                                            <select name="hiv" id="hiv" x-model="hiv"
                                                    class="form-control @error('hiv') is-invalid @enderror"
                                                    :class="{ 'text-danger': hiv == 'Reaktif' }">
                                                <option value="">Pilih HIV</option>
                                                <option value="Reaktif">Reaktif</option>
                                                <option value="Non Reaktif">Non Reaktif</option>
                                                <option value="Belum Dilakukan">Belum Dilakukan</option>
                                            </select>
                                            {{-- <input type="text"
                                                                class="form-control-sm form-control tw-max-w-24 @error('hiv') is-invalid @enderror"
                                                                id="hiv" wire:model="hiv"> --}}
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
                                            <select name="syphilis" id="syphilis" x-model="syphilis"
                                                    class="form-control @error('syphilis') is-invalid @enderror"
                                                    :class="{ 'text-danger': syphilis == 'Reaktif' }">
                                                <option value="">Pilih Syphilis</option>
                                                <option value="Reaktif">Reaktif</option>
                                                <option value="Non Reaktif">Non Reaktif</option>
                                                <option value="Belum Dilakukan">Belum Dilakukan</option>
                                            </select>
                                            {{-- <input type="text"
                                                                class="form-control-sm form-control tw-max-w-24 @error('syphilis') is-invalid @enderror"
                                                                id="syphilis" wire:model="syphilis"> --}}
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
                                            <select name="urine_reduction"
                                                    class="form-control @error('urine_reduction') is-invalid @enderror"
                                                    id="urine_reduction" x-model="urine_reduction"
                                                    :class="{ 'text-danger': urine_reduction != 'Negatif' && urine_reduction != null }">
                                                <option value="">Pilih Reduksi Urine</option>
                                                <option value="Negatif">Negatif</option>
                                                <option value="Trace (+-)">Trace (+-)</option>
                                                <option value="+1">+1</option>
                                                <option value="+2">+2</option>
                                                <option value="+3">+3</option>
                                                <option value="+4">+4</option>
                                                <option value="Belum Dilakukan">Belum Dilakukan</option>
                                            </select>
                                            {{-- <input type="text"
                                                                class="form-control-sm form-control tw-max-w-24 @error('urine_reduction') is-invalid @enderror"
                                                                id="urine_reduction" wire:model="urine_reduction"> --}}
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
                                            <select name="urine_protein"
                                                    class="form-control @error('urine_protein') is-invalid @enderror"
                                                    id="urine_protein" x-model="urine_protein"
                                                    :class="{ 'text-danger': urine_protein != 'Negatif' && urine_protein != null }">
                                                <option value="">Pilih Protein Urine</option>
                                                <option value="Negatif">Negatif</option>
                                                <option value="Trace (+-)">Trace (+-)</option>
                                                <option value="+1">+1</option>
                                                <option value="+2">+2</option>
                                                <option value="+3">+3</option>
                                                <option value="+4">+4</option>
                                                <option value="Belum Dilakukan">Belum Dilakukan</option>
                                            </select>
                                            {{-- <input type="text"
                                                                class="form-control-sm form-control tw-max-w-24 @error('urine_protein') is-invalid @enderror"
                                                                id="urine_protein" wire:model="urine_protein"> --}}
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
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" x-on:click="updateLabFirstEntry">Submit</button>
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
                            @forelse ($lastMedicalRecord->illnessHistories ?? [] as $item)
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
                {{-- <div class="col-md-4">
                    <p class="h6">Riwayat Alergi</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lastMedicalRecord->allergyHistories ?? [] as $item)
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
                            <label for="main_complaint" class="form-label h6">Riwayat Keluhan Sekarang/Keluhan Saat
                                Ini</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $firstEntry ? $firstEntry->main_complaint : '' }}</textarea>
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
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Alergi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($firstEntry->patient->allergyHistories ?? [] as $key => $a)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $a->name }}</td>
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
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
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
                                    placeholder="Otomatis dari sistem">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="text" class="form-control" id="date"
                                    value="{{ now()->format('d-m-Y') }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Perawat</label>
                                <input type="text" class="form-control" id="date"
                                    value="{{ auth()->user()->name }}" disabled>
                            </div>
                        </div>
                        @if (auth()->user()->role_id == 5)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="doctor_id" class="form-label">Nama Dokter</label>
                                    <select class="form-select select2 @error('doctor_id') is-invalid @enderror"
                                        id="doctor_id" name="doctor_id" aria-label="Default select example"
                                        wire:model="doctor_id">
                                        <option value="" selected>Pilih Nama Dokter</option>
                                        @foreach ($doctors as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card mb-3">
        <div class="card-body" x-data="{
            para: @entangle('para'),
            height: @entangle('height'),
            weight: @entangle('weight'),
            next_control: @entangle('next_control'),
            bmi: @entangle('bmi'),
            bmi_status: @entangle('bmi_status'),
            edd: @entangle('edd'),
            showLab: @entangle('showLab'),
            hpht: @entangle('hpht'),
            interpretation_childbirth: @entangle('interpretation_childbirth'),
            age_childbirth: @entangle('age_childbirth'),
            main_complaints: @entangle('main_complaints'),
            random_blood_sugar: @entangle('random_blood_sugar'),
            hemoglobin: @entangle('hemoglobin'),
            hbsag: @entangle('hbsag'),
            hiv: @entangle('hiv'),
            syphilis: @entangle('syphilis'),
            urine_reduction: @entangle('urine_reduction'),
            urine_protein: @entangle('urine_protein')
        }">
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
                    {{-- <p class="h6">Anamnesa</p> --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="subjective_summary" class="form-label">Subjective</label>
                                <textarea type="text" class="form-control @error('subjective_summary') is-invalid @enderror"
                                    id="subjective_summary" wire:model="subjective_summary" rows="5"></textarea>
                                @error('subjective_summary')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="hpht" class="form-label">HPHT</label>
                                <input type="text" date-picker
                                    class="form-control @error('hpht') is-invalid @enderror" id="hpht"
                                    x-model="hpht"
                                    x-on:change="(e)=>{
                                        let input_date = e.target.value.split('-').reverse().join('-');

                                        let date = dayjs(input_date).add(280, 'day');
                                        interpretation_childbirth=date.format('DD-MM-YYYY')
                                        edd = date.format('DD-MM-YYYY')
                                        let weeks = dayjs().diff(dayjs(input_date), 'week');
                                        let days = dayjs().diff(dayjs(input_date), 'day') - weeks * 7;
                                        age_childbirth = `${weeks} minggu, ${days} hari`
                                    }">
                                @error('hpht')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="para" class="form-label">Para</label>
                                <input type="text" class="form-control @error('para') is-invalid @enderror"
                                    x-model="para">
                                @error('para')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="interpretation_childbirth" class="form-label">Tafsiran Persalinan</label>
                                <input type="text"
                                    class="form-control @error('interpretation_childbirth') is-invalid @enderror"
                                    id="interpretation_childbirth" x-model="interpretation_childbirth" disabled>
                                @error('interpretation_childbirth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="abbortion" class="form-label">Abortion/Misscarriage</label>
                                <input type="text" class="form-control @error('abbortion') is-invalid @enderror"
                                    id="abbortion" wire:model="abbortion">
                                @error('abbortion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="age_childbirth" class="form-label">Usia Kehamilan</label>
                                <input type="text" class="form-control" disabled id="age_childbirth"
                                    x-model="age_childbirth">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <div class="mb-3" :class="para == 0 || para == '' || para == null ? 'd-none' : ''">
                                <label for="hidup" class="form-label">Hidup</label>
                                <input type="text" class="form-control @error('hidup') is-invalid @enderror"
                                    id="hidup" wire:model="hidup">
                                @error('hidup')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <div class="mb-3" :class="para == 0 || para == '' || para == null ? 'd-none' : ''">
                                <label for="birth_description" class="form-label">Rincian</label>
                                <input type="text"
                                    class="form-control @error('birth_description') is-invalid @enderror"
                                    id="birth_description" wire:model="birth_description">
                                @error('birth_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6"></div> --}}
                        {{-- <div class="col-md-4">
                            <div class="mb-3" wire:ignore>
                                <label for="exampleFormControlTextarea1" class="form-label">Riwayat Penyakit</label>
                                <select name="illness_history" id="illness_history" wire:model="illness_history"
                                    multiple class="select2 form-control w-100">
                                    @foreach ($all_illness_history as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-4">
                            <div class="mb-3" wire:ignore>
                                <label for="exampleFormControlTextarea1" class="form-label">Riwayat Alergi</label>
                                <select name="allergy_history" id="allergy_history" wire:model="allergy_history"
                                    multiple class="select2 form-control w-100">
                                    @foreach ($all_allergy_history as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-md-4"></div>
                        {{-- <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Keluhan Utama</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model="main_complaints"></textarea>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Riwayat Lainnya</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model="other_history"></textarea>
                            </div>
                        </div> --}}
                        <div class="col-md-4"></div>
                        {{-- <div class="col-md-6">
                            <livewire:medical-record.table.create.vaccine-table :user_id="$user->id ?? null">
                        </div> --}}
                    </div>
                </div>
                <div class="tab-pane fade " id="pills-objective" role="tabpanel" aria-labelledby="pills-profile-tab"
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
                                        <select class="form-select @error('patient_awareness') is-invalid @enderror"
                                            id="patient_awareness" name="patient_awareness"
                                            aria-label="Default select example" wire:model="patient_awareness">
                                            <option selected>Pilih Kesadaran Pasien</option>
                                            <option value="Compos Mentis">Compos Mentis</option>
                                            <option value="Apatis">Apatis</option>
                                            <option value="Delirium">Delirium</option>
                                            <option value="Somnolen">Somnolen</option>
                                            <option value="Soporous">Soporous</option>
                                            <option value="Semi Koma">Semi Koma</option>
                                        </select>
                                        @error('patient_awareness')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="body_temperature" class="form-label">Suhu Tubuh</label>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control @error('body_temperature') is-invalid @enderror"
                                                id="body_temperature" wire:model="body_temperature">
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
                                            <input type="text" pattern="[0-9.]*"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                                class="form-control @error('height') is-invalid @enderror"
                                                id="height" x-model="height"
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
                                            <input type="text" pattern="[0-9.]*"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                                class="form-control @error('weight') is-invalid @enderror"
                                                id="weight" x-model="weight"
                                                x-on:change="(e)=>{
                                                    if(height>0 && weight>0){
                                                        let res = Number.parseFloat(weight/((height/100)*(height/100))).toFixed(2)
                                                        bmi = res
                                                        if(res>=40.0){
                                                            bmi_status = 'Obese Class III'
                                                        }else if(res>=35.00 && res<=39.99){
                                                            bmi_status = 'Obese Class II'
                                                        }else if(res>=30.00 && res<=34.99){
                                                            bmi_status = 'Obese Class I'
                                                        }else if(res>=25.00 && res<=29.99){
                                                            bmi_status = 'Overweight'
                                                        }else if(res>=18.50 && res<=24.99){
                                                            bmi_status = 'Normal'
                                                        }else if(res>=17.00 && res<=18.49){
                                                            bmi_status = 'Underweight'
                                                        }else if(res>=16.00 && res<=16.99){
                                                            bmi_status = 'Severely Underweight'
                                                        }else{
                                                            bmi_status = 'Very Severely Underweight'
                                                        }
                                                    }
                                                }">
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
                                            <input type="text" pattern="[0-9.]*"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                                class="form-control @error('sistole') is-invalid @enderror"
                                                id="sistole" wire:model="sistole">
                                            <span class="input-group-text" id="basic-addon1">
                                                /mmHg
                                            </span>
                                            @error('sistole')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="diastole" class="form-label">Diastole</label>
                                        <div class="input-group">
                                            <input type="text" pattern="[0-9.]*"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                                class="form-control @error('diastole') is-invalid @enderror"
                                                id="diastole" wire:model="diastole">
                                            <span class="input-group-text" id="basic-addon1">
                                                /mmHg
                                            </span>
                                            @error('diastole')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pulse" class="form-label">Nadi</label>
                                        <div class="input-group">
                                            <input type="text" pattern="[0-9.]*"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                                class="form-control @error('pulse') is-invalid @enderror"
                                                id="pulse" wire:model="pulse">
                                            <span class="input-group-text" id="basic-addon1">
                                                /menit
                                            </span>
                                            @error('pulse')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="respiratory_frequency" class="form-label">Frekuensi
                                            Pernafasan</label>
                                        <div class="input-group">
                                            <input type="text" pattern="[0-9.]*"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                                class="form-control @error('respiratory_frequency') is-invalid @enderror"
                                                id="respiratory_frequency" wire:model="respiratory_frequency">
                                            <span class="input-group-text" id="basic-addon1">
                                                /menit
                                            </span>
                                            @error('respiratory_frequency')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bmi" class="form-label">BMI / IMT</label>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control @error('bmi') is-invalid @enderror"
                                                id="bmi" x-model="bmi" disabled>
                                            <span class="input-group-text" id="basic-addon1">
                                                kg/m<sup>2</sup>
                                            </span>
                                            @error('bmi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bmi_status" class="form-label">BMI / IMT Status</label>
                                        <input type="text" class="form-control" id="pulse"
                                            x-model="bmi_status" disabled>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Keterangan
                                            Tambahan</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                {{-- <div class="col-12">
                                    <p class="h6">Hasil USG</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ga" class="form-label">Gestational Age (GA)</label>
                                        <input type="text" class="form-control @error('ga') is-invalid @enderror"
                                            id="ga" wire:model="ga">
                                        @error('ga')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="gs" class="form-label">Gestational Sac (GS)</label>
                                        <input type="text" class="form-control @error('gs') is-invalid @enderror"
                                            id="gs" wire:model="gs">
                                        @error('gs')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="crl" class="form-label">Crown Rump Length (CRL)</label>
                                        <input type="text" class="form-control @error('crl') is-invalid @enderror"
                                            id="crl" wire:model="crl">
                                        @error('crl')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="bpd" class="form-label">Biparietal Diameter (BPD)</label>
                                        <input type="text" class="form-control @error('bpd') is-invalid @enderror"
                                            id="bpd" wire:model="bpd">
                                        @error('bpd')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="ac" class="form-label">Abdominal Circumferencial
                                            (AC)</label>
                                        <input type="text" class="form-control @error('ac') is-invalid @enderror"
                                            id="ac" wire:model="ac">
                                        @error('ac')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fl" class="form-label">Femur Lenght (FL)</label>
                                        <input type="text" class="form-control @error('fl') is-invalid @enderror"
                                            id="fl" wire:model="fl">
                                        @error('fl')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="fhr" class="form-label">Fetal Hearth Rate (FHR)</label>
                                        <input type="text" class="form-control @error('fhr') is-invalid @enderror"
                                            id="fhr" wire:model="fhr">
                                        @error('fhr')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="efw" class="form-label">Estimated Fetal Weight (EFW)</label>
                                        <input type="text" class="form-control @error('efw') is-invalid @enderror"
                                            id="efw" wire:model="efw">
                                        @error('efw')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="">
                                        <div class="form-check">
                                            <input class="form-check-input" x-bind:checked="showLab == true"
                                                type="checkbox" x-model="showLab" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Hasil Lab
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-1" x-show="showLab">
                                        <div class="mb-3">
                                            <label for="date_lab" class="form-label">Tanggal Pemeriksaan Lab</label>
                                            <input type="text" date-picker
                                                class="form-control @error('date_lab') is-invalid @enderror"
                                                id="date_lab" wire:model="date_lab">
                                                @error('date_lab')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>
                                    <template x-if="showLab">
                                        <div class="table-responsive">
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
                                                            id="blood_type" wire:model="blood_type">
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
                                                            class="form-control-sm form-control tw-max-w-24 @error('random_blood_sugar') is-invalid @enderror"
                                                            id="random_blood_sugar" x-model="random_blood_sugar"
                                                            pattern="[0-9.]*"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                                            :class="{
                                                                'text-danger': random_blood_sugar < 80 ||
                                                                    random_blood_sugar > 120
                                                            }">
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
                                                            class="form-control-sm form-control tw-max-w-24 @error('hemoglobin') is-invalid @enderror"
                                                            id="hemoglobin" x-model="hemoglobin" pattern="[0-9.]*"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                                            :class="{ 'text-danger': hemoglobin < 12 || hemoglobin > 16 }">
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
                                                        <select name="hbsag" id="hbsag" x-model="hbsag"
                                                            class="form-control @error('hbsag') is-invalid @enderror"
                                                            :class="{ 'text-danger': hbsag == 'Reaktif' }">
                                                            <option value="">Pilih HBSAG</option>
                                                            <option value="Reaktif">Reaktif</option>
                                                            <option value="Non Reaktif">Non Reaktif</option>
                                                            <option value="Belum Dilakukan">Belum Dilakukan</option>
                                                        </select>
                                                        {{-- <input type="text"
                                                            class="form-control-sm form-control tw-max-w-24 @error('hbsag') is-invalid @enderror"
                                                            id="hbsag" wire:model="hbsag"> --}}
                                                        @error('hbsag')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </td>
                                                    <td>Non Reaktif</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>HIV</td>
                                                    <td style="border: 1px solid">
                                                        <select name="hiv" id="hiv" x-model="hiv"
                                                            class="form-control @error('hiv') is-invalid @enderror"
                                                            :class="{ 'text-danger': hiv == 'Reaktif' }">
                                                            <option value="">Pilih HIV</option>
                                                            <option value="Reaktif">Reaktif</option>
                                                            <option value="Non Reaktif">Non Reaktif</option>
                                                            <option value="Belum Dilakukan">Belum Dilakukan</option>
                                                        </select>
                                                        {{-- <input type="text"
                                                            class="form-control-sm form-control tw-max-w-24 @error('hiv') is-invalid @enderror"
                                                            id="hiv" wire:model="hiv"> --}}
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
                                                        <select name="syphilis" id="syphilis" x-model="syphilis"
                                                            class="form-control @error('syphilis') is-invalid @enderror"
                                                            :class="{ 'text-danger': syphilis == 'Reaktif' }">
                                                            <option value="">Pilih Syphilis</option>
                                                            <option value="Reaktif">Reaktif</option>
                                                            <option value="Non Reaktif">Non Reaktif</option>
                                                            <option value="Belum Dilakukan">Belum Dilakukan</option>
                                                        </select>
                                                        {{-- <input type="text"
                                                            class="form-control-sm form-control tw-max-w-24 @error('syphilis') is-invalid @enderror"
                                                            id="syphilis" wire:model="syphilis"> --}}
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
                                                        <select name="urine_reduction"
                                                            class="form-control @error('urine_reduction') is-invalid @enderror"
                                                            id="urine_reduction" x-model="urine_reduction"
                                                            :class="{
                                                                'text-danger': urine_reduction != 'Negatif' &&
                                                                    urine_reduction != null
                                                            }">
                                                            <option value="">Pilih Reduksi Urine</option>
                                                            <option value="Negatif">Negatif</option>
                                                            <option value="Trace (+-)">Trace (+-)</option>
                                                            <option value="+1">+1</option>
                                                            <option value="+2">+2</option>
                                                            <option value="+3">+3</option>
                                                            <option value="+4">+4</option>
                                                            <option value="Belum Dilakukan">Belum Dilakukan</option>
                                                        </select>
                                                        {{-- <input type="text"
                                                            class="form-control-sm form-control tw-max-w-24 @error('urine_reduction') is-invalid @enderror"
                                                            id="urine_reduction" wire:model="urine_reduction"> --}}
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
                                                        <select name="urine_protein"
                                                            class="form-control @error('urine_protein') is-invalid @enderror"
                                                            id="urine_protein" x-model="urine_protein"
                                                            :class="{
                                                                'text-danger': urine_protein != 'Negatif' &&
                                                                    urine_protein != null
                                                            }">
                                                            <option value="">Pilih Protein Urine</option>
                                                            <option value="Negatif">Negatif</option>
                                                            <option value="Trace (+-)">Trace (+-)</option>
                                                            <option value="+1">+1</option>
                                                            <option value="+2">+2</option>
                                                            <option value="+3">+3</option>
                                                            <option value="+4">+4</option>
                                                            <option value="Belum Dilakukan">Belum Dilakukan</option>
                                                        </select>
                                                        {{-- <input type="text"
                                                            class="form-control-sm form-control tw-max-w-24 @error('urine_protein') is-invalid @enderror"
                                                            id="urine_protein" wire:model="urine_protein"> --}}
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
                                        </div>
                                    </template>
                                    <div class="">
                                        <label for="other_lab" class="form-label">Hasil Lab Lainnya</label>
                                        <textarea name="other_lab" id="other_lab" class="form-control" rows="5" wire:model='other_lab'></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <livewire:medical-record.table.create.usg-table :user_id="$user->id ?? null" />
                        </div> --}}
                        <div class="col-md-6">
                            <livewire:medical-record.table.create.check-table :user_id="$user->id ?? null" />
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-assessment" role="tabpanel" aria-labelledby="pills-profile-tab"
                    tabindex="0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Diagnosa</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model="diagnose"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Kesimpulan</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model="summary"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-plan" role="tabpanel" aria-labelledby="pills-profile-tab"
                    tabindex="0">
                    {{-- <div class="row">
                        <div class="col-12">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="other_summary" class="form-label">Catatan</label>
                                    <textarea class="form-control @error('other_summary') is-invalid @enderror" id="other_summary"
                                        wire:model="other_summary" rows="5"></textarea>
                                    @error('other_summary')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- <div class="mb-3">
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
                        </div> --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="plan_note" class="form-label">Plan</label>
                                <textarea class="form-control" id="plan_note" rows="3" wire:model="plan_note"></textarea>
                            </div>
                        </div>

                        {{-- <livewire:medical-record.table.nurse.create.action-table /> --}}
                    </div>
                    {{-- <livewire:medical-record.table.nurse.create.laborate-table /> --}}
                    {{-- <livewire:medical-record.table.nurse.create.drug-table /> --}}
                </div>
            </div>
        </div>
    </div>
    </div>
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
@endassets

@script
@if(!$user)
<script>
    let $user_id = $("#user_id");
        $user_id.select2({
            theme: 'bootstrap-5',
        });
        $user_id.on('change', function(e) {
            var data = $('#user_id').select2("val");
            $wire.$set('user_id', data);

        });
        Livewire.on('refresh-select2', function(event) {
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
        flatpickr($wire.$el.querySelector('#date'), {
            dateFormat: "Y-m-d",
            onClose: (selectedDates) => {
                $wire.$set('date', selectedDates[0])
            },
        })
</script>
@endif


    <script>
        flatpickr($wire.$el.querySelector('#date_lab'), {
            dateFormat: "d-m-Y",
            altFormat: "d-m-Y",
            // onClose: function(selectedDates, dateStr, instance) {
            //     $wire.$set('hpht', dateStr);
            //     },
            defaultDate: null,
            allowInput: true,
        });
        flatpickr($wire.$el.querySelector('#date_lab_fe'), {
            dateFormat: "d-m-Y",
            altFormat: "d-m-Y",
            defaultDate: null,
            allowInput: true,
        });
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    </script>
@endscript
