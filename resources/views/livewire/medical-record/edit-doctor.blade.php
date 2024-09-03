<x-slot:title>
    Ubah Rekam Medis
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('medical-record.index') }}" wire:navigate>CPPT</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ubah CPPT</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <button class="btn btn-primary" wire:loading.attr="disabled" wire:click="save">Simpan</button>
    </x-slot:button>

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
                                    <td>: {{ $firstEntry->patient->patient_number }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Nama</td>
                                    <td>: <button
                                            wire:click="$dispatch('openModal', {component:'medical-record.detail-patient',arguments:{uuid:'{{ $firstEntry->patient->uuid }}'}})"
                                            class="text-info"
                                            title="Detail Pasien">{{ ucwords(strtolower($firstEntry->patient->user->name)) }}</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Tanggal Lahir</td>
                                    <td>:
                                        {{ Carbon\Carbon::parse($firstEntry->patient->dob)->format('d M Y') . ' (' . $age->format('%y tahun') . ')' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Nomor Telepon</td>
                                    <td>: {{ $firstEntry->patient->user->patient->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Golongan Darah</td>
                                    <td>: {{ $firstEntry->patient->user->patient->blood_type }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Pekerjaan</td>
                                    <td>:
                                        {{ ucwords(strtolower($firstEntry->patient->user->patient->job->name ?? '-')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Alamat</td>
                                    <td>: {{ $firstEntry->patient->user->patient->address }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-nowrap">Email</td>
                                    <td>: {{ $firstEntry->patient->user->email ?? '-' }}</td>
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
                                <label for="exampleFormControlTextarea1" class="form-label">Hasil Lab: <button type="button"   data-bs-toggle="modal"
                                    data-bs-target="#editHasilLabModal"
                                    data-bs-placement="bottom" data-bs-title="Edit Hasil Lab" class="tw-bg-yellow-500 tw-text-black tw-text-xs tw-px-2 tw-py-1 tw-rounded">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
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

    <div class="row">
        <div class="col">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="h5">SOAP</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Subjective</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" wire:model="subjective_summary"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Objective</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" wire:model="objective_summary"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Assessment</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" wire:model="assessment_summary"></textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="mb-3" wire:ignore>
                                        <label for="exampleFormControlTextarea1" class="form-label">Diagnosa Penyerta</label>
                                        <select name="diagnose" id="diagnose" wire:model="diagnose"
                                            class="select2 form-control w-100">
                                            @foreach ([] as $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Plan</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" wire:model="other_summary"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    {{-- <div class="row">
                                        <p class="h6">Hasil USG</p>
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
                                        </div>
                                        <div class="col-md-6">
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
                                        </div>
                                    </div> --}}

                                </div>
                                {{-- <div class="col-6">
                                    <livewire:medical-record.table.edit.usg-table :user_id="$medicalRecord->user_id" :medical_record_id="$medicalRecord->id" />
                                </div> --}}
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
                                                <th>Cabang<br>Tanggal, <br>Dokter/Perawat</th>
                                                <th>Rekam Medis</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($oldMedicalRecords ?? [] as $omr)
                                                <tr :key="rand()" style="border: 1px solid">
                                                    <td>
                                                        Cabang : {{ $omr->registration->branch->name ?? '-' }} <br>
                                                        Tanggal :
                                                        {{ Carbon\Carbon::parse($omr->date)->format('d-m-Y') }}
                                                        <br>
                                                        Dokter : {{ isset($omr->doctor) ? $omr->doctor->name : '' }}
                                                        <br>

                                                    </td>
                                                    <td>
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div>
                                                                        <span class="text-primary">Subjective :</span>
                                                                        <br>
                                                                        {{ $omr->subjective_summary ?? '-' }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div>
                                                                        <span class="text-primary">Objective :</span>
                                                                        <br>
                                                                        <p>{{ $omr->objective_summary }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    {{-- Additional fields can go here --}}
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div>
                                                                        <span class="text-primary">Asesmen :</span>
                                                                        <br>
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
                                                                        <span class="text-primary">Tindakan :</span>
                                                                        <br>
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
                                                                        <span class="text-primary">Laborate :</span>
                                                                        <br>
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
                                                        Tanggal :
                                                        {{ Carbon\Carbon::parse($omr->date)->format('d-m-Y') }}
                                                        <br>
                                                        Perawat : {{ $omr->nurse->name ?? '' }} <br><br>
                                                    </td>
                                                    <td>
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div>
                                                                        {{-- @if ($omr->date_lab != null)
                                                                            <span class="text-primary">Hasil Lab
                                                                                :</span> <br>
                                                                            <table>
                                                                                <tr>
                                                                                    <td>Goldar</td>
                                                                                    <td>: {{ $omr->blood_type }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Gula Darah Acak</td>
                                                                                    <td>:
                                                                                        {{ $omr->random_blood_sugar }}
                                                                                    </td>
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
                                                                                    <td>: {{ $omr->urine_reduction }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Protein Urine</td>
                                                                                    <td>: {{ $omr->urine_protein }}
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        @endif --}}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div>
                                                                        <span class="text-primary">Asesmen :</span>
                                                                        <br>
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
                                                                        <span class="text-primary">Perhatian Khusus
                                                                            :</span> <br>
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
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3" x-data="{ next_control: @entangle('next_control') }">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <p class="h5">Rencana Perawatan</p>
                    <div class="col-12">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="next_control" class="form-label">Periksa
                                    Berikutnya</label>
                                <input type="text" date-picker wire:ignore
                                    class="form-control @error('next_control') is-invalid @enderror" id="next_control"
                                    x-model="next_control">
                                @error('next_control')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <livewire:medical-record.table.doctor.drug-table :medical_record_id="$medicalRecord->id" />
                        <div class="mt-2s">
                            <label for="other_recipe" class="form-label">Resep Luar</label>
                            <textarea name="other_recipe" id="other_recipe" class="form-control" rows="5" wire:model='other_recipe'></textarea>
                        </div>
                    </div>
                    <livewire:medical-record.table.doctor.action-table :medical_record_id="$medicalRecord->id" />
                    <livewire:medical-record.table.doctor.laborate-table :medical_record_id="$medicalRecord->id" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3" x-data="{
        showLab: @entangle('showLab')
    }">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" x-model="showLab"
                                    id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Hasil Lab
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mt-1" x-show="showLab">
                            <div class="mb-3">
                                <label for="date_lab" class="form-label">Tanggal Pemeriksaan Lab</label>
                                <input type="text" date-picker
                                    class="form-control @error('date_lab') is-invalid @enderror" id="date_lab"
                                    wire:model="date_lab">
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
                        <div class="">
                            <label for="other_lab" class="form-label">Hasil Lab Lainnya</label>
                            <textarea name="other_lab" id="other_lab" class="form-control" rows="5" wire:model='other_lab'></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <livewire:medical-record.table.edit.check-table :user_id="$medicalRecord->user_id" :medical_record_id="$medicalRecord->id" />
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">

        </div>
    </div>
    <section class="py-5">
        <ul class="timeline">
            @foreach ($logs as $log)
                <li class="timeline-item mb-3">
                    <h5 class="fw-bold tw-text-xs">{{ $log->author }}</h5>
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
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
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

@script
    <script>
        flatpickr($wire.$el.querySelector('#next_control'), {
            dateFormat: "d-m-Y",
            "locale": "id",
            minDate: "today",
            defaultDate: new Date(),
            allowInput: true,
        });

        flatpickr($wire.$el.querySelector('#date_lab'), {
            dateFormat: "d-m-Y",
            "locale": "id",
            defaultDate: null,
            allowInput: true,
        });
        flatpickr($wire.$el.querySelector('#date_lab_fe'), {
            dateFormat: "d-m-Y",
            "locale": "id",
            defaultDate: null,
            allowInput: true,
        });
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    </script>
@endscript
