<form wire:submit="save" class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Ubah Profil</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        wire:model="name">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        wire:model="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row"  x-data="{showPassword: false}">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input x-bind:type="showPassword  ? 'text' : 'password'" class="form-control @error('password') is-invalid @enderror"
                        id="password" wire:model="password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input x-bind:type="showPassword  ? 'text' : 'password'" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password"
                        wire:model="confirm_password">
                    @error('confirm_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-check ms-2">
                <input class="form-check-input" type="checkbox" value="" id="view-password"
                x-on:change="(e)=>{
                    if(e.target.checked){
                        showPassword = true;
                    }else{
                        showPassword = false;
                    }
                }"
                >
                <label class="form-check-label" for="view-password">
                  Lihat Password
                </label>
              </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModal')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
