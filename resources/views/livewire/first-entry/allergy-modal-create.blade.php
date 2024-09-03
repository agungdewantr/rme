<form wire:submit="save" class="card" id="modal">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Alergi</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="mb-3">
                <label for="allergy_id" class="form-label">Nama Alergi</label>
                <div  wire:ignore>
                    <select class="form-select @error('allergy_id') is-invalid @enderror" id="allergy_id" name="allergy_id" aria-label="Default select example">
                        <option value="" selected>Pilih Alergi</option>
                        @foreach ($allergy as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>

                @error('allergy_id')
                <div class="text-danger tw-text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Tanda & Gejala</label>
                <input type="text" class="form-control" wire:model="indication">
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
    $("#allergy_id").select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#modal"),
        tags: true,
    })
    $("#allergy_id").on('change', (e) => {
        $wire.$set('allergy_id', $(e.target).select2('val'))
    })
</script>
@endscript
