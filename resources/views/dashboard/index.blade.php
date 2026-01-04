@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card" style="--gradient-start: #0a58ca; --gradient-end: #4ba27e;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Ikan</h6>
                        <h3 class="mb-0">{{ $totalIkan }}</h3>
                    </div>
                    <div>
                        <i class="fas fa-fish fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card" style="--gradient-start:rgb(240, 212, 53); --gradient-end:rgb(231, 53, 193);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Kategori</h6>
                        <h3 class="mb-0">{{ $totalKategori }}</h3>
                    </div>
                    <div>
                        <i class="fas fa-tags fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card" style="--gradient-start:rgb(82, 85, 252); --gradient-end:rgb(0, 254, 241);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Transaksi</h6>
                        <h3 class="mb-0">{{ $totalTransaksi }}</h3>
                    </div>
                    <div>
                        <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card" style="--gradient-start:rgb(233, 67, 67); --gradient-end:rgb(255, 115, 0);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Pendapatan</h6>
                        <h3 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                    <div>
                        <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Stok Rendah (< 10)</h5>
                </div>
                <div class="card-body">
                    @if($stokRendah->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Ikan</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stokRendah as $ikan)
                                <tr>
                                    <td>{{ $ikan->nama_ikan }}</td>
                                    <td><span class="badge bg-secondary">{{ $ikan->kategori->nama_kategori }}</span></td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">{{ $ikan->stok }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <p>Semua stok ikan masih aman!</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Transaksi Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($transaksiTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kasir</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiTerbaru as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                                    <td>{{ $transaksi->user->name }}</td>
                                    <td class="text-end">
                                        <strong>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>Belum ada transaksi</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('transaksi.create') }}" class="btn btn-lg btn-primary w-100">
                                <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                                Transaksi Baru
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('ikan.create') }}" class="btn btn-lg btn-success w-100">
                                <i class="fas fa-fish fa-2x d-block mb-2"></i>
                                Tambah Ikan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('kategori.create') }}" class="btn btn-lg btn-info w-100">
                                <i class="fas fa-tags fa-2x d-block mb-2"></i>
                                Tambah Kategori
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('transaksi.index') }}" class="btn btn-lg btn-warning w-100">
                                <i class="fas fa-list fa-2x d-block mb-2"></i>
                                Lihat Transaksi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection