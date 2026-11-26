@extends('layouts.app', ['title' => 'Webinar Management'])

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">Daftar Webinar (Chapters)</h4>
                        <p class="text-muted small mb-0">Kelola chapter webinar, jadwal episode materi, harga, dan pembicara</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.webinar.registrations') }}" class="btn btn-outline-primary btn-sm mr-2">
                            <i class="mdi mdi-account-group mr-1"></i> Data Transaksi Peserta
                        </a>
                        <a href="{{ route('admin.webinar.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus mr-1"></i> Buat Webinar Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>Chapter</th>
                                    <th>Judul Webinar</th>
                                    <th>Pembicara Utama</th>
                                    <th>Jumlah Episode</th>
                                    <th>Harga All-Access</th>
                                    <th>Total Peserta</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($webinars as $w)
                                <tr>
                                    <td>
                                        <span class="badge badge-primary px-3 py-2">Chapter {{ $w->chapter_number }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $w->title }}</strong>
                                        <div class="text-muted small text-truncate" style="max-width: 320px;">
                                            {{ $w->description }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($w->speaker_photo)
                                                <img src="{{ asset('storage/' . $w->speaker_photo) }}" alt="" class="rounded-circle mr-2" width="36" height="36" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-center mr-2 text-primary font-weight-bold" style="width: 36px; height: 36px;">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-weight-bold">{{ $w->speaker_name }}</div>
                                                <div class="small text-muted">{{ $w->speaker_title }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $w->episodes_count }} Episode</span>
                                    </td>
                                    <td>
                                        <strong class="text-primary">Rp {{ number_format($w->all_access_price, 0, ',', '.') }}</strong>
                                        @if($w->all_access_original_price)
                                        <div class="small text-muted text-decoration-line-through">
                                            <strike>Rp {{ number_format($w->all_access_original_price, 0, ',', '.') }}</strike>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $w->registrations_count }} Pendaftar</span>
                                    </td>
                                    <td>
                                        @if($w->status === 'active')
                                            <span class="badge badge-success">Aktif</span>
                                        @elseif($w->status === 'draft')
                                            <span class="badge badge-warning">Draft</span>
                                        @else
                                            <span class="badge badge-danger">Tutup</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.webinar.edit', $w->id) }}" class="btn btn-warning btn-sm" title="Kelola Episode & Edit">
                                            <i class="fa fa-pencil"></i> Kelola
                                        </a>
                                        <form action="{{ route('admin.webinar.destroy', $w->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus webinar ini beserta seluruh episodenya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="mdi mdi-video-off mdi-48px d-block mb-2"></i>
                                        Belum ada webinar yang dibuat. Silakan klik tombol "Buat Webinar Baru".
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $webinars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

