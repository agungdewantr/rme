{{-- <div class="tw-p-6 tw-flex tw-flex-col tw-space-y-4">
    <div class="tw-flex tw-justify-between tw-items-center">
        <p>Hapus Pasien</p>
        <button wire:click="$dispatch('closeModal')" type="button"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <p>Pasien beserta data yang dimiliki pasien tersebut ikut terhapus. Apakah Anda yakin ?</p>
    <div class="tw-flex tw-justify-end tw-space-x-4">
        <button wire:click="$dispatch('closeModal')" type="button">Batal</button>
        <button class="tw-text-red-500" type="button"
            x-on:click="()=>{
            $wire.dispatchTo('patient.index', 'delete-patient', {uuid:'{{ $uuid }}'})
        }">Hapus</button>
    </div>
</div> --}}
<form wire:submit="save" class="tw-p-6 tw-flex tw-flex-col tw-space-y-4">
    <div class="tw-flex tw-justify-between tw-items-center">
        <p>Hapus Pasien</p>
        <button wire:click="$dispatch('closeModal')" type="button"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <p>Pasien beserta data yang dimiliki pasien tersebut ikut terhapus. Apakah Anda yakin ?</p>
    <div class="tw-flex tw-justify-end tw-space-x-4">
        <button wire:click="$dispatch('closeModal')" type="button">Batal</button>
        <button class="tw-text-red-500" type="submit">Hapus</button>
    </div>
</form>
