@extends('admin.layout')
@section('title', 'Create Kertas Kerja')
@section('kertaskerja-active', 'menu-active')
@section('content')
    @if ($errors->any())
        <div class="alert alert-error my-5">
            <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card w-full bg-base-100 shadow-sm">
        <div class="card-body">
            <h2 class="text-xl font-bold">{{ $pka->suratTugas->judul_audit }}</h2>
            <form action="{{ route('kertasKerja.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_pka" value="{{ $pka->id }}">
                <div class="flex flex-row flex-wrap">
                    <div class="md:w-6/12 w-12/12">
                        <div class="flex flex-row flex-wrap gap-y-5 p-5">
                            <div class="md:w-2/12 w-12/12">
                                <label for="kontrol" class="font-semibold">Kontrol</label>
                            </div>
                            <div class="md:w-10/12 w-12/12">
                                <input type="text" id="kontrol" name="kontrol"
                                    class="input input-ghost w-full input-xs border-b-2 border-b-gray-500" placeholder="Kontrol">
                            </div>
                            <div class="md:w-2/12 w-12/12">
                                <label for="unit" class="font-semibold">Unit</label>
                            </div>
                            <div class="md:w-10/12 w-12/12">
                                <input type="text" id="unit" name="unit"
                                    class="input input-ghost w-full input-xs  border-b-2 border-b-gray-500" placeholder="Unit">
                            </div>
                            <div class="md:w-2/12 w-12/12">
                                <label for="bidang" class="font-semibold">Bidang</label>
                            </div>
                            <div class="md:w-10/12 w-12/12">
                                <input type="text" id="bidang" name="bidang"
                                    class="input input-ghost w-full input-xs border-b-2 border-b-gray-500" placeholder="Bidang">
                            </div>
                            <div class="md:w-2/12 w-12/12">
                                <label for="tanggal" class="font-semibold">tanggal</label>
                            </div>
                            <div class="md:w-10/12 w-12/12">
                                <input type="date" id="tanggal" name="tanggal"
                                    class="input input-ghost w-full input-xs  border-b-2 border-b-gray-500" placeholder="tanggal">
                            </div>
                            <div class="w-12/12">
                                <p class="font-semibold mb-2 p-0">Temuan</p>
                                <textarea name="temuan" id="" class="textarea w-full h-[150px]" placeholder="Kontent Kerja"></textarea>
                            </div>
                            <div class="w-12/12">
                                <p class="font-semibold mb-2 p-0">Opportunity for Improvement (OFI)</p>
                                <textarea name="ofi" id="" class="textarea w-full h-[150px]" placeholder="Kontent Kerja"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-6/12 w-12/12 p-5 space-y-3">
                        <div>
                            <p class="font-semibold mb-2 p-0">Keterangan Tambahan</p>
                            <textarea name="keterangan_tambahan" id="" class="textarea w-full h-[150px]" placeholder="Kontent Kerja"></textarea>
                        </div>
                        <div>
                            <fieldset class="fieldset">
                                <legend class="fieldset-legend text-sm">Dokumen Dukung</legend>
                                <input type="file" class="file-input w-full" name="dokumen_dukung" />
                                <label class="label">Max size 10MB</label>
                                <label class="label">File berupa .pdf,.doc,.docx</label>
                                <label class="label">Tidak Wajib Diisi</label>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end px-5">
                    <button class="btn btn-accent btn-sm">Tambah</button>
                </div>
            </form>
        </div>
    </div>
@endsection
