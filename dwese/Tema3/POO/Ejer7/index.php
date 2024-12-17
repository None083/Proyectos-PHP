<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7 POO</title>
</head>

<body>
    <h1>Ejercicio 7 POO</h1>
    <?php
    require 'class_pelicula.php';
    $pelicula = new Pelicula("El Padrino", 1972, "Francis Ford Coppola", true, 20.5, "2024-06-10");
    echo '<h1>Gestión de Alquiler de Películas</h1>';
    echo '<p><strong>Título: </strong>' . $pelicula->getNombre() . '</p>';
    echo '<p><strong>Año: </strong>' . $pelicula->getAnio() . '</p>';
    echo '<p><strong>Director: </strong>' . $pelicula->getDirector() . '</p>';
    echo '<p><strong>Precio: </strong>' . $pelicula->getPrecio() . '€</p>';

    if ($pelicula->getAlquilada()) {
        echo '<p><strong>Estado: </strong>Alquilada</p>';
    } else {
        echo '<p><strong>Estado: </strong>Disponible</p>';
    }

    echo '<p><strong>Fecha Prevista de Devolución: </strong>' . $pelicula->getFechaPrevDev() . '</p>';
    echo '<p><strong>Recargo Actual: </strong>' . $pelicula->calcularRecargo() . '€</p>';

    ?>
</body>

</html>