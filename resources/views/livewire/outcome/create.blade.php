<x-slot:title>
    Tambah Pengeluaran
</x-slot:title>

<x-page-layout>
    <form >
        <x-slot:breadcrumbs>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('outcome.index') }}" wire:navigate>Pengeluaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pengeluaran</li>
        </x-slot:breadcrumbs>
        @if ($notification)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ $notification }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <x-slot:button>
            <div class="d-flex">
                <button class="btn btn-primary" wire:loading.attr="disabled" wire:click="save">
                    <i wire:loading class="fa-solid fa-spinner tw-animate-spin"></i>

                    Simpan
                </button>
            </div>
        </x-slot:button>

        <div class="card mb-3" x-data="outcome">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">ID Pengeluaran</label>
                                    <input type="text" class="form-control" disabled
                                        placeholder="Otomatis dari sistem">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Jenis Pembayaran</label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror"
                                        name="payment_method" id="payment_method" wire:model="payment_method">
                                        <option value="">Pilih Metode Pembayaran</option>
                                        <option value="Tunai">Tunai</option>
                                        <option value="Transfer">Transfer</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Tanggal<span
                                            class="text-danger">*</span></label>
                                    <div wire:ignore class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                        <input type="text" date-picker name="date" wire:model="date"
                                            id="date" class="form-control @error('date') is-invalid @enderror">
                                        @error('date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Kategori<span
                                            class="text-danger">*</span></label>
                                    <div wire:ignore>
                                    <select class="form-select @error('category') is-invalid @enderror" name="category"
                                        id="category" x-model="category">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $c)
                                        <option value="{{$c->name}}">{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                    @error('category')
                                        <div class="text-danger tw-text-sm">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="branch_id" class="form-label">Cabang<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('branch_id') is-invalid @enderror"
                                        name="branch_id" id="branch_id" wire:model="branch_id">
                                        <option value="">Pilih Cabang</option>
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
                            <div class="col-md-4">
                                <div class="mb-3" wire:ignore>
                                    <label for="date" class="form-label">Supplier</label>
                                    <select class="form-select select2 @error('supplier_id') is-invalid @enderror"
                                        id="supplier_id" name="supplier_id"
                                        aria-label="Default select example"
                                        style="width: 100%">
                                        <option value="" selected>Pilih Supplier</option>
                                        @foreach ($suppliers as $s)
                                            <option value="{{ $s->id }}">
                                                {{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div wire:ignore>
                                    <label for="account_id" class="form-label">Akun<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2 @error('account_id') is-invalid @enderror"
                                        id="account_id" name="account_id"
                                        aria-label="Default select example" wire:model="account_id"
                                        style="width: 100%">
                                        <option value="" selected>Pilih Akun</option>
                                        @foreach ($accounts as $a)
                                            <option value="{{ $a->id }}">
                                                {{ $a->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                    @error('account_id')
                                        <div class="text-danger tw-text-sm">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nominal" class="form-label">Nominal</label>
                                    <input type="text" class="form-control @error('nominal') is-invalid @enderror" wire:model="nominal" name="nominal" id="nominal"  x-on:keyup="()=>{
                                        let  nominal = document.getElementById('nominal');
                                        let total_payment = $('#total_payment');
                                        var number_string = (nominal.value).replace(/[^,\d]/g, '').toString(),

                                        split   = number_string.split(','),
                                        sisa     = split[0].length % 3,
                                        rupiah     = split[0].substr(0, sisa),
                                        ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
                                        if(ribuan){
                                        separator = sisa ? '.' : '';
                                        rupiah += separator + ribuan.join('.');
                                        }
                                        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                                        nominal.value = rupiah;
                                        total_payment.val(rupiah);
                                    }">
                                    @error('nominal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nik" class="form-label">Keterangan</label>
                                    <textarea name="note" id="note" class="form-control" wire:model="note"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4"></div>


                        </div>
                    </div>


                </div>
                {{-- <div>
                    <div class="row">
                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Referensi</th>
                                    <th>Item</th>
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-if="references.length > 0">
                                    <template x-for="(reference, index) in references" :key="reference.id">
                                        <tr>
                                            <td>
                                                <span x-text="index+1"></span>
                                            </td>
                                            <td>
                                                <div class="mb-3" wire:ignore>
                                                    <select
                                                        class="form-select select2 @error('stock_entry_id') is-invalid @enderror"
                                                        id="" name="modalStock_entry_id"
                                                        aria-label="Default select example"
                                                        style="width: 50%"
                                                        x-init="() => {
                                                            $($el).select2({
                                                                placeholder: 'Pilih Referensi',
                                                                width: '100%',
                                                                theme: 'bootstrap-5',
                                                            });
                                                            reference.stock_entry_select = $refs;

                                                            $($el).on('change', function(e) {
                                                                 references = references.map((val, idx)=>{
                                                                if(reference.id === val.id){
                                                                    return {
                                                                        ...val,
                                                                        stock_entry_id:e.target.value
                                                                    }
                                                                }else{
                                                                    return val
                                                                }
                                                                })
                                                            })
                                                        }">
                                                        <option value="" selected>Pilih Referensi</option>
                                                        @foreach ($stock_entries as $s)
                                                            <option value="{{ $s->id }}">
                                                                {{ $s->stock_entry_number . ' - (Rp' . number_format($s->nominal ?? 0, 0, ',', '.') . ')' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('stock_entry_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <template x-for="(item, itemIndex) in reference.items">
                                                    <p x-text="item.name"></p><br>
                                                </template>
                                            </td>
                                            <td>
                                                <template x-for="(item, itemIndex) in reference.items">
                                                    <p x-text="item.uom"></p><br>
                                                </template>
                                            </td>
                                            <td>
                                                <template x-for="(item, itemIndex) in reference.items">
                                                    <p x-text="item.quantity"></p><br>
                                                </template>
                                            </td>
                                            <td>
                                                <template x-for="(item, itemIndex) in reference.items">
                                                    <p x-text="item.purchase_price"></p><br>
                                                </template>
                                            </td>
                                            <td>
                                                <template x-for="(item, itemIndex) in reference.items">
                                                    <p x-text="item.total_price"></p><br>
                                                </template>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                x-on:click="references = references.filter((item)=>item.id!==reference.id)">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                                <template x-if="references.length == 0">
                                    <tr>
                                        <td colspan="8" class="tw-text-center">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <button type="button" class="btn btn-sm btn-primary" x-on:click="()=>{
                                references = [
                                    ...references,
                                    {
                                        id:Math.floor(Math.random() * 100) + 1,
                                        stock_entry_id:'',
                                        stock_entry_select:null
                                    }
                                ]
                            }">
                                Add Item
                            </button>
                            <button type="button" class="btn btn-sm btn-warning" wire:click="getItem">
                                Get Item
                            </button>
                        </div>
                        <div class="flex-grow-2 text-end">
                            Total Nominal Pembayaran: <input readonly type="text" class="form-control w-auto d-inline-block" id="total_payment" wire:model="total_payment">
                        </div>
                    </div>

                </div> --}}
            </div>

        </div>
    </form>
</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
@endassets


@script
    <script>
        Alpine.data('outcome', () => ({
            isDrugMedDev:false,
            status: @entangle('status'),
            references: @entangle('references'),
            category: @entangle('category').live,
            isReference: false,

            init() {
                flatpickr($wire.$el.querySelector('#date'), {
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: 'd-m-Y',
                    "locale": "id",
                    defaultDate: new Date(),
                    allowInput: true,
                    onClose: (selectedDates, dateStr, instance) => {
                        this.date = dateStr
                    }
                });

                $('#account_id').select2({
                    theme: "bootstrap-5",
                    placeholder: "--Pilih Akun--",
                    width: '100%',
                    tags: true,
                })

                $('#account_id').on('change', function(e) {
                    var data = $('#account_id').select2("val");
                    $wire.$set('account_id', data);
                });

                $('#supplier_id').select2({
                    theme: "bootstrap-5",
                    placeholder: "--Pilih Supplier--",
                    width: '100%',
                })

                $('#supplier_id').on('change', function(e) {
                    var data = $('#supplier_id').select2("val");
                    $wire.$set('supplier_id', data);
                    $wire.$call('getUpdatedReference');
                });

                $('#category').select2({
                    theme: "bootstrap-5",
                    placeholder: "--Pilih Kategori--",
                    width: '100%',
                })

                $wire.on('updatedReference', ({stockEntry}) => {
                    console.log(stockEntry)
                    for(let se of this.references){
                        console.log(se)
                       let stock =  se.stock_entry_select;
                       console.log(stock)
                       stock.destroy;
                       stock.$element.find('option').remove();
                       stock.select2({
                            theme: 'bootstrap-5',
                        });
                        stock.append($('<option>', {
                        value: '',
                        text: 'Pilih Referensi',
                        selected: true // Menandai opsi ini sebagai terpilih secara default
                    }));
                    stockEntry.forEach(function(se2) {
                        select2.$element.append(new Option(se2.stock_entry_number, se2.id,
                            false, false));
                    });
                    stock.on('change', function(e) {
                        var data = stock.select2("val");
                        $wire.$set('user_id', data);
                    });

                    se.stock_entry_select = stock
                    }
                })

                $('#category').on('change', function(e) {
                    var data = $('#category').select2("val");
                    $wire.$set('category', data);
                    if(data == 'Obat & Alkes'){
                        this.isReference = true
                    }else{
                        this.isReference = false
                    }
                });

            }
        }))

    </script>
@endscript
