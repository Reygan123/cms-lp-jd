@extends('layouts.app', ['title' => 'Edit Konten Proposal'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <div>
                            <h4 class="card-title font-weight-bold text-dark mb-1">
                                <i class="mdi mdi-pencil-box-multiple text-primary mr-1"></i> Edit &amp; Kustomisasi Naskah Proposal
                            </h4>
                            <p class="text-muted small mb-0">Sesuaikan draf naskah hasil AI sebelum dikirimkan secara resmi ke pihak sekolah/institusi.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.proposal.download-pdf', $proposal->id) }}" class="btn btn-outline-success btn-sm mr-2" title="Download file PDF laporan proposal">
                                <i class="mdi mdi-download mr-1"></i> Download Laporan
                            </a>
                            <a href="{{ route('admin.proposal.show', $proposal->id) }}" class="btn btn-outline-info btn-sm mr-2">
                                <i class="mdi mdi-eye mr-1"></i> Lihat Preview
                            </a>
                            <a href="{{ route('admin.proposal.preview-pdf', $proposal->id) }}" target="_blank" class="btn btn-outline-danger btn-sm mr-2">
                                <i class="mdi mdi-file-pdf mr-1"></i> Buka PDF
                            </a>
                            <a href="{{ route('admin.proposal.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="mdi mdi-alert"></i> Periksa kembali data:</strong>
                            <ul class="mb-0 mt-2 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('admin.proposal.update', $proposal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- 1. DATA DASAR / KEPESERTAAN -->
                        <h6 class="text-primary font-weight-bold text-uppercase mb-3" style="font-size: 13px;">
                            <i class="mdi mdi-information-outline mr-1"></i> 1. Informasi Calon Klien &amp; Status
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="text-label font-weight-bold">Nama Institusi / Sekolah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="school_name" value="{{ old('school_name', $proposal->school_name) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="text-label font-weight-bold">Nama PIC &amp; Gelar <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pic_name" value="{{ old('pic_name', $proposal->pic_name) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="text-label font-weight-bold">Jabatan PIC</label>
                                <input type="text" class="form-control" name="pic_title" value="{{ old('pic_title', $proposal->pic_title) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="text-label font-weight-bold">WhatsApp PIC <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pic_phone" value="{{ old('pic_phone', $proposal->pic_phone) }}" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-label font-weight-bold">Email PIC <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="pic_email" value="{{ old('pic_email', $proposal->pic_email) }}" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-label font-weight-bold">Estimasi Peserta</label>
                                <input type="number" class="form-control" name="estimated_participants" value="{{ old('estimated_participants', $proposal->estimated_participants) }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-label font-weight-bold">Harga per Peserta (Rp)</label>
                                <input type="number" class="form-control" name="price_per_participant" value="{{ old('price_per_participant', $proposal->price_per_participant) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="text-label font-weight-bold">Status Dokumen</label>
                                <select class="form-control" name="status">
                                    <option value="pending" {{ $proposal->status == 'pending' ? 'selected' : '' }}>Menunggu Generate AI</option>
                                    <option value="draft_generated" {{ $proposal->status == 'draft_generated' ? 'selected' : '' }}>Draf AI Siap</option>
                                    <option value="reviewed" {{ $proposal->status == 'reviewed' ? 'selected' : '' }}>Sudah Direview Admin (Disetujui)</option>
                                    <option value="sent" {{ $proposal->status == 'sent' ? 'selected' : '' }}>Terkirim ke Email</option>
                                </select>
                            </div>
                        </div>

                        <!-- 2. EDITING KONTEN NASKAH (SURAT & LATAR BELAKANG) -->
                        <h6 class="text-primary font-weight-bold text-uppercase mt-4 mb-3 border-top pt-3" style="font-size: 13px;">
                            <i class="mdi mdi-file-document mr-1"></i> 2. Penyuntingan Isi Dokumen Proposal
                        </h6>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="text-label font-weight-bold">Nomor Surat Proposal</label>
                                <input type="text" class="form-control" name="custom_content[nomor_surat]" value="{{ old('custom_content.nomor_surat', $content['nomor_surat'] ?? $proposal->proposal_number) }}">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="text-label font-weight-bold">Perihal Surat</label>
                                <input type="text" class="form-control" name="custom_content[perihal]" value="{{ old('custom_content.perihal', $content['perihal'] ?? 'Penawaran Kerja Sama Program Asesmen Psikologi Digital') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-label font-weight-bold">Surat Pengantar Resmi</label>
                            <textarea class="form-control" name="custom_content[surat_pengantar]" rows="4">{{ old('custom_content.surat_pengantar', $content['surat_pengantar'] ?? '') }}</textarea>
                            <small class="form-text text-muted">Mencantumkan kalimat pembuka resmi, dasar supervisi psikolog HIMPSI, dan salam hormat.</small>
                        </div>

                        <div class="mb-3">
                            <label class="text-label font-weight-bold">Ringkasan Eksekutif</label>
                            <textarea class="form-control" name="custom_content[ringkasan_eksekutif]" rows="3">{{ old('custom_content.ringkasan_eksekutif', $content['ringkasan_eksekutif'] ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="text-label font-weight-bold">Latar Belakang &amp; Kebutuhan Sekolah</label>
                            <textarea class="form-control" name="custom_content[latar_belakang]" rows="4">{{ old('custom_content.latar_belakang', $content['latar_belakang'] ?? '') }}</textarea>
                            <small class="form-text text-muted">Disesuaikan dengan jenjang (Kurikulum Merdeka untuk SMA, Kesiapan PKL/BMW untuk SMK, atau Seleksi untuk Kampus).</small>
                        </div>

                        <!-- 3. INVESTASI & DASAR ANGGARAN -->
                        <h6 class="text-primary font-weight-bold text-uppercase mt-4 mb-3 border-top pt-3" style="font-size: 13px;">
                            <i class="mdi mdi-cash mr-1"></i> 3. Keterangan Investasi &amp; Dasar Legalitas BOS
                        </h6>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="text-label font-weight-bold">Nama Paket Layanan</label>
                                <input type="text" class="form-control" name="custom_content[skema_investasi][nama_paket]" value="{{ old('custom_content.skema_investasi.nama_paket', $content['skema_investasi']['nama_paket'] ?? 'Advance Package') }}">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="text-label font-weight-bold">Dasar Regulasi Anggaran BOS / SIPLah</label>
                                <textarea class="form-control" name="custom_content[skema_investasi][dasar_anggaran_bos_siplah]" rows="2">{{ old('custom_content.skema_investasi.dasar_anggaran_bos_siplah', $content['skema_investasi']['dasar_anggaran_bos_siplah'] ?? 'Dapat dialokasikan melalui Dana BOS Reguler Permendikbudristek No. 2/2024 dan SIPLah.') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-label font-weight-bold">Kalimat Penutup &amp; Call to Action</label>
                            <textarea class="form-control" name="custom_content[penutup_dan_call_to_action]" rows="3">{{ old('custom_content.penutup_dan_call_to_action', $content['penutup_dan_call_to_action'] ?? '') }}</textarea>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-4">
                            <div>
                                <span class="text-muted small">Perubahan konten akan langsung tersimpan dan tercermin pada file PDF.</span>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                    <i class="mdi mdi-content-save mr-1"></i> Simpan Perubahan Naskah
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
