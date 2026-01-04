@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('page-title', 'Transaksi Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Form Transaksi Penjualan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST" id="formTransaksi">
            @csrf
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6><i class="fas fa-user me-2"></i>Kasir</h6>
                            <p class="mb-0"><strong>{{ auth()->user()->name }}</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6><i class="fas fa-calendar me-2"></i>Tanggal Transaksi</h6>
                            <p class="mb-0"><strong>{{ now()->format('d/m/Y H:i') }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-fish me-2"></i>Pilih Ikan</h6>
                </div>
                <div class="card-body">
                    <div id="itemContainer">
                        <div class="row mb-3 item-row">
                            <div class="col-md-6">
                                <label class="form-label">Pilih Ikan</label>
                                <select name="ikan_id[]" class="form-select ikan-select" required>
                                    <option value="">-- Pilih Ikan --</option>
                                    @foreach($ikans as $ikan)
                                    <option value="{{ $ikan->id }}" data-harga="{{ $ikan->harga_jual }}" data-stok="{{ $ikan->stok }}">
                                        {{ $ikan->nama_ikan }} - {{ $ikan->kategori->nama_kategori }} (Stok: {{ $ikan->stok }}) - Rp {{ number_format($ikan->harga_jual, 0, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" value="1" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Subtotal</label>
                                <input type="text" class="form-control subtotal-display" readonly value="Rp 0">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-danger w-100 remove-item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-success" id="addItem">
                        <i class="fas fa-plus me-2"></i>Tambah Item
                    </button>
                </div>
            </div>

            <div class="card bg-light mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 text-end">
                            <h4>Total Bayar:</h4>
                        </div>
                        <div class="col-md-4 text-end">
                            <h3 class="text-success" id="totalBayar">Rp 0</h3>
                            <input type="hidden" name="total_bayar" id="totalBayarInput" value="0">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-check me-2"></i>Proses Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

@endsection