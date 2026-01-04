@extends('layouts.app')

@section('title', 'Detail Kategori')
@section('page-title', 'Detail Kategori Ikan')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Kategori</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Nama Kategori</strong></td>
                        <td>:</td>
                        <td>{{ $kategori->nama_kategori }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Ikan</strong></td>
                        <td>:</td>
                        <td><span class="badge bg-primary">{{ $kategori->ikan->count() }} Ikan</span></td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat</strong></td>
                        <td>:</td>
                        <td>{{ $kategori->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diupdate</strong></td>
                        <td>:</td>
                        <td>{{ $kategori->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                <hr>

                <div class="mb-3">
                    <strong>Deskripsi:</strong>
                    <p class="mt-2">{{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Kategori
                    </a>
                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>Hapus Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-fish me-2"></i>Daftar Ikan di Kategori Ini</h5>
                <a href="{{ route('ikan.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>Tambah Ikan
                </a>
            </div>
            <div class="card-body">
                @if($kategori->ikan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Foto</th>
                                <th>Nama Ikan</th>
                                <th>Ukuran</th>
                                <th class="text-end">Harga Jual</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategori->ikan as $index => $ikan)
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
                                <td><small>{{ $ikan->ukuran }}</small></td>
                                <td class="text-end">Rp {{ number_format($ikan->harga_jual, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($ikan->stok < 10)
                                    <span class="badge bg-danger">{{ $ikan->stok }}</span>
                                    @else
                                    <span class="badge bg-success">{{ $ikan->stok }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('ikan.show', $ikan->id) }}" class="btn btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('ikan.edit', $ikan->id) }}" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
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
                    <h5 class="text-muted">Belum ada ikan di kategori ini</h5>
                    <a href="{{ route('ikan.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Tambah Ikan Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection