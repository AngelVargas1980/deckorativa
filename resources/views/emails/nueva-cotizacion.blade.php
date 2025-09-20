<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Cotización</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #7c3aed, #3730a3);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f8fafc;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .info-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #7c3aed;
        }
        .servicios-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        .servicios-table th {
            background: #7c3aed;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .servicios-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        .servicios-table tr:nth-child(even) {
            background: #f9fafb;
        }
        .total-box {
            background: #059669;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎨 DECKORATIVA</h1>
        <h2>Nueva Solicitud de Cotización</h2>
        <p><strong>{{ $numero_cotizacion }}</strong></p>
    </div>

    <div class="content">
        <h3>📋 Información del Cliente</h3>
        <div class="info-box">
            <p><strong>👤 Nombre:</strong> {{ $nombre }}</p>
            <p><strong>📧 Email:</strong> {{ $email }}</p>
            <p><strong>📞 Teléfono:</strong> {{ $telefono }}</p>
            <p><strong>📅 Fecha de Solicitud:</strong> {{ $fecha }}</p>
            @if($mensaje)
                <p><strong>💬 Mensaje del Cliente:</strong></p>
                <p style="font-style: italic; background: #f3f4f6; padding: 10px; border-radius: 4px;">{{ $mensaje }}</p>
            @endif
        </div>

        <h3>🛍️ Servicios Solicitados</h3>
        <table class="servicios-table">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                    <th>Precio Unit.</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrito as $item)
                <tr>
                    <td><strong>{{ $item['nombre'] }}</strong></td>
                    <td>{{ $item['categoria'] }}</td>
                    <td style="text-align: center;">{{ $item['cantidad'] }}</td>
                    <td style="text-align: right;">Q{{ number_format($item['precio'], 2) }}</td>
                    <td style="text-align: right;">Q{{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3>💰 Resumen Financiero</h3>
        <div class="info-box">
            <p><strong>Subtotal:</strong> Q{{ number_format($subtotal, 2) }}</p>
            <p><strong>IVA (12%):</strong> Q{{ number_format($iva, 2) }}</p>
        </div>

        <div class="total-box">
            💵 TOTAL ESTIMADO: Q{{ number_format($total, 2) }}
        </div>

        <div style="background: #fef3c7; border: 1px solid #f59e0b; padding: 15px; border-radius: 8px; margin-top: 20px;">
            <p><strong>⚠️ Próximos Pasos:</strong></p>
            <ol>
                <li>Contactar al cliente dentro de las próximas 24 horas</li>
                <li>Programar una visita de evaluación si es necesario</li>
                <li>Enviar cotización oficial detallada</li>
                <li>Dar seguimiento al proceso de ventas</li>
            </ol>
        </div>
    </div>

    <div class="footer">
        <p>Este es un mensaje automático del sistema de cotizaciones de DECKORATIVA</p>
        <p>Para responder al cliente, utilice: <strong>{{ $email }}</strong></p>
    </div>
</body>
</html>