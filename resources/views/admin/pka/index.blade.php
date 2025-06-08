@extends('admin.layout')
@push('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
@section('title', 'PKA')
@section('pka-active', 'menu-active')
@section('content')
    <div class="flex justify-end mb-5">
        <button class="btn btn-sm btn-accent" onclick="create.showModal()">Tambah</button>
    </div>
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
    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>Audit</th>
                    <th>PKA</th>
                    <th>Tim Audit</th>
                    <th>Daftar Hadir</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pkas as $pka)
                    <tr>
                        <td>{{ $pkas->firstItem() + $loop->index }}</td>
                        <td>
                            <p class="text-slate-800"><span class="font-bold">{{ $pka->surattugas->judul_audit }}</span> -
                                {{ $pka->surattugas->lokasi_audit }}</p>
                            <p class="text-slate-500 text-xs">
                                {{ $pka->surattugas->tanggal_audit->translatedFormat('d F Y') }}
                            </p>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-detail-pka btn-soft btn-sm" data-id="{{ $pka->id }}"
                                onclick="detail.showModal()"><x-heroicon-o-document-magnifying-glass
                                    class="w-5 h-5" />Detail PKA</button>
                        </td>
                        <td>
                            @if ($pka->tim_audit_count > 1)
                                <button class="btn btn-soft btn-sm btn-warning btn-lihat-tim" data-id="{{ $pka->id }}"
                                    onclick="lihatTim.showModal()">
                                    <x-heroicon-o-tag class="w-5 h-5" />Lihat Tim
                                </button>
                            @else
                                <button class="btn btn-soft btn-sm btn-accent btn-tambah-tim" onclick="storeTim.showModal()"
                                    data-id="{{ $pka->id }}"><x-heroicon-o-user-plus class="w-5 h-5" />Tambah
                                    Tim</button>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-soft btn-sm btn-info {{ $pka->daftar_hadir_count >= 1 ? 'btn-daftar-hadir-show' : 'btn-daftar-hadir' }}" data-id="{{ $pka->id }}"
                                onclick="{{ $pka->daftar_hadir_count >= 1 ? 'daftarHadirShow.showModal()' : 'daftarHadirCreate.showModal()' }}">
                                <x-heroicon-o-document-check class="w-5 h-5" /> {{ $pka->daftar_hadir_count >= 1 ? 'Lihat' : 'Upload' }}
                            </button>
                        </td>
                        <td></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="99" class="text-center text-slate-500">No Found Record</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="my-4 px-3">
            {{ $pkas->links() }}
        </div>
    </div>
    @include('admin.pka.detail')
    @include('admin.pka.create')
    @include('admin.timaudit.create')
    @include('admin.timaudit.detail')
    @include('admin.daftarhadir.create')
    @include('admin.daftarhadir.show')
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $('textarea').each(function() {
            var placeholder = $(this).attr('placeholder') || ''; // fallback jika tidak ada placeholder
            $(this).summernote({
                placeholder: placeholder,
                height: 120,
            });
        });
    </script>
@endpush
