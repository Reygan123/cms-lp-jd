@extends('layouts.app', ['title' => 'Data Transaksi & Pendaftar Webinar'])

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
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h2 class="text-white">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</h2>
                            <span class="text-white">Total Omset Lunas</span>
                        </div>
                        <i class="mdi mdi-cash-multiple mdi-48px text-white opacity-5"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h2 class="text-white">{{ $stats['total'] }}</h2>
                            <span class="text-white">Total Pendaftar</span>
                        </div>
                        <i class="mdi mdi-account-group mdi-48px text-white opacity-5"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h2 class="text-white">{{ $stats['paid'] }}</h2>
                            <span class="text-white">Status Lunas (PAID)</span>
                        </div>
                        <i class="mdi mdi-check-circle-outline mdi-48px text-white opacity-5"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h2 class="text-white">{{ $stats['pending'] }}</h2>
                            <span class="text-white">Menunggu Pembayaran</span>
                        </div>
                        <i class="mdi mdi-clock-outline mdi-48px text-white opacity-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div>
                        <h4 class="card-title mb-0">Daftar Pendaftar & Transaksi Webinar</h4>
                        <p class="text-muted small mb-0">Pantau bukti follow Instagram tiket gratis dan verifikasi pembayaran Duitku</p>
                    </div>
                    <a href="{{ route('admin.webinar.index') }}" class="btn btn-secondary btn-sm mt-2 mt-md-0">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali ke Webinar
                    </a>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.webinar.registrations') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama, whatsapp, email, order ID..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <select name="status" class="form-control">
                                    <option value="ALL">Semua Status</option>
                                    <option value="PAID" {{ request('status') === 'PAID' ? 'selected' : '' }}>PAID (Lunas)</option>
                                    <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>PENDING (Menunggu)</option>
                                    <option value="EXPIRED" {{ request('status') === 'EXPIRED' ? 'selected' : '' }}>EXPIRED (Kedaluwarsa)</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <select name="episode" class="form-control">
                                    <option value="">Semua Episode</option>
                                    @foreach($episodes as $ep)
                                    <option value="{{ $ep->code }}" {{ request('episode') === $ep->code ? 'selected' : '' }}>{{ $ep->title }}</option>
                                    @endforeach
                                    <option value="all-pass" {{ request('episode') === 'all-pass' ? 'selected' : '' }}>All-Access Pass</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-filter mr-1"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Peserta</th>
                                    <th>Episode</th>
                                    <th>Bukti IG</th>
                                    <th>Nominal</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $r)
                                <tr>
                                    <td>
                                        <span class="font-weight-bold font-monospace">{{ $r->order_id }}</span>
                                        <div class="small text-muted">{{ $r->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $r->full_name }}</div>
                                        <div class="small text-muted">
                                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $r->whatsapp)) }}" target="_blank" class="text-success">
                                                <i class="fa fa-whatsapp"></i> {{ $r->whatsapp }}
                                            </a> • {{ $r->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light">{{ $r->episode_title ?: $r->episode_id }}</span>
                                    </td>
                                    <td>
                                        @if($r->ig_proof_file)
                                            <button type="button" class="btn btn-outline-info btn-xs" data-toggle="modal" data-target="#modalIg{{ $r->id }}">
                                                <i class="fa fa-instagram"></i> @ {{ $r->ig_username ?: 'Lihat Bukti' }}
                                            </button>

                                            <div class="modal fade" id="modalIg{{ $r->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title font-weight-bold">Bukti Follow IG: {{ $r->full_name }} ({{ $r->ig_username }})</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body text-center p-3">
                                                            <img src="{{ $r->ig_proof_file }}" alt="Screenshot IG" class="img-fluid rounded" style="max-height: 500px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($r->total_amount == 0)
                                            <span class="badge badge-success">GRATIS</span>
                                        @else
                                            <strong>Rp {{ number_format($r->total_amount, 0, ',', '.') }}</strong>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $r->payment_channel ?: 'Duitku' }}</span>
                                    </td>
                                    <td>
                                        @if($r->payment_status === 'PAID')
                                            <span class="badge badge-success px-2 py-1"><i class="fa fa-check mr-1"></i> PAID</span>
                                        @elseif($r->payment_status === 'PENDING')
                                            <span class="badge badge-warning px-2 py-1"><i class="fa fa-clock-o mr-1"></i> PENDING</span>
                                        @else
                                            <span class="badge badge-danger px-2 py-1">{{ $r->payment_status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($r->payment_status !== 'PAID')
                                        <form action="{{ route('admin.webinar.registrations.mark-paid', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Verifikasi pembayaran ini sebagai PAID?')">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-xs" title="Tandai Lunas">
                                                <i class="fa fa-check"></i> Lunas
                                            </button>
                                        </form>
                                        @else
                                        <span class="text-success small font-weight-bold"><i class="fa fa-check-circle"></i> Terverifikasi</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        Tidak ada data transaksi yang sesuai filter.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $registrations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

