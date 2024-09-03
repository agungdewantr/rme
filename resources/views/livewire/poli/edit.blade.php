<form wire:submit="save" class="card" x-data="checkup">
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
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{$is_active ? 'checked' : ''}} wire:model="is_active">
                        <label class="form-check-label" for="flexSwitchCheckChecked">Status</label>
                      </div>
                </div>

                <div class="row">
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
                                <template x-if="checkups.length">
                                    <template x-for="(value, index) in checkups">
                                        <tr class="text-center" :key="value.id">
                                            <td x-text="index+1"></td>
                                            <td>
                                                <input type="text" placeholder="Nama" class="form-control" x-model="value.name">
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" x-model="value.is_active">
                                                  </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        wire:click="deleteRow(value.id)"><i
                                                            class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                                <template x-if="!checkups.length">
                                    <tr>
                                        <td colspan="4" align="center">Tidak ada data</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                </div>
                <button type="button" class="btn btn-sm btn-warning mb-2"
                x-on:click="addRow">Tambah</button>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModal')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>


@script
    <script>
        Alpine.data('checkup', () => ({
            checkups: @entangle('checkups'),
            init() {
                $wire.on('get-checkup', ({
                    items
                }) => {
                    this.checkups = items
                })
                $wire.on('delete-value', ({
                    items
                }) => {
                    this.checkups = items
                })
            },

            addRow() {
                this.checkups.push({
                    id: Math.floor(Math.random() * 100) + 1,
                    name: null,
                    is_active: true,
                })
            }
        }))
    </script>
@endscript
