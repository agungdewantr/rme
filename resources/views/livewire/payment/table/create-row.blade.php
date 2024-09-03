<tr>
    <td>{{ $iteration }}</td>
    <td style="width:250px" wire:ignore>
        <select name="drug_action_id" class="form-select" x-init="() => {
            $($el).select2({
                placeholder: 'Pilih {{ $type_row == 'drug' ? 'Obat/Alkes' : 'Tindakan' }}',
                width: '100%',
                theme: 'bootstrap-5',
            })
            $($el).on('change', function() {
                @this.set('drug_action_id', $el.value)
            })
            const drug_action_id = $wire.$get('drug_action_id');
            if(drug_action_id){
                $($el).val(drug_action_id).trigger('change');
            }
        }">
            <option value="">Pilih Obat/Alkes</option>
            @if ($type_row == 'drug')
                @foreach ($drugMedDevs as $dmd)
                    <option value="{{ $dmd->id }}-drug">{{ $dmd->name }}</option>
                @endforeach
            @else
                @foreach ($actions as $action)
                    <option value="{{ $action->id }}-action">{{ $action->name }}</option>
                @endforeach
            @endif
        </select>
    </td>
    <td>
        <input type="text" placeholder="0" wire:model.blur="qty">
    </td>
    <td style="vertical-align: middle">{{ $uom }}</td>
    <td style="vertical-align: middle">{{ $type }}</td>
    <td style="vertical-align: middle">Rp{{ number_format($price, 0, '.', '.') }}</td>
    <td><input type="text" placeholder="Rp0" wire:model.blur="discount"
            x-on:focus="
        if (!$event.target.value.includes('Rp')) {
            $event.target.value = 'Rp' + $event.target.value;
            $wire.discount = $event.target.value;
        }">
    </td>
    {{-- <input type="text" placeholder="Rp0" wire:model.lazy="discount" x-on:blur="$wire.discount = 'Rp' + $event.target.value"> --}}
    <td style="vertical-align: middle">Rp{{ number_format($total, 0, '.', '.') }}</td>
    <td>
        <button type="button" class="btn btn-sm btn-danger" wire:click="delete">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </td>
</tr>
