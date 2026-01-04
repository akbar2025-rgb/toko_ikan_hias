@extends('layouts.app')

@section('title', 'Data Ikan')
@section('page-title', 'Data Ikan Hias')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-fish me-2"></i>Daftar Ikan Hias</h5>
        <a href="{{ route('ikan.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Ikan
        </a>
    </div>
    <div class="card-body">
        @if($ikans->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="8%">Foto</th>
                        <th>Nama Ikan</th>
                        <th>Kategori</th>
                        <th>Ukuran</th>
                        <th class="text-end">Harga Beli</th>
                        <th class="text-end">Harga Jual</th>
                        <th class="text-center">Stok</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ikans as $index => $ikan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($ikan->foto)
                            <img src="{{ asset('storage/'.$ikan->foto) }}" alt="{{ $ikan->nama_ikan }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-fish text-white"></i>
                            </div>
                            @endif
                        </td>
                        <td><strong>{{ $ikan->nama_ikan }}</strong></td>
                        <td><span class="badge bg-info">{{ $ikan->kategori->nama_kategori }}</span></td>
                        <td><small>{{ $ikan->ukuran }}</small></td>
                        <td class="text-end">Rp {{ number_format($ikan->harga_beli, 0, ',', '.') }}</td>
                        <td class="text-end"><strong>Rp {{ number_format($ikan->harga_jual, 0, ',', '.') }}</strong></td>
                        <td class="text-center">
                            @if($ikan->stok < 10)
                            <span class="badge bg-danger">{{ $ikan->stok }}</span>
                            @else
                            <span class="badge bg-success">{{ $ikan->stok }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('ikan.show', $ikan->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('ikan.edit', $ikan->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('ikan.destroy', $ikan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus ikan ini?')">
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
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada data ikan</h5>
            <a href="{{ route('ikan.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i>Tambah Ikan Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection