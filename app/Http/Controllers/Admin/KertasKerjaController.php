<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KertasKerja\StoreKertasKerjaRequest;
use App\Http\Requests\KertasKerja\UpdateKertasKerjaRequest;
use App\Models\KertasKerja;
use App\Models\Pka;
use App\Models\SuratTugas;
use Illuminate\Http\Request;

class KertasKerjaController extends Controller
{
    public function index()
    {
        $pkas = Pka::with(['suratTugas','kertasKerja.lha'])->withCount('kertasKerja')->paginate(10);
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

    public function show($idpka){
        $kertas_kerjas=KertasKerja::with(['pka.suratTugas'])->findByPka($idpka)->get();
        return response()->json([
            'data'=>$kertas_kerjas
        ],200);
    }

    public function edit($id){
        $kertas_kerja=KertasKerja::with(['pka.suratTugas'])->findorFail($id);
        return view('admin.kertasKerja.edit',compact('kertas_kerja'));
    }

    public function update(UpdateKertasKerjaRequest $request, $id){
        $validated = $request->except('dokumen_dukung','_token');
        if($request->hasFile('dokumen_dukung')){
            $validated['dokumen_dukung']=$this->upload($request->file('dokumen_dukung'));
        }
        $kertas_kerja=KertasKerja::whereId($id)->update($validated);
        if($kertas_kerja){
            return redirect()->route('kertasKerja.index')->with('notifikasi_sukses','Berhasil Mengubah Data');
        }
        return redirect()->route('kertasKerja.index')->with('notifikasi_gagal','Gagal Mengubah Data');
    }

    public function detail($id){
        $kertas_kerja=KertasKerja::with(['pka.suratTugas','user'])->findOrFail($id);
        return view('admin.kertaskerja.detail',compact('kertas_kerja'));
    }

    private function upload($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('kertas_kerja', $filename, 'public');
        return $filename;
    }
}
