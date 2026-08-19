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
        Schema::create('suspects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investigation_case_id');
            $table->foreign('investigation_case_id')->references('id')->on('investigation_cases')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('identity_number')->nullable();
            $table->enum('status', [
                'identified',
                'wanted',
                'detainded',
                'release'
            ]);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suspects');
    }
};
