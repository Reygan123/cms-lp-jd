<?php

namespace Database\Seeders;

use App\Models\Pelatihan;
use App\Models\PelatihanQuestion;
use App\Models\PelatihanReferral;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PelatihanSeeder extends Seeder
{
    public function run()
    {
        $pelatihan = Pelatihan::updateOrCreate(
            ['title' => 'Pelatihan Peer Counselor: Active Listening | Pendidik dan Tenaga Kependidikan | Batch 3'],
            [
                'slug'              => Str::slug('Pelatihan Peer Counselor Active Listening Batch 3'),
                'batch'             => 'Batch 3',
                'description'       => 'Jatidiri mengundang pendidik dan tenaga kependidikan semua jenjang untuk mengikuti Pelatihan Peer Counselor: Active Listening secara offline. Program terbuka bagi guru BK, guru kelas/mata pelajaran, dosen, kepala sekolah, serta tenaga administrasi, perpustakaan, laboratorium, dan pendukung pendidikan lainnya. Total pembelajaran: 16 JP gabungan dua hari (1 JP = 45 menit).',
                'start_date'        => '2026-10-14',
                'end_date'          => '2026-10-15',
                'start_time'        => '08:00',
                'end_time'          => '16:00',
                'location'          => 'Kantor Jatidiri, Jalan Abdul Halim No. 128, Cigugur Tengah, Cimahi Tengah, Kota Cimahi, Jawa Barat',
                'price'             => 750000,
                'bank_name'         => 'Bank Mandiri',
                'bank_account'      => '1320529111818',
                'bank_holder'       => 'PT Hexagon Karyatama Indonesia',
                'quota'             => 30,
                'whatsapp_contact'  => '0851-4239-8721',
                'email_contact'     => 'jatidiri.apps@gmail.com',
                'status'            => 'active',
            ]
        );

        // Pertanyaan dinamis tambahan/kuesioner spesifik event
        $questions = [
            [
                'question'    => 'Apakah Bapak/Ibu berkomitmen mengikuti penuh seluruh sesi (16 JP) selama 2 hari pelatihan?',
                'type'        => 'radio',
                'options'     => ['Ya, saya berkomitmen mengikuti penuh seluruh sesi', 'Tidak bisa penuh'],
                'is_required' => true,
                'sort_order'  => 1,
            ],
            [
                'question'    => 'Dari mana Bapak/Ibu mengetahui informasi pelatihan ini?',
                'type'        => 'select',
                'options'     => ['Instagram Jatidiri', 'Grup WhatsApp Guru/Lembaga', 'Rekomendasi Rekan Kerja / Alumni', 'Website Jatidiri', 'Lainnya'],
                'is_required' => false,
                'sort_order'  => 2,
            ],
            [
                'question'    => 'Apakah Bapak/Ibu bersedia didokumentasikan (foto/video) untuk publikasi kegiatan Jatidiri?',
                'type'        => 'radio',
                'options'     => ['Ya, saya bersedia', 'Tidak bersedia'],
                'is_required' => true,
                'sort_order'  => 3,
            ],
        ];

        foreach ($questions as $q) {
            PelatihanQuestion::updateOrCreate(
                [
                    'pelatihan_id' => $pelatihan->id,
                    'question'     => $q['question'],
                ],
                $q
            );
        }

        // Contoh kode referral untuk pengujian potongan harga
        $referrals = [
            [
                'code'           => 'SINERGI26',
                'partner_name'   => 'Member Sinergi Project',
                'discount_type'  => 'nominal',
                'discount_value' => 50000,
                'max_usage'      => 100,
                'is_active'      => true,
            ],
            [
                'code'           => 'EARLYBIRD',
                'partner_name'   => 'Promo Early Bird Diskon 10%',
                'discount_type'  => 'percent',
                'discount_value' => 10,
                'max_usage'      => 50,
                'is_active'      => true,
            ],
        ];

        foreach ($referrals as $ref) {
            PelatihanReferral::updateOrCreate(
                [
                    'pelatihan_id' => $pelatihan->id,
                    'code'         => $ref['code'],
                ],
                $ref
            );
        }
    }
}
