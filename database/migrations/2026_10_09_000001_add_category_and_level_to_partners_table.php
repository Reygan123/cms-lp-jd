<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('category', 50)->default('sekolah')->after('slug')->index();
            $table->string('level', 50)->nullable()->after('category')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['level']);
            $table->dropColumn(['category', 'level']);
        });
    }
};
