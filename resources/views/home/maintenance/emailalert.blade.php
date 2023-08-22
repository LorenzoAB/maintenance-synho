<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Detallado de Proceso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px auto;
            max-width: 600px;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .header, .footer {
            text-align: center;
            padding: 20px;
            background-color: #343a40;
            color: white;
        }
        .content {
            padding: 20px;
            background-color: white;
            border: 1px solid #ced4da;
            margin-bottom: 20px;
        }
        .content p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Informe Detallado de Proceso</h2>
    </div>

    <div class="content">
        <p><strong>Fecha de Inicio:</strong> {{ $data['fecha_inicio'] }}</p>
        <p><strong>Usuario:</strong> {{ $data['usuario'] }}</p>
        <p><strong>Máquina:</strong> {{ $data['maquina'] }}</p>
        <p><strong>Proceso:</strong> {{ $data['proceso'] }}</p>
        <p><strong>Descripción:</strong> {{ $data['descripcion'] }}</p>
    </div>

    <div class="footer">
        <p>Estamos aquí para ayudarte. Si tienes alguna pregunta o inquietud, no dudes en contactarnos. ¡Gracias por confiar en nosotros!</p>
    </div>
</body>
</html>
