<form wire:submit="save" class="card" id="modal">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Ubah Detail Pengeluaran</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3" wire:ignore>
                    <label for="account_id" class="form-label">Akun<span class="text-danger">*</span></label>
                    <select class="form-select select2 @error('account_id') is-invalid @enderror" id="account_id"
                        name="account_id" aria-label="Default select example" wire:model="account_id"
                        style="width: 100%">
                        <option value="">Pilih Akun</option>
                        @foreach ($accounts as $a)
                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                        @endforeach
                    </select>
                    @error('account_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3" wire:ignore>
                    <label for="date" class="form-label">Supplier</label>
                    <select class="form-select select2 @error('supplier_id') is-invalid @enderror" id="supplier_id"
                    name="supplier_id" aria-label="Default select example" wire:model="supplier_id"
                    style="width: 100%">
                    <option value="">Pilih Supplier</option>
                    @foreach ($suppliers as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3" wire:ignore>
                    <label for="date" class="form-label">Referensi</label>
                    <select class="form-select select2 @error('stock_entry_id') is-invalid @enderror" id="stock_entry_id"
                    name="stock_entry_id" aria-label="Default select example" wire:model="stock_entry_id"
                    style="width: 100%">
                    <option value="">Pilih Referensi</option>
                    @foreach ($stock_entries as $s)
                        <option value="{{ $s->id }}">{{ $s->stock_entry_number. ' - (Rp' . number_format($s->nominal ?? 0,0,',','.') .')' }}</option>
                        @endforeach
                    </select>
                    @error('stock_entry_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="note" class="form-label">Keterangan</label>
                    <input type="note" class="form-control @error('note') is-invalid @enderror"
                        id="note" wire:model="note">
                    @error('note')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="nominal" class="form-label">Nominal<span class="text-danger">*</span></label>
                    <input type="nominal" class="form-control @error('nominal') is-invalid @enderror"
                        id="note" wire:model="nominal" pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/\D+/g, '')">
                    @error('nominal')
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

@script
<script>
    let isShow = false;
    Livewire.hook('component.init', ({ component, cleanup }) => {

        if(!isShow){
            isShow = true;
            if({{ json_encode($account_id) }} != null && {{ json_encode($account_id) }} != 0){
                $("#account_id").val({{$account_id}}).trigger("change");
            }
            if({{ json_encode($supplier_id) }} != null && {{ json_encode($supplier_id) }} != 0){
                $("#supplier_id").val({{$supplier_id}}).trigger("change");
            }
            if ({{ json_encode($stock_entry_id) }} !== null && {{ json_encode($stock_entry_id) }} !== 0) {
                $("#stock_entry_id").val({{$stock_entry_id}}).trigger("change");
            }

        }

    });

    $("#account_id").select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#modal"),
        tags: true,
    });
    $("#account_id").on('change', (e) => {
        $wire.$set('account_id', $(e.target).select2('val'));
    });

    $("#supplier_id").select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#modal"),
    });
    $("#supplier_id").on('change', (e) => {
        $wire.$set('supplier_id', $(e.target).select2('val'));
    });

    $("#stock_entry_id").select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#modal"),
    });
    $("#stock_entry_id").on('change', (e) => {
        $wire.$set('stock_entry_id', $(e.target).select2('val'));
    });

    Livewire.on('refresh-stock-entry-select', function(event){
        let select2 = $('#stock_entry_id').data('select2');
        select2.destroy();
        select2.$element.find('option').remove();
        $('#stock_entry_id').select2({
            theme: 'bootstrap-5',
            dropdownParent: $("#modal"),
        });
        $('#stock_entry_id').append($('<option>', {
            value: '',
            text: 'Pilih Referensi',
            selected: true
        }));
        event.references.forEach(function (ref) {
            $('#stock_entry_id').append(new Option(ref.stock_entry_number + ' - (Rp' + ref.nominal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ')', ref.id, false, false));
        });
        $("#stock_entry_id").val({{$stock_entry_id}}).trigger("change");
    });
</script>

@endscript
