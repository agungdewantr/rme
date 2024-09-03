<x-slot:title>
    Register
</x-slot:title>

<div class="vw-100 vh-100 row justify-content-center align-items-center">
    <div class="card mb-3 col-8" style="padding-left:0; padding-right:0">
        <div class="row g-0 h-100">
            <div class="col-md-5 align-self-center">
                <form class="card-body" wire:submit="save">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            wire:model="name" placeholder="Nama Lengkap">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control @error('nik') is-invalid" @enderror id="nik"
                            wire:model="nik" placeholder="NIK">
                        @error('nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Nomor Handphone</label>
                        <input type="text"
                            class="form-control @error('phone_number') is-invalid" @enderror id="phone_number"
                            wire:model="phone_number" placeholder="Nomor Handphone">
                        @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid" @enderror id="email"
                            wire:model="email" placeholder="Email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                            class="form-control @error('password') is-invalid" @enderror id="password"
                            wire:model="password" placeholder="Password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password"
                            class="form-control @error('password_confirmation') is-invalid" @enderror id="password_confirmation"
                            wire:model="password_confirmation" placeholder="Konfirmasi Password">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="d-flex
                            justify-content-between align-items-center mb-3">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <p>Sudah punya akun? <a
                            class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                            href="{{ route('login') }}" wire:navigate>
                            Login Sekarang
                        </a></p>
                </form>
            </div>
            <div class="col-md-7">
                <img src="https://picsum.photos/1920/1080" class="w-100 h-100 rounded-end"
                    style="object-fit: cover; object-position: center" alt="login picture">
            </div>
        </div>
    </div>
</div>
