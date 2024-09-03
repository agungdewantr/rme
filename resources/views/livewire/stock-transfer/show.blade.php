<x-slot:title>
    Detail Stock Transfer
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('stock-transfer.index') }}" wire:navigate>Stock
                Transfer</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Stock Transfer</li>
    </x-slot:breadcrumbs>

    {{-- <x-slot:button>
    @if(!$stockTransfer->isClaim)
        <button class="btn btn-warning" type="button" data-bs-toggle="modal"
        data-bs-target="#exampleModal">
            <i class="fa-solid fa-hand-holding-dollar"></i> Klaim
        </button>
    @else
        <span class="btn btn-success">
            <i class="fa-solid fa-check"></i>  Sudah diklaim
        </span>
       @if(auth()->user()->role_id == 1)
       <button class="btn btn-warning ms-2" type="button" data-bs-toggle="modal"
       data-bs-target="#unclaimConfirm">
       <i class="fa-regular fa-circle-xmark"></i> Batalkan Klaim
       </button>
       @endif
    @endif
    </x-slot:button> --}}


    <div class="card" x-data="stockTransfer">
        <div class="card-body">
            {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" wire:ignore data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Form Klaim Stock Transfer</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="claim_date" class="form-label">Tanggal Klaim</label>
                                        <div wire:ignore class="input-group">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa-solid fa-calendar-days"></i>
                                            </span>
                                            <input type="text" class="form-control @error('claim_date') is-invalid @enderror"
                                                id="claim_date" x-model="claim_date">
                                        </div>
                                        @error('claim_date')
                                        <div class="tw-text-small text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="outcome_date" class="form-label">Tanggal Pengeluaran</label>
                                        <div wire:ignore class="input-group">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa-solid fa-calendar-days"></i>
                                            </span>
                                        <input type="text" class="form-control @error('outcome_date') is-invalid @enderror"
                                               id="outcome_date" x-model="outcome_date">
                                        </div>
                                        @error('outcome_date')
                                        <div class="tw-text-small text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" x-on:click="save">Submit</button>
                          </div>
                    </div>
                  </div>
            </div>

            <div class="modal fade" id="unclaimConfirm" tabindex="-1" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Konfirmasi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <p>Anda yakin ingin membatalkan klaim untuk stock transfer ({{$stockTransfer->stock_transfer_number}})?</p>
                      <p>Data Transaksi Pembayaran & Pengeluaran terkait stock transfer ini akan terhapus.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" wire:click="unClaim">Submit</button>
                    </div>
                  </div>
                </div>
            </div> --}}
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
                                        <input type="text" class="form-control"
                                               value="{{$stockTransfer->stock_transfer_number}}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Tanggal</label>
                                        <input type="text" class="form-control @error('date') is-invalid @enderror"
                                               disabled
                                               id="date"
                                               value="{{$stockTransfer->date ? Carbon\Carbon::parse($stockTransfer->date)->format('d-m-Y') : '-'}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Cabang Penerima</label>
                                        <input type="text" class="form-control @error('date') is-invalid @enderror"
                                               disabled
                                               id="date" value="{{$stockTransfer->toBranch->name}}">
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
                                        <label for="date" class="form-label">Status</label>
                                        <input type="text" class="form-control @error('date') is-invalid @enderror"
                                               disabled
                                               id="date" value="{{$stockTransfer->status}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Keterangan</label>
                                        <textarea name="" id="" class="form-control"
                                                  disabled>{{$stockTransfer->description}}</textarea>
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
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($stockTransfer->items as $i)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$i->name}}</td>
                                    <td>{{$i->pivot->qty_total}}</td>
                                    <td>{{$i->uom}}</td>
                                    <td>{{number_format($i->batches[$i->batches->count()-1]->new_price, 0, '.','.')}}</td>
                                    <td>{{number_format((int)$i->batches[$i->batches->count()-1]->new_price * (int)$i->pivot->qty_total, 0, '.','.')}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Total :</td>
                                <td>Rp. {{ number_format($stockTransfer->grand_total, 0, '.','.')}}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Jumlah Bayar :</td>
                                <td>Rp. {{ number_format($stockTransfer->amount, 0, '.','.')}}</td>
                            </tr>
                            </tfoot>
                        </table>

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

@endassets

@script
    <script>
                Alpine.data('stockTransfer', () => ({
                    claim_date: @entangle('claim_date'),
                    outcome_date: @entangle('outcome_date'),
                    init() {
                        flatpickr($wire.$el.querySelector('#claim_date'), {
                            dateFormat: "d-m-Y",
                            "locale": "id",
                            allowInput: true,
                            onClose: (selectedDates, dateStr, instance) => {
                                $wire.$set('claim_date', dateStr)
                            },
                        })
                        flatpickr($wire.$el.querySelector('#outcome_date'), {
                            dateFormat: "d-m-Y",
                            "locale": "id",
                            allowInput: true,
                            onClose: (selectedDates, dateStr, instance) => {
                                $wire.$set('outcome_date', dateStr)
                            },
                        })
                    },

                    save() {
                        if(this.claim_date == null || this.outcome_date == null){
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Lengkapi seluruh tanggal"
                            });
                            return
                        }

                        $wire.save()
                    }
                }));

    </script>
@endscript
