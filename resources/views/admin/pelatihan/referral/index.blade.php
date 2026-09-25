@extends('layouts.app', ['title' => 'Kode Referral - ' . $pelatihan->title])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="card-title mb-0">Kode Referral</h5>
                            <small class="text-muted">{{ $pelatihan->title }} {{ $pelatihan->batch ? '- ' . $pelatihan->batch : '' }}</small>
                        </div>
                        <div>
                            <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-secondary btn-rounded btn-sm mr-2">
                                <i class="fa-solid fa-arrow-left mr-1"></i>Kembali
                            </a>
                            <a href="{{ route('admin.pelatihan.referral.create', $pelatihan->id) }}" class="btn btn-primary btn-rounded btn-sm">
                                <i class="fa-solid fa-plus mr-1"></i>Tambah Kode
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Nama Mitra/PIC</th>
                                    <th>Diskon</th>
                                    <th>Penggunaan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($referrals as $i => $r)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><strong class="text-primary">{{ $r->code }}</strong></td>
                                    <td>{{ $r->partner_name ?? '-' }}</td>
                                    <td>
                                        @if($r->discount_type === 'percent')
                                            {{ $r->discount_value }}%
                                        @else
                                            Rp{{ number_format($r->discount_value, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $r->used_count }} / {{ $r->max_usage ?? '∞' }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $r->is_active ? 'success' : 'secondary' }}">
                                            {{ $r->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pelatihan.referral.edit', [$pelatihan->id, $r->id]) }}" class="badge badge-warning mr-1">Edit</a>
                                        <button class="badge badge-danger border-0 btn-delete-referral" data-id="{{ $r->id }}">Hapus</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada kode referral.</td>
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

<script>
document.querySelectorAll('.btn-delete-referral').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = this.dataset.id;
        var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");
        Swal.fire({ title: 'Hapus kode ini?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' })
        .then(function(result) {
            if (result.isConfirmed) {
                jQuery.ajax({
                    url: '/admin/pelatihan/{{ $pelatihan->id }}/referral/' + id,
                    data: { "_token": token, "_method": "DELETE" },
                    type: 'POST',
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({ icon: 'success', title: 'Berhasil!', showConfirmButton: false, timer: 1500 }).then(function() { location.reload(); });
                        }
                    }
                });
            }
        });
    });
});
</script>
@endsection
