<tr x-data="{ age: '' }">
    <td>{{ $iteration }}</td>
    <td>
        <input type="text" name="type_of_birth" id="type_of_birth" wire:model.blur="type_of_birth"
             x-ref="type_of_birth" placeholder="Jenis Persalinan...">
    </td>
    <td>
        <select name="gender" id="gender" class="form-control @error('field')

        @enderror"
            wire:model.live="gender">
            <option value="" selected>Pilih Jenis Kelamin</option>
            <option value="1">Laki-laki</option>
            <option value="0">Perempuan</option>
            <option value="5">IUFD</option>
            {{-- <option value="2">Keguguran</option> --}}
            {{-- <option value="3">Hamil INI</option> --}}
        </select>
    </td>
    <td>
        <div class="input-group flex-nowrap" style="width: 100%">
            <input type="text" class="form-control" placeholder="0" name="weight" id="weight"
                @if ($gender == 3 || $gender == 2) disabled @endif wire:model.blur="weight"
                aria-describedby="addon-wrapping">
            <span class="input-group-text" id="weight">gr</span>
        </div>
    </td>
    <td>
        <div class="input-group flex-nowrap" style="width: 100%">
            <input type="text" class="form-control" placeholder="0" name="age" id="age" @if ($gender == 3 || $gender == 2) disabled @endif wire:model.blur="age" aria-describedby="addon-wrapping">
            <span class="input-group-text" id="age">tahun</span>
        </div>
        {{-- <input type="text" disabled id="age" wire:model.blur="age" x-ref="age" > --}}
    </td>


    <td><input type="text" name="" id="" wire:model.blur="clinical_information"
             x-ref="clinical_information"
            placeholder="Keterangan klinis...">
    </td>
    <td>
        <button type="button" class="btn btn-sm btn-danger" wire:click="delete({{ $tmpId }})">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </td>

</tr>

@assets
    <script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/dayjs/customParseFormat.js') }}"></script>
@endassets

{{-- @script
    <script>
        dayjs.extend(window.dayjs_plugin_customParseFormat)
        flatpickr($wire.$el.querySelector('[date-picker]'), {
            dateFormat: "d-m-Y",
            "locale": "id",
            onClose: function(selectedDates, dateStr, instance) {
                $wire.$set('birth_date', dateStr);
            },
            defaultDate: null
        });
    </script>
@endscript --}}
