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
        Schema::table('investigation_cases', function (Blueprint $table) {
            $table->enum('status', [
                'Open',
                'In Progress',
                'Closed',
            ]);
            $table->enum('priority', [
                'Low',
                'Medium',
                'High',
            ]);
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investigation_cases', function (Blueprint $table) {
            $table->dropColumn(['priority', 'status','opened_at','closed_at']);
        });
    }
};
