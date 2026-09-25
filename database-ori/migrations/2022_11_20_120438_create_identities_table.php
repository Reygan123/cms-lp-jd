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
        Schema::create('identities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('year')->nullable();;
            $table->text('description')->nullable();;
            $table->text('address')->nullable();;
            $table->text('gmap')->nullable();;
            $table->string('phone')->nullable();;
            $table->string('email')->nullable();;
            $table->string('fb')->nullable();;
            $table->string('ig')->nullable();;
            $table->string('tt')->nullable();;
            $table->string('yt')->nullable();;
            $table->string('logo')->nullable();;
            $table->string('favicon')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identities');
    }
};
