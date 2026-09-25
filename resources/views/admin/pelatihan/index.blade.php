@extends('layouts.app', ['title' => 'Pelatihan'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between align-items-center mb-4">
                        <div class="col-sm-6">
                            <h4 class="card-title mb-0">Daftar Pelatihan</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.pelatihan.create') }}" class="btn btn-primary btn-rounded">
                                <span class="btn-icon-left text-primary"><i class="fa-solid fa-plus"></i></span>Tambah Pelatihan
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pelatihan</th>
                                    <th>Batch</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th>Peserta</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelatihans as $i => $p)
                                <tr>
                                    <td>{{ $pelatihans->firstItem() + $i }}</td>
                                    <td>
                                        <strong>{{ $p->title }}</strong>
                                        @if($p->location)
                                        <div class="text-muted small">{{ $p->location }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $p->batch ?? '-' }}</td>
                                    <td class="small">
                                        @if($p->start_date)
                                            {{ \Carbon\Carbon::parse($p->start_date)->format('d M Y') }}
                                            @if($p->end_date) – {{ \Carbon\Carbon::parse($p->end_date)->format('d M Y') }} @endif
                                        @else -
                                        @endif
                                    </td>
                                    <td>Rp{{ number_format($p->price, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.pelatihan.participant.index', $p->id) }}" class="badge badge-primary">
                                            {{ $p->participants_count }} Peserta
                                        </a>
                                        @if($p->quota !== null)
                                        <span class="badge {{ $p->quota_remaining <= 0 ? 'badge-danger' : 'badge-light' }}">
                                            Kuota: {{ $p->quota_remaining }}/{{ $p->quota }}
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $p->status === 'active' ? 'success' : ($p->status === 'closed' ? 'danger' : 'warning') }}">
                                            {{ $p->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="{{ route('admin.pelatihan.edit', $p->id) }}" class="badge badge-warning mr-1">Edit</a>
                                            <a href="{{ route('admin.pelatihan.participant.index', $p->id) }}" class="badge badge-info mr-1">Peserta</a>
                                            <a href="{{ route('admin.pelatihan.referral.index', $p->id) }}" class="badge badge-secondary mr-1">Referral</a>
                                            <a href="{{ route('admin.pelatihan.bundle.index', $p->id) }}" class="badge badge-dark mr-1">Bundling</a>
                                            <button class="badge badge-danger btn-delete border-0" data-id="{{ $p->id }}">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Belum ada data pelatihan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $pelatihans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-delete').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = this.dataset.id;
        var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");
        Swal.fire({
            title: 'APAKAH KAMU YAKIN ?',
            text: "INGIN MENGHAPUS PELATIHAN INI!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'BATAL',
            confirmButtonText: 'YA, HAPUS!',
        }).then(function(result) {
            if (result.isConfirmed) {
                jQuery.ajax({
                    url: '/admin/pelatihan/' + id,
                    data: { "_token": token, "_method": "DELETE" },
                    type: 'POST',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({ icon: 'success', title: 'BERHASIL!', text: 'DATA BERHASIL DIHAPUS!', showConfirmButton: false, timer: 2000 })
                                .then(function() { location.reload(); });
                        }
                    }
                });
            }
        });
    });
});
</script>
@endsection
