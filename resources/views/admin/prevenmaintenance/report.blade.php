<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SYNHO | Mantenimiento Preventivo</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            padding: 50px;
            color: #333;
        }

        h1, h3, h5 {
            color: #444;
            text-align: center;
            margin-bottom: 30px;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        .section-title {
            padding: 10px;
            margin-bottom: 30px;
            color: #007bff;
            text-align: center;
            border-bottom: 1px solid #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table th, table td {
            border: 1px solid #eaeaea;
            padding: 10px 15px;
            text-align: left;
        }

        table th {
            background-color: #f9f9f9;
            font-weight: 600;
        }

        p {
            margin: 20px 0;
            line-height: 1.6;
        }

        strong {
            color: #007bff;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Mantenimiento Preventivo</h1>

        <div class="section-title">
            <h5>INSTALACION/MAQUINA</h5>
        </div>
        <table>
            <thead>
                <tr>
                    <th>MAQUINA</th>
                    <th>ELEMENTOS</th>
                    <th>REVISION</th>
                    <th>FECHA PROGRAMADA</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailprevenmaintenance as $item)
                    <tr>
                        <td>{{ $item->maquina }}</td>
                        <td>{{ $item->elementos }}</td>
                        <td>{{ $item->revision }}</td>
                        <td>{{ $item->fechaprogramada }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="section-title">
            <h5>PARAMETROS A CONTROLAR</h5>
        </div>
        <p><strong>Enumerar Parametro:</strong> {{ $prevenmaintenance->parametro }}</p>
        <p><strong>Factibilidad de la Revisión:</strong> {{ $prevenmaintenance->factibilidad_revision }}</p>
        <p><strong>Personal a cargo:</strong> {{ $prevenmaintenance->personal }}</p>

        <div class="section-title">
            <h5>PRUEBAS A EJECUTAR</h5>
        </div>
        <p><strong>Enumerar Pruebas:</strong> {{ $prevenmaintenance->pruebas }}</p>
        <p><strong>Estado previo:</strong> {{ $prevenmaintenance->estado }}</p>
        <p><strong>Solucion efectuada:</strong> {{ $prevenmaintenance->solucion }}</p>
        <p><strong>Observaciones y Recomendaciones:</strong> {{ $prevenmaintenance->observacion }}</p>
    </div>
</body>

</html>
