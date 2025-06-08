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
                        <td>{{ $pka->suratTugas->judul_audit }}</td>
                        <td>
                            @if ($pka->kertasKerja->count()>=1)
                                <button class="btn btn-sm btn-success">Lihat Kertas Kerja</button>
                            @endif
                            <a class="btn btn-sm btn-accent" href="{{ route('kertasKerja.create', $pka->id) }}">
                                <x-heroicon-o-folder-plus class="w-5 h-5"/>
                                Create Kertas Kerja
                            </a>
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
@endsection
