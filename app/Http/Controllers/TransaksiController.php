<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Ikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'detailTransaksi'])->latest()->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $ikans = Ikan::where('stok', '>', 0)->with('kategori')->get();
        return view('transaksi.create', compact('ikans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ikan_id' => 'required|array',
            'ikan_id.*' => 'required|exists:ikan,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        
        try {
            $totalBayar = 0;
            $items = [];

            foreach ($request->ikan_id as $index => $ikanId) {
                $ikan = Ikan::findOrFail($ikanId);
                $jumlah = $request->jumlah[$index];
                
                if ($ikan->stok < $jumlah) {
                    throw new \Exception("Stok {$ikan->nama_ikan} tidak mencukupi!");
                }
                
                $subtotal = $ikan->harga_jual * $jumlah;
                $totalBayar += $subtotal;
                
                $items[] = [
                    'ikan' => $ikan,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                ];
            }

            $transaksi = Transaksi::create([
                'user_id' => auth()->id(),
                'tanggal_transaksi' => now(),
                'total_bayar' => $totalBayar,
            ]);

            foreach ($items as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'ikan_id' => $item['ikan']->id,
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['ikan']->harga_jual,
                    'subtotal' => $item['subtotal'],
                ]);

                $item['ikan']->decrement('stok', $item['jumlah']);
            }

            DB::commit();
            return redirect()->route('transaksi.show', $transaksi->id)->with('success', 'Transaksi berhasil!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'detailTransaksi.ikan.kategori']);
        return view('transaksi.show', compact('transaksi'));
    }

    public function destroy(Transaksi $transaksi)
    {
        DB::beginTransaction();
        
        try {
            foreach ($transaksi->detailTransaksi as $detail) {
                $detail->ikan->increment('stok', $detail->jumlah);
            }
            
            $transaksi->delete();
            
            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi!');
        }
    }

    public function print(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'detailTransaksi.ikan.kategori']);
        
        return view('transaksi.print', compact('transaksi'));
    }
}