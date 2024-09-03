<x-slot:title>
    Detail Role
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('role.index') }}" wire:navigate>Role</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
    </x-slot:breadcrumbs>

    <x-slot:button>
        <button class="btn btn-primary"
            wire:click="$dispatch('openModal', {component:'role.add-user', arguments:{role_uuid:'{{ $role->uuid }}'}})"><i
                class="fa-solid fa-plus"></i>
            User</button>
    </x-slot:button>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $item->id }})"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" align="center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</x-page-layout>

@assets
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    </link>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
@endassets
