@extends('admin.layout')
@push('style')
@endpush
@section('title', 'Tindak Lanjut')
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
    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
        <table class="table">
            <!-- head -->
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
                                        {{ $pka->surattugas->lokasi_audit }} -
                                        {{ $pka->kertasKerja->first()?->lha?->formated_action }}
                                    <p class="text-slate-500 text-xs">
                                        {{ $pka->surattugas->tanggal_audit->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('lha.review', $pka->id) }}"><x-heroicon-o-eye
                                    class="w-4 h-4" />LHA</a>
                            <a href="{{ route('tindakLanjut.create', $pka->kertasKerja->first()->id_lha) }}"
                                class="btn btn-sm ">Tindak Lanjut</a>

                            @hasanyrole(['Atasan Auditee','Super Admin'])
                                @if ($pka->kertasKerja->first()?->lha?->tindakLanjutLha?->status == 'diajukan')
                                    <a href="{{ route('tindakLanjut.reviewTindakLanjut', $pka->kertasKerja->first()?->lha->tindakLanjutLha->id) }}"
                                        class="btn btn-sm btn-neutral">Review Tindak Lanjut</a>
                                @endif
                            @endhasanyrole

                            @hasanyrole(['Staf Auditor','Super Admin'])
                                @if ($pka->kertasKerja->first()?->lha?->action == 'tindaklanjut_ok')
                                    <a href="{{ route('tindakLanjut.reviewFinal', $pka->kertasKerja->first()?->lha->tindakLanjutLha->id) }}"
                                        class="btn btn-sm btn-neutral">Final Review</a>
                                @endif
                            @endhasanyrole
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
@push('script')
@endpush
