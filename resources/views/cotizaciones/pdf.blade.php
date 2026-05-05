<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización - Preview</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; margin: 0; padding: 0; }
        .container { padding: 30px; }
        .header { border-bottom: 2px solid #ef4444; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; color: #ef4444; }
        .info-section { margin-bottom: 20px; }
        .info-section h3 { border-bottom: 1px solid #ddd; padding-bottom: 5px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #eee; padding: 8px; text-align: left; }
        th { background-color: #f9f9f9; font-weight: bold; }
        .total-section { margin-top: 30px; text-align: right; }
        .total-box { display: inline-block; padding: 10px 20px; background-color: #f1f1f1; border-radius: 5px; }
        .footer { position: fixed; bottom: 30px; left: 0; right: 0; text-align: center; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cotización de Evento</h1>
            <p>Descripción: {{ $cotizacion['descripcion'] ?? 'N/A' }}</p>
        </div>

        <div class="info-section">
            <h3>Detalles del Evento</h3>
            <p><strong>Fecha Inicio:</strong> {{ $cotizacion['fecha_ini'] ?? '-' }}</p>
            <p><strong>Fecha Fin:</strong> {{ $cotizacion['fecha_fin'] ?? '-' }}</p>
        </div>

        @if(isset($cotizacion['tarifas']) && count($cotizacion['tarifas']) > 0)
        <div class="info-section">
            <h3>Espacios y Tarifas</h3>
            <table>
                <thead>
                    <tr>
                        <th>Descripción/Espacio</th>
                        <th>Días</th>
                        <th>Precio Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalTarifas = 0; @endphp
                    @foreach($cotizacion['tarifas'] as $tarifa)
                        @php $sub = $tarifa['dias'] * $tarifa['precio_aplicado']; $totalTarifas += $sub; @endphp
                        <tr>
                            <td>Tarifa #{{ $tarifa['id'] }}</td>
                            <td>{{ $tarifa['dias'] }}</td>
                            <td>{{ number_format($tarifa['precio_aplicado'], 2) }} Bs.</td>
                            <td>{{ number_format($sub, 2) }} Bs.</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @if(isset($cotizacion['servicios']) && count($cotizacion['servicios']) > 0)
        <div class="info-section">
            <h3>Servicios Adicionales</h3>
            <table>
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Cant.</th>
                        <th>Precio Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalServicios = 0; @endphp
                    @foreach($cotizacion['servicios'] as $servicio)
                        @php $sub = $servicio['cantidad'] * $servicio['precio_aplicado']; $totalServicios += $sub; @endphp
                        <tr>
                            <td>Servicio #{{ $servicio['id'] }}</td>
                            <td>{{ $servicio['cantidad'] }}</td>
                            <td>{{ number_format($servicio['precio_aplicado'], 2) }} Bs.</td>
                            <td>{{ number_format($sub, 2) }} Bs.</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="total-section">
            <div class="total-box">
                @php 
                    $final = ($totalTarifas ?? 0) + ($totalServicios ?? 0);
                @endphp
                <h2>Total: {{ number_format($final, 2) }} Bs.</h2>
            </div>
        </div>

        <div class="footer">
            Generado automáticamente por el Sistema de Gestión de Eventos.
        </div>
    </div>
</body>
</html>
