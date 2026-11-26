<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('webinar_registrations')) {
            Schema::create('webinar_registrations', function (Blueprint $table) {
                $table->id();
                $table->string('order_id')->unique();
                $table->string('chapter_id')->default('chapter-1');
                $table->string('episode_id')->default('ep-1');
                $table->string('episode_title')->nullable();
                $table->string('pricing_type')->default('free_donation'); // free_donation, paid, bundling
                $table->string('full_name');
                $table->string('whatsapp');
                $table->string('email');
                $table->string('category')->nullable();
                $table->string('institution')->nullable();
                $table->text('biggest_challenge')->nullable();
                $table->text('speaker_question')->nullable();
                $table->string('ig_username')->nullable();
                $table->string('ig_proof_file')->nullable();
                $table->decimal('donation_amount', 12, 2)->default(0);
                $table->decimal('total_amount', 12, 2)->default(0);
                $table->string('payment_channel')->nullable();
                $table->string('payment_status')->default('PENDING'); // PENDING, PAID, EXPIRED, FAILED
                $table->string('duitku_reference')->nullable();
                $table->text('duitku_payment_url')->nullable();
                $table->string('va_number')->nullable();
                $table->text('qr_string')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->timestamp('expiry_time')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('webinar_registrations');
    }
};

