<form wire:submit="save" class="card" id="modal">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Booking</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row" x-data="{ isWeekend: false }">
            <div class="col-md-12">
                <div class="mb-3" wire:ignore>
                    <label for="user_id" class="form-label">Nama Pasien</label><br>
                    <select style="width: 100%" class="form-select   @error('user_id') is-invalid @enderror"
                        id="user_id" name="user_id" aria-label="Default select example" wire:model="user_id">
                        <option selected>Pilih Nama Pasien</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} - {{ $u->patient->nik }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="branch_id" class="form-label">Lokasi Klinik</label>
                    <select class="form-select @error('branch_id') is-invalid @enderror" disabled id="branch_id"
                        name="branch_id" aria-label="Default select example" wire:model="branch_id">
                        <option selected>Pilih Lokasi Klinik</option>
                        @foreach ($branches as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal Appointment</label>
                    <div wire:ignore class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-calendar-days"></i>
                        </span>
                        <input type="text" date-picker name="date" class="form-control"
                            x-on:change="(e)=> {
                            const selectedDate = new Date(e.target.value.split('-').reverse().join('-'));
                            isWeekend = selectedDate.getDay() === 6 || selectedDate.getDay() === 0;
                        }">
                    </div>
                    @error('date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="poli" class="form-label">Poli Tujuan</label>
                    <select class="form-select @error('poli') is-invalid @enderror" id="poli" name="poli"
                        aria-label="Default select example" wire:model.live="poli">
                        <option value="" selected>Pilih Poli Tujuan</option>
                        @foreach ($polis as $poli)
                        <option value="{{$poli->name}}">{{$poli->name}}</option>
                        @endforeach
                    </select>
                    @error('poli')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="poli" class="form-label">Tujuan Pemeriksaan</label>
                    <select class="form-select @error('checkup') is-invalid @enderror" id="checkup" name="checkup"
                        aria-label="Default select example" wire:model="checkup">
                        <option value="" selected>Pilih Poli Tujuan</option>
                        @foreach ($checkups->checkups ?? [] as $checkup)
                        <option value="{{$checkup->name}}">{{$checkup->name}}</option>
                        @endforeach
                    </select>
                    @error('poli')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="mb-3">
                    <label for="estimated_arrival" class="form-label">Estimasi Waktu Kedatangan</label>
                    <select class="form-select @error('estimated_arrival') is-invalid @enderror" id="estimated_arrival"
                        name="estimated_arrival" aria-label="Default select example" wire:model.live="estimated_arrival">
                        <option value="" selected>Pilih Estimasi waktu kedatangan</option>
                        @foreach ($estimated_arrivals as $ea)
                        <option value="{{$ea}}">{{$ea}}</option>
                        @endforeach
                    </select>
                    {{-- <select x-data="{ isWeekend: false }" x-init="() => {
                        const dateInput = document.querySelector('input[name=date]');
                        dateInput.addEventListener('change', (e) => {
                            const selectedDate = new Date(e.target.value.split('-').reverse().join('-'));
                            isWeekend = selectedDate.getDay() === 6 || selectedDate.getDay() === 0;
                            console.log(isWeekend)
                        });
                }">
                    <option selected>Pilih Estimasi Waktu Kedatangan</option>
                    <template x-if="isWeekend">
                        <option value="Poli Sore">Poli Sore</option>
                        <option value="Poli Pagi (Sabtu & Minggu)">Poli Pagi (Sabtu & Minggu)</option>
                    </template>
                    <template x-if="!isWeekend">
                        <option value="Poli Sore">Poli Sore</option>
                    </template>
                </select> --}}
                    @error('estimated_arrival')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="estimated_hour" class="form-label">Estimasi Jam Kedatangan</label>
                    <select class="form-select @error('estimated_hour') is-invalid @enderror" id="estimated_hour" name="estimated_hour"
                        aria-label="Default select example" wire:model="estimated_hour">
                        <option value="" selected>Pilih Estimasi Jam Kedatangan </option>
                        @foreach ($estimated_hours as $eh)
                        <option value="{{$eh}}">{{$eh}}</option>
                        @endforeach
                    </select>
                    @error('estimated_hour')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="mb-3">
                    <label for="finance_type" class="form-label">Jenis Pembiayaan</label>
                    <select class="form-select @error('finance_type') is-invalid @enderror" id="finance_type"
                        name="finance_type" aria-label="Default select example" wire:model="finance_type">
                        <option selected>Pilih Jenis Pembiayaan</option>
                        <option value="BPJS">BPJS</option>
                        <option value="Umum">Umum</option>
                        <option value="Asuransi">Asuransi</option>
                    </select>
                    @error('finance_type')
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
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
@endassets

@script
    <script>
        $("#user_id").select2({
            theme: 'bootstrap-5',
            dropdownParent: $("#modal"),
            // tags: true,

        });

        $("#user_id").on('change', function(e) {
            var data = $('#user_id').select2("val");
            $wire.$set('user_id', data);

        });
        flatpickr($wire.$el.querySelector('[date-picker]'), {
            dateFormat: "d-m-Y",
            onClose: function(selectedDates, dateStr, instance) {
                $wire.$set('date', dateStr);
            },
            defaultDate: new Date(),
            allowInput: true,
            dateFormat: "d-m-Y"
        });
    </script>
@endscript
