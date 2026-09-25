@extends('layouts.app', ['title' => 'Detail Peserta'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title mb-0">{{ $participant->full_name }}</h5>
                            <small class="text-muted">{{ $participant->registration_code }}</small>
                        </div>
                        <span class="badge badge-{{ $participant->status_badge }} badge-pill" style="font-size:13px;">
                            {{ $participant->status_label }}
                        </span>
                    </div>

                    <h6 class="text-primary border-bottom pb-1 mb-3">Identitas Peserta</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr><td class="text-muted" style="width:40%">Nama Lengkap</td><td><strong>{{ $participant->full_name }}</strong></td></tr>
                                <tr><td class="text-muted">Nama Sertifikat</td><td>{{ $participant->name_for_certificate }}</td></tr>
                                <tr><td class="text-muted">Jenis Kelamin</td><td>{{ $participant->gender ?? '-' }}</td></tr>
                                <tr><td class="text-muted">TTL / Usia</td><td>
                                    {{ $participant->birth_place ?? '-' }}{{ $participant->birth_date ? ', ' . \Carbon\Carbon::parse($participant->birth_date)->format('d/m/Y') : '' }}
                                    @if($participant->age)<span class="badge badge-info ml-1">{{ $participant->age }} th</span>@endif
                                </td></tr>
                                <tr><td class="text-muted">Email</td><td>{{ $participant->email }}</td></tr>
                                <tr><td class="text-muted">WhatsApp</td><td>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $participant->whatsapp) }}" target="_blank">{{ $participant->whatsapp }}</a>
                                </td></tr>
                                <tr><td class="text-muted">Domisili</td><td>{{ $participant->domicile ?? '-' }}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr><td class="text-muted" style="width:40%">Institusi</td><td><strong>{{ $participant->institution_name ?? '-' }}</strong></td></tr>
                                <tr><td class="text-muted">Kota Lembaga</td><td>{{ $participant->institution_city ?? '-' }}</td></tr>
                                <tr><td class="text-muted">Jenjang (Q4)</td><td>
                                    @if($participant->institution_level)
                                        @foreach(explode(', ', $participant->institution_level) as $lvl)
                                            <span class="badge badge-light border text-dark mr-1 mb-1">{{ trim($lvl) }}</span>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td></tr>
                                <tr><td class="text-muted">Jabatan</td><td>{{ $participant->role_in_institution ?? '-' }}</td></tr>
                                <tr><td class="text-muted">Pernah Pelatihan</td><td>{{ $participant->had_previous_training ? 'Pernah' : 'Belum pernah' }}</td></tr>
                                <tr><td class="text-muted">Tipe Daftar</td><td>
                                    {{ $participant->registration_type === 'kolektif' ? 'Kolektif (' . $participant->collective_count . ' orang)' : 'Individu' }}
                                    @if($participant->collective_coordinator)<br><small class="text-muted">Koordinator: {{ $participant->collective_coordinator }}</small>@endif
                                </td></tr>
                            </table>
                        </div>
                    </div>

                    @if($participant->skill_to_improve)
                    <div class="mb-3">
                        <label class="text-muted small">Keterampilan yang ingin diperkuat</label>
                        <p class="mb-0">{{ $participant->skill_to_improve }}</p>
                    </div>
                    @endif

                    <h6 class="text-primary border-bottom pb-1 mb-3">Pembayaran</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr><td class="text-muted">Pengirim</td><td>{{ $participant->payment_sender_name ?? '-' }}</td></tr>
                                <tr><td class="text-muted">Tanggal Bayar</td><td>{{ $participant->payment_date ? \Carbon\Carbon::parse($participant->payment_date)->format('d M Y') : '-' }}</td></tr>
                                <tr><td class="text-muted">Butuh Invoice</td><td>{{ $participant->needs_invoice ? 'Ya (' . ($participant->invoice_name ?? '-') . ')' : 'Tidak' }}</td></tr>
                                @if($participant->bundle_name)
                                <tr><td class="text-muted">Paket Bundling</td><td><span class="badge badge-info">{{ $participant->bundle_name }}</span></td></tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr><td class="text-muted">Harga Awal</td><td>Rp{{ number_format($participant->original_price, 0, ',', '.') }}</td></tr>
                                @if($participant->discount_amount > 0)
                                <tr><td class="text-muted">Diskon</td><td class="text-danger">-Rp{{ number_format($participant->discount_amount, 0, ',', '.') }}</td></tr>
                                @endif
                                <tr><td class="text-muted">Total Bayar</td><td><strong class="text-success">Rp{{ number_format($participant->final_price, 0, ',', '.') }}</strong></td></tr>
                            </table>
                        </div>
                    </div>
                    @if($participant->payment_proof)
                    <a href="{{ asset('storage/payment_proofs/' . $participant->payment_proof) }}" target="_blank" class="btn btn-info btn-sm btn-rounded mb-3">
                        <i class="fa-solid fa-eye mr-1"></i> Lihat Bukti Pembayaran
                    </a>
                    @else
                    <p class="text-muted small">Bukti pembayaran belum diunggah oleh peserta.</p>
                    @endif

                    @if($participant->referral_code)
                    <h6 class="text-primary border-bottom pb-1 mb-2">Referral</h6>
                    <p class="mb-3">Kode: <strong>{{ $participant->referral_code }}</strong>
                        @if($participant->referral_giver_name) | Dari: {{ $participant->referral_giver_name }}@endif
                    </p>
                    @endif

                    @if($participant->answers->count() > 0)
                    <h6 class="text-primary border-bottom pb-1 mb-3">Jawaban Pertanyaan Tambahan</h6>
                    @foreach($participant->answers as $answer)
                    <div class="mb-3">
                        <label class="text-muted small">{{ $answer->question->question ?? 'Pertanyaan' }}</label>
                        <p class="mb-0">{{ $answer->answer ?? '-' }}</p>
                    </div>
                    @endforeach
                    @endif

                    @if($participant->admin_note)
                    <h6 class="text-primary border-bottom pb-1 mb-2">Catatan Admin</h6>
                    <p>{{ $participant->admin_note }}</p>
                    @endif
                </div>
            </div>

            @if($participant->registration_type === 'kolektif' && $participant->subParticipants->count() > 0)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-users mr-1"></i> Daftar Data Lengkap Peserta Kolektif Lembaga ({{ $participant->subParticipants->count() }} orang)</span>
                    <form action="{{ route('admin.pelatihan.participant.send-all-certificates', [$pelatihan->id, $participant->id]) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary btn-rounded" onclick="return confirm('Kirim semua sertifikat yang sudah diupload?')">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Kirim Semua Sertifikat
                        </button>
                    </form>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama & Gelar</th>
                                    <th>Gender / TTL / Usia</th>
                                    <th>Kontak & Domisili</th>
                                    <th>Institusi & Jenjang</th>
                                    <th>Jabatan</th>
                                    <th>Sertifikat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($participant->subParticipants as $i => $sub)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        <strong>{{ $sub->full_name }}</strong><br>
                                        <small class="text-muted">{{ $sub->name_for_certificate }}</small>
                                    </td>
                                    <td class="small">
                                        {{ $sub->gender ?? '-' }}<br>
                                        {{ $sub->birth_place ?? '-' }}{{ $sub->birth_date ? ', ' . \Carbon\Carbon::parse($sub->birth_date)->format('d/m/Y') : '' }}
                                        @if($sub->age)<span class="badge badge-info ml-1">{{ $sub->age }} th</span>@endif
                                    </td>
                                    <td class="small">
                                        <i class="fa-solid fa-envelope mr-1 text-muted"></i>{{ $sub->email ?? '-' }}<br>
                                        <i class="fa-brands fa-whatsapp mr-1 text-success"></i>{{ $sub->whatsapp ?? '-' }}<br>
                                        <small class="text-muted"><i class="fa-solid fa-location-dot mr-1"></i>{{ $sub->domicile ?? '-' }}</small>
                                    </td>
                                    <td class="small">
                                        <strong>{{ $sub->institution_name ?? '-' }}</strong>
                                        @if($sub->institution_city)<br><small class="text-muted">{{ $sub->institution_city }}</small>@endif
                                        @if($sub->institution_level)
                                            <div class="mt-1">
                                                @foreach(explode(', ', $sub->institution_level) as $lvl)
                                                    <span class="badge badge-light border text-dark" style="font-size:10px;">{{ trim($lvl) }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="small">{{ $sub->role_in_institution ?? '-' }}</td>
                                    <td>
                                        @if($sub->certificate_file)
                                            <span class="badge badge-success">Ada</span>
                                            <a href="{{ asset('storage/certificates/' . $sub->certificate_file) }}" target="_blank" class="d-block small text-primary mt-1"><i class="fa-solid fa-file-pdf"></i> Lihat</a>
                                            @if($sub->certificate_sent_at)
                                            <div class="text-muted" style="font-size:11px;">Terkirim {{ \Carbon\Carbon::parse($sub->certificate_sent_at)->format('d/m/Y') }}</div>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary">Belum</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.pelatihan.participant.sub.upload-certificate', [$pelatihan->id, $participant->id, $sub->id]) }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center mb-1" style="gap:4px">
                                            @csrf
                                            <input type="file" name="certificate_file" class="form-control form-control-sm" style="max-width:140px" accept=".pdf,.jpg,.jpeg,.png">
                                            <button type="submit" class="btn btn-xs btn-outline-primary btn-rounded" style="white-space:nowrap">Upload</button>
                                        </form>
                                        @if($sub->certificate_file)
                                        <form action="{{ route('admin.pelatihan.participant.sub.send-certificate', [$pelatihan->id, $participant->id, $sub->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-primary btn-rounded btn-block" {{ !$sub->email ? 'disabled title="Email tidak ada"' : '' }}>
                                                <i class="fa-solid fa-paper-plane mr-1"></i> Kirim
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            @include('layouts.alert')

            @if($participant->status === 'pending')
            <div class="card mb-3 border-warning">
                <div class="card-header bg-warning text-white">Approval Peserta</div>
                <div class="card-body">
                    <form action="{{ route('admin.pelatihan.participant.approve', [$pelatihan->id, $participant->id]) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="form-group mb-2">
                            <textarea class="form-control" name="admin_note" rows="2" placeholder="Catatan (opsional)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block btn-rounded">
                            <i class="fa-solid fa-check mr-1"></i> Approve Peserta
                        </button>
                    </form>
                    <form action="{{ route('admin.pelatihan.participant.reject', [$pelatihan->id, $participant->id]) }}" method="POST">
                        @csrf
                        <div class="form-group mb-2">
                            <textarea class="form-control" name="admin_note" rows="2" placeholder="Alasan penolakan..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block btn-rounded">
                            <i class="fa-solid fa-times mr-1"></i> Tolak Peserta
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <div class="card mb-3">
                <div class="card-header">Ubah Status Manual</div>
                <div class="card-body">
                    <form action="{{ route('admin.pelatihan.participant.update-status', [$pelatihan->id, $participant->id]) }}" method="POST">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small text-muted">Status Baru</label>
                            <select name="status" class="form-control form-control-sm" required>
                                <option value="pending" {{ $participant->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="approved" {{ $participant->status === 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ $participant->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small text-muted">Catatan Admin (opsional)</label>
                            <textarea class="form-control form-control-sm" name="admin_note" rows="2" placeholder="Catatan...">{{ $participant->admin_note }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block btn-rounded btn-sm">
                            <i class="fa-solid fa-rotate mr-1"></i> Perbarui Status & Kirim Notifikasi
                        </button>
                    </form>
                </div>
            </div>

            @if($participant->registration_type === 'individu')
            <div class="card mb-3">
                <div class="card-header">Sertifikat</div>
                <div class="card-body">
                    @if($participant->certificate_file)
                    <div class="mb-3">
                        <span class="badge badge-success">File Tersedia</span>
                        @if($participant->certificate_sent_at)
                        <div class="text-muted small mt-1">
                            Dikirim: {{ \Carbon\Carbon::parse($participant->certificate_sent_at)->format('d M Y H:i') }}
                        </div>
                        @endif
                    </div>
                    <form action="{{ route('admin.pelatihan.participant.send-certificate', [$pelatihan->id, $participant->id]) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block btn-rounded btn-sm">
                            <i class="fa-solid fa-paper-plane mr-1"></i>
                            {{ $participant->certificate_sent_at ? 'Kirim Ulang Sertifikat' : 'Kirim Sertifikat ke Email' }}
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('admin.pelatihan.participant.upload-certificate', [$pelatihan->id, $participant->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="text-label small">{{ $participant->certificate_file ? 'Ganti' : 'Upload' }} Sertifikat (PDF/JPG)</label>
                            <input type="file" class="dropify" name="certificate_file" data-allowed-file-extensions="pdf jpg jpeg png" data-max-file-size="5M">
                        </div>
                        <button type="submit" class="btn btn-outline-primary btn-block btn-rounded btn-sm">
                            <i class="fa-solid fa-upload mr-1"></i> Simpan Sertifikat
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <a href="{{ route('admin.pelatihan.participant.index', $pelatihan->id) }}" class="btn btn-secondary btn-block btn-rounded">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection
