@extends('admin.layout')
@push('style')
@endpush
@section('title', 'Tindak Lanjut')
@section('tindaklanjut-active', 'menu-active')
@section('content')

    @php
        $is_ada_tindak_lanjut=$kertas_kerjas->first()?->lha->tindakLanjutLha?->count() > 0;
        $id_tindak_lanjut=$kertas_kerjas->first()?->lha->tindakLanjutLha?->id;
    @endphp

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
    <div class="card">
        <div class="card-body shadow">
            <div class="flex flex-row flex-wrap">
                <div class="w-5/12">
                    @forelse ($kertas_kerjas as $kertas_kerja)
                        <div class="p-4">
                            <div class="space-y-4">
                                {{-- PKA --}}
                                <div>
                                    <span class="text-sm text-gray-500">Audit Terkait</span>
                                    <p class="">
                                        <span class="font-semibold">
                                            {{ $kertas_kerja->pka->suratTugas->judul_audit ?? '-' }}</span> - <span
                                            class="">{{ $kertas_kerja->pka->suratTugas->lokasi_audit ?? '-' }}</span>
                                    </p>
                                    <p>{{ $kertas_kerja->pka->suratTugas->tanggal_audit->translatedFormat('d F Y') ?? '-' }}
                                    </p>
                                </div>
                                {{-- Kontrol --}}
                                <div>
                                    <span class="text-sm text-gray-500">Kontrol / Prosedur</span>
                                    <p>{{ $kertas_kerja->kontrol }}</p>
                                </div>
                                {{-- Tanggal --}}
                                <div>
                                    <span class="text-sm text-gray-500">Tanggal</span>
                                    <p>{{ \Carbon\Carbon::parse($kertas_kerja->tanggal)->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Ketegori Temuan</span>
                                    <p>{{ $kertas_kerja->kategori_temuan }}</p>
                                </div>
                                {{-- Temuan --}}
                                <div>
                                    <span class="text-sm text-gray-500">Temuan</span>
                                    <p>{{ $kertas_kerja->temuan }}</p>
                                </div>
                                {{-- OFI --}}
                                <div>
                                    <span class="text-sm text-gray-500">Opportunity for Improvement (OFI)</span>
                                    <p>{{ $kertas_kerja->ofi }}</p>
                                </div>
                                {{-- Keterangan Tambahan --}}
                                <div>
                                    <span class="text-sm text-gray-500">Keterangan Tambahan</span>
                                    <p>{{ $kertas_kerja->keterangan_tambahan }}</p>
                                </div>

                                {{-- Dokumen Dukung --}}
                                <div>
                                    <span class="text-sm text-gray-500">Dokumen Pendukung</span>
                                    @if ($kertas_kerja->dokumen_dukung)
                                        <a href="{{ asset('storage/kertas_kerja/' . $kertas_kerja->dokumen_dukung) }}"
                                            target="_blank" class="btn btn-sm btn-outline btn-info">
                                            Lihat Dokumen
                                        </a>
                                    @else
                                        <p class="text-gray-400">Tidak ada dokumen</p>
                                    @endif
                                </div>
                                {{-- Inserted By --}}
                                <div>
                                    <span class="text-sm text-gray-500">Dibuat oleh</span>
                                    <p>{{ $kertas_kerja->user->name ?? 'Tidak diketahui' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="w-7/12">
                    <form method="POST" action="{{ $is_ada_tindak_lanjut ?  route('tindakLanjut.update',$kertas_kerjas->first()?->lha->tindakLanjutLha?->id) : route('tindakLanjut.store')  }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_lha" value="{{ $kertas_kerjas->first()?->id_lha }}">

                        <div class="badge badge-outline badge-primary">{{$kertas_kerjas->first()?->lha->tindakLanjutLha?->status}}</div>

                        <fieldset class="fieldset w-full">
                            <legend class="fieldset-legend text-base">Penjelasan Tindak Lanjut</legend>
                            <textarea name="tindak_lanjut" id="" class="textarea h-64 w-full required" required
                                placeholder="Penjelasan Tindak Lanjut">{{$kertas_kerjas->first()?->lha->tindakLanjutLha?->tindak_lanjut ?? ''}}</textarea>
                        </fieldset>
                        <fieldset class="fieldset w-full">
                            <legend class="fieldset-legend text-base">Upload Bukti Dukung Perbaikan</legend>
                            <input type="file" class="file-input w-full required" required name="eviden_path" />
                            <label class="label">Max size 2MB</label>
                            <label class="label">Jenis File .jpg / .jpeg / .pdf</label>
                        </fieldset>
                        <a href="{{asset('storage/tindak_lanjut/'.$kertas_kerjas->first()?->lha->tindakLanjutLha?->eviden_path)}}" class="link-accent underline">
                        {{$kertas_kerjas->first()?->lha->tindakLanjutLha?->eviden_path ? 'Lihat Dokumen' : ''}}
                        </a>

                        @if ($is_ada_tindak_lanjut)
                            <div class="flex flex-row justify-end space-x-2">
                                @if ($kertas_kerjas->first()?->lha->tindakLanjutLha?->status=='diajukan')

                                @else
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                @endif
                                @if ($kertas_kerjas->first()?->lha->tindakLanjutLha?->status!='diajukan')
                                    <button type="button" id="submit-keatasan" class="btn btn-neutral btn-sm">Submit Keatasan</button>
                                @endif
                            </div>
                        @else
                            <button class="btn btn-success float-end mt-3">Kirim Tindak Lanjut</button>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('script')
    <script>
        $('#submit-keatasan').on('click',function(){
            if(confirm('Apakah Yakin Ingin Mengirim KeAtasan ?')){
                window.location.href="{{route('tindakLanjut.submitKeatasan',$id_tindak_lanjut)}}"
            }
        })
    </script>
@endpush
