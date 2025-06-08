<dialog class="modal" id="daftarHadirCreate">
    <div class="modal-box md:modal-middle modal-bottom overflow-visible">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold mb-5 w-full text-left">Upload Daftar Hadir</h3>
        <form action="{{ route('daftarHadir.store') }}" method="post" enctype="multipart/form-data" class="w-full">
            @csrf
            <div class="space-y-5">
                <input type="hidden" value="" name="id_pka">
                <input type="hidden" value="{{ auth()->user()->id }}" name="inserted_by">
                <label for="" class="floating-label">
                    <span>Tanggal Meeting</span>
                    <input type="date" class="input input-md w-full validator" placeholder="Tanggal Meeting"
                        name="tanggal_meeting" required>
                </label>
                <label for="" class="floating-label">
                    <span>Lokasi Meeting</span>
                    <input type="text" class="input input-md w-full validator" placeholder="Lokasi Meeting"
                        name="lokasi_meeting" required>
                </label>
                <label class="floating-label">
                    <span>Daftar Hadir</span>
                    <input type="file" class="file-input input-md w-full validator" name="daftar_hadir"
                        accept="application/pdf" required>
                    <ul class="flex flex-col mt-1">
                        <li class="label text-xs">Maks. File 2Mb</li>
                        <li class="label text-xs">Format File .pdf</li>
                    </ul>
                </label>
                <button type="submit" class="btn btn-accent btn-sm w-full">Upload</button>
            </div>
        </form>
    </div>
</dialog>
@push('script')
    <script>
        $('.btn-daftar-hadir').on('click', function() {
            var id_pka = $(this).data('id')
            $('#daftarHadirCreate').find('input[name="id_pka"]').val(id_pka)
        })
    </script>
@endpush
