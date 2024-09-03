<form wire:submit="save" class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Promo & Event</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        wire:model="title">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category"
                        aria-label="Default select example" wire:model="category">
                        <option value="" selected>Pilih Kategori</option>
                        <option value="Promo">Promo</option>
                        <option value="Event">Event</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <div wire:ignore>
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                        wire:model="date">
                    </div>
                    @error('date')
                        <div class="text-danger tw-text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="cover" class="form-label">Cover</label>
                    <input type="file" class="form-control @error('cover') is-invalid @enderror"
                        id="cover" wire:model="cover">
                    @error('cover')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="" id=""  wire:model="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    @if ($cover)
                    <img src="{{ $cover ? $cover->temporaryUrl() : asset('storage/' . $promo->cover) }}" alt="#">
                    @else
                @endif
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
        flatpickr($wire.$el.querySelector('#date'), {
            dateFormat: "d-m-Y",
            "locale": "id",
            minDate: 'today',
            allowInput: true,
            // defaultDate: new Date()
        });

</script>
@endscript
