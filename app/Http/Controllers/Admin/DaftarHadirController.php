<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaftarHadir;
use Illuminate\Http\Request;

class DaftarHadirController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inserted_by'=>'required|numeric|exists:users,id',
            'id_pka' => 'required|numeric|exists:pkas,id',
            'tanggal_meeting'=>'required|date|before:tomorrow',
            'lokasi_meeting'=>'required',
            'daftar_hadir' => 'required|file|max:2048|mimes:pdf'
        ]);
        $validated['daftar_hadir'] = $this->upload($request->file('daftar_hadir'));
        $daftar_hadir = DaftarHadir::create($validated);
        if ($daftar_hadir) {
            return redirect()->route('pka.index')->with('notifikasi_sukses', 'Berhasil Mengupload Daftar Hadir');
        }

        return redirect()->route('pka.index')->with('notifikasi_gagal', 'Gagal Mengupload Daftar Hadir');
    }

    public function daftarHadirPka($idpka){
        $daftar_hadirs=DaftarHadir::findByPka($idpka)->get();
        return response()->json([
            'data'=>$daftar_hadirs
        ],200);
    }

    private function upload($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('daftar_hadir', $filename, 'public');
        return $filename;
    }
}
