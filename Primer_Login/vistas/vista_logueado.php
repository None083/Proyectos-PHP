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
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
    <title>Primer Login</title>
</head>
<body>
    <h1>Primer Login</h1>
    <div>
        Bienvenido - <strong><?php $_SESSION["usuario"] ?></strong>
        <form action="index.html" method="post">
            <button type="submit" name="btnCerrarSesion">Cerrar sesión</button>
        </form>

    </div>
</body>
</html>