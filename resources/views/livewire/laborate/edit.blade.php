<form wire:submit="save" class="card" id="modal">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Detail Laborate</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="user_id" class="form-label">Nama Laborate</label><br>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        wire:model="name" wire:loading.attr="disabled" wire:target="save">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="type" class="form-label">Tipe Laborate</label>
                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type"
                        aria-label="Default select example" wire:model="type" wire:loading.attr="disabled"
                        wire:target="save">
                        <option value="" selected>Pilih Tipe</option>
                        <option value="Internal">Internal</option>
                        <option value="Eksternal">Eksternal</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="user_id" class="form-label">Harga</label><br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Rp</div>
                        </div>
                        <input type="text" class="form-control @error('price') is-invalid @enderror"
                            wire:model="price" id="price" wire:loading.attr="disabled" wire:target="save">
                    </div>
                    @error('price')
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
        <button type="submit" wire:dirty class="btn btn-primary" wire:loading.attr="disabled">
            <div class="spinner-border spinner-border-sm" wire:loading role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            Simpan
        </button>
    </div>
</form>
