@push('style')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        /* Gaya dropdown secara umum */
        .ts-dropdown,
        .ts-dropdown .dropdown-content {
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            /* gray-200 */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background-color: white;
            font-size: 14px;
            padding: 0.25rem 0;
        }

        /* Opsi tiap item */
        .ts-dropdown .option {
            padding: 0.5rem 1rem;
            cursor: pointer;
            color: #374151;
            /* gray-700 */
            transition: background-color 0.2s ease;
        }

        .ts-dropdown .option:hover {
            background-color: #eff6ff;
            /* blue-50 */
        }

        .ts-dropdown .option.selected {
            background-color: #dbeafe;
            /* blue-100 */
            color: #1e3a8a;
            /* blue-800 */
        }

        /* Tampilan input utama */
        .ts-control {
            min-height: 42px;
            border: 1px solid #d1d5db;
            /* gray-300 */
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            font-size: 14px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* Tag saat item dipilih */
        .ts-control .item {
            background-color: #dbeafe;
            /* blue-100 */
            color: #1e3a8a;
            /* blue-800 */
            border-radius: 9999px;
            padding: 0.25rem 0.5rem;
            font-size: 13px;
            margin-right: 0.25rem;
            font-weight: 500;
        }

        .ts-control .item .remove {
            margin-left: 0.25rem;
            color: #3b82f6;
            /* blue-500 */
            font-weight: bold;
            cursor: pointer;
        }

        .ts-control .item .remove:hover {
            color: #ef4444;
            /* red-500 */
        }
    </style>
@endpush
<dialog id="create" class="modal md:modal-middle modal-bottom ">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold mb-5">Tambah</h3>
        <form action="{{ route('user.store') }}" method="post">
            @csrf
            <div class="flex flex-col flex-wrap gap-y-5">
                <label class="floating-label">
                    <span>Pegawai</span>
                    <select name="id_pegawai" id="id_pegawai" class="w-full validator" required>
                        <option value="" selected disabled>Pilih Pegawai</option>
                        @forelse ($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}">{{ $pegawai->nama }} / {{ $pegawai->jabatan }}</option>
                        @empty
                        @endforelse
                    </select>
                </label>
                <label class="floating-label">
                    <span>Username</span>
                    <input type="text" placeholder="Username" required class="input input-md w-full validator"
                        name="username" />
                </label>
                <label class="floating-label">
                    <span>Password</span>
                    <input type="password" placeholder="Password" required class="input input-md w-full validator"
                        name="password" />
                </label>
                <label class="floating-label ">
                    <span>Role</span>
                    <select class="select w-full validator" required name="role">
                        <option value="" selected disabled>Pilih Role</option>
                        @forelse ($roles as $role)
                            @continue($role->name == 'Super Admin')
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </label>
            </div>
            <button type="submit" class="btn btn-accent btn-sm mt-3 w-full">Simpan</button>
        </form>
    </div>
</dialog>
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect('#id_pegawai', {
            plugins: ['remove_button'],
            persist: false,
            create: false,
            placeholder: "Ketik untuk mencari pegawai...",
        })

        $('.btn-tambah-tim').on('click', function() {
            var id = $(this).data('id')
            $('#storeTim').find('input[name="id_pka"]').val(id)
        })
    </script>
@endpush
