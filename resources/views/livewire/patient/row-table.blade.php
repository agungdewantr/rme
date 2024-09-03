<tr class="text-center">
    <td>{{ $iteration }}</td>
    <td>
        <input type="text" placeholder="Nama" wire:model.blur="name">
    </td>
    <td>
        <select name="" wire:model.live="relationship" id="">
            <option value="" selected>Pilih Hubungan</option>
            <option value="Suami">Suami</option>
            <option value="Orang tua">Orang tua</option>
            <option value="Saudara">Saudara</option>
            <option value="Lainnya">Lainnya</option>
        </select>
        {{-- <input type="text" placeholder="Hubungan" wire:model.blur="relationship"> --}}
    </td>
    <td><input type="text" placeholder="Nomor Telepon" wire:model.blur="phone_number" pattern="[0-9]*"
        oninput="this.value = this.value.replace(/\D+/g, '')">
    </td>
    <td><input type="text" placeholder="Alamat" wire:model.blur="address">
    </td>
    <td wire:ignore>
        {{-- <input type="text" placeholder="Pekerjaan" wire:model.blur="job"> --}}
        <select name="" id="" class="form-control" x-init="() => {
            $($el).select2({
                placeholder: 'Pilih Pekerjaan',
                width: '100%',
                theme: 'bootstrap-5',
                tags: true
            })
            $($el).on('change', function(e) {
               @this.set('job', $el.value)
            })
            const job = $wire.$get('job');
            if(job){
                $($el).val(job).trigger('change');

            }


            }">
            <option value="" selected>Pilih Pekerjaan</option>
            @foreach ($jobs as $j)
                <option value="{{ $j->name }}">{{ $j->name }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <button type="button" class="btn btn-sm btn-danger" wire:click="delete">
            <i class="fa-solid fa-trash"></i>
        </button>
        <button type="button" class="btn btn-sm btn-info" wire:click="setHusband" title="Sama Dengan Data Suami" @if($relationship != 'Suami') disabled @endif>
            <i class="fa-solid fa-check-to-slot"></i>
        </button>
    </td>
</tr>
