<x-slot:title>
    Tambah Stock Transfer
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('stock-transfer.index') }}" wire:navigate>Stock
                Transfer</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Stock Transfer</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <button class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
            <i wire:loading class="fa-solid fa-spinner tw-animate-spin"></i>
            Simpan
        </button>
    </x-slot:button>

    <div class="card" x-data="stockTransfer">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h5>Stock Transfer</h5>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock_entry_number" class="form-label">Nomor Stock Transfer</label>
                                        <input type="text" class="form-control" id="stock_transfer_number"
                                            placeholder="STF.MMYY.XXXX" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                        <label for="to_branch" class="form-label">Kirim Ke<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('to_branch') is-invalid @enderror"
                                            id="to_branch" x-model="to_branch" aria-label="Default select example">
                                            <option selected value="">--Pilih Cabang--</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('to_branch')
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
                                        <label for="receiver_id" class="form-label">Penerima<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('receiver_id') is-invalid @enderror"
                                            id="receiver_id" x-model="receiver_id" aria-label="Default select example">
                                            <option selected value="">--Pilih Penerima--</option>
                                            @foreach ($healthWorkers as $healtWorker)
                                                <option value="{{ $healtWorker->id }}">{{ $healtWorker->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('receiver_id')
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
                <div class="col-md-6">
                    <div class="row">
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
                                        <label for="description" class="form-label">Keterangan</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="3"
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Item</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-if="items.length > 0">
                                    <template x-for="(item, index) in items">
                                        <tr>
                                            <td x-text="index + 1"></td>
                                            <td style="width:250px" wire:ignore>
                                                <select name="drug_action_id" class="form-select"
                                                    x-init="() => {
                                                        $($el).select2({
                                                            placeholder: 'Pilih Obat/Alkes',
                                                            width: '100%',
                                                            theme: 'bootstrap-5',
                                                        })
                                                        $($el).on('change', function() {
                                                            item.item_id = $el.value
                                                            $wire.$call('getDrugMedDev', item.temp_id, item.item_id)
                                                        })
                                                        if (item.item_id != '') {
                                                            $($el).val(item.item_id).trigger('change');
                                                        }
                                                    }">
                                                    <option value="">Pilih Obat/Alkes</option>
                                                    @foreach ($drugMedDevsOption as $drugMedDev)
                                                        <option value="{{ $drugMedDev->id }}">{{ $drugMedDev->name }}
                                                            ({{ $drugMedDev->batches?->sum('qty') ?? 0 }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td style="width:250px">
                                                <input type="text" placeholder="0" x-model="item.qty" x-on:keyup="(e) => {
                                                if(e.target.value > item.qtyExisting){
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Error',
                                                            text: 'Jumlah QTY melebihi Eksisting QTY'
                                                        });
                                                        e.target.value = 0;
                                                        return;

                                                }


                                                }">
                                            </td>
                                            <td style="vertical-align: middle" x-text="item.uom"></td>
                                            <td style="vertical-align: middle"
                                                x-text="parseInt(item.price).toLocaleString('ID')"></td>

                                            <td style="vertical-align: middle" style="vertical-align: middle"
                                                x-text="parseInt(item.qty*item.price).toLocaleString('ID')">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    x-on:click="removeItem(item.temp_id)">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                                <template x-if="items.length == 0">
                                    <tr>
                                        <td colspan="7" class="tw-text-center">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">Grand Total</td>
                                    <td ><input type="text" class="form-control" x-model="grand_total" :value="calculateTotal().toLocaleString('ID')" readonly></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">Jumlah Bayar</td>
                                    <td ><input type="text" class="form-control" x-model="amount" :value="calculateTotal().toLocaleString('ID')" x-on:input="formatRupiah($event)"></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        <button type="button" class="btn btn-sm btn-primary mb-2"
                            x-on:click="addItem">Tambah</button>

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
        Alpine.data('stockTransfer', () => ({
            date: @entangle('date'),
            to_branch: @entangle('to_branch'),
            description: @entangle('description'),
            status: @entangle('status'),
            items: @entangle('items'),
            receiver_id: @entangle('receiver_id'),
            amount: @entangle('amount'),
            grand_total: @entangle('grand_total'),

            // itemsTotal() {
            //     return this.items.reduce((sum, item) => sum + (item.qty * item.price), 0).toLocaleString('ID');
            // },
            calculateTotal() {
                return this.items.reduce((total, item) => {
                    return total + (item.price * item.qty);
                }, 0);
            },

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

                    this.amount = formattedValue;

                    setTimeout(() => {
                        input.setSelectionRange(index, index);
                    }, 0);
                },


            init() {
                this.$watch('date', value => {
                    this.$wire.call('changeItemByDate', value);
                });
                this.$watch('items', () => {
                    this.grand_total = (this.calculateTotal()).toLocaleString('ID');
                    this.amount = (this.calculateTotal()).toLocaleString('ID');

                });
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

                $wire.$on('get-drug-med-dev-result', ({
                    drugMedDev,
                    temp_id
                }) => {
                    this.items = this.items.map((item, index) => {
                        if (item.temp_id == temp_id) {
                            return {
                                ...item,
                                item_id: drugMedDev.id,
                                qtyExisting: drugMedDev.qty ?? 0,
                                uom: drugMedDev.uom ?? '-',
                                price: drugMedDev.new_price ?? 0,
                                expired_date: drugMedDev.expired_date ?? null,
                            }
                        }
                        return item
                    })
                })
            },

            addItem() {
                this.items.push({
                    temp_id: new Date().getTime(),
                    item_id: '-',
                    qtyExisting: 0,
                    qty: 0,
                    uom: '-',
                    expired_date: null,
                    price: 0
                })

            },
            removeItem(temp_id) {
                this.items = this.items.filter((item) => item.temp_id != temp_id);
            },

        }))
    </script>
@endscript
