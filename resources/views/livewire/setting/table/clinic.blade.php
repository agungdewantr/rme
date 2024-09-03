<div class="col-md-6">
    <div class="d-flex justify-content-between align-items-center">
        <p class="h6">Poli</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Poli</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clinics as $c)
                <livewire:setting.table.clinic-row :clinic="$c" :iteration="$loop->iteration" :key="rand()" />
            @empty
                <tr>
                    <td colspan="5" align="center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <button type="button" class="btn btn-sm btn-primary mb-2" wire:click="add">Tambah</button>
</div>
