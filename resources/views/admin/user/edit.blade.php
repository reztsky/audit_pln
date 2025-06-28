<dialog id="edit" class="modal md:modal-middle modal-bottom ">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold mb-5">Edit</h3>
        <div class="animate-pulse hidden" id="skeleton-edit">
            <div class="flex flex-col  gap-y-5">
                <div class="bg-gray-300 h-7 rounded w-full"></div>
                <div class="bg-gray-300 h-7 rounded w-full"></div>
                <div class="bg-gray-300 h-7 rounded w-full"></div>
                <div class="bg-gray-300 h-7 rounded w-full"></div>
                <div class="bg-gray-300 h-7 rounded w-full"></div>
            </div>
        </div>
        <form action="" method="post" id="form-update" class="hidden">
            @csrf
            <div class="flex flex-col flex-wrap gap-y-5">
                <label class="floating-label">
                    <span>Pegawai</span>
                    <select name="id_pegawai" id="id_pegawai_edit" class="w-full validator" required>
                        <option value="" selected disabled>Pilih Pegawai</option>
                        @forelse ($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}">{{ $pegawai->nama }} / {{ $pegawai->jabatan }}</option>
                        @empty
                        @endforelse
                    </select>
                </label>
                <label class="floating-label ">
                    <span>Role</span>
                    <select class="select w-full validator" id="role_edit" required name="role">
                        <option value="" selected disabled>Pilih Role</option>
                        @forelse ($roles as $role)
                            @continue($role->name == 'Super Admin')
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </label>
                <label class="floating-label">
                    <span>Username</span>
                    <input type="text" placeholder="Username" id="username_edit" required
                        class="input input-md w-full validator" name="username" />
                </label>
                <label class="floating-label">
                    <span>Password</span>
                    <input type="password" placeholder="Password" class="input input-md w-full validator"
                        name="password" />
                    <p class="text-xs text-gray-400">Jika Tidak Ingin Mengubah Password Harap Dikosongkan</p>
                </label>

            </div>
            <button type="submit" class="btn btn-accent btn-sm mt-3 w-full">Update</button>
        </form>
    </div>
</dialog>
@push('script')
    <script>
        const id_pegawai_edit = new TomSelect('#id_pegawai_edit', {
            plugins: ['remove_button'],
            persist: false,
            create: false,
            placeholder: "Ketik untuk mencari pegawai...",
        })
        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            var url = "{{ route('user.edit', ':id') }}"
            var url_form = "{{ route('user.update', ':id') }}"
            url = url.replace(':id', id)
            url_form = url_form.replace(':id', id)

            $.ajax({
                url: url,
                beforeSend: function() {
                    $('#skeleton-edit').show()
                    $('#form-update').hide()
                },
                success: function(resp) {
                    var data = resp.data
                    id_pegawai_edit.setValue(data.has_pegawai?.pegawai.id)
                    // $('#id_pegawai_edit').val().trigger('change')
                    $('#role_edit').val(data.roles[0].name)
                    $('#username_edit').val(data.username)
                    $('#form-update').attr('action', url_form)
                    $('#skeleton-edit').hide()
                    $('#form-update').show()
                }
            })
        })
    </script>
@endpush
