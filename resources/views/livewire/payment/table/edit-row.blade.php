<tr>
    <td>{{ $iteration }}</td>
    <td style="width:250px">
        <select name="drug_action_id" wire:model.live="drug_action_id" class="form-select">
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
