@extends('layouts.app', ['title' => 'Daftar Proposal'])

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-alert-circle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- STATS CARDS -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Total Proposal</h6>
                        <h3 class="mb-0 font-weight-bold text-dark">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="mdi mdi-file-document-multiple text-white" style="font-size: 22px;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Menunggu Generate</h6>
                        <h3 class="mb-0 font-weight-bold text-warning">{{ $stats['pending'] }}</h3>
                    </div>
                    <div class="bg-warning text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="mdi mdi-clock-outline text-white" style="font-size: 22px;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Draf AI Siap</h6>
                        <h3 class="mb-0 font-weight-bold text-info">{{ $stats['draft'] }}</h3>
                    </div>
                    <div class="bg-info text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="mdi mdi-robot text-white" style="font-size: 22px;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Terkirim ke Email</h6>
                        <h3 class="mb-0 font-weight-bold text-success">{{ $stats['sent'] }}</h3>
                    </div>
                    <div class="bg-success text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="mdi mdi-email-check text-white" style="font-size: 22px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CARD TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="card-title mb-1 font-weight-bold text-dark">Daftar Permohonan &amp; Generator Proposal</h4>
                    <p class="text-muted small mb-0">Kelola pengajuan proposal dari Web Landing Page atau buat penawaran baru secara manual.</p>
                </div>
                <div class="mt-2 mt-md-0 d-flex gap-2">
                    <a href="{{ route('admin.proposal.export-report', request()->query()) }}" class="btn btn-outline-success btn-rounded shadow-sm mr-2" title="Download Rekap Seluruh Data Proposal (Excel/CSV)">
                        <i class="mdi mdi-file-excel mr-1"></i> Download Rekap Laporan
                    </a>
                    <a href="{{ route('admin.proposal.create') }}" class="btn btn-primary btn-rounded shadow-sm">
                        <i class="mdi mdi-plus-circle mr-1"></i> + Buat Proposal Baru
                    </a>
                </div>
            </div>

            <!-- FILTER & SEARCH -->
            <form method="GET" action="{{ route('admin.proposal.index') }}" class="mb-4">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5 mb-2 mb-md-0">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama sekolah, PIC, nomor surat..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Semua Status --</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Generate</option>
                            <option value="draft_generated" {{ request('status') == 'draft_generated' ? 'selected' : '' }}>Draf AI Siap</option>
                            <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Sudah Direview</option>
                            <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Terkirim</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <select name="source" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Semua Sumber --</option>
                            <option value="web_lead" {{ request('source') == 'web_lead' ? 'selected' : '' }}>Web Landing Page</option>
                            <option value="admin_manual" {{ request('source') == 'admin_manual' ? 'selected' : '' }}>Input Manual Admin</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        @if(request('search') || request('status') || request('source'))
                            <a href="{{ route('admin.proposal.index') }}" class="btn btn-outline-secondary btn-block" title="Reset filter">
                                <i class="mdi mdi-refresh"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 25%;">Institusi &amp; PIC</th>
                            <th style="width: 18%;">Kontak PIC</th>
                            <th style="width: 18%;">Paket &amp; Peserta</th>
                            <th style="width: 14%;">Status &amp; Sumber</th>
                            <th style="width: 20%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proposals as $idx => $p)
                        <tr>
                            <td>{{ $proposals->firstItem() + $idx }}</td>
                            <td>
                                <strong class="text-dark d-block" style="font-size: 14px;">{{ $p->school_name }}</strong>
                                <span class="badge badge-light border text-secondary mr-1">{{ strtoupper($p->institution_type) }}</span>
                                @if($p->city)<span class="text-muted small"><i class="mdi mdi-map-marker"></i> {{ $p->city }}</span>@endif
                                <div class="mt-1 small">
                                    <i class="mdi mdi-account text-primary"></i> <strong>{{ $p->pic_name }}</strong> 
                                    @if($p->pic_title)<span class="text-muted">({{ $p->pic_title }})</span>@endif
                                </div>
                                <small class="text-muted d-block mt-1">No: {{ $p->proposal_number ?? '-' }}</small>
                            </td>
                            <td>
                                <div><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->pic_phone) }}" target="_blank" class="text-success small font-weight-bold"><i class="mdi mdi-whatsapp"></i> {{ $p->pic_phone }}</a></div>
                                <div><a href="mailto:{{ $p->pic_email }}" class="text-muted small"><i class="mdi mdi-email-outline"></i> {{ $p->pic_email }}</a></div>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $p->package_label }}</span>
                                <div class="small mt-1 text-dark">
                                    <strong>{{ number_format($p->estimated_participants) }}</strong> Peserta
                                </div>
                                <div class="small text-muted">
                                    @ Rp {{ number_format($p->price_per_participant, 0, ',', '.') }}
                                </div>
                                <div class="small font-weight-bold text-primary">
                                    Total: Rp {{ number_format($p->total_estimated_budget, 0, ',', '.') }}
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $p->status_badge['class'] }} d-block py-1 mb-1">
                                    {{ $p->status_badge['label'] }}
                                </span>
                                @if($p->source === 'web_lead')
                                    <span class="badge badge-outline-primary" style="font-size: 10px;"><i class="mdi mdi-web"></i> Web Lead</span>
                                @else
                                    <span class="badge badge-outline-secondary" style="font-size: 10px;"><i class="mdi mdi-account-cog"></i> Manual Admin</span>
                                @endif
                                <div class="text-muted" style="font-size: 10px; margin-top: 2px;">
                                    {{ $p->created_at->format('d M Y H:i') }}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm mb-1" role="group">
                                    <!-- PREVIEW / WORKSPACE -->
                                    <a href="{{ route('admin.proposal.show', $p->id) }}" class="btn btn-outline-info" title="Lihat Detail & Preview">
                                        <i class="mdi mdi-eye"></i>
                                    </a>

                                    <!-- EDIT WORKSPACE -->
                                    <a href="{{ route('admin.proposal.edit', $p->id) }}" class="btn btn-outline-primary" title="Edit Isi Konten Proposal">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>

                                    <!-- PREVIEW PDF -->
                                    <a href="{{ route('admin.proposal.preview-pdf', $p->id) }}" target="_blank" class="btn btn-outline-danger" title="Buka Preview PDF">
                                        <i class="mdi mdi-file-pdf-box"></i>
                                    </a>

                                    <!-- DOWNLOAD LAPORAN (PDF) -->
                                    <a href="{{ route('admin.proposal.download-pdf', $p->id) }}" class="btn btn-outline-success" title="Download Laporan (PDF)">
                                        <i class="mdi mdi-download"></i>
                                    </a>
                                </div>

                                <div class="d-flex justify-content-center align-items-center mt-1">
                                    <!-- GENERATE AI BUTTON -->
                                    <form action="{{ route('admin.proposal.generate-ai', $p->id) }}" method="POST" class="d-inline mr-1" onsubmit="return confirm('Generate / perbarui naskah proposal dengan AI?')">
                                        @csrf
                                        <button type="submit" class="btn btn-xs btn-outline-warning" title="Generate AI Gemini">
                                            <i class="mdi mdi-robot mr-1"></i> AI
                                        </button>
                                    </form>

                                    <!-- SEND EMAIL BUTTON -->
                                    <form action="{{ route('admin.proposal.send-email', $p->id) }}" method="POST" class="d-inline mr-1" onsubmit="return confirm('Kirim dokumen PDF proposal resmi ke email {{ $p->pic_email }}?')">
                                        @csrf
                                        <button type="submit" class="btn btn-xs btn-success" title="Kirim ke Email PIC">
                                            <i class="mdi mdi-send"></i> Kirim
                                        </button>
                                    </form>

                                    <!-- DELETE BUTTON -->
                                    <form action="{{ route('admin.proposal.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus proposal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="mdi mdi-file-outline d-block mb-2" style="font-size: 42px; color: #CBD5E1;"></i>
                                <h6>Belum ada pengajuan proposal.</h6>
                                <p class="small mb-3">Klik tombol di bawah untuk membuat penawaran baru secara manual.</p>
                                <a href="{{ route('admin.proposal.create') }}" class="btn btn-primary btn-sm btn-rounded">
                                    <i class="mdi mdi-plus"></i> + Buat Proposal Baru
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <span class="small text-muted">Menampilkan {{ $proposals->firstItem() ?? 0 }} - {{ $proposals->lastItem() ?? 0 }} dari {{ $proposals->total() }} proposal</span>
                {{ $proposals->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
