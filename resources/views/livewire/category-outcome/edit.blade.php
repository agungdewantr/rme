<form wire:submit="save" class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Kategori Pengeluaran</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="name" class="form-label">Kategori</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                wire:model="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" wire:model="is_active" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">Status</label>
              </div>
        </div>

    </div>

    <div class="card-footer d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModal')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
