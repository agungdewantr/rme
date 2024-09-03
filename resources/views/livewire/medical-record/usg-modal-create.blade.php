<form wire:submit="save" class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah USG</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="usg_id" class="form-label">ID USG</label>
                    <input type="text" class="form-control @error('usg_id') is-invalid @enderror" id="usg_id"
                        wire:model="usg_id" readonly>
                    @error('usg_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="file" class="form-label">File</label>
                    <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                        wire:model="file" accept="image/*">
                    @error('file')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="text" date-picker class="form-control @error('date') is-invalid @enderror" id="date"
                        wire:model="date">
                    @error('date')
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

@assets
    <script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
@endassets

@script
<script>
        flatpickr($wire.$el.querySelector('[date-picker]'), {
            dateFormat: "d-m-Y",
            "locale": "id",
            // altFormat: "d-m-Y",
            onClose: function(selectedDates, dateStr, instance) {
                    $wire.$set('date', dateStr);
                },
            defaultDate: new Date()
        });
</script>
@endscript
