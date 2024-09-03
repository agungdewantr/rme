<form wire:submit="save" class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Ubah Tenaga Kesehatan</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Nakes</label>
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
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender"
                        aria-label="Default select example" wire:model="gender">
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
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Handphone</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">+62</div>
                        </div>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                            wire:model="phone_number" id="phone_number" pattern="[0-9]*"
                            oninput="this.value = this.value.replace(/\D+/g, '')">
                    </div>
                    @error('phone_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="position" class="form-label">Posisi</label>
                    <select class="form-select @error('position') is-invalid @enderror" id="position" name="position"
                        aria-label="Default select example" wire:model="position">
                        <option selected>Pilih Posisi</option>
                        <option value="Dokter">Dokter</option>
                        <option value="Perawat">Perawat</option>
                    </select>
                    @error('position')
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
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="practice_license" class="form-label">No. Izin Praktek</label>
                    <input type="text" class="form-control @error('practice_license') is-invalid @enderror"
                        id="practice_license" wire:model="practice_license">
                    @error('practice_license')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                        wire:model="address">
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                        aria-label="Default select example" wire:model="status">
                        <option selected>Pilih Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Non Aktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModal')">Batal</button>
        <button type="submit" class="btn btn-primary" wire:dirty>Simpan</button>
    </div>
</form>
