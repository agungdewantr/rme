<div class="col-md-6">
    <div class="d-flex justify-content-between align-items-center">
        <p class="h6">Cabang</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th class="tw-w-6">No</th>
                <th class="tw-max-w-12">Nama Cabang</th>
                <th>Alamat</th>
                <th class="tw-w-6">Aktif</th>
                <th class="tw-w-8">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($branches as $b)
                <livewire:setting.table.branch-row :branch="$b" :iteration="$loop->iteration" :key="rand()" />
            @empty
                <tr>
                    <td colspan="5" align="center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <button type="button" class="btn btn-sm btn-primary mb-2" wire:click="add">Tambah</button>
</div>
