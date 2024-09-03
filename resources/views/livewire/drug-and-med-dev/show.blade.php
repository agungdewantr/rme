<x-slot:title>
    Detail Obat dan Alkes
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('drug-and-med-dev.index') }}" wire:navigate>Obat dan Alkes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Obat dan Alkes</li>
    </x-slot:breadcrumbs>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto</label>
                    </div>
                    <img src="{{ asset('storage/' . $drugMedDev->photo) }}" alt=""
                        style="object-fit: cover; object-position: center" class="w-100">
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" disabled
                            value="{{ $drugMedDev->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipe</label>
                        <select class="form-select" id="type" name="type" aria-label="Default select example"
                            disabled>
                            <option value="Obat" @if ($drugMedDev->type == 'Obat') selected @endif>Obat</option>
                            <option value="Alat Kesehatan" @if ($drugMedDev->type == 'Alat Kesehatan') selected @endif>Alat
                                Kesehatan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Kategori</label>
                        <input type="text" disabled value="{{$drugMedDev->category->name}}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis</label>
                        <input type="text" disabled value="{{$drugMedDev->jenis}}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="uom" class="form-label">Satuan</label>
                        <select class="form-select" id="uom" name="uom" aria-label="Default select example"
                            disabled>
                            <option value="Pcs" @if ($drugMedDev->uom == 'Pcs') selected @endif>Pcs</option>
                            <option value="Strip" @if ($drugMedDev->uom == 'Strip') selected @endif>Strip</option>
                            <option value="Botol" @if ($drugMedDev->uom == 'Botol') selected @endif>Botol</option>
                            <option value="Box" @if ($drugMedDev->uom == 'Box') selected @endif>Box</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="purchase_price" class="form-label">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                            <input type="text" class="form-control" name="purchase_price" id="purchase_price"
                                disabled value="{{ number_format($drugMedDev->purchase_price, 0, ',', '.') }}"
                                aria-label="Harga Beli" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                            <input type="text" class="form-control" name="selling_price" id="selling_price"
                                aria-label="Harga Beli" aria-describedby="basic-addon1" disabled
                                value="{{ number_format($drugMedDev->selling_price, 0, ',', '.') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="min_stock" class="form-label">Minimum Stok</label>
                        <input type="text" class="form-control" id="min_stock" disabled
                            value="{{ $drugMedDev->min_stock }}">
                    </div>
                    {{-- <div class="mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="text" class="form-control" id="stock" disabled
                            value="{{ $drugMedDev->stock }}">
                    </div> --}}
                    {{-- <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                @if ($drugMedDev->is_can_minus) checked @endif id="flexCheckDefault" disabled>
                            <label class="form-check-label" for="flexCheckDefault">
                                Izinkan stok minus
                            </label>
                        </div>
                    </div> --}}
                    <div class="mb-3">
                        <label for="type" class="form-label">Tanggal Kadaluarsa</label>
                        <input type="text" disabled value="{{$drugMedDev->expired_date}}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="card mb-3">
        <div class="card-body">
            <p class="h5">Konversi & Supplier</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="h6">Unit Konversi</p>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Satuan</th>
                                <th>Konversi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" align="center">Tidak ada data</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="h6">Supplier</p>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>PIC</th>
                                <th>Nomor Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" align="center">Tidak ada data</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
    <section class="py-5">
        <ul class="timeline">
            @foreach ($logs as $log)
                <li class="timeline-item mb-3">
                    <h5 class="efw-bold tw-text-xs">{{ $log->author }}</h5>
                    <p class="text-muted mb-2 fw-bold tw-text-xs">{{ $log->created_at->format('j F Y H:i:s') }}</p>
                    <p class="text-muted tw-text-xs">
                        {{ $log->log }}
                    </p>
                </li>
            @endforeach
        </ul>
    </section>
</x-page-layout>

@assets
    <style>
        .timeline {
            border-left: 1px solid black;
            position: relative;
            list-style: none;
        }

        .timeline .timeline-item {
            position: relative;
        }

        .timeline .timeline-item:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .timeline-item:after {
            background-color: black;
            left: -38px;
            border-radius: 50%;
            height: 11px;
            width: 11px;
            content: "";
        }
    </style>
@endassets
