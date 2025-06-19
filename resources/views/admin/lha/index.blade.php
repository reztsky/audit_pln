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
                            <div class="flex flex-row space-x-2">
                                <div>
                                    <p class="text-slate-800"><span
                                            class="font-bold">{{ $pka->surattugas->judul_audit }}</span> -
                                        {{ $pka->surattugas->lokasi_audit }}</p>
                                    <p class="text-slate-500 text-xs">
                                        {{ $pka->surattugas->tanggal_audit->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <label class="btn btn-primary btn-sm" for="detail-drawer"><x-heroicon-o-eye class="w-4 h-4"/>LHA</label>
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
    @include('admin.lha.detail')
@endsection
