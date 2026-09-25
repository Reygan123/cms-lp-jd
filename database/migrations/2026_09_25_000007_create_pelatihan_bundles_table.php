<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelatihan_bundles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelatihan_id')->constrained('pelatihans')->onDelete('cascade');
            $table->string('name');
            $table->integer('person_count');
            $table->decimal('bundle_price', 12, 2);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelatihan_bundles');
    }
};
