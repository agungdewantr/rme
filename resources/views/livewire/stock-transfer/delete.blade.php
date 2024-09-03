<div class="tw-p-6 tw-flex tw-flex-col tw-space-y-4">
    <div class="tw-flex tw-justify-between tw-items-center">
        <p>Hapus Poli</p>
        <button wire:click="$dispatch('closeModal')" type="button"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <p>Anda yakin ingin mengahpus stock Transfer dengan Number {{$stockTransfer->stock_transfer_number}} ?</p>
    <div class="tw-flex tw-justify-end tw-space-x-4">
        <button wire:click="$dispatch('closeModal')" type="button">Batal</button>
        <button class="tw-text-red-500" type="button" wire:click="delete">Hapus</button>
    </div>
</div>
