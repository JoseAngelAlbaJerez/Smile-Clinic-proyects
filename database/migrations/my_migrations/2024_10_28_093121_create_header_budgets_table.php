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
        Schema::create('header_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('pacient')->onDelete('cascade');
            $table->foreignId('c_x_c_id')->nullable()->constrained('_c_x_c')->nullOnDelete();
            $table->string('type', 50)->nullable();
            $table->decimal('Total', 8, 2);
            $table->foreignId('budget_detail_id')->nullable()->constrained('budgets')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_budgets');
    }
};
