<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pelatihan_sub_participants', function (Blueprint $table) {
            $table->string('gender', 20)->nullable()->after('name_for_certificate');
            $table->string('birth_place', 100)->nullable()->after('gender');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->integer('age')->nullable()->after('birth_date');
            $table->text('domicile')->nullable()->after('whatsapp');
            $table->string('institution_name')->nullable()->after('domicile');
            $table->text('institution_level')->nullable()->after('institution_name');
            $table->string('institution_city', 100)->nullable()->after('institution_level');
            $table->text('skill_to_improve')->nullable()->after('role_in_institution');
            $table->boolean('had_previous_training')->nullable()->after('skill_to_improve');
        });
    }

    public function down()
    {
        Schema::table('pelatihan_sub_participants', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'birth_place',
                'birth_date',
                'age',
                'domicile',
                'institution_name',
                'institution_level',
                'institution_city',
                'skill_to_improve',
                'had_previous_training',
            ]);
        });
    }
};
