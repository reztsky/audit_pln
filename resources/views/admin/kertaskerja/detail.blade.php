@extends('admin.layout')
@section('title', 'Kertas Kerja')
@section('kertaskerja-active', 'menu-active')
@section('content')
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Detail Kertas Kerja</h1>

        <div class="card bg-base-100 shadow-md">
            <div class="card-body space-y-4">

                {{-- PKA --}}
                <div>
                    <span class="text-sm text-gray-500">Audit Terkait</span>
                    <p class="">
                       <span class="font-semibold"> {{ $kertas_kerja->pka->suratTugas->judul_audit ?? '-' }}</span> - <span class="">{{ $kertas_kerja->pka->suratTugas->lokasi_audit ?? '-' }}</span>
                    </p>
                    <p>{{ $kertas_kerja->pka->suratTugas->tanggal_audit->translatedFormat('d F Y') ?? '-' }} </p>
                </div>

                {{-- LHA --}}
                <div>
                    <span class="text-sm text-gray-500">LHA Terkait</span>
                    <p>
                        @if ($kertas_kerja->lha)
                            <a href="{{ route('lha.show', $kertas_kerja->lha->id) }}" class="link link-primary">
                                {{ $kertas_kerja->lha->judul }}
                            </a>
                        @else
                            <span class="text-gray-400">Belum ditugaskan</span>
                        @endif
                    </p>
                </div>

                {{-- Kontrol --}}
                <div>
                    <span class="text-sm text-gray-500">Kontrol / Prosedur</span>
                    <p>{{ $kertas_kerja->kontrol }}</p>
                </div>

                {{-- Unit --}}
                <div>
                    <span class="text-sm text-gray-500">Unit</span>
                    <p>{{ $kertas_kerja->unit }}</p>
                </div>

                {{-- Bidang --}}
                <div>
                    <span class="text-sm text-gray-500">Bidang</span>
                    <p>{{ $kertas_kerja->bidang }}</p>
                </div>

                {{-- Tanggal --}}
                <div>
                    <span class="text-sm text-gray-500">Tanggal</span>
                    <p>{{ \Carbon\Carbon::parse($kertas_kerja->tanggal)->format('d M Y') }}</p>
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

                <div class="pt-6">
                    <a href="{{ redirect()->back() }}" class="btn btn-neutral">
                        ← Kembali ke Daftar
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
