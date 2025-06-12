<div class="drawer drawer-end">
    <input id="detail-drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-side">
        <label for="detail-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
        <div id="detail-skeleton" class="md:w-[40vw] animate-pulse hidden min-h-full bg-white px-5">
            <div class="text-center mb-6 mt-7">
                <div class="h-8 bg-gray-300 rounded w-1/3 mx-auto mb-2"></div>
                <div class="h-1 bg-gray-200 rounded w-24 mx-auto"></div>
            </div>

            <ul class="space-y-4">
                @for ($i = 0; $i < 5; $i++)
                    <li class="p-4 border border-gray-200 rounded bg-gray-50">
                        <div class="h-5 bg-gray-300 rounded w-1/4 mb-2"></div>
                        <div class="space-y-1">
                            <div class="h-4 bg-gray-200 rounded w-full"></div>
                            <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                        </div>
                    </li>
                @endfor
            </ul>
        </div>

        <div class="min-h-full bg-white">
            <div id="content-detail" class="bg-white hidden min-h-full w-[40vw] px-5 ">
                <div class="text-center mb-6 mt-8 p-2">
                    <h3
                        class="text-lg sm:text-xl md:text-2xl font-extrabold text-primary uppercase tracking-wide inline-flex flex-wrap justify-center items-center gap-2 text-center">
                        <x-heroicon-o-document-magnifying-glass class="w-6 h-6 sm:w-7 sm:h-7 text-primary" />
                        <span class="block">
                            Detail <span id="title-judul-audit" class="break-words inline-block max-w-full"></span> -
                            <span id="title-lokasi-audit" class="break-words inline-block max-w-full"></span>
                        </span>
                    </h3>
                    <div class="w-16 sm:w-20 md:w-24 h-1 bg-primary mx-auto mt-2 rounded-full"></div>
                </div>

                <ul class="w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden px-4">
                    <li class="p-4 bg-white hover:bg-gray-50 transition">
                        <h4 class="text-lg font-semibold text-gray-800 mb-1">Judul LHA</h4>
                        <p class="text-sm text-gray-600 leading-relaxed" id="text-judul-lha">-</p>
                    </li>
                    <li class="p-4 bg-white hover:bg-gray-50 transition">
                        <h4 class="text-lg font-semibold text-gray-800 mb-1">Tanggal Selesai</h4>
                        <p class="text-sm text-gray-600 leading-relaxed" id="text-tanggal-lha">-</p>
                    </li>
                    <li class="p-4 bg-white hover:bg-gray-50 transition">
                        <h4 class="text-lg font-semibold text-gray-800 mb-1">Ringkasan</h4>
                        <p class="text-sm text-gray-600 leading-relaxed" id="text-ringkasan-lha">-</p>
                    </li>
                    <li class="p-4 bg-white hover:bg-gray-50 transition">
                        <h4 class="text-lg font-semibold text-gray-800 mb-1">List Kertas Kerja</h4>
                        <div class="text-sm text-gray-600 leading-relaxed" id="text-list-kertas-kerja">-</div>
                    </li>
                    <li class="p-4 bg-white hover:bg-gray-50 transition">
                        <h4 class="text-lg font-semibold text-gray-800 mb-1">Status</h4>
                        <div class="badge" id="text-status-lha">-</div>
                    </li>
                    <li class="p-4 bg-white hover:bg-gray-50 transition">
                        <h4 class="text-lg font-semibold text-gray-800 mb-1">Histori LHA</h4>
                        <div class="text-sm text-gray-600 leading-relaxed" id="text-catatan-revisi-lha"></div>
                    </li>
                </ul>
                <div class="flex justify-end my-3 space-x-1.5">
                    <div id="container-btn-edit">
                        <a class="btn btn-sm btn-warning" id="btn-edit">Edit</a>
                    </div>
                    <div class="" id="btn-submit-keatasan">
                        <form method="post" id="form-submit-keatasan">
                            @csrf
                            <button class="btn btn-primary btn-sm">Kirim Ke Atasan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        function setBadge(status) {
            var class_status = {
                'draft': 'badge-neutral',
                'diajukan': 'badge-primary',
                'revisi': 'badge-secondary',
                'disetujui': 'badge-accent',
                'ditindaklanjuti': 'badge-info',
                'tindaklanjut_ok': 'badge-success',
                'selesai': 'badge-warning'
            }
            // Hapus class badge-* sebelumnya (opsional)
            $('#text-status-lha').removeClass(function(index, className) {
                return (className.match(/(^|\s)badge-\S+/g) || []).join(' ');
            });

            // Tambahkan class baru dan update text
            $('#text-status-lha')
                .html(status)
                .addClass(class_status[status] || 'badge-neutral');
        }

        function setLogLha(logs) {
            var ul = `<ul class="list-disc ml-6">`
            logs.forEach(row => {
                ul +=
                    `<li>
                        <strong>${row.action}</strong> Oleh ${row.user.name} <span class="text-sm text-gray-500"> ${row.formated_date}</span>
                        <div class="text-sm mt-1">${row.catatan ?? '-'}</div>
                    </li>`
            });
            ul += `</ul>`
            $('#text-catatan-revisi-lha').html(ul)
        }

        function setLhaDetail(data) {
            var ul = `<ul class="list-disc ml-6">`
            data.kertas_kerja.forEach(row => {
                var shortText = row.temuan.slice(0, 50) + " ..."
                var urlkertas_kerja = "{{ route('kertasKerja.detail', ':id') }}"
                urlkertas_kerja = urlkertas_kerja.replace(':id', row.id)
                ul +=
                    `<li>${ row.kontrol } - ${ shortText ?? '-' } <a class="underline text-blue-400 cursor-pointer" href="${urlkertas_kerja}">Read More</a></li>`
            });
            ul += `</ul>`

            $('#title-judul-audit').html(data.pka.surat_tugas.judul_audit)
            $('#title-lokasi-audit').html(data.pka.surat_tugas.lokasi_audit)
            $('#text-judul-lha').html(data.judul)
            $('#text-tanggal-lha').html(data.tanggal)
            $('#text-ringkasan-lha').html(data.ringkasan)
            $('#text-list-kertas-kerja').html(ul)
            setBadge(data.status)
            setLogLha(data.lha_log)


            var url_submit = "{{ route('lha.submitKeAtasan', ':id') }}"
            url_submit = url_submit.replace(':id', data.id)
            $('#form-submit-keatasan').attr('action', url_submit)

            if (data.status == 'draft' || data.status == 'revisi') {
                $('#btn-submit-keatasan').show()
            } else {
                $('#btn-submit-keatasan').hide()
            }

            var url_edit = "{{ route('lha.edit', ':id') }}"
            url_edit = url_edit.replace(':id', data.id)
            $('#btn-edit').attr('href', url_edit)
        }

        $('.btn-lihat-lha').on('click', function() {
            var id = $(this).data('id')
            var url = "{{ route('lha.detail', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                beforeSend: function() {
                    $('#detail-skeleton').show();
                    $('#content-detail').hide();
                },
                success: function(resp) {
                    $('#detail-skeleton').hide();
                    $('#content-detail').show();
                    var data = resp.data
                    setLhaDetail(data)
                }
            })
        })
    </script>
@endpush
