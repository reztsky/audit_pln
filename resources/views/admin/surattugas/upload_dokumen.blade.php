<dialog id="uploadDokumenMeeting" class="modal md:modal-middle modal-bottom ">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold mb-5">Upload Dokumen</h3>
        <form action="{{ route('dokumenMeeting.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col flex-wrap gap-y-5">
                <input type="hidden" name="id_surat_tugas" id="id_surat_tugas">
                <fieldset class="fieldset">
                    <label for="jenis_dokumen" class="label">Jenis Dokumen</label>
                    <input type="text" class="validation input w-full" required readonly id="jenis_dokumen" name="jenis_dokumen">

                    <label for="dokumen" class="label">Dokumen Pendukung</label>
                    <input type="file" name="dokumen" class="file-input w-full validation" required id="dokumen" accept=".pdf">
                    <ul class="label block">
                        <li>Ukuran File Maks. 2MB</li>
                        <li>Format file harus .pdf</li>
                    </ul>
                </fieldset>
            </div>
            <button type="submit" class="btn btn-accent btn-sm mt-3 w-full">Upload</button>
        </form>
    </div>
</dialog>

@push('script')
    <script>
        $('.btn-upload').on('click',function(){
            var jenis_dokumen=$(this).data('jenisdokumen');
            var id_surat_tugas=$(this).data('id');

            $('#id_surat_tugas').val(id_surat_tugas)
            $('#jenis_dokumen').val(jenis_dokumen)
        })
    </script>
@endpush
