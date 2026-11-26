<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('frontend_copies', function (Blueprint $table) {
            $table->id();
            $table->string('key', 32)->unique();
            $table->text('source');
            $table->text('context')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frontend_copies');
    }
};
