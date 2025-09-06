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
        Schema::table('users', function (Blueprint $table) {
            // Eliminar la constraint única actual
            $table->dropUnique(['email']);
            
            // Crear nueva constraint única que incluya deleted_at
            // Solo será único si deleted_at es NULL (usuario activo)
            $table->unique(['email', 'deleted_at'], 'users_email_deleted_at_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir los cambios
            $table->dropUnique(['email', 'deleted_at']);
            $table->unique('email', 'users_email_unique');
        });
    }
};
