<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<div class="formulario">
    <h2>Administrador</h2>

    <form action="validar.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contrase&ntilde;a" required>
        <button class="btn">Ingresar</button>
    </form>
</div>

</body>
</html>