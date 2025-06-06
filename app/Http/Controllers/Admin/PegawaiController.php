<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(){
        $jabatans=Jabatan::all();
        $pegawais=Pegawai::paginate(10);
        return view('admin.pegawai.index',compact('jabatans','pegawais'));
    }

    public function store(Request $request){
        $validated=$request->validate([
            'nama'=>'required',
            'nip'=>'numeric|required',
            'jabatan'=>'required|exists:jabatans,nama_jabatan'
        ]);

        $pegawai=Pegawai::create($validated);
        if($pegawai){
            return redirect()->route('pegawai.index')->with('notifikasi_sukses','Berhasil Menambahkan Data');
        }

        return redirect()->route('pegawai.index')->with('notifikasi_gagal','Gagal Menambahkan Data');
    }

    public function delete($id){
        $pegawai=Pegawai::findOrFail($id);
        $pegawai->delete();
        if($pegawai){
            return redirect()->route('pegawai.index')->with('notifikasi_sukses','Berhasil Menghapus Data');
        }

        return redirect()->route('pegawai.index')->with('notifikasi_gagal','Gagal Menghapus Data');
    }
    
}
