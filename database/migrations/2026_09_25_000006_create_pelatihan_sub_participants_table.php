<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelatihan_sub_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('pelatihan_participants')->onDelete('cascade');
            $table->string('full_name');
            $table->string('name_for_certificate');
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('role_in_institution')->nullable();
            $table->string('certificate_file')->nullable();
            $table->timestamp('certificate_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelatihan_sub_participants');
    }
};
