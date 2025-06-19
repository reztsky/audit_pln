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
            <div id="content-detail" class="bg-white  min-h-full md:w-[40vw] w-full px-5 ">
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

    </script>
@endpush
