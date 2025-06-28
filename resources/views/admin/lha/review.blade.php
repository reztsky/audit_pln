@extends('admin.layout')
@section('title', 'Laporan Hasil Audit (LHA)')
@section('lha-active', 'menu-active')
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
        <div class="md:w-6/12 w-12/12 p-3">
            @forelse ($kertas_kerjas as $kertas_kerja)
                <div class="card bg-base-100 shadow-md">
                    <div class="card-body space-y-4">
                        {{-- PKA --}}
                        <div>
                            <span class="text-sm text-gray-500">Audit Terkait</span>
                            <p class="">
                                <span class="font-semibold"> {{ $kertas_kerja->pka->suratTugas->judul_audit ?? '-' }}</span>
                                -
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

                        {{-- Temuan --}}
                        <div>
                            <span class="text-sm text-gray-500">Kategori Temuan</span>
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
        @hasanyrole(['Atasan Auditor','Super Admin'])
            <div class="md:w-6/12 w-12/12">
                @if (in_array($kertas_kerjas->first()?->lha?->action, ['draft', 'diajukan', 'revisi']))
                    <div class="flex flex-row flex-wrap gap-3">
                        <div class="card-body">
                            <form method="POST" action="{{ route('lha.accAtasan') }}">
                                @csrf
                                <input type="hidden" name="lha_id" value="{{ $kertas_kerjas->first()->id_lha }}">
                                <div class="form-control mb-4">
                                    <label class="label font-semibold">Tanggapan</label>
                                    <select name="action" class="select select-bordered w-full" required>
                                        <option value="">-- Pilih Tindakan --</option>
                                        <option value="disetujui"
                                            {{ $kertas_kerjas->first()->lha->action == 'disetujui' ? 'selected' : '' }}>✅
                                            Setujui
                                        </option>
                                        <option value="revisi"
                                            {{ $kertas_kerjas->first()->lha->action == 'revisi' ? 'selected' : '' }}>
                                            ✏️ Minta Revisi</option>
                                    </select>
                                </div>
                                <div class="form-control mb-6">
                                    <label class="label font-semibold">Komentar (Opsional)</label>
                                    <textarea name="catatan" class="textarea textarea-bordered w-full" rows="4"
                                        placeholder="Tulis komentar jika perlu...">{{ old('catatan')  }}</textarea>
                                </div>

                                @if ($kertas_kerjas->first()?->lha?->action == 'revisi')
                                    <button type="button" disabled class="btn btn-success w-full">
                                        Sedang Direvisi
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-success w-full">
                                        Kirim Review
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        @endhasanyrole

    </div>


    <div class="pt-6 flex flex-row justify-end gap-3">
        <a href="{{ route('lha.index') }}" class="btn btn-neutral">
            ← Kembali ke Daftar
        </a>
    </div>
@endsection
