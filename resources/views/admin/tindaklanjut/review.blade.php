@extends('admin.layout')
@push('style')
@endpush
@section('title', 'Review Tindak Lanjut')
@section('tindaklanjut-active', 'menu-active')
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
    <div class="flex flex-row flex-wrap">
        @php
            $kertas_kerjas = $tindak_lanjut_lha->lha->kertasKerja;
        @endphp
        <div class="md:w-6/12 w-12/12">
            @forelse ($kertas_kerjas as $kertas_kerja)
                <div class="card-body shadow mr-3">
                    {{-- PKA --}}
                    <div>
                        <span class="text-sm text-gray-500">Audit Terkait</span>
                        <p class="">
                            <span class="font-semibold"> {{ $kertas_kerja->pka->suratTugas->judul_audit ?? '-' }}</span> -
                            <span class="">{{ $kertas_kerja->pka->suratTugas->lokasi_audit ?? '-' }}</span>
                        </p>
                        <p>{{ $kertas_kerja->pka->suratTugas->tanggal_audit->translatedFormat('d F Y') ?? '-' }} </p>
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
                            <a href="{{ asset('storage/kertas_kerja/' . $kertas_kerja->dokumen_dukung) }}" target="_blank"
                                class="btn btn-sm btn-outline btn-info">
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
            @empty
            @endforelse
        </div>
        <div class="md:w-6/12 w-12/12">
            <div class="card-body bg-base-200 shadow">
                <table class="table w-full">
                    <tbody>
                        <tr>
                            <th class="w-3/12">Tindak Lanjut</th>
                            <td class="w-9/12">{{ $tindak_lanjut_lha->tindak_lanjut }}</td>
                        </tr>
                        <tr>
                            <th class="w-3/12">Dokumen Dukung</th>
                            <td class="w-9/12"><a
                                    href="{{ asset('storage/tindak_lanjut/' . $tindak_lanjut_lha->eviden_path) }}"
                                    class="link-accent" target="_blank">Lihat Dokumen</a></td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <form action="{{ route('tindakLanjut.submitReview') }}" method="post">
                    @csrf
                    <input type="hidden" name="id_tindak_lanjut" value="{{ $tindak_lanjut_lha->id }}">
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend text-base">Review</legend>
                        <select name="status" class="select w-full" id="">
                            <option selected disabled>Pilih Review</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="revisi">Revisi</option>
                        </select>
                    </fieldset>
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend text-base">Catatan</legend>
                        <textarea name="catatan" id="" class="textarea h-30 w-full" placeholder="Catatan"></textarea>
                    </fieldset>
                    <button class="btn btn-sm btn-neutral float-end mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
