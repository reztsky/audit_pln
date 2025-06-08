<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimAudit;
use Illuminate\Http\Request;

class TimAuditController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pka' => 'required|numeric|exists:pkas,id',
            'tim_audit' => 'array|min:1'
        ]);

        foreach ($validated['tim_audit'] as $value) {
            $tim_audit = TimAudit::create([
                'id_pka' => $validated['id_pka'],
                'id_pegawai' => $value
            ]);
        }

        if ($tim_audit) {
            return redirect()->route('pka.index')->with('notifikasi_sukses', 'Berhasil Menambahkan Tim Audit');
        }

        return redirect()->route('pka.index')->with('notifikasi_gagal', 'Gagal Menambahkan Tim Audit');
    }

    public function timByPka($id_pka){
        $tim_audits=TimAudit::findByPka($id_pka)->with('pegawai')->get();
        return response()->json([
            'data'=>$tim_audits
        ],200);
    }

    public function update(Request $request,$id){
        $tim_audit=TimAudit::findOrFail($id);
        $tim_audit->is_pic=$request->input('is_pic');
        $tim_audit->save();
        return response()->json(['success' => true]);
    }
}
