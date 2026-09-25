<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: Arial, sans-serif; color: #333; background: #f5f5f5; margin: 0; padding: 0; }
.container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
.header { background: #2c3e50; color: #fff; padding: 30px 40px; text-align: center; }
.header h1 { margin: 0; font-size: 20px; }
.body { padding: 30px 40px; }
.body p { line-height: 1.7; margin-bottom: 14px; }
.highlight { background: #f0f4ff; border-left: 4px solid #2c3e50; padding: 12px 18px; border-radius: 4px; margin: 20px 0; }
.footer { background: #f5f5f5; padding: 20px 40px; text-align: center; font-size: 12px; color: #888; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>E-Sertifikat Pelatihan</h1>
        <p style="margin:8px 0 0;font-size:14px;opacity:.85;">{{ $pelatihan->title }}</p>
    </div>
    <div class="body">
        <p>Yth. <strong>{{ $participant->name_for_certificate }}</strong>,</p>
        <p>
            Selamat! Terima kasih telah berpartisipasi dan menyelesaikan pelatihan
            <strong>{{ $pelatihan->title }}</strong>{{ $pelatihan->batch ? ' - ' . $pelatihan->batch : '' }}.
        </p>
        <p>
            Bersama email ini kami lampirkan <strong>e-sertifikat</strong> keikutsertaan Anda
            dalam program tersebut. Sertifikat ini merupakan bukti kehadiran dan penyelesaian
            program 16 JP sesuai ketentuan.
        </p>
        <div class="highlight">
            <strong>Detail Peserta:</strong><br>
            Nama: {{ $participant->name_for_certificate }}<br>
            Kode Registrasi: {{ $participant->registration_code }}<br>
            Pelatihan: {{ $pelatihan->title }}<br>
            @if($pelatihan->batch) Batch: {{ $pelatihan->batch }}<br>@endif
            @if($pelatihan->start_date) Tanggal: {{ $pelatihan->start_date }} @if($pelatihan->end_date)– {{ $pelatihan->end_date }}@endif<br>@endif
        </div>
        <p>
            Jika ada pertanyaan, silakan hubungi kami melalui WhatsApp
            {{ $pelatihan->whatsapp_contact ?? '0851-4239-8721' }}
            atau email {{ $pelatihan->email_contact ?? 'jatidiri.apps@gmail.com' }}.
        </p>
        <p>Salam hangat,<br><strong>Tim Jatidiri</strong></p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Jatidiri &mdash; jatidiri.app
    </div>
</div>
</body>
</html>
