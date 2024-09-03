<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Detail Booking</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="user" class="form-label">Nama Pasien</label>
                    <input disabled type="text" class="form-control" id="user"
                        value="{{ $registration->user->name }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal</label>
                    <input disabled type="date" class="form-control" id="date"
                        value="{{ $registration->date }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="estimated_arrival" class="form-label">Estimasi Waktu Kedatangan</label>
                    <input disabled type="text" class="form-control" id="estimated_arrival"
                        value="{{ $registration->estimated_arrival }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="type" class="form-label">Poli Tujuan</label>
                    <input disabled type="text" class="form-control" id="type"
                        value="{{ $registration->poli }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="branch" class="form-label">Lokasi Klinik</label>
                    <input disabled type="text" class="form-control" id="branch"
                        value="{{ $registration->branch->name }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="type" class="form-label">Jenis Pembiayaan</label>
                    <input disabled type="text" class="form-control" id="type"
                        value="{{ $registration->finance_type }}">
                </div>
            </div>
        </div>
    </div>
</div>
