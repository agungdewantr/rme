<form wire:submit="save" class="card" id="modal">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Penyakit Keluarga</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="mb-3">
                <label for="relationship" class="form-label">Hubungan</label>
                <div wire:ignore>
                    <select class="form-select @error('relationship') is-invalid @enderror" id="relationship" wire:model.live="relationship" name="relationship" aria-label="Default select example">
                        <option value="" selected>Pilih Hubungan</option>
                        <option value="Suami">Suami</option>
                        <option value="Bapak">Bapak</option>
                        <option value="Ibu">Ibu</option>
                        <option value="Anak">Anak</option>
                        <option value="Saudara">Saudara</option>
                    </select>
                </div>
                @error('relationship')
                <div class="text-danger tw-text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" wire:model="name">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="disease_name" class="form-label">Nama Penyakit</label>
                <div wire:ignore>
                    <select class="form-select @error('disease_name') is-invalid @enderror" id="disease_name" name="disease_name" aria-label="Default select example">
                        <option value="" selected>Pilih Penyakit</option>
                        @foreach ($illness as $i)
                        <option value="{{ $i->name }}">{{ $i->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('disease_name')
                <div class="text-danger tw-text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModal')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

@script
<script>
    $("#disease_name").select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#modal"),
        tags: true,
    })
    $("#disease_name").on('change', (e) => {
        $wire.$set('disease_name', $(e.target).select2('val'))
    })
    $("#relationship").select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#modal"),
    })
    $("#relationship").on('change', (e) => {
        $wire.$set('relationship', $(e.target).select2('val'))
    })
</script>
@endscript
