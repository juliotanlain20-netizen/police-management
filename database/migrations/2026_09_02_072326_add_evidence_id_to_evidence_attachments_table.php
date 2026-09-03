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
        Schema::table('evidence_attachments', function (Blueprint $table) {
            Schema::table('evidence_attachments', function (Blueprint $table) {
                $table->foreignId('evidence_id')
                    ->constrained('evidences')
                    ->cascadeOnDelete();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evidence_attachments', function (Blueprint $table) {

            Schema::table('evidence_attachments', function (Blueprint $table) {
                $table->dropForeign(['evidence_id']);
                $table->dropColumn('evidence_id');
            });
        });
    }
};
