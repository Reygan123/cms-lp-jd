@php
    /* ------------------------------------------------------------------
     | ASET (header/footer/logo sama dengan laporan di Go service)
     | Lokasi: public/assets/...
     ------------------------------------------------------------------ */
    $b64 = function ($path) {
        if (!file_exists($path)) {
            return '';
        }
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mime = in_array($ext, ['jpg', 'jpeg']) ? 'image/jpeg' : 'image/png';
        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
    };

    $headerBase64 = $b64(public_path('assets/header.png'));
    $footerBase64 = $b64(public_path('assets/footer.png'));
    $logoBase64 = $b64(public_path('assets/logo-haki.png'));
    $ttdTaufikBase64 = $b64(public_path('assets/taufik.png'));
    $ttdMiryamBase64 = $b64(public_path('assets/barcode.png'));
    $heroBase64 = $b64(public_path('assets/illustration/HeroDekstop.png'));

    /* Font Sora (opsional). Taruh TTF STATIS di public/assets/fonts/
       Sora-Regular.ttf dan Sora-Bold.ttf. Kalau tidak ada -> fallback DejaVu Sans. */
    $fontPath = function ($name) {
        $p = public_path('assets/fonts/' . $name);
        return file_exists($p) ? str_replace('\\', '/', $p) : null;
    };
    $soraRegular = $fontPath('Sora-Regular.ttf');
    $soraBold = $fontPath('Sora-Bold.ttf');
    $fontStack = ($soraRegular && $soraBold)
        ? "'Sora', 'DejaVu Sans', sans-serif"
        : "'DejaVu Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";

    /* Tinggi area cover (area konten A4 = 255.6mm). Turunkan sedikit kalau muncul halaman kosong
       setelah cover; naikkan kalau ilustrasi belum menempel ke footer. */
    $coverH = '243mm';

    /* ------------------------------------------------------------------
     | DATA
     ------------------------------------------------------------------ */
    $content = is_array($content ?? null) ? $content : (array) ($content ?? []);
    $skema = $content['skema_investasi'] ?? [];

    $schoolName = $content['tujuan_surat']['institusi'] ?? $proposal->school_name ?? 'Institusi Mitra';
    $picName = $content['tujuan_surat']['nama_pic'] ?? $proposal->pic_name ?? 'Bapak/Ibu Pimpinan';
    $picTitle = $content['tujuan_surat']['jabatan'] ?? $proposal->pic_title ?? 'Kepala Sekolah / Pimpinan';
    $city = $content['tujuan_surat']['kota'] ?? ($proposal->city ?: 'Tempat');
    $nomorSurat = $content['nomor_surat'] ?? $proposal->proposal_number ?? 'PRP/JD/' . date('Y/m/') . '001';
    $tglSurat = $content['tanggal_surat'] ?? now()->locale('id')->translatedFormat('d F Y');
    $perihal = $content['perihal'] ?? 'Penawaran Kerja Sama Program Asesmen Psikologi Digital & Ekosistem Terpadu';

    $typeKey = strtolower((string) ($proposal->institution_type ?? 'school'));
    $isSchool = in_array($typeKey, ['school', 'sekolah', 'smp', 'sma', 'smk', 'sd']);
    $isCampus = in_array($typeKey, ['campus', 'kampus', 'university', 'universitas']);
    $unit = $isCampus ? 'Mahasiswa' : (in_array($typeKey, ['corporate', 'corp', 'perusahaan']) ? 'Karyawan' : 'Siswa');
    $typeLabel = $isSchool ? 'Sekolah' : ($isCampus ? 'Kampus' : (in_array($typeKey, ['corporate', 'corp', 'perusahaan']) ? 'Corporate' : ucfirst($typeKey)));

    $num = function ($v, $default) {
        return is_numeric($v) ? (float) $v : (float) $default;
    };
    $harga = $num($skema['harga_per_peserta'] ?? null, $proposal->price_per_participant ?? 145000);
    $jumlah = (int) $num($skema['jumlah_peserta'] ?? null, $proposal->estimated_participants ?? 1);
    $total = $num($skema['total_investasi'] ?? null, $harga * $jumlah);
    $namaPaket = $skema['nama_paket'] ?? 'Advance Package';
    $rp = fn($n) => 'Rp ' . number_format($n, 0, ',', '.');

    /* teks AI -> daftar paragraf */
    $paras = function ($t) {
        $t = trim((string) $t);
        if ($t === '') {
            return [];
        }
        return array_values(array_filter(array_map('trim', preg_split('/\R\s*\R/', $t))));
    };

    $runHead = '<table class="runhead"><tr>'
        . '<td class="rh-l">Proposal Penawaran Kerja Sama Asesmen Psikologi &mdash; ' . e($schoolName) . '</td>'
        . '<td class="rh-r">Confidential</td></tr></table>';
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Proposal Penawaran - {{ $schoolName }}</title>
    <style>
        @if($soraRegular && $soraBold)
            @font-face {
                font-family: 'Sora';
                font-style: normal;
                font-weight: normal;
                src: url('{{ $soraRegular }}') format('truetype');
            }
            @font-face {
                font-family: 'Sora';
                font-style: normal;
                font-weight: bold;
                src: url('{{ $soraBold }}') format('truetype');
            }
        @endif

        /* Margin = tinggi header.png & footer.png (sama dengan laporan di Go service) */
        @page {
            margin: 29.6mm 0 22.8mm 0;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-family: {!! $fontStack !!};
            color: #0F172A;
            font-size: 9.6px;
            line-height: 1.55;
        }

        .header-bar {
            position: fixed;
            top: -29.6mm;
            left: 0;
            right: 0;
            height: 29.6mm;
            width: 100%;
            z-index: -100;
        }
        .header-bar img { width: 100%; height: 29.6mm; display: block; }

        .footer-bar {
            position: fixed;
            bottom: -22.8mm;
            left: 0;
            right: 0;
            height: 22.8mm;
            width: 100%;
            z-index: -100;
        }
        .footer-bar img { width: 100%; height: 22.8mm; display: block; }

        .content { padding: 8px 40px 0 40px; }
        .pg { page-break-before: always; }

        /* ---------------- COVER ---------------- */
        .cover { position: relative; height: {{ $coverH }}; overflow: hidden; }
        .cover-content { padding: 14px 52px 0 52px; }
        .cover-logo { text-align: center; margin-bottom: 14px; }
        .cover-logo img { height: 40px; width: auto; }
        .eyebrow { text-align: center; margin-bottom: 10px; }
        .eyebrow span {
            display: inline-block;
            background-color: #E8E8FD;
            color: #4F4FF0;
            font-size: 9px;
            font-weight: bold;
            padding: 4px 16px;
            border-radius: 14px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .cover-title {
            text-align: center;
            font-size: 21px;
            font-weight: bold;
            line-height: 1.3;
            color: #0E0E82;
            margin-bottom: 12px;
        }
        .cover-badges { text-align: center; margin-bottom: 12px; }
        .badge-o, .badge-b {
            display: inline-block;
            font-size: 9px;
            font-weight: bold;
            padding: 4px 14px;
            border-radius: 14px;
            margin: 0 3px;
        }
        .badge-o { background-color: #FAEEDA; color: #854F0B; }
        .badge-b { background-color: #E6EFF7; color: #0E0E82; }
        .cover-inst {
            text-align: center;
            font-size: 11.5px;
            font-weight: bold;
            color: #0F172A;
            margin-bottom: 4px;
        }
        .cover-note {
            text-align: center;
            font-size: 8px;
            color: #64748B;
            margin-bottom: 14px;
        }
        .cover-card {
            background-color: #F0F7FD;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 6px 18px;
            margin-bottom: 10px;
        }
        .cover-card table { width: 100%; border-collapse: collapse; }
        .cover-card td { padding: 6px 0; border-bottom: 1px solid #E2E8F0; font-size: 9.4px; vertical-align: top; }
        .cover-card tr.last td { border-bottom: none; }
        .cv-l { color: #4B5563; width: 32%; }
        .cv-v { font-weight: bold; color: #0F172A; text-align: right; }
        .rahasia {
            background-color: #FEF2F2;
            border: 1px solid #FEE2E2;
            border-radius: 12px;
            padding: 8px 14px;
            font-size: 8.8px;
            color: #7F1D1D;
            line-height: 1.5;
        }
        .cover-illust { position: absolute; left: 0; right: 0; bottom: 0; }
        .cover-illust img { width: 100%; display: block; }

        /* ---------------- KONTEN ---------------- */
        .runhead { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .runhead td { padding: 0; border: none; font-size: 8.8px; }
        .rh-l { text-align: left; font-weight: bold; color: #4B5563; }
        .rh-r { text-align: right; font-weight: bold; color: #B91C1C; }

        .ribbon {
            background-color: #0E0E82;
            color: #FFFFFF;
            border-radius: 9px;
            padding: 7px 14px;
            margin-top: 6px;
            margin-bottom: 9px;
            font-size: 10.5px;
            font-weight: bold;
            letter-spacing: 0.3px;
            page-break-after: avoid;
        }

        .card-white {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 9px 14px;
            margin-bottom: 10px;
        }
        .card-blue {
            background-color: #F0F7FD;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 9px 14px;
            margin-bottom: 10px;
        }
        .letter {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-left: 3px solid #0E0E82;
            border-radius: 12px;
            padding: 9px 14px;
            margin-bottom: 10px;
        }
        .avoid { page-break-inside: avoid; }

        .txt { font-size: 9.6px; color: #1F2937; line-height: 1.65; text-align: justify; }
        .txt p { margin: 0 0 6px 0; }
        .txt p:last-child { margin-bottom: 0; }
        .txt strong { color: #0E0E82; }
        .txt ul, .txt ol { margin: 3px 0 4px 0; padding-left: 16px; }
        .txt li { margin-bottom: 3px; }
        .sub-label {
            font-size: 8.6px;
            font-weight: bold;
            color: #4F4FF0;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 4px;
        }

        table.tbl { width: 100%; border-collapse: collapse; margin: 0 0 10px 0; }
        table.tbl thead { display: table-header-group; }
        table.tbl tr { page-break-inside: avoid; }
        table.tbl th {
            background-color: #F0F7FD;
            color: #0E0E82;
            font-size: 8.8px;
            font-weight: bold;
            text-align: left;
            padding: 6px 9px;
            border: 1px solid #E2E8F0;
        }
        table.tbl td {
            font-size: 8.8px;
            color: #374151;
            padding: 6px 9px;
            border: 1px solid #E2E8F0;
            vertical-align: top;
            line-height: 1.5;
        }
        table.tbl td.k { background-color: #F0F7FD; font-weight: bold; color: #0E0E82; width: 28%; }
        .pill {
            display: inline-block;
            background-color: #E8E8FD;
            color: #4F4FF0;
            font-size: 8.8px;
            font-weight: bold;
            padding: 2px 10px;
            border-radius: 12px;
        }

        .metric { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .metric td { padding: 0 8px 0 0; vertical-align: top; width: 33.33%; }
        .metric td.last { padding-right: 0; }
        .stat {
            background-color: #F0F7FD;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 9px 8px;
            text-align: center;
        }
        .stat-l { font-size: 8px; font-weight: bold; color: #64748B; text-transform: uppercase; margin-bottom: 3px; }
        .stat-v { font-size: 14px; font-weight: bold; color: #0E0E82; }

        .total-wrap {
            background-color: #0E0E82;
            border-radius: 12px;
            padding: 10px 16px;
            margin-bottom: 10px;
        }
        .total-wrap table { width: 100%; border-collapse: collapse; }
        .total-wrap td { padding: 0; vertical-align: middle; border: none; }
        .tw-l { font-size: 9px; color: #E0E7FF; line-height: 1.45; }
        .tw-r { text-align: right; font-size: 16px; font-weight: bold; color: #FFFFFF; }

        .sig-table { width: 100%; border-collapse: collapse; margin-top: 4px; page-break-inside: avoid; }
        .sig-table td { width: 50%; vertical-align: top; padding: 0 5px; border: none; }
        .sig-card {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 12px 10px;
            text-align: center;
        }
        .sig-date { font-size: 8.8px; color: #4B5563; margin-bottom: 2px; }
        .sig-role { font-size: 9.4px; color: #0F172A; margin-bottom: 4px; line-height: 1.45; }
        .sig-img-wrap { position: relative; width: 170px; height: 62px; margin: 0 auto 4px auto; }
        .sig-cap { position: absolute; left: 10px; top: -4px; width: 70px; height: 70px; opacity: 0.5; }
        .sig-ttd { position: absolute; left: 20px; top: 5px; width: 135px; height: 52px; }
        .sig-line { width: 170px; border-bottom: 1px solid #CBD5E1; margin: 0 auto 6px auto; }
        .sig-name { font-size: 10px; font-weight: bold; color: #0F172A; margin-bottom: 3px; }
        .sig-sub { font-size: 8.2px; color: #6B7280; line-height: 1.4; }

        .disclaimer {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 8px 12px;
            margin-top: 10px;
            font-size: 8.2px;
            color: #4B5563;
            line-height: 1.55;
            text-align: justify;
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    <!-- HEADER & FOOTER BERULANG (header.png / footer.png) -->
    <div class="header-bar">
        @if(!empty($headerBase64))
            <img src="{{ $headerBase64 }}" alt="Jatidiri Header" />
        @endif
    </div>
    <div class="footer-bar">
        @if(!empty($footerBase64))
            <img src="{{ $footerBase64 }}" alt="Jatidiri Footer" />
        @endif
    </div>

    <!-- ============================================================ -->
    <!-- COVER                                                        -->
    <!-- ============================================================ -->
    <div class="cover">
        <div class="cover-content">
            <div class="cover-logo">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Jatidiri" />
                @else
                    <span style="font-size:18px; font-weight:bold; color:#0E0E82;">JATIDIRI.APP</span>
                @endif
            </div>

            <div class="eyebrow"><span>Proposal Penawaran Kerja Sama</span></div>

            <div class="cover-title">
                Proposal Penawaran<br>Program Asesmen Psikologi Digital
            </div>

            <div class="cover-badges">
                <span class="badge-o">{{ $namaPaket }}</span>
                <span class="badge-b">{{ $typeLabel }}</span>
            </div>

            <div class="cover-inst">{{ $schoolName }}</div>
            <div class="cover-note">No. SIAP HIMPSI: 20100303 &nbsp;|&nbsp; Mitra SIPLah Kemendikdasmen</div>

            <div class="cover-card">
                <table>
                    <tr>
                        <td class="cv-l">Nomor Surat</td>
                        <td class="cv-v">{{ $nomorSurat }}</td>
                    </tr>
                    <tr>
                        <td class="cv-l">Tanggal Surat</td>
                        <td class="cv-v">{{ $tglSurat }}</td>
                    </tr>
                    <tr>
                        <td class="cv-l">Perihal</td>
                        <td class="cv-v">{{ $perihal }}</td>
                    </tr>
                    <tr>
                        <td class="cv-l">Ditujukan Kepada</td>
                        <td class="cv-v">{{ $picName }} ({{ $picTitle }})</td>
                    </tr>
                    <tr class="last">
                        <td class="cv-l">Wilayah / Kota</td>
                        <td class="cv-v">{{ $city }}</td>
                    </tr>
                </table>
            </div>

            <div class="rahasia">
                <strong style="color:#B91C1C;">Rahasia &amp; Terbatas:</strong> Dokumen ini memuat rincian penawaran dan skema pembiayaan
                yang hanya diperuntukkan bagi institusi penerima. Dilarang menggandakan atau menyebarluaskan tanpa izin tertulis
                dari Jatidiri.app.
            </div>
        </div>

        @if(!empty($heroBase64))
            <div class="cover-illust">
                <img src="{{ $heroBase64 }}" alt="Ilustrasi Jatidiri" />
            </div>
        @endif
    </div>

    <!-- ============================================================ -->
    <!-- HALAMAN 2: SURAT PENGANTAR, RINGKASAN, TUJUAN                -->
    <!-- ============================================================ -->
    <div class="content pg">
        {!! $runHead !!}

        <div class="letter avoid">
            <div style="font-size:9px; color:#475569; margin-bottom:4px;">
                Kepada Yth. <strong>{{ $picName }}</strong> ({{ $picTitle }}),
                <strong>{{ $schoolName }}</strong> di {{ $city }}
            </div>
            <div class="txt">
                @php
                    $surat = $paras($content['surat_pengantar'] ?? 'Dengan hormat, bersama dokumen ini kami sampaikan penawaran kerja sama penyelenggaraan Program Asesmen Psikologi Digital Jatidiri.app untuk mendukung pemetaan komprehensif potensi, gaya belajar, dan kesiapan karier peserta didik.');
                @endphp
                @foreach($surat as $p)
                    <p>{!! nl2br(e($p)) !!}</p>
                @endforeach
            </div>
        </div>

        <div class="ribbon">1. RINGKASAN EKSEKUTIF &amp; URGENSI PELAKSANAAN</div>
        @php
            $ringkasan = array_merge($paras($content['ringkasan_eksekutif'] ?? ''), $paras($content['latar_belakang'] ?? ''));
        @endphp
        @if(count($ringkasan))
            <div class="card-white">
                <div class="txt">
                    @foreach($ringkasan as $p)
                        <p>{!! nl2br(e($p)) !!}</p>
                    @endforeach
                </div>
            </div>
        @endif

        @if(!empty($content['urgensi_dan_isu']))
            <div class="card-blue avoid">
                <div class="sub-label">Isu Strategis &amp; Urgensi yang Dijawab</div>
                <div class="txt">
                    <ul>
                        @foreach($content['urgensi_dan_isu'] as $isu)
                            <li>{{ $isu }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(!empty($content['tujuan_program']))
            <div class="ribbon">2. TUJUAN &amp; SASARAN PROGRAM KERJA SAMA</div>
            <div class="card-white avoid">
                <div class="txt">
                    <ol>
                        @foreach($content['tujuan_program'] as $tujuan)
                            <li>{{ $tujuan }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endif
    </div>

    <!-- ============================================================ -->
    <!-- HALAMAN 3: BATERAI TES & EKOSISTEM                           -->
    <!-- ============================================================ -->
    <div class="content pg">
        {!! $runHead !!}

        <div class="ribbon">3. KOMPOSISI BATERAI TES PSIKOLOGI DIGITAL JATIDIRI</div>
        <div class="card-white avoid">
            <div class="txt">
                Seluruh asesmen dirancang terstandar oleh psikolog berlisensi resmi SIAP HIMPSI dan disajikan interaktif melalui platform digital.
            </div>
        </div>

        <table class="tbl">
            <thead>
                <tr>
                    <th style="width: 28%;">Nama Modul / Alat Tes</th>
                    <th style="width: 36%;">Aspek &amp; Dimensi yang Diukur</th>
                    <th style="width: 36%;">Manfaat untuk {{ $unit }} &amp; Pembimbing</th>
                </tr>
            </thead>
            <tbody>
                @forelse($content['baterai_tes'] ?? [] as $tes)
                    <tr>
                        <td><strong style="color:#0E0E82;">{{ $tes['nama_modul'] ?? '-' }}</strong></td>
                        <td>{{ $tes['aspek_diukur'] ?? '-' }}</td>
                        <td>{{ $tes['manfaat_untuk_siswa_guru'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td><strong style="color:#0E0E82;">Jatidiri Gaya Belajar</strong></td>
                        <td>Modalitas belajar Visual, Auditori, dan Kinestetik</td>
                        <td>Mengetahui metode belajar paling efektif untuk memaksimalkan prestasi</td>
                    </tr>
                    <tr>
                        <td><strong style="color:#0E0E82;">Jatidiri Karier</strong></td>
                        <td>Preferensi minat bidang studi dan karier</td>
                        <td>Panduan pemilihan jurusan dan peminatan karier masa depan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(!empty($content['ekosistem_tambahan']))
            <div class="ribbon">4. FASILITAS EKOSISTEM PENDUKUNG (LAYANAN NILAI TAMBAH)</div>
            <table class="tbl">
                <thead>
                    <tr>
                        <th style="width: 30%;">Layanan Ekosistem</th>
                        <th>Deskripsi &amp; Manfaat Implementasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($content['ekosistem_tambahan'] as $eko)
                        <tr>
                            <td><strong style="color:#0E0E82;">{{ $eko['fitur'] ?? '-' }}</strong></td>
                            <td>{{ $eko['deskripsi'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- ============================================================ -->
    <!-- HALAMAN 4: SKEMA INVESTASI & TAHAPAN                         -->
    <!-- ============================================================ -->
    <div class="content pg">
        {!! $runHead !!}

        <div class="ribbon">5. RINCIAN SKEMA INVESTASI &amp; FASILITAS PAKET</div>

        <table class="metric">
            <tr>
                <td>
                    <div class="stat">
                        <div class="stat-l">Paket Layanan</div>
                        <div class="stat-v" style="font-size:11px;">{{ $namaPaket }}</div>
                    </div>
                </td>
                <td>
                    <div class="stat">
                        <div class="stat-l">Investasi per {{ $unit }}</div>
                        <div class="stat-v">{{ $rp($harga) }}</div>
                    </div>
                </td>
                <td class="last">
                    <div class="stat">
                        <div class="stat-l">Estimasi Peserta</div>
                        <div class="stat-v">{{ number_format($jumlah, 0, ',', '.') }} <span style="font-size:8.5px; font-weight:normal; color:#64748B;">{{ $unit }}</span></div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="total-wrap avoid">
            <table>
                <tr>
                    <td class="tw-l">
                        Total Estimasi Investasi Program
                        @if($isSchool)
                            <br>Dapat dialokasikan melalui Dana BOS / SIPLah
                        @endif
                    </td>
                    <td class="tw-r">{{ $rp($total) }}</td>
                </tr>
            </table>
        </div>

        <table class="tbl">
            <tr>
                <td class="k">Paket Layanan</td>
                <td><span class="pill">{{ $namaPaket }}</span></td>
            </tr>
            <tr>
                <td class="k">Investasi per Peserta</td>
                <td><strong>{{ $rp($harga) }}</strong> / {{ strtolower($unit) }} (bebas biaya server &amp; pemeliharaan)</td>
            </tr>
            <tr>
                <td class="k">Estimasi Peserta</td>
                <td><strong>{{ number_format($jumlah, 0, ',', '.') }} {{ $unit }}</strong></td>
            </tr>
            <tr>
                <td class="k">Total Nilai Investasi</td>
                <td>
                    <strong style="color:#0E0E82; font-size:10px;">{{ $rp($total) }}</strong>
                    @if(!empty($skema['terbilang']))
                        <div style="font-size:8px; color:#64748B; font-style:italic;">({{ $skema['terbilang'] }})</div>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="k">{{ $isSchool ? 'Dasar Alokasi BOS / SIPLah' : 'Dasar Alokasi Anggaran' }}</td>
                <td>
                    {{ $skema['dasar_anggaran_bos_siplah'] ?? ($isSchool
    ? 'Dapat dianggarkan secara legal melalui Dana BOS Kinerja/Reguler serta SIPLah Kemendikdasmen.'
    : 'Dapat disesuaikan dengan mekanisme pengadaan dan anggaran institusi.') }}
                </td>
            </tr>
        </table>

        @if(!empty($skema['fasilitas_termasuk']))
            <div class="card-blue avoid">
                <div class="sub-label">Fasilitas yang Sudah Termasuk dalam Paket</div>
                <div class="txt">
                    <ul>
                        @foreach($skema['fasilitas_termasuk'] as $fasilitas)
                            <li>{{ $fasilitas }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="ribbon">6. TAHAPAN PELAKSANAAN, SOP &amp; TIMELINE</div>
        <table class="tbl">
            <thead>
                <tr>
                    <th style="width: 22%;">Tahapan</th>
                    <th style="width: 40%;">Uraian Kegiatan &amp; SOP</th>
                    <th style="width: 16%;">Durasi</th>
                    <th style="width: 22%;">Output Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($content['metode_dan_jadwal'] ?? [] as $jadwal)
                    <tr>
                        <td><strong style="color:#0E0E82;">{{ $jadwal['tahap'] ?? '-' }}</strong></td>
                        <td>{{ $jadwal['kegiatan'] ?? '-' }}</td>
                        <td>{{ $jadwal['durasi'] ?? '-' }}</td>
                        <td>{{ $jadwal['output'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td><strong style="color:#0E0E82;">Tahap 1: Persiapan</strong></td>
                        <td>Sosialisasi teknis, pembuatan akun peserta &amp; jadwal pelaksanaan</td>
                        <td>1 - 2 Hari</td>
                        <td>Akun &amp; Token Ujian</td>
                    </tr>
                    <tr>
                        <td><strong style="color:#0E0E82;">Tahap 2: Pelaksanaan</strong></td>
                        <td>Pengerjaan asesmen secara daring mandiri atau serentak di lab</td>
                        <td>1 Hari</td>
                        <td>Log Data Ujian</td>
                    </tr>
                    <tr>
                        <td><strong style="color:#0E0E82;">Tahap 3: Pelaporan</strong></td>
                        <td>Pengolahan hasil, generate laporan individual &amp; dashboard rekap</td>
                        <td>1 - 3 Hari</td>
                        <td>Laporan PDF &amp; Rekap</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ============================================================ -->
    <!-- HALAMAN 5: DELIVERABLES, PENUTUP, PENGESAHAN                 -->
    <!-- ============================================================ -->
    <div class="content pg">
        {!! $runHead !!}

        <div class="ribbon">7. DOKUMEN HASIL AKHIR (DELIVERABLES)</div>
        <div class="card-white avoid">
            <div class="txt">
                <ol>
                    @if(!empty($content['deliverables']))
                        @foreach($content['deliverables'] as $deliv)
                            <li><strong>{{ $deliv }}</strong></li>
                        @endforeach
                    @else
                        <li><strong>Laporan Hasil Asesmen Individual (E-Report PDF Resmi)</strong> dengan tanda tangan psikolog ber-SIAP HIMPSI.</li>
                        <li><strong>Akses Dashboard Eksekutif &amp; Pembimbing</strong> untuk rekapitulasi data dan pemetaan kelompok.</li>
                        <li><strong>Sesi Konsultasi &amp; Bedah Hasil Bersama Tim Psikolog Jatidiri</strong>.</li>
                    @endif
                </ol>
            </div>
        </div>

        <div class="ribbon">8. PENUTUP &amp; LEMBAR PERSETUJUAN KERJA SAMA</div>
        <div class="card-white">
            <div class="txt">
                @php
                    $penutup = $paras($content['penutup_dan_call_to_action'] ?? 'Demikian proposal penawaran kerja sama ini kami sampaikan. Kami meyakini bahwa kolaborasi strategis ini akan memberikan dampak positif yang nyata dalam memetakan potensi peserta didik secara akurat. Atas perhatian dan kerja sama yang baik, kami ucapkan terima kasih.');
                @endphp
                @foreach($penutup as $p)
                    <p>{!! nl2br(e($p)) !!}</p>
                @endforeach
            </div>
        </div>

        <table class="sig-table">
            <tr>
                <td>
                    <div class="sig-card">
                        <div class="sig-date">Bandung, {{ $tglSurat }}</div>
                        <div class="sig-role">Hormat kami,<br><strong>CEO Jatidiri.App</strong></div>
                        <div class="sig-img-wrap" style="text-align: center;">
                            @if(!empty($ttdTaufikBase64))
                                <img src="{{ $ttdTaufikBase64 }}" alt="Tanda Tangan CEO" style="max-height: 56px; max-width: 160px; display: inline-block; vertical-align: middle;" />
                            @endif
                        </div>
                        <div class="sig-line"></div>
                        <div class="sig-name">Maulis Taufik Kosasih P. S,Pd.</div>
                        <div class="sig-sub">CEO Jatidiri.App</div>
                    </div>
                </td>
                <td>
                    <div class="sig-card">
                        <div class="sig-date">Bandung, {{ $tglSurat }}</div>
                        <div class="sig-role">Kontak:<br><strong>COO &ndash; Jatidiri</strong></div>
                        <div class="sig-img-wrap" style="text-align: center;">
                            @if(!empty($ttdMiryamBase64))
                                <img src="{{ $ttdMiryamBase64 }}" alt="Barcode HIMPSI" style="max-height: 56px; max-width: 160px; display: inline-block; vertical-align: middle;" />
                            @endif
                        </div>
                        <div class="sig-line"></div>
                        <div class="sig-name">Miryam A. Sigarlaki, M.Psi., Psikolog</div>
                        <div class="sig-sub">COO &ndash; Jatidiri</div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="disclaimer">
            <strong style="color:#0F172A;">Legalitas &amp; Kerahasiaan:</strong> Dokumen proposal ini diterbitkan secara sah oleh
            Platform Jatidiri.app (PT Hexagon Karyatama Indonesia). Instrumen psikologi yang digunakan berada di bawah supervisi
            Psikolog berlisensi resmi SIAP HIMPSI (20100303) serta Terdaftar HAKI di Kemenkumham RI. Seluruh isi dan rincian skema
            pembiayaan dalam dokumen ini bersifat <em>Confidential</em> dan hanya diperuntukkan bagi institusi penerima yang
            tercantum.
        </div>
    </div>

</body>
</html>