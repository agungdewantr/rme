<x-slot:title>
    Lihat Stock Entry
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('stock-entry.index') }}" wire:navigate>Stock
                Entry</a></li>
        <li class="breadcrumb-item active" aria-current="page">Lihat Stock Entry</li>
    </x-slot:breadcrumbs>


    <div class="card">
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
                                               placeholder="STE.MMYY.XXXX" readonly
                                               value="{{ $stockEntry->stock_entry_number }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="purpose" class="form-label">Tujuan Stock Entry</label>
                                        <input type="text" class="form-control" id="stock_entry_number" readonly
                                               value="{{ $stockEntry->purpose }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="receiver" class="form-label">Penerima</label>
                                        <div wire:ignore>
                                            <select class="form-select @error('receiver_id') is-invalid @enderror"
                                                    id="receiver" disabled aria-label="Default select example">
                                                <option value="">--Pilih Penerima--</option>
                                                @foreach ($nurses as $nurse)
                                                    <option value="{{ $nurse->id }}"
                                                            @if ($nurse->id == $stockEntry->receiver_id) selected @endif>
                                                        {{ $nurse->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
                                            {{-- <select class="form-select @error('supplier') is-invalid @enderror"
                                                id="supplier" aria-label="Default select example" disabled>
                                                <option value="">--Pilih Supplier--</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->name }}"
                                                        @if ($supplier->name == $stockEntry->supplier->name ?? NULL) selected @endif>
                                                        {{ $supplier->name }}</option>
                                                @endforeach
                                            </select> --}}
                                            <input type="text" class="form-control" readonly
                                                   value="{{ $stockEntry->supplier->name ?? '-' }}">
                                        </div>
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
                                        <input type="text" class="form-control" id="date" readonly
                                               value="{{ $stockEntry->date }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" class="form-control" id="date" readonly
                                               value="{{ $stockEntry->status }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="branch" class="form-label">Cabang</label>
                                        <select class="form-select" disabled id="branch"
                                                aria-label="Default select example">
                                            <option value="">--Pilih Cabang--</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}"
                                                        @if ($branch->id == $stockEntry->branch_id) selected @endif>
                                                    {{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Keterangan</label>
                                        <textarea class="form-control" disabled id="description"
                                                  rows="3">{{ $stockEntry->description }}</textarea>
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
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Expired Date</th>
                                <th>Harga Beli</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($stockEntry->details as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->item_uom }}</td>
                                    <td>{{ $item->item_qty }}</td>
                                    <td>{{ $item->item_expired_date }}</td>
                                    <td class="text-end">{{number_format($item->item_price, 0, '.','.') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" class="text-end tw-font-semibold">Grand Total</td>
                                <td class="text-end tw-font-semibold">{{number_format($stockEntry->grand_total, 0, '.','.')}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-page-layout>
