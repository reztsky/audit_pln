<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KertasKerja;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data_chart = $this->countDashboard();
        return view('admin.dashboard.index', compact('data_chart'));
    }

    private function countDashboard()
    {
        $kategori_temuan = KertasKerja::selectRaw('count(*) as jumlah,kategori_temuan')
            ->groupBy('kategori_temuan')
            ->get();

        $kategori_temuan_perbulan = KertasKerja::selectRaw('kategori_temuan,Month(tanggal) as bulan,count(*) as jumlah')
            ->whereYear('tanggal', date('Y'))
            ->groupByRaw('kategori_temuan,Month(tanggal)')
            ->get()->each->setAppends([]);

        $chart = $this->setChart($kategori_temuan_perbulan);
        return [
            'kategori_temuan' => $kategori_temuan,
            'kategori_temuan_perbulan' => $chart
        ];
    }

    private function setChart($data)
    {
        $chart = collect([]);
        $jumlah_perbulan=[];
        $kategori_temuan = [
            'Major',
            'Minor',
            'Ofi',
            'Sesuai'
        ];

        for ($y = 0; $y < 4; $y++) {
            $jumlah_perbulan=[];
            for ($i = 1; $i < 13; $i++) {
                $jumlah_perbulan[]=$data->where('kategori_temuan',$kategori_temuan[$y])->where('bulan',$i)->first()?->jumlah ?? 0;
            }
            $chart->push((Object)[
                'kategori'=>$kategori_temuan[$y],
                'data'=>$jumlah_perbulan
            ]);
        }
        return $chart;
    }
}
