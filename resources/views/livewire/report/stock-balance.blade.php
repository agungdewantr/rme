<x-report-stock-layout :type="$type" :date="$date" :branch="$branch_id" :item="$item">
    <div class="row">
        <div class="col-12 d-flex gap-4">
            <div class="mb-3" wire:ignore>
                <select name="" class="form-select" id="" wire:model.live="item" x-data="{
                    item_id: $wire.$entangle('item').live
                }"
                        x-init="() => {
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
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="m-0">Laporan Stok Balance</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Satuan</th>
                        <th>Stok Masuk</th>
                        <th>Stok Keluar</th>
                        <th>Stok Akhir</th>
                        <th>Cabang</th>
                        <th>Avg Value</th>
                        <th>Balance Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($result as $r)
                        <tr>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->uom }}</td>
                            <td>{{ $r->in }}</td>
                            <td>{{ $r->out }}</td>
                            <td>{{ $r->qty }}
                            </td>
                            <td>{{ $r->branch_name }}</td>
                            <td>Rp{{ number_format($r->avg_new_price, 0, '.', '.') }}</td>
                            <td>
                                Rp{{ number_format($r->qty * $r->avg_new_price, 0, '.', '.') }}
                            </td>
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
