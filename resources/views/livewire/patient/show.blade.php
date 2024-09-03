<x-slot:title>
    Detail Pasien
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('patient.index') }}" wire:navigate>Pasien</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Pasien</li>
    </x-slot:breadcrumbs>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Nomor RM</label>
                        <input type="text" class="form-control" value="{{ $patient->patient_number }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" disabled value="{{ $patient->nik }}">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Pasien</label>
                        <input type="text" class="form-control" id="name" disabled
                               value="{{ ucwords(strtolower($patient->name)) }}">
                    </div>
                    {{-- <div class="mb-3">
                        <label for="pob" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="pob" disabled value="{{ $patient->pob }}">
                    </div> --}}
                    <div class="mb-3">
                        <label for="dob" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" id="dob" disabled
                               value="{{ Carbon\Carbon::parse($patient->dob)->format('d-m-Y') }}">
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Usia</label>
                        <input type="text" class="form-control" id="age" disabled
                               value="{{ $age->format('%y tahun %m bulan') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="blood_type" class="form-label">Golongan Darah</label>
                        <input type="text" class="form-control" disabled value="{{ $patient->blood_type }}">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="gender" name="gender" aria-label="Default select example"
                                disabled>
                            <option value="1" @if ($patient->gender) selected @endif>Laki-Laki</option>
                            <option value="0" @if (!$patient->gender) selected @endif>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                        <input type="text" class="form-control" id="status_pernikahan" disabled
                               value="{{ $patient->status_pernikahan }}">
                    </div>

                    <label for="age_of_marriage" class="form-label">Lama Pernikahan</label>
                    <div class="mb-3">
                        <label for="age_of_marriage" class="form-label">Lama Pernikahan<span
                                class="text-danger">*</span></label>

                    </div>
                    <div
                        class="input-group">
                        <input type="text" class="form-control"
                               placeholder="Tahun" aria-label="Tahun" value="{{$patient->age_of_marriage}}" disabled>
                        <span class="input-group-text">Tahun</span>
                        <input type="text" class="form-control"
                               placeholder="Bulan" aria-label="Bulan" value="{{$patient->month_of_marriage}}" disabled>
                        <span class="input-group-text">Bulan</span>
                    </div>
                    <div class="mb-3">
                        <label for="job_id" class="form-label">Pekerjaan</label>
                        <select class="form-select" id="job_id" name="job_id" aria-label="Default select example"
                                disabled>
                            @foreach ($jobs as $j)
                                <option value="{{ $j->id }}" @if ($patient->job_id === $j->id) selected @endif>
                                    {{ ucwords(strtolower($j->name)) }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="address" disabled
                               value="{{ $patient->address }}">
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Kota Domisili</label>
                        <input type="text" class="form-control" id="city" disabled
                               value="{{ $patient->city }}">
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Handphone</label>
                        <input type="text" class="form-control" id="phone_number" disabled
                               value="{{ $patient->phone_number }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" disabled
                               value="{{ $patient->user->email ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="citizenship" class="form-label">Kewarganegaraan</label>
                        <input type="text" class="form-control" id="citizenship" disabled
                               value="{{ $patient->citizenship }}">
                    </div>
                    <div class="mb-3">
                        <label for="insurance" class="form-label">Asuransi</label>
                        <select class="form-select" id="insurance" name="insurance"
                                aria-label="Default select example" disabled>
                            <option value="Tidak" @if (count($patient->insurances) === 0) selected @endif>Tidak</option>
                            <option value="Ya" @if (count($patient->insurances) !== 0) selected @endif>Ya</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (count($patient->insurances) !== 0)
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="h6">Asuransi</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Asuransi</th>
                                    <th>Nomor Asuransi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($patient->insurances as $i)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $i->name }}</td>
                                        <td>{{ $i->number }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" align="center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card mb-3">
        <div class="card-body">
            <p class="h5">Riwayat</p>
            <div class="row">
                <div class="col-md-6">
                    <p class="h6">Riwayat Penyakit</p>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            {{-- <th>Tanggal</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($lastMedicalRecord->illnessHistories ?? [] as $ih)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ih->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <p class="h6">Riwayat Alergi</p>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($lastMedicalRecord->allergyHistories ?? [] as $ah)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ah->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="h6">Kontak Darurat</p>
                        {{-- <button type="button" class="btn btn-sm btn-primary mb-2"
                            wire:click="$dispatch('openModal', {component:'patient.insurance-modal-create'})">Tambah</button> --}}
                    </div>
                    <div class="table-responsive">
                        <table width="100%" class="table">
                            <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th width="20%">Nama</th>
                                <th width="15%">Hubungan</th>
                                <th width="15%">Nomor Telepon</th>
                                <th width="25%">Alamat</th>
                                <th width="15%">Pekerjaan</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($emergency_contacts as $ec)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ ucwords(strtolower($ec->name)) }}
                                    </td>
                                    <td>{{ $ec->relationship }}
                                    </td>
                                    <td>{{ $ec->phone_number }}
                                    </td>
                                    <td>{{ $ec->address }}
                                    </td>
                                    <td>{{ $ec->job }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" align="center">Tidak ada data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($patient->status_pernikahan == 'Menikah')
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <p class="h6">Data Suami</p>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="husbands_name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('husbands_name') is-invalid @enderror"
                                   id="husbands_name" value="{{ ucwords(strtolower($patient->husbands_name)) }}"
                                   disabled>
                        </div>
                        <div class="mb-3">
                            <label for="husbands_birth_date" class="form-label">Tanggal Lahir</label>
                            <div wire:ignore class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </span>
                                <input type="text" name="husbands_birth_date" id="husbands_birth_date"
                                       class="form-control @error('husbands_birth_date') is-invalid @enderror" disabled
                                       value="{{ Carbon\Carbon::parse($patient->husbands_birth_date)->format('d-m-Y') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Usia</label>
                            <input type="text" class="form-control" id="husbands_age" disabled
                                   value="{{ $age_husband->format('%y tahun %m bulan') }}">
                        </div>
                        <label for="age_of_marriage" class="form-label">Lama Pernikahan</label>
                        <div class="input-group">
                            <div
                                class="input-group">
                                <input type="text" class="form-control"
                                       placeholder="Tahun" aria-label="Tahun" value="{{$patient->age_of_marriage}}"
                                       disabled>
                                <span class="input-group-text">Tahun</span>
                                <input type="text" class="form-control"
                                       placeholder="Bulan" aria-label="Bulan" value="{{$patient->month_of_marriage}}"
                                       disabled>
                                <span class="input-group-text">Bulan</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="husbands_job" class="form-label">Handphone</label>
                            <input type="text" name="husbands_birth_date" id="husbands_birth_date"
                                   class="form-control @error('husbands_birth_date') is-invalid @enderror" disabled
                                   value="{{ $patient->husbands_phone_number }}">
                        </div>
                        <div class="mb-3">
                            <label for="husbands_job" class="form-label">Pekerjaan</label>
                            <input type="text" name="husbands_birth_date" id="husbands_birth_date"
                                   class="form-control @error('husbands_birth_date') is-invalid @enderror" disabled
                                   value="{{ $patient->husbands_job }}">
                        </div>
                        <div class="mb-3">
                            <label for="husbands_address" class="form-label">Alamat</label>
                            <input type="text"
                                   class="form-control @error('husbands_address') is-invalid @enderror"
                                   id="husbands_address" disabled value="{{ $patient->husbands_address }}">
                        </div>
                        <div class="mb-3">
                            <label for="husbands_citizenship" class="form-label">Kewarganegaraan</label>
                            <input type="text"
                                   class="form-control @error('husbands_address') is-invalid @enderror"
                                   id="husbands_address" wire:model="husbands_address"
                                   value="{{ $patient->husbands_citizenship }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="husbands_note">Keterangan</label>
                            <textarea name="husbands_note" id="" class="form-control" rows="3"
                                      disabled>{{ $patient->husbands_note }}</textarea>
                            @error('husbands_note')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endif
    <div class="card mb-3 m-3">
        <div class="card-body">
            <div>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true"><i class="fa-solid fa-list"></i> Medical Record
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                         aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="mb-2">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Medical History</h1>
                                    <p class="m-0">Sudah {{ $medical_record->count() }} kali pemeriksaan
                                    </p>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Dokter<br>Tanggal<br>Dokter/Perawat</th>
                                        <th>Rekam Medis</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($medical_record as $mr)
                                        <tr>
                                            <td>
                                                <p>Cabang : {{ $mr->registration->branch->name }} </p>
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
                                                        <p>Plan:</p>
                                                        <p>{{ $mr->other_summary ?? '-' }}</p>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="d-flex align-items-start">
                                                            @foreach ($mr->usgs as $u)
                                                                <a href="{{ asset('storage/' . $u->file) }}"
                                                                   class="btn btn-primary btn-sm" noreferer
                                                                   noopener target="_blank">Lihat File</a>
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
                                                                        <span class="text-primary">Tindakan
                                                                            :</span> <br>
                                                                    @foreach ($mr->actions as $a)
                                                                        {{ '- ' . $a->name }} <br>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div>
                                                                        <span class="text-primary">Laborate
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
                                                    @if ($mr->date_lab != null)
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
                                                    @endif
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-page-layout>
