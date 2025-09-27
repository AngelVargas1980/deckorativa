<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecurrenteService
{
    private $baseUrl;
    private $publicKey;
    private $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('app.env') === 'production'
            ? env('RECURRENTE_BASE_URL', 'https://app.recurrente.com/api')
            : env('RECURRENTE_BASE_URL', 'https://app.recurrente.com/api');

        $this->publicKey = env('RECURRENTE_PUBLIC_KEY');
        $this->secretKey = env('RECURRENTE_SECRET_KEY');
    }

    /**
     * Crear un checkout en Recurrente
     */
    public function crearCheckout(array $items, array $customerData, array $options = [])
    {
        try {
            $data = $this->prepararDatosCheckout($items, $customerData, $options);

            // Debug: Log datos preparados para Recurrente
            Log::info('=== DEBUG RECURRENTE SERVICE ===', [
                'items_received' => $items,
                'items_count' => count($items),
                'customer_data' => $customerData,
                'prepared_data' => $data,
                'api_url' => $this->baseUrl . '/checkouts'
            ]);

            // Enviar como JSON según pruebas exitosas
            $response = Http::withHeaders([
                'X-PUBLIC-KEY' => $this->publicKey,
                'X-SECRET-KEY' => $this->secretKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
            ->post($this->baseUrl . '/checkouts', $data);

            // Debug: Log respuesta completa de Recurrente
            Log::info('=== RESPUESTA COMPLETA DE RECURRENTE ===', [
                'status_code' => $response->status(),
                'headers' => $response->headers(),
                'response_body' => $response->body(),
                'response_json' => $response->json()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                Log::info('Checkout creado exitosamente:', $responseData);

                return [
                    'success' => true,
                    'data' => $responseData
                ];
            }

            Log::error('Error al crear checkout en Recurrente', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => 'Error al procesar el pago. Intente nuevamente.',
                'details' => $response->json()
            ];

        } catch (\Exception $e) {
            Log::error('Excepción al crear checkout en Recurrente', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'Error interno del servidor. Intente nuevamente.',
                'exception' => $e->getMessage()
            ];
        }
    }

    /**
     * Obtener información de un checkout
     */
    public function obtenerCheckout($checkoutId)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get($this->baseUrl . '/checkouts/' . $checkoutId);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'error' => 'No se pudo obtener la información del checkout'
            ];

        } catch (\Exception $e) {
            Log::error('Error al obtener checkout', [
                'checkout_id' => $checkoutId,
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => 'Error al consultar el estado del pago'
            ];
        }
    }

    /**
     * Verificar el estado de un pago
     */
    public function verificarPago($checkoutId)
    {
        $resultado = $this->obtenerCheckout($checkoutId);

        if (!$resultado['success']) {
            return $resultado;
        }

        $checkout = $resultado['data'];

        return [
            'success' => true,
            'estado' => $checkout['status'] ?? 'unknown',
            'data' => $checkout
        ];
    }

    /**
     * Crear headers para la API
     */
    private function getHeaders()
    {
        return [
            'X-PUBLIC-KEY' => $this->publicKey,
            'X-SECRET-KEY' => $this->secretKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    /**
     * Preparar datos para el checkout en formato JSON según pruebas exitosas
     */
    private function prepararDatosCheckout(array $items, array $customerData, array $options = [])
    {
        $data = [];

        // Agregar items en formato de array JSON
        $data['items'] = [];
        foreach ($items as $item) {
            $itemData = [
                'name' => $item['name'],
                'currency' => $item['currency'] ?? 'GTQ',
                'amount_in_cents' => $item['amount_in_cents'],
                'quantity' => $item['quantity'] ?? 1,
                'has_dynamic_pricing' => false
            ];

            // Imagen opcional
            if (isset($item['image_url']) && $item['image_url']) {
                $itemData['image_url'] = $item['image_url'];
            }

            $data['items'][] = $itemData;
        }

        // URLs de éxito y cancelación (requeridas)
        $data['success_url'] = $options['success_url'] ?? route('public.payment.success');
        $data['cancel_url'] = $options['cancel_url'] ?? route('public.payment.cancel');

        // Datos del usuario (opcional)
        if (isset($customerData['user_id'])) {
            $data['user_id'] = $customerData['user_id'];
        }

        // Metadata (opcional)
        if (isset($options['metadata'])) {
            $data['metadata'] = $options['metadata'];
        }

        Log::info('Datos preparados para Recurrente (JSON):', $data);

        return $data;
    }

    /**
     * Convertir array de servicios del carrito a formato de Recurrente
     */
    public function convertirCarritoAItems(array $carrito)
    {
        $items = [];

        foreach ($carrito as $item) {
            $items[] = [
                'name' => $item['nombre'],
                'currency' => 'GTQ',
                'amount_in_cents' => intval($item['precio'] * 100), // Convertir a centavos
                'quantity' => $item['cantidad'] ?? 1,
                'image_url' => $item['imagen'] ?? null
            ];
        }

        return $items;
    }

    /**
     * Calcular totales del carrito
     */
    public function calcularTotales(array $carrito)
    {
        $subtotal = 0;

        foreach ($carrito as $item) {
            $subtotal += ($item['precio'] * ($item['cantidad'] ?? 1));
        }

        $impuesto = $subtotal * 0.12; // 12% IVA
        $total = $subtotal + $impuesto;

        return [
            'subtotal' => round($subtotal, 2),
            'impuesto' => round($impuesto, 2),
            'total' => round($total, 2)
        ];
    }

    /**
     * Probar la autenticación con Recurrente
     */
    public function probarAutenticacion()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get($this->baseUrl . '/test');

            return [
                'success' => $response->successful(),
                'status_code' => $response->status(),
                'response' => $response->json()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

}