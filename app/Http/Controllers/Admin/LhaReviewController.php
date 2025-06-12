<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lha;
use App\Models\LhaLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LhaReviewController extends Controller
{
    public function index()
    {
        $lhas = Lha::with(['LhaLog', 'user'])->paginate(10);
        return view('admin.lhareview.index', compact('lhas'));
    }

    public function show($id)
    {
        $lha = Lha::with(['LhaLog'=>function($query){
            return $query->orderBy('id','desc');
        }, 'pka'])->findOrFail($id);
        return view('admin.lhareview.show', compact('lha'));
    }

    public function submitReview(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:disetujui,revisi',
            'komentar' => 'nullable|string',
        ]);

        $lha = Lha::findOrFail($id);
        $lha->update([
            'status' => $request->action,
            'komentar' => $request->komentar,
        ]);

        // log aktivitas
        LhaLog::create([
            'lha_id' => $lha->id,
            'inserted_by' => Auth::user()->id,
            'action' => $request->action,
            'catatan' => $request->komentar,
        ]);

        return redirect()->route('lhaReview.index')->with('success', 'Review berhasil dikirim.');
    }
}
