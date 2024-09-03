<x-slot:title>
    Daftar Asesmen Awal
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('first-entry.index') }}" wire:navigate>Asesmen Awal</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Asesmen Awal</li>
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
                            Asesmen Awal : {{ $timestamp }}</span>
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
                                        id="user_id" name="user_id" aria-label="Default select example"
                                        wire:model.live="user_id" style="width: 100%">
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
                @if($user && $user->patient->status_pernikahan == 'Menikah')
                <div class="col-md-4 mt-4">
                    <p class="h6 mt-3">Data Suami Pasien</p>
                    <div class="row">
                        <div class="col">
                            <table>
                                <tr>
                                    <td class="tw-text-nowrap">Nama</td>
                                    <td>: {{ ucwords(strtolower($user->patient->husbands_name)) }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Tanggal Lahir</td>
                                    <td>:
                                        {{ $user->patient->husbands_birth_date ? Carbon\Carbon::parse($user->patient->husbands_birth_date)->format('d M Y') . ' (' . $age_husband->format('%y tahun') . ')' : '-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Nomor Telepon</td>
                                    <td>: {{ $user->patient->husbands_phone_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Pekerjaan</td>
                                    <td>: {{ ucwords(strtolower($user->patient->husbands_job ?? '-')) }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Alamat</td>
                                    <td>: {{ $user->patient->husbands_address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Kewarganegaraan</td>
                                    <td>: {{ $user->patient->husbands_citizenship ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Lama Pernikahan</td>
                                    <td>: {{ $user->patient->age_of_marriage ? $user->patient->age_of_marriage . ' tahun' : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Keterangan</td>
                                    <td>: {{ $user->patient->husbands_note ?? '-' }}</td>
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
                                       wire:model="nurse">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end">
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
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Medical
                                                            History</h1>
                                                        <p class="m-0">Sudah {{ $medicalRecords->count() }} kali
                                                            pemeriksaan
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
                                                                <th>Tanggal<br>Dokter/Perawat</th>
                                                                <th>Rekam Medis</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse ($medicalRecords as $mr)
                                                                <tr>
                                                                    <td>
                                                                        <p>{{ \Carbon\Carbon::parse($mr->date)->format('d/m/Y') }}
                                                                        </p>
                                                                        <p>Dokter {{ $mr->doctor?->name }}</p>
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
                                                                                        $imtStatus = 'Overweight';
                                                                                    } elseif (
                                                                                        $imt >= 18.5 &&
                                                                                        $imt <= 24.99
                                                                                    ) {
                                                                                        $imtStatus = 'Normal';
                                                                                    } elseif (
                                                                                        $imt >= 17.0 &&
                                                                                        $imt <= 18.49
                                                                                    ) {
                                                                                        $imtStatus = 'Underweight';
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
                                                                            <div class="col-md-12">
                                                                                <p>Asesmen:</p>
                                                                                <p>{{ $mr->assessment_summary ?? '-' }}
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <p>Keterangan Tambahan/Laporan Hasil
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
                                                                                    <p>
                                                                                        EDD:{{ $mr->edd ? \Carbon\Carbon::parse($mr->edd)->format('d/m/Y') : '' }}
                                                                                    </p>
                                                                                    {{-- <p>Hasil USG:</p> --}}

                                                                                    {{-- <div class="row">
                                                                                        <div class="col-md-6">
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
                                                                                        <div class="col-md-6">
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
                                                                                                    :</span> <br>
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
                                                                                                    :</span> <br>
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
                                                                                                    :</span> <br>
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
                                                                        <p>Perawat {{ $mr->nurse?->name }}</p>
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
                                                                                <p>Asesmen :</p>

                                                                                <p>{{ $mr->diagnose }}</p>
                                                                                <p>{{ $mr->summary }}</p>
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
                                                            data-bs-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        {{-- @if (auth()->user()->role_id == 5) --}}
                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                                <label for="doctor_id" class="form-label">Nama Dokter</label>
                                <input type="text" class="form-control" disabled name="" id=""
                                    wire:model="doctor">
                            </div>

                        </div> --}}
                        {{-- @endif --}}
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="{{ !$user ? 'tw-invisible' : '' }} tw-transition-all	tw-duration-700">
        <div class="card mb-3">
            <div class="card-body" x-data="{
                hpht: @entangle('hpht'),
                interpretation_childbirth: @entangle('interpretation_childbirth'),
                age_childbirth: '',
                'obstetri_array': @entangle('obstetri_array'),
                'count_obstetri': @entangle('count_obstetri')
            }">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="h6">Status obstetri</p>

                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">Kehamilan ke-</th>
                                <th>Jenis Persalinan</th>
                                <th width="160">Jenis Kelamin</th>
                                <th width="13%">Berat Badan</th>
                                {{-- <th width="200">Tanggal Lahir Anak</th> --}}
                                <th width="160">Usia Anak Sekarang</th>
                                <th>Keterangan Tambahan/Komplikasi</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($obstetri as $o)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $o->type_of_birth }}</td>
                                    <td>{{ is_null($o->gender) ? '-' : ($o->gender == 1 ? 'Laki-laki' : ($o->gender == 0 ? 'Perempuan' : ($o->gender == 2 ? 'Keguguran' : ($o->gender == 3 ? 'Hamil INI' : ($o->gender == 5 ? 'IUFD' : '-'))))) }}
                                    </td>
                                    <td>{{ $o->weight ?? 0 }} gr</td>
                                    {{-- <td>{{ $o->birth_date }}</td> --}}
                                    <td>{{ $o->age ?? 0 }} tahun
                                    </td>
                                    <td>{{ $o->clinical_information }}</td>
                                    <td>
                                        {{-- <button type="button" class="btn btn-sm btn-danger" wire:click="delete_obstetri({{$o->id}})"> <i class="fa-solid fa-trash"></i></button> --}}
                                    </td>
                                </tr>
                            @endforeach


                            <template x-for="(value, index) in obstetri_array" :key="index">
                                <tr x-data="{ age: '' }">
                                    <td class="text-center" x-text="index+1+count_obstetri"></td>
                                    <td>
                                        {{-- <input type="text" name="type_of_birth" id="type_of_birth"
                                            x-on:blur="(e)=>{
                                obstetri_array = obstetri_array.map((val, idx)=>{
                                    if(value.id === val.id){
                                        return {
                                            ...val,
                                            type_of_birth:e.target.value
                                        }
                                    }else{
                                        return val
                                    }
                                })
                            }"
                                            placeholder="Jenis Persalinan..."> --}}
                                        <select name="type_of_birth" id="type_of_birth"
                                                class="form-control @error('type_of_birth') @enderror"
                                                x-on:change="(e)=>{
                                    obstetri_array = obstetri_array.map((val, idx)=>{
                                        if(value.id === val.id){
                                            return {
                                                ...val,
                                                type_of_birth:e.target.value
                                            }
                                        }else{
                                            return val
                                        }
                                    })
                                }">
                                            <option value="" selected>Pilih Jenis Persalinan</option>
                                            <option value="SC">SC</option>
                                            <option value="Spontan Kepala">Spontan Kepala</option>
                                            <option value="Spontan Sungsang">Spontan Sungsang</option>
                                            <option value="Hamil INI">Hamil INI</option>
                                            <option value="Vacuum/Forcep">Vacuum/Forcep</option>
                                            <option value="Laparatomi">Laparatomi</option>
                                            <option value="Abortus">Abortus</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="gender" id="gender"
                                                class="form-control @error('field')

                                @enderror"
                                                x-bind:disabled="value.type_of_birth == 'Hamil INI' || value.type_of_birth == 'Abortus'"
                                                x-on:change="(e)=>{
                                    obstetri_array = obstetri_array.map((val, idx)=>{
                                        if(value.id === val.id){
                                            return {
                                                ...val,
                                                gender:e.target.value
                                            }
                                        }else{
                                            return val
                                        }
                                    })
                                }">
                                            <option value="" selected>Pilih Jenis</option>
                                            <option value="1">Laki-laki</option>
                                            <option value="0">Perempuan</option>
                                            <option value="5">IUFD</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="input-group flex-nowrap" style="width: 100%">
                                            <input type="text" class="form-control" placeholder="0"
                                                   name="weight" id="weight"
                                                   x-bind:disabled="value.gender == 2 || value.gender == 3 || value.type_of_birth ==
                                                        'Hamil INI' || value.type_of_birth == 'Abortus'"
                                                   x-on:blur="(e)=>{
                                            obstetri_array = obstetri_array.map((val, idx)=>{
                                                if(value.id === val.id){
                                                    if(e.target.value >= 2147483647){
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Error',
                                                            text: 'Berat badan tidak sesuai'
                                                        });
                                                        e.target.value = 0;
                                                    }
                                                    return {
                                                        ...val,
                                                        weight:e.target.value
                                                    }
                                                }else{
                                                    return val
                                                }
                                            })
                                        }"
                                                   aria-describedby="addon-wrapping">
                                            <span class="input-group-text" id="weight">gr</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group flex-nowrap" style="width: 100%">
                                            <input type="text" class="form-control" placeholder="0"
                                                   name="age" id="age"
                                                   x-bind:disabled="value.gender == 2 || value.gender == 3 || value.type_of_birth ==
                                                        'Hamil INI' || value.type_of_birth == 'Abortus'"
                                                   x-on:blur="(e)=>{
                                        obstetri_array = obstetri_array.map((val, idx)=>{
                                            if(value.id === val.id){
                                                return {
                                                    ...val,
                                                    age:e.target.value
                                                }
                                            }else{
                                                return val
                                            }
                                        })
                                    }"
                                                   aria-describedby="addon-wrapping">
                                            <span class="input-group-text" id="age">tahun</span>
                                        </div>
                                        {{-- <input type="text" disabled id="age" wire:model.blur="age" x-ref="age" > --}}
                                    </td>


                                    <td><input type="text" name="clinical_information"
                                               id="clinical_information"
                                               x-on:blur="(e)=>{
                                obstetri_array = obstetri_array.map((val, idx)=>{
                                    if(value.id === val.id){
                                        return {
                                            ...val,
                                            clinical_information:e.target.value
                                        }
                                    }else{
                                        return val
                                    }
                                })
                            }"
                                               placeholder="Keterangan klinis...">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger"
                                                x-on:click="obstetri_array = obstetri_array.filter((item)=>item.id!==value.id)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                            </template>

                            {{-- @if ($obstetri->count() == 0 && $rows->count() == 0)
                        <tr>
                            <td colspan="9" align="center">Tidak ada data</td>
                        </tr>
                    @endif --}}
                            </tbody>
                        </table>
                    </div>
                    <tr>
                        <button type="button" class="btn btn-sm btn-primary mb-2"
                                x-on:click="()=>{
                    obstetri_array = [
                        ...obstetri_array,
                        {
                            id:Math.floor(Math.random() * 100) + 1,
                            type_of_birth:'',
                            gender:'',
                            weight:'',
                            age:'',
                            clinical_information:''
                        }
                    ]
                }">Tambah
                        </button>
                    </tr>
                </div>

                {{-- <livewire:first-entry.table.create.obstetri-table :patient_id="$user->patient->id ?? null" :key="rand()" /> --}}

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="hpht" class="form-label">HPHT</label>
                            <input type="text" date-picker required
                                   class="form-control @error('hpht') is-invalid @enderror" id="hpht"
                                   x-model="hpht"
                                   x-on:change="(e)=>{
                            let input_date = e.target.value.split('-').reverse().join('-');
                            let date = dayjs(input_date).add(280, 'day');
                            if(date['$d'] != 'Invalid Date'){
                                date_format =  date.format('DD-MM-YYYY')
                            }else{
                                date_format = null
                            }
                            interpretation_childbirth= date_format
                            edd = date_format
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
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="edd" class="form-label">Tafsiran Persalinan</label>
                            <input type="text"
                                   class="form-control @error('interpretation_childbirth') is-invalid @enderror"
                                   id="interpretation_childbirth" x-model="interpretation_childbirth"
                                   x-on:change="(e)=>{
                                    let input_date = e.target.value.split('-').reverse().join('-');
                                    let date = dayjs(input_date).subtract(280, 'day');
                                    if(date['$d'] != 'Invalid Date'){
                                        date_format =  date.format('DD-MM-YYYY')
                                    }else{
                                        date_format = null
                                    }

                                    let weeks = dayjs().diff(dayjs(date), 'week');
                                    let days = dayjs().diff(dayjs(date), 'day') - weeks * 7;
                                    if((weeks > 0 || (weeks == 0 && days > 0)) && weeks <= 40){
                                        hpht = date_format
                                        age_childbirth = `${weeks} minggu, ${days} hari`
                                    }else{
                                        interpretation_childbirth = null;
                                        hpht = null;
                                    }

                                 }">
                            @error('interpretation_childbirth')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="edd" class="form-label">Usia Kehamilan</label>
                            <input type="text" class="form-control" disabled id="age_childbirth"
                                   x-model="age_childbirth">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="main_complaint" class="form-label">Riwayat Penyakit Sekarang/Keluhan
                                Saat Ini<span class="text-danger">*</span></label>
                            <textarea id="main_complaint" name="main_complaint" wire:model="main_complaint"
                                      class="form-control @error('main_complaint') is-invalid @enderror"></textarea>
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
                            <textarea id="" name="specific_attention" wire:model="specific_attention"
                                      class="form-control"></textarea>
                            @error('specific_attention')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-md-4 col-sm-12">
                        <livewire:first-entry.table.create.illness-table :user_id="$user->id ?? null" :key="rand()">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <livewire:first-entry.table.create.family-illness-table :patient_id="$user->patient->id ?? null"
                                                                                :key="rand()">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <livewire:first-entry.table.create.allergy-table :user_id="$user->id ?? null" :key="rand()">
                    </div>
                </div>
            </div>
        </div>

        {{-- Pemeriksaan FIsik --}}
        <div class="card mb-3">
            <div class="card-body" x-data="{
                showLab: @entangle('showLab'),
                height: @entangle('height'),
                weight: @entangle('weight'),
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
                                               class="form-control @error('height') is-invalid @enderror" id="height"
                                               x-model="height"
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
                                               class="form-control @error('weight') is-invalid @enderror" id="weight"
                                               x-model="weight"
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
                                               class="form-control @error('pulse') is-invalid @enderror" id="pulse"
                                               wire:model="pulse">
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
                                        <input type="text" class="form-control @error('bmi') is-invalid @enderror"
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
                                    <input type="text" class="form-control" id="pulse" x-model="bmi_status"
                                           disabled>
                                </div>
                            </div>

                            <div class="col col-12">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Keterangan
                                        Tambahan</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                              wire:model="description_physical"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" x-model="showLab"
                                       id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Hasil Lab
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mt-1" x-bind:class="showLab == false ? 'tw-invisible' : ''">
                            <div class="mb-3">
                                <label for="date_lab" class="form-label">Tanggal Pemeriksaan Lab</label>
                                <input type="text" date-picker
                                       class="form-control @error('date_lab') is-invalid @enderror" id="date_lab"
                                       wire:model="date_lab">
                                       @error('date_lab')
                                       <div class="invalid-feedback">
                                           {{ $message }}
                                       </div>
                                       @enderror
                            </div>
                        </div>
                        <template x-if="showLab">
                            <div x-data="{
                                random_blood_sugar: @entangle('random_blood_sugar'),
                                hemoglobin: @entangle('hemoglobin'),
                                hbsag: @entangle('hbsag'),
                                hiv: @entangle('hiv'),
                                syphilis: @entangle('syphilis'),
                                urine_reduction: @entangle('urine_reduction'),
                                urine_protein: @entangle('urine_protein')
                            }">
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
                                                    id="blood_type" name="blood_type"
                                                    aria-label="Default select example"
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
                                                   class="form-control-sm text-danger form-control tw-max-w-24 @error('random_blood_sugar') is-invalid @enderror"
                                                   id="random_blood_sugar" x-model="random_blood_sugar"
                                                   pattern="[0-9.]*"
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
                                                    :class="{
                                                    'text-danger': urine_reduction != 'Negatif' && urine_reduction !=
                                                        null
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
                        </div> --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="neck" class="form-label">Leher</label>
                                    <input type="text" class="form-control  @error('neck') is-invalid @enderror"
                                           id="neck" wire:model="neck">
                                    @error('neck')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="head" class="form-label">Kepala</label>
                                    <input type="text" class="form-control @error('head') is-invalid @enderror"
                                           id="head" wire:model="head">
                                    @error('head')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="chest" class="form-label">Dada</label>
                                    <input type="text" class="form-control @error('chest') is-invalid @enderror"
                                           wire:model="chest" id="chest">
                                    @error('chest')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="eye" class="form-label">Mata</label>
                                    <input type="text" class="form-control @error('eye') is-invalid @enderror"
                                           id="eye" wire:model="eye">
                                    @error('eye')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="abdomen" class="form-label">Abdomen</label>
                                    <input type="text" class="form-control @error('abdomen') is-invalid @enderror"
                                           id="abdomen" wire:model="abdomen">
                                    @error('abdomen')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="heart" class="form-label">Jantung</label>
                                    <input type="text" class="form-control @error('heart') is-invalid @enderror"
                                           id="heart" wire:model="heart">
                                    @error('heart')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="extremities" class="form-label">Ekstremitas</label>
                                    <input type="text"
                                           class="form-control @error('extremities') is-invalid @enderror"
                                           id="extremities" wire:model="extremities">
                                    @error('extremities')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lungs" class="form-label">Paru</label>
                                    <input type="text" class="form-control @error('lungs') is-invalid @enderror"
                                           id="lungs" wire:model="lungs">
                                    @error('lungs')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="skin" class="form-label">Kulit</label>
                                    <input type="text" class="form-control @error('skin') is-invalid @enderror"
                                           id="skin" wire:model="skin">
                                    @error('skin')
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


<style>
    table td {
        position: relative;
    }

    table td input,
    table td select {
        position: absolute;
        display: block;
        top: 0;
        left: 0;
        margin: 0;
        height: 100% !important;
        width: 100%;
        border-radius: 0 !important;
        border: none !important;
        padding: 5px;
        box-sizing: border-box;
    }
</style>
@endassets


@if (!$user)
    @script
    <script>
        let $user_id = $("#user_id");
        $user_id.select2({
            theme: 'bootstrap-5',
        });
        $user_id.on('change', function (e) {
            var data = $('#user_id').select2("val");
            $wire.$set('user_id', data);
        });
        flatpickr($wire.$el.querySelector('#date'), {
            dateFormat: "Y-m-d",
            onClose: (selectedDates) => {
                $wire.$set('date', selectedDates[0])
            },
        })
    </script>
    @endscript
@endif
@script
<script>
    flatpickr($wire.$el.querySelector('#hpht'), {
        dateFormat: "d-m-Y",
        "locale": "id",
        // altFormat: "d-m-Y",
        // onClose: function(selectedDates, dateStr, instance) {
        //     $wire.$set('hpht', dateStr);
        //     },
        maxDate: 'today',
        defaultDate: null,
        allowInput: true,
    });
    flatpickr($wire.$el.querySelector('#date_lab'), {
        dateFormat: "d-m-Y",
        "locale": "id",
        altFormat: "d-m-Y",
        // onClose: function(selectedDates, dateStr, instance) {
        //     $wire.$set('hpht', dateStr);
        //     },
        allowInput: true,
    });
    flatpickr($wire.$el.querySelector('#interpretation_childbirth'), {
        dateFormat: "d-m-Y",
        "locale": "id",
        // altFormat: "d-m-Y",
        // onClose: function(selectedDates, dateStr, instance) {
        //     $wire.$set('hpht', dateStr);
        //     },
        defaultDate: null,
        allowInput: true,
    });

    Livewire.on('refresh-select2', function (event) {
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
        event.users.forEach(function (user) {
            select2.$element.append(new Option(user.name, user.id,
                false, false));
        });

        $('#user_id').on('change', function (e) {
            var data = $('#user_id').select2("val");
            $wire.$set('user_id', data);
        });
    })
</script>
@endscript
