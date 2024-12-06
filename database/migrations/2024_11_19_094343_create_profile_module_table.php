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
        // Crear la tabla profile_module
        Schema::create('profile_module', function (Blueprint $table) {
            $table->id();
            // Clave foránea hacia la tabla profile
            $table->foreignId('id_profile')
                  ->nullable()
                  ->constrained('profile') // Hace referencia a la tabla 'profile'
                  ->nullOnDelete(); // Establece que al eliminar un perfil, el campo queda como NULL
    
            // Clave foránea hacia la tabla module
            $table->foreignId('id_module')
                  ->nullable()
                  ->constrained('module') // Hace referencia a la tabla 'module'
                  ->nullOnDelete(); // Establece que al eliminar un módulo, el campo queda como NULL
    
            $table->integer('view_start');
            $table->integer('status');
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_module');
    }
};
