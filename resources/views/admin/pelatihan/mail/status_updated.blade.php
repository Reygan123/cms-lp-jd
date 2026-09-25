<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { font-family: Arial, sans-serif; background:#f6f6f6; margin:0; padding:0; }
.wrap { max-width:600px; margin:30px auto; background:#fff; border-radius:8px; overflow:hidden; }
.header { background:#2563eb; color:#fff; padding:28px 32px; }
.header h1 { margin:0; font-size:22px; }
.body { padding:28px 32px; color:#333; line-height:1.7; }
.info-box { background:#eff6ff; border-left:4px solid #3b82f6; padding:16px 20px; border-radius:6px; margin:18px 0; }
.info-box b { display:block; font-size:13px; color:#666; margin-bottom:2px; }
.status-badge { display:inline-block; padding:4px 14px; border-radius:20px; font-weight:bold; font-size:14px; }
.status-approved { background:#dcfce7; color:#16a34a; }
.status-pending  { background:#fef9c3; color:#ca8a04; }
.status-rejected { background:#fee2e2; color:#dc2626; }
.btn { display:inline-block; background:#25d366; color:#fff; text-decoration:none; padding:12px 24px; border-radius:6px; font-weight:bold; margin:16px 0; }
.footer { background:#f9f9f9; padding:16px 32px; font-size:12px; color:#999; text-align:center; border-top:1px solid #eee; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <h1>Pembaruan Status Pendaftaran</h1>
  </div>
  <div class="body">
    <p>Yth. <strong>{{ $participant->name_for_certificate }}</strong>,</p>
    <p>Status pendaftaran Anda telah diperbarui oleh Tim Jatidiri.</p>

    <div class="info-box">
      <b>Pelatihan</b>{{ $participant->pelatihan->title }}
      @if($participant->pelatihan->batch)<b>Batch</b>{{ $participant->pelatihan->batch }}@endif
      <b>Kode Registrasi</b>{{ $participant->registration_code }}
      <b>Status Terbaru</b>
      <span class="status-badge status-{{ $participant->status }}">{{ $participant->status_label }}</span>
    </div>

    @if($participant->admin_note)
    <p><strong>Catatan dari Admin:</strong><br>{{ $participant->admin_note }}</p>
    @endif

    @if($participant->status === 'approved' && $waGroupLink)
    <p>Karena pendaftaran Anda telah disetujui, silakan bergabung ke <strong>Grup WhatsApp</strong> resmi peserta:</p>
    <a href="{{ $waGroupLink }}" class="btn">📲 Bergabung ke Grup WhatsApp</a>
    @endif

    <p>Untuk informasi lebih lanjut, hubungi kami:</p>
    <ul>
      @if($participant->pelatihan->whatsapp_contact)<li>WhatsApp: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $participant->pelatihan->whatsapp_contact) }}">{{ $participant->pelatihan->whatsapp_contact }}</a></li>@endif
      @if($participant->pelatihan->email_contact)<li>Email: <a href="mailto:{{ $participant->pelatihan->email_contact }}">{{ $participant->pelatihan->email_contact }}</a></li>@endif
    </ul>

    <p>Salam,<br><strong>Tim Jatidiri</strong></p>
  </div>
  <div class="footer">© {{ date('Y') }} Jatidiri — PT Hexagon Karyatama Indonesia</div>
</div>
</body>
</html>
