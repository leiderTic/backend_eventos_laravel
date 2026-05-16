<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Evento;
use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Tarifa;
use App\Models\CotizacionHistorial;

class CotizacionController extends Controller
{
    public function index()
    {
        $query = Cotizacion::with(['user', 'evento', 'clientes', 'servicios', 'tarifas.evento', 'tarifas.espacio'])
            ->orderBy('created_at', 'desc');

        // Buena Práctica de Seguridad (Row-Level Security):
        $user = Auth::user();
        
        if ($user) {
            // Filtramos directamente por el ID del usuario en sesión
            // Nota: Si luego agregas un campo a tu BD (ej. $user->is_admin == true), puedes envolver esto en un IF.
            $query->where('user_id', $user->id);
        }

        $cotizaciones = $query->get();
        return response()->json($cotizaciones);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_ini',
            'evento_id' => 'required|exists:eventos,id',
            'clientes' => 'nullable|array',
            'clientes.*.id' => 'required|exists:clientes,id',
            'servicios' => 'nullable|array',
            'servicios.*.id' => 'required|exists:servicios,id',
            'servicios.*.cantidad' => 'required|numeric|min:0',
            'servicios.*.dias' => 'required|numeric|min:1',
            'servicios.*.precio_aplicado' => 'required|numeric|min:0',
            'tarifas' => 'nullable|array',
            'tarifas.*.id' => 'required|exists:tarifas,id',
            'tarifas.*.dias' => 'required|numeric|min:0',
            'tarifas.*.precio_aplicado' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request) {
            $userId = Auth::id() ?? 1;
            $user = User::find($userId);
            $anioActual = date('Y');

            $maxCorrelativo = Cotizacion::where('user_id', $userId)
                ->whereYear('created_at', $anioActual)
                ->max('correlativo');

            $siguienteCorrelativo = $maxCorrelativo ? $maxCorrelativo + 1 : 1;
            $correlativoFormateado = str_pad($siguienteCorrelativo, 3, '0', STR_PAD_LEFT);
            $codigo = 'COT-' . $user->alias . '-' . $correlativoFormateado . '/' . $anioActual;

            $cotizacion = Cotizacion::create([
                'codigo' => $codigo,
                'correlativo' => $siguienteCorrelativo,
                'descripcion' => $request->descripcion,
                'fecha_ini' => $request->fecha_ini,
                'fecha_fin' => $request->fecha_fin,
                'paso' => 1,
                'user_id' => $userId,
                'evento_id' => $request->evento_id,
            ]);

            if ($request->has('clientes')) {
                $syncData = [];
                foreach ($request->clientes as $cliente) {
                    if (isset($cliente['id']) && $cliente['id']) {
                        $syncData[$cliente['id']] = ['estado' => true];
                    }
                }
                $cotizacion->clientes()->sync($syncData);
            }

            if ($request->has('servicios')) {
                $syncData = [];
                foreach ($request->servicios as $servicio) {
                    $syncData[$servicio['id']] = [
                        'cantidad' => $servicio['cantidad'],
                        'dias' => $servicio['dias'],
                        'precio_aplicado' => $servicio['precio_aplicado'],
                        'estado' => true
                    ];
                }
                $cotizacion->servicios()->sync($syncData);
            }

            if ($request->has('tarifas')) {
                $syncData = [];
                foreach ($request->tarifas as $tarifa) {
                    $syncData[$tarifa['id']] = [
                        'dias' => $tarifa['dias'],
                        'precio_aplicado' => $tarifa['precio_aplicado'],
                        'estado' => true
                    ];
                }
                $cotizacion->tarifas()->sync($syncData);
            }

            // Recalcular totales después de sincronizar relaciones
            $cotizacion->refreshTotals();

            return response()->json($cotizacion->load(['clientes', 'servicios', 'tarifas']), 201);
        });
    }

    public function show(string $id)
    {
        $cotizacion = Cotizacion::with(['user', 'evento', 'clientes', 'servicios', 'tarifas.evento', 'tarifas.espacio'])
            ->findOrFail($id);
        return response()->json($cotizacion);
    }

    public function update(Request $request, string $id)
    {
        $cotizacion = Cotizacion::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_ini',
            'evento_id' => 'required|exists:eventos,id',
            'paso' => 'integer',
            'vencido' => 'boolean',
            'motivo' => 'required|string|min:5' // Nuevo campo obligatorio para auditoría
        ]);

        return DB::transaction(function () use ($request, $cotizacion) {
            // Guardamos los cambios realizados (opcionalmente)
            $oldData = $cotizacion->toArray();
            
            $cotizacion->update($request->only(['descripcion', 'fecha_ini', 'fecha_fin', 'paso', 'vencido', 'evento_id']));

            if ($request->has('clientes')) {
                $syncData = [];
                foreach ($request->clientes as $cliente) {
                    $syncData[$cliente['id']] = ['estado' => true];
                }
                $cotizacion->clientes()->sync($syncData);
            }

            if ($request->has('servicios')) {
                $syncData = [];
                foreach ($request->servicios as $servicio) {
                    $syncData[$servicio['id']] = [
                        'cantidad' => $servicio['cantidad'],
                        'precio_aplicado' => $servicio['precio_aplicado'],
                        'estado' => $servicio['estado'] ?? true
                    ];
                }
                $cotizacion->servicios()->sync($syncData);
            }

            if ($request->has('tarifas')) {
                $syncData = [];
                foreach ($request->tarifas as $tarifa) {
                    $syncData[$tarifa['id']] = [
                        'dias' => $tarifa['dias'],
                        'precio_aplicado' => $tarifa['precio_aplicado'],
                        'estado' => $tarifa['estado'] ?? true
                    ];
                }
                $cotizacion->tarifas()->sync($syncData);
            }

            // Recalcular totales después de sincronizar relaciones
            $cotizacion->refreshTotals();

            // Registrar en el historial
            CotizacionHistorial::create([
                'cotizacion_id' => $cotizacion->id,
                'user_id' => Auth::id() ?? 1, // Fallback si no hay sesión para pruebas
                'accion' => 'actualizacion',
                'motivo' => $request->motivo,
                'cambios' => [
                    'antes' => $oldData,
                    'despues' => $cotizacion->fresh()->toArray()
                ]
            ]);

            return response()->json($cotizacion->load(['clientes', 'servicios', 'tarifas', 'historial.user']));
        });
    }

    public function destroy(string $id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        $cotizacion->delete();
        return response()->json(['message' => 'Cotización eliminada correctamente']);
    }

    public function preview(Request $request)
    {
        try {
            app()->setLocale('es');
            $cotizacion = $request->all();
            
            if(!isset($cotizacion['codigo'])) {
                $cotizacion['codigo'] = 'NO REGISTRADO - VISTA PREVIA';
                $cotizacion['is_preview'] = true;
            }

            // 1. Hidratar Evento
            $evento = Evento::find($cotizacion['evento_id'] ?? null);
            $cotizacion['tipo_evento_nombre'] = $evento ? $evento->descripcion : 'Evento Desconocido';
            
            // Rango de fechas
            $fIni = isset($cotizacion['fecha_ini']) ? Carbon::parse($cotizacion['fecha_ini'])->translatedFormat('d \d\e F \d\e Y') : date('d \d\e F \d\e Y');
            $fFin = isset($cotizacion['fecha_fin']) ? Carbon::parse($cotizacion['fecha_fin'])->translatedFormat('d \d\e F \d\e Y') : date('d \d\e F \d\e Y');
            $cotizacion['fecha_rango'] = $fIni . ' al ' . $fFin;
            $cotizacion['temporada_label'] = 'Vista Previa';

            // 2. Hidratar Clientes (Buscar temporal o numérico)
            $clientePrincipal = null;
            $contactoInfo = null;

            if (!empty($cotizacion['clientes'])) {
                $cData = $cotizacion['clientes'][0];
                if (isset($cData['id']) && is_numeric($cData['id'])) {
                    $clientePrincipal = Cliente::find($cData['id']);
                } else {
                    $clientePrincipal = (object) $cData; // Soporte para clientes inyectados en vista previa
                }
                
                if (isset($cotizacion['clientes'][1])) {
                    $contData = $cotizacion['clientes'][1];
                    if (isset($contData['id']) && is_numeric($contData['id'])) {
                        $contactoInfo = Cliente::find($contData['id']);
                    } else {
                        $contactoInfo = (object) $contData;
                    }
                } else {
                    $contactoInfo = $clientePrincipal;
                }
            }

            if ($clientePrincipal && isset($clientePrincipal->nombre)) {
                $cotizacion['entidad_nombre'] = $clientePrincipal->nombre;
                $cotizacion['nit'] = $clientePrincipal->ci_nit ?? $clientePrincipal->nit ?? '-';
                
                // Buscar telefono en el contacto o en el cliente
                $telObj = (isset($contactoInfo->telefono) && $contactoInfo->telefono) ? $contactoInfo : $clientePrincipal;
                $tel = $telObj->telefono ?? $telObj->telefono_fijo ?? '';
                if ($tel && !empty($telObj->telefono_codigo)) {
                    $tel = '+' . $telObj->telefono_codigo . ' ' . $tel;
                } elseif ($tel && is_numeric($telObj->id ?? '')) {
                    $tel = '+591 ' . $tel; // Fallback
                }
                $cotizacion['telefono'] = $tel ?: '-';
                
                $cotizacion['contacto_nombre'] = $contactoInfo->nombre ?? 'Contacto';
            } else {
                $cotizacion['entidad_nombre'] = 'Cliente (En borrador)';
                $cotizacion['nit'] = '-';
                $cotizacion['telefono'] = '-';
                $cotizacion['contacto_nombre'] = 'Contacto (En borrador)';
            }

            // 3. Hidratar Espacios a partir de Tarifas
            $totalDias = 0;
            $subtotalEspacios = 0;
            $espaciosMapeados = [];
            if (!empty($cotizacion['tarifas'])) {
                foreach ($cotizacion['tarifas'] as $tarifa) {
                    $tarifaModel = Tarifa::with('espacio')->find($tarifa['id'] ?? null);
                    $nombreEspacio = ($tarifaModel && $tarifaModel->espacio) ? $tarifaModel->espacio->nombre : 'Espacio Borrador';
                    
                    $dias = floatval($tarifa['dias'] ?? 1);
                    $precio = floatval($tarifa['precio_aplicado'] ?? 0);
                    $sub = $dias * $precio;
                    $subtotalEspacios += $sub;
                    if ($dias > $totalDias) $totalDias = $dias;

                    $espaciosMapeados[] = [
                        'nombre' => $nombreEspacio,
                        'precio_dia' => $precio,
                        'dias' => $dias,
                        'subtotal' => $sub
                    ];
                }
            }
            $cotizacion['espacios'] = $espaciosMapeados;
            $cotizacion['total_dias'] = $totalDias > 0 ? $totalDias : 1;
            $cotizacion['subtotal_espacios'] = $subtotalEspacios;

            // 4. Hidratar Servicios
            $subtotalServicios = 0;
            $serviciosMapeados = [];
            if (!empty($cotizacion['servicios'])) {
                foreach ($cotizacion['servicios'] as $servicio) {
                    $servicioModel = Servicio::find($servicio['id'] ?? null);
                    $nombreServicio = $servicioModel ? $servicioModel->nombre : 'Servicio Borrador';
                    
                    $cantidad = floatval($servicio['cantidad'] ?? 1);
                    $dias = floatval($servicio['dias'] ?? 1);
                    $precio = floatval($servicio['precio_aplicado'] ?? 0);
                    $sub = $cantidad * $dias * $precio;
                    $subtotalServicios += $sub;

                    $serviciosMapeados[] = [
                        'nombre' => $nombreServicio,
                        'cantidad' => $cantidad,
                        'dias' => $dias,
                        'precio' => $precio,
                        'subtotal' => $sub
                    ];
                }
            }
            $cotizacion['servicios'] = $serviciosMapeados;
            $cotizacion['subtotal_servicios'] = $subtotalServicios;
            $cotizacion['total'] = $subtotalEspacios + $subtotalServicios;
            
            // Cargar Logo como Base64 para máxima compatibilidad con DomPDF
            $logoPath = public_path('image/logo.png');
            $logoBase64 = '';
            if (file_exists($logoPath)) {
                $type = pathinfo($logoPath, PATHINFO_EXTENSION);
                $data = file_get_contents($logoPath);
                $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }

            // Configuración para optimizar rendimiento y compatibilidad
            $pdf = Pdf::loadView('cotizaciones.pdf', compact('cotizacion', 'logoBase64'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'sans-serif'
                ]);

            return $pdf->stream('preview.pdf');
        } catch (\Exception $e) {
            \Log::error("Error en PDF Preview: " . $e->getMessage());
            return response()->json([
                'error' => 'Error al generar el PDF',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function imprimir($id)
    {
        try {
            app()->setLocale('es');
            $cotModel = Cotizacion::with(['evento', 'clientes', 'servicios', 'tarifas.espacio'])->findOrFail($id);
            
            $cotizacion = [
                'codigo' => $cotModel->codigo,
                'is_preview' => false,
                'tipo_evento_nombre' => $cotModel->evento ? $cotModel->evento->descripcion : 'Evento Desconocido',
                'temporada_label' => 'Cotización Oficial',
                'descripcion' => $cotModel->descripcion,
            ];
            
            $fIni = Carbon::parse($cotModel->fecha_ini)->translatedFormat('d \d\e F \d\e Y');
            $fFin = Carbon::parse($cotModel->fecha_fin)->translatedFormat('d \d\e F \d\e Y');
            $cotizacion['fecha_rango'] = $fIni . ' al ' . $fFin;
            
            $clientePrincipal = $cotModel->clientes->firstWhere('tipo_cliente_id', 1) ?? $cotModel->clientes->first();
            $contactoInfo = $cotModel->clientes->firstWhere('tipo_cliente_id', 2) ?? $clientePrincipal;
            
            if ($clientePrincipal) {
                $cotizacion['entidad_nombre'] = $clientePrincipal->nombre;
                $cotizacion['nit'] = $clientePrincipal->ci_nit ?? $clientePrincipal->nit ?? '-';
                
                $telObj = ($contactoInfo && $contactoInfo->telefono) ? $contactoInfo : $clientePrincipal;
                $tel = $telObj->telefono ?? $telObj->telefono_fijo ?? '';
                if ($tel && !empty($telObj->telefono_codigo)) {
                    $tel = '+' . $telObj->telefono_codigo . ' ' . $tel;
                }
                $cotizacion['telefono'] = $tel ?: '-';
                $cotizacion['contacto_nombre'] = $contactoInfo ? $contactoInfo->nombre : 'Contacto';
            }
            
            $totalDias = 0;
            $espaciosMapeados = [];
            foreach ($cotModel->tarifas as $tarifa) {
                $dias = floatval($tarifa->pivot->dias ?? 1);
                $precio = floatval($tarifa->pivot->precio_aplicado ?? 0);
                $sub = $dias * $precio;
                if ($dias > $totalDias) $totalDias = $dias;

                $espaciosMapeados[] = [
                    'nombre' => $tarifa->espacio ? $tarifa->espacio->nombre : 'Espacio',
                    'precio_dia' => $precio,
                    'dias' => $dias,
                    'subtotal' => $sub
                ];
            }
            $cotizacion['espacios'] = $espaciosMapeados;
            $cotizacion['total_dias'] = $totalDias > 0 ? $totalDias : 1;
            $cotizacion['subtotal_espacios'] = $cotModel->monto_tarifas;
            
            $serviciosMapeados = [];
            foreach ($cotModel->servicios as $servicio) {
                $cantidad = floatval($servicio->pivot->cantidad ?? 1);
                $dias = floatval($servicio->pivot->dias ?? 1);
                $precio = floatval($servicio->pivot->precio_aplicado ?? 0);
                $sub = $cantidad * $dias * $precio;

                $serviciosMapeados[] = [
                    'nombre' => $servicio->nombre,
                    'cantidad' => $cantidad,
                    'dias' => $dias,
                    'precio' => $precio,
                    'subtotal' => $sub
                ];
            }
            $cotizacion['servicios'] = $serviciosMapeados;
            $cotizacion['subtotal_servicios'] = $cotModel->monto_servicios;
            $cotizacion['total'] = $cotModel->monto_total;
            
            $logoPath = public_path('image/logo.png');
            $logoBase64 = '';
            if (file_exists($logoPath)) {
                $type = pathinfo($logoPath, PATHINFO_EXTENSION);
                $data = file_get_contents($logoPath);
                $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }

            $pdf = Pdf::loadView('cotizaciones.pdf', compact('cotizacion', 'logoBase64'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'sans-serif'
                ]);

            // Reemplazar la barra inclinada '/' por un guion '-' para el nombre del archivo
            $nombreArchivo = str_replace('/', '-', $cotModel->codigo) . '.pdf';
            return $pdf->stream($nombreArchivo);
        } catch (\Exception $e) {
            \Log::error("Error en PDF Imprimir: " . $e->getMessage());
            return response()->json(['error' => 'Error al generar el PDF', 'message' => $e->getMessage()], 500);
        }
    }
}
