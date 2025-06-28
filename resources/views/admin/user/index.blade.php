@extends('admin.layout')
@section('title', 'User')
@section('user-active', 'menu-active')
@section('content')
    <div class="flex justify-end mb-5">
        <button class="btn btn-sm btn-accent" onclick="create.showModal()">Tambah</button>
    </div>
    @if ($errors->any())
        <div class="alert alert-error my-5">
            <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>Role</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $users->currentPage() + $loop->index }}</td>
                        <td>{{ $user->roles->first()->name }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td class="">
                            <div class="flex flex-row flex-wrap md:space-x-2 md:space-y-0 sm:space-x-2 sm:space-y-2 space-x-0 space-y-2">
                                <button class="btn btn-xs btn-detail btn-neutral" data-id="{{ $user->id }}"
                                    onclick="show.showModal()"><x-heroicon-o-list-bullet class="h-5 w-5" /></button>
                                <button class="btn btn-xs btn-edit btn-warning" onclick="edit.showModal()" data-id="{{ $user->id }}"><x-heroicon-o-pencil-square class="h-5 w-5"/></button>
                                <button class="btn btn-xs btn-delete btn-error text-white" data-id="{{ $user->id }}"
                                    onclick="form_delete.showModal()"><x-heroicon-o-trash class="w-5 h-5" /></button>
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        <div class="my-4 px-3">
            {{ $users->links() }}
        </div>
    </div>

    @include('admin.user.create')
    @include('admin.user.show')
    @include('admin.user.edit')

    <dialog id="form_delete" class="modal modal-middle">
        <div class="modal-box">
            <p class="text-center">Apakah Yakin Ingin Menghapus Data ?</p>
            <div class="flex flex-row justify-center gap-x-4 mt-4">
                <form method="dialog">
                    <button class="btn btn-ghost btn-sm">Cancel</button>
                </form>
                <form method="post" id="form-delete">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-error btn-sm">Hapus</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
@endsection
@push('script')
    <script>
        $('.btn-delete').on('click', function() {
            var id = $(this).data('id')
            var url = "{{ route('user.delete', ':id') }}"
            url = url.replace(':id', id);
            $('#form-delete').attr('action', url)
        })
    </script>
@endpush
