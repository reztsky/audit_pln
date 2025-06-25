<?php

namespace App\Http\Controllers;

use App\Models\KertasKerja;
use App\Models\Lha;
use App\Models\LhaLog;
use App\Models\Pka;
use App\Models\TindakLanjutLha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TindakLanjutLhaController extends Controller
{
    public function index()
    {
        $pkas = Pka::with(['suratTugas', 'kertasKerja', 'kertasKerja.lha.tindakLanjutLha'])->whereHas('kertasKerja.lha', function ($q) {
            return $q->whereAction('disetujui');
        })->paginate(10);
        return view('admin.tindaklanjut.index', compact('pkas'));
    }

    public function create($id_lha)
    {
        $kertas_kerjas = KertasKerja::findByLha($id_lha)->get();
        return view('admin.tindaklanjut.create', compact('kertas_kerjas'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'id_lha' => 'required|exists:lhas,id',
            'tindak_lanjut' => 'required|string',
            'eviden_path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('eviden_path')) {
            $path = $this->upload($request->file('eviden_path'));
        }

        $tindak_lanjut_lha = TindakLanjutLha::create([
            'id_lha' => $request->id_lha,
            'inserted_by' => Auth::user()->id,
            'tindak_lanjut' => $request->tindak_lanjut,
            'eviden_path' => $path,
            'status' => 'draft'
        ]);

        $log_lha = LhaLog::create([
            'lha_id' => $request->id_lha,
            'insertedt_by' => Auth::user()->id,
            'action' => 'ditindaklanjuti',
        ]);

        if ($tindak_lanjut_lha) {
            return redirect()->route('tindakLanjut.index')->with('notifikasi_sukses', 'Berhasil Menambahkan Data');
        }
        return redirect()->route('tindakLanjut.index')->with('notifikasi_gagal', 'Gagal Menambahkan Data');
    }

    public function update(Request $request, $id)
    {
        $tindak_lanjut_lha = TindakLanjutLha::findOrFail($id);
        $validate = $request->validate([
            'id_lha' => 'required|exists:lhas,id',
            'tindak_lanjut' => 'required|string',
            'eviden_path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('eviden_path')) {
            $path = $this->upload($request->file('eviden_path'));
            $this->delete($tindak_lanjut_lha->eviden_path);
        }

        $tindak_lanjut_lha = TindakLanjutLha::where('id', $id)
            ->update([
                'id_lha' => $request->id_lha,
                'inserted_by' => Auth::user()->id,
                'tindak_lanjut' => $request->tindak_lanjut,
                'eviden_path' => $path,
                'status' => 'draft'
            ]);

        if ($tindak_lanjut_lha) {
            return redirect()->route('tindakLanjut.index')->with('notifikasi_sukses', 'Berhasil Mengubah Data');
        }
        return redirect()->route('tindakLanjut.index')->with('notifikasi_gagal', 'Gagal Mengubah Data');
    }

    public function submitKeatasan($id)
    {
        $tindak_lanjut_lha = TindakLanjutLha::findOrfail($id);
        $tindak_lanjut_lha->status = 'diajukan';
        $tindak_lanjut_lha->save();

        if ($tindak_lanjut_lha) {
            return redirect()->route('tindakLanjut.index')->with('notifikasi_sukses', 'Berhasil Mengirim Keatasan');
        }
        return redirect()->route('tindakLanjut.index')->with('notifikasi_gagal', 'Gagal Mengirim Keatasan');
    }

    public function reviewTindakLanjut($id){
        $tindak_lanjut_lha=TindakLanjutLha::with([''])->findOrFail($id);
        return view('admin.tindaklanjut.review',compact('tindak_lanjut_lha'));
    }


    private function upload($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('tindak_lanjut', $filename, 'public');
        return $filename;
    }

    private function delete($file)
    {
        if (Storage::disk('public')->exists('/public/tindak_lanjut/' . $file)) {
            Storage::disk('public')->delete('/public/tindak_lanjut/' . $file);
        }
    }
}
