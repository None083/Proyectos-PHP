<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6 POO</title>
</head>
<body>
    <h1>Ejercicio 6 POO</h1>
    <?php
    require "class_menu.php";
    $m = new Menu();
    $m->cargar("loquesea", "Lais");
    $m->cargar("loquesea", "Zara");
    $m->cargar("loquesea", "Sony");
    $m->vertical();
    $m->horizontal();
    ?>
</body>
</html>