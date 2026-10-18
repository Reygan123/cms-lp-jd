<?php

namespace App\Services;

use App\Models\ProposalRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiProposalService
{
    protected ?string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model  = config('services.gemini.model', 'gemini-2.5-flash');
    }

    /**
     * Generate structured proposal content for a ProposalRequest
     */
    public function generateProposal(ProposalRequest $request): array
    {
        if (!empty($this->apiKey)) {
            try {
                $aiResponse = $this->callGeminiApi($request);
                if (!empty($aiResponse) && is_array($aiResponse)) {
                    return $aiResponse;
                }
            } catch (\Throwable $e) {
                Log::warning('Gemini API call failed, falling back to expert knowledge base template', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Fallback to high-fidelity template informed by the 9 official proposals
        return $this->buildFallbackProposal($request);
    }

    /**
     * Call Google Gemini API with structured JSON output
     */
    protected function callGeminiApi(ProposalRequest $request): ?array
    {
        $systemPrompt = "Anda adalah Konsultan Senior Psikologi Pendidikan & Bisnis Jatidiri.app (PT Hexagon Karyatama Indonesia).
Tugas Anda adalah menghasilkan naskah proposal penawaran kerja sama asesmen psikologi digital yang sangat profesional, persuasif, elegan, dan sesuai standar psikologi Indonesia (SIAP HIMPSI: Miryam A. Sigarlaki, M.Psi., Psikolog).
Gaya bahasa harus diplomatis, berbasis bukti (UU Sisdiknas No. 20/2003, Permendikbud Kurikulum Merdeka No. 5/2024, Juknis BOS Permendikbudristek No. 2/2024, transaksi SIPLah).
Output HARUS berupa format JSON valid tanpa tanda markdown (misal ```json).";

        $userPrompt = "Susun proposal penawaran resmi untuk institusi berikut:
- Nomor Surat: {$request->proposal_number}
- Nama Sekolah/Institusi: {$request->school_name}
- Tipe Lembaga: {$request->institution_type}
- Kota/Kabupaten: {$request->city}
- Nama PIC: {$request->pic_name}
- Jabatan PIC: {$request->pic_title}
- Email PIC: {$request->pic_email}
- No. WA: {$request->pic_phone}
- Target Sasaran: {$request->target_audience}
- Estimasi Peserta: {$request->estimated_participants} orang
- Kebutuhan Baterai Tes: " . json_encode($request->test_needs) . "
- Opsi Paket: {$request->package_type}
- Sumber Anggaran: {$request->budget_source}
- Urgensi / Keperluan: {$request->urgency_purpose}
- Catatan Tambahan: {$request->special_notes}

Struktur JSON yang wajib dihasilkan memiliki key berikut:
{
  \"nomor_surat\": string,
  \"tanggal_surat\": string,
  \"perihal\": string,
  \"lampiran\": string,
  \"tujuan_surat\": {
    \"nama_pic\": string,
    \"jabatan\": string,
    \"institusi\": string,
    \"kota\": string
  },
  \"surat_pengantar\": string,
  \"ringkasan_eksekutif\": string,
  \"latar_belakang\": string,
  \"urgensi_dan_isu\": [string],
  \"tujuan_program\": [string],
  \"baterai_tes\": [
    {
      \"nama_modul\": string,
      \"aspek_diukur\": string,
      \"manfaat_untuk_siswa_guru\": string
    }
  ],
  \"ekosistem_tambahan\": [
    {
      \"fitur\": string,
      \"deskripsi\": string
    }
  ],
  \"skema_investasi\": {
    \"nama_paket\": string,
    \"harga_per_peserta\": number,
    \"jumlah_peserta\": number,
    \"total_investasi\": number,
    \"terbilang\": string,
    \"dasar_anggaran_bos_siplah\": string,
    \"fasilitas_termasuk\": [string]
  },
  \"metode_dan_jadwal\": [
    {
      \"tahap\": string,
      \"kegiatan\": string,
      \"durasi\": string,
      \"output\": string
    }
  ],
  \"deliverables\": [string],
  \"legalitas_dan_tim\": {
    \"badan_hukum\": \"PT Hexagon Karyatama Indonesia\",
    \"penanggung_jawab_psikolog\": \"Miryam A. Sigarlaki, M.Psi., Psikolog (SIAP HIMPSI: 20100303)\",
    \"mitra_strategis\": string
  },
  \"penutup_dan_call_to_action\": string
}";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

        $response = Http::timeout(35)->post($url, [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $systemPrompt . "\n\n" . $userPrompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json',
                'temperature' => 0.3,
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if ($text) {
                return json_decode($text, true);
            }
        }

        return null;
    }

    /**
     * High fidelity proposal data built directly from Jatidiri's 9 proposal corpus
     */
    public function buildFallbackProposal(ProposalRequest $request): array
    {
        $city = $request->city ?: 'Bandung';
        $currDate = now()->translatedFormat('d F Y');
        $participants = $request->estimated_participants ?: 100;
        $unitPrice = $request->price_per_participant ?: $this->getDefaultPrice($request->package_type);
        $totalPrice = $unitPrice * $participants;

        // Custom narrative based on institution
        $type = strtolower($request->institution_type ?? '');
        $isSmk = str_contains($type, 'smk');
        $isUniv = str_contains($type, 'univ') || str_contains($type, 'kedokteran') || str_contains($type, 'kampus') || str_contains($type, 'politeknik');
        $isCorp = str_contains($type, 'corp') || str_contains($type, 'instansi') || str_contains($type, 'bumn') || str_contains($type, 'perusahaan');
        
        if ($isCorp) {
            $latarBelakang = "Dalam lanskap bisnis modern yang dinamis dan kompetitif, keberhasilan organisasi sangat ditentukan oleh keselarasan antara kompetensi individu (person-job fit) dan budaya perusahaan (person-organization fit). Jatidiri Corporate hadir menyediakan asesmen psikometri ilmiah terstandarisasi untuk mendukung siklus manajemen talenta—mulai dari rekrutmen objektif, identifikasi calon pemimpin masa depan, hingga pengelolaan kesehatan mental karyawan demi mencegah burnout dan menekan turnover.";
            $bateraiTes = [
                [
                    'nama_modul' => 'Tes Potensi Kognitif & Critical Thinking',
                    'aspek_diukur' => 'Kapasitas penalaran logika, pemecahan masalah kompleks, dan daya analisis strategis.',
                    'manfaat_untuk_siswa_guru' => 'Memprediksi kecepatan belajar (learning agility) dan efektivitas kerja staf di posisi target.'
                ],
                [
                    'nama_modul' => 'Tes Kepribadian Kerja & Sikap Kerja (DISC/PAPI)',
                    'aspek_diukur' => 'Gaya komunikasi, orientasi hasil, kepatuhan prosedur, ketahanan di bawah tekanan, & dinamika tim.',
                    'manfaat_untuk_siswa_guru' => 'Memastikan keselarasan kepribadian kandidat dengan budaya tim dan ekspektasi manajerial.'
                ],
                [
                    'nama_modul' => 'Asesmen Kepemimpinan & Manajerial (Leadership Insight)',
                    'aspek_diukur' => 'Kecakapan delegasi, pengambilan keputusan strategis, coaching tim, dan visi organisasional.',
                    'manfaat_untuk_siswa_guru' => 'Memberikan peta kesiapan promosi kepemimpinan dan kebutuhan Individual Development Plan (IDP).'
                ],
                [
                    'nama_modul' => 'WorkWell & Burnout Risk Screening',
                    'aspek_diukur' => 'Indeks stres kerja, kelelahan emosional, tingkat kepuasan kerja, & risiko turnover dini.',
                    'manfaat_untuk_siswa_guru' => 'Early warning bagi divisi SDM untuk merancang program retensi dan intervensi kesejahteraan pegawai.'
                ],
            ];
            $dasarAnggaran = "Dapat dialokasikan melalui Anggaran Divisi Human Capital/HRD, Anggaran Diklat/Pengembangan SDM, maupun Alokasi Program CSR Perusahaan.";
            $participantUnit = "Peserta / Karyawan";
        } elseif ($isUniv) {
            $latarBelakang = "Dinamika akademik di jenjang pendidikan tinggi menuntut kesiapan daya juang intelektual (adversity quotient), kesehatan mental yang prima, dan arah karier yang jelas. Jatidiri Kampus hadir sebagai solusi digital terintegrasi yang mendukung pemetaan potensi mahasiswa baru, pencegahan burnout tugas akhir, serta sistem seleksi ketat PMB berstandar HIMPSI yang akuntabel.";
            $bateraiTes = [
                [
                    'nama_modul' => 'Jatidiri Gaya Belajar & Potensi Akademik',
                    'aspek_diukur' => 'Gaya pemrosesan informasi (VAK) dan kompetensi produktif mahasiswa di perkuliahan.',
                    'manfaat_untuk_siswa_guru' => 'Membantu dosen wali dan prodi merancang strategi bimbingan akademik yang personal.'
                ],
                [
                    'nama_modul' => 'Jatidiri Cerdas Dewasa (IST / Penalaran Lanjut)',
                    'aspek_diukur' => 'Kapasitas intelektual komprehensif, logika numerik, verbal, dan penalaran spasial.',
                    'manfaat_untuk_siswa_guru' => 'Mengukur kesiapan daya nalar mahasiswa dalam menyelesaikan kurikulum tingkat sarjana/profesi.'
                ],
                [
                    'nama_modul' => 'Jatidiri Bakat & Kesiapan Karir Masa Depan',
                    'aspek_diukur' => 'Minat profesi, kesesuaian konsentrasi studi, dan kesiapan memasuki dunia kerja.',
                    'manfaat_untuk_siswa_guru' => 'Meningkatkan keterserapan lulusan (graduate employability) dan akreditasi tracer study prodi.'
                ],
                [
                    'nama_modul' => 'Jatidiri Mental Health & Kendali Stres Mahasiswa',
                    'aspek_diukur' => 'Skrining depresi ringan, kecemasan ujian, dan ketahanan menghadapi tekanan akademik/skripsi.',
                    'manfaat_untuk_siswa_guru' => 'Sistem peringatan dini bagi Unit Layanan Bimbingan & Konseling Kampus (Kampus Sehat).'
                ],
            ];
            $dasarAnggaran = "Dapat dialokasikan resmi melalui Anggaran Kemahasiswaan, Dana Penerimaan Mahasiswa Baru (PMB), atau Bantuan Program Kampus Sehat Kemendikbudristek.";
            $participantUnit = "Mahasiswa";
        } else {
            $latarBelakang = $isSmk 
                ? "Tantangan era revolusi industri menuntut lulusan Sekolah Menengah Kejuruan (SMK) tidak hanya terampil secara teknis (hard skills), namun juga memiliki kematangan mental kerja (workplace resilience), etos profesional, dan kejelasan arah karier BMW (Bekerja, Melanjutkan, Wirausaha). Berdasarkan Permendikbud No. 5 Tahun 2024 dan Kurikulum Merdeka, pemetaan diagnostik non-kognitif berkala merupakan kunci keberhasilan penempatan Praktik Kerja Lapangan (PKL) dan penyerapan lulusan ke dunia usaha/industri."
                : "Perubahan Kurikulum Merdeka menuntut sekolah untuk menyelenggarakan pembelajaran terdiferensiasi yang diawali dengan asesmen diagnostik non-kognitif yang valid dan akuntabel. Data riset nasional I-NAMHS menunjukkan 34.9% remaja mengalami tantangan kesehatan mental dan emosional, sementara rasio Guru BK di sekolah rata-rata melampaui batas ideal 1:150. Jatidiri.app hadir menjembatani tantangan ini dengan solusi terpadu.";
            
            $bateraiTes = [
                [
                    'nama_modul' => 'Jatidiri Cerdas (Cognitive Assessment)',
                    'aspek_diukur' => 'Kapasitas intelektual umum, penalaran logis, daya tangkap instruksi, & pemecahan masalah kritis.',
                    'manfaat_untuk_siswa_guru' => 'Guru memperoleh peta daya tangkap belajar kelas, mempermudah penyusunan modul ajar yang adil.'
                ],
                [
                    'nama_modul' => 'Jatidiri Bakat & Potensi (Talent Mapping)',
                    'aspek_diukur' => 'Kecenderungan minat studi lanjut, pilihan klaster karier, dan penjurusan mata pelajaran pilihan.',
                    'manfaat_untuk_siswa_guru' => 'Mencegah salah jurusan (data nasional 87% mahasiswa salah jurusan) dan memandu persiapan UTBK/SNBP.'
                ],
                [
                    'nama_modul' => 'Jatidiri Pribadi & Peran (Behavioral Style)',
                    'aspek_diukur' => 'Gaya komunikasi interpersonal, kerja sama tim, kepemimpinan, dan adaptasi sosial.',
                    'manfaat_untuk_siswa_guru' => 'Mendukung terciptanya iklim kelas bebas perundungan (anti-bullying) dan kolaborasi aktif.'
                ],
                [
                    'nama_modul' => 'Jatidiri Gigih (Adversity Quotient / Resiliensi)',
                    'aspek_diukur' => 'Daya juang menghadapi kegagalan, manajemen stres tugas, dan persistensi pencapaian target.',
                    'manfaat_untuk_siswa_guru' => 'Mendeteksi dini siswa rentan patah semangat dan menyiapkan intervensi pembinaan BK terukur.'
                ],
                [
                    'nama_modul' => 'Jatidiri Mental & Anxiety Screening',
                    'aspek_diukur' => 'Skrining tingkat kecemasan akademik, gejala stres, dan beban emosional.',
                    'manfaat_untuk_siswa_guru' => 'Sistem peringatan dini (early warning indicator) bagi Tim BK untuk siswa prioritas pendampingan.'
                ]
            ];
            $dasarAnggaran = "Dapat dialokasikan resmi melalui Dana BOS Reguler (Permendikbudristek No. 2/2024 Rekening 5.1.02.03.01.0014 Pembinaan Siswa/Ekstrakurikuler atau 5.1.02.02.01.0026 Langganan Aplikasi/Software) serta pengadaan resmi melalui SIPLah.";
            $participantUnit = "Siswa";
        }

        // Jika user / admin memilih baterai tes spesifik, gunakan modul yang dipilih secara presisi
        $testNeeds = is_array($request->test_needs) ? $request->test_needs : [];
        if (!empty($testNeeds)) {
            $metadata = $this->getAssessmentTestMetadata();
            $customBattery = [];
            foreach ($testNeeds as $tId) {
                if (isset($metadata[$tId])) {
                    $customBattery[] = $metadata[$tId];
                }
            }
            if (!empty($customBattery)) {
                $bateraiTes = $customBattery;
            }
        }

        return [
            'nomor_surat' => $request->proposal_number ?: ProposalRequest::generateNextProposalNumber(),
            'tanggal_surat' => $currDate,
            'perihal' => 'Penawaran Kerja Sama Program Asesmen Psikologi Digital & Ekosistem Terpadu',
            'lampiran' => '1 (Satu) Berkas Proposal Lengkap',
            'tujuan_surat' => [
                'nama_pic' => $request->pic_name ?: 'Pimpinan / Penanggung Jawab',
                'jabatan' => $request->pic_title ?: 'Pimpinan Lembaga / Koordinator',
                'institusi' => $request->school_name,
                'kota' => $city
            ],
            'surat_pengantar' => "Dengan hormat,\n\nSehubungan dengan komitmen peningkatan mutu pembinaan dan pengembangan sumber daya di {$request->school_name}, kami dari Jatidiri.app (PT Hexagon Karyatama Indonesia) menyampaikan proposal penawaran kerja sama penyelenggaraan Program Asesmen Psikologi Digital dan Ekosistem Terpadu Tahun 2026/2027.\n\nSeluruh instrumen Jatidiri dirancang berbasis psikometri modern terstandarisasi di bawah supervisi psikolog profesional berizin resmi (Miryam A. Sigarlaki, M.Psi., Psikolog - Nomor SIAP HIMPSI: 20100303), menjamin validitas, reliabilitas, dan kepatuhan kode etik psikologi Indonesia.",
            'ringkasan_eksekutif' => "Program ini merupakan solusi komprehensif yang memadukan asesmen psikologi digital via platform Jatidiri.app, akses Executive Dashboard analitik institusi, modul pelaporan berbasis data, serta layanan konseling pendampingan HalloPsy guna mewujudkan ekosistem yang sehat mental, produktif, dan berkinerja unggul.",
            'latar_belakang' => $latarBelakang,
            'urgensi_dan_isu' => [
                "Kebutuhan pemetaan diagnostik objektif berbasis data psikometrik terstandarisasi.",
                "Optimalisasi potensi individu sesuai peran dan sasaran strategis institusi.",
                "Deteksi dini potensi burnout, kecemasan, dan tantangan psikososial di lingkungan lembaga.",
                "Penyediaan laporan diagnostik yang komprehensif, akuntabel, dan mudah dipahami."
            ],
            'tujuan_program' => [
                "Memberikan laporan profil psikologis individual yang mendalam dan solutif.",
                "Menyediakan data agregat institusi secara instan di Executive Dashboard.",
                "Menyelenggarakan bimbingan teknis dan seminar pembacaan hasil asesmen bersama tim psikolog.",
                "Membekali institusi dengan sistem rujukan pendampingan psikologis lanjutan melalui HalloPsy."
            ],
            'baterai_tes' => $bateraiTes,
            'ekosistem_tambahan' => [
                [
                    'fitur' => 'Executive Dashboard & Analitik Data Real-Time',
                    'deskripsi' => 'Akses dashboard interaktif untuk memantau pemetaan potensi, radar resiliensi, dan analitik agregat.'
                ],
                [
                    'fitur' => 'HalloPsy (Konseling Profesional & Pendampingan)',
                    'deskripsi' => 'Kanal konseling 1-on-1 bersama psikolog profesional ber-SIPP bagi individu yang membutuhkan bimbingan lanjutan.'
                ],
                [
                    'fitur' => 'Bimbingan Teknis & Pembacaan Hasil oleh Tim Psikolog',
                    'deskripsi' => 'Sesi pemaparan komprehensif bagi pimpinan/pengelola untuk menindaklanjuti rekomendasi asesmen.'
                ]
            ],
            'skema_investasi' => [
                'nama_paket' => $this->getPackageName($request->package_type),
                'harga_per_peserta' => (float) $unitPrice,
                'jumlah_peserta' => (int) $participants,
                'total_investasi' => (float) $totalPrice,
                'terbilang' => $this->terbilang($totalPrice) . ' Rupiah',
                'dasar_anggaran_bos_siplah' => $dasarAnggaran,
                'fasilitas_termasuk' => [
                    "Akses seluruh modul asesmen digital via platform web/mobile Jatidiri.app",
                    "Laporan individual format PDF (full color, grafik interpretasi)",
                    "Akses Executive Dashboard Institusi selama masa kemitraan",
                    "Seminar Pembacaan Hasil & Bedah Kasus bersama Psikolog SIPP",
                    "Bimtek optimalisasi data asesmen bagi tim pembina / manajemen",
                    "Voucher sesi pendampingan awal HalloPsy"
                ]
            ],
            'metode_dan_jadwal' => [
                [
                    'tahap' => 'Tahap 1: Persiapan & Sinkronisasi Data',
                    'kegiatan' => 'Rapat koordinasi teknis, penginputan daftar peserta, dan pembuatan akun akses serempak.',
                    'durasi' => 'Hari ke 1 - 3',
                    'output' => 'Daftar akun & token ujian siap digunakan'
                ],
                [
                    'tahap' => 'Tahap 2: Pelaksanaan Asesmen Daring',
                    'kegiatan' => 'Pengerjaan tes serempak di lab komputer sekolah/kampus/kantor atau perangkat masing-masing.',
                    'durasi' => 'Hari ke 4 - 6',
                    'output' => '100% data jawaban terekam di sistem cloud Jatidiri'
                ],
                [
                    'tahap' => 'Tahap 3: Olah Data Psikometrik & Scoring',
                    'kegiatan' => 'Pemrosesan algoritma psikometri, verifikasi psikolog penanggung jawab, & generate laporan.',
                    'durasi' => 'Hari ke 7 - 9',
                    'output' => 'Laporan individual PDF & agregat dashboard terbit'
                ],
                [
                    'tahap' => 'Tahap 4: Diseminasi, Seminar Hasil, & Bimtek',
                    'kegiatan' => 'Seminar pemaparan hasil untuk manajemen/pembina dan serah terima dokumen resmi.',
                    'durasi' => 'Hari ke 10 - 14',
                    'output' => 'Institusi menguasai peta potensi dan rencana tindak lanjut terarah'
                ]
            ],
            'deliverables' => [
                "Dokumen Laporan Individual ({$participantUnit}) Format PDF",
                'Dokumen Rekapitulasi & Peta Potensi Institusi',
                'Hak Akses Akun Executive Dashboard Analitik',
                'Sertifikat Partisipasi & Bimbingan Teknis',
                'Sesi Seminar Presentasi Hasil oleh Psikolog Berizin'
            ],
            'legalitas_dan_tim' => [
                'badan_hukum' => 'PT Hexagon Karyatama Indonesia',
                'penanggung_jawab_psikolog' => 'Miryam A. Sigarlaki, M.Psi., Psikolog (SIAP HIMPSI: 20100303, Aktif s.d 2028)',
                'mitra_strategis' => 'MGBK Indonesia, AP2TPI, Afiliasi ICICP UNJANI, dan Pengadaan Resmi Mitra SIPLah Kemendikdasmen RI'
            ],
            'penutup_dan_call_to_action' => "Demikian proposal penawaran kerja sama ini kami sampaikan. Kami meyakini bahwa kolaborasi antara {$request->school_name} dan Jatidiri.app akan memberikan dampak transformatif bagi pengembangan potensi sumber daya yang ada. Atas perhatian dan kerja sama yang baik, kami ucapkan terima kasih."
        ];
    }

    public function getPackageName(?string $tier): string
    {
        return match(strtolower($tier ?? '')) {
            'school_starter', 'starter' => 'Jatidiri School Starter',
            'school_advance', 'advance' => 'Jatidiri School Advance (Rekomendasi)',
            'school_ultimate', 'ultimate' => 'Jatidiri School Ultimate',
            'campus_efisien' => 'Jatidiri Kampus - Paket Efisien',
            'campus_komprehensif' => 'Jatidiri Kampus - Paket Komprehensif (Rekomendasi)',
            'campus_pmb_seleksi', 'pmb' => 'Jatidiri Kampus - Paket Seleksi PMB / Kedokteran',
            'corp_basic' => 'Jatidiri Corporate - Basic Fit (Screening)',
            'corp_professional' => 'Jatidiri Corporate - Professional Match (Rekomendasi)',
            'corp_leader' => 'Jatidiri Corporate - Leader Insight & Development',
            'corp_wellness' => 'Jatidiri Corporate - WorkWell & Retention Check',
            'custom' => 'Jatidiri Custom Tailored Package',
            default => 'Jatidiri Advance Package',
        };
    }

    protected function getDefaultPrice(?string $tier): float
    {
        return match(strtolower($tier ?? '')) {
            'school_starter', 'starter' => 35000.0,
            'school_advance', 'advance' => 145000.0,
            'school_ultimate', 'ultimate' => 245000.0,
            'campus_efisien' => 75000.0,
            'campus_komprehensif' => 150000.0,
            'campus_pmb_seleksi', 'pmb' => 250000.0,
            'corp_basic' => 350000.0,
            'corp_professional' => 650000.0,
            'corp_leader' => 1200000.0,
            'corp_wellness' => 250000.0,
            'custom' => 145000.0,
            default => 145000.0,
        };
    }

    protected function terbilang(float $angka): string
    {
        $angka = abs((int)$angka);
        $baca = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        
        if ($angka < 12) {
            return $baca[$angka];
        } elseif ($angka < 20) {
            return $this->terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            return $this->terbilang((int)($angka / 10)) . ' Puluh ' . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            return 'Seratus ' . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return $this->terbilang((int)($angka / 100)) . ' Ratus ' . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            return 'Seribu ' . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return $this->terbilang((int)($angka / 1000)) . ' Ribu ' . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return $this->terbilang((int)($angka / 1000000)) . ' Juta ' . $this->terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            return $this->terbilang((int)($angka / 1000000000)) . ' Miliar ' . $this->terbilang($angka % 1000000000);
        }
        return (string)$angka;
    }

    /**
     * Master metadata for 24 psychological assessment tools (from ExplorasiSection.vue) + services
     */
    public function getAssessmentTestMetadata(): array
    {
        return [
            'belajar' => [
                'nama_modul' => 'Jatidiri Belajar (Instrumen Gaya Belajar VAK)',
                'aspek_diukur' => 'Gaya belajar visual, auditori, dan kinestetik untuk pemetaan modalitas belajar.',
                'manfaat_untuk_siswa_guru' => 'Guru dan pengajar dapat merancang pembelajaran terdiferensiasi dan metode ajar yang efektif.'
            ],
            'jatidiri' => [
                'nama_modul' => 'Jatidiri Komprehensif (Minat, Bakat, & Karir)',
                'aspek_diukur' => 'Pemetaan holistik minat keilmuan, bakat dominan, dan kecenderungan kepribadian.',
                'manfaat_untuk_siswa_guru' => 'Panduan terpadu penentuan arah masa depan dan pengambilan keputusan akademik.'
            ],
            'cerdas' => [
                'nama_modul' => 'Jatidiri Cerdas (Kognitif G-Factor)',
                'aspek_diukur' => 'Kemampuan logika, analisis numerik, penalaran abstrak, dan pemecahan masalah dasar.',
                'manfaat_untuk_siswa_guru' => 'Memetakan daya tangkap belajar dan kesiapan kognitif dalam menguasai kurikulum.'
            ],
            'bahagia' => [
                'nama_modul' => 'Jatidiri Bahagia (Subjective Well-being)',
                'aspek_diukur' => 'Tingkat kebahagiaan, kepuasan hidup, dan keseimbangan emosional individu.',
                'manfaat_untuk_siswa_guru' => 'Mendeteksi kepuasan hidup serta membangun iklim psikologis yang sehat dan positif.'
            ],
            'anxiety' => [
                'nama_modul' => 'Jatidiri Anxiety (Skrining Kecemasan)',
                'aspek_diukur' => 'Tingkat kecemasan akademik, kecemasan sosial, dan kecenderungan psikosomatis.',
                'manfaat_untuk_siswa_guru' => 'Sistem peringatan dini bagi tim BK/HRD untuk intervensi dan konseling pendampingan.'
            ],
            'bakat' => [
                'nama_modul' => 'Jatidiri Bakat (Talent Mapping)',
                'aspek_diukur' => 'Pemetaan bakat alami, keunikan potensi, dan kekuatan dominan yang siap diasah.',
                'manfaat_untuk_siswa_guru' => 'Mengarahkan pengembangan potensi optimal dan meminimalisir salah peminatan studi/kerja.'
            ],
            'kendali_stress' => [
                'nama_modul' => 'Jatidiri Kendali Stress (PSS / Perceived Stress)',
                'aspek_diukur' => 'Persepsi beban tekanan hidup/tugas, reaksi stres emosional, dan daya kendali diri.',
                'manfaat_untuk_siswa_guru' => 'Mengetahui tingkat kelelahan mental untuk merancang program manajemen stres terarah.'
            ],
            'kendali' => [
                'nama_modul' => 'Jatidiri Kendali Gadget (Digital Screen Time)',
                'aspek_diukur' => 'Regulasi penggunaan smartphone, kontrol screen-time, dan ketergantungan media digital.',
                'manfaat_untuk_siswa_guru' => 'Menghindari distraksi belajar dan meningkatkan fokus produktif di lingkungan formal.'
            ],
            'kesehatan_mental' => [
                'nama_modul' => 'Jatidiri Kesehatan Mental (WorkWell / Mental Wellness)',
                'aspek_diukur' => 'Kestabilan emosi, fokus, energi harian, dan deteksi dini kelelahan mental.',
                'manfaat_untuk_siswa_guru' => 'Menjaga stamina psikologis individu agar terhindar dari krisis mental atau burnout.'
            ],
            'potensi' => [
                'nama_modul' => 'Jatidiri Potensi (Strength Typology ST-30)',
                'aspek_diukur' => 'Pemetaan 30 tipologi kekuatan peran kerja, kepemimpinan, dan produktivitas.',
                'manfaat_untuk_siswa_guru' => 'Penempatan peran tugas yang tepat (the right person on the right job/project).'
            ],
            'karir' => [
                'nama_modul' => 'Jatidiri Karir (Career Planning & BMW)',
                'aspek_diukur' => 'Perencanaan karir terpadu: Bekerja, Melanjutkan studi, atau Wirausaha (BMW).',
                'manfaat_untuk_siswa_guru' => 'Meningkatkan kesiapan karir, employability rate, dan akurasi penjurusan lanjut.'
            ],
            'cerdas_dewasa' => [
                'nama_modul' => 'Jatidiri Cerdas Dewasa (IST / Kognitif Lanjut)',
                'aspek_diukur' => 'Kapasitas intelektual komprehensif, logika deduktif-induktif, dan adaptasi kerja lanjut.',
                'manfaat_untuk_siswa_guru' => 'Standar kesiapan berpikir tingkat tinggi untuk jenjang universitas dan rekrutmen profesional.'
            ],
            'adaptasi_budaya' => [
                'nama_modul' => 'Jatidiri Adaptasi Budaya (Cross-Cultural Fit)',
                'aspek_diukur' => 'Kemampuan menyesuaikan diri dengan lingkungan baru, keberagaman sosial, dan budaya organisasi.',
                'manfaat_untuk_siswa_guru' => 'Membantu adaptasi mahasiswa baru, perantau, maupun karyawan baru dalam onboarding.'
            ],
            'grafis' => [
                'nama_modul' => 'Jatidiri Grafis (Proyektif Baum/Wartegg)',
                'aspek_diukur' => 'Eksplorasi kepribadian bawah sadar, kestabilan emosi mendalam, dan motivasi psikologis.',
                'manfaat_untuk_siswa_guru' => 'Analisis klinis mendalam untuk kebutuhan seleksi khusus (kedokteran, posisi berisiko).'
            ],
            'leadership' => [
                'nama_modul' => 'Jatidiri Leadership (Gaya Kepemimpinan)',
                'aspek_diukur' => 'Gaya memimpin, pengambilan keputusan di bawah tekanan, delegasi, dan pengaruh sosial.',
                'manfaat_untuk_siswa_guru' => 'Mempersiapkan kader organisasi, OSIS, BEM, serta suksesi manajerial corporate.'
            ],
            'religius' => [
                'nama_modul' => 'Jatidiri Religius (Spiritualitas & Integritas)',
                'aspek_diukur' => 'Refleksi nilai spiritual, kepatuhan etika, kejujuran nurani, dan komitmen moral.',
                'manfaat_untuk_siswa_guru' => 'Membangun karakter luhur dan integritas tinggi bagi calon pemimpin dan profesional.'
            ],
            'dap' => [
                'nama_modul' => 'Jatidiri DAP (Draw A Person)',
                'aspek_diukur' => 'Dinamika citra diri (self-concept), kepercayaan diri, dan proyeksi relasi interpersonal.',
                'manfaat_untuk_siswa_guru' => 'Memberikan potret kepribadian proyektif komplementer dalam asesmen psikologi formal.'
            ],
            'tangguh' => [
                'nama_modul' => 'Jatidiri Tangguh (Resiliensi BRI / Adversity Quotient)',
                'aspek_diukur' => 'Daya juang, ketahanan menghadapi rintangan, dan kapasitas bangkit dari kegagalan.',
                'manfaat_untuk_siswa_guru' => 'Menyaring individu yang pantang menyerah dan adaptif terhadap target tantangan tinggi.'
            ],
            'nalar_cfit' => [
                'nama_modul' => 'Jatidiri Nalar (CFIT / Culture Fair Intelligence)',
                'aspek_diukur' => 'Kecerdasan non-verbal, penalaran pola abstrak, dan kecepatan analisis bebas bias budaya.',
                'manfaat_untuk_siswa_guru' => 'Standar seleksi objektif yang adil untuk seluruh latar belakang suku dan daerah.'
            ],
            'cendekia' => [
                'nama_modul' => 'Jatidiri Cendekia (Academic Aptitude)',
                'aspek_diukur' => 'Potensi intelektual belajar, kemampuan analisis pola logika visual, dan retensi informasi.',
                'manfaat_untuk_siswa_guru' => 'Mengidentifikasi potensi bakat akademik unggulan (gifted/accelerated potential).'
            ],
            'personal' => [
                'nama_modul' => 'Jatidiri Personal (Karakter & Motivasi Diri)',
                'aspek_diukur' => 'Karakter bawaan, preferensi perilaku dasar, dan pendorong motivasi intrinsik individu.',
                'manfaat_untuk_siswa_guru' => 'Memberikan pemahaman mendalam tentang cara memotivasi dan memperlakukan setiap individu.'
            ],
            'pribadi' => [
                'nama_modul' => 'Jatidiri Pribadi (Kepribadian Kerja DISC/PAPI)',
                'aspek_diukur' => 'Karakter kerja, gaya komunikasi tim, kepatuhan prosedur, dan stabilitas emosi formal.',
                'manfaat_untuk_siswa_guru' => 'Menciptakan keharmonisan kerja tim, mengurangi konflik interpersonal, dan memacu sinergi.'
            ],
            'kematangan_sd' => [
                'nama_modul' => 'Jatidiri Kematangan SD (School Readiness)',
                'aspek_diukur' => 'Kesiapan kognitif dasar, motorik halus/kasar, regulasi emosi, dan kemandirian sosial anak.',
                'manfaat_untuk_siswa_guru' => 'Membantu guru SD dan orang tua mendeteksi kesiapan masuk sekolah dasar secara tepat.'
            ],
            'figur_frt' => [
                'nama_modul' => 'Jatidiri Figur (FRT / Figure Reasoning)',
                'aspek_diukur' => 'Kemampuan berpikir logis analitis sistematis melalui penalaran relasi figur spasial.',
                'manfaat_untuk_siswa_guru' => 'Mengukur daya analisis tingkat tinggi untuk bidang teknik, sains, IT, dan pemecahan masalah.'
            ],
            'hallopsy' => [
                'nama_modul' => 'Layanan HalloPsy (Konseling Psikolog Berizin SIPP)',
                'aspek_diukur' => 'Konseling psikologis mendalam, penanganan kecemasan/stres, dan pendampingan personal.',
                'manfaat_untuk_siswa_guru' => 'Kanal bantuan profesional langsung bagi individu yang terdeteksi membutuhkan pendampingan.'
            ],
            'peer_counselor' => [
                'nama_modul' => 'Certified Peer Counselor (Pelatihan Duta Konselor)',
                'aspek_diukur' => 'Pelatihan active listening, empati psikologis, dan pertolongan pertama kesehatan mental.',
                'manfaat_untuk_siswa_guru' => 'Membentuk duta konselor sebaya di lingkungan institusi sebagai garda terdepan BK/HRD.'
            ],
        ];
    }
}
