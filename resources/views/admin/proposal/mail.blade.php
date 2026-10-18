<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Proposal Penawaran Jatidiri.app</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; margin: 0; padding: 20px; background-color: #f7f9fa;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <div style="background-color: #1e3a8a; padding: 24px; text-align: center; color: #ffffff;">
            <h1 style="margin: 0; font-size: 22px; font-weight: bold; letter-spacing: 0.5px;">JATIDIRI.APP</h1>
            <p style="margin: 4px 0 0 0; font-size: 13px; color: #93c5fd;">PT Hexagon Karyatama Indonesia</p>
        </div>

        <div style="padding: 24px 28px;">
            <p style="font-size: 15px;">Yth. Bapak/Ibu <strong>{{ $proposal->pic_name }}</strong>,<br>
            {{ $proposal->pic_title }} - <strong>{{ $proposal->school_name }}</strong></p>

            <p style="font-size: 14px; text-align: justify;">
                Terima kasih atas minat dan kesediaan Bapak/Ibu untuk berkolaborasi bersama <strong>Jatidiri.app</strong>. 
                Sesuai dengan informasi kebutuhan asesmen psikologi digital untuk institusi Anda, terlampir kami sampaikan dokumen resmi 
                <strong>Proposal Penawaran Kerja Sama Program Asesmen &amp; BK Digital Terpadu</strong>.
            </p>

            <div style="background-color: #f1f5f9; border-left: 4px solid #1e3a8a; padding: 14px 18px; margin: 18px 0; border-radius: 4px;">
                <p style="margin: 0 0 6px 0; font-size: 13px;"><strong>Nomor Surat:</strong> {{ $proposal->proposal_number }}</p>
                <p style="margin: 0 0 6px 0; font-size: 13px;"><strong>Target Sasaran:</strong> {{ $proposal->target_audience ?: 'Siswa / Peserta' }} ({{ $proposal->estimated_participants }} Peserta)</p>
                <p style="margin: 0; font-size: 13px;"><strong>Paket Pilihan:</strong> {{ ucfirst($proposal->package_type) }} Package</p>
            </div>

            <p style="font-size: 14px; text-align: justify;">
                Dokumen proposal lengkap telah kami lampirkan dalam format <strong>PDF</strong> pada email ini. 
                Proposal ini mencakup rincian instrumen tes, dasar regulasi penggunaan dana BOS/SIPLah, SOP pelaksanaan, serta legalitas tim psikolog penanggung jawab (SIAP HIMPSI: 20100303).
            </p>

            <p style="font-size: 14px;">
                Bila Bapak/Ibu membutuhkan diskusi teknis, presentasi luring/daring, atau penyesuaian khusus, silakan menghubungi tim konsultan kemitraan kami melalui:
            </p>
            
            <p style="font-size: 14px; margin-bottom: 24px;">
                WhatsApp: <a href="https://wa.me/6281211112222" style="color: #1e3a8a; font-weight: bold; text-decoration: none;">0812-1111-2222</a><br>
                Email: <a href="mailto:info.jatidiri@gmail.com" style="color: #1e3a8a; font-weight: bold; text-decoration: none;">info.jatidiri@gmail.com</a><br>
                Website: <a href="https://jatidiri.app" style="color: #1e3a8a; text-decoration: none;">https://jatidiri.app</a>
            </p>

            <p style="font-size: 14px; margin: 0;">
                Hormat kami,<br>
                <strong>Tim Kemitraan Jatidiri.app</strong><br>
                <em>PT Hexagon Karyatama Indonesia</em>
            </p>
        </div>

        <div style="background-color: #f8fafc; padding: 14px; text-align: center; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
            Email ini dikirimkan secara otomatis dari sistem resmi Jatidiri.app. Hak Cipta &copy; {{ date('Y') }}.
        </div>
    </div>
</body>
</html>
