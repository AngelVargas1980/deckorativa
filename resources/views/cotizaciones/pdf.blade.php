<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización - {{ $cotizacion->numero_cotizacion }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            border-bottom: 3px solid #7c3aed;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #7c3aed;
            margin: 0;
        }
        .company-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .cotizacion-info {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }
        .cotizacion-numero {
            font-size: 20px;
            font-weight: bold;
            color: #7c3aed;
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
            border-left: 4px solid #059669;
        }
        .servicios-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .servicios-table th {
            background: #7c3aed;
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
            color: #059669;
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
        .estado-borrador { background: #e5e7eb; color: #374151; }
        .estado-enviada { background: #dbeafe; color: #1e40af; }
        .estado-aprobada { background: #d1fae5; color: #065f46; }
        .estado-rechazada { background: #fee2e2; color: #991b1b; }
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
    </style>
</head>
<body>
    <!-- Controles de impresión -->
    <div class="print-controls no-print">
        <button onclick="window.print()" style="background: #7c3aed; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin-right: 8px;">
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

    <!-- Información de la Cotización -->
    <div class="cotizacion-info">
        <div>
            <h2 class="cotizacion-numero">Cotización #{{ $cotizacion->numero_cotizacion }}</h2>
            <div class="fecha">Fecha: {{ $cotizacion->created_at->format('d/m/Y') }}</div>
            <div class="fecha">Válida hasta: {{ $cotizacion->fecha_vigencia->format('d/m/Y') }}</div>
        </div>
        <div>
            <span class="estado-badge estado-{{ $cotizacion->estado }}">
                {{ strtoupper($cotizacion->estado) }}
            </span>
        </div>
    </div>

    <!-- Información del Cliente -->
    <div class="cliente-info">
        <h3 style="margin: 0 0 10px 0; color: #059669;">Información del Cliente</h3>
        <div><strong>Cliente:</strong> {{ $cotizacion->client->name }}</div>
        <div><strong>Email:</strong> {{ $cotizacion->client->email }}</div>
        @if($cotizacion->client->phone)
            <div><strong>Teléfono:</strong> {{ $cotizacion->client->phone }}</div>
        @endif
        @if($cotizacion->client->identification_number)
            <div><strong>NIT/DPI:</strong> {{ $cotizacion->client->identification_number }}</div>
        @endif
    </div>

    @if($cotizacion->observaciones)
    <div style="background: #f3f4f6; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
        <strong>Observaciones:</strong><br>
        {{ $cotizacion->observaciones }}
    </div>
    @endif

    <!-- Servicios/Productos -->
    <h3 style="color: #7c3aed; margin-bottom: 15px;">Detalle de Servicios y Productos</h3>
    <table class="servicios-table">
        <thead>
            <tr>
                <th>Servicio/Producto</th>
                <th>Categoría</th>
                <th class="text-center">Cantidad</th>
                <th class="text-right">Precio Unit.</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cotizacion->detalles as $detalle)
            <tr>
                <td>
                    <strong>{{ $detalle->servicio->nombre }}</strong>
                    @if($detalle->notas)
                        <br><small style="color: #6b7280;">{{ $detalle->notas }}</small>
                    @endif
                </td>
                <td>{{ $detalle->servicio->categoria->nombre ?? 'Sin categoría' }}</td>
                <td class="text-center">{{ $detalle->cantidad }}</td>
                <td class="text-right">Q{{ number_format($detalle->precio_unitario, 2) }}</td>
                <td class="text-right">Q{{ number_format($detalle->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totales -->
    <div class="totales">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>Q{{ number_format($cotizacion->subtotal, 2) }}</span>
        </div>
        @if($cotizacion->descuento > 0)
        <div class="total-row" style="color: #dc2626;">
            <span>Descuento:</span>
            <span>- Q{{ number_format($cotizacion->descuento, 2) }}</span>
        </div>
        @endif
        <div class="total-row">
            <span>IVA (12%):</span>
            <span>Q{{ number_format($cotizacion->total_impuesto, 2) }}</span>
        </div>
        <div class="total-final">
            <span>TOTAL:</span>
            <span>Q{{ number_format($cotizacion->total, 2) }}</span>
        </div>
    </div>

    <!-- Nota importante -->
    <div class="nota">
        <strong>⚠️ Nota Importante:</strong> Esta es una cotización formal. Los precios indicados son válidos hasta la fecha de vigencia señalada. Cualquier modificación en los servicios, materiales o condiciones del proyecto será cotizada nuevamente.
    </div>

    <!-- Footer -->
    <div class="footer">
        <div style="margin-bottom: 10px;"><strong>Términos y Condiciones:</strong></div>
        <ul style="margin: 0; padding-left: 20px; font-size: 11px;">
            <li>Esta cotización tiene validez hasta el {{ $cotizacion->fecha_vigencia->format('d/m/Y') }}.</li>
            <li>Los precios incluyen mano de obra e instalación básica.</li>
            <li>Materiales adicionales no contemplados serán cotizados por separado.</li>
            <li>Se requiere un anticipo del 50% para iniciar el proyecto.</li>
            <li>El tiempo de entrega será definido una vez confirmado el proyecto.</li>
            <li>Generado por: {{ $cotizacion->user->name }} el {{ $cotizacion->created_at->format('d/m/Y H:i') }}</li>
        </ul>

        <div style="margin-top: 20px; text-align: center; color: #7c3aed;">
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
