<?php

namespace App\Http\Controllers;

use App\Models\Ikan;
use App\Models\KategoriIkan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IkanController extends Controller
{
    public function index()
    {
        $ikans = Ikan::with('kategori')->latest()->get();
        return view('ikan.index', compact('ikans'));
    }

    public function create()
    {
        $kategoris = KategoriIkan::all();
        return view('ikan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_ikan,id',
            'nama_ikan' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'ukuran' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('ikan', 'public');
        }

        Ikan::create($validated);

        return redirect()->route('ikan.index')->with('success', 'Data ikan berhasil ditambahkan!');
    }

    public function show(Ikan $ikan)
    {
        $ikan->load('kategori');
        return view('ikan.show', compact('ikan'));
    }

    public function edit(Ikan $ikan)
    {
        $kategoris = KategoriIkan::all();
        return view('ikan.edit', compact('ikan', 'kategoris'));
    }

    public function update(Request $request, Ikan $ikan)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_ikan,id',
            'nama_ikan' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'ukuran' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($ikan->foto) {
                Storage::disk('public')->delete($ikan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('ikan', 'public');
        }

        $ikan->update($validated);

        return redirect()->route('ikan.index')->with('success', 'Data ikan berhasil diupdate!');
    }

    public function destroy(Ikan $ikan)
    {
        if ($ikan->foto) {
            Storage::disk('public')->delete($ikan->foto);
        }
        
        $ikan->delete();
        return redirect()->route('ikan.index')->with('success', 'Data ikan berhasil dihapus!');
    }
}