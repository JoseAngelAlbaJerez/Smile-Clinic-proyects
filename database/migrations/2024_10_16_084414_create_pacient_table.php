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
        Schema::create('pacient', function (Blueprint $table) {
            $table->id('pacient_id');
            $table->date('fecha');
            $table->string('ars');
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('complications')->nullable();
            $table->text('complication_detail')->nullable();
            $table->string('alergies')->nullable();
            $table->text('alergies_detail')->nullable();
            $table->string('drugs')->nullable();
            $table->text('drugs_detail')->nullable();
            $table->string('motive');
            $table->string('address');
            $table->string('Cedula');
            $table->string('phone');
            $table->timestamps();
            $table->date('date')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacient');
    }
};
