<form wire:submit="save" class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Tindakan</span>
        <button class="btn" type="button" wire:click="close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Cabang</label>
                    <select class="form-select @error('branch') is-invalid @enderror" wire:model="branch"
                        aria-label="Default select example">
                        <option selected>--Pilih Cabang--</option>
                        @foreach ($branches as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                    @error('branch')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            @if (auth()->user() && auth()->user()->role->name != 'doctor')
                <div class="col">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Dokter</label>
                        <select class="form-select @error('doctor') is-invalid @enderror" wire:model="doctor"
                            aria-label="Default select example">
                            <option selected>--Pilih Dokter--</option>
                            @foreach ($doctors as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <div class="flex justify-content-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
