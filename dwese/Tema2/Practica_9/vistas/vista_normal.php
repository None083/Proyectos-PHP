<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .enLinea{
            display:inline
        }
        .enlace{
            background: none;
            border:none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
        .mensaje{
            color: blue;
            font-size: 1.25em;
        }
        
    </style>
    <title>Practica 9</title>
</head>
<body>
    <h1>Practica 9</h1>
    <div>
        Bienvenido - <strong><?php echo $datos_usuario_log["usuario"]; ?></strong>
        <form action="index.php" class="enlinea" method="post">
            <button type="submit" class="enlace" name="btnCerrarSesion">Cerrar sesión</button>
        </form>
    </div>
    <?php
    if (isset($_SESSION["mensaje_registro"])) {
        echo "<p class='mensaje'>".$_SESSION["mensaje_registro"]."</p>";
        unset($_SESSION["mensaje_registro"]);
    }
    ?>
</body>
</html>