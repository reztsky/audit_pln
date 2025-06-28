<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DokumenMeetingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_surat_tugas' => 'required|exists:surat_tugas,id',
            'jenis_dokumen' => ['required', Rule::in(['Daftar Hadir Closing', 'Closing Meeting'])],
            'dokumen' => 'required|mimes:pdf|file|max:2048'
        ]);
        $path_dokumen = $this->upload($request->dokumen);

        $dokumen_meeting = DokumenMeeting::create([
            'id_surat_tugas' => $request->id_surat_tugas,
            'inserted_by' => Auth::user()->id,
            'jenis_dokumen' => $request->jenis_dokumen,
            'path_dokumen' => $path_dokumen
        ]);

        if ($dokumen_meeting) {
            return redirect()->route('suratTugas.index')->with('notifikasi_sukses', 'Berhasil Mengupload Dokumen');
        }
        return redirect()->route('suratTugas.index')->with('notifikasi_gagal', 'Gagal Mengupload Dokumen');
    }

    public function delete($id)
    {
        $dokumen_meeting = DokumenMeeting::findOrFail($id);
        if (!$this->removeFile($dokumen_meeting->path_dokumen)) return redirect()->route('suratTugas.index')->with('notifikasi_sukses', 'Gagal Menghapus Dokumen');

        $dokumen_meeting->delete();
        return redirect()->route('suratTugas.index')->with('notifikasi_sukses', 'Berhasil Menghapus Dokumen');
    }

    private function upload($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('dokumen_meeting', $filename, 'public');
        return $filename;
    }

    private function removeFile($file)
    {
        if (Storage::disk('public')->exists('dokumen_meeting/' . $file)) {
            Storage::disk('public')->delete('dokumen_meeting/' . $file);
            return true;
        }
        return false;
    }
}
