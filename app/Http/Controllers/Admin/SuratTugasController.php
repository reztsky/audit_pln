<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuratTugas\StoreSuratTugasRequest;
use App\Models\Pegawai;
use App\Models\SuratTugas;
use Illuminate\Http\Request;

class SuratTugasController extends Controller
{
    public function index()
    {
        $surattugass = SuratTugas::with(['pegawai','dokumenMeeting','pka.kertasKerja.lha'])->paginate(10);
        $pegawais = Pegawai::stafAuditor()->get();
        return view('admin.surattugas.index', compact('surattugass', 'pegawais'));
    }

    public function store(StoreSuratTugasRequest $request)
    {
        $validated = $request->except(['surat_tugas']);
        $validated['surat_tugas'] = $this->upload($request->file('surat_tugas'));
        $surattugas = SuratTugas::create($validated);
        if ($surattugas) {
            return redirect()->route('suratTugas.index')->with('notifikasi_sukses', 'Berhasil Menambahkan Data');
        }

        return redirect()->route('suratTugas.index')->with('notifikasi_gagal', 'Gagal Menambahkan Data');
    }

    private function upload($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('surat_tugas', $filename, 'public');
        return $filename;
    }
}
