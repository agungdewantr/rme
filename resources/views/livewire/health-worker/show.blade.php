<form wire:submit="save" class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Detail Tenaga Kesehatan</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Nakes</label>
                    <input type="text" class="form-control" id="name" disabled
                        value="{{ $healthWorker->name }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="gender" name="gender" aria-label="Default select example"
                        disabled>
                        <option value="1" @if ($healthWorker->gender) selected @endif>Laki-Laki</option>
                        <option value="0" @if (!$healthWorker->gender) selected @endif>Perempuan</option>
                    </select>

                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Handphone</label>
                    <input type="text" class="form-control" id="phone_number" disabled
                        value="{{ $healthWorker->phone_number }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="position" class="form-label">Posisi</label>
                    <select class="form-select" id="position" name="position" aria-label="Default select example"
                        disabled>
                        <option value="Dokter" @if ($healthWorker->position == 'Dokter') selected @endif>Dokter</option>
                        <option value="Perawat" @if ($healthWorker->position == 'Perawat') selected @endif>Perawat</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" disabled
                        value="{{ $healthWorker->email }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="practice_license" class="form-label">No. Izin Praktek</label>
                    <input type="text" class="form-control" id="practice_license" disabled
                        value="{{ $healthWorker->practice_license }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="address" disabled
                        value="{{ $healthWorker->address }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" aria-label="Default select example"
                        disabled>
                        <option value="1" @if ($healthWorker->status) selected @endif>Aktif</option>
                        <option value="0" @if (!$healthWorker->status) selected @endif>Non Aktif</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>
