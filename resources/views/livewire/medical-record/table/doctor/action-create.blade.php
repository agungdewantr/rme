<form wire:submit="save" class="card" id="modal">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Tindakan</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="action_id" class="form-label">Nama Tindakan</label>
                    <select name="action_id" id="action_id" wire:model="action_id"
                        class="form-select @error('action_id') is-invalid @enderror">
                        <option value="">Pilih Nama Tindakan</option>
                        @foreach ($actions as $a)
                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                        @endforeach
                    </select>
                    @error('action_id')
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
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

@script
<script>
    $("#action_id").select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#modal"),
        // tags: true,
    })
    $("#action_id").on('change', (e) => {
        $wire.$set('action_id', $(e.target).select2('val'))
    })
</script>
@endscript
