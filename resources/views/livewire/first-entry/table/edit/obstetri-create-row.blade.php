<tr x-data="{ age: @entangle('age') }">
    <td class="text-center">{{ $iteration }}</td>
    <td>
        {{-- <input type="text" name="type_of_birth" id="type_of_birth" wire:model.blur="type_of_birth"
            placeholder="Jenis Persalinan..."> --}}
            <select name="type_of_birth" id="type_of_birth" wire:model.live="type_of_birth" class="form-control @error('type_of_birth') @enderror">
            <option value="" selected>Pilih Jenis Persalinan</option>
            <option value="SC">SC</option>
            <option value="Spontan Kepala">Spontan Kepala</option>
            <option value="Spontan Sungsang">Spontan Sungsang</option>
            <option value="Hamil INI">Hamil INI</option>
            <option value="Vacuum/Forcep">Vacuum/Forcep</option>
            <option value="Laparatomi">Laparatomi</option>
            <option value="Abortus">Abortus</option>
                        </select>
    </td>
    <td>
        <select name="gender" id="gender" class="form-control @error('gender')
        @enderror"
            wire:model.live="gender" @if ($type_of_birth == 'Hamil INI' || $type_of_birth == 'Abortus') disabled @endif >
            <option value="" selected>Pilih Jenis Kelamin</option>
            <option value="1">Laki-laki</option>
            <option value="0">Perempuan</option>
            <option value="5">IUFD</option>
            {{-- <option value="2">Keguguran</option> --}}
            {{-- <option value="3">Hamil INI</option> --}}
        </select>
    </td>
    <td>
        <div class="input-group flex-nowrap" style="width: 50%">
            <input type="text" class="form-control" placeholder="0" name="weight" id="weight"  @if ($type_of_birth == 'Hamil INI' || $type_of_birth == 'Abortus' || $gender == 2 || $gender == 3) disabled @endif
                wire:model.blur="weight" aria-describedby="addon-wrapping">
            <span class="input-group-text" id="weight">gr</span>
        </div>
    </td>
    {{-- <td>
        <div wire:ignore class="input-group">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-calendar-days"></i>
            </span>
            <input type="text" date-picker name="birth_date" wire:model="birth_date"
                class="form-control @error('birth_date') is-invalid @enderror"
                x-on:change="(e)=>{
                let years = dayjs().diff(dayjs(e.target.value, 'DD-MM-YYYY'), 'years');
                let months = dayjs().diff(dayjs(e.target.value, 'DD-MM-YYYY'), 'months') - years * 12;
                age = `${years} tahun, ${months} bulan`
                }">
            @error('birth_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </td> --}}
    <td>
        <div class="input-group flex-nowrap" style="width: 50%">
            <input type="text" class="form-control" placeholder="0" name="age" id="age" @if ($type_of_birth == 'Hamil INI' || $type_of_birth == 'Abortus' || $gender == 2 || $gender == 3) disabled @endif
                wire:model.blur="age" aria-describedby="addon-wrapping">
            <span class="input-group-text" id="age">tahun</span>
        </div>
    </td>
    <td><input type="text" name="" id="" wire:model.blur="clinical_information"
            placeholder="Keterangan klinis..."></td>
    <td>
        @if(Carbon\Carbon::parse($created_at)->format('Y-m-d') == Carbon\Carbon::now()->format('Y-m-d'))
        <button type="button" class="btn btn-sm btn-danger" wire:click="delete">
            <i class="fa-solid fa-xmark"></i>
        </button>
        @endif
    </td>

</tr>

@assets
    <script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/dayjs/customParseFormat.js') }}"></script>
@endassets
