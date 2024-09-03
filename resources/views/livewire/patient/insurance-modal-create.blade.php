<form wire:submit="save" class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Asuransi</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Asuransi</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                wire:model="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="number" class="form-label">Nomor Asuransi</label>
            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"
                wire:model="number">
            @error('number')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModal')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
