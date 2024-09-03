<x-report-stock-layout :type="$type" :date="$date" :branch="$branch_id" :item="$item_id" :batch="$batch">
    <div class="row">
        <div class="col-12 d-flex gap-4">
            <div class="mb-3" wire:ignore>
                <input type="text" class="form-control" id="date" date-picker placeholder="Filter Tanggal">
            </div>
            <div class="mb-3" wire:ignore>
                <select name="" class="form-select" id="" wire:model.live="item_id"
                    x-data="{
                        item_id: $wire.$entangle('item_id').live
                    }" x-init="() => {
                        $($el).select2({
                            placeholder: 'Semua Barang',
                            allowClear: true,
                            theme: 'bootstrap-5'
                        })
                    
                        $($el).on('change', function(e) {
                            item_id = $el.value
                        })
                    
                        $($el).val(item_id).trigger('change');
                    }">
                    <option value="">Semua Barang</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <select name="" class="form-select" id="" wire:model.live="branch_id">
                    <option value="">Semua Cabang</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <select name="" class="form-select" id="" wire:model.live="batch">
                    <option value="">Semua Batch</option>
                    @foreach ($batches as $batch)
                        <option value="{{ $batch->batch_number }}">{{ $batch->batch_number }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="m-0">Laporan Stok Ledger</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Cabang</th>
                            <th>Barang</th>
                            <th>Stok Awal</th>
                            <th>Stok Masuk</th>
                            <th>Stok Keluar</th>
                            <th>Stok Akhir</th>
                            <th>Batch</th>
                            <th>Value</th>
                            <th>Balance Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stockLedgers as $s)
                            <tr>
                                <td>{{ $s->created_at->format('d-m-Y') }}</td>
                                <td>{{ $s->batch->stockEntry->branch->name }}</td>
                                <td>{{ $s->item->name }}</td>
                                <td>{{ $s->current_qty }}</td>
                                <td>{{ $s->in }}</td>
                                <td>{{ $s->out > 0 ? '-' : '' }}{{ $s->out }}</td>
                                <td>{{ $s->qty }}</td>
                                <td>{{ $s->batch_reference }}</td>
                                <td>Rp{{ number_format($s->batch->new_price, 0, '.', '.') }}</td>
                                <td>Rp{{ number_format($s->batch->new_price * $s->qty, 0, '.', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                </table>
            </div>
        </div>
    </div>
</x-report-stock-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
@endassets
