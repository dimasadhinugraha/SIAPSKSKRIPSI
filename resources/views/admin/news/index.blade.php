@extends('layouts.app-bootstrap')

@section('title', 'Manajemen Berita')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0 text-white"><i class="fas fa-newspaper me-2"></i>Manajemen Berita</h1>
                    <p class="mb-0 small">Kelola berita dan informasi desa</p>
                </div>
                <a href="{{ route('admin.news.create') }}" class="btn btn-light">
                    <i class="fas fa-plus me-2"></i>Tambah Berita
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <i class="fas fa-newspaper fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Total Pengajuan</p>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded p-3">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Menunggu Review</p>
                            <h3 class="mb-0">{{ $stats['draft'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Disetujui</p>
                            <h3 class="mb-0">{{ $stats['published'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded p-3">
                                <i class="fas fa-calendar-day fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Hari Ini</p>
                            <h3 class="mb-0">{{ $stats['today'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Daftar Berita (Total: {{ $news->total() }})</h5>
        </div>
        <div class="card-body">
            @if($news->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Penulis</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->featured_image)
                                                <img src="{{ Storage::url($item->featured_image) }}" alt="{{ $item->title }}" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <span class="fw-bold">{{ $item->title }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $categoryColors = [
                                                'news' => 'bg-primary',
                                                'announcement' => 'bg-info text-dark',
                                                'event' => 'bg-success',
                                            ];
                                            $categoryLabels = [
                                                'news' => 'Berita',
                                                'announcement' => 'Pengumuman',
                                                'event' => 'Kegiatan',
                                            ];
                                        @endphp
                                        <span class="badge rounded-pill {{ $categoryColors[$item->category] ?? 'bg-secondary' }}">
                                            {{ $categoryLabels[$item->category] ?? ucfirst($item->category) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill {{ $item->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $item->status === 'published' ? 'Dipublikasi' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td>{{ $item->author->name }}</td>
                                    <td class="text-muted small">
                                        {{ ($item->published_at ?? $item->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            @if($item->status === 'published')
                                                <a href="{{ route('news.show', $item) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.news.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
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
                @if($news->hasPages())
                    <div class="mt-3">
                        {{ $news->links() }}
                    </div>
                @endif
            @else
                <div class="text-center p-5">
                    <i class="fas fa-newspaper display-4 text-muted mb-3"></i>
                    <h4 class="mb-2">Belum ada berita</h4>
                    <p class="text-muted mb-3">Mulai dengan membuat berita pertama.</p>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                       <i class="fas fa-plus me-2"></i> Tambah Berita
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection