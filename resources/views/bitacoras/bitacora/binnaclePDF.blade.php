<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de la Bitácora</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .header, .footer {
            text-align: center;
        }
        .content {
            margin-top: 20px;
        }
        .images img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        table th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="content">
        <h3>DETALLE DEL REGISTRO DE BITACORA</h3>
        <table>
            <tr>
                <th>Título</th>
                <td>{{ $binnacle->title }}</td>
            </tr>
            <tr>
                <th>Tipo de Observación</th>
                <td>{{ $binnacle->observationType->name }}</td>
            </tr>
            <tr>
                <th>Sede</th>
                <td>{{ $binnacle->headquarter->name }}</td>
            </tr>
            <tr>
                <th>Creado por</th>
                <td>{{ $binnacle->user->name }}</td>
            </tr>
            <tr>
                <th>Fecha de Creación</th>
                <td>{{ $binnacle->created_at->format('d/m/Y h:i A') }}</td>
            </tr>
        </table>

        <h3>OBSERVACIÓN</h3>
        <p>{{ $binnacle->observation }}</p>

        @if ($binnacle->images && count($binnacle->images) > 0)
            <h3>EVIDENCIA</h3>
            <div class="images">
                @foreach ($binnacle->images as $image)
                    <img src="{{ public_path('storage/' . $image) }}" alt="Imagen" style="max-height: 200px; width: auto; margin-bottom: 10px;">
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>