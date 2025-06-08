<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KertasKerja\StoreKertasKerjaRequest;
use App\Models\KertasKerja;
use App\Models\Pka;
use Illuminate\Http\Request;

class KertasKerjaController extends Controller
{
    public function index()
    {
        $pkas = Pka::with(['suratTugas','kertasKerja'])->paginate(10);
        return view('admin.kertaskerja.index', compact('pkas'));
    }

    public function create($idpka)
    {
        $pka = Pka::with('suratTugas')->findOrFail($idpka);
        return view('admin.kertaskerja.create', compact('pka'));
    }

    public function store(StoreKertasKerjaRequest $request)
    {
        $validated = $request->except('dokumen_dukung');
        if($request->hasFile('dokumen_dukung')){
            $validated['dokumen_dukung']=$this->upload($request->file('dokumen_dukung'));
        }
        $kertas_kerja=KertasKerja::create($validated);
        if($kertas_kerja){
            return redirect()->route('kertasKerja.index')->with('notifikasi_sukses','Berhasil Menambahkan Data');
        }
        return redirect()->route('kertasKerja.index')->with('notifikasi_gagal','Gagal Menambahkan Data');
    }

    private function upload($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('kertas_kerja', $filename, 'public');
        return $filename;
    }
}
