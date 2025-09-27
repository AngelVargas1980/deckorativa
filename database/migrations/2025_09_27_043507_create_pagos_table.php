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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string('checkout_id')->unique(); // ID del checkout de Recurrente
            $table->string('payment_intent_id')->nullable(); // ID del payment intent
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('cascade');
            $table->string('customer_email');
            $table->string('customer_name');
            $table->enum('estado', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuesto', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('moneda', 3)->default('GTQ');
            $table->json('items'); // Detalles de los servicios comprados
            $table->string('checkout_url')->nullable(); // URL del checkout de Recurrente
            $table->json('recurrente_response')->nullable(); // Respuesta completa de Recurrente
            $table->timestamp('fecha_pago')->nullable();
            $table->string('metodo_pago')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->index(['estado', 'created_at']);
            $table->index('customer_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
