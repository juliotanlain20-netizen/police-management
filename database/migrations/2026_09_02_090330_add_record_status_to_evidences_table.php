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
        Schema::table('evidences', function (Blueprint $table) {
        $table->enum('record_status', [
            'Valid',
            'Voided',
        ])->default('Valid');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evidences', function (Blueprint $table) {
              $table->dropColumn('record_status');
        });
    }
};
