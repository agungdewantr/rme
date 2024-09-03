<form wire:submit="save" class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Tindakan</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Tindakan</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                wire:model="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category"
                aria-label="Default select example" wire:model="category">
                <option value="" selected>Pilih Kategori</option>
                <option value="Administrasi">Administrasi</option>
                <option value="Tindakan">Tindakan</option>
            </select>
            @error('category')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Tarif</label>
            <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                wire:model="price"
                x-on:keyup="()=>{
                    let  price = document.getElementById('price');
                    var number_string = (price.value).replace(/[^,\d]/g, '').toString(),

                    split   = number_string.split(','),
                    sisa     = split[0].length % 3,
                    rupiah     = split[0].substr(0, sisa),
                    ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
                    if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    price.value = rupiah;
                }">
            @error('price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModal')">Batal</button>
        <button type="submit" class="btn btn-primary" wire:dirty wire:loading.attr="disabled">
            <i class="fa-solid fa-spinner tw-animate-spin" wire:loading></i>
            Simpan</button>
    </div>
</form>
