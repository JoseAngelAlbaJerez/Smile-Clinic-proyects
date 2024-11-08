<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('budgets', function (Blueprint $table) {
        $table->id();
        $table->string('procedure');
        $table->string('treatment')->nullable();
        $table->decimal('quantity', 8, 2);
        $table->decimal('amount', 8, 2);
        $table->decimal('discount', 8, 2);
        $table->decimal('coberture', 8, 2);
        $table->decimal('Total', 8, 2);
        $table->timestamps();

    
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
