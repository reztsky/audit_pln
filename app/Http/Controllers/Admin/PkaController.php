<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pka\StorePkaRequest;
use App\Models\Pegawai;
use App\Models\Pka;
use App\Models\SuratTugas;
use Illuminate\Http\Request;

class PkaController extends Controller
{
    public function index(){
        $surattugass=SuratTugas::all();
        $pegawais=Pegawai::timAudit()->get();
        $pkas=Pka::with(['suratTugas'])->withCount('daftarHadir')->withCount('timAudit')->paginate(10);
        return view('admin.pka.index',compact('pkas','surattugass','pegawais'));
    }

    public function store(StorePkaRequest $request){
        $validated=$request->validated();
        $pka=Pka::create($validated);
         if ($pka) {
            return redirect()->route('pka.index')->with('notifikasi_sukses', 'Berhasil Menambahkan Data');
        }
        return redirect()->route('pka.index')->with('notifikasi_gagal', 'Gagal Menambahkan Data');
    }

    public function detail($id){
        $pka=Pka::with('suratTugas')->findOrFail($id);
        return response()->json([
            'data'=>$pka,
        ],200);
    }
}
