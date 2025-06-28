<dialog id="show" class="modal md:modal-middle modal-bottom ">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold mb-5">Detail</h3>

        <div class="overflow-x-auto animate-pulse hidden" id="detail-skeleton">
            <table class="table w-full">
                <tbody>
                    <tr>
                        <th class="w-32">NIP</th>
                        <td>
                            <div class="h-4 bg-gray-300 rounded w-40"></div>
                        </td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <div class="h-4 bg-gray-300 rounded w-32"></div>
                        </td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>
                            <div class="h-4 bg-gray-300 rounded w-48"></div>
                        </td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>
                            <div class="h-4 bg-gray-300 rounded w-44"></div>
                        </td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>
                            <div class="h-4 bg-gray-300 rounded w-36"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="overflow-x-auto hidden" id="detail-table">
            <table class="table w-full">
                <tbody>
                    <tr>
                        <th>NIP</th>
                        <td id="detail-nip"></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td id="detail-role"></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td id="detail-nama"></td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td id="detail-jabatan"></td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td id="detail-username"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</dialog>
@push('script')
    <script>
        $('.btn-detail').on('click', function() {
            var id = $(this).data('id')
            var url = "{{ route('user.detail', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                beforeSend:function(){
                    $('#detail-skeleton').show()
                    $('#detail-table').hide()
                },
                success: function(resp) {
                    var data = resp.data
                    $('#detail-nip').html(data.has_pegawai?.pegawai?.nip ?? '-')
                    $('#detail-role').html(data.roles[0].name)
                    $('#detail-nama').html(data.name)
                    $('#detail-jabatan').html(data.has_pegawai?.pegawai?.jabatan ?? '-')
                    $('#detail-username').html(data.username)
                    $('#detail-skeleton').hide()
                    $('#detail-table').show()
                }
            })
        })
    </script>
@endpush
