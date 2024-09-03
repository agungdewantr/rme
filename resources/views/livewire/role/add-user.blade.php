<form wire:submit="save" class="card" id="modal">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah User</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body" id="uhuk">
        <div class="row">
            <div class="mb-3" wire:ignore>
                <label for="user_id" class="form-label">Nama User</label>
                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" aria-label="Default select example">
                    <option selected>Pilih Nama User</option>
                    @foreach ($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
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
    $("#user_id").select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#modal")
    })
    $("#user_id").on('change', (e) => {
        $wire.$set('user_id', $(e.target).select2('val'))
    })
</script>
@endscript
