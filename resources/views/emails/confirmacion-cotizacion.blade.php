<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Solicitud de Cotización</title>
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
        .success-box {
            background: #d1fae5;
            border: 1px solid #10b981;
            padding: 20px;
            border-radius: 8px;
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
        .contact-box {
            background: #e0e7ff;
            border: 1px solid #7c3aed;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎨 DECKORATIVA</h1>
        <h2>¡Solicitud Recibida!</h2>
        <p>Hola <strong>{{ $nombre }}</strong>, gracias por confiar en nosotros</p>
    </div>

    <div class="content">
        <div class="success-box">
            <h3>✅ ¡Tu solicitud ha sido enviada exitosamente!</h3>
            <p><strong>Número de Cotización:</strong> {{ $numero_cotizacion }}</p>
            <p><strong>Fecha:</strong> {{ $fecha }}</p>
        </div>

        <h3>📋 Resumen de tu Solicitud</h3>
        <div class="info-box">
            <p><strong>👤 Nombre:</strong> {{ $nombre }}</p>
            <p><strong>📧 Email:</strong> {{ $email }}</p>
            <p><strong>📞 Teléfono:</strong> {{ $telefono }}</p>
            @if($mensaje)
                <p><strong>💬 Tu Mensaje:</strong></p>
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

        <div class="total-box">
            💵 TOTAL ESTIMADO: Q{{ number_format($total, 2) }}
        </div>

        <div class="contact-box">
            <h3>📞 ¿Qué sigue ahora?</h3>
            <ol>
                <li><strong>Respuesta rápida:</strong> Te contactaremos dentro de las próximas 24 horas</li>
                <li><strong>Evaluación:</strong> Si es necesario, programaremos una visita gratuita</li>
                <li><strong>Cotización oficial:</strong> Recibirás una propuesta detallada y personalizada</li>
                <li><strong>Inicio del proyecto:</strong> Una vez aprobado, comenzamos tu transformación</li>
            </ol>
        </div>

        <div style="background: #fef3c7; border: 1px solid #f59e0b; padding: 15px; border-radius: 8px; margin-top: 20px;">
            <p><strong>⚠️ Nota Importante:</strong> Los precios mostrados son estimaciones basadas en información general. La cotización final puede variar según las especificaciones técnicas, materiales seleccionados y condiciones del proyecto.</p>
        </div>

        <div class="contact-box">
            <h3>📱 ¿Necesitas ayuda inmediata?</h3>
            <p><strong>📞 Teléfono:</strong> +502 0000-0000</p>
            <p><strong>📧 Email:</strong> info@deckorativa.com</p>
            <p><strong>💬 WhatsApp:</strong> +502 0000-0000</p>
            <p><strong>🕒 Horarios:</strong> Lunes a Viernes de 8:00 AM a 6:00 PM</p>
        </div>
    </div>

    <div class="footer">
        <p><strong>¡Gracias por confiar en DECKORATIVA!</strong></p>
        <p>Tu socio en decoración y diseño de interiores</p>
        <p style="margin-top: 10px;">Este es un mensaje automático, por favor no responder a este correo.</p>
    </div>
</body>
</html>