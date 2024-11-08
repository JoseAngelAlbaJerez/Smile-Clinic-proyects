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
        Schema::create('odontodiagramas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('patient_id');
            $table->integer('caries')->default(0);
            $table->integer('restauraciones')->default(0);
            $table->integer('extracciones')->default(0);
            $table->integer('ausencias')->default(0);
            $table->integer('puentes')->default(0);
            $table->integer('endodoncias')->default(0);
            $table->integer('implantes')->default(0);
            $table->timestamps();
            $table->foreign('patient_id')->references('pacient_id')->on('pacient')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('odontodiagramas');
    }
};
