@extends('layouts.app')

@section('title', 'Data Transaksi')
@section('page-title', 'Data Transaksi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Daftar Transaksi</h5>
        <a href="{{ route('transaksi.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus me-1"></i>Transaksi Baru
        </a>
    </div>
    <div class="card-body">
        @if($transaksis->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Jumlah Item</th>
                        <th class="text-end">Total Bayar</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $index => $transaksi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $transaksi->tanggal_transaksi ? $transaksi->tanggal_transaksi->format('d/m/Y') : $transaksi->created_at->format('d/m/Y') }}</strong><br>
                            <small class="text-muted">{{ $transaksi->tanggal_transaksi ? $transaksi->tanggal_transaksi->format('H:i') : $transaksi->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $transaksi->user->name }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $transaksi->detailTransaksi->count() }} Item</span>
                        </td>
                        <td class="text-end">
                            <strong class="text-success">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</strong>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('transaksi.print', $transaksi->id) }}" class="btn btn-sm btn-success" title="Print" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                                <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok akan dikembalikan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <th colspan="4" class="text-end">Total Pendapatan:</th>
                        <th class="text-end">
                            <strong class="text-success">Rp {{ number_format($transaksis->sum('total_bayar'), 0, ',', '.') }}</strong>
                        </th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada transaksi</h5>
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i>Buat Transaksi Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection