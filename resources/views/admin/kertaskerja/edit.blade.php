@extends('admin.layout')
@section('title', 'Edit Kertas Kerja')
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
            <h2 class="text-xl font-bold">{{ $kertas_kerja->pka->suratTugas->judul_audit }}</h2>
            <form action="{{ route('kertasKerja.update',$kertas_kerja->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_pka" value="{{ $kertas_kerja->id_pka }}">
                <div class="flex flex-row flex-wrap">
                    <div class="md:w-6/12 w-12/12">
                        <div class="flex flex-row flex-wrap gap-y-5 p-5">
                            <div class="md:w-2/12 w-12/12">
                                <label for="kontrol" class="font-semibold">Kontrol</label>
                            </div>
                            <div class="md:w-10/12 w-12/12">
                                <input type="text" id="kontrol" name="kontrol"
                                    class="input input-ghost w-full input-xs border-b-2 border-b-gray-500"
                                    placeholder="Kontrol" value="{{$kertas_kerja->kontrol}}">
                            </div>
                            <div class="md:w-2/12 w-12/12">
                                <label for="tanggal" class="font-semibold">Tanggal</label>
                            </div>

                            <div class="md:w-10/12 w-12/12">
                                <input type="date" id="tanggal" name="tanggal"
                                    class="input input-ghost w-full input-xs 1 border-b-2 border-b-gray-500"
                                    value="{{$kertas_kerja->tanggal->format('Y-m-d') }}">
                            </div>
                            <div class="md:w-2/12 w-12/12">
                                <label for="tanggal" class="font-semibold">Kategori Temuan</label>
                            </div>
                            <div class="md:w-10/12 w-12/12">
                                <select name="kategori_temuan" id="" class="select w-full select-sm">
                                    <option disabled selected>Kategori Temuan</option>
                                    <option value="Major" @selected($kertas_kerja->kategori_temuan=='Major')>Major</option>
                                    <option value="Minor" @selected($kertas_kerja->kategori_temuan=='Minor')>Minor</option>
                                    <option value="Ofi" @selected($kertas_kerja->kategori_temuan=='Ofi')>OFI</option>
                                    <option value="Sesuai" @selected($kertas_kerja->kategori_temuan=='Sesuai')>Sesuai</option>
                                </select>
                            </div>
                            <div class="w-12/12">
                                <p class="font-semibold mb-2 p-0">Temuan</p>
                                <textarea name="temuan" id="" class="textarea w-full h-[150px]" placeholder="Kontent Kerja">{{$kertas_kerja->temuan}}</textarea>
                            </div>
                            <div class="w-12/12">
                                <p class="font-semibold mb-2 p-0">Opportunity for Improvement (OFI)</p>
                                <textarea name="ofi" id="" class="textarea w-full h-[150px]" placeholder="Kontent Kerja">{{$kertas_kerja->ofi}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-6/12 w-12/12 p-5 space-y-3">
                        <div>
                            <p class="font-semibold mb-2 p-0">Keterangan Tambahan</p>
                            <textarea name="keterangan_tambahan" id="" class="textarea w-full h-[150px]" placeholder="Kontent Kerja">{{$kertas_kerja->keterangan_tambahan}}</textarea>
                        </div>
                        <div>
                            <fieldset class="fieldset">
                                <legend class="fieldset-legend text-sm">Dokumen Dukung</legend>
                                <input type="file" class="file-input w-full" name="dokumen_dukung" />
                                <label class="label">Max size 10MB</label>
                                <label class="label">File berupa .pdf,.doc,.docx</label>
                                <label class="label">Tidak Wajib Diisi</label>
                            </fieldset>
                            <a href="{{asset('storage/kertas_kerja/'.$kertas_kerja->dokumen_dukung)}}"></a>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end px-5">
                    <button class="btn btn-accent btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
