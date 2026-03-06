<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('template_summary_drafts', function (Blueprint $table) {
            $table->id();
            $table->string('draft_type', 50)->index();
            $table->string('title')->nullable();
            $table->longText('payload')->nullable();
            $table->timestamp('last_saved_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_summary_drafts');
    }
};