<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="formulario">
    <h2>Administrador</h2>

    <form action="validar.php" method="POST">

        <input type="text" name="usuario" placeholder="Usuario" required>

        <input type="password" name="password" placeholder="Contraseña" required>

        <button class="btn">Ingresar</button>

    </form>
</div>

</body>
</html>