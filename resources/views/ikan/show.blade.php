@extends('layouts.app')

@section('title', 'Detail Ikan')
@section('page-title', 'Detail Ikan Hias')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-image me-2"></i>Foto Ikan</h5>
            </div>
            <div class="card-body text-center">
                @if($ikan->foto)
                <img src="{{ asset('storage/'.$ikan->foto) }}" alt="{{ $ikan->nama_ikan }}" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                @else
                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                    <div class="text-white text-center">
                        <i class="fas fa-fish fa-5x mb-3"></i>
                        <p>Tidak ada foto</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i>Statistik</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Harga Beli:</span>
                    <strong>Rp {{ number_format($ikan->harga_beli, 0, ',', '.') }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Harga Jual:</span>
                    <strong class="text-success">Rp {{ number_format($ikan->harga_jual, 0, ',', '.') }}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Profit per Item:</span>
                    <strong class="text-primary">Rp {{ number_format($ikan->harga_jual - $ikan->harga_beli, 0, ',', '.') }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Margin:</span>
                    <strong class="text-info">{{ number_format((($ikan->harga_jual - $ikan->harga_beli) / $ikan->harga_beli) * 100, 1) }}%</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Ikan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Nama Ikan</strong></td>
                        <td width="5%">:</td>
                        <td><h5 class="mb-0">{{ $ikan->nama_ikan }}</h5></td>
                    </tr>
                    <tr>
                        <td><strong>Kategori</strong></td>
                        <td>:</td>
                        <td><span class="badge bg-info">{{ $ikan->kategori->nama_kategori }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Ukuran</strong></td>
                        <td>:</td>
                        <td>{{ $ikan->ukuran ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Harga Beli</strong></td>
                        <td>:</td>
                        <td>Rp {{ number_format($ikan->harga_beli, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Harga Jual</strong></td>
                        <td>:</td>
                        <td><strong class="text-success">Rp {{ number_format($ikan->harga_jual, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Stok</strong></td>
                        <td>:</td>
                        <td>
                            @if($ikan->stok < 10)
                            <span class="badge bg-danger fs-6">{{ $ikan->stok }} Item (Stok Rendah!)</span>
                            @elseif($ikan->stok < 20)
                            <span class="badge bg-warning fs-6">{{ $ikan->stok }} Item</span>
                            @else
                            <span class="badge bg-success fs-6">{{ $ikan->stok }} Item</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat</strong></td>
                        <td>:</td>
                        <td>{{ $ikan->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Terakhir Update</strong></td>
                        <td>:</td>
                        <td>{{ $ikan->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                <hr>

                <div class="mb-3">
                    <strong>Deskripsi:</strong>
                    <p class="mt-2">{{ $ikan->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Aksi</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('ikan.edit', $ikan->id) }}" class="btn btn-warning w-100">
                            <i class="fas fa-edit me-2"></i>Edit Data
                        </a>
                    </div>
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('ikan.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    <div class="col-md-12">
                        <form action="{{ route('ikan.destroy', $ikan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ikan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Hapus Ikan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection