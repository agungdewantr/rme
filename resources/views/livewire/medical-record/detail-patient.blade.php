<div class="tw-modal tw-max-w-6xl">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <p class="h6">Detail Pasien</p>
                    <div class="col-4">
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
                            <input type="text" class="form-control" id="name" disabled value="{{  ucwords(strtolower($patient->name)) }}">
                        </div>
                        {{-- <div class="mb-3">
                            <label for="pob" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="pob" disabled value="{{ $patient->pob }}">
                        </div> --}}
                        <div class="mb-3">
                            <label for="dob" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="dob" disabled value="{{ $patient->dob }}">
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Usia</label>
                            <input type="text" class="form-control" id="age" disabled
                                value="{{ $age->format('%y tahun %m bulan') }}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="blood_type" class="form-label">Golongan Darah</label>
                            <input type="text" class="form-control" id="name" disabled value="{{ $patient->blood_type }}">
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
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="job_id" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" id="city" disabled
                            value="{{ $patient->job->name ?? '-' }}">
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
        @if($patient->status_pernikahan == 'Menikah')
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <p class="h6">Data Suami</p>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="husbands_name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('husbands_name') is-invalid @enderror"
                                id="husbands_name" value="{{$patient->husbands_name}}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="husbands_birth_date" class="form-label">Tanggal Lahir</label>
                            <div wire:ignore class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </span>
                                <input type="text" name="husbands_birth_date" id="husbands_birth_date"
                                    class="form-control @error('husbands_birth_date') is-invalid @enderror" disabled value="{{$patient->husbands_birth_date}}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Usia</label>
                            <input type="text" class="form-control" id="husbands_age" disabled value="{{ $age_husband->format('%y tahun %m bulan') }}">
                        </div>
                        <label for="age_of_marriage" class="form-label">Lama Pernikahan<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" disabled
                                class="form-control @error('age_of_marriage') is-invalid @enderror"
                                wire:model="age_of_marriage" value="{{$patient->age_of_marriage}}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Tahun</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="husbands_job" class="form-label">Handphone</label>
                            <input type="text" name="husbands_birth_date" id="husbands_birth_date"
                            class="form-control @error('husbands_birth_date') is-invalid @enderror" disabled value="{{$patient->husbands_phone_number}}">
                        </div>
                        <div class="mb-3">
                            <label for="husbands_job" class="form-label">Pekerjaan</label>
                            <input type="text" name="husbands_birth_date" id="husbands_birth_date"
                            class="form-control @error('husbands_birth_date') is-invalid @enderror" disabled value="{{$patient->husbands_job}}">
                        </div>
                        <div class="mb-3">
                            <label for="husbands_address" class="form-label">Alamat</label>
                            <input type="text" class="form-control @error('husbands_address') is-invalid @enderror"
                                id="husbands_address" disabled value="{{$patient->husbands_address}}">
                        </div>
                        <div class="mb-3">
                            <label for="husbands_citizenship" class="form-label">Kewarganegaraan</label>
                            <input type="text" class="form-control @error('husbands_address') is-invalid @enderror"
                            id="husbands_address"  value="{{$patient->husbands_citizenship}}" disabled>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="husbands_note" class="form-label">Keterangan</label>
                            <textarea name="" class="form-control"  rows="3" disabled>{{$patient->husbands_note}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if (count($patient->insurances) !== 0)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="h6">Asuransi</p>
                            </div>
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
        @endif
        @if(auth()->user()->role_id == 2)
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
                                @forelse ($patient->illnessHistories ?? [] as $ih)
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
                        <p class="h6">Riwayat Penyakit Keluarga</p>
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
                                @forelse ($patient->familyIlnessHistories ?? [] as $ih)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ih->name }}</td>
                                        <td>{{ $ih->relationship}}</td>
                                        <td>{{ $ih->disease_name}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" align="center">Tidak ada data</td>
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
                                    <th>tanda & Gejala</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patient->allergyHistories ?? [] as $ah)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ah->name }}</td>
                                        <td>{{$ah->pivot->indication}}</td>
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
        @endif
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="h6">Kontak Darurat</p>
                            {{-- <button type="button" class="btn btn-sm btn-primary mb-2"
                                wire:click="$dispatch('openModal', {component:'patient.insurance-modal-create'})">Tambah</button> --}}
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Hubungan</th>
                                    <th>Nomor Telepon</th>
                                    <th>Alamat</th>
                                    <th>Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($emergency_contacts as $ec)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $ec->name }}
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
