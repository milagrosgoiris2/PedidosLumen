<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido #{{ $pedido->id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .box {
            border: 1px solid #ccc;
            padding: 12px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>

    <h1>Pedido #{{ $pedido->id }}</h1>

    {{-- DATOS GENERALES --}}
    <div class="box">

        {{-- TIPO --}}
        <p>
            <strong>Tipo:</strong>
            {{ $pedido->tipo == 1 ? 'A proveedor' : 'Entre locales' }}
        </p>

        {{-- ENTRE LOCALES --}}
        @if($pedido->tipo == 2)
            <p>
                <strong>Origen:</strong>
                {{ $pedido->origen?->nombre ?? '—' }}
            </p>

            <p>
                <strong>Destino:</strong>
                {{ $pedido->destino?->nombre ?? '—' }}
            </p>
        @else
        {{-- A PROVEEDOR --}}
            <p>
                <strong>Proveedor:</strong>
                {{ $pedido->proveedor?->nombre ?? '—' }}
            </p>
        @endif

        <p>
            <strong>Estado:</strong>
            {{ \App\Models\Pedido::labels()[$pedido->estado] ?? '—' }}
        </p>

        <p>
            <strong>Fecha:</strong>
            {{ $pedido->created_at?->format('d/m/Y') }}
        </p>
    </div>

    {{-- ITEMS --}}
    <h3>Ítems del pedido</h3>

    <table>
        <thead>
            <tr>
                <th>Marca</th>
                <th>Producto</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->items as $item)
                <tr>
                    <td>{{ $item->producto->marca->nombre ?? '—' }}</td>
                    <td>{{ $item->producto->nombre }}</td>
                    <td>{{ number_format($item->cantidad, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Sistema Pedidos Lumen — Documento generado automáticamente
    </div>

</body>
</html>
