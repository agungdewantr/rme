<x-slot:title>
    Tambah Stock Entry
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('stock-entry.index') }}" wire:navigate>Stock
                Entry</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Stock Entry</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <button class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
            <i wire:loading class="fa-solid fa-spinner tw-animate-spin"></i>
            Simpan
        </button>
    </x-slot:button>

    <div class="card" x-data="stockEntry">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h5>Stock Entry</h5>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock_entry_number" class="form-label">Nomor Stock Entry</label>
                                        <input type="text" class="form-control" id="stock_entry_number"
                                               placeholder="STE.MMYY.XXXX" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="purpose" class="form-label">Tujuan Stock Entry<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('purpose') is-invalid @enderror"
                                                x-model="purpose" id="purpose" aria-label="Default select example">
                                            <option selected value="">--Pilih Tujuan--</option>
                                            <option value="Barang Masuk">Barang Masuk</option>
                                            <option value="Barang Opname">Barang Opname</option>
                                            <option value="Barang Keluar">Barang Keluar</option>
                                        </select>
                                        @error('purpose')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="receiver" class="form-label">Penerima<span
                                                class="text-danger">*</span></label>
                                        <div wire:ignore>
                                            <select class="form-select @error('receiver_id') is-invalid @enderror"
                                                    id="receiver" aria-label="Default select example">
                                                <option selected value="">--Pilih Penerima--</option>
                                                @foreach ($nurses as $nurse)
                                                    <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('receiver_id')
                                        <div class="text-danger tw-text-sm">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="supplier" class="form-label">Supplier</label>
                                        <div wire:ignore>
                                            <select class="form-select @error('supplier') is-invalid @enderror"
                                                    id="supplier" aria-label="Default select example">
                                                <option selected value="">--Pilih Supplier--</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->name }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('supplier')
                                        <div class="text-danger tw-text-sm">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3" wire:ignore>
                                        <label for="date" class="form-label">Tanggal</label>
                                        <input type="text" class="form-control @error('date') is-invalid @enderror"
                                               id="date">
                                        @error('date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                                x-model="status" aria-label="Default select example">
                                            <option selected value="">--Pilih Status--</option>
                                            <option value="Lunas">Lunas</option>
                                            <option value="Dibayar Sebagian">Dibayar Sebagian</option>
                                            <option value="Hutang">Hutang</option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="branch" class="form-label">Cabang</label>
                                        <select class="form-select @error('branch_id') is-invalid @enderror"
                                                x-model="branch" x-on:change="()=>{
                                                    batches = [];
                                                }" id="branch" aria-label="Default select example">
                                            <option selected value="">--Pilih Cabang--</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Keterangan</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" rows="3"
                                                  x-model="description"></textarea>
                                        @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <button type="button" class="btn btn-primary" x-on:click="getItems"
                                x-show="purpose=='Barang Opname'">
                            Get Item
                        </button>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Item</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Expired Date</th>
                                <th>Harga Beli</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template x-if="batches.length > 0">
                                <template x-for="(batch, index) in batches">
                                    <tr>
                                        <td x-text="index + 1"></td>
                                        <td x-text="batch.item_name"></td>
                                        <td x-text="batch.uom"></td>
                                        <td x-text="batch.qty"></td>
                                        <td x-text="batch.expired_date.split('-').reverse().join('-')"></td>
                                        <td x-text="batch.new_price" class="tw-text-end"></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" x-on:click="()=>edit(index)">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                    x-on:click="batches.splice(index, 1)">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <template x-if="batches.length == 0">
                                <tr>
                                    <td colspan="7" class="tw-text-center">
                                        Tidak ada data
                                    </td>
                                </tr>
                            </template>
                            <tr>
                                <td colspan="5" class="text-end tw-font-semibold">Grand Total</td>
                                <td
                                    x-text="batches.reduce((a, b)=>a+b.qty*b.new_price.replaceAll('.',''), 0).toLocaleString('id-ID')"
                                    class="text-end tw-font-semibold"
                                ></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                            Tambah
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true" wire:ignore x-data="{
                formatRupiah(event) {
                    const input = event.target;
                    const value = input.value;
                    const cursorPosition = input.selectionStart;

                    const leftPart = value.substring(0, cursorPosition);
                    const rightPart = value.substring(cursorPosition);

                    const leftNumeric = leftPart.replace(/\D/g, '');
                    const rightNumeric = rightPart.replace(/\D/g, '');

                    const combinedNumeric = leftNumeric + rightNumeric;

                    const formattedValue = new Intl.NumberFormat('id-ID', {
                        style: 'decimal',
                        maximumFractionDigits: 0
                    }).format(combinedNumeric);

                    let newCursorPosition = cursorPosition;
                    let index = 0;
                    for (let i = 0; i < leftNumeric.length; i++) {
                        if (formattedValue[index] === '.') {
                            index++;
                        }
                        index++;
                    }

                    this.modalNewPrice = formattedValue;

                    setTimeout(() => {
                        input.setSelectionRange(index, index);
                    }, 0);
                }
            }">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Batch</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Item</label>
                                    <select class="form-select" id="item" aria-label="Default select example">
                                        <option selected value="">--Pilih Item--</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->id }}/{{ $item->name }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="batch_number" class="form-label">Batch Number</label>
                                    <input class="form-control" type="text" name="" id="batch_number"
                                           readonly placeholder="DDMMYYXXX (Dari Sistem)" x-model="modalBatchNumber">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="uom" class="form-label">Satuan</label>
                                    <input class="form-control" type="text" name="" x-model="modalUom"
                                           id="uom" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expired_date" class="form-label">Expired Date</label>
                                    <input class="form-control" type="text" name="" id="expired_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="old_price" class="form-label">Harga Beli (Lama)</label>
                                    <input class="form-control" type="text" name=""
                                           x-model="modalOldPrice" id="old_price" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="old_qty" class="form-label">Eksisting QTY</label>
                                    <input class="form-control" type="text" name="" id="old_qty"
                                           x-model="modalOldQty" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="new_price" class="form-label">Harga Beli (Baru)</label>
                                    <input class="form-control" type="text" name=""
                                           x-model="modalNewPrice" id="new_price" x-on:input="formatRupiah($event)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="qty" class="form-label">QTY</label>
                                    <input class="form-control" type="text" x-model="modalQty" name=""
                                           id="qty">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <template x-if="modalIndex<0">
                            <button type="button" class="btn btn-primary" x-on:click="addRow">Simpan</button>
                        </template>
                        <template x-if="modalIndex>=0">
                            <button type="button" class="btn btn-primary"
                                    x-on:click="()=>updateRow(modalIndex)">Simpan
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-page-layout>

@assets
<link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
<script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
@endassets

@script
<script>
    Alpine.data('stockEntry', () => ({
        purpose: @entangle('purpose'),
        date: @entangle('date'),
        status: @entangle('status'),
        branch: @entangle('branch_id'),
        description: @entangle('description'),
        receiver: @entangle('receiver_id'),
        supplier: @entangle('supplier'),
        qtyItemCurrent: 0,
        modalExpiredDate: "",
        modalBatchNumber: "",
        modalItem: "",
        modalUom: "",
        modalOldPrice: "",
        modalOldQty: "",
        modalNewPrice: "",
        modalQty: "",
        modalExpiredDatePicker: null,
        batches: @entangle('batches'),
        modalIndex: -1,
        modalItemSelect: null,

        init() {
            // init flatpickr
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

            this.modalExpiredDatePicker = flatpickr($wire.$el.querySelector('#expired_date'), {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: 'd-m-Y',
                "locale": "id",
                allowInput: true,
                onClose: (selectedDates, dateStr, instance) => {
                    this.modalExpiredDate = dateStr
                }
            })

            // init select2
            let receiverSelect = $("#receiver").select2({
                theme: "bootstrap-5",
                placeholder: "--Pilih Penerima--",
                width: '100%',
            });

            let supplierSelect = $("#supplier").select2({
                theme: "bootstrap-5",
                placeholder: "--Pilih Supplier--",
                width: '100%',
                allowClear: true,
                tags: true
            });

            this.modalItemSelect = $("#item").select2({
                theme: "bootstrap-5",
                placeholder: "--Pilih Item--",
                width: '100%',
                dropdownParent: $("#exampleModal")
            })

            // event select2
            receiverSelect.on('select2:select', (e) => {
                this.receiver = e.params.data.id;
            })

            supplierSelect.on('select2:select', (e) => {
                this.supplier = e.params.data.id;
            })

            this.modalItemSelect.on('select2:select', (e) => {
                this.modalItem = e.params.data.id
                $wire.call('fetchItem',
                    e.params.data.id.split('/')[0],
                    this.branch
                );
            })

            // listen event from server
            $wire.$on("fetch-item", ({item}) => {
                this.modalUom = item?.uom ?? ""
                this.modalOldPrice = item?.new_price ?? ""
                this.modalOldQty = item?.qty ?? 0
                this.qtyItemCurrent = item?.qty ?? 0
            })

            $wire.$on("get-items", ({items}) => {
                items.forEach(item => {
                    this.batches.push({
                        id: item.id,
                        batch_number: item.batch_number,
                        item_id: item.item.id,
                        item_name: item.item.name,
                        uom: item.item.uom,
                        old_price: item.new_price,
                        new_price: item.new_price,
                        qty: item.qty == 0 ? '0' : item.qty,
                        expired_date: item.expired_date
                    })
                });
            })

            // event modal
            $("#exampleModal").on("hidden.bs.modal", (e) => {
                this.reset()
                this.modalExpiredDatePicker.setDate("{{ date('Y-m-d') }}")
            })

            // watch changed data
            this.$watch('purpose', (value, oldValue) => {
                if (value == 'Barang Opname' || oldValue == 'Barang Opname') {
                    this.batches = []
                }
            })
        },

        reset() {
            this.modalItemSelect.val(null).trigger("change")
            this.modalUom = ""
            this.modalOldPrice = ""
            this.modalQty = ""
            this.modalOldQty = ""
            this.modalNewPrice = ""
            this.modalIndex = -1
            this.modalBatchNumber = ""
        },

        addRow() {
            if ((this.qtyItemCurrent < this.modalQty) && this.purpose == 'Barang Keluar') {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Jumlah QTY melebihi Eksisting QTY"
                });
                return;
            }
            this.batches.push({
                id: new Date().getTime(),
                item_id: this.modalItem.split("/")[0],
                item_name: this.modalItem.split("/")[1],
                uom: this.modalUom,
                new_price: this.modalNewPrice,
                qty: this.modalQty,
                expired_date: this.modalExpiredDate
            })

            $("#exampleModal").modal("hide")
        },

        edit(index) {
            this.modalIndex = index
            this.modalNewPrice = this.batches[index].new_price
            this.modalQty = this.batches[index].qty
            this.modalExpiredDate = this.batches[index].expired_date
            this.modalItemSelect.val(this.batches[index].item_id + "/" + this.batches[index].item_name)
                .trigger("change")
            if (this.purpose != 'Barang Opname') {
                $wire.call("fetchItem",
                    this.batches[index].item_id, this.branch
                )
            } else {
                this.modalItem = this.batches[index].item_id + "/" + this.batches[index].item_name
                this.modalBatchNumber = this.batches[index].batch_number
                this.modalUom = this.batches[index].uom
                this.modalOldPrice = this.batches[index].old_price
                this.modalOldQty = this.batches[index].qty
            }
            this.modalExpiredDatePicker.setDate(this.batches[index].expired_date)

            $("#exampleModal").modal("show")
        },

        updateRow(index) {
            if ((this.qtyItemCurrent < this.modalQty) && this.purpose == 'Barang Keluar') {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Jumlah QTY melebihi Eksisting QTY"
                });
                return;
            }
            this.batches = this.batches.map((val, idx) => {
                if (index === idx) {
                    return {
                        ...val,
                        new_price: this.modalNewPrice,
                        qty: this.modalQty,
                        expired_date: this.modalExpiredDate,
                        item_id: val.item_id,
                        item_name: val.item_name,
                        uom: this.modalUom,
                    }
                }

                return val
            })

            $("#exampleModal").modal("hide")
        },

        getItems() {
            $wire.$call('getItems', this.supplier, this.branch)
        }
    }))
</script>
@endscript
