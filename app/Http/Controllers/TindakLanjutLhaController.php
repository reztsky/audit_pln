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
            return $q->whereIn('action',['disetujui','ditindaklanjuti','revisi_tindaklanjut','tindaklanjut_ok']);
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

        $lha = Lha::where('lha_id', $request->id_lha)->update([
            'action'=>'ditindaklanjuti'
        ]);

        $log_lha = LhaLog::create([
            'lha_id' => $request->id_lha,
            'inserted_by' => Auth::user()->id,
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
        $tindak_lanjut_lha=TindakLanjutLha::with(['lha','lha.kertasKerja.pka.suratTugas'])->findOrFail($id);
        return view('admin.tindaklanjut.review',compact('tindak_lanjut_lha'));
    }

    public function submitReview(Request $request){
        $request->validate([
            'id_tindak_lanjut'=>'required|numeric|exists:tindak_lanjut_lhas,id',
            'status'=>'required',
            'catatan'=>'nullable'
        ]);

        $tindak_lanjut_lha=TindakLanjutLha::findOrFail($request->id_tindak_lanjut);
        $tindak_lanjut_lha->status=$request->status;
        $tindak_lanjut_lha->save();

        $lhaLog=LhaLog::create([
            'lha_id'=>$tindak_lanjut_lha->id_lha,
            'inserted_by'=>Auth::user()->id,
            'action'=>$request->status=='revisi' ? 'revisi_tindaklanjut' : 'tindaklanjut_ok',
            'catatan'=>$request->catatan,
        ]);

        $lha=Lha::whereId($tindak_lanjut_lha->id_lha)->update([
            'action'=>$request->status=='revisi' ? 'revisi_tindaklanjut' : 'tindaklanjut_ok'
        ]);

        if ($tindak_lanjut_lha) {
            return redirect()->route('tindakLanjut.index')->with('notifikasi_sukses', 'Berhasil Mengirim Keatasan');
        }
        return redirect()->route('tindakLanjut.index')->with('notifikasi_gagal', 'Gagal Mengirim Keatasan');

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
