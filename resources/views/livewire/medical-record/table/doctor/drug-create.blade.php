<form wire:submit="save" class="card" id="modal">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Resep</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="drug_med_dev_id" class="form-label">Nama Obat atau Alkes</label>
                    <select name="drug_med_dev_id" id="drug_med_dev_id" wire:model="drug_med_dev_id"
                        class="form-select @error('drug_med_dev_id') is-invalid @enderror">
                        <option value="">Pilih Nama Obat/Alkes</option>
                        @foreach ($drugs as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}
                                ({{ $d->batches?->sum('qty') ?? 0 }})</option>
                        @endforeach
                    </select>
                    @error('drug_med_dev_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="total" class="form-label">Jumlah</label>
                    <input type="text" class="form-control @error('total') is-invalid @enderror" id="total"
                        wire:model="total">
                    @error('total')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="rule" class="form-label">Aturan Pakai</label>
                    <input type="text" class="form-control @error('rule') is-invalid @enderror" id="rule"
                        wire:model="rule">
                    @error('rule')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="how_to_use" class="form-label">Cara Pakai</label>
                    <input type="text" class="form-control @error('how_to_use') is-invalid @enderror" id="how_to_use"
                        wire:model="how_to_use">
                    @error('how_to_use')
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
        $("#drug_med_dev_id").select2({
            theme: 'bootstrap-5',
            dropdownParent: $("#modal"),
        })
        $("#drug_med_dev_id").on('change', (e) => {
            $wire.$set('drug_med_dev_id', $(e.target).select2('val'))
        })
    </script>
@endscript
