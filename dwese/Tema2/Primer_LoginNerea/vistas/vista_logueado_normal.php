<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <style>
        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Primer login - Vista Normal</h1>

    <form action="index.php" method="post">
        <p>
            Bienvenido <strong> <?php echo $datos_usuario_logueado["nombre"]  ?></strong> -
            <button type="submit" name="btnSalir" class="enlace">Salir</button>
        </p>
    </form>
</body>

</html>