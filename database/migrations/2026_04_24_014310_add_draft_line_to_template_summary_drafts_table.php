<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('template_summary_drafts', function (Blueprint $table) {
            $table->string('draft_line', 100)->nullable()->after('draft_type');
        });
    }

    public function down(): void
    {
        Schema::table('template_summary_drafts', function (Blueprint $table) {
            $table->dropColumn('draft_line');
        });
    }
};
