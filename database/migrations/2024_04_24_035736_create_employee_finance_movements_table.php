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
        Schema::create('employee_finance_movements', function (Blueprint $table) {
            $table->id();
            $table->uuid('employee_id');
            $table->string('description');
            $table->integer('amount');
            $table->dateTime('date');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_finance_movements');
    }
};
