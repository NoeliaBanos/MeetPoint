<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
</head>
<body>
    <h1>Contacto</h1>
    <form action="{{ route('contacto.store') }}" method="POST">
        @csrf
        <label for="asunto">Asunto:</label>
        <input type="text" name="asunto" id="asunto" required><br>

        <label for="mensaje">Mensaje:</label>
        <textarea name="mensaje" id="mensaje" required></textarea><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>
