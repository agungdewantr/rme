<x-slot:title>
    Settings
</x-slot:title>

<x-page-layout>
    <form id="form" wire:submit="save" x-data="form">
        <x-slot:button>
            <button class="btn btn-primary" wire:click="save">Simpan</button>
        </x-slot:button>

        <x-slot:breadcrumbs>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Settings</li>
        </x-slot:breadcrumbs>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" wire:model="email">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model="is_can_minus"
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Izinkan stok minus
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">+62</span>
                                    <input type="text" class="form-control" aria-label="Username"
                                        wire:model="phone_number" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="float_precision" class="form-label">Float Precission</label>
                                    <input type="float_precision"
                                        class="form-control @error('float_precision') is-invalid @enderror"
                                        id="float_precision" wire:model="float_precision">
                                    @error('float_precision')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="">
                                <div class="mb-3">
                                    <label for="running_text" class="form-label">Running Text</label>
                                    <input type="running_text"
                                        class="form-control @error('running_text') is-invalid @enderror"
                                        id="running_text" wire:model="running_text">
                                    @error('running_text')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-12">
                                <div class="mb-3" wire:ignore>
                                    <label for="exampleFormControlTextarea1" class="form-label">Header Kop Surat</label>
                                    <div id="summernote" class="tw-prose">
                                        {!! $header_letter !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="photo" class="form-label">Foto</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                id="photo" wire:model="photo" accept="image/jpeg, image/png,">
                            @error('photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <img src="{{ !$photo ? asset('storage/' . $currentPhoto) : $photo->temporaryUrl() }}"
                            alt="" style="object-fit: cover; object-position: center" class="w-100"> --}}
                        @if ($photo && strpos($photo->getMimeType(), 'image') !== false)
                            <img src="{{ $photo->temporaryUrl() }}" alt=""
                                style="object-fit: cover; object-position: center" class="w-50">
                        @elseif($currentPhoto)
                            <img src="{{ asset('storage/' . $currentPhoto) }}" alt=""
                                style="object-fit: cover; object-position: center" class="w-50">
                        @elseif(!$photo && !$currentPhoto)
                            <span class="text-danger"></span>
                        @else
                            <span class="text-danger">File yang dipilih bukan gambar.</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <livewire:setting.table.branch />
                    <livewire:setting.table.clinic />
                </div>
            </div>
        </div>
    </form>
</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/summernote-0.8.18-dist/summernote-lite.min.css') }}" />
    <script src="{{ asset('assets/vendor/summernote-0.8.18-dist/summernote-lite.min.js') }}"></script>
    <style>
        .note-editable ul {
            list-style: disc !important;
            list-style-position: inside !important;
        }

        .note-editable ol {
            list-style: decimal !important;
            list-style-position: inside !important;
        }

        table td {
            position: relative;
        }

        table td input[type=text],
        table td select {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            margin: 0;
            height: 100% !important;
            width: 100%;
            border-radius: 0 !important;
            border: none !important;
            padding: 5px;
            box-sizing: border-box;
        }
    </style>
@endassets

@script
    <script>
        Alpine.data('form', () => ({
            header_letter: @entangle('header_letter'),
            init() {
                $("#summernote").summernote({
                    height: 100,
                    callbacks: {
                        onChange: (contents, $editable) => {
                            this.header_letter = contents
                        }
                    }
                })
            },
        }))
    </script>
@endscript
