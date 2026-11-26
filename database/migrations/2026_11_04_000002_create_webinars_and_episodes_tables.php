<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('webinars')) {
            Schema::create('webinars', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->integer('chapter_number')->default(1);
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('speaker_name');
                $table->string('speaker_title')->nullable();
                $table->string('speaker_photo')->nullable();
                $table->string('wa_group_url')->nullable();
                $table->decimal('all_access_price', 12, 2)->default(79000);
                $table->decimal('all_access_original_price', 12, 2)->nullable()->default(198000);
                $table->enum('status', ['active', 'draft', 'closed'])->default('active');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('webinar_episodes')) {
            Schema::create('webinar_episodes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('webinar_id')->constrained('webinars')->onDelete('cascade');
                $table->string('code');
                $table->integer('episode_number')->default(1);
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('date_label')->nullable();
                $table->string('time_label')->nullable();
                $table->dateTime('scheduled_at')->nullable();
                $table->enum('pricing_type', ['free_donation', 'paid'])->default('free_donation');
                $table->decimal('price', 12, 2)->default(0);
                $table->decimal('original_price', 12, 2)->nullable();
                $table->boolean('requires_ig_proof')->default(false);
                $table->boolean('assessment_voucher_included')->default(false);
                $table->json('features')->nullable();
                $table->integer('sort_order')->default(0);
                $table->enum('status', ['active', 'closed'])->default('active');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('webinar_episodes');
        Schema::dropIfExists('webinars');
    }
};

