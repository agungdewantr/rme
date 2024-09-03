<x-slot:title>
    Login
</x-slot:title>

<div class="vw-100 vh-100 row justify-content-center align-items-center ms-1">
    <div class="card mb-3 col-lg-6" style=" height:60% !important;">
        <div class="row g-0 h-100 d-sm-flex justify-content-center align-items-center">
            <div class="col-md-5 align-self-center">
                <form class="card-body" wire:submit="save">
                    <div class="mb-3">
                        <label for="email_nik" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email_nik') is-invalid @enderror"
                            id="email_nik" wire:model="email_nik">
                        @error('email_nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3" x-data="{ showPassword: false }">
                        <label for="password" class="form-label">Password</label>
                        <input x-bind:type="showPassword ? 'text' : 'password'"
                            class="form-control @error('password') is-invalid" @enderror id="password"
                            wire:model="password">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="view-password"
                                x-on:change="(e)=>{
                                    if(e.target.checked){
                                        showPassword = true;
                                    }else{
                                        showPassword = false;
                                    }
                                }">
                            <label class="form-check-label" for="view-password">
                                Lihat Password
                            </label>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- <div class="d-flex
                            justify-content-between align-items-center mb-3">
                        <button type="submit" class="btn btn-primary col-sm-12">Login</button>
                        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                            href="{{route('forgot-password')}}">
                            Lupa Password?
                        </a>
                    </div> --}}
                    {{-- <div class="row">
                        <div class="col-sm-12 mb-3">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <div class="col-sm-12">
                            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-center"
                                href="{{route('forgot-password')}}">
                                Lupa Password?
                            </a>
                        </div>
                    </div> --}}
                    <div class="d-md-flex justify-content-md-between align-items-md-center mb-3">
                        <div class="mb-3 mb-md-0">
                            <button type="submit" class="btn btn-primary btn-block btn-md-auto col-12">Login</button>
                        </div>
                        <div class="mb-3 mb-md-0 text-md-right">
                            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                href="{{ route('forgot-password') }}">
                                Lupa Password?
                            </a>
                        </div>
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
                    speed="1" style="height: 100%;" loop autoplay></dotlottie-player>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('login', () => {
            Livewire.dispatch('openModal', {
                component: 'global-filter'
            })
        })
    })
</script>
