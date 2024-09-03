<x-slot:title>
    Laporan Pendapatan
</x-slot:title>


<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laporan</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <div class="dropdown">
            <button class="btn dropdown-toggle text-decoration-none" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-title="Download" aria-expanded="false">
                <span class="text-success"><i class="fa-solid fa-download"></i></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">Pdf</a></li>
                <li><a class="dropdown-item" href="#">Excel</a></li>
            </ul>
        </div>
        <a href=""
            class="text-decoration-none" data-bs-toggle="tooltip"
            data-bs-placement="bottom" wire:click="print" target="_blank" data-bs-title="Cetak">
            <span class="text-warning"><i class="fa-solid fa-print fa-fw"></i></span>
        </a>
        <div class="dropdown">
            <button class="btn dropdown-toggle text-decoration-none" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="text-primary"><i class="fa-solid fa-ellipsis-vertical"></i></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><button class="dropdown-item" wire:click="report_type('Lap. Pendapatan')">Lap. Pendapatan</button></li>
                <li><button  class="dropdown-item" wire:click="report_type('Lap. per Tindakan')">Lap. per Tindakan</button></li>
                <li><button class="dropdown-item" wire:click="report_type('Lap. per Dokter')">Lap. per Dokter</button></li>
            </ul>
        </div>
    </x-slot:button>

    <div class="card">
        <div class="card-body">
            <div class="d-flex gap-2 align-items-center mb-3">
                <div wire:ignore class="tw-max-w-[300px] input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-calendar-days"></i>
                    </span>
                    <input type="text" date-picker name="" id="" class="form-control">
                </div>
                @if($type = 'Lap. Pendapatan')
                <div class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-filter"></i>
                    </span>
                    <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id"
                        aria-label="Default select example" wire:model.live="branch_id">
                        <option value="" selected>Pilih Cabang</option>
                        @foreach ($branches as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
            <p class="h5">Laporan Pendapatan</p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Cabang</th>
                        <th>Tindakan</th>
                        <th>Obat</th>
                        <th>Pembayaran Tunai</th>
                        <th>Pembayaran EDC</th>
                        <th>Pembayaran Transfer</th>
                        <th>Pendapatan Harian</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                        $branch = '';
                        $grand_total = 0;
                    @endphp
                        @foreach ($reports  as $key => $report)
                            @foreach ($report as $r)
                            @php
                            $total_action = 0;
                            $total_drug = 0;
                            $total_cash = 0;
                            $total_transfer = 0;
                            $total_edc = 0;
                            $drug_p = 0;
                            $action_p = 0;
                            @endphp
                                    @foreach($r as $p)
                                    @php
                                        $branch = $p->branch->name;
                                        $m = '';
                                    @endphp
                                        @if(isset($p->medicalRecord->transaction->actions))
                                            @if($p->medicalRecord->transaction->actions->count() > 0)
                                                @foreach($p->medicalRecord->transaction->actions as $act)
                                                    @php
                                                        $total_action += (int)$act->price*$act->pivot->qty
                                                    @endphp
                                                @endforeach
                                            @endif
                                        @endif
                                        @if(isset($p->medicalRecord->transaction->drugMedDevs))
                                            @if($p->medicalRecord->transaction->drugMedDevs->count() > 0)
                                            @foreach ($p->medicalRecord->transaction->drugMedDevs as $drug)
                                                @php
                                                    $total_drug += (int)$drug->selling_price*$drug->pivot->qty
                                                @endphp
                                            @endforeach
                                            @endif
                                        @endif
                                            @php
                                                $transaction = $p->medicalRecord->transaction;
                                                if($transaction){
                                                    if($transaction->payment_method == 'Transfer' || $transaction->payment_method == 'QRIS'){
                                                        foreach($transaction->actions ?? [] as $ta){
                                                            $total_transfer += $ta->price * $ta->pivot->qty;
                                                        }
                                                        foreach($transaction->drugMedDevs ?? [] as $td){
                                                            $total_transfer += $td->selling_price * $td->pivot->qty;
                                                        }
                                                    }elseif($transaction->payment_method == 'EDC'){
                                                        foreach($transaction->actions ?? [] as $ta){
                                                            $total_edc += $ta->price * $ta->pivot->qty;
                                                        }
                                                        foreach($transaction->drugMedDevs ?? [] as $td){
                                                            $total_edc += $td->selling_price * $td->pivot->qty;
                                                        }
                                                    }elseif($transaction->payment_method == 'Cash'){
                                                        foreach($transaction->actions ?? [] as $ta){
                                                            $total_cash += $ta->price * $ta->pivot->qty;
                                                        }
                                                        foreach($transaction->drugMedDevs ?? [] as $td){
                                                            $total_cash += $td->selling_price * $td->pivot->qty;
                                                        }
                                                    }
                                                }
                                            @endphp
                                    @endforeach
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$key}}</td>
                                    <td>{{$branch}}</td>
                                    <td>Rp. {{ number_format($total_action, 0, '.', '.')}}</td>
                                    <td>Rp. {{ number_format($total_drug, 0, '.', '.')}}</td>
                                    <td>Rp. {{ number_format($total_cash, 0, '.', '.')}}</td>
                                    <td>Rp. {{number_format($total_edc, 0, '.', '.')}}</td>
                                    <td>Rp. {{ number_format($total_transfer, 0, '.', '.')}}</td>
                                    <td>Rp. {{number_format($total_drug+$total_action, 0, '.', '.')}}</td>
                                </tr>
                                @php
                                    $grand_total += $total_drug+$total_action;
                                @endphp
                                @endforeach
                        @endforeach
                            <td colspan="8" class="text-end">Grand Total</td>
                            <td>Rp. {{number_format(($grand_total ?? 0), 0, '.', '.')}}</td>

                </tbody>
            </table>
        </div>
    </div>

</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
@endassets

@script
    <script>
         const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        flatpickr($wire.$el.querySelector('[date-picker]'), {
            mode: 'range',
            onClose: (selectedDates) => {
                $wire.$set('date', selectedDates)
            }
        })

        $('.select2').select2({
            theme: 'bootstrap-5',
        });
        $('#poli').on('change', function(e) {
            var data = $('#poli').select2("val");
            $wire.$set('poli', data);
        });
    </script>
@endscript
