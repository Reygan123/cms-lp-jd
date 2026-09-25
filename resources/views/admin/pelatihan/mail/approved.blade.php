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
.info-box { background:#f0fdf4; border-left:4px solid #22c55e; padding:16px 20px; border-radius:6px; margin:18px 0; }
.info-box b { display:block; font-size:13px; color:#666; margin-bottom:2px; }
.btn { display:inline-block; background:#25d366; color:#fff; text-decoration:none; padding:12px 24px; border-radius:6px; font-weight:bold; margin:16px 0; }
.footer { background:#f9f9f9; padding:16px 32px; font-size:12px; color:#999; text-align:center; border-top:1px solid #eee; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <h1>🎉 Pendaftaran Anda Diterima!</h1>
  </div>
  <div class="body">
    <p>Yth. <strong>{{ $participant->name_for_certificate }}</strong>,</p>
    <p>Kami dengan senang hati mengonfirmasi bahwa pendaftaran Anda untuk program pelatihan berikut telah <strong>DITERIMA</strong>:</p>

    <div class="info-box">
      <b>Pelatihan</b>{{ $participant->pelatihan->title }}
      @if($participant->pelatihan->batch)
        <b>Batch</b>{{ $participant->pelatihan->batch }}
      @endif
      <b>Kode Registrasi</b>{{ $participant->registration_code }}
      @if($participant->pelatihan->start_date)
        <b>Tanggal</b>{{ \Carbon\Carbon::parse($participant->pelatihan->start_date)->format('d M Y') }}
        @if($participant->pelatihan->end_date && $participant->pelatihan->start_date != $participant->pelatihan->end_date)
          — {{ \Carbon\Carbon::parse($participant->pelatihan->end_date)->format('d M Y') }}
        @endif
      @endif
      @if($participant->pelatihan->location)
        <b>Lokasi</b>{{ $participant->pelatihan->location }}
      @endif
    </div>

    <p>Kursi Anda telah dikonfirmasi. Silakan bergabung ke <strong>Grup WhatsApp</strong> resmi peserta pelatihan untuk mendapatkan informasi lebih lanjut:</p>

    <a href="{{ $waGroupLink }}" class="btn">📲 Bergabung ke Grup WhatsApp</a>

    <p>Jika Anda mengalami kesulitan, hubungi kami melalui:</p>
    <ul>
      @if($participant->pelatihan->whatsapp_contact)<li>WhatsApp: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $participant->pelatihan->whatsapp_contact) }}">{{ $participant->pelatihan->whatsapp_contact }}</a></li>@endif
      @if($participant->pelatihan->email_contact)<li>Email: <a href="mailto:{{ $participant->pelatihan->email_contact }}">{{ $participant->pelatihan->email_contact }}</a></li>@endif
    </ul>

    <p>Salam hangat,<br><strong>Tim Jatidiri</strong></p>
  </div>
  <div class="footer">© {{ date('Y') }} Jatidiri — PT Hexagon Karyatama Indonesia</div>
</div>
</body>
</html>
