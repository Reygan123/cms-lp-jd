<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelatihan_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelatihan_id')->constrained('pelatihans')->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('partner_name')->nullable();
            $table->enum('discount_type', ['nominal', 'percent'])->default('nominal');
            $table->decimal('discount_value', 12, 2)->default(0);
            $table->integer('max_usage')->nullable();
            $table->integer('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelatihan_referrals');
    }
};
