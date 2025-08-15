<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('identification_number')->nullable();
            $table->string('first_name');  // Nombre
            $table->string('last_name');   // Apellidos
            $table->string('phone');       // Teléfono
            $table->string('email')->unique(); // Correo
            $table->boolean('email_verified')->default(false); // Verificación de correo
            $table->timestamps();
        });

    }    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');

    }
};




