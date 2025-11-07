<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido - {{ $pedido->numero_pedido }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #3b82f6;
            margin: 0;
        }
        .company-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .pedido-info {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }
        .pedido-numero {
            font-size: 20px;
            font-weight: bold;
            color: #3b82f6;
            margin: 0;
        }
        .fecha {
            color: #666;
            font-size: 14px;
        }
        .cliente-info {
            background: #f0fdf4;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #10b981;
        }
        .info-box {
            background: #fff7ed;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #f97316;
        }
        .servicios-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .servicios-table th {
            background: #3b82f6;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        .servicios-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        .servicios-table tr:nth-child(even) {
            background: #f9fafb;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totales {
            margin-top: 20px;
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
            max-width: 400px;
            margin-left: auto;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .total-final {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: bold;
            color: #3b82f6;
            border-top: 1px solid #d1d5db;
            padding-top: 10px;
            margin-top: 10px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #666;
        }
        .nota {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            margin-top: 20px;
            font-size: 12px;
        }
        .estado-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .estado-pendiente { background: #fef3c7; color: #92400e; }
        .estado-en_proceso { background: #dbeafe; color: #1e40af; }
        .estado-completado { background: #d1fae5; color: #065f46; }
        .estado-cancelado { background: #fee2e2; color: #991b1b; }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
        .print-controls {
            position: fixed;
            top: 10px;
            right: 10px;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .info-item {
            background: #f9fafb;
            padding: 12px;
            border-radius: 6px;
            border-left: 3px solid #3b82f6;
        }
        .info-label {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 14px;
            color: #111827;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Controles de impresión -->
    <div class="print-controls no-print">
        <button onclick="window.print()" style="background: #3b82f6; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin-right: 8px;">
            📄 Imprimir/Guardar PDF
        </button>
        <button onclick="window.close()" style="background: #6b7280; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
            ✕ Cerrar
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <h1 class="company-name">DECKORATIVA</h1>
        <div class="company-info">
            <div>📧 ventas.deckorativa@gmail.com | 📞 +502 0000-0000</div>
            <div>📍 Guatemala, Guatemala</div>
        </div>
    </div>

    <!-- Información del Pedido -->
    <div class="pedido-info">
        <div>
            <h2 class="pedido-numero">Pedido #{{ $pedido->numero_pedido }}</h2>
            <div class="fecha">Fecha de creación: {{ $pedido->created_at->format('d/m/Y H:i') }}</div>
            @if($pedido->fecha_entrega)
                <div class="fecha">Fecha de entrega: {{ $pedido->fecha_entrega->format('d/m/Y') }}</div>
            @endif
        </div>
        <div>
            <span class="estado-badge estado-{{ $pedido->estado }}">
                {{ strtoupper($pedido->estado_formateado) }}
            </span>
        </div>
    </div>

    <!-- Información Adicional del Pedido -->
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">📞 Teléfono de Contacto</div>
            <div class="info-value">{{ $pedido->telefono_contacto }}</div>
        </div>
        @if($pedido->cotizacion)
            <div class="info-item">
                <div class="info-label">💼 Cotización Relacionada</div>
                <div class="info-value">{{ $pedido->cotizacion->numero_cotizacion }}</div>
            </div>
        @endif
        <div class="info-item">
            <div class="info-label">📦 Total de Servicios</div>
            <div class="info-value">{{ count($pedido->detalles) }} servicio(s)</div>
        </div>
    </div>

    <!-- Información del Cliente -->
    <div class="cliente-info">
        <h3 style="margin: 0 0 10px 0; color: #10b981;">👤 Información del Cliente</h3>
        <div><strong>Cliente:</strong> {{ $pedido->cliente->first_name }} {{ $pedido->cliente->last_name }}</div>
        <div><strong>Email:</strong> {{ $pedido->cliente->email }}</div>
        @if($pedido->cliente->phone)
            <div><strong>Teléfono:</strong> {{ $pedido->cliente->phone }}</div>
        @endif
        @if($pedido->cliente->identification_number)
            <div><strong>Identificación:</strong> {{ $pedido->cliente->identification_number }}</div>
        @endif
    </div>

    <!-- Dirección de Entrega -->
    <div class="info-box">
        <h3 style="margin: 0 0 10px 0; color: #f97316;">📍 Dirección de Entrega</h3>
        <div>{{ $pedido->direccion_entrega }}</div>
    </div>

    @if($pedido->observaciones)
    <div style="background: #f3f4f6; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
        <strong>📝 Observaciones:</strong><br>
        {{ $pedido->observaciones }}
    </div>
    @endif

    <!-- Servicios/Productos -->
    <h3 style="color: #3b82f6; margin-bottom: 15px;">📋 Detalle de Servicios Incluidos</h3>
    <table class="servicios-table">
        <thead>
            <tr>
                <th>Servicio</th>
                <th class="text-center">Cantidad</th>
                <th class="text-right">Precio Unit.</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->detalles as $detalle)
            <tr>
                <td>
                    <strong>{{ $detalle->servicio->nombre }}</strong>
                    @if($detalle->servicio->descripcion)
                        <br><small style="color: #6b7280;">{{ Str::limit($detalle->servicio->descripcion, 100) }}</small>
                    @endif
                </td>
                <td class="text-center">{{ $detalle->cantidad }}</td>
                <td class="text-right">${{ number_format($detalle->precio_unitario, 2) }}</td>
                <td class="text-right">${{ number_format($detalle->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totales -->
    <div class="totales">
        <div class="total-final">
            <span>TOTAL DEL PEDIDO:</span>
            <span>${{ number_format($pedido->total, 2) }}</span>
        </div>
    </div>

    <!-- Nota importante -->
    <div class="nota">
        <strong>⚠️ Nota Importante:</strong> Este documento confirma el pedido realizado. Por favor, verifica que toda la información sea correcta. Cualquier modificación debe ser notificada inmediatamente.
    </div>

    <!-- Footer -->
    <div class="footer">
        <div style="margin-bottom: 10px;"><strong>Información del Pedido:</strong></div>
        <ul style="margin: 0; padding-left: 20px; font-size: 11px;">
            <li>Pedido creado el {{ $pedido->created_at->format('d/m/Y H:i') }}</li>
            @if($pedido->updated_at != $pedido->created_at)
                <li>Última actualización: {{ $pedido->updated_at->format('d/m/Y H:i') }}</li>
            @endif
            <li>Estado actual: {{ $pedido->estado_formateado }}</li>
            <li>Total de servicios: {{ count($pedido->detalles) }}</li>
            <li>Cantidad total de items: {{ $pedido->detalles->sum('cantidad') }}</li>
            <li>Para cualquier consulta o modificación, por favor contactar con su asesor de ventas.</li>
        </ul>

        <div style="margin-top: 20px; text-align: center; color: #3b82f6;">
            <strong>¡Gracias por confiar en DECKORATIVA!</strong><br>
            Su socio en decoración y diseño de interiores
        </div>
    </div>

    <script>
        // Automáticamente mostrar el diálogo de impresión cuando se carga la página
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>