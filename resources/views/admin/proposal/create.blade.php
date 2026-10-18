@extends('layouts.app', ['title' => 'Buat Proposal Baru'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <div>
                            <h4 class="card-title font-weight-bold text-dark mb-1">
                                <i class="mdi mdi-file-document-edit text-primary mr-1"></i> Form Input Proposal Kemitraan Baru
                            </h4>
                            <p class="text-muted small mb-0">Isi data calon mitra sekolah/institusi untuk menghasilkan proposal penawaran otomatis dengan AI.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.proposal.index') }}" class="btn btn-outline-secondary btn-sm btn-rounded">
                                <i class="mdi mdi-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="mdi mdi-alert"></i> Terdapat kesalahan input:</strong>
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

                    <form action="{{ route('admin.proposal.store') }}" method="POST" id="proposalForm">
                        @csrf

                        <!-- SECTION 1: PROFIL LEMBAGA / SEKOLAH -->
                        <h6 class="text-primary font-weight-bold text-uppercase mb-3" style="letter-spacing: 0.5px; font-size: 13px;">
                            <i class="mdi mdi-domain mr-1"></i> 1. Identitas Institusi &amp; Nomor Registrasi
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="text-label font-weight-bold">Nomor Surat Proposal Resmi</label>
                                <input type="text" class="form-control" name="proposal_number" value="{{ old('proposal_number', $nextProposalNumber) }}" placeholder="Contoh: 011/JTD-EDU/X/2026">
                                <small class="form-text text-muted">Format standar: <code>[No]/JTD-EDU/[BulanRomawi]/[Tahun]</code></small>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="text-label font-weight-bold">Nama Sekolah / Lembaga Mitra <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="school_name" value="{{ old('school_name') }}" placeholder="Contoh: SMAN 3 Bandung, SMKN 1 Bandung, FK Unpas" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-label font-weight-bold">Tipe Lembaga <span class="text-danger">*</span></label>
                                <select class="form-control" name="institution_type" id="institution_type" onchange="onInstitutionChange()" required>
                                    <optgroup label="── JATIDIRI SEKOLAH ──">
                                        <option value="sma" {{ old('institution_type') == 'sma' ? 'selected' : '' }}>SMA (Sekolah Menengah Atas)</option>
                                        <option value="smk" {{ old('institution_type') == 'smk' ? 'selected' : '' }}>SMK (Vokasi / Kejuruan)</option>
                                        <option value="smp" {{ old('institution_type') == 'smp' ? 'selected' : '' }}>SMP (Sekolah Menengah Pertama)</option>
                                        <option value="sd" {{ old('institution_type') == 'sd' ? 'selected' : '' }}>SD / Madrasah Ibtidaiyah</option>
                                        <option value="yayasan" {{ old('institution_type') == 'yayasan' ? 'selected' : '' }}>Yayasan Pendidikan (Multi-Unit)</option>
                                    </optgroup>
                                    <optgroup label="── JATIDIRI KAMPUS ──">
                                        <option value="universitas" {{ old('institution_type') == 'universitas' ? 'selected' : '' }}>Perguruan Tinggi / Universitas</option>
                                        <option value="fk_kedokteran" {{ old('institution_type') == 'fk_kedokteran' ? 'selected' : '' }}>Fakultas Kedokteran / Kesehatan</option>
                                        <option value="pmb_kampus" {{ old('institution_type') == 'pmb_kampus' ? 'selected' : '' }}>Panitia PMB Kampus / Maba</option>
                                        <option value="politeknik" {{ old('institution_type') == 'politeknik' ? 'selected' : '' }}>Politeknik / Vokasi</option>
                                    </optgroup>
                                    <optgroup label="── JATIDIRI CORPORATE ──">
                                        <option value="corporate" {{ old('institution_type') == 'corporate' ? 'selected' : '' }}>Perusahaan Swasta / Korporasi</option>
                                        <option value="bumn_instansi" {{ old('institution_type') == 'bumn_instansi' ? 'selected' : '' }}>BUMN / Instansi Pemerintah / Dinas</option>
                                        <option value="rumah_sakit" {{ old('institution_type') == 'rumah_sakit' ? 'selected' : '' }}>Rumah Sakit / Fasilitas Kesehatan</option>
                                        <option value="csr_filantropi" {{ old('institution_type') == 'csr_filantropi' ? 'selected' : '' }}>Program CSR / Lembaga Filantropi</option>
                                    </optgroup>
                                </select>
                                <small class="text-primary mt-1 d-block font-weight-bold" id="institution_category_badge">
                                    <i class="mdi mdi-check-circle"></i> Kategori: JATIDIRI SEKOLAH
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-label font-weight-bold">Kota / Kabupaten</label>
                                <input type="text" class="form-control" name="city" value="{{ old('city', 'Bandung') }}" placeholder="Contoh: Kota Bandung, Cimahi, Kab. Indramayu, Jakarta">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-label font-weight-bold">Target Sasaran Peserta</label>
                                <input type="text" class="form-control" name="target_audience" id="target_audience" value="{{ old('target_audience', 'Siswa Kelas X & XII') }}" placeholder="Contoh: Siswa Kelas X (Angkatan Baru), Maba 2026, Karyawan Staff">
                            </div>
                        </div>

                        <!-- SECTION 2: DATA PIC (PERSON IN CHARGE) -->
                        <h6 class="text-primary font-weight-bold text-uppercase mt-4 mb-3 border-top pt-3" style="letter-spacing: 0.5px; font-size: 13px;">
                            <i class="mdi mdi-account-tie mr-1"></i> 2. Data PIC / Pembuat Keputusan di Institusi
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-label font-weight-bold">Nama Lengkap PIC &amp; Gelar <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pic_name" value="{{ old('pic_name') }}" placeholder="Contoh: Dra. Hj. Siti Rohmah, M.M.Pd." required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-label font-weight-bold">Jabatan PIC</label>
                                <input type="text" class="form-control" name="pic_title" value="{{ old('pic_title', 'Kepala Sekolah / Koordinator Guru BK') }}" placeholder="Contoh: Kepala Sekolah, Dekan, HRD Manager">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-label font-weight-bold">Nomor WhatsApp PIC <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="mdi mdi-whatsapp text-success"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="pic_phone" value="{{ old('pic_phone') }}" placeholder="Contoh: 081234567890" required>
                                </div>
                                <small class="form-text text-muted">Akan digunakan untuk notifikasi konfirmasi dan pengiriman naskah.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-label font-weight-bold">Email PIC / Institusi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                    </div>
                                    <input type="email" class="form-control" name="pic_email" value="{{ old('pic_email') }}" placeholder="Contoh: pic.mitra@gmail.com" required>
                                </div>
                                <small class="form-text text-muted">Proposal PDF resmi akan dikirimkan ke alamat email ini.</small>
                            </div>
                        </div>

                        <!-- SECTION 3: BATERAI TES & INSTRUMEN -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 mb-3 border-top pt-3">
                            <h6 class="text-primary font-weight-bold text-uppercase mb-0" style="letter-spacing: 0.5px; font-size: 13px;">
                                <i class="mdi mdi-brain mr-1"></i> 3. Kebutuhan Baterai Tes Psikologi Digital
                            </h6>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge badge-primary px-2 py-1 mr-2" id="selected_tests_count_badge">0 Modul Dipilih</span>
                                <button type="button" class="btn btn-outline-primary btn-xs py-1 px-2 mr-1" onclick="resetToCurrentPackageTests()">
                                    Sesuai Paket
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-xs py-1 px-2 mr-1" onclick="selectAllFilteredTests()">
                                    Pilih Semua
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-xs py-1 px-2" onclick="clearAllTests()">
                                    Reset
                                </button>
                            </div>
                        </div>

                        <!-- FILTER TABS & SEARCH -->
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-7 mb-2 mb-md-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-primary" id="btn_filter_recommended" onclick="setTestFilterMode('recommended')">
                                        <i class="mdi mdi-star mr-1"></i> Rekomendasi Lembaga
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="btn_filter_all" onclick="setTestFilterMode('all')">
                                        <i class="mdi mdi-view-grid mr-1"></i> Semua 24 Alat Tes Asesmen
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="test_search_input" placeholder="Cari tes (e.g. CFIT, Bakat, Stres)..." oninput="onTestSearchInput()">
                                </div>
                            </div>
                        </div>

                        <div class="row" id="test_needs_container" style="max-height: 480px; overflow-y: auto;">
                            <!-- Populated dynamically by JavaScript -->
                        </div>

                        <!-- SECTION 4: SKEMA PAKET, HARGA, & ANGGARAN -->
                        <h6 class="text-primary font-weight-bold text-uppercase mt-4 mb-3 border-top pt-3" style="letter-spacing: 0.5px; font-size: 13px;">
                            <i class="mdi mdi-cash-multiple mr-1"></i> 4. Skema Paket Penawaran &amp; Anggaran
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="text-label font-weight-bold">Tingkatan Paket <span class="text-danger">*</span></label>
                                <select class="form-control font-weight-bold" name="package_type" id="package_type" onchange="onPackageChange()" required>
                                    <!-- Populated dynamically by JavaScript -->
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="text-label font-weight-bold">Harga per Peserta (Rp)</label>
                                <input type="number" class="form-control font-weight-bold text-primary" name="price_per_participant" id="price_per_participant" value="145000" oninput="calculateTotal()">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="text-label font-weight-bold">Estimasi Jumlah Peserta (<span id="participant_unit_text">Siswa</span>)</label>
                                <input type="number" class="form-control" name="estimated_participants" id="estimated_participants" value="{{ old('estimated_participants', 200) }}" oninput="calculateTotal()">
                            </div>
                        </div>

                        <!-- TOTAL PREVIEW BANNER -->
                        <div class="p-3 mb-3 rounded" style="background-color: #F1F5F9; border-left: 4px solid #1E3A8A;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small text-uppercase font-weight-bold">Estimasi Total Nilai Proposal:</span>
                                    <h4 class="mb-0 text-primary font-weight-bold" id="total_display">Rp 29.000.000</h4>
                                </div>
                                <div class="text-right">
                                    <span class="badge badge-primary px-3 py-2 text-uppercase" id="package_badge">School Advance</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-label font-weight-bold">Rujukan Sumber Anggaran</label>
                                <select class="form-control" name="budget_source" id="budget_source">
                                    <option value="bos_siplah" selected>Dana BOS Reguler Permendikbud &amp; SIPLah (Akun 5.1.02.03.01.0014)</option>
                                    <option value="bopd">BOPD Pemprov Jabar (Akun Digitalisasi BK &amp; Mental Health)</option>
                                    <option value="kampus">Anggaran PMB / Kemahasiswaan Perguruan Tinggi</option>
                                    <option value="corporate_hrd">Anggaran HRD / Pelatihan &amp; Diklat Karyawan</option>
                                    <option value="csr">Sponsorship / Program CSR Perusahaan / BAZNAS</option>
                                    <option value="yayasan">Anggaran Terpusat Yayasan Pendidikan</option>
                                    <option value="mandiri">Iuran Mandiri / Komite</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-label font-weight-bold">Urgensi / Tujuan Khusus Program</label>
                                <input type="text" class="form-control" name="urgency_purpose" id="urgency_purpose" value="{{ old('urgency_purpose', 'Pemetaan Diagnostik Kurikulum Merdeka & Konsentrasi Pilihan') }}" placeholder="Contoh: Kesiapan PKL & Budaya Industri SMK, Seleksi PMB FK, Asesmen Kepemimpinan">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-label font-weight-bold">Catatan Tambahan / Permintaan Khusus</label>
                            <textarea class="form-control" name="special_notes" rows="3" placeholder="Tuliskan catatan khusus dari hasil diskusi awal (misal: perlu tester psikolog hadir offline, butuh jadwal khusus, dll.)">{{ old('special_notes') }}</textarea>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="d-flex flex-wrap justify-content-end align-items-center border-top pt-3 mt-4">
                            <button type="submit" name="action" value="save" class="btn btn-secondary mr-3 mb-2">
                                <i class="mdi mdi-content-save mr-1"></i> Simpan Draf Saja
                            </button>
                            <button type="submit" name="action" value="save_and_generate" class="btn btn-primary shadow-sm mb-2">
                                <i class="mdi mdi-robot mr-1"></i> Simpan &amp; Generate AI Proposal (Gemini)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const packagesData = {
    sekolah: [
        { id: 'school_starter', name: 'School Starter', price: 35000, desc: 'Rp 35.000 / siswa (Tes Gaya Belajar & Potensi Dasar)', defaultTests: ['belajar', 'potensi'] },
        { id: 'school_advance', name: 'School Advance (Rekomendasi)', price: 145000, desc: 'Rp 145.000 / siswa (Tes Lengkap: IQ Cerdas, Minat Bakat, Karir, Gadget + BK + HalloPsy)', defaultTests: ['bakat', 'cerdas', 'belajar', 'karir', 'kendali', 'anxiety', 'hallopsy'] },
        { id: 'school_ultimate', name: 'School Ultimate', price: 245000, desc: 'Rp 245.000 / siswa (All-in: Bakat, IQ, Karir, Bahagia, Mental + BK Digital + Peer Counselor)', defaultTests: ['bakat', 'cerdas', 'belajar', 'karir', 'kendali', 'anxiety', 'bahagia', 'kesehatan_mental', 'potensi', 'tangguh', 'hallopsy', 'peer_counselor'] },
        { id: 'custom', name: 'Custom Package', price: 145000, desc: 'Harga Khusus Kesepakatan', defaultTests: ['belajar', 'bakat', 'cerdas'] }
    ],
    kampus: [
        { id: 'campus_efisien', name: 'Paket Efisien Kampus', price: 75000, desc: 'Rp 75.000 / mhs (Gaya Belajar & Potensi Maba, Skrining Anxiety, Bahagia & Mental)', defaultTests: ['belajar', 'potensi', 'bahagia', 'anxiety', 'kesehatan_mental'] },
        { id: 'campus_komprehensif', name: 'Paket Komprehensif Kampus (Rekomendasi)', price: 150000, desc: 'Rp 150.000 / mhs (Asesmen Lengkap: Belajar, IQ IST, Bakat Karir, Stres, Mental + HalloPsy)', defaultTests: ['belajar', 'cerdas_dewasa', 'bakat', 'potensi', 'bahagia', 'kendali_stress', 'anxiety', 'kesehatan_mental', 'kendali', 'hallopsy'] },
        { id: 'campus_pmb_seleksi', name: 'Paket Seleksi PMB / Kedokteran', price: 250000, desc: 'Rp 250.000 / mhs (Standar PMB/FK: Kognitif IST, CFIT, FRT, Stres, Tangguh, Grafis, DAP + HalloPsy)', defaultTests: ['cerdas_dewasa', 'nalar_cfit', 'figur_frt', 'potensi', 'kendali_stress', 'tangguh', 'grafis', 'dap', 'hallopsy'] },
        { id: 'custom', name: 'Custom Package', price: 150000, desc: 'Harga Khusus Kesepakatan Kampus', defaultTests: ['belajar', 'cerdas_dewasa', 'potensi'] }
    ],
    corporate: [
        { id: 'corp_basic', name: 'Basic Fit (Screening)', price: 350000, desc: 'Rp 350.000 / peserta (Entry/Staff: Kognitif Cerdas Dewasa, Kepribadian Kerja, Integritas)', defaultTests: ['cerdas_dewasa', 'pribadi', 'religius'] },
        { id: 'corp_professional', name: 'Professional Match (Rekomendasi)', price: 650000, desc: 'Rp 650.000 / peserta (Supervisor: IQ Lengkap, CFIT, DISC/PAPI, Motivasi Personal, Stres + HalloPsy)', defaultTests: ['cerdas_dewasa', 'nalar_cfit', 'pribadi', 'personal', 'potensi', 'kendali_stress', 'hallopsy'] },
        { id: 'corp_leader', name: 'Leader Insight & Development', price: 1200000, desc: 'Rp 1.200.000 / peserta (Managerial: Leadership, CFIT & FRT, Kepribadian, Tangguh + In-Basket IDP)', defaultTests: ['leadership', 'cerdas_dewasa', 'nalar_cfit', 'figur_frt', 'pribadi', 'potensi', 'tangguh'] },
        { id: 'corp_wellness', name: 'WorkWell & Retention Check', price: 250000, desc: 'Rp 250.000 / peserta (Kesehatan Mental WorkWell, Kendali Stres PSS, Tangguh & HalloPsy EAP)', defaultTests: ['kesehatan_mental', 'kendali_stress', 'tangguh', 'hallopsy'] },
        { id: 'custom', name: 'Custom Package', price: 500000, desc: 'Harga Khusus Kesepakatan Corporate', defaultTests: ['cerdas_dewasa', 'pribadi'] }
    ]
};

// 24 Alat Tes Asesmen Psikologi Resmi (sesuai Halaman Asesmen Psikologi / ExplorasiSection.vue) + Layanan Pendukung
const masterTestsList = [
    { id: 'belajar', name: 'Jatidiri Belajar', category: 'Bakat & Karir', desc: 'Tes instrumen gaya belajar (VAK) untuk efektivitas diferensiasi belajar siswa/mahasiswa.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'jatidiri', name: 'Jatidiri (Komprehensif)', category: 'Bakat & Karir', desc: 'Tes komprehensif minat, bakat & kepribadian untuk membantu menentukan pilihan karir & studi.', categories: ['sekolah', 'kampus'] },
    { id: 'cerdas', name: 'Jatidiri Cerdas', category: 'Kognitif & Logika', desc: 'Tes kecerdasan umum (G-Factor) mengukur logika, analisis, numerik & penalaran IQ dasar.', categories: ['sekolah', 'kampus'] },
    { id: 'bahagia', name: 'Jatidiri Bahagia', category: 'Kesehatan Mental', desc: 'Tes kesejahteraan subjektif mengukur kebahagiaan, kepuasan hidup & keseimbangan emosi.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'anxiety', name: 'Jatidiri Anxiety', category: 'Kesehatan Mental', desc: 'Tes skrining kecemasan untuk mendeteksi kecemasan ujian, akademik & kehidupan sehari-hari.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'bakat', name: 'Jatidiri Bakat', category: 'Bakat & Karir', desc: 'Tes pemetaan bakat alami untuk mengidentifikasi kekuatan unik menuju kesuksesan masa depan.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'kendali_stress', name: 'Jatidiri Kendali Stress', category: 'Kesehatan Mental', desc: 'Tes skala stres (PSS) mengukur persepsi beban situasi hidup/tugas yang penuh tekanan.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'kendali', name: 'Jatidiri Kendali Gadget', category: 'Kesehatan Mental', desc: 'Tes ketergantungan digital mengukur kemampuan mengendalikan penggunaan gadget & internet.', categories: ['sekolah', 'kampus'] },
    { id: 'kesehatan_mental', name: 'Jatidiri Kesehatan Mental', category: 'Kesehatan Mental', desc: 'Tes reflektif kesejahteraan mental memahami keseimbangan emosi, fokus & energi 7 hari terakhir.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'potensi', name: 'Jatidiri Potensi (ST-30)', category: 'Bakat & Karir', desc: 'Tes pemetaan 30 tipologi kekuatan (ST-30) untuk menemukan kompetensi produktif dalam diri.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'karir', name: 'Jatidiri Karir', category: 'Bakat & Karir', desc: 'Tes perencanaan karir memadukan minat, bakat, dan kepribadian untuk menemukan jalur profesi BMW.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'cerdas_dewasa', name: 'Jatidiri Cerdas Dewasa (IST)', category: 'Kognitif & Logika', desc: 'Tes kecerdasan umum dewasa (IST) mengukur kesiapan kognitif, daya nalar & adaptasi kerja.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'adaptasi_budaya', name: 'Jatidiri Adaptasi Budaya', category: 'Kepribadian & Sosial', desc: 'Tes adaptasi budaya mengukur penyesuaian diri terhadap lingkungan sosial & budaya baru.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'grafis', name: 'Jatidiri Grafis', category: 'Khusus & Klinis', desc: 'Tes grafis psikologi berbasis gambar (Baum/Wartegg) untuk mengeksplorasi kepribadian mendalam.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'leadership', name: 'Jatidiri Leadership', category: 'Kepribadian & Sosial', desc: 'Tes gaya kepemimpinan untuk kemampuan memimpin, pengambilan keputusan & pengaruh sosial.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'religius', name: 'Jatidiri Religius', category: 'Kepribadian & Sosial', desc: 'Tes refleksi religiusitas memahami nilai spiritual, etika karakter & integritas moral.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'dap', name: 'Jatidiri DAP (Draw A Person)', category: 'Khusus & Klinis', desc: 'Tes DAP (Draw A Person) mengeksplorasi aspek kepribadian, citra diri & dinamika emosi gambar.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'tangguh', name: 'Jatidiri Tangguh', category: 'Kesehatan Mental', desc: 'Tes resiliensi mengukur kemampuan menghadapi tekanan, tantangan, dan bangkit dari kesulitan.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'nalar_cfit', name: 'Jatidiri Nalar (CFIT)', category: 'Kognitif & Logika', desc: 'Tes CFIT untuk mengukur kecerdasan umum dan kemampuan berpikir logis secara kultur-fair.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'cendekia', name: 'Jatidiri Cendekia', category: 'Kognitif & Logika', desc: 'Tes kemampuan akademik & kecerdasan untuk memahami potensi intelektual & kesiapan belajar.', categories: ['sekolah', 'kampus'] },
    { id: 'personal', name: 'Jatidiri Personal', category: 'Kepribadian & Sosial', desc: 'Tes personal untuk memahami karakter, preferensi perilaku, dan dinamika interaksi sosial.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'pribadi', name: 'Jatidiri Pribadi', category: 'Kepribadian & Sosial', desc: 'Tes kepribadian kerja (DISC/PAPI) mengenali karakter diri, stabilitas emosi & pola kerja.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'kematangan_sd', name: 'Jatidiri Kematangan SD', category: 'Khusus & Klinis', desc: 'Tes kesiapan & kematangan kognitif, motorik, sosial, dan emosional anak usia sekolah dasar.', categories: ['sekolah'] },
    { id: 'figur_frt', name: 'Jatidiri Figur (FRT)', category: 'Kognitif & Logika', desc: 'Tes FRT untuk mengukur kemampuan berpikir logis, analitis, dan pemecahan masalah sistematis.', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'hallopsy', name: 'Layanan HalloPsy', category: 'Khusus & Klinis', desc: 'Sesi konseling daring 1-on-1 bersama psikolog profesional berizin resmi (SIPP HIMPSI).', categories: ['sekolah', 'kampus', 'corporate'] },
    { id: 'peer_counselor', name: 'Certified Peer Counselor', category: 'Kepribadian & Sosial', desc: 'Pelatihan duta konselor sebaya siswa / mahasiswa di lingkungan institusi pendidikan.', categories: ['sekolah', 'kampus'] }
];

let currentTestFilterMode = 'recommended';
let currentSearchQuery = '';

function getCategory() {
    const val = (document.getElementById('institution_type').value || '').toLowerCase();
    if (['universitas', 'fk_kedokteran', 'pmb_kampus', 'politeknik'].includes(val)) {
        return 'kampus';
    }
    if (['corporate', 'bumn_instansi', 'rumah_sakit', 'csr_filantropi'].includes(val)) {
        return 'corporate';
    }
    return 'sekolah';
}

function onInstitutionChange() {
    const category = getCategory();
    const badge = document.getElementById('institution_category_badge');
    const unitLabel = document.getElementById('participant_unit_text');
    const budgetSelect = document.getElementById('budget_source');
    const targetInput = document.getElementById('target_audience');

    // Update Category Badge & Unit
    if (category === 'kampus') {
        badge.innerHTML = '<i class="mdi mdi-school"></i> Kategori: JATIDIRI KAMPUS';
        unitLabel.innerText = 'Mahasiswa';
        budgetSelect.value = 'kampus';
        if (!targetInput.value || targetInput.value.includes('Siswa') || targetInput.value.includes('Karyawan')) {
            targetInput.value = 'Mahasiswa Baru & Tingkat Akhir';
        }
    } else if (category === 'corporate') {
        badge.innerHTML = '<i class="mdi mdi-domain"></i> Kategori: JATIDIRI CORPORATE';
        unitLabel.innerText = 'Peserta / Karyawan';
        budgetSelect.value = 'corporate_hrd';
        if (!targetInput.value || targetInput.value.includes('Siswa') || targetInput.value.includes('Mahasiswa')) {
            targetInput.value = 'Karyawan / Calon Pegawai';
        }
    } else {
        badge.innerHTML = '<i class="mdi mdi-book-open-page-variant"></i> Kategori: JATIDIRI SEKOLAH';
        unitLabel.innerText = 'Siswa';
        budgetSelect.value = 'bos_siplah';
        if (!targetInput.value || targetInput.value.includes('Mahasiswa') || targetInput.value.includes('Karyawan')) {
            targetInput.value = 'Siswa Kelas X & XII';
        }
    }

    // Populate Packages
    const packageSelect = document.getElementById('package_type');
    packageSelect.innerHTML = '';
    const currentPkgs = packagesData[category] || packagesData.sekolah;
    
    currentPkgs.forEach((p, index) => {
        const opt = document.createElement('option');
        opt.value = p.id;
        opt.text = `${p.name} - ${p.desc}`;
        if (p.name.includes('Rekomendasi') || index === 1) {
            opt.selected = true;
        }
        packageSelect.appendChild(opt);
    });

    // Populate Test Checkboxes with package defaults
    renderTestCheckboxes();

    // Update Price Suggestion
    onPackageChange();
}

function getFilteredTests() {
    const category = getCategory();
    const query = currentSearchQuery.toLowerCase().trim();
    let list = masterTestsList;

    if (currentTestFilterMode === 'recommended' && !query) {
        list = list.filter(t => t.categories.includes(category));
    }

    if (query) {
        list = list.filter(t => 
            t.name.toLowerCase().includes(query) ||
            t.desc.toLowerCase().includes(query) ||
            t.category.toLowerCase().includes(query)
        );
    }

    return list;
}

function setTestFilterMode(mode) {
    currentTestFilterMode = mode;
    const btnRec = document.getElementById('btn_filter_recommended');
    const btnAll = document.getElementById('btn_filter_all');

    if (mode === 'recommended') {
        btnRec.className = 'btn btn-primary';
        btnAll.className = 'btn btn-outline-secondary';
    } else {
        btnRec.className = 'btn btn-outline-secondary';
        btnAll.className = 'btn btn-primary';
    }

    renderTestCheckboxes();
}

function onTestSearchInput() {
    currentSearchQuery = document.getElementById('test_search_input').value;
    renderTestCheckboxes();
}

function renderTestCheckboxes() {
    const container = document.getElementById('test_needs_container');
    const category = getCategory();
    const tests = getFilteredTests();
    
    // Save currently selected values before re-rendering
    const currentlyChecked = new Set();
    document.querySelectorAll('input[name="test_needs[]"]:checked').forEach(cb => {
        currentlyChecked.add(cb.value);
    });

    // If initial empty state, load package defaults
    if (currentlyChecked.size === 0) {
        const pkgId = document.getElementById('package_type').value;
        const currentPkgs = packagesData[category] || packagesData.sekolah;
        const currentPkg = currentPkgs.find(p => p.id === pkgId) || currentPkgs[1] || currentPkgs[0];
        if (currentPkg && currentPkg.defaultTests) {
            currentPkg.defaultTests.forEach(id => currentlyChecked.add(id));
        }
    }

    container.innerHTML = '';

    if (tests.length === 0) {
        container.innerHTML = `
            <div class="col-12 text-center py-4 text-muted">
                <i class="mdi mdi-alert-circle-outline mr-1"></i> Tidak ditemukan alat tes yang cocok dengan pencarian "${currentSearchQuery}".
            </div>
        `;
        updateSelectedTestsCountBadge();
        return;
    }

    tests.forEach((t) => {
        const col = document.createElement('div');
        col.className = 'col-md-6 col-lg-4 mb-2';
        const isChecked = currentlyChecked.has(t.id) ? 'checked' : '';
        col.innerHTML = `
            <div class="card border p-2 h-100 shadow-none test-card-item" style="border-radius: 8px; transition: background 0.15s ease;">
                <div class="custom-control custom-checkbox d-flex align-items-start">
                    <input type="checkbox" class="custom-control-input" id="test_${t.id}" name="test_needs[]" value="${t.id}" ${isChecked} onchange="updateSelectedTestsCountBadge()">
                    <label class="custom-control-label w-100 pl-1 cursor-pointer" for="test_${t.id}">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-dark small">${t.name}</strong>
                            <span class="badge badge-light border text-muted" style="font-size: 9px;">${t.category}</span>
                        </div>
                        <div class="text-muted" style="font-size: 11px; line-height: 1.35;">${t.desc}</div>
                    </label>
                </div>
            </div>
        `;
        container.appendChild(col);
    });

    updateSelectedTestsCountBadge();
}

function updateSelectedTestsCountBadge() {
    const count = document.querySelectorAll('input[name="test_needs[]"]:checked').length;
    const badge = document.getElementById('selected_tests_count_badge');
    if (badge) {
        badge.innerText = `${count} Modul Dipilih`;
    }
}

function resetToCurrentPackageTests() {
    const category = getCategory();
    const pkgId = document.getElementById('package_type').value;
    const currentPkgs = packagesData[category] || packagesData.sekolah;
    const currentPkg = currentPkgs.find(p => p.id === pkgId) || currentPkgs[1] || currentPkgs[0];
    const defaultTests = currentPkg ? currentPkg.defaultTests : [];

    document.querySelectorAll('input[name="test_needs[]"]').forEach(cb => {
        cb.checked = defaultTests.includes(cb.value);
    });
    updateSelectedTestsCountBadge();
}

function selectAllFilteredTests() {
    document.querySelectorAll('input[name="test_needs[]"]').forEach(cb => {
        cb.checked = true;
    });
    updateSelectedTestsCountBadge();
}

function clearAllTests() {
    document.querySelectorAll('input[name="test_needs[]"]').forEach(cb => {
        cb.checked = false;
    });
    updateSelectedTestsCountBadge();
}

function onPackageChange() {
    const category = getCategory();
    const pkgId = document.getElementById('package_type').value;
    const currentPkgs = packagesData[category] || packagesData.sekolah;
    const pkg = currentPkgs.find(p => p.id === pkgId);
    const priceInput = document.getElementById('price_per_participant');
    const badge = document.getElementById('package_badge');

    if (pkg) {
        priceInput.value = pkg.price;
        badge.innerText = pkg.name;

        // Auto-check default tests for this package
        if (pkg.defaultTests && pkg.defaultTests.length > 0) {
            document.querySelectorAll('input[name="test_needs[]"]').forEach(cb => {
                cb.checked = pkg.defaultTests.includes(cb.value);
            });
            updateSelectedTestsCountBadge();
        }
    } else {
        badge.innerText = 'Custom Package';
    }

    calculateTotal();
}

function calculateTotal() {
    const price = parseFloat(document.getElementById('price_per_participant').value) || 0;
    const participants = parseFloat(document.getElementById('estimated_participants').value) || 0;
    const total = price * participants;
    document.getElementById('total_display').innerText = 'Rp ' + total.toLocaleString('id-ID');
}

document.addEventListener('DOMContentLoaded', function() {
    onInstitutionChange();
});
</script>
@endsection
