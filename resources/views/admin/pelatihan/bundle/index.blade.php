@extends('layouts.app', ['title' => 'Paket Bundling - ' . $pelatihan->title])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="card-title mb-0">Paket Bundling</h5>
                            <small class="text-muted">{{ $pelatihan->title }} {{ $pelatihan->batch ? '— ' . $pelatihan->batch : '' }}</small>
                        </div>
                        <div>
                            <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-secondary btn-rounded btn-sm mr-2">
                                <i class="fa-solid fa-arrow-left mr-1"></i>Kembali
                            </a>
                            <a href="{{ route('admin.pelatihan.bundle.create', $pelatihan->id) }}" class="btn btn-primary btn-rounded btn-sm">
                                <i class="fa-solid fa-plus mr-1"></i>Tambah Paket
                            </a>
                        </div>
                    </div>

                    @include('layouts.alert')

                    <p class="text-muted small mb-3">
                        Paket bundling memungkinkan harga khusus untuk pendaftaran kelompok. Contoh: Paket 3 Orang = Rp 2.100.000.
                        Harga satuan per pelatihan: <strong>Rp{{ number_format($pelatihan->price, 0, ',', '.') }}</strong>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Paket</th>
                                    <th>Jumlah Orang</th>
                                    <th>Harga Paket</th>
                                    <th>Harga / Orang</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bundles as $i => $b)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><strong>{{ $b->name }}</strong></td>
                                    <td>{{ $b->person_count }} orang</td>
                                    <td>Rp{{ number_format($b->bundle_price, 0, ',', '.') }}</td>
                                    <td class="text-muted">Rp{{ number_format($b->price_per_person, 0, ',', '.') }}</td>
                                    <td class="small text-muted">{{ $b->description ?? '-' }}</td>
                                    <td>
                                        @if($b->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pelatihan.bundle.edit', [$pelatihan->id, $b->id]) }}" class="btn btn-sm btn-warning btn-rounded">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.pelatihan.bundle.destroy', [$pelatihan->id, $b->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-rounded"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Belum ada paket bundling.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
