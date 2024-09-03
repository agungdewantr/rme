<x-slot:title>
    Tambah Obat dan Alkes
</x-slot:title>

<x-page-layout>
    <x-slot:button>
        <button class="btn btn-primary"
                x-on:click="Livewire.dispatchTo('drug-and-med-dev.create', 'drug-and-med-dev-create')">Simpan
        </button>
    </x-slot:button>

    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('drug-and-med-dev.index') }}" wire:navigate>Obat dan Alkes</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Obat dan Alkes</li>
    </x-slot:breadcrumbs>

    <form id="form" wire:submit="save" x-date="{}">
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
                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" alt=""
                                 style="object-fit: cover; object-position: center" class="w-100">
                        @endif
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
                                <option value="" selected>Pilih Tipe</option>
                                <option value="Obat">Obat</option>
                                <option value="Alat Kesehatan">Alat Kesehatan</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3" style="width: 96%" wire:ignore>
                            <label for="id_category" class="form-label">Kategori</label>
                            <select class="form-select @error('id_category') is-invalid @enderror" id="id_category"
                                    name="id_category" aria-label="Default select example" wire:model="id_category">
                                <option value="" selected>Pilih Kategori</option>
                                @foreach ($categories as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
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
                                <input type="text" class="form-control @error('purchase_price') is-invalid @enderror"
                                       name="purchase_price" id="purchase_price" wire:model="purchase_price"
                                       readonly
                                       aria-label="Harga Beli" aria-describedby="basic-addon1" x-on:keyup="()=>{
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
                                <input type="text" class="form-control @error('selling_price') is-invalid @enderror"
                                       name="selling_price" id="selling_price" wire:model="selling_price"
                                       aria-label="Harga Beli" aria-describedby="basic-addon1" x-on:keyup="()=>{
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
                        <div class="mb-3">
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
    </form>
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
    flatpickr($wire.$el.querySelector('#expired_date'), {
        dateFormat: "d-m-Y",
        "locale": "id",
        minDate: 'today',
        allowInput: true,
        // defaultDate: new Date()
    });

    $('#id_category').select2({
        theme: 'bootstrap-5',
    });

    $('#id_category').on('change', function (e) {
        var data = $('#id_category').select2("val");
        $wire.$set('id_category', data);

    });
</script>
@endscript
