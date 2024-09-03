<x-slot:title>
    Laporan Per Tindakan
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
            x-on:click="(e)=>{
                e.stopImmediatePropagation()
            }"
            data-bs-placement="bottom" target="_blank" data-bs-title="Cetak">
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
                {{-- <div class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Cari" wire:model.live="search" aria-label="Username" aria-describedby="basic-addon1">
                </div> --}}
                <div wire:ignore class="tw-max-w-[300px] input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-calendar-days"></i>
                    </span>
                    <input type="text" date-picker name="" id="" class="form-control">
                </div>
                {{-- <div wire:ignore class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-filter"></i>
                    </span>
                    <select class="form-select select2 @error('doctor_id') is-invalid @enderror" id="doctor_id" name="doctor_id"
                        aria-label="Default select example" wire:model.live="doctor_id">
                        <option value="" selected>Pilih Dokter</option>
                        @foreach ($doctors as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div> --}}
                @if($type = 'Lap. per Tindakan')
                <div class="input-group" style="width:300px">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-filter"></i>
                    </span>
                    <select class="form-select select2 @error('poli') is-invalid @enderror" id="poli" name="poli"
                        aria-label="Default select example" wire:model.live="poli">
                        <option value="" selected>Pilih Poli</option>
                        <option value="Poli Kandungan">Poli Kandungan</option>
                        <option value="Poli Anak">Poli Anak</option>
                    </select>
                </div>
                @endif
            </div>
            <p class="h5">Laporan Per Tindakan</p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Poli</th>
                        <th>Tindakan</th>
                        <th>Jumlah</th>
                        <th>Harga (Rp)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                        @foreach ($actions  as $item)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$item->date}}</td>
                            <td>{{$item->poli}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{ $item->qty_sum }}</td>
                            <td>Rp. {{number_format($item->price, 0, '.', '.')}}</td>
                            <td>Rp. {{number_format($item->qty_sum * $item->price, 0, '.', '.')}}</td>
                        </tr>
                        @endforeach
                        @if($total_price > 0)
                            <td colspan="6" class="text-end">Grand Total</td>
                            <td>Rp. {{number_format(($total_price ?? 0), 0, '.', '.')}}</td>
                        @endif

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
