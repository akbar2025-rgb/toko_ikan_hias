@extends('layouts.app')

@section('title', 'Data Kategori Ikan')
@section('page-title', 'Data Kategori Ikan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Daftar Kategori Ikan</h5>
        <a href="{{ route('kategori.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Kategori
        </a>
    </div>
    <div class="card-body">
        @if($kategoris->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th width="12%" class="text-center">Jumlah Ikan</th>
                        <th width="12%" class="text-center">Tanggal Dibuat</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $index => $kategori)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $kategori->nama_kategori }}</strong>
                        </td>
                        <td>{{ Str::limit($kategori->deskripsi, 50) }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary">{{ $kategori->ikan_count }} Ikan</span>
                        </td>
                        <td class="text-center">
                            <small class="text-muted">{{ $kategori->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('kategori.show', $kategori->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
            <h5 class="text-muted">Belum ada data kategori</h5>
            <a href="{{ route('kategori.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i>Tambah Kategori Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection