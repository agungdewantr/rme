<tr>
    <td style="width:250px">
        <select name="feature" wire:model.live="feature" class="form-select">
            <option value="">Pilih Fitur</option>
            <option value="patient">Data Pasien</option>
            <option value="mr">Rekam Medis</option>
            <option value="registration">Pendaftaran</option>
            <option value="payment">Kasir</option>
            <option value="report">Laporan</option>
            <option value="setting.general">General</option>
            <option value="setting.role">Role</option>
            <option value="master.healthworker">Tenaga Kesehatan</option>
            <option value="master.drugmeddev">Obat dan Alkes</option>
            <option value="action">Jenis Tindakan</option>
            <option value="first_entry">Assesment Awal</option>
            <option value="stock_entry">Stock Entry</option>
        </select>
    </td>
    <td style="width:250px; vertical-align:middle" wire:ignore>
        <select name="role_id" wire:model.live="role_id" id="{{ $id }}" class="form-select">
            <option value="">Pilih Role</option>
            @foreach ($roles as $item)
                <option value="{{ $item->id }}" {{ $item->id === $id ? 'selected' : '' }}>{{ $item->name }}
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <div class="row">
            <div class="col-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="create" id="flexCheckDefault"
                        wire:model.live="create">
                    <label class="form-check-label" for="flexCheckDefault">
                        Create
                    </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="read" id="flexCheckDefault"
                        wire:model.live="read">
                    <label class="form-check-label" for="flexCheckDefault">
                        Read
                    </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="update" id="flexCheckDefault"
                        wire:model.live="update">
                    <label class="form-check-label" for="flexCheckDefault">
                        Update
                    </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="delete" id="flexCheckDefault"
                        wire:model.live="delete">
                    <label class="form-check-label" for="flexCheckDefault">
                        Delete
                    </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="print" id="flexCheckDefault"
                        wire:model.live="print">
                    <label class="form-check-label" for="flexCheckDefault">
                        Print
                    </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="report" id="flexCheckDefault"
                        wire:model.live="report">
                    <label class="form-check-label" for="flexCheckDefault">
                        Report
                    </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="import" id="flexCheckDefault"
                        wire:model.live="import">
                    <label class="form-check-label" for="flexCheckDefault">
                        Import
                    </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="export" id="flexCheckDefault"
                        wire:model.live="export">
                    <label class="form-check-label" for="flexCheckDefault">
                        Export
                    </label>
                </div>
            </div>
        </div>
    </td>
    <td>
        <div class="d-flex">
            <button class="btn btn-sm btn-warning me-2" wire:click="save">
                <i class="fa-regular fa-floppy-disk"></i>
            </button>
            <button class="btn btn-sm btn-danger" wire:click="deleteRow">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
