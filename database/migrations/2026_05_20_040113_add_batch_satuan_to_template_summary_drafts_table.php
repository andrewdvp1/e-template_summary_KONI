<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('template_summary_drafts', function (Blueprint $table) {
            $table->string('batch_satuan')->nullable()->after('batch_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_summary_drafts', function (Blueprint $table) {
            $table->dropColumn('batch_satuan');
        });
    }
};
