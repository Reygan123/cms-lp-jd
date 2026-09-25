<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pelatihan_participants', function (Blueprint $table) {
            $table->foreignId('bundle_id')->nullable()->after('referral_id')->constrained('pelatihan_bundles')->onDelete('set null');
            $table->string('bundle_name')->nullable()->after('bundle_id');
        });
    }

    public function down()
    {
        Schema::table('pelatihan_participants', function (Blueprint $table) {
            $table->dropForeign(['bundle_id']);
            $table->dropColumn(['bundle_id', 'bundle_name']);
        });
    }
};
