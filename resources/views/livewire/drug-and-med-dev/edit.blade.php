<x-slot:title>
    Ubah Obat dan Alkes
</x-slot:title>

<x-page-layout>
    <x-slot:button>
        <button class="btn btn-primary"
                x-on:click="Livewire.dispatchTo('drug-and-med-dev.edit', 'drug-and-med-dev-update')" wire:dirty
                wire:loading.attr="disabled">
            <i class="fa-solid fa-spinner tw-animate-spin" wire:loading></i>
            Simpan
        </button>
    </x-slot:button>

    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('drug-and-med-dev.index') }}" wire:navigate>Obat dan Alkes</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Ubah Obat dan Alkes</li>
    </x-slot:breadcrumbs>

    <form id="form" wire:submit="save">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="photo" class="form-label">Foto</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                   id="photo" wire:model="photo">
                            @error('photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <img src="{{ $photo ? $photo->temporaryUrl() : asset('storage/' . $drugMedDev->photo) }}"
                             alt="" style="object-fit: cover; object-position: center" class="w-100">
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" wire:model="name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type"
                                    name="type" aria-label="Default select example" wire:model="type">
                                <option value="" selected>Pilih Kategori</option>
                                <option value="Obat">Obat</option>
                                <option value="Alat Kesehatan">Alat Kesehatan</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3" style="width: 96%">
                            <label for="id_category" class="form-label">Kategori</label>
                            <select class="form-control @error('id_category') is-invalid @enderror" id="id_category"
                                    name="id_category" aria-label="Default select example" wire:model="id_category">
                                <option value="" selected>Pilih Kategori</option>
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            @error('id_category')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select class="form-select @error('jenis') is-invalid @enderror" id="jenis"
                                    name="jenis" aria-label="Default select example" wire:model="jenis">
                                <option value="" selected>Pilih Jenis</option>
                                <option value="Paten">Paten</option>
                                <option value="Generik">Generik</option>
                            </select>
                            @error('jenis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="uom" class="form-label">Satuan</label>
                            <select class="form-select @error('uom') is-invalid @enderror" id="uom" name="uom"
                                    aria-label="Default select example" wire:model="uom">
                                <option value="" selected>Pilih Satuan</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Tube">Tube</option>
                                <option value="Strip">Strip</option>
                                <option value="Botol">Botol</option>
                                <option value="Box">Box</option>
                                <option value="Suppos">Suppos</option>
                                <option value="Ampl">Ampl</option>
                                <option value="Vial">Vial</option>
                                <option value="Kotak">Kotak</option>
                                <option value="Buah">Buah</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('uom')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="purchase_price" class="form-label">Harga Beli</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text" readonly
                                       class="form-control @error('purchase_price') is-invalid @enderror"
                                       name="purchase_price" id="purchase_price" wire:model="purchase_price"
                                       aria-label="Harga Beli" aria-describedby="basic-addon1"
                                       x-on:keyup="()=>{
                                        let  purchase_price = document.getElementById('purchase_price');
                                        var number_string = (purchase_price.value).replace(/[^,\d]/g, '').toString(),

                                        split   = number_string.split(','),
                                        sisa     = split[0].length % 3,
                                        rupiah     = split[0].substr(0, sisa),
                                        ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
                                        if(ribuan){
                                        separator = sisa ? '.' : '';
                                        rupiah += separator + ribuan.join('.');
                                        }
                                        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                                        purchase_price.value = rupiah;
                                    }">
                                @error('purchase_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="selling_price" class="form-label">Harga Jual</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text"
                                       class="form-control @error('selling_price') is-invalid @enderror"
                                       name="selling_price" id="selling_price" wire:model="selling_price"
                                       aria-label="Harga Beli" aria-describedby="basic-addon1"
                                       x-on:keyup="()=>{
                                        let  selling_price = document.getElementById('selling_price');
                                        var number_string = (selling_price.value).replace(/[^,\d]/g, '').toString(),

                                        split   = number_string.split(','),
                                        sisa     = split[0].length % 3,
                                        rupiah     = split[0].substr(0, sisa),
                                        ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
                                        if(ribuan){
                                        separator = sisa ? '.' : '';
                                        rupiah += separator + ribuan.join('.');
                                        }
                                        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                                        selling_price.value = rupiah;
                                    }">
                                @error('selling_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="min_stock" class="form-label">Minimum Stok</label>
                            <input type="text" class="form-control @error('min_stock') is-invalid @enderror"
                                   id="min_stock" wire:model="min_stock">
                            @error('min_stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3" wire:ignore>
                            <label for="expired_date" class="form-label">Tanggal Kadaluarsa</label>
                            <input type="text" date-picker class="form-control" wire:model="expired_date"
                                   id="expired_date">
                            @error('expired_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="text" class="form-control" id="stock" disabled>
                        </div> --}}
                        {{-- <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="is_can_minus"
                                    id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Izinkan stok minus
                                </label>
                            </div>
                        </div> --}}
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
                            <button type="button" class="btn btn-sm btn-primary mb-2">Tambah</button>
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
                            <button type="button" class="btn btn-sm btn-primary mb-2">Tambah</button>
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
        <div class="card mb-3">
            <div class="card-header">
                <h4>Riwayat Harga</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h6>Harga Beli</h6>
                        <div class="table-responsive mt-2">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Last Update</th>
                                    <th>Last Price</th>
                                    <th>New Price</th>
                                    <th>Updated By</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($batches as $index=> $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            Rp{{ $index > 0 ?number_format( $batches[$index-1]->new_price, 0, thousands_separator:'.' ): 0}}</td>
                                        <td>Rp{{ number_format($item->new_price, 0, thousands_separator:'.') }}</td>
                                        <td>{{ '-' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-6">
                        <h6>Harga Jual</h6>
                        <div class="table-responsive mt-2">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Last Update</th>
                                    <th>Last Price</th>
                                    <th>New Price</th>
                                    <th>Updated By</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($drugMedDevPriceHistory as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>Rp{{ number_format( $item->old_price, 0, thousands_separator:'.' )}}</td>
                                        <td>Rp{{ number_format($item->new_price, 0, thousands_separator:'.') }}</td>
                                        <td>{{ $item->user->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
<link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
<script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
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

@script
<script>
    const idCategory = $wire.$get('id_category');
    flatpickr($wire.$el.querySelector('#expired_date'), {
        dateFormat: "d-m-Y",
        "locale": "id",
        minDate: 'today',
        allowInput: true,
        // defaultDate: new Date()
    });

    $('#id_category').val(idCategory).trigger('change');
    $('#id_category').select2({
        theme: 'bootstrap-5',
    });

    $('#id_category').on('change', function (e) {
        var data = $('#id_category').select2("val");
        $wire.$set('id_category', data);

    });
</script>
@endscript
