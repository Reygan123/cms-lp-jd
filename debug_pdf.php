<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$headerPath = public_path('assets/header.png');
$footerPath = public_path('assets/footer.png');
$headerBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($headerPath));
$footerBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($footerPath));

$html = '
<!DOCTYPE html>
<html>
<head>
<style>
    @page {
        size: A4 portrait;
        margin-top: 100px;
        margin-bottom: 80px;
        margin-left: 0px;
        margin-right: 0px;
    }
    * { box-sizing: border-box; }
    body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }
    .header-bar {
        position: fixed;
        top: -100px;
        left: 0;
        right: 0;
        height: 85px;
        width: 100%;
    }
    .header-bar img {
        width: 100%;
        height: 85px;
        display: block;
    }
    .footer-bar {
        position: fixed;
        bottom: -80px;
        left: 0;
        right: 0;
        height: 65px;
        width: 100%;
    }
    .footer-bar img {
        width: 100%;
        height: 65px;
        display: block;
    }
    .content {
        padding: 10px 40px;
    }
</style>
</head>
<body>
    <div class="header-bar">
        <img src="' . $headerBase64 . '" />
    </div>
    <div class="footer-bar">
        <img src="' . $footerBase64 . '" />
    </div>
    <div class="content">
        <h1>Testing Header and Footer</h1>
        <p>This is test content inside the document.</p>
    </div>
</body>
</html>';

$pdf = Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('a4', 'portrait');
file_put_contents(__DIR__ . '/public/test_hf.pdf', $pdf->output());

// Convert first page to image using Ghostscript or pdftoppm or imagick or let's inspect
echo "test_hf.pdf generated, size: " . filesize(__DIR__ . '/public/test_hf.pdf') . "\n";
