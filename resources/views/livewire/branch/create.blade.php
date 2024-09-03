<x-slot:title>
    Tambah Cabang
</x-slot:title>

<x-page-layout>
    <div>
        <x-slot:breadcrumbs>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('branch.index') }}" wire:navigate>Cabang</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Cabang</li>
        </x-slot:breadcrumbs>

        <x-slot:button>
            <div class="d-flex">
                <button class="btn btn-primary"  wire:click="save">
                    <i wire:loading class="fa-solid fa-spinner tw-animate-spin"></i>

                    Simpan
                </button>
            </div>
        </x-slot:button>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Cabang<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="name" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Alamat<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="address" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No Handphone<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="phone_number" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status"
                                        id="status" wire:model.live="status">
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3" wire:ignore>
                                    <label for="exampleFormControlTextarea1" class="form-label">Poli<span class="text-danger">*</span></label>
                                    <select name="poli" id="poli" style="width: 100%"
                                        multiple class="select2 form-control w-100">
                                            @foreach ($polis as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="tw-container tw-mx-auto tw-px-4">
                        <div class="tw-grid tw-grid-cols-1 tw-gap-4">
                            <!-- Day and Select fields -->
                            @foreach ($days as $key => $day)
                            <div class="tw-grid tw-grid-cols-8 tw-items-center tw-gap-2 tw-border-b tw-pb-2 tw-mb-2">
                                <div class="tw-col-span-1 tw-flex tw-items-center">
                                    <input checked type="checkbox" name="{{ $key }}" wire:model="days.{{ $key }}.status" class="tw-form-checkbox tw-h-5 tw-w-5 tw-text-blue-600">
                                    <label for="{{ $key }}" class="tw-ml-2 tw-text-lg">{{ ucfirst($key) }}</label>
                                </div>
                                <div class="tw-col-span-7 tw-grid tw-gap-2">
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($day as $key2 => $d)

                                    @if (is_array($d))
                                    <div class="tw-grid tw-grid-cols-8 tw-items-center tw-gap-2 tw-border">
                                        <div class="tw-col-span-1">
                                            <select name="days.{{ $key }}.{{ $key2 }}.poli" wire:model="days.{{ $key }}.{{ $key2 }}.poli" class="tw-form-select tw-w-full tw-p-2">
                                                    <option value="">Pilih Poli</option>
                                                    <option value="Poli Pagi">Poli Pagi</option>
                                                    <option value="Poli Sore">Poli Sore</option>
                                            </select>
                                        </div>
                                        <div class="tw-col-span-1" wire:ignore>
                                            <input type="time" placeholder="Jam Buka" name="days.{{ $key }}.{{ $key2 }}.open" wire:model="days.{{ $key }}.{{ $key2 }}.open" class="tw-form-input tw-w-full tw-p-2"
                                            x-init="() => {
                                                flatpickr($($el), {
                                                    enableTime: true,
                                                    noCalendar: true,
                                                    dateFormat: 'H:i',
                                                    time_24hr: true
                                                })
                                            }">
                                        </div>
                                        <div class="tw-col-span-1" wire:ignore>
                                            <input type="time" placeholder="Jam Tutup" name="days.{{ $key }}.{{ $key2 }}.close" wire:model="days.{{ $key }}.{{ $key2 }}.close" class="tw-form-input tw-w-full tw-p-2"
                                            x-init="() => {
                                                flatpickr($($el), {
                                                    enableTime: true,
                                                    noCalendar: true,
                                                    dateFormat: 'H:i',
                                                    time_24hr: true
                                                })
                                            }">
                                        </div>
                                        <div class="tw-col-span-1 tw-text-center">
                                            @if($i != 0)
                                            <button type="button" class="tw-text-red-600" wire:click="deleteRow('{{$key}}','{{$key2}}',{{$d['id'] ?? 0}})"><i class="fa-solid fa-x"></i></button>
                                            @endif
                                            @if($i == 0)
                                            <button type="button" class="tw-text-green-600" wire:click="addRow('{{ $key }}')"><i class="fa-solid fa-plus"></i></button>
                                            @endif
                                            @php
                                                $i++;
                                            @endphp
                                        </div>
                                        {{-- <div class="tw-col-span-1 tw-text-center">
                                        </div> --}}
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
@endassets


@script
    <script>
        let $poli = $('#poli');
         $poli.select2({
            theme: 'bootstrap-5',
            tokenSeparators: [',']
        })

        $poli.on('select2:select', function(e) {
            $wire.set('poli', $poli.select2('data').map(i => i['text']))
        })

        $poli.on('change', function () {
            $wire.set('poli', $poli.select2('data').map(i => i['text']))
        })
    </script>
@endscript
