@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Detail Transaksi #{{ $transaksi->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Informasi Transaksi</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td width="40%">Tanggal</td>
                                <td><strong>{{ $transaksi->tanggal_transaksi ? $transaksi->tanggal_transaksi->format('d/m/Y H:i') : $transaksi->created_at->format('d/m/Y H:i') }}</strong></td>
                            </tr>
                            <tr>
                                <td>Kasir</td>
                                <td><span class="badge bg-secondary">{{ $transaksi->user->name }}</span></td>
                            </tr>
                            <tr>
                                <td>Total Item</td>
                                <td><strong>{{ $transaksi->detailTransaksi->count() }} Item</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <h6 class="text-muted mb-3">Detail Pembelian</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Ikan</th>
                                <th>Kategori</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi->detailTransaksi as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->ikan->nama_ikan }}</td>
                                <td><span class="badge bg-info">{{ $detail->ikan->kategori->nama_kategori }}</span></td>
                                <td class="text-end">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $detail->jumlah }}</td>
                                <td class="text-end"><strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="5" class="text-end">Total Bayar:</th>
                                <th class="text-end">
                                    <h5 class="text-success mb-0">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</h5>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Ringkasan</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Item:</span>
                    <strong>{{ $transaksi->detailTransaksi->sum('jumlah') }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Jenis Ikan:</span>
                    <strong>{{ $transaksi->detailTransaksi->count() }}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span><strong>Total Bayar:</strong></span>
                    <h5 class="text-success mb-0">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Aksi</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('transaksi.print', $transaksi->id) }}" class="btn btn-success w-100 mb-2" target="_blank">
                    <i class="fas fa-print me-2"></i>Cetak Struk
                </a>
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary w-100 mb-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-2"></i>Hapus Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection