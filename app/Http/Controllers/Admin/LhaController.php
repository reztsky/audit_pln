<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lha\UpdateLhaRequest;
use App\Http\Requests\StoreLhaRequest;
use App\Models\KertasKerja;
use App\Models\Lha;
use App\Models\LhaLog;
use App\Models\Pka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LhaController extends Controller
{
    public function index()
    {
        $pkas = Pka::with(['suratTugas', 'kertasKerja.lha'])->paginate(10);
        return view('admin.lha.index', compact('pkas'));
    }

    public function create($idpka)
    {
        $pka = Pka::with(['lha', 'suratTugas'])->findOrfail($idpka);
        $kertas_kerjas = KertasKerja::findByPka($idpka)->get();
        return view('admin.lha.create', compact('pka', 'kertas_kerjas'));
    }

    public function store(StoreLhaRequest $request)
    {
        $kertas_kerjas = KertasKerja::whereIn('id', $request->id_kertas_kerja)->get();
        
        if ($kertas_kerjas->first()->id_lha != null) {
            $lha = Lha::findOrFail($kertas_kerjas->first()->id_lha);
            $lha->action = 'diajukan';
            $lha->save();
        } else {
            $validated = $request->validated();
            $lha = Lha::create($validated);
            $kertas_kerjas = KertasKerja::whereIn('id', $request->id_kertas_kerja)->update([
                'id_lha' => $lha->id
            ]);
        }

        $lha_log = LhaLog::create([
            'lha_id' => $lha->id,
            'inserted_by' => Auth::user()->id,
            'action' => 'diajukan'
        ]);

        if ($lha) {
            return redirect()->route('lha.index')->with('notifikasi_sukses', 'Berhasil Menambahkan Data');
        }
        return redirect()->route('lha.index')->with('notifikasi_gagal', 'Gagal Menambahkan Data');
    }

    public function review($idpka)
    {
        $kertas_kerjas = KertasKerja::with(['pka'])->findByPka($idpka)->lhaNotNull()->get();
        return view('admin.lha.review', compact('kertas_kerjas'));
    }

    public function accAtasan(Request $request)
    {
        $lha = Lha::whereId($request->lha_id)->update([
            'action' => $request->action,
        ]);
        $lha_log = LhaLog::create([
            'lha_id' => $request->lha_id,
            'inserted_by' => Auth::user()->id,
            'action' => $request->action,
            'catatan' => $request->catatan
        ]);

        if ($lha) {
            return redirect()->route('lha.index')->with('notifikasi_sukses', 'Berhasil Mensetujui LHA');
        }
        return redirect()->route('lha.index')->with('notifikasi_gagal', 'Gagal Mensetujui LHA');
    }

    public function submitKeAtasan($id)
    {
        $lha = Lha::findOrFail($id);
        $lha->status = 'diajukan';
        $lha->save();
        $lha_log = LhaLog::create([
            'lha_id' => $lha->id,
            'inserted_by' => Auth::user()->id,
            'action' => 'diajukan'
        ]);

        if ($lha && $lha_log) {
            return redirect()->route('lha.index')->with('notifikasi_sukses', 'Berhasil Mengirim LHA Ke Atasan');
        }
        return redirect()->route('lha.index')->with('notifikasi_gagal', 'Gagal Mengirim LHA Ke Atasan');
    }

    public function edit($id)
    {
        $lha = Lha::with(['pka', 'kertasKerja'])->findOrFail($id);
        $pka = Pka::with('suratTugas')->findOrfail($lha->id_pka);
        $kertas_kerjas = KertasKerja::findByPka($lha->id_pka)->get();
        return view('admin.lha.edit', compact('lha', 'pka', 'kertas_kerjas'));
    }

    public function detail($id)
    {

        $lha = Lha::with([
            'pka.suratTugas',
            'LhaLog' => function ($query) {
                $query->with('user')->orderBy('id', 'desc');
            },
            'kertasKerja'
        ])->findOrFail($id);
        return response()->json([
            'data' => $lha,
        ], 200);
    }

    public function update(UpdateLhaRequest $request, $id)
    {
        $lha = Lha::findOrFail($id);
        $lha->update($request->validated());
        if ($lha) {
            return redirect()->route('lha.index')->with('notifikasi_sukses', 'Berhasil Mengupdate LHA');
        }
        return redirect()->route('lha.index')->with('notifikasi_gagal', 'Gagal Mengupdate LHA');
    }

    public function lhaHistory($id)
    {
        $log = LhaLog::with(['lha', 'user'])->findByLha($id)->orderBy('created_at', 'asc')->get();
        return response()->json([
            'data' => $log
        ], 200);
    }
}
