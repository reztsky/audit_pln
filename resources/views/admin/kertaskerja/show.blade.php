<dialog class="modal" id="showKertasKerja">
    <div class="modal-box  md:modal-middle modal-bottom overflow-visible max-w-3xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold mb-5 w-full text-left">Kertas Kerja <span id="judul-audit"></span></h3>
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 w-full">
            <form action="{{ route('lha.store') }}" method="post">
                @csrf
                <table class="table" id="table-kertas-kerja">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th></th>
                            <th>Kontrol</th>
                            <th>Kategori Temuan</th>
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
                            <td>
                                <div class="skeleton h-4 w-auto"></div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody id="kertas-kerja-tbody" class="hidden">

                    </tbody>
                </table>
                <div class="flex justify-center space-y-3">
                    <div class="md:mr-3">
                        <a class="btn btn-sm btn-accent" id="btn-create"
                            href="{{ route('kertasKerja.create', $pka->id) }}">
                            <x-heroicon-o-folder-plus class="w-5 h-5" />
                            Tambah Kertas Kerja
                        </a>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-primary hidden submit-lha" type="submit">Submit Ke
                            Atasan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</dialog>
@push('script')
    <script>
        function setTbodyKertasKerja(data) {
            var tbody = ``
            if (data.length < 1) return tbody = `<tr><td colspan="9" class="text-center">No Found Record</td></tr>`;
            data.forEach(row => {
                var url = "{{ route('kertasKerja.detail', ':id') }}"
                var url_edit="{{route('kertasKerja.edit',':id')}}"
                url_edit=url_edit.replace(':id',row.id)
                url = url.replace(':id', row.id)
                tbody += `<tr>
                        <td>
                            <input type="checkbox" ${row.id_lha ? 'checked' : ''} name="id_kertas_kerja[]" id="id-kertas-kerja-${row.id}" class="checkbox-lha cursor-pointer" value="${row.id}">
                        </td>
                        <td>${row.kontrol}</td>
                        <td>${row.kategori_temuan}</td>
                        <td>${row.tanggal_formatted}</td>
                        <td>
                            <p class="line-clamp-4">${row.temuan}</p>
                        </td>
                        <td>
                            <div class="space-y-2">
                            <a class="btn btn-accent btn-xs mb-0" href="${url}">Detail</a>
                            <a class="btn btn-danger btn-xs mb-0" href="${url_edit}">Edit</a>
                            <button class="btn btn-error btn-xs btn-delete-kertas-kerja">Hapus</button>
                            </div>
                        </td>
                    </tr>`
            });
            return tbody
        }


        $('#table-kertas-kerja').on('click', '.checkbox-lha', function() {
            if ($('.checkbox-lha:checked').length > 0) {
                $('.submit-lha').show()
            } else {
                $('.submit-lha').hide()
            }
        })

        $('.btn-show-kertas-kerja').on('click', function() {
            var id_pka = $(this).data('id')

            var url_btn_create = "{{ route('kertasKerja.create', ':idpka') }}"
            url_btn_create = url_btn_create.replace(':idpka', id_pka)
            $('#btn-create').attr('href', url_btn_create)

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
