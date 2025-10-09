<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización {{ $cotizacion->numero_cotizacion }}</title>
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
            padding: 30px 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
        }
        .header p {
            margin: 0;
            opacity: 0.9;
        }
        .content {
            background: #f8fafc;
            padding: 30px 20px;
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
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
        }
        .cta-button {
            display: inline-block;
            background: #7c3aed;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .alert-box {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎨 DECKORATIVA</h1>
        <p>Cotización de Servicios de Decoración</p>
        <h2 style="margin: 15px 0 0 0;">#{{ $cotizacion->numero_cotizacion }}</h2>
    </div>

    <div class="content">
        <p>Estimado/a <strong>{{ $cotizacion->client->nombre_completo }}</strong>,</p>

        <p>Nos complace enviarle la cotización solicitada para nuestros servicios de decoración. A continuación encontrará el detalle completo:</p>

        <h3 style="color: #7c3aed; margin-top: 30px;">📋 Resumen de la Cotización</h3>
        <div class="info-box">
            <p><strong>Número de Cotización:</strong> {{ $cotizacion->numero_cotizacion }}</p>
            <p><strong>Fecha de Emisión:</strong> {{ $cotizacion->created_at->format('d/m/Y') }}</p>
            <p><strong>Válida hasta:</strong> {{ $cotizacion->fecha_vigencia->format('d/m/Y') }}</p>
            <p><strong>Estado:</strong> <span style="text-transform: uppercase; color: #059669;">{{ $cotizacion->estado }}</span></p>
        </div>

        @if($cotizacion->observaciones)
        <div class="info-box">
            <p><strong>Observaciones:</strong></p>
            <p>{{ $cotizacion->observaciones }}</p>
        </div>
        @endif

        <h3 style="color: #7c3aed;">🛍️ Servicios y Productos Cotizados</h3>
        <table class="servicios-table">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th style="text-align: center;">Cant.</th>
                    <th style="text-align: right;">Precio Unit.</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cotizacion->detalles as $detalle)
                <tr>
                    <td>
                        <strong>{{ $detalle->servicio->nombre }}</strong>
                        <br><small style="color: #6b7280;">{{ $detalle->servicio->categoria->nombre ?? 'Sin categoría' }}</small>
                        @if($detalle->notas)
                            <br><small style="color: #6b7280; font-style: italic;">{{ $detalle->notas }}</small>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $detalle->cantidad }}</td>
                    <td style="text-align: right;">Q{{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td style="text-align: right;"><strong>Q{{ number_format($detalle->subtotal, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3 style="color: #7c3aed;">💰 Resumen Financiero</h3>
        <div class="info-box">
            <p style="display: flex; justify-content: space-between;">
                <span>Subtotal:</span>
                <strong>Q{{ number_format($cotizacion->subtotal, 2) }}</strong>
            </p>
            @if($cotizacion->descuento > 0)
            <p style="display: flex; justify-content: space-between; color: #dc2626;">
                <span>Descuento:</span>
                <strong>- Q{{ number_format($cotizacion->descuento, 2) }}</strong>
            </p>
            @endif
            <p style="display: flex; justify-content: space-between;">
                <span>IVA ({{ $cotizacion->impuesto_porcentaje }}%):</span>
                <strong>Q{{ number_format($cotizacion->impuesto, 2) }}</strong>
            </p>
        </div>

        <div class="total-box">
            💵 TOTAL: Q{{ number_format($cotizacion->total, 2) }}
        </div>

        <div class="alert-box">
            <p><strong>⏰ Validez de la Cotización:</strong></p>
            <p>Esta cotización es válida hasta el <strong>{{ $cotizacion->fecha_vigencia->format('d/m/Y') }}</strong>. Después de esta fecha, los precios están sujetos a cambios.</p>
        </div>

        <div style="background: #f0fdf4; border-left: 4px solid #059669; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p><strong>✅ Próximos Pasos:</strong></p>
            <ol style="margin: 10px 0; padding-left: 20px;">
                <li>Revisar el detalle de la cotización</li>
                <li>Si tiene dudas, contáctenos directamente</li>
                <li>Para aprobar, responda este correo confirmando</li>
                <li>Coordinaremos los detalles del proyecto con usted</li>
            </ol>
        </div>

        <div style="text-align: center;">
            <p><strong>¿Tiene alguna pregunta?</strong></p>
            <p>Nuestro equipo está listo para ayudarle</p>
        </div>
    </div>

    <div class="footer">
        <p><strong>DECKORATIVA</strong> - Su socio en decoración profesional</p>
        <p>
            📧 ventas.deckorativa@gmail.com<br>
            📞 +502 0000-0000<br>
            📍 Guatemala, Guatemala
        </p>
        <p style="margin-top: 15px; font-size: 11px;">
            Este correo fue generado automáticamente por nuestro sistema de cotizaciones.<br>
            Para cualquier consulta, no dude en contactarnos.
        </p>
    </div>
</body>
</html>
