<dialog class="modal" id="daftarHadirShow">
    <div class="modal-box md:modal-middle modal-bottom overflow-visible max-w-2xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold mb-5 w-full text-left">Daftar Hadir</h3>
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 w-full">
            <table class="table" id="table-daftar-hadir">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Tanggal Meeting</th>
                        <th>Lokasi Meeting</th>
                        <th>Daftar Hadir</th>
                    </tr>
                </thead>
                <tbody class="hidden" id="daftar-hadir-skeleton">
                    <tr>
                        <td>
                            <div class="skeleton h-4 w-auto"></div>
                        </td>
                        <td>
                            <div class="skeleton h-4 w-auto"></div>
                        </td>
                        <td>
                            <div class="skeleton h-4 w-auto"></div>
                        </td>
                    </tr>
                </tbody>
                <tbody id="daftar-hadir-tbody" class="hidden">

                </tbody>
            </table>
        </div>
    </div>
</dialog>
@push('script')
    <script>
        function setTbodyDaftarHadir(data) {
            var tbody = ``
            data.forEach(row => {
                tbody += `<tr>
                        <td>${row.tanggal_formatted}</td>
                        <td>${row.lokasi_meeting}</td>
                        <td>
                            <a href="{{ asset('storage/daftar_hadir') }}/${row.daftar_hadir}" target="_blank" class="link">Document</a>
                        </td>
                    </tr>`
            });
            return tbody
        }


        $('.btn-daftar-hadir-show').on('click', function() {
            var id = $(this).data('id')
            var url = "{{ route('daftarHadir.daftarHadirPka', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                beforeSend: function() {
                    $('#daftar-hadir-skeleton').show()
                    $('#daftar-hadir-tbody').hide()
                },
                success: function(resp) {
                    var data = resp.data
                    $('#daftar-hadir-skeleton').hide()
                    $('#daftar-hadir-tbody').html(setTbodyDaftarHadir(data)).show()
                }
            })
        })
    </script>
@endpush
