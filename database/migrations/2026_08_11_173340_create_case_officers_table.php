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
        Schema::create('case_officers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investigation_case_id');
            $table->foreign('investigation_case_id')->references('id')->on('investigation_cases')->onDelete('cascade');
            $table->unsignedBigInteger('police_officer_id');
            $table->foreign('police_officer_id')->references('id')->on('police_officers')->onDelete('cascade');
            $table->enum('status',[
                'Active',
                'Inactive',
            ]);
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamps();
            $table->unique(['investigation_case_id', 'police_officer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_officers');
    }
};
