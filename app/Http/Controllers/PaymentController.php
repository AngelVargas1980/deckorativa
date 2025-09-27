<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecurrenteService;
use App\Models\Pago;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected $recurrenteService;

    public function __construct(RecurrenteService $recurrenteService)
    {
        $this->recurrenteService = $recurrenteService;
    }

    /**
     * Procesar el checkout del carrito
     */
    public function procesarCarrito(Request $request)
    {
        // Debug: Log de datos recibidos
        Log::info('=== DEBUG PAYMENT CONTROLLER ===', [
            'all_input' => $request->all(),
            'items_received' => $request->input('items'),
            'items_count' => count($request->input('items', [])),
            'customer_data' => [
                'name' => $request->input('customer_name'),
                'email' => $request->input('customer_email'),
                'phone' => $request->input('customer_phone')
            ]
        ]);

        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'subtotal' => 'required|numeric|min:0',
            'iva' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $items = $request->input('items');
            $customerData = [
                'name' => $request->input('customer_name'),
                'email' => $request->input('customer_email'),
                'phone' => $request->input('customer_phone')
            ];

            // Convertir items a formato de Recurrente
            $recurrenteItems = $this->recurrenteService->convertirCarritoAItems($items);

            $totales = [
                'subtotal' => $request->input('subtotal'),
                'iva' => $request->input('iva'),
                'total' => $request->input('total')
            ];

            // Buscar o crear cliente
            $client = $this->buscarOCrearCliente($customerData);

            // Crear checkout en Recurrente
            $checkoutOptions = [
                'success_url' => route('public.payment.success'),
                'cancel_url' => route('public.payment.cancel'),
                'metadata' => [
                    'client_id' => $client->id,
                    'source' => 'carrito_publico'
                ]
            ];

            $resultado = $this->recurrenteService->crearCheckout($recurrenteItems, $customerData, $checkoutOptions);

            if (!$resultado['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $resultado['error']
                ], 400);
            }

            $checkoutData = $resultado['data'];

            // Debug: Log the actual response structure
            Log::info('Recurrente checkout response structure', [
                'response_keys' => array_keys($checkoutData),
                'full_response' => $checkoutData
            ]);

            // Verificar que tenemos la URL del checkout (respuesta directa de Recurrente)
            $checkoutUrl = $checkoutData['checkout_url'] ?? null;

            if (!$checkoutUrl) {
                Log::error('No se pudo obtener URL de checkout de la respuesta de Recurrente', [
                    'response_data' => $checkoutData
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Error al generar enlace de pago. Por favor intente nuevamente.',
                    'debug_info' => config('app.debug') ? [
                        'available_fields' => array_keys($checkoutData)
                    ] : null
                ], 500);
            }

            // Guardar el pago en la base de datos
            $pago = Pago::create([
                'checkout_id' => $checkoutData['id'],
                'client_id' => $client->id,
                'customer_email' => $customerData['email'],
                'customer_name' => $customerData['name'],
                'estado' => 'pending',
                'subtotal' => $totales['subtotal'],
                'impuesto' => $totales['iva'],
                'total' => $totales['total'],
                'moneda' => 'GTQ',
                'items' => $items,
                'checkout_url' => $checkoutUrl,
                'recurrente_response' => $checkoutData
            ]);

            Log::info('Pago creado exitosamente', [
                'pago_id' => $pago->id,
                'checkout_url' => $checkoutUrl,
                'checkout_id' => $checkoutData['id']
            ]);

            return response()->json([
                'success' => true,
                'checkout_url' => $checkoutUrl,
                'checkout_id' => $checkoutData['id'],
                'pago_id' => $pago->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error al procesar carrito para pago', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor. Intente nuevamente.'
            ], 500);
        }
    }

    /**
     * Página de éxito después del pago
     */
    public function success(Request $request)
    {
        $checkoutId = $request->query('checkout_id');

        if (!$checkoutId) {
            return redirect()->route('public.home')->with('error', 'Pago no encontrado.');
        }

        // Buscar el pago en nuestra base de datos
        $pago = Pago::where('checkout_id', $checkoutId)->first();

        if (!$pago) {
            return redirect()->route('public.home')->with('error', 'Pago no encontrado en nuestros registros.');
        }

        // Verificar el estado con Recurrente
        $resultado = $this->recurrenteService->verificarPago($checkoutId);

        if ($resultado['success'] && $resultado['estado'] === 'paid') {
            $pago->marcarComoCompletado();

            return view('public.payment.success', [
                'pago' => $pago,
                'checkout_data' => $resultado['data']
            ]);
        }

        return view('public.payment.pending', [
            'pago' => $pago
        ]);
    }

    /**
     * Página de cancelación del pago
     */
    public function cancel(Request $request)
    {
        $checkoutId = $request->query('checkout_id');

        if ($checkoutId) {
            $pago = Pago::where('checkout_id', $checkoutId)->first();
            if ($pago && $pago->estado === 'pending') {
                $pago->update(['estado' => 'cancelled']);
            }
        }

        return view('public.payment.cancel');
    }

    /**
     * Webhook para recibir notificaciones de Recurrente
     */
    public function webhook(Request $request)
    {
        try {
            Log::info('Webhook recibido de Recurrente', $request->all());

            $eventType = $request->input('event_type');
            $checkoutData = $request->input('checkout');

            if (!$checkoutData || !isset($checkoutData['id'])) {
                Log::warning('Webhook sin datos de checkout válidos');
                return response()->json(['status' => 'error'], 400);
            }

            $checkoutId = $checkoutData['id'];
            $pago = Pago::where('checkout_id', $checkoutId)->first();

            if (!$pago) {
                Log::warning('Pago no encontrado para checkout ID: ' . $checkoutId);
                return response()->json(['status' => 'not_found'], 404);
            }

            switch ($eventType) {
                case 'payment_intent.succeeded':
                    $paymentData = $request->input('payment', []);
                    $paymentIntentId = $paymentData['id'] ?? null;

                    $pago->marcarComoCompletado($paymentIntentId, 'card');

                    Log::info('Pago completado via webhook', [
                        'pago_id' => $pago->id,
                        'checkout_id' => $checkoutId
                    ]);
                    break;

                case 'payment_intent.failed':
                    $failureReason = $request->input('failure_reason', 'Pago rechazado');
                    $pago->marcarComoFallido($failureReason);

                    Log::info('Pago fallido via webhook', [
                        'pago_id' => $pago->id,
                        'reason' => $failureReason
                    ]);
                    break;

                case 'bank_transfer_intent.succeeded':
                    $pago->marcarComoCompletado(null, 'bank_transfer');

                    Log::info('Pago por transferencia completado via webhook', [
                        'pago_id' => $pago->id
                    ]);
                    break;

                case 'bank_transfer_intent.failed':
                    $pago->marcarComoFallido('Transferencia bancaria fallida');
                    break;
            }

            // Actualizar la respuesta de Recurrente
            $pago->update([
                'recurrente_response' => array_merge(
                    $pago->recurrente_response ?? [],
                    ['last_webhook' => $request->all()]
                )
            ]);

            return response()->json(['status' => 'ok']);

        } catch (\Exception $e) {
            Log::error('Error procesando webhook de Recurrente', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);

            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Verificar el estado de un pago
     */
    public function verificarEstado($pagoId)
    {
        $pago = Pago::findOrFail($pagoId);

        if ($pago->isCompletado()) {
            return response()->json([
                'success' => true,
                'estado' => 'completed',
                'pago' => $pago
            ]);
        }

        // Verificar con Recurrente si está pendiente
        if ($pago->isPendiente()) {
            $resultado = $this->recurrenteService->verificarPago($pago->checkout_id);

            if ($resultado['success'] && $resultado['estado'] === 'paid') {
                $pago->marcarComoCompletado();

                return response()->json([
                    'success' => true,
                    'estado' => 'completed',
                    'pago' => $pago->fresh()
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'estado' => $pago->estado,
            'pago' => $pago
        ]);
    }

    /**
     * Buscar o crear un cliente
     */
    private function buscarOCrearCliente(array $customerData)
    {
        $client = Client::where('email', $customerData['email'])->first();

        if (!$client) {
            // Dividir el nombre completo en first_name y last_name
            $nameParts = explode(' ', trim($customerData['name']), 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            $client = Client::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $customerData['email'],
                'phone' => $customerData['phone'] ?? null,
            ]);
        }

        return $client;
    }

    /**
     * Probar la conexión con Recurrente
     */
    public function probarConexion()
    {
        $resultado = $this->recurrenteService->probarAutenticacion();

        return response()->json($resultado);
    }
}
