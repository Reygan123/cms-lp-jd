<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelatihan_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelatihan_id')->constrained('pelatihans')->onDelete('cascade');
            $table->foreignId('referral_id')->nullable()->constrained('pelatihan_referrals')->onDelete('set null');
            $table->string('registration_code')->unique();
            $table->string('referral_code')->nullable();
            $table->string('referral_giver_name')->nullable();
            $table->string('full_name');
            $table->string('name_for_certificate');
            $table->string('email');
            $table->string('whatsapp');
            $table->text('domicile')->nullable();
            $table->string('institution_level')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('role_in_institution')->nullable();
            $table->text('skill_to_improve')->nullable();
            $table->boolean('had_previous_training')->nullable();
            $table->enum('registration_type', ['individu', 'kolektif'])->default('individu');
            $table->integer('collective_count')->nullable();
            $table->string('collective_coordinator')->nullable();
            $table->string('payment_sender_name')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_proof')->nullable();
            $table->boolean('needs_invoice')->default(false);
            $table->string('invoice_name')->nullable();
            $table->decimal('original_price', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('final_price', 12, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->string('certificate_file')->nullable();
            $table->timestamp('certificate_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelatihan_participants');
    }
};
