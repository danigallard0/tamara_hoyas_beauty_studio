<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $factura->numero_factura }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #111827;
        }

        .contenedor {
            max-width: 900px;
            margin: 0 auto;
        }

        .cabecera {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .bloque {
            margin-bottom: 25px;
        }

        h1, h2, h3 {
            margin-bottom: 10px;
        }

        p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            border: 1px solid #d1d5db;
            padding: 10px;
            text-align: left;
        }

        .totales {
            margin-top: 20px;
            width: 320px;
            margin-left: auto;
        }

        .totales td {
            border: 1px solid #d1d5db;
            padding: 10px;
        }

        .acciones {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            text-decoration: none;
            color: #111827;
            margin-right: 10px;
        }

        @media print {
            .acciones {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <div class="acciones">
            <button onclick="window.print()" class="btn">Imprimir</button>
            <a href="{{ route('admin.facturas.show', $factura) }}" class="btn">Volver a la factura</a>
        </div>

        <div class="cabecera">
            <div>
                <h1>Tamara Hoyas Beauty Studio</h1>
                <p>Factura</p>
            </div>

            <div>
                <p><strong>Número:</strong> {{ $factura->numero_factura }}</p>
                <p><strong>Fecha emisión:</strong> {{ $factura->fecha_emision }}</p>
                <p><strong>Estado factura:</strong> {{ ucfirst($factura->estado_factura) }}</p>
                <p><strong>Estado cobro:</strong> {{ ucfirst($factura->estado_cobro) }}</p>
            </div>
        </div>

        <div class="bloque">
            <h3>Datos del cliente</h3>
            <p><strong>Nombre:</strong> {{ $factura->cita->user->name ?? 'Sin nombre' }}</p>
            <p><strong>Email:</strong> {{ $factura->cita->user->email ?? 'Sin email' }}</p>
        </div>

        <div class="bloque">
            <h3>Detalle de servicios</h3>

            <table>
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Precio aplicado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->cita->servicios as $servicio)
                        <tr>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ number_format($servicio->pivot->precio_aplicado, 2) }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bloque">
            <h3>Pagos registrados</h3>

            @if($factura->pagos->isEmpty())
                <p>No hay pagos registrados.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Método</th>
                            <th>Importe</th>
                            <th>Estado</th>
                            <th>Referencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factura->pagos as $pago)
                            <tr>
                                <td>{{ $pago->fecha_pago }}</td>
                                <td>{{ ucfirst($pago->metodo) }}</td>
                                <td>{{ number_format($pago->importe, 2) }} €</td>
                                <td>{{ ucfirst($pago->estado) }}</td>
                                <td>{{ $pago->referencia ?: 'Sin referencia' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <table class="totales">
            <tr>
                <td><strong>Base imponible</strong></td>
                <td>{{ number_format($factura->base_imponible, 2) }} €</td>
            </tr>
            <tr>
                <td><strong>IVA ({{ number_format($factura->iva_porcentaje, 2) }}%)</strong></td>
                <td>{{ number_format($factura->iva_importe, 2) }} €</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ number_format($factura->total, 2) }} €</strong></td>
            </tr>
            <tr>
                <td><strong>Total pagado</strong></td>
                <td>{{ number_format($factura->total_pagado, 2) }} €</td>
            </tr>
            <tr>
                <td><strong>Pendiente</strong></td>
                <td>{{ number_format($factura->total - $factura->total_pagado, 2) }} €</td>
            </tr>
        </table>
    </div>
</body>
</html>