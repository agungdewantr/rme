<x-slot:title>
    Forgot Password
</x-slot:title>

<div class="vw-100 vh-100 row justify-content-center align-items-center ms-1">
    <div class="card mb-3 col-lg-6" style="padding-left:0; padding-right:0; height:60% !important">
        <div class="row g-0 h-100 d-sm-flex justify-content-center align-items-center">
            <div class="col-md-5 align-self-center">
                <div class="ms-3 mt-3">
                    <h4 class="text-primary">Reset Password</h4>
                    <small class="">Masukkan alamat email terverifikasi akun pengguna Anda dan kami akan mengirimkan Anda tautan pengaturan ulang kata sandi</small>
                </div>
                <form class="card-body" wire:submit="save">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                            id="email" wire:model="email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="d-flex
                            justify-content-between align-items-center mb-3">
                        <button type="submit" class="btn btn-primary">Send Email</button>
                        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                            href="{{route('login')}}">
                            Kembali ke Login
                        </a>
                    </div>
                    {{-- <p>Belum punya akun? <a
                            class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                            href="{{ route('register') }}" wire:navigate>
                            Daftar Sekarang
                        </a></p> --}}
                </form>
            </div>
            <div class="col-md-7 col-6">
                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

                <dotlottie-player src="{{ asset('assets/img/Animation-1709105402949.json') }}" background="transparent"
                    speed="1" style="width: 100%; height: 100%;" loop autoplay></dotlottie-player>
            </div>
        </div>
    </div>
</div>
