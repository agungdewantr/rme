<x-slot:title>
    Detail Role
</x-slot:title>

<x-page-layout>
    <x-slot:breadcrumbs>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('role.index') }}" wire:navigate>Role</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Role</li>
    </x-slot:breadcrumbs>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" align="center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{$users->links()}}
        </div>
    </div>
</x-page-layout>