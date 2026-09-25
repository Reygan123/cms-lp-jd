# 📚 Dokumentasi API & Panduan Integrasi Frontend
## Modul Pelatihan & Pendaftaran Event — Jatidiri ED (jatidiri-ed-new)

Dokumentasi ini disusun khusus untuk tim Frontend (**jatidiri-ed-new** / **jatidiri-LP-v2**) yang bertugas mengintegrasikan halaman katalog pelatihan, detail event, form kuesioner dinamis, sistem paket bundling, kode referral, upload pembayaran, kelengkapan data peserta kolektif lembaga, hingga fitur cek status pendaftaran peserta.

---

## 1. Environment & Base URL

| Environment | Base URL | Keterangan |
|---|---|---|
| **Lokal / Development** | `http://localhost:8005/api` | Port default backend Laravel artisan serve |
| **Staging / Production** | `https://[domain-backend]/api` | Sesuaikan dengan env `NEXT_PUBLIC_API_URL` atau `VITE_API_URL` |

### HTTP Headers Wajib
Setiap request ke backend disarankan menyertakan header:
```http
Accept: application/json
```
> [!NOTE]
> Semua endpoint API modul pelatihan bersifat **publik** (tidak memerlukan Bearer token authentication) karena diakses langsung oleh calon peserta/publik.

---

## 2. Ringkasan Endpoint

| No | Method | Endpoint | Fungsi |
|---|---|---|---|
| 1 | `GET` | `/pelatihan` | Mengambil daftar semua pelatihan berstatus aktif |
| 2 | `GET` | `/pelatihan/{slug}` | Mengambil detail lengkap pelatihan, info kuota, paket bundling, dan kuesioner dinamis |
| 3 | `POST` | `/pelatihan/check-referral` | Memvalidasi kode referral & menghitung potongan harga secara real-time |
| 4 | `POST` | `/pelatihan/daftar` | Mendaftarkan peserta (individu / kolektif lembaga bundling, profil lengkap 11 item, kuesioner, bukti bayar) |
| 5 | `GET` | `/pelatihan/cek-status/{code}` | Cek status verifikasi pendaftaran & link download e-sertifikat |

---

## 3. Detail Spesifikasi Endpoint

---

### 3.1. Get Daftar Pelatihan Aktif
Mengambil seluruh katalog pelatihan yang sedang aktif dan dibuka.

* **Endpoint:** `GET /pelatihan`
* **Headers:** `Accept: application/json`
* **Response `200 OK`:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Peer Counselor: Active Listening",
      "slug": "peer-counselor-active-listening",
      "batch": "Batch 3",
      "description": "Pelatihan peningkatan kompetensi konseling dan active listening bagi pendidik dan tenaga kependidikan.",
      "start_date": "2026-10-15",
      "end_date": "2026-10-16",
      "start_time": "09:00:00",
      "end_time": "15:00:00",
      "location": "Zoom Meeting & LMS Jatidiri",
      "price": 150000,
      "quota": 100,
      "quota_remaining": 82,
      "participants_count": 18,
      "image": "http://localhost:8005/storage/pelatihans/banner-batch-3.jpg",
      "whatsapp_contact": "081234567890",
      "email_contact": "event@jatidiri.app",
      "status": "active"
    }
  ]
}
```

> [!TIP]
> **Logika Kuota di Frontend:**  
> Jika `quota !== null && quota_remaining <= 0`, tampilkan label/badge **"Kuota Penuh"** dan nonaktifkan tombol daftar pada kartu event.

---

### 3.2. Get Detail Pelatihan (`/pelatihan/{slug}`)
Mengambil detail satu event pelatihan, informasi rekening transfer, daftar **Paket Bundling**, serta daftar **Pertanyaan Kuesioner Dinamis**.

* **Endpoint:** `GET /pelatihan/{slug}`
* **Contoh:** `GET /pelatihan/peer-counselor-active-listening`
* **Headers:** `Accept: application/json`
* **Response `200 OK`:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Peer Counselor: Active Listening",
    "slug": "peer-counselor-active-listening",
    "batch": "Batch 3",
    "description": "Deskripsi lengkap event pelatihan...",
    "start_date": "2026-10-15",
    "end_date": "2026-10-16",
    "start_time": "09:00:00",
    "end_time": "15:00:00",
    "location": "Zoom Meeting Online",
    "price": 150000,
    "bank_name": "Bank Central Asia (BCA)",
    "bank_account": "1234567890",
    "bank_holder": "PT Jatidiri Muda Kreatif",
    "quota": 100,
    "quota_remaining": 82,
    "image": "http://localhost:8005/storage/pelatihans/banner-batch-3.jpg",
    "whatsapp_contact": "081234567890",
    "email_contact": "event@jatidiri.app",
    "bundles": [
      {
        "id": 1,
        "name": "Paket Berdua (2 Orang)",
        "person_count": 2,
        "bundle_price": 260000,
        "price_per_person": "130000.00",
        "description": "Hemat Rp 40.000 untuk pendaftaran 2 peserta sekaligus."
      },
      {
        "id": 2,
        "name": "Paket Bertiga (3 Orang)",
        "person_count": 3,
        "bundle_price": 360000,
        "price_per_person": "120000.00",
        "description": "Hemat Rp 90.000 untuk pendaftaran 3 peserta sekaligus."
      }
    ],
    "questions": [
      {
        "id": 1,
        "question": "Apakah Anda pernah mengikuti pelatihan konseling sebelumnya?",
        "type": "radio",
        "options": ["Sudah pernah", "Belum pernah"],
        "is_required": true,
        "sort_order": 1,
        "conditional_on_question": null,
        "conditional_on_value": null
      }
    ]
  }
}
```

---

### 3.3. Check Kode Referral (`/pelatihan/check-referral`)
Digunakan pada form checkout untuk memvalidasi voucher / kode referral yang diinput peserta dan menghitung diskon harga secara real-time.

* **Endpoint:** `POST /pelatihan/check-referral`
* **Headers:**  
  `Content-Type: application/json`  
  `Accept: application/json`

#### Request Body (JSON)
| Field | Tipe | Wajib | Keterangan |
|---|---|---|---|
| `code` | `string` | **Ya** | Kode referral (e.g. `GURUBK2026`). Backend otomatis case-insensitive & trim. |
| `pelatihan_id` | `integer` | **Ya** | ID pelatihan yang sedang didaftar. |
| `bundle_id` | `integer` | *Opsional* | Jika memilih paket bundling, kirim `bundle_id` agar potongan diskon dihitung terhadap harga paket bundling. |
| `collective_count` | `integer` | *Opsional* | Jika memilih kolektif non-bundling, kirim total jumlah peserta (pendaftar utama + anggota) agar diskon & final price dihitung dari total harga kolektif (`harga x total orang`). |

#### Contoh Request (Kolektif 3 Orang):
```json
{
  "code": "GURUBK2026",
  "pelatihan_id": 1,
  "collective_count": 3
}
```

#### Response `200 OK` (Kode Valid):
```json
{
  "success": true,
  "data": {
    "code": "GURUBK2026",
    "partner_name": "MGMP Guru BK Jawa Barat",
    "discount_type": "percent",
    "discount_value": 10,
    "discount_amount": 26000,
    "original_price": 260000,
    "final_price": 234000
  }
}
```

---

### 3.4. Pendaftaran Peserta (`POST /pelatihan/daftar`)
Endpoint untuk submit formulir registrasi. Menggunakan format `multipart/form-data` karena mendukung upload berkas bukti pembayaran.

* **Endpoint:** `POST /pelatihan/daftar`
* **Content-Type:** `multipart/form-data`
* **Accept:** `application/json`

#### Form Data Fields (Peserta Utama / Perseorangan):

| Field Key | Tipe | Wajib | Keterangan |
|---|---|---|---|
| `pelatihan_id` | Integer | **Wajib** | ID pelatihan target |
| `registration_type` | String | **Wajib** | Nilai: `'individu'` atau `'kolektif'` |
| `bundle_id` | Integer | Opsional | ID paket bundling (jika memilih paket bundling) |
| `full_name` | String | **Wajib** | Nama lengkap pendaftar utama / koordinator |
| `name_for_certificate` | String | **Wajib** | Nama lengkap dan gelar untuk sertifikat (Field #1) |
| `gender` | String | Opsional | Jenis Kelamin: `'Laki-laki'` atau `'Perempuan'` (Field #2) |
| `birth_place` | String | Opsional | Kota/Kabupaten Tempat Lahir (Field #3) |
| `birth_date` | String | Opsional | Tanggal Lahir format `YYYY-MM-DD` (Field #4) |
| `age` | Integer | Opsional | Usia peserta dalam tahun. **Jika kosong, backend otomatis menghitung dari `birth_date`** (Field #5) |
| `whatsapp` | String | **Wajib** | No WhatsApp aktif peserta (Field #6) |
| `email` | String | **Wajib** | Email aktif peserta (Field #7) |
| `domicile` | String | **Wajib** | Domisili / Kota Asal peserta (Field #8) |
| `institution_name` | String | **Wajib** | Nama lembaga/instansi tempat bertugas (Field #9) |
| `institution_level` | Array / String | **Wajib** | **Jenjang atau jenis lembaga bertugas (Q4)**. Boleh memilih lebih dari satu (checkbox)! (Field #10) |
| `institution_city` | String | Opsional | Kota/Kabupaten lembaga tempat bertugas (Field #11) |
| `role_in_institution` | String | **Wajib** | Jabatan di lembaga (Guru BK, Dosen, Kepala Sekolah, dll) |
| `skill_to_improve` | String | Opsional | Keterampilan yang ingin ditingkatkan |
| `had_previous_training` | Boolean | **Wajib** | Pernah ikut pelatihan serupa sebelumnya (`1` atau `0`) |
| `collective_count` | Integer | Opsional | Jumlah peserta jika registrasi kolektif (e.g. `2`, `3`) |
| `collective_coordinator` | String | Opsional | Nama PIC / Koordinator rombongan kolektif |
| `referral_code` | String | Opsional | Kode voucher diskon |
| `referral_giver_name` | String | Opsional | Nama pihak pemberi referral |
| `payment_sender_name` | String | Opsional | Nama pemilik rekening pengirim transfer |
| `payment_date` | String | Opsional | Tanggal pembayaran format `YYYY-MM-DD` |
| `payment_proof` | File | Opsional | File bukti transfer (`jpg`, `jpeg`, `png`, `pdf`, max: 5MB) |
| `needs_invoice` | Boolean | **Wajib** | Membutuhkan kuitansi/invoice resmi (`1` atau `0`) |
| `invoice_name` | String | Opsional | Nama instansi/individu yang tertera di invoice |

---

### Opsi Resmi Q4: Jenjang atau Jenis Lembaga Bertugas (`institution_level`)
Sesuai formulir pendaftaran, pertanyaan ini bertipe **Checkbox (Boleh memilih lebih dari satu)**:
1. `PAUD/TK/RA`
2. `SD/MI`
3. `SMP/MTs`
4. `SMA/MA`
5. `SMK/MAK`
6. `SLB`
7. `Perguruan tinggi`
8. `Pendidikan nonformal`
9. `Yang lain: [input teks bebas peserta]`

> [!TIP]
> **Cara Mengirim Q4 ke API:**  
> Frontend bisa mengirimkan array:  
> `formData.append('institution_level[]', 'SMA/MA')`  
> `formData.append('institution_level[]', 'SMK/MAK')`  
> Atau string yang digabung koma: `'SMA/MA, SMK/MAK'`. Backend otomatis menyimpannya dengan format rapi.

---

### Data Peserta Tambahan Kolektif Lembaga (`sub_participants`)
Jika `registration_type = 'kolektif'`, setiap anggota rombongan dikirimkan dengan kelengkapan data **identik** dengan peserta perorangan:

* `sub_participants[0][full_name]` *(Wajib)*
* `sub_participants[0][name_for_certificate]` *(Wajib)*
* `sub_participants[0][gender]` *(Opsional: Laki-laki / Perempuan)*
* `sub_participants[0][birth_place]` *(Opsional: Tempat lahir)*
* `sub_participants[0][birth_date]` *(Opsional: YYYY-MM-DD)*
* `sub_participants[0][age]` *(Opsional: Angka usia, auto-dihitung jika tgl lahir diisi)*
* `sub_participants[0][whatsapp]` *(Opsional: No WA aktif anggota)*
* `sub_participants[0][email]` *(Opsional: Email anggota untuk pengiriman sertifikat)*
* `sub_participants[0][domicile]` *(Opsional: Domisili anggota)*
* `sub_participants[0][institution_name]` *(Opsional: Default mewarisi lembaga pendaftar utama jika tidak diisi)*
* `sub_participants[0][institution_level]` *(Opsional: Jenjang Q4 anggota)*
* `sub_participants[0][institution_city]` *(Opsional: Kota lembaga anggota)*
* `sub_participants[0][role_in_institution]` *(Opsional: Jabatan anggota)*
* `sub_participants[0][skill_to_improve]` *(Opsional)*
* `sub_participants[0][had_previous_training]` *(Opsional: 1 / 0)*
* `sub_participants[1][full_name]` ... dst.

---

#### Contoh Response `201 Created` (Pendaftaran Berhasil):
```json
{
  "success": true,
  "message": "Pendaftaran berhasil! Kode registrasi Anda: JD-BTH-20260925-A1B2C. Admin akan menghubungi Anda untuk konfirmasi.",
  "data": {
    "registration_code": "JD-BTH-20260925-A1B2C",
    "full_name": "Dr. Siti Rahmawati, M.Pd.",
    "email": "siti.rahma@school.sch.id",
    "original_price": 260000,
    "discount_amount": 26000,
    "final_price": 234000,
    "bundle": "Paket Berdua (2 Orang)",
    "status": "pending"
  }
}
```

---

### 3.5. Cek Status Pendaftaran (`GET /pelatihan/cek-status/{code}`)
Digunakan pada halaman **"Cek Status Pendaftaran"** atau tracking peserta.

* **Endpoint:** `GET /pelatihan/cek-status/{code}`
* **Contoh:** `GET /pelatihan/cek-status/JD-BTH-20260925-A1B2C`
* **Response `200 OK`:**
```json
{
  "success": true,
  "data": {
    "registration_code": "JD-BTH-20260925-A1B2C",
    "full_name": "Dr. Siti Rahmawati, M.Pd.",
    "email": "siti.rahma@school.sch.id",
    "event": "Peer Counselor: Active Listening",
    "original_price": 260000,
    "final_price": 234000,
    "discount_amount": 26000,
    "bundle": "Paket Berdua (2 Orang)",
    "status": "approved",
    "admin_note": "Pembayaran lunas via BCA. Selamat bergabung!",
    "certificate_file": "http://localhost:8005/storage/certificates/cert-JD-BTH-20260925-A1B2C.pdf",
    "certificate_sent_at": "2026-10-17 14:30:00",
    "sertifikat_dikirim": true
  }
}
```

---

## 4. TypeScript Interface Definition

Frontend developer dapat langsung menggunakan interface TypeScript berikut:

```typescript
// types/pelatihan.ts

export type GenderType = 'Laki-laki' | 'Perempuan';

export interface PelatihanListItem {
  id: number;
  title: string;
  slug: string;
  batch: string;
  description: string;
  start_date: string;
  end_date: string;
  start_time: string;
  end_time: string;
  location: string;
  price: number;
  quota: number | null;
  quota_remaining: number | null;
  participants_count: number;
  image: string | null;
  whatsapp_contact: string;
  email_contact: string;
  status: 'active' | 'closed' | 'archived';
}

export interface PelatihanBundle {
  id: number;
  name: string;
  person_count: number;
  bundle_price: number;
  price_per_person: string;
  description: string | null;
}

export interface PelatihanQuestion {
  id: number;
  question: string;
  type: string;
  options: string[] | null;
  is_required: boolean;
  sort_order: number;
  conditional_on_question: number | null;
  conditional_on_value: string | null;
}

export interface PelatihanDetail extends PelatihanListItem {
  bank_name: string | null;
  bank_account: string | null;
  bank_holder: string | null;
  bundles: PelatihanBundle[];
  questions: PelatihanQuestion[];
}

export interface SubParticipantItem {
  full_name: string;
  name_for_certificate: string;
  gender?: GenderType | string;
  birth_place?: string;
  birth_date?: string; // YYYY-MM-DD
  age?: number;
  email?: string;
  whatsapp?: string;
  domicile?: string;
  institution_name?: string;
  institution_level?: string[] | string;
  institution_city?: string;
  role_in_institution?: string;
  skill_to_improve?: string;
  had_previous_training?: boolean;
}

export interface RegisterPayload {
  pelatihan_id: number;
  bundle_id?: number | null;
  registration_type: 'individu' | 'kolektif';
  full_name: string;
  name_for_certificate: string;
  gender?: GenderType | string;
  birth_place?: string;
  birth_date?: string; // YYYY-MM-DD
  age?: number;
  email: string;
  whatsapp: string;
  domicile: string;
  institution_name: string;
  institution_level: string[] | string; // Opsi Q4
  institution_city?: string;
  role_in_institution: string;
  skill_to_improve?: string;
  had_previous_training: boolean;
  collective_count?: number;
  collective_coordinator?: string;
  sub_participants?: SubParticipantItem[];
  referral_code?: string;
  referral_giver_name?: string;
  payment_sender_name?: string;
  payment_date?: string;
  payment_proof?: File | null;
  needs_invoice: boolean;
  invoice_name?: string;
  answers?: Record<number, string | string[]>;
}
```

---

## 5. Contoh Helper Pengiriman FormData (Next.js / Vue / React)

```typescript
// services/pelatihanApi.ts
import axios from 'axios';
import { RegisterPayload } from '@/types/pelatihan';

const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8005/api';

export const registerPelatihan = async (payload: RegisterPayload) => {
  const formData = new FormData();

  // 1. Data Utama Peserta
  formData.append('pelatihan_id', payload.pelatihan_id.toString());
  formData.append('registration_type', payload.registration_type);
  formData.append('full_name', payload.full_name);
  formData.append('name_for_certificate', payload.name_for_certificate);
  if (payload.gender) formData.append('gender', payload.gender);
  if (payload.birth_place) formData.append('birth_place', payload.birth_place);
  if (payload.birth_date) formData.append('birth_date', payload.birth_date);
  if (payload.age) formData.append('age', payload.age.toString());
  formData.append('email', payload.email);
  formData.append('whatsapp', payload.whatsapp);
  formData.append('domicile', payload.domicile);
  formData.append('institution_name', payload.institution_name);
  if (payload.institution_city) formData.append('institution_city', payload.institution_city);
  formData.append('role_in_institution', payload.role_in_institution);
  formData.append('had_previous_training', payload.had_previous_training ? '1' : '0');
  formData.append('needs_invoice', payload.needs_invoice ? '1' : '0');

  // Jenjang Q4 (Array multi-checkbox)
  if (Array.isArray(payload.institution_level)) {
    payload.institution_level.forEach((lvl) => {
      formData.append('institution_level[]', lvl);
    });
  } else if (payload.institution_level) {
    formData.append('institution_level', payload.institution_level);
  }

  if (payload.bundle_id) formData.append('bundle_id', payload.bundle_id.toString());
  if (payload.skill_to_improve) formData.append('skill_to_improve', payload.skill_to_improve);
  if (payload.collective_count) formData.append('collective_count', payload.collective_count.toString());
  if (payload.collective_coordinator) formData.append('collective_coordinator', payload.collective_coordinator);
  if (payload.referral_code) formData.append('referral_code', payload.referral_code);
  if (payload.referral_giver_name) formData.append('referral_giver_name', payload.referral_giver_name);
  if (payload.payment_sender_name) formData.append('payment_sender_name', payload.payment_sender_name);
  if (payload.payment_date) formData.append('payment_date', payload.payment_date);
  if (payload.invoice_name) formData.append('invoice_name', payload.invoice_name);

  // 2. Berkas Bukti Bayar
  if (payload.payment_proof) {
    formData.append('payment_proof', payload.payment_proof);
  }

  // 3. Sub-Peserta Lengkap (Jika Kolektif / Bundling)
  if (payload.registration_type === 'kolektif' && payload.sub_participants) {
    payload.sub_participants.forEach((sub, index) => {
      formData.append(`sub_participants[${index}][full_name]`, sub.full_name);
      formData.append(`sub_participants[${index}][name_for_certificate]`, sub.name_for_certificate);
      if (sub.gender) formData.append(`sub_participants[${index}][gender]`, sub.gender);
      if (sub.birth_place) formData.append(`sub_participants[${index}][birth_place]`, sub.birth_place);
      if (sub.birth_date) formData.append(`sub_participants[${index}][birth_date]`, sub.birth_date);
      if (sub.age) formData.append(`sub_participants[${index}][age]`, sub.age.toString());
      if (sub.email) formData.append(`sub_participants[${index}][email]`, sub.email);
      if (sub.whatsapp) formData.append(`sub_participants[${index}][whatsapp]`, sub.whatsapp);
      if (sub.domicile) formData.append(`sub_participants[${index}][domicile]`, sub.domicile);
      if (sub.institution_name) formData.append(`sub_participants[${index}][institution_name]`, sub.institution_name);
      if (sub.institution_city) formData.append(`sub_participants[${index}][institution_city]`, sub.institution_city);
      if (sub.role_in_institution) formData.append(`sub_participants[${index}][role_in_institution]`, sub.role_in_institution);

      if (Array.isArray(sub.institution_level)) {
        sub.institution_level.forEach((lvl) => {
          formData.append(`sub_participants[${index}][institution_level][]`, lvl);
        });
      } else if (sub.institution_level) {
        formData.append(`sub_participants[${index}][institution_level]`, sub.institution_level);
      }
    });
  }

  // 4. Jawaban Kuesioner Dinamis
  if (payload.answers) {
    Object.entries(payload.answers).forEach(([questionId, answer]) => {
      if (Array.isArray(answer)) {
        answer.forEach((item) => {
          formData.append(`answers[${questionId}][]`, item);
        });
      } else if (answer !== undefined && answer !== null && answer !== '') {
        formData.append(`answers[${questionId}]`, answer);
      }
    });
  }

  const response = await axios.post(`${API_BASE_URL}/pelatihan/daftar`, formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
      Accept: 'application/json',
    },
  });

  return response.data;
};
```

---

## 6. Kontak Dukungan Backend
Jika terdapat kendala response API, penyesuaian endpoint, atau kebutuhan pengujian, silakan koordinasikan dengan tim backend.
