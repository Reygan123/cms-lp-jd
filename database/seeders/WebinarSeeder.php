<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Webinar;
use App\Models\WebinarEpisode;

class WebinarSeeder extends Seeder
{
    public function run(): void
    {
        $webinar = Webinar::updateOrCreate(
            ['code' => 'chapter-1'],
            [
                'chapter_number' => 1,
                'title' => 'Sering Overthinking Soal Masa Depan? Saatnya Temukan “Jatidiri” Aslimu Bersama Pakar Psikologi',
                'slug' => 'overthinking-masa-depan-temukan-jatidiri',
                'description' => 'Serial webinar komprehensif yang dirancang untuk membongkar akar kecemasan masa depan, memetakan potensi dan minat karier objektif, serta membangun resiliensi emosional berbasis data psikologi ilmiah.',
                'speaker_name' => 'Ibu Miryam Ariadne Sigarlaki, M.Psi., Psikolog',
                'speaker_title' => 'Senior Psychologist Jatidiri.app & Pakar Psikologi Klinis',
                'speaker_photo' => null,
                'wa_group_url' => 'https://chat.whatsapp.com/JatidiriWebinarSeries',
                'all_access_price' => 79000,
                'all_access_original_price' => 198000,
                'status' => 'active',
            ]
        );

        WebinarEpisode::updateOrCreate(
            ['webinar_id' => $webinar->id, 'code' => 'ep-1'],
            [
                'episode_number' => 1,
                'title' => 'Mengurai Benang Kusut Overthinking & Burnout Usia 20-an',
                'description' => 'Memahami mekanisme otak saat cemas berlebih, teknik regulasi emosi mandiri, dan cara melepaskan tekanan ekspektasi sosial.',
                'date_label' => 'Jumat, 15 November 2026',
                'time_label' => '19.30 – 21.00 WIB',
                'pricing_type' => 'free_donation',
                'price' => 0,
                'original_price' => 35000,
                'requires_ig_proof' => true,
                'assessment_voucher_included' => false,
                'features' => [
                    'Akses Ruang Live Zoom Privat',
                    'E-Certificate Resmi Jatidiri',
                    'E-Workbook Self-Reflection PDF',
                    'Live Mini-Assessment & Analisis Agregat',
                    'Sesi Q&A Bersama Psikolog',
                ],
                'sort_order' => 1,
                'status' => 'active',
            ]
        );

        WebinarEpisode::updateOrCreate(
            ['webinar_id' => $webinar->id, 'code' => 'ep-2'],
            [
                'episode_number' => 2,
                'title' => 'Masterclass Career & Talent Mapping: Arahkan Minat Jadi Karier Nyata',
                'description' => 'Framework ilmiah membedah potensi diri, kecocokan bidang profesional, serta menyusun kompas karier 3 tahun ke depan.',
                'date_label' => 'Sabtu, 22 November 2026',
                'time_label' => '19.30 – 21.30 WIB',
                'pricing_type' => 'paid',
                'price' => 49000,
                'original_price' => 70000,
                'requires_ig_proof' => false,
                'assessment_voucher_included' => true,
                'features' => [
                    'Semua Fasilitas Episode 1',
                    '1x VOUCHER ASESMEN MINAT BAKAT LENGKAP di Jatidiri.app',
                    'Akses Rekaman Video (Aktif 30 Hari)',
                    'Slide Materi Lengkap Psikolog & Template Rencana Karier',
                    'Antrean Prioritas Konseling 1-on-1 HalloPsy',
                ],
                'sort_order' => 2,
                'status' => 'active',
            ]
        );

        WebinarEpisode::updateOrCreate(
            ['webinar_id' => $webinar->id, 'code' => 'ep-3'],
            [
                'episode_number' => 3,
                'title' => 'Emotional Resilience & Boundary Setting: Menghadapi Quarter-Life Crisis',
                'description' => 'Membangun benteng mental yang tangguh saat menghadapi penolakan kerja, kegagalan rencana, dan tekanan perbandingan sosial.',
                'date_label' => 'Jumat, 29 November 2026',
                'time_label' => '19.30 – 21.30 WIB',
                'pricing_type' => 'paid',
                'price' => 49000,
                'original_price' => 70000,
                'requires_ig_proof' => false,
                'assessment_voucher_included' => true,
                'features' => [
                    'Semua Fasilitas Episode 1',
                    '1x VOUCHER ASESMEN KESEHATAN MENTAL di Jatidiri.app',
                    'Akses Rekaman Video (Aktif 30 Hari)',
                    'Mental Resilience Toolkit & Habit Tracker',
                    'Konsultasi Group Sharing Privat',
                ],
                'sort_order' => 3,
                'status' => 'active',
            ]
        );
    }
}

