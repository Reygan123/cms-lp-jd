<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { font-family: Arial, sans-serif; background:#f6f6f6; margin:0; padding:0; }
.wrap { max-width:600px; margin:30px auto; background:#fff; border-radius:8px; overflow:hidden; }
.header { background:#dc2626; color:#fff; padding:28px 32px; }
.header h1 { margin:0; font-size:22px; }
.body { padding:28px 32px; color:#333; line-height:1.7; }
.info-box { background:#fef2f2; border-left:4px solid #ef4444; padding:16px 20px; border-radius:6px; margin:18px 0; }
.info-box b { display:block; font-size:13px; color:#666; margin-bottom:2px; }
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
    <p>Terima kasih telah mendaftar pada program pelatihan Jatidiri. Setelah melalui proses verifikasi, dengan ini kami sampaikan bahwa pendaftaran Anda berstatus <strong>TIDAK DAPAT KAMI PROSES</strong> untuk program berikut:</p>

    <div class="info-box">
      <b>Pelatihan</b>{{ $participant->pelatihan->title }}
      @if($participant->pelatihan->batch)<b>Batch</b>{{ $participant->pelatihan->batch }}@endif
      <b>Kode Registrasi</b>{{ $participant->registration_code }}
    </div>

    @if($participant->admin_note)
    <p><strong>Keterangan:</strong><br>{{ $participant->admin_note }}</p>
    @endif

    <p>Jika Anda memiliki pertanyaan lebih lanjut atau ingin mendaftar ulang, silakan hubungi kami:</p>
    <ul>
      @if($participant->pelatihan->whatsapp_contact)<li>WhatsApp: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $participant->pelatihan->whatsapp_contact) }}">{{ $participant->pelatihan->whatsapp_contact }}</a></li>@endif
      @if($participant->pelatihan->email_contact)<li>Email: <a href="mailto:{{ $participant->pelatihan->email_contact }}">{{ $participant->pelatihan->email_contact }}</a></li>@endif
    </ul>

    <p>Mohon maaf atas ketidaknyamanannya.<br>Salam,<br><strong>Tim Jatidiri</strong></p>
  </div>
  <div class="footer">© {{ date('Y') }} Jatidiri — PT Hexagon Karyatama Indonesia</div>
</div>
</body>
</html>
