<div>
    <!-- ? Preloader Start -->
    {{-- <div id="preloader-active">
            <div class="preloader d-flex align-items-center justify-content-center">
                <div class="preloader-inner position-relative">
                    <div class="preloader-circle"></div>
                    <div class="preloader-img pere-text">
                        <img src="{{asset('assets/assets/img/logo/loderbm.png')}}" alt="">
</div>
</div>
</div>
</div> --}}
    <!-- Preloader Start -->
    <header>
        <!--? Header Start -->
        <div class="header-area" wire:ignore>
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-2 col-md-1">
                            <div class="logo">
                                <a href="#"><img src="{{ asset('assets/assets/img/logo/logobm.jpg') }}"
                                        width="100%" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-md-10">
                            <div class="menu-main d-flex align-items-center justify-content-end">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="#">Home</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="header-right-btn f-right d-none d-lg-block ml-30">
                                    <a href="#section-appointment" class="btn header-btn">Appointment</a>
                                </div>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <main>
        <!--? slider Area Start-->
        <div class="slider-area position-relative">
            <div class="slider-active">
                <!-- Single Slider -->
                <div class="single-slider slider-height d-flex align-items-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-8 col-lg-9 col-md-8 col-sm-9">
                                <div class="hero__caption">
                                    <span>Selamat Datang di Bermakna Mulia</span>
                                    <h1 class="col-12 cd-headline letters scale">Peduli Pada
                                    </h1>
                                    <h1 class="h1" style="color:#006A3A">Kesehatan Anda</h1>
                                    <p data-animation="fadeInLeft" class="col-8" data-delay="0.1s">Anda dapat membuat
                                        jadwal konsultasi dengan dokter kami dengan mudah, kapanpun dan dimanapun!</p>
                                    <a href="#section-appointment" class="btn hero-btn" data-animation="fadeInLeft"
                                        data-delay="0.5s">Appointment <i class="ti-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider Area End-->
        <!--? About Us Start-->
        <div class="about-area section-padding2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-10">
                        <div class="about-caption mb-50">
                            <!-- Section Tittle -->
                            <div class="section-tittle section-tittle2 mb-35">
                                <span>About Us</span>
                                <h2>Selamat Datang di Bermakna Mulia</h2>
                            </div>
                            <p>Klinik Bermakna Mulia memberikan pelayanan kehamilan islami kepada bunda sehingga bunda
                                dapat mengetahui perkembangan calon buah hati.</p>
                            <div class="about-btn1 mb-30">
                                <a href="#doctor" class="btn about-btn">Tenaga Medis Ahli dan Berpengalaman<i
                                        class="ti-arrow-right"></i></a>
                            </div>
                            <div class="about-btn1 mb-30">
                                <a href="#section-appointment" class="btn about-btn2">Buat Appointment <i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <!-- about-img -->
                        <div class="about-img ">
                            <div class="about-font-img d-none d-lg-block">
                                <img src="{{ asset('assets/assets/img/gallery/aboutbgg.png') }}" alt="">
                            </div>
                            <div class="about-back-img ">
                                <img src="{{ asset('assets/assets/img/gallery/about0.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--? Team Start -->
        <div class="team-area section-padding30">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row justify-content-center" id="doctor">
                    <div class="col-lg-6">
                        <div class="section-tittle text-center mb-100">
                            <span>Tenaga Medis Ahli dan Berpengalaman</span>
                            <h2>Dokter Spesialis Kami</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <!-- single Tem -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="{{ asset('assets/assets/img/gallery/druning.png') }}" alt="">
                            </div>
                            <div class="team-caption">
                                <h3><a href="#">dr. Uning Marlina, MHSM, Sp.OG</a></h3>
                                <span>Spesialis Obstetri dan Ginekologi</span>
                                <!-- Team social -->
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="{{ asset('assets/assets/img/gallery/drqa.png') }}" alt="">
                            </div>
                            <div class="team-caption">
                                <h3><a href="#">dr. Qurrata Akyuni, M.Ked.Klin., Sp.OG</a></h3>
                                <span>Spesialis Obstetri dan Ginekologi</span>
                                <!-- Team social -->
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->
        <!--? Contact form Start -->
        <div class="contact-form-main" id="section-appointment">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-xl-7 col-lg-7">
                        <div class="form-wrapper">
                            <!--Section Tittle  -->
                            <div class="form-tittle" x-data="{
                                type: 'pasien_baru',
                                type_input: @entangle('type_input')
                            }">
                                <div class="row ">
                                    <div class="col-xl-12">
                                        <div class="section-tittle section-tittle2">
                                            <span>Make An Appointment</span>
                                            <h2>Appointment</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fs-5">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item mr-1 border border-success rounded">
                                            <a x-on:click="(e)=>{
                                                type = 'pasien_baru';
                                                type_input = type;
                                            }"
                                                class="nav-link  text-success"
                                                x-bind:class="type == 'pasien_baru' ? 'active' : ''"
                                                id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                                role="tab" aria-controls="pills-home" aria-selected="true">Pasien
                                                Baru</a>
                                        </li>
                                        <li class="ms-2 nav-item border border-success rounded">
                                            <a x-on:click="(e)=>{
                                                type = 'pasien_lama'
                                                type_input = type;
                                            }"
                                                class="nav-link  text-success"
                                                x-bind:class="type == 'pasien_lama' ? 'active' : ''"
                                                id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                                role="tab" aria-controls="pills-profile"
                                                aria-selected="false">Pasien Lama</a>
                                        </li>
                                    </ul>
                                </div>


                                <div class="container costum-form mt-4 fs-5">
                                    <input type="hidden" x-model="type_input" id="type">
                                    <div class="row" x-bind:class="type != 'pasien_baru' ? 'd-none' : ''"
                                        x-data="{ isWeekend: false }">
                                        <div class="col-md-6 mb-3">
                                            <label for="input1">NIK<span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control fs-5 @error('nik') is-invalid @enderror"
                                                wire:model="nik" id="nik" name="nik" style="height: 35px"
                                                maxlength="16" pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/\D+/g, '')">
                                            @error('nik')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="input2">Nama Lengkap<span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control fs-5 @error('name') is-invalid @enderror"
                                                wire:model="name" style="height: 35px">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3" wire:ignore>
                                            <label for="input2">Tanggal Lahir<span class="text-danger">*</span></label>
                                            <input type="text" date-picker
                                                class="form-control mt-2 @error('dob') is-invalid @enderror"
                                                wire:model="dob" id="dob" style="height: 35px">
                                            @error('dob')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="blood_type" class="form-label">Golongan Darah<span
                                                    class="text-danger">*</span></label>
                                            <div wire:ignore>
                                                <select style="height: 55px !important; width:100%"
                                                    class="form-control fs-5 @error('blood_type') is-invalid @enderror"
                                                    id="blood_type" name="blood_type"
                                                    aria-label="Default select example" wire:model="blood_type">
                                                    <option value="" selected>Pilih Golongan darah</option>
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
                                            </div>
                                            @error('blood_type')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="gender" class="form-label">Jenis Kelamin<span
                                                    class="text-danger">*</span></label>
                                            <div wire:ignore>
                                                <select style="height: 35px;width:100%"
                                                    class="form-control @error('gender') is-invalid @enderror"
                                                    id="gender" name="gender" aria-label="Default select example"
                                                    wire:model="gender">
                                                    <option value="" selected>Pilih Jenis Kelamin</option>
                                                    <option value="1">Laki-Laki</option>
                                                    <option value="0">Perempuan</option>
                                                </select>
                                            </div>
                                            @error('gender')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="status_pernikahan" class="form-label">Status Pernikahan<span
                                                    class="text-danger">*</span></label>
                                            <div wire:ignore>
                                                <select
                                                    class="form-control @error('status_pernikahan') is-invalid @enderror"
                                                    id="status_pernikahan" style="height: 35px;width:100%"
                                                    name="status_pernikahan" aria-label="Default select example"
                                                    wire:model="status_pernikahan">
                                                    <option value="" selected>Pilih Status Pernikahan</option>
                                                    <option value="Belum Menikah">Belum Menikah</option>
                                                    <option value="Menikah">Menikah</option>
                                                    <option value="Janda">Janda</option>
                                                </select>
                                            </div>
                                            @error('status_pernikahan')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="address" class="form-label">Alamat Domisili<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" style="height:35px"
                                                class="form-control @error('address') is-invalid @enderror"
                                                id="address" wire:model="address">
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="city" class="form-label">Kota Domisili<span
                                                    class="text-danger">*</span></label>
                                            <div wire:ignore>
                                                <select
                                                    class="form-control select2 @error('city') is-invalid @enderror"
                                                    id="city" name="city" aria-label="Default select example"
                                                    wire:model="city" style="width: 100%">
                                                    <option value="" selected>Pilih Kota Domisili</option>
                                                    @foreach ($cities as $c)
                                                        <option value="{{ $c->name }}">{{ $c->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('city')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="job_id" class="form-label">Pekerjaan<span
                                                    class="text-danger">*</span></label>
                                            <div wire:ignore>
                                                <select class="form-control @error('job_id') is-invalid @enderror"
                                                    id="job_id" name="job_id" aria-label="Default select example"
                                                    wire:model="job_id" style="width: 100%">
                                                    <option value="" selected>Pilih Pekerjaan</option>
                                                    @foreach ($jobs as $j)
                                                        <option value="{{ $j->id }}">{{ $j->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('job_id')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="input3">No Handphone (Whatsapp Aktif)<span class="text-danger">*</span></label>
                                            <div class="input-group mt-1 @error('phone_number') is-invalid @enderror">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text fs-5" style="height:35px">+62</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control fs-5 @error('phone_number') is-invalid @enderror"
                                                    wire:model="phone_number" id="phone_number" pattern="[0-9]*"
                                                    oninput="this.value = this.value.replace(/\D+/g, '')"
                                                    style="height: 35px">
                                            </div>
                                            @error('phone_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row" x-bind:class="type != 'pasien_lama' ? 'd-none' : ''"
                                        x-data="{ isWeekend: false }">
                                        <div class="col-md-6 mb-3" wire:ignore>
                                            <label for="input2">Tanggal Lahir</label>
                                            <input type="text" date-picker
                                                class="form-control fs-5 mt-1 @error('dob_exist') is-invalid @enderror"
                                                wire:model="dob_exist" id="dob_exist" style="height: 35px">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="input1">NIK<span class="text-danger">*</span></label>
                                            <div class="input-group mt-1 @error('nik') is-invalid @enderror">
                                                <input type="text"
                                                    class="form-control fs-5 @error('nik_exist') is-invalid @enderror"
                                                    wire:model="nik_exist" id="nik_exist" name="nik_exist"
                                                    maxlength="16" pattern="[0-9]*"
                                                    oninput="this.value = this.value.replace(/\D+/g, '')"
                                                    style="height: 35px">
                                                <div class="input-group-prepend ">
                                                    <button type="button" wire:click="getPatient('nik')"
                                                        class="bg-warning border-0">
                                                        <div class="input-group-text py-2 bg-warning border-0"
                                                            style="height: 30px">
                                                            <i class="fas fa-search"></i>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('nik_exist')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="input2">Nama Lengkap</label>
                                            <input type="text"
                                                class="form-control fs-5 mt-2 @error('name_exist') is-invalid @enderror"
                                                wire:model="name_exist" disabled style="height: 35px">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="blood_type" class="form-label">Golongan Darah<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control fs-5 @error('blood_type_exist') is-invalid @enderror"
                                                wire:model="blood_type_exist" disabled id="blood_type_exist"
                                                style="height: 35px">

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="gender" class="form-label">Jenis Kelamin<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control fs-5 mt-2 @error('gender_exist') is-invalid @enderror"
                                                wire:model="gender_exist" disabled id="gender_exist"
                                                style="height: 35px">

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="status_pernikahan" class="form-label">Status Pernikahan<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control fs-5 mt-2 @error('status_pernikahan_exist') is-invalid @enderror"
                                                wire:model="status_pernikahan_exist" disabled
                                                id="status_pernikahan_exist" style="height: 35px">

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="address" class="form-label">Alamat Domisili<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" style="height:35px"
                                                class="form-control fs-5 mt-2 @error('address_exist') is-invalid @enderror"
                                                id="address_exist" wire:model="address_exist" disabled>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="city" class="form-label">Kota Domisili<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control fs-5 mt-2 @error('city_exist') is-invalid @enderror"
                                                wire:model="city_exist" disabled id="city_exist"
                                                style="height: 35px">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="job_id" class="form-label">Pekerjaan<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control fs-5 @error('job_id_exist') is-invalid @enderror"
                                                wire:model="job_id_exist" disabled id="job_id_exist"
                                                style="height: 35px">

                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="input3">No Handphone (Whatsapp Aktif)<span class="text-danger">*</span></label>
                                                <div class="input-group mt-2 @error('phone_number') is-invalid @enderror">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text fs-5" style="height:35px">+62</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control fs-5 @error('phone_number_exist') is-invalid @enderror"
                                                        wire:model="phone_number_exist" id="phone_number_exist"
                                                        pattern="[0-9]*"
                                                        oninput="this.value = this.value.replace(/\D+/g, '')"
                                                        style="height: 35px" disabled>

                                                </div>
                                                @error('phone_number_exist')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="branch_id" class="form-label">Lokasi Klinik<span
                                                    class="text-danger">*</span></label>
                                            <div wire:ignore>
                                                <select class="form-control @error('branch_id') is-invalid @enderror"
                                                    id="branch_id" name="branch_id"
                                                    aria-label="Default select example" wire:model="branch_id"
                                                    style="width: 100%">
                                                    <option value="" selected>Pilih Lokasi Klinik</option>
                                                    @foreach ($branches as $j)
                                                        <option value="{{ $j->id }}">{{ $j->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('branch_id')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3" wire:ignore>
                                            <label for="input2">Tanggal Appointment<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" date-picker
                                                class="form-control mt-1 fs-5 @error('appointment_date') is-invalid @enderror"
                                                x-on:change="(e)=> {
                                                        const selectedDate = new Date(e.target.value.split('-').reverse().join('-'));
                                                        isWeekend = selectedDate.getDay() === 6 || selectedDate.getDay() === 0;
                                                    }"
                                                wire:model.blur="appointment_date" id="appointment_date"
                                                style="height: 35px">
                                            @error('appointment_date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="estimated_arrival" class="form-label">Estimasi Kedatangan<span class="text-danger">*</span></label>
                                                    <div>
                                                        <select class="form-control fs-5 @error('estimated_arrival') is-invalid @enderror"
                                                            id="estimated_arrival" style="height: 35px;width:100%" name="estimated_arrival" aria-label="Default select example"
                                                            wire:model="estimated_arrival">
                                                            <option value="" selected>Pilih Estimasi waktu kedatangan</option>
                                                            @foreach ($estimated_arrivals as $ea)
                                                                <option value="{{$ea}}">{{$ea}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('estimated_arrival')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="estimated_hour" class="form-label">Estimasi Jam Kedatangan<span class="text-danger">*</span></label>
                                                    <div>
                                                        <select class="form-control fs-5 @error('estimated_hour') is-invalid @enderror"
                                                            id="estimated_hour" style="height: 35px;width:100%" name="estimated_hour" aria-label="Default select example"
                                                            wire:model="estimated_hour">
                                                            <option value="" selected>Pilih Estimasi Jam Kedatangan</option>
                                                            @foreach ($estimated_hours as $eh)
                                                                <option value="{{$eh}}">{{$eh}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('estimated_hour')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="poli" class="form-label">Poli Tujuan<span class="text-danger">*</span></label>
                                                    <div>
                                                        <select class="form-control fs-5 @error('poli') is-invalid @enderror"
                                                            id="poli" style="height: 35px;width:100%" name="poli" aria-label="Default select example"
                                                            wire:model.live="poli">
                                                            <option value="" selected>Pilih Poli</option>
                                                            @foreach ($polis as $p)
                                                                <option value="{{$p->name}}">{{$p->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('poli')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="checkup" class="form-label">Tujuan Pemeriksaan<span class="text-danger">*</span></label>
                                                    <div>
                                                        <select class="form-control fs-5 @error('checkup') is-invalid @enderror"
                                                            id="checkup" style="height: 35px;width:100%" name="checkup" aria-label="Default select example"
                                                            wire:model="checkup">
                                                            <option value="" selected>Pilih Tujuan Pemeriksaan</option>
                                                            @foreach ($checkups->checkups ?? [] as $checkup)
                                                                <option value="{{$checkup->name}}">{{$checkup->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('checkup')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>


                                    </div>
                                    <button type="button" wire:click="save()" class="btn btn-hero">Submit</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- contact left Img-->
            <div class="from-left d-none d-lg-block">
                <img src="{{ asset('assets/assets/img/gallery/form-image.jpg') }}" alt="">
            </div>
        </div>
        <!--? Blog start (Promo and Event) -->
        <div class="home_blog-area section-padding30">
            <div class="container">
                <div class="row justify-content-sm-center">
                    <div class="cl-xl-7 col-lg-8 col-md-10">
                        <!-- Section Tittle -->
                        <div class="section-tittle text-center mb-70">
                            <span>Promo And Event</span>
                            <h2>Promo dan Event Untuk Bunda</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($promos as $promo)
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="single-blogs mb-30">
                                <div class="blog-img">
                                    <img src="{{ $promo->cover ? asset('storage/' . $promo->cover) : asset('assets/assets/img/gallery/not-found.jpg') }}"
                                        alt="#">
                                </div>
                                <div class="blogs-cap">
                                    <div class="date-info">
                                        <span>{{ $promo->category }}</span>
                                        <p>{{ Carbon\Carbon::parse($promo->date)->format('d F Y') }}</p>
                                    </div>
                                    <h4><a href="#">{{ $promo->title }}</a></h4>
                                    <p>{!! nl2br(e($promo->description)) !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Blog End -->
    </main>
    <footer>
        <!--? Footer Start-->
        <div class="footer-area section-bg" data-background="assets/img/gallery/footer_bg.jpg">
            <div class="container">
                <div class="footer-top footer-padding">
                    <div class="row d-flex justify-content-between">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-8">
                            <div class="single-footer-caption mb-50">
                                <!-- logo -->
                                <div class="footer-logo">
                                    <a href="#"><img
                                            src="{{ asset('assets/assets/img/logo/logobm_footer.png') }}"
                                            alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-5">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4>Alamat</h4>
                                    <div class="footer-pera">
                                        <a href="https://www.google.com/maps/place/Praktik+dr.+Qurrata+Akyuni,+M.Ked.Klin.,+Sp.OG+Bermakna+Mulia+Dharmahusada/@-7.2659829,112.7616498,15z/data=!4m6!3m5!1s0x2dd7fb918182bc3b:0x15facb3bbab7a1b1!8m2!3d-7.2659829!4d112.7616498!16s%2Fg%2F11vqh_kh2_?hl=id&entry=ttu"
                                            target="_blank">
                                            <p class="info1">Jl. Dharmahusada No.14, Mojo</p>
                                        </a>
                                        <a target="_blank"
                                            href="https://www.google.com/maps/place/Praktek+dr.+Uning+Marlina,+MHSM.,SpOG/@-7.3058295,112.7811853,17z/data=!3m1!4b1!4m6!3m5!1s0x2dd7fb4f3cb782df:0x83cb2dce2b2645c7!8m2!3d-7.3058295!4d112.7811853!16s%2Fg%2F11h_bvbdcd?entry=ttu">
                                            <p class="info1">Jl. Dr. Ir. H. Soekarno No.247, MERR</p>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-number mb-50">
                                    <h4><span>+62 </span>81336835005</h4>
                                    {{-- <p>youremail@gmail.com</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-9 col-lg-8">
                            <div class="footer-copy-right">
                                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    Copyright &copy;
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script> All rights reserved | This template is made with <i
                                        class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
                                        target="_blank">Colorlib</a>
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4">
                            <!-- Footer Social -->
                            <div class="footer-social f-right">
                                <a target="_blank" href="https://www.facebook.com/kehamilanbermaknamulia/"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a target="_blank" href="#"><i class="fas fa-globe"></i></a>
                                <a target="_blank" href="https://www.instagram.com/bermakna.mulia/"><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End-->
    </footer>
    <!-- Scroll Up -->
    <div id="back-top">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>
    <!-- ? Preloader Start -->

    <!-- Preloader Start -->
    @assets
        <style>
            .select2-selection--single {
                display: none;
            }

            .select2-selection__rendered {
                line-height: 31px !important;
            }

            .select2-container .select2-selection--single {
                height: 35px !important;
            }

            .select2-selection__arrow {
                height: 34px !important;
            }

            .nav-pills .nav-link.active {
                background-color: #006A3A !important;
                color: #fff !important;
            }
            .select2-results__option, .select2-selection__rendered{
                font-size: 12px !important;
            }
        </style>
    @endassets

    @script
        <script>
            let disabledDaysIndexes = "{{$disabledDaysIndexes}}"
            console.log(disabledDaysIndexes)
            flatpickr($wire.$el.querySelector('#dob'), {
                dateFormat: "d-m-Y",
                "locale": "id",
                // altFormat: "d-m-Y",
                onClose: function(selectedDates, dateStr, instance) {
                    $wire.$set('dob', dateStr);
                },
                allowInput: true,
                // defaultDate: new Date()
            });
            flatpickr($wire.$el.querySelector('#dob_exist'), {
                dateFormat: "d-m-Y",
                "locale": "id",
                // altFormat: "d-m-Y",
                onClose: function(selectedDates, dateStr, instance) {
                    $wire.$set('dob_exist', dateStr);
                },
                allowInput: true,
                // defaultDate: new Date()
            });
            let flatpickrAppointment = flatpickr($wire.$el.querySelector('#appointment_date'), {
                dateFormat: "d-m-Y",
                "locale": "id",
                // altFormat: "d-m-Y",
                onClose: function(selectedDates, dateStr, instance) {
                    $wire.$set('appointment_date', dateStr);
                },
                allowInput: true,
                minDate: 'today',
                disable: [
                function(date) {
                    // Disable days based on the dynamic array
                    return disabledDaysIndexes.includes(date.getDay());
                }
            ]

            });
            $('#city').select2({
                tags: true,
                theme: 'bootstrap-5',
            });
            $('#job_id').select2({
                tags: true,
                theme: 'bootstrap-5',
            });
            $('#branch_id').select2({
                tags: true,
                theme: 'bootstrap-5',
            });
            $('#status_pernikahan').select2({
                tags: true,
                theme: 'bootstrap-5',
            });

            $('#blood_type').select2({
                theme: 'bootstrap-5',
            });
            $('#gender').select2({
                theme: 'bootstrap-5',
            });
            // $('#poli').select2({
            //     theme: 'bootstrap-5',
            // });
            $('#estimated_arrival').select2({
                theme: 'bootstrap-5',
            });

            $('#job_id').on('change', function(e) {
                var data = $('#job_id').select2("val");
                $wire.$set('job_id', data);
            });
            $('#branch_id').on('change', function(e) {
                var data = $('#branch_id').select2("val");
                $wire.$set('branch_id', data);
            });

            $('#city').on('change', function(e) {
                var data = $('#city').select2("val");
                $wire.$set('city', data);
            });
            $('#blood_type').on('change', function(e) {
                var data = $('#blood_type').select2("val");
                $wire.$set('blood_type', data);
            });
            $('#status_pernikahan').on('change', function(e) {
                var data = $('#status_pernikahan').select2("val");
                $wire.$set('status_pernikahan', data);
            });
            // $('#poli').on('change', function(e) {
            //     var data = $('#poli').select2("val");
            //     $wire.$set('poli', data);
            // });
            $('#estimated_arrival').on('change', function(e) {
                var data = $('#estimated_arrival').select2("val");
                $wire.$set('estimated_arrival', data);
            });
            $('#gender').on('change', function(e) {
                var data = $('#gender').select2("val");
                $wire.$set('gender', data);
            });

            $('#gender').val($wire.$get('gender')).trigger('change');

            Livewire.on('refresh-disabledDay', function(event) {
                flatpickrAppointment.set('disable', [
                    function (date) {
                        return event.disabledDaysIndexes.includes(date.getDay());
                    }
                ]);
            });
        </script>
    @endscript
