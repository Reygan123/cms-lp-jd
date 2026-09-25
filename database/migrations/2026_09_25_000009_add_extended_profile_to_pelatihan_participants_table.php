<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pelatihan_participants', function (Blueprint $table) {
            $table->string('gender', 20)->nullable()->after('name_for_certificate');
            $table->string('birth_place', 100)->nullable()->after('gender');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->integer('age')->nullable()->after('birth_date');
            $table->string('institution_city', 100)->nullable()->after('institution_name');
        });

        // Use direct SQL to alter column type without doctrine/dbal dependency
        try {
            DB::statement("ALTER TABLE pelatihan_participants MODIFY COLUMN institution_level TEXT NULL");
        } catch (\Throwable $e) {
            // Ignore if already text or database doesn't support modify
        }
    }

    public function down()
    {
        Schema::table('pelatihan_participants', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'birth_place',
                'birth_date',
                'age',
                'institution_city',
            ]);
        });
    }
};
