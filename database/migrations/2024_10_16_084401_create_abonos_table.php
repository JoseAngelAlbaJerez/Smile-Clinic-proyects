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
        Schema::create('abonos', function (Blueprint $table) {
            $table->id();
            $table->string('procedure');
            $table->string('treatment')->nullable();
            $table->decimal('quantity', 8, 2);
            $table->decimal('amount', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->decimal('coberture', 8, 2);
            $table->decimal('Total', 8, 2);
            $table->foreignId('patient_id')->nullable()->constrained('pacient')->nullOnDelete();
            $table->foreignId('c_x_c_id')->nullable()->constrained('_c_x_c')->nullOnDelete();
            $table->timestamps();
            $table->float('abonar')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonos');
    }
};
