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
<dialog id="storeTim" class="modal">
    <div class="modal-box md:modal-middle modal-bottom overflow-visible">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold mb-5 w-full text-left">Tambah Tim Audit</h3>
        <form action="{{ route('timAudit.store') }}" method="post" enctype="multipart/form-data" class="w-full">
            @csrf
            <input type="hidden" value="" name="id_pka">
            <div>
                <label for="tim-audit" class="block text-sm font-medium text-gray-700 mb-1">Pilih Tim Audit</label>
                <select name="tim_audit[]" id="tim-audit" multiple required
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 shadow-sm text-sm">
                    @foreach ($pegawais as $pegawai)
                        <option value="{{ $pegawai->id }}">
                            {{ $pegawai->nama }} / {{ $pegawai->jabatan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-accent btn-sm mt-3 w-full">Simpan</button>
        </form>
    </div>
</dialog>
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect('#tim-audit', {
            plugins: ['remove_button'],
            persist: false,
            create: false,
            placeholder: "Ketik untuk mencari dan pegawai...",
        })

        $('.btn-tambah-tim').on('click',function(){
            var id=$(this).data('id')
            $('#storeTim').find('input[name="id_pka"]').val(id)
        })
    </script>
@endpush
