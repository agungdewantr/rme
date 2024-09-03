<form wire:submit="save" class="card" id="modal">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Penyakit Terdahulu</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="mb-3">
                <label for="illness_id" class="form-label">Nama Penyakit Terdahulu</label>
                <div wire:ignore>
                    <select class="form-select @error('illness_id') is-invalid @enderror" id="illness_id" name="illness_id" aria-label="Default select example">
                        <option value="" selected>Pilih Penyakit Terdahulu</option>
                        @foreach ($illness as $i)
                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('illness_id')
                <div class="text-danger tw-text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="therapy" class="form-label">Terapi</label>
                <input type="text" name="therapy" id="therapy" class="form-control @error('therapy') is-invalid @enderror" wire:model="therapy">
                @error('therapy')
                <div class="invalid-feedback">
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
    $("#illness_id").select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#modal"),
        tags: true,
    })
    $("#illness_id").on('change', (e) => {
        $wire.$set('illness_id', $(e.target).select2('val'))
    })
</script>
@endscript
