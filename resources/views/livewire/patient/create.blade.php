<x-slot:title>
    Tambah Pasien
</x-slot:title>

<x-page-layout>
    <form x-data="{
        insurance: false,
        husbands_data: false,
        status_pernikahan: @entangle('status_pernikahan'),
        age_of_marriage: @entangle('age_of_marriage'),
        month_of_marriage: @entangle('month_of_marriage'),
        address: @entangle('address'),
        insurances: @entangle('insurances').live,
        age: '',
        husbands_age: '',
        husbands_name: @entangle('husbands_name'),
        husbands_phone_number: @entangle('husbands_phone_number'),
        husbands_address: @entangle('husbands_address'),
        husbands_job: @entangle('husbands_job'),
        dob: @entangle('dob').live,
        emergencyContacts: @entangle('emergency_contacts')
    }" id="form" wire:submit="save">
        <x-slot:button>
            <button class="btn btn-primary" wire:loading.attr="disabled" x-on:click="Livewire.dispatch('patient-save')">
                <i wire:loading class="fa-solid fa-spinner tw-animate-spin"></i>Simpan
            </button>
        </x-slot:button>

        <x-slot:breadcrumbs>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('patient.index') }}" wire:navigate>Pasien</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pasien</li>
        </x-slot:breadcrumbs>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Nomor RM</label>
                            <input type="text" class="form-control" disabled placeholder="Otomatis dari sistem">
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK<span class="text-danger">*</span></label>
                            <div wire:ignore class="input-group">
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                       wire:model="nik" maxlength="16" pattern="[0-9]*"
                                       oninput="this.value = this.value.replace(/\D+/g, '')">
                                <button type="button" class="btn btn-outline-primary" title="Generate NIK"
                                        x-on:click="Livewire.dispatch('generate-nik')"><i
                                        class="fa-solid fa-shuffle"></i></button>
                            </div>
                            @error('nik')
                            <div class="text-danger tw-text-sm">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Pasien<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" wire:model="name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label for="pob" class="form-label">Tempat Lahir<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pob') is-invalid @enderror" id="pob"
                                wire:model="pob">
                            @error('pob')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="mb-3">
                            <label for="dob" class="form-label">Tanggal Lahir<span class="text-danger">*</span></label>
                            <div wire:ignore class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </span>
                                <input type="text" date-picker name="dob" id="dob"
                                       class="form-control @error('dob') is-invalid @enderror"
                                       x-on:change="(e)=>{
                                    let years = dayjs().diff(dayjs(e.target.value, 'DD-MM-YYYY'), 'years');
                                    let months = dayjs().diff(dayjs(e.target.value, 'DD-MM-YYYY'), 'months') - years * 12;
                                    age = `${years} tahun, ${months} bulan`
                                }">
                            </div>
                            @error('dob')
                            <div class="tw-text-sm text-danger">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Usia</label>
                            <input type="text" class="form-control" id="age" disabled x-model="age">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="blood_type" class="form-label">Golongan Darah<span class="text-danger">*</span></label>
                            <select class="form-select @error('blood_type') is-invalid @enderror" id="blood_type"
                                    name="blood_type" aria-label="Default select example" wire:model="blood_type">
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
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin<span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                    name="gender" aria-label="Default select example" wire:model="gender">
                                <option selected>Pilih Jenis Kelamin</option>
                                <option value="1">Laki-Laki</option>
                                <option value="0">Perempuan</option>
                            </select>
                            @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status_pernikahan" class="form-label">Status Pernikahan<span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('status_pernikahan') is-invalid @enderror"
                                    id="status_pernikahan" name="status_pernikahan" aria-label="Default select example"
                                    x-model="status_pernikahan" x-on:change="(e)=>{
                                    if(e.target.value==='Menikah'){
                                        husbands_data = true
                                    }else{
                                        husbands_data = false
                                        age_of_marriage = null
                                    }
                                }">
                                <option value="" selected>Pilih Status Pernikahan</option>
                                <option value="Belum Menikah">Belum Menikah</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Janda">Janda</option>
                            </select>
                            @error('status_pernikahan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="age_of_marriage" class="form-label">Lama Pernikahan</label>
                            <div
                                class="input-group @error('age_of_marriage') is-invalid @enderror  @error('month_of_marriage') is-invalid @enderror">
                                <input type="text" class="form-control @error('age_of_marriage') is-invalid @enderror"
                                       placeholder="Tahun" aria-label="Tahun" x-model="age_of_marriage"
                                       pattern="[0-9.]*"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                       x-bind:disabled="status_pernikahan != 'Menikah'">
                                <span class="input-group-text">Tahun</span>
                                <input type="text" class="form-control @error('month_of_marriage') is-invalid @enderror"
                                       placeholder="Bulan" aria-label="Bulan" x-model="month_of_marriage"
                                       pattern="[0-9.]*"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                       x-bind:disabled="status_pernikahan != 'Menikah'">
                                <span class="input-group-text">Bulan</span>
                            </div>
                            @error('age_of_marriage')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            @error('month_of_marriage')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="job_id" class="form-label">Pekerjaan<span class="text-danger">*</span></label>
                            <div wire:ignore>
                                <select class="form-select select2 @error('job_id') is-invalid @enderror" id="job_id"
                                        name="job_id" aria-label="Default select example" wire:model="job_id"
                                        style="width: 100%">
                                    <option value="" selected>Pilih Pekerjaan</option>
                                    @foreach ($jobs as $j)
                                        <option value="{{ $j->id }}">{{ $j->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('job_id')
                            <div class="text-danger tw-text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                   id="address" x-model="address" x-on:blur="()=>{
                                if(status_pernikahan == 'Menikah'){
                                    husbands_address = address
                                }

                                }
                                ">
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">Kota Domisili<span class="text-danger">*</span></label>
                            <div wire:ignore>
                                <select class="form-select select2 @error('city') is-invalid @enderror" id="city"
                                        name="city" aria-label="Default select example" wire:model="city"
                                        style="width: 100%">
                                    <option value="" selected>Pilih Kota Domisili</option>
                                    @foreach ($cities as $c)
                                        <option value="{{ $c->name }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('city')
                            <div class="text-danger tw-text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Handphone<span
                                    class="text-danger">*</span></label>
                            {{-- <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                id="phone_number" wire:model="phone_number"  pattern="[0-9]*" oninput="this.value = this.value.replace(/\D+/g, '')"> --}}
                            <div class="input-group @error('phone_number') is-invalid @enderror">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+62</div>
                                </div>
                                <input type="text"
                                       class="form-control @error('phone_number') is-invalid @enderror"
                                       wire:model="phone_number" id="phone_number" pattern="[0-9]*"
                                       oninput="this.value = this.value.replace(/\D+/g, '')">
                            </div>

                            @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" wire:model="email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="citizenship" class="form-label">Kewarganegaraan<span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('citizenship') is-invalid @enderror" id="citizenship"
                                    name="citizenship" wire:model="citizenship"
                                    aria-label="Default select example">
                                <option value="" selected>Pilih Kewarganegaraan</option>
                                <option value="WNI">WNI</option>
                                <option value="WNA">WNA</option>
                            </select>
                            @error('citizenship')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="insurance" class="form-label">Asuransi</label>
                            <select class="form-select" id="insurance" name="insurance" wire:model="insurance"
                                    aria-label="Default select example"
                                    x-on:change="(e)=>{
                                if(e.target.value==='Ya'){
                                    insurance = true
                                    $('html,body').animate({scrollTop: document.body.scrollHeight},'fast');
                                }else{
                                    insurance = false
                                }
                            }">
                                <option value="Tidak">Tidak</option>
                                <option value="Ya">Ya</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mb-3" x-show="insurance">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="h6">Asuransi</p>
                            {{-- <button type="button" class="btn btn-sm btn-primary mb-2"
                                wire:click="$dispatch('openModal', {component:'patient.insurance-modal-create'})">Tambah</button> --}}
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Asuransi</th>
                                    <th>Nomor Asuransi</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template x-if="insurances.length>0">
                                    <template x-for="(value, index) in insurances">
                                        <tr>
                                            <td x-text="index+1"></td>
                                            <td x-text="value.name"></td>
                                            <td x-text="value.number"></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        x-on:click="insurances = insurances.filter((item)=>item.id!==value.id)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                                <template x-if="insurances.length==0">
                                    <tr>
                                        <td colspan="4" align="center">Tidak ada data</td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mb-2"
                                wire:click="$dispatch('openModal', {component:'patient.insurance-modal-create'})">Tambah
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
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
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template x-if="emergencyContacts.length>0">
                                    <template x-for="(value, index) in emergencyContacts" :key="value.id">
                                        <tr class="text-center">
                                            <td x-text="index+1"></td>
                                            <td>
                                                <input type="text" placeholder="Nama"
                                                       x-on:blur="(e)=>{
                                                        emergencyContacts = emergencyContacts.map((val, idx)=>{
                                                            if(value.id === val.id){
                                                                return {
                                                                    ...val,
                                                                    name:e.target.value
                                                                }
                                                            }else{
                                                                return val
                                                            }
                                                        })
                                                    }">
                                            </td>
                                            <td>
                                                <select class="form-select" x-on:change="(e)=>{
                                                        emergencyContacts = emergencyContacts.map((val, idx)=>{
                                                            if(value.id === val.id){
                                                                return {
                                                                    ...val,
                                                                    relationship:e.target.value
                                                                }
                                                            }else{
                                                                return val
                                                            }
                                                        })
                                                    }">
                                                    <option selected>Pilih Hubungan</option>
                                                    <option value="Suami">Suami</option>
                                                    <option value="Orang tua">Orang tua</option>
                                                    <option value="Saudara">Saudara</option>
                                                    <option value="Lainnya-">Lainnya-</option>
                                                </select>
                                            </td>
                                            <td><input type="text" placeholder="Nomor Telepon"
                                                       x-on:blur="(e)=>{
                                                        emergencyContacts = emergencyContacts.map((val, idx)=>{
                                                            if(value.id === val.id){
                                                                return {
                                                                    ...val,
                                                                    phone_number:e.target.value
                                                                }
                                                            }else{
                                                                return val
                                                            }
                                                        })
                                                    }" pattern="[0-9]*"
                                                       oninput="this.value = this.value.replace(/\D+/g, '')">
                                            </td>
                                            <td><input type="text" placeholder="Alamat" x-model="value.address"
                                                       x-on:blur="(e)=>{
                                                        emergencyContacts = emergencyContacts.map((val, idx)=>{
                                                            if(value.id === val.id){
                                                                return {
                                                                    ...val,
                                                                    address:e.target.value
                                                                }
                                                            }else{
                                                                return val
                                                            }
                                                        })
                                                    }">
                                            </td>
                                            <td wire:ignore>
                                                <select name="" id="" class="form-control" x-init="() => {
                                                        $($el).select2({
                                                            placeholder: 'Pilih Pekerjaan',
                                                            width: '100%',
                                                            theme: 'bootstrap-5',
                                                            tags: true
                                                        })
                                                        $($el).on('change', function(e) {
                                                             emergencyContacts = emergencyContacts.map((val, idx)=>{
                                                            if(value.id === val.id){
                                                                return {
                                                                    ...val,
                                                                    job:e.target.value
                                                                }
                                                            }else{
                                                                return val
                                                            }
                                                            })
                                                        })
                                                        }">
                                                    <option value="" selected>Pilih Pekerjaan</option>
                                                    @foreach ($jobs as $j)
                                                        <option value="{{ $j->name }}">{{ $j->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        x-on:click="emergencyContacts = emergencyContacts.filter((item)=>item.id!==value.id)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-info"
                                                        title="Sama Dengan Data Suami"
                                                        x-bind:disabled="emergencyContacts.find((item)=>item.id==value.id).relationship != 'Suami'"
                                                        x-on:click="()=>{
                                                        husbands_name = emergencyContacts.find((item)=>item.id==value.id).name;
                                                        husbands_address = emergencyContacts.find((item)=>item.id==value.id).address;
                                                        husbands_phone_number = emergencyContacts.find((item)=>item.id==value.id).phone_number;
                                                        husbands_job = emergencyContacts.find((item)=>item.id==value.id).job;
                                                        var newOption = new Option(husbands_job, husbands_job, true, true);
                                                        $('#husbands_job').append(newOption).trigger('change');
                                                        $('html,body').animate({scrollTop: document.body.scrollHeight},'fast');

                                                    }">
                                                    <i class="fa-solid fa-check-to-slot"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                                <template x-if="emergencyContacts.length==0">
                                    <tr>
                                        <td colspan="7" align="center">Tidak ada data</td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mb-2"
                                x-on:click="()=>{
                                emergencyContacts = [
                                    ...emergencyContacts,
                                    {
                                        id:Math.floor(Math.random() * 100) + 1,
                                        name:'',
                                        relationship:'',
                                        phone_number:'',
                                        job:'',
                                        address: address
                                    }
                                ]
                            }">Tambah
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3" x-show="husbands_data">
            <div class="card-body">
                <div class="row">
                    <p class="h6">Data Suami</p>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="husbands_name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('husbands_name') is-invalid @enderror"
                                   id="husbands_name" wire:model="husbands_name" x-model="husbands_name">
                            @error('husbands_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label for="husbands_nik" class="form-label">NIK</label>
                            <input type="text" class="form-control @error('husbands_nik') is-invalid @enderror" id="husbands_nik"
                                wire:model="husbands_nik" maxlength="16" pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/\D+/g, '')">
                            @error('husbands_nik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="mb-3">
                            <label for="husbands_birth_date" class="form-label">Tanggal Lahir</label>
                            <div>
                                <div wire:ignore class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                    <input type="text" date-picker name="husbands_birth_date" id="husbands_birth_date"
                                           class="form-control @error('husbands_birth_date') is-invalid @enderror"
                                           x-on:change="(e)=>{
                                            let years = dayjs().diff(dayjs(e.target.value, 'DD-MM-YYYY'), 'years');
                                            let months = dayjs().diff(dayjs(e.target.value, 'DD-MM-YYYY'), 'months') - years * 12;
                                            husbands_age = `${years} tahun, ${months} bulan`
                                        }">
                                </div>
                                @error('husbands_birth_date')
                                <div class="text-danger tw-text-sm">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Usia</label>
                            <input type="text" class="form-control" id="husbands_age" disabled x-model="husbands_age">
                        </div>
                        <div class="mb-3">
                            <label for="age_of_marriage" class="form-label">Lama Pernikahan<span
                                    class="text-danger">*</span></label>
                            <div
                                class="input-group @error('age_of_marriage') is-invalid @enderror  @error('month_of_marriage') is-invalid @enderror">
                                <input type="text" class="form-control @error('age_of_marriage') is-invalid @enderror"
                                       placeholder="Tahun" aria-label="Tahun" x-model="age_of_marriage" disabled>
                                <span class="input-group-text">Tahun</span>
                                <input type="text" class="form-control @error('month_of_marriage') is-invalid @enderror"
                                       placeholder="Bulan" aria-label="Bulan" x-model="month_of_marriage" disabled>
                                <span class="input-group-text">Bulan</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="husbands_phone_number" class="form-label">Handphone</label>
                            <div class="input-group @error('husbands_phone_number') is-invalid @enderror">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+62</div>
                                </div>
                                <input type="text"
                                       class="form-control @error('husbands_phone_number') is-invalid @enderror"
                                       id="husbands_phone_number" x-model="husbands_phone_number" pattern="[0-9]*"
                                       oninput="this.value = this.value.replace(/\D+/g, '')">
                            </div>

                            @error('husbands_phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="husbands_job" class="form-label">Pekerjaan</label>
                            <div wire:ignore>
                                <select class="form-select select2 @error('husbands_job') is-invalid @enderror"
                                        id="husbands_job"
                                        name="husbands_job" aria-label="Default select example" x-model="husbands_job"
                                        wire:model="husbands_job"
                                        style="width: 100%">
                                    <option value="" selected>Pilih Pekerjaan</option>
                                    @foreach ($jobs as $j)
                                        <option value="{{ $j->name }}">{{ $j->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('husbands_job')
                            <div class="text-danger tw-text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="husbands_address" class="form-label">Alamat</label>
                            <input type="text" class="form-control @error('husbands_address') is-invalid @enderror"
                                   id="husbands_address" wire:model="husbands_address" x-model="husbands_address">
                            @error('husbands_address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="husbands_citizenship" class="form-label">Kewarganegaraan</label>
                            <select class="form-select @error('husbands_citizenship') is-invalid @enderror"
                                    id="husbands_citizenship" name="husbands_citizenship"
                                    wire:model="husbands_citizenship"
                                    aria-label="Default select example">
                                <option value="" selected>Pilih Kewarganegaraan</option>
                                <option value="WNI">WNI</option>
                                <option value="WNA">WNA</option>
                            </select>
                            @error('husbands_citizenship')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="husbands_note">Keterangan</label>
                            <textarea name="husbands_note" id="" class="form-control" rows="3"
                                      wire:model='husbands_note'></textarea>
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
    </form>
</x-page-layout>

@assets
<link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
<script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
<script src="{{ asset('assets/vendor/dayjs/dayjs.min.js') }}"></script>
<script src="{{ asset('assets/vendor/dayjs/customParseFormat.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
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

@script
{{-- <script>

</script> --}}
<script>
    $('.select2').select2({
        tags: true,
        theme: 'bootstrap-5',
    });
    $('#job_id').on('change', function (e) {
        var data = $('#job_id').select2("val");
        $wire.$set('job_id', data);
    });
    $('#husbands_job').on('change', function (e) {
        var data = $('#husbands_job').select2("val");
        $wire.$set('husbands_job', data);
    });

    $('#city').on('change', function (e) {
        var data = $('#city').select2("val");
        $wire.$set('city', data);
    });


    dayjs.extend(window.dayjs_plugin_customParseFormat)

    flatpickr($wire.$el.querySelector('#dob'), {
        dateFormat: "d-m-Y",
        "locale": "id",
        // altFormat: "d-m-Y",
        onClose: function (selectedDates, dateStr, instance) {
            $wire.$set('dob', dateStr);
        },
        allowInput: true,
        // defaultDate: new Date()
    });

    flatpickr($wire.$el.querySelector('#husbands_birth_date'), {
        dateFormat: "d-m-Y",
        "locale": "id",
        // altFormat: "d-m-Y",
        onClose: function (selectedDates, dateStr, instance) {
            $wire.$set('husbands_birth_date', dateStr);
        },
        allowInput: true,
        // defaultDate: new Date()
    });
</script>
@endscript
