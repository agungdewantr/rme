<form wire:submit="save" class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tambah Poli</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Poli</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                wire:model="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" wire:model="is_active" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">Status</label>
              </div>
        </div>

        <div class="row" x-data="{
        checkups: @entangle('checkups')
        }">
            <p class="h5">Jenis Pemeriksaan</p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemeriksaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-if="checkups.length>0">
                        <template x-for="(value, index) in checkups" :key="value.id">
                            <tr class="text-center">
                                <td x-text="index+1"></td>
                                <td>
                                    <input type="text" placeholder="Nama" class="form-control"
                                        x-on:blur="(e)=>{
                                        checkups = checkups.map((val, idx)=>{
                                            if(value.id === val.id){
                                                return {
                                                    ...val,
                                                    name:e.target.value
                                                }
                                            }else{
                                                return val
                                            }
                                        })
                                    }">
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked
                                        x-on:change="(e)=>{
                                         checkups = checkups.map((val, idx)=>{
                                            if(value.id === val.id){
                                                return {
                                                    ...val,
                                                    status:e.target.checked
                                                }
                                            }else{
                                                return val
                                            }
                                        })
                                        }">
                                      </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        x-on:click="checkups = checkups.filter((item)=>item.id!==value.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </template>
                    <template x-if="checkups.length==0">
                        <tr>
                            <td colspan="4" align="center">Tidak ada data</td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <div class="row">
                <button type="button" class="col-md-2 btn btn-sm btn-warning mb-2"
                x-on:click="()=>{
                    checkups = [
                        ...checkups,
                        {
                            id:Math.floor(Math.random() * 100) + 1,
                            name:'',
                            status: true
                        }
                    ]
                }">Tambah</button>
            </div>
        </div>
    </div>

    <div class="card-footer d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModal')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
