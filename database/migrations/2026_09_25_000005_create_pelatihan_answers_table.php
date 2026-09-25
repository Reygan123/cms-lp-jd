<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelatihan_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('pelatihan_participants')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('pelatihan_questions')->onDelete('cascade');
            $table->text('answer')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelatihan_answers');
    }
};
