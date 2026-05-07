<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización Institutional - Chuquiago Marka</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; color: #1e293b; margin: 0; padding: 0; line-height: 1.3; position: relative; }
        
        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.04;
            width: 500px;
            z-index: -1000;
        }

        /* Top Brand Stripes */
        .brand-stripes { height: 12px; width: 100%; display: table; table-layout: fixed; }
        .stripe { display: table-cell; height: 12px; }
        .stripe-red { background-color: #ef4444; }
        .stripe-yellow { background-color: #fbbf24; }
        .stripe-green { background-color: #15803d; }

        .content { padding: 30px 45px; position: relative; }

        /* header */
        .header-table { width: 100%; border: none; margin-bottom: 20px; }
        .header-table td { border: none; vertical-align: middle; }
        .logo-img { height: 75px; }
        .company-header-info { text-align: right; color: #475569; font-size: 9px; }
        .company-header-info h2 { margin: 0; color: #0d4a3e; font-size: 12px; font-weight: 800; line-height: 1.2; }
        
        /* Dark Green Banner */
        .banner { 
            background-color: #06352c; 
            color: #facc15; 
            padding: 8px 20px; 
            display: table; 
            width: 100%; 
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        .banner-title { display: table-cell; font-size: 11px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; vertical-align: middle; }
        .banner-code { display: table-cell; text-align: right; font-size: 12px; font-weight: 800; vertical-align: middle; color: white; }

        /* Meta Grid */
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; table-layout: fixed; }
        .meta-table td { padding: 5px 10px 5px 0; border: none; vertical-align: top; width: 20%; overflow-wrap: break-word; word-wrap: break-word; }
        .meta-label { color: #15803d; font-weight: 800; font-size: 8px; text-transform: uppercase; margin-bottom: 2px; }
        .meta-value { font-weight: 800; font-size: 11px; color: #0f172a; margin-bottom: 2px; }
        .meta-sub { color: #64748b; font-size: 8px; font-weight: 400; }

        /* Badges */
        .badge-container { margin-bottom: 20px; }
        .badge { 
            display: inline-block; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 9px; 
            font-weight: 700; 
            margin-right: 10px;
            border: 1px solid;
        }
        .badge-green { background-color: #f0fdf4; color: #15803d; border-color: #15803d; }
        .badge-orange { background-color: #fffaf0; color: #b45309; border-color: #fed7aa; }

        /* Main Data Tables */
        .section-header { 
            background-color: #334155; 
            color: white; 
            padding: 5px 12px; 
            font-size: 9px; 
            font-weight: 800; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
            margin-bottom: 0;
        }
        
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .data-table th { 
            text-align: left; 
            padding: 6px 12px; 
            font-size: 8px; 
            color: #475569; 
            border-bottom: 1px solid #cbd5e1;
            background-color: white;
            font-weight: 700;
            text-transform: uppercase;
        }
        .data-table td { 
            padding: 10px 12px; 
            border-bottom: 1px solid #f1f5f9; 
            vertical-align: middle; 
            font-size: 10px;
        }
        .item-name { font-weight: 800; color: #0f172a; font-size: 11px; }
        .col-right { text-align: right; font-weight: 600; }
        .col-subtotal { text-align: right; font-weight: 800; color: #0f172a; font-size: 11px; }

        /* Summary Totals */
        .summary-row { width: 100%; margin-top: 5px; }
        .summary-label { text-align: right; color: #64748b; font-weight: 700; padding: 4px 12px; width: 80%; font-size: 10px; }
        .summary-value { text-align: right; color: #0f172a; font-weight: 800; padding: 4px 12px; width: 20%; font-size: 11px; }

        .total-box { 
            background-color: #06352c; 
            color: #facc15; 
            padding: 10px 20px; 
            width: 100%; 
            margin-top: 10px;
            display: table;
            box-sizing: border-box;
        }
        .total-box-label { display: table-cell; font-size: 12px; font-weight: 900; vertical-align: middle; text-transform: uppercase; letter-spacing: 1px; }
        .total-box-value { display: table-cell; text-align: right; font-size: 22px; font-weight: 900; vertical-align: middle; }

        /* Legal info */
        .legal { text-align: center; font-size: 8px; color: #94a3b8; margin-top: 25px; font-style: italic; }

        /* Footer */
        .footer-fixed { position: fixed; bottom: 0; width: 100%; border-top: 1px solid #cbd5e1; }
        .footer-table { width: 100%; padding: 15px 45px; }
        .footer-table td { border: none; font-size: 8px; color: #64748b; }
        .footer-center { text-align: center; color: #15803d; font-weight: bold; }
        .footer-right { text-align: right; }
    </style>
</head>
<body>
    @if($logoBase64)
        <img src="{{ $logoBase64 }}" class="watermark" alt="Watermark">
    @endif

    <!-- Top Stripes -->
    <div class="brand-stripes">
        <div class="stripe stripe-red"></div>
        <div class="stripe stripe-yellow"></div>
        <div class="stripe stripe-green"></div>
    </div>

    <div class="content">
        <!-- header -->
        <table class="header-table">
            <tr>
                <td>
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" class="logo-img" alt="Logo">
                    @else
                        <div style="font-weight: bold; font-size: 20px; color: #0d4a3e;">CAMPO FERIAL<br>Chuquiago Marka</div>
                    @endif
                </td>
                <td class="company-header-info">
                    <h2>Unidad de Coordinación de Programas y Proyectos</h2>
                    www.chuquiagomarka.com.bo &bull; www.ucpp.gob.bo<br>
                    La Paz, Bolivia
                </td>
            </tr>
        </table>

        <!-- banner -->
        <div class="banner">
            <div class="banner-title">Cotización de Arrendamiento</div>
            <div class="banner-code">COT-2026-{{ str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT) }}</div>
        </div>

        <!-- Meta info -->
        <table class="meta-table">
            <tr>
                <td>
                    <div class="meta-label">Cliente</div>
                    <div class="meta-value">{{ $cotizacion['entidad_nombre'] ?? 'S/N' }}</div>
                    <div class="meta-sub">NIT: {{ $cotizacion['nit'] ?? '9222358A' }}</div>
                </td>
                <td>
                    <div class="meta-label">Contacto</div>
                    <div class="meta-value">{{ $cotizacion['contacto_nombre'] ?? 'Juan Perez' }}</div>
                    <div class="meta-sub">{{ $cotizacion['telefono'] ?? '73767252' }}</div>
                </td>
                <td>
                    <div class="meta-label">Tipo de Evento</div>
                    <div class="meta-value">{{ $cotizacion['tipo_evento_nombre'] ?? 'Feria' }}</div>
                </td>
                <td>
                    <div class="meta-label">Fecha(s)</div>
                    <div class="meta-value">{{ $cotizacion['fecha_rango'] ?? '-' }}</div>
                    <div class="meta-sub">{{ $cotizacion['total_dias'] ?? 1 }} días</div>
                </td>
                <td>
                    <div class="meta-label">Emisión</div>
                    <div class="meta-value">{{ now()->translatedFormat('d \d\e F \d\e Y') }}</div>
                    <div class="meta-sub">Patricia Castillo<br>Santander</div>
                </td>
            </tr>
        </table>

        <!-- Badges -->
        <div class="badge-container">
            <div class="badge badge-green">{{ $cotizacion['total_dias'] ?? 1 }} días</div>
            <div class="badge badge-orange">{{ $cotizacion['temporada_label'] ?? 'Temporada mixta' }}</div>
        </div>

        <!-- Spaces Table -->
        <div class="section-header">Arrendamiento de Espacios</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 40%">Espacio</th>
                    <th style="width: 25%">Tipo de Evento</th>
                    <th style="width: 15%; text-align: right;">Tarifa/día</th>
                    <th style="width: 5%; text-align: right;">Días</th>
                    <th style="width: 15%; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cotizacion['espacios'] ?? [] as $espacio)
                <tr>
                    <td class="item-name">{{ $espacio['nombre'] }}</td>
                    <td>{{ $espacio['tarifa_nombre'] ?? '-' }}</td>
                    <td class="col-right">Bs {{ number_format($espacio['precio_dia'], 2, ',', '.') }}</td>
                    <td class="col-right">{{ $espacio['dias'] }}</td>
                    <td class="col-subtotal">Bs {{ number_format($espacio['subtotal'], 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Services Table -->
        @if(count($cotizacion['servicios'] ?? []) > 0)
        <div class="section-header">Servicios Adicionales</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 40%">Servicio</th>
                    <th style="width: 25%; text-align: right;">Precio</th>
                    <th style="width: 10%; text-align: right;">Cant.</th>
                    <th style="width: 10%; text-align: right;">Días</th>
                    <th style="width: 15%; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cotizacion['servicios'] ?? [] as $servicio)
                <tr>
                    <td class="item-name">{{ $servicio['nombre'] }}</td>
                    <td class="col-right">Bs {{ number_format($servicio['precio'], 2, ',', '.') }}</td>
                    <td class="col-right">{{ $servicio['cantidad'] }}</td>
                    <td class="col-right">{{ $servicio['dias'] }}</td>
                    <td class="col-subtotal">Bs {{ number_format($servicio['subtotal'], 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Summary -->
        <table style="width: 100%; margin-top: 10px; border-collapse: collapse;">
            <tr>
                <td class="summary-label">Subtotal Arrendamiento</td>
                <td class="summary-value">Bs {{ number_format($cotizacion['subtotal_espacios'] ?? 0, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="summary-label">Subtotal Servicios</td>
                <td class="summary-value">Bs {{ number_format($cotizacion['subtotal_servicios'] ?? 0, 2, ',', '.') }}</td>
            </tr>
        </table>

        <div class="total-box">
            <div class="total-box-label">Total Cotización</div>
            <div class="total-box-value">Bs {{ number_format($cotizacion['total'] ?? 0, 2, ',', '.') }}</div>
        </div>

        <div class="legal">
            Todos los precios incluyen impuestos de ley (IT/IVA). Cotización válida 15 días calendario. Para reserva formal se requiere carta de solicitud oficial.
        </div>
    </div>

    <!-- footer -->
    <div class="footer-fixed">
        <table class="footer-table">
            <tr>
                <td>Campo Ferial Chuquiago Marka - Gestión 2026</td>
                <td class="footer-center">www.chuquiagomarka.com.bo - www.ucpp.gob.bo</td>
                <td class="footer-right">COT-2026-004</td>
            </tr>
        </table>
        <div class="brand-stripes">
            <div class="stripe stripe-red"></div>
            <div class="stripe stripe-yellow"></div>
            <div class="stripe stripe-green"></div>
        </div>
    </div>
</body>
</html>
