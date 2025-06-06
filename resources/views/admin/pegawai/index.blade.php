@extends('admin.layout')
@section('title', 'Pegawai')
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
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawais as $pegawai)
                    <tr>
                        <td>{{ $pegawais->firstItem() + $loop->index }}</td>
                        <td>{{ $pegawai->nip }}</td>
                        <td>{{ $pegawai->nama }}</td>
                        <td>{{ $pegawai->jabatan }}</td>
                        <td>
                            <button class="btn btn-error btn-delete text-white btn-xs" data-id="{{ $pegawai->id }}"
                                onclick="form_delete.showModal()">
                                <x-heroicon-o-trash class="w-4 h-4" />
                            </button>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        <div class="my-4 px-3">
            {{ $pegawais->links() }}
        </div>
    </div>
    <dialog id="create" class="modal md:modal-middle modal-top ">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold mb-5">Tambah</h3>
            <form action="{{ route('pegawai.store') }}" method="post">
                @csrf
                <div class="flex flex-col flex-wrap gap-y-5">
                    <label class="floating-label">
                        <span>Nama</span>
                        <input type="text" placeholder="Nama" required name="nama"
                            class="input input-md w-full validator" />
                    </label>
                    <label class="floating-label v">
                        <span>NIP</span>
                        <input type="text" placeholder="NIP" required class="input input-md w-full validator"
                            name="nip" />
                    </label>
                    <label class="floating-label ">
                        <span>Jabatan</span>
                        <select class="select w-full validator" required name="jabatan">
                            <option value="" selected>Pilih Jabatan</option>
                            @forelse ($jabatans as $jabatan)
                                <option value="{{ $jabatan->nama_jabatan }}">{{ $jabatan->nama_jabatan }}</option>
                            @empty
                            @endforelse
                        </select>
                    </label>
                </div>
                <button type="submit" class="btn btn-accent btn-sm mt-3 w-full">Simpan</button>
            </form>
        </div>
    </dialog>

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
            var url = "{{ route('pegawai.delete', ':id') }}"
            url = url.replace(':id', id);
            $('#form-delete').attr('action', url)
        })
    </script>
@endpush
