<dialog class="modal" id="showKertasKerja">
    <div class="modal-box  md:modal-middle modal-bottom overflow-visible max-w-3xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold mb-5 w-full text-left">Kertas Kerja <span id="judul-audit"></span></h3>
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 w-full">
            <table class="table" id="table-kertas-kerja">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Kontrol</th>
                        <th>Unit/Bidang</th>
                        <th>Tanggal</th>
                        <th>Temuan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="hidden" id="kertas-kerja-skeleton">
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
                        <td>
                            <div class="skeleton h-4 w-auto"></div>
                        </td>
                    </tr>
                </tbody>
                <tbody id="kertas-kerja-tbody" class="hidden">

                </tbody>    
            </table>
        </div>
    </div>
</dialog>
@push('script')
    <script>
        function setTbodyKertasKerja(data) {
            var tbody = ``
            data.forEach(row => {
                var url = "{{ route('kertasKerja.detail', ':id') }}"
                url = url.replace(':id', row.id)
                tbody += `<tr>
                        <td>${row.kontrol}</td>
                        <td>${row.unit} / ${row.bidang}</td>
                        <td>${row.tanggal_formatted}</td>
                        <td>
                            <p class="line-clamp-2">${row.temuan}</p>
                        </td>
                        <td>
                            <div class="space-y-2">
                            <a class="btn btn-accent btn-xs" href="${url}">Detail</a>
                            <button class="btn btn-error btn-xs btn-delete-kertas-kerja">Hapus</button>
                            </div>
                        </td>
                    </tr>`
            });
            return tbody
        }

        $('.btn-show-kertas-kerja').on('click', function() {
            var id_pka = $(this).data('id')
            var url = "{{ route('kertasKerja.show', ':idpka') }}"
            url = url.replace(':idpka', id_pka)

            $.ajax({
                url: url,
                beforeSend: function() {
                    $('#kertas-kerja-skeleton').show()
                    $('#kertas-kerja-tbody').hide()
                },
                success: function(resp) {
                    var data = resp.data
                    $('#kertas-kerja-skeleton').hide()
                    $('#kertas-kerja-tbody').html(setTbodyKertasKerja(data)).show()
                }
            })
        })
    </script>
@endpush
