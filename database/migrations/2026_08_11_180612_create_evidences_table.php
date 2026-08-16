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
        Schema::create('evidences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investigation_case_id');
            $table->foreign('investigation_case_id')->references('id')->on('investigation_cases')->onDelete('cascade');
            $table->unsignedBigInteger('evidence_category_id');
            $table->foreign('evidence_category_id')->references('id')->on('evidence_categories')->onDelete('cascade');
            $table->string('evidence_code',50)->unique();
            $table->string('name',150);
            $table->text('description')->nullable();
            $table->string('storage_location');
            $table->enum('status',[
                'Stored',
                'Borrowed',
                'Returned',
                'Destroyed',
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidence');
    }
};
