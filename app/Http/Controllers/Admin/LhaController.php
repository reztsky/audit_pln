<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLhaRequest;
use App\Models\KertasKerja;
use App\Models\Lha;
use App\Models\Pka;
use Illuminate\Http\Request;

class LhaController extends Controller
{
    public function index(){
        $pkas=Pka::with(['suratTugas'])->withCount('lha')->paginate(10);
        return view('admin.lha.index',compact('pkas'));
    }

    public function create($idpka){
        $pka=Pka::with('suratTugas')->findOrfail($idpka);
        $kertas_kerjas=KertasKerja::findByPka($idpka)->get();
        return view('admin.lha.create',compact('pka','kertas_kerjas'));
    }

    
    public function store(StoreLhaRequest $request){
        $validated=$request->except(['id_kertas_kerjas']);
        $lha=Lha::create($validated);
        $kertas_kerja=KertasKerja::whereIn('id',$request->id_kertas_kerjas)
        ->update([
            'id_lha'=>$lha->id
        ]);

        if($lha && $kertas_kerja){
            return redirect()->route('lha.index')->with('notifikasi_sukses','Berhasil Menambahkan Data');
        }
        return redirect()->route('lha.index')->with('notifikasi_gagal','Gagal Menambahkan Data');
    }
}
