<form wire:submit="save" class="card" id="modal" x-data="laborate">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Laborate</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="lab_id" class="form-label">Nama Lab</label>
                    <select id="lab_id" class="form-select @error('lab_id') is-invalid @enderror">
                        <option value="">Pilih Nama Lab</option>
                        @foreach ($laborates as $l)
                            <option value="{{ $l->id }}">{{ $l->name }}</option>
                        @endforeach
                    </select>
                    @error('lab_id')
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
        Alpine.data('laborate', () => ({
            lab_id: @entangle('lab_id'),
            select2: null,

            init() {
                this.select2 = $("#lab_id").select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $("#modal"),
                    tags: true,
                })

                this.select2.on('select2:select', (e) => {
                    this.lab_id = e.target.value
                })

                this.$watch('lab_id', (value) => {
                    this.select2.val(value).trigger("change")
                })
            }
        }))
    </script>
@endscript
