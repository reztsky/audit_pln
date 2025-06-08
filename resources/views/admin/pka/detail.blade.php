<dialog id="detail" class="modal">
    <div class="modal-box md:modal-middle modal-bottom max-w-4xl w-full">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>

        <div id="detail-skeleton" class="w-full animate-pulse hidden">
            <div class="text-center mb-6">
                <div class="h-8 bg-gray-300 rounded w-1/3 mx-auto mb-2"></div>
                <div class="h-1 bg-gray-200 rounded w-24 mx-auto"></div>
            </div>

            <ul class="space-y-4">
                @for ($i = 0; $i < 6; $i++)
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

        <div id="content-detail" class="hidden">
            <div class="text-center mb-6 px-2">
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

            <ul class="w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
                <li class="p-4 bg-white hover:bg-gray-50 transition">
                    <h4 class="text-lg font-semibold text-gray-800 mb-1">📌 Landasan Audit</h4>
                    <p class="text-sm text-gray-600 leading-relaxed" id="text-landasan-audit">-</p>
                </li>
                <li class="p-4 bg-white hover:bg-gray-50 transition">
                    <h4 class="text-lg font-semibold text-gray-800 mb-1">🎯 Tujuan Audit</h4>
                    <p class="text-sm text-gray-600 leading-relaxed" id="text-tujuan-audit">-</p>
                </li>
                <li class="p-4 bg-white hover:bg-gray-50 transition">
                    <h4 class="text-lg font-semibold text-gray-800 mb-1">🎯 Sasaran Audit</h4>
                    <p class="text-sm text-gray-600 leading-relaxed" id="text-sasaran-audit">-</p>
                </li>
                <li class="p-4 bg-white hover:bg-gray-50 transition">
                    <h4 class="text-lg font-semibold text-gray-800 mb-1">📍 Lingkup Audit</h4>
                    <p class="text-sm text-gray-600 leading-relaxed" id="text-lingkup-audit">-</p>
                </li>
                <li class="p-4 bg-white hover:bg-gray-50 transition">
                    <h4 class="text-lg font-semibold text-gray-800 mb-1">📝 Gambaran Audit</h4>
                    <p class="text-sm text-gray-600 leading-relaxed" id="text-gambaran-audit">-</p>
                </li>
                <li class="p-4 bg-white hover:bg-gray-50 transition">
                    <h4 class="text-lg font-semibold text-gray-800 mb-1">📂 Data Awal Audit</h4>
                    <p class="text-sm text-gray-600 leading-relaxed" id="text-data-awal">-</p>
                </li>
            </ul>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
@push('script')
    <script>
         function setDetail(data) {
            $('#title-judul-audit').html(data.surat_tugas.judul_audit)
            $('#title-lokasi-audit').html(data.surat_tugas.lokasi_audit)
            $('#text-landasan-audit').html(data.landasan_audit)
            $('#text-tujuan-audit').html(data.tujuan_audit)
            $('#text-sasaran-audit').html(data.sasaran_audit)
            $('#text-lingkup-audit').html(data.lingkup_audit)
            $('#text-gambaran-audit').html(data.gambaran_audit)
            $('#text-data-awal').html(data.data_awal)
        }
        $('.btn-detail-pka').on('click', function() {
            var id = $(this).data('id')
            var url = "{{ route('pka.detail', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                beforeSend: function() {
                    $('#content-detail').hide();
                    $("#detail-skeleton").show();
                },
                success: function(resp) {
                    data = resp.data
                    setDetail(data)
                    $('#detail-skeleton').hide();
                    $('#content-detail').show();
                }
            })
        })
    </script>
@endpush
