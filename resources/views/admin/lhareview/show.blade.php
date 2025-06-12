@extends('admin.layout')
@section('title', 'Review LHA')
@section('lhareview-active', 'menu-active')
@section('content')
    <div class="card bg-white shadow-lg rounded-xl p-6">
        <h2 class="card-title text-2xl font-bold mb-4">Ringkasan LHA</h2>
        <p class="text-gray-700 leading-relaxed mb-6">
            {{ $lha->ringkasan }}
        </p>

        <div class="flex flex-row space-x-4">
            <div class="w-7/12">
                <form method="POST" action="{{ route('lhaReview.submit', $lha->id) }}">
                    @csrf
                    <div class="form-control mb-4">
                        <label class="label font-semibold">Tanggapan</label>
                        <select name="action" class="select select-bordered w-full" required>
                            <option value="">-- Pilih Tindakan --</option>
                            <option value="disetujui">✅ Setujui</option>
                            <option value="revisi">✏️ Minta Revisi</option>
                        </select>
                    </div>

                    <div class="form-control mb-6">
                        <label class="label font-semibold">Komentar (Opsional)</label>
                        <textarea name="komentar" class="textarea textarea-bordered w-full" rows="4"
                            placeholder="Tulis komentar jika perlu...">{{ old('komentar') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-full">
                        Kirim Review
                    </button>
                </form>
            </div>
            <div class="w-5/12">
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold mb-2">Log Aktivitas LHA</h3>
                    @forelse ($lha->LhaLog as $log)
                        <div class="bg-gray-50 border border-gray-400 rounded-xl p-4 shadow">
                            <div class="flex items-center justify-between">
                                <div class="font-semibold text-gray-800">
                                    {{ ucfirst($log->action) }}
                                    <span class="badge badge-outline badge-sm ml-2">{{ $log->user->name }}</span>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $log->created_at->format('d M Y H:i') }}
                                </div>
                            </div>

                            @if ($log->catatan)
                                <p class="text-sm text-gray-600 mt-2">
                                    📝 {{ $log->catatan }}
                                </p>
                            @endif
                        </div>
                    @empty
                        <div class="text-gray-500 italic">Belum ada aktivitas tercatat.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
