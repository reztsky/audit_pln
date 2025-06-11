@extends('admin.layout')
@section('title', 'Review LHA')
@section('lhareview-active', 'menu-active')
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
                    <th>Tanggal</th>
                    <th>Judul</th>
                    <th>Dibuat Oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lhas as $lha)
                    <tr>
                        <td>{{ $lhas->firstItem() + $loop->index }}</td>
                        <td>{{ $lha->created_at->translatedFormat('d F Y') }}</td>
                        <td>{{ $lha->judul }}</td>
                        <td>{{ $lha->user->name }}</td>
                        <td>
                            <a href="{{ route('lhaReview.show', $lha->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Review</a>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>

        <div class="my-4 px-3">
            {{ $lhas->links() }}
        </div>
    </div>
@endsection
