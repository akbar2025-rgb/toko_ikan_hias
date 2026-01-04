<?php

namespace App\Http\Controllers;

use App\Models\Ikan;
use App\Models\KategoriIkan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIkan = Ikan::count();
        $totalKategori = KategoriIkan::count();
        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Transaksi::sum('total_bayar');
        
        $stokRendah = Ikan::where('stok', '<', 10)->with('kategori')->get();
        $transaksiTerbaru = Transaksi::with(['user', 'detailTransaksi.ikan'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $pendapatanBulanan = Transaksi::select(
            DB::raw('MONTH(tanggal_transaksi) as bulan'),
            DB::raw('SUM(total_bayar) as total')
        )
        ->whereYear('tanggal_transaksi', date('Y'))
        ->groupBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

        return view('dashboard.index', compact(
            'totalIkan',
            'totalKategori',
            'totalTransaksi',
            'totalPendapatan',
            'stokRendah',
            'transaksiTerbaru',
            'pendapatanBulanan'
        ));
    }
}