<?php
if (isset($_POST["btnBorrar"])) {
    try {
        $consulta = "delete from libros where referencia='" . $_POST["btnBorrar"] . "'";
        mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        session_destroy();
        die(error_page("Examen 2", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table, th, tr, td {
            border: 1px solid black;
        }
        table{
            border-collapse: collapse;
        }
    </style>
    <title>Examen 2</title>
</head>

<body>
    <p>
    <form action="index.php" method="post">
        <strong>Bienvenido:</strong> <?php echo $_POST["usuario"] ?>
        <button type="submit">Salir</button>
    </form>
    </p>
    <h2>Listado de los libros</h2>
    <?php
    echo "<table>";
    echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
    while ($tupla = mysqli_fetch_assoc($listado_libros)) {
        echo "<tr>";
        echo "<td>".$tupla["referencia"]."</td>";
        echo "<td>".$tupla["titulo"]."</td>";
        echo "<td><button type='submit' name='btnBorrar' value='".$tupla["referencia"]."'>Borrar</button> - Editar</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>

</html>