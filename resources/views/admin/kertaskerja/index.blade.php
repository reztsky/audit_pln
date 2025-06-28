@extends('admin.layout')
@section('title', 'Kertas Kerja')
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
    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Audit</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pkas as $pka)
                    <tr>
                        <td>{{ $pkas->firstItem() + $loop->index }}</td>
                        <td>
                            <p class="text-slate-800"><span class="font-bold">{{ $pka->surattugas->judul_audit }}</span> -
                                {{ $pka->surattugas->lokasi_audit }} - {{$pka->kertasKerja->first()?->lha?->formated_action}}</p>
                            <p class="text-slate-500 text-xs">
                                {{ $pka->surattugas->tanggal_audit->translatedFormat('d F Y') }}
                            </p>

                        </td>
                        <td>
                            <button class="btn btn-sm btn-success btn-show-kertas-kerja" data-id="{{ $pka->id }}"
                                onclick="showKertasKerja.showModal()">Lihat Kertas Kerja</button>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>

        <div class="my-4 px-3">
            {{ $pkas->links() }}
        </div>
    </div>
    @include('admin.kertaskerja.show')
@endsection
