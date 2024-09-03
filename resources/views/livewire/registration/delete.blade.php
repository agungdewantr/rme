<form wire:submit="save" class="tw-p-6 tw-flex tw-flex-col tw-space-y-4">
    <div class="tw-flex tw-justify-between tw-items-center">
        <p>Hapus Pendaftaran</p>
        <button wire:click="$dispatch('closeModal')" type="button"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <p>Pendaftaran akan dibatalkan. Apakah Anda yakin ?</p>
    <div class="tw-flex tw-justify-end tw-space-x-4">
        <button wire:click="$dispatch('closeModal')" type="button">Batal</button>
        <button class="tw-text-red-500" type="submit">Hapus</button>
    </div>
</form>
