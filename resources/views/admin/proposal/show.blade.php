@extends('layouts.app', ['title' => 'Detail Proposal'])

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

    <div class="row">
        <!-- SIDEBAR INFO CARD -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge {{ $proposal->status_badge['class'] }} px-3 py-1">
                            {{ $proposal->status_badge['label'] }}
                        </span>
                        <span class="badge badge-outline-secondary text-uppercase" style="font-size: 11px;">
                            {{ $proposal->source === 'web_lead' ? 'Web Lead' : 'Input Manual' }}
                        </span>
                    </div>

                    <h4 class="font-weight-bold text-dark mb-1">{{ $proposal->school_name }}</h4>
                    <p class="text-muted small mb-3">
                        <i class="mdi mdi-map-marker text-danger"></i> {{ $proposal->city ?: 'Jawa Barat' }} &bull; {{ strtoupper($proposal->institution_type) }}
                    </p>

                    <ul class="list-group list-group-flush small mb-4">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Nomor Surat:</span>
                            <strong>{{ $proposal->proposal_number ?: '-' }}</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Nama PIC:</span>
                            <strong>{{ $proposal->pic_name }}</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Jabatan PIC:</span>
                            <span>{{ $proposal->pic_title ?: '-' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">WhatsApp:</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $proposal->pic_phone) }}" target="_blank" class="text-success font-weight-bold">
                                {{ $proposal->pic_phone }}
                            </a>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Email:</span>
                            <a href="mailto:{{ $proposal->pic_email }}" class="text-primary">
                                {{ $proposal->pic_email }}
                            </a>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Paket Pilihan:</span>
                            <strong class="text-info">{{ $proposal->package_label }}</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Estimasi Peserta:</span>
                            <strong>{{ number_format($proposal->estimated_participants) }} Orang</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Harga / Peserta:</span>
                            <strong>Rp {{ number_format($proposal->price_per_participant, 0, ',', '.') }}</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Total Anggaran:</span>
                            <strong class="text-primary font-weight-bold" style="font-size: 13px;">
                                Rp {{ number_format($proposal->total_estimated_budget, 0, ',', '.') }}
                            </strong>
                        </li>
                        @if($proposal->sent_at)
                        <li class="list-group-item px-0 d-flex justify-content-between bg-light p-2 rounded mt-2">
                            <span class="text-success small"><i class="mdi mdi-check-all"></i> Terkirim:</span>
                            <strong class="text-success small">{{ $proposal->sent_at->format('d M Y H:i') }}</strong>
                        </li>
                        @endif
                    </ul>

                    <!-- ACTION BUTTONS -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.proposal.download-pdf', $proposal->id) }}" class="btn btn-success btn-block mb-2 shadow-sm font-weight-bold">
                            <i class="mdi mdi-download mr-1"></i> Download Laporan (PDF)
                        </a>
                        <a href="{{ route('admin.proposal.preview-pdf', $proposal->id) }}" target="_blank" class="btn btn-outline-danger btn-block mb-2">
                            <i class="mdi mdi-file-pdf-box mr-1"></i> Buka Preview PDF
                        </a>
                        <a href="{{ route('admin.proposal.edit', $proposal->id) }}" class="btn btn-primary btn-block mb-2">
                            <i class="mdi mdi-pencil mr-1"></i> Edit Konten Proposal
                        </a>

                        <form action="{{ route('admin.proposal.generate-ai', $proposal->id) }}" method="POST" class="mb-2" onsubmit="return confirm('Regenerate konten proposal dengan AI?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning btn-block">
                                <i class="mdi mdi-robot mr-1"></i> Regenerate AI Gemini
                            </button>
                        </form>

                        <form action="{{ route('admin.proposal.send-email', $proposal->id) }}" method="POST" onsubmit="return confirm('Kirimkan file PDF proposal resmi ke email {{ $proposal->pic_email }}?')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block shadow-sm">
                                <i class="mdi mdi-send mr-1"></i> Kirim ke Email PIC Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT PREVIEW CARD -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <h5 class="card-title font-weight-bold text-dark mb-0">
                            <i class="mdi mdi-text-box-search-outline text-primary mr-1"></i> Preview Naskah Proposal Resmi
                        </h5>
                        <div>
                            <a href="{{ route('admin.proposal.download-pdf', $proposal->id) }}" class="btn btn-outline-success btn-sm btn-rounded mr-2" title="Download Laporan Proposal (PDF)">
                                <i class="mdi mdi-download mr-1"></i> Download Laporan
                            </a>
                            <a href="{{ route('admin.proposal.index') }}" class="btn btn-outline-secondary btn-sm btn-rounded">
                                <i class="mdi mdi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    @if(empty($content))
                        <div class="text-center py-5 text-muted">
                            <i class="mdi mdi-robot-confused" style="font-size: 48px; color: #94A3B8;"></i>
                            <h5 class="mt-2">Proposal Belum Di-generate</h5>
                            <p class="small">Klik tombol di bawah untuk membuat draf naskah proposal secara instan menggunakan AI.</p>
                            <form action="{{ route('admin.proposal.generate-ai', $proposal->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-rounded shadow-sm">
                                    <i class="mdi mdi-robot mr-1"></i> Generate Proposal Sekarang
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- PREVIEW ACCORDION -->
                        <div class="proposal-preview-wrapper p-4 bg-light rounded border mb-4">
                            <!-- HEADER -->
                            <div class="border-bottom pb-3 mb-3">
                                <div class="text-muted small">No: {{ $content['nomor_surat'] ?? $proposal->proposal_number }}</div>
                                <h5 class="text-primary font-weight-bold mt-1 mb-1">{{ $content['perihal'] ?? 'Penawaran Kerja Sama Asesmen' }}</h5>
                                <div class="small">Tujuan: <strong>{{ $content['tujuan_surat']['nama_pic'] ?? $proposal->pic_name }}</strong> ({{ $content['tujuan_surat']['institusi'] ?? $proposal->school_name }})</div>
                            </div>

                            <!-- SURAT PENGANTAR -->
                            <div class="mb-4">
                                <h6 class="text-dark font-weight-bold">Surat Pengantar:</h6>
                                <p class="text-muted small" style="white-space: pre-line;">{{ $content['surat_pengantar'] ?? '' }}</p>
                            </div>

                            <!-- RINGKASAN EKSEKUTIF -->
                            <div class="mb-4">
                                <h6 class="text-dark font-weight-bold">Ringkasan Eksekutif:</h6>
                                <p class="text-muted small">{{ $content['ringkasan_eksekutif'] ?? '' }}</p>
                            </div>

                            <!-- LATAR BELAKANG -->
                            <div class="mb-4">
                                <h6 class="text-dark font-weight-bold">Latar Belakang:</h6>
                                <p class="text-muted small">{{ $content['latar_belakang'] ?? '' }}</p>
                            </div>

                            <!-- BATERAI TES -->
                            <div class="mb-4">
                                <h6 class="text-dark font-weight-bold">Baterai Tes yang Diberikan:</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered bg-white small mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Nama Modul</th>
                                                <th>Aspek Diukur</th>
                                                <th>Manfaat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($content['baterai_tes'] ?? [] as $tes)
                                            <tr>
                                                <td><strong>{{ $tes['nama_modul'] }}</strong></td>
                                                <td>{{ $tes['aspek_diukur'] }}</td>
                                                <td>{{ $tes['manfaat_untuk_siswa_guru'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- SKEMA INVESTASI -->
                            <div class="mb-4">
                                <h6 class="text-dark font-weight-bold">Skema Investasi:</h6>
                                <div class="bg-white p-3 rounded border small">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div>Paket: <strong>{{ $content['skema_investasi']['nama_paket'] ?? 'Advance Package' }}</strong></div>
                                            <div>Harga: <strong>Rp {{ number_format($content['skema_investasi']['harga_per_peserta'] ?? $proposal->price_per_participant, 0, ',', '.') }}</strong> / siswa</div>
                                            <div>Peserta: <strong>{{ $content['skema_investasi']['jumlah_peserta'] ?? $proposal->estimated_participants }} Siswa</strong></div>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <div class="text-muted">Total Nilai Penawaran:</div>
                                            <h4 class="text-success font-weight-bold mb-0">
                                                Rp {{ number_format($content['skema_investasi']['total_investasi'] ?? $proposal->total_estimated_budget, 0, ',', '.') }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-muted border-top pt-2" style="font-size: 11px;">
                                        <strong>Dasar Anggaran:</strong> {{ $content['skema_investasi']['dasar_anggaran_bos_siplah'] ?? 'Dana BOS & SIPLah' }}
                                    </div>
                                </div>
                            </div>

                            <!-- JADWAL METODE -->
                            <div class="mb-3">
                                <h6 class="text-dark font-weight-bold">Tahapan Pelaksanaan:</h6>
                                <ul class="small text-muted pl-3 mb-0">
                                    @foreach($content['metode_dan_jadwal'] ?? [] as $jadwal)
                                        <li><strong>{{ $jadwal['tahap'] }}</strong>: {{ $jadwal['kegiatan'] }} ({{ $jadwal['durasi'] }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- LIVE PDF IFRAME PREVIEW -->
                        <div class="border rounded overflow-hidden">
                            <div class="bg-light p-2 border-bottom d-flex justify-content-between align-items-center">
                                <span class="small font-weight-bold text-dark"><i class="mdi mdi-file-pdf"></i> Dokumen PDF Siap Kirim</span>
                                <a href="{{ route('admin.proposal.preview-pdf', $proposal->id) }}?download=1" class="btn btn-xs btn-outline-primary">
                                    <i class="mdi mdi-download"></i> Download PDF
                                </a>
                            </div>
                            <iframe src="{{ route('admin.proposal.preview-pdf', $proposal->id) }}" style="width: 100%; height: 500px; border: none;"></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
