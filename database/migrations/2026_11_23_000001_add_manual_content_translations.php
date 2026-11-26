<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLES = [
        'posts', 'categories', 'agendas', 'programs', 'facilities', 'unggulans', 'pricings',
        'benefits', 'testimonies', 'portofolios', 'dukungans', 'partners', 'legals', 'ourteams',
        'sliders', 'identities', 'faqs', 'welcomechats', 'services', 'why_services', 'alasanservices',
        'how_services', 'bonus_services', 'masalah_services', 'manfaat_services', 'activities',
        'pelatihans', 'pelatihan_bundles', 'pelatihan_questions', 'webinars', 'webinar_episodes',
    ];

    public function up(): void
    {
        foreach (self::TABLES as $name) {
            if (!Schema::hasTable($name)) {
                throw new RuntimeException('Tabel konten tidak tersedia: '.$name.'. Verifikasi skema sebelum migrasi.');
            }
            if (Schema::hasColumn($name, 'translations')) {
                throw new RuntimeException('Kolom translations sudah tersedia pada '.$name.'. Verifikasi kepemilikan kolom sebelum migrasi.');
            }
        }
        foreach (self::TABLES as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->json('translations')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (self::TABLES as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropColumn('translations');
            });
        }
    }
};
