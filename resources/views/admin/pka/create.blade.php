<dialog id="create" class="modal">
    <div class="modal-box md:modal-middle modal-bottom max-w-7xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold mb-5 w-full text-left">Tambah</h3>
        <form action="{{ route('pka.store') }}" method="post" enctype="multipart/form-data" class="w-full">
            @csrf
            <div class="flex flex-row flex-wrap">
                <div class="md:w-6/12 w-12/12 p-5 flex flex-col gap-y-5">
                    <label class="floating-label ">
                        <span>Audit</span>
                        <select name="id_surat_tugas" id="" required class="select w-full validator">
                            <option value="" disabled selected>Pilih Tugas</option>
                            @foreach ($surattugass as $surattugas)
                                <option value="{{ $surattugas->id }}">{{ $surattugas->judul_audit }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="floating-label">
                        <span>Landasan Audit</span>
                        <textarea name="landasan_audit" class="textarea input-md w-full validator" required placeholder="Landasan Audit"></textarea>
                    </label>
                    <label class="floating-label">
                        <span>Tujuan Audit</span>
                        <textarea name="tujuan_audit" class="textarea input-md w-full validator" required placeholder="Tujuan Audit"></textarea>
                    </label>
                    <label class="floating-label">
                        <span>Sasaran Audit</span>
                        <textarea name="sasaran_audit" class="textarea input-md w-full validator" required placeholder="Sasaran Audit"></textarea>
                    </label>
                </div>
                <div class="md:w-6/12 w-12/12 p-5 flex flex-col gap-y-5">
                    <label class="floating-label">
                        <span>Lingkup Audit</span>
                        <textarea name="lingkup_audit" class="textarea input-md w-full validator" required placeholder="Lingkup Audit"></textarea>
                    </label>
                    <label class="floating-label">
                        <span>Gambaran Audit</span>
                        <textarea name="gambaran_audit" class="textarea input-md w-full validator" required placeholder="Gambaran Audit"></textarea>
                    </label>
                    <label class="floating-label">
                        <span>Data Dukung Audit</span>
                        <textarea name="data_awal" class="textarea input-md w-full validator" required placeholder="Data Dukung Audit"></textarea>
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-accent btn-sm mt-3 w-full">Simpan</button>
        </form>
    </div>
</dialog>
