<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1</title>
</head>
<body>
<form action="post">
    <h1>Rellena tu CV</h1>

    <p>Nombre</p>
    <input type="text" name="nombre" id="nombre">
    <p>Apellidos</p>
    <input type="text" name="apellidos" id="apellidos">
    <p>Contraseña</p>
    <input type="password" name="pass" id="pass">
    <p>DNI</p>
    <input type="text" name="dni" id="dni">
    <p>Sexo</p>
    <input type="radio" name="sexo" id="mujer"><label for="sexo">Mujer</label>
    <input type="radio" name="sexo" id="hombre"><label for="sexo">Hombre</label>
    <p>Incluir mi foto: </p> <input type="file" name="Seleccionar archivo" id="foto">
    <p>Nacido en: </p> <select name="ciudad" id="ciudad">
        <option value="malaga">Málaga</option>
        <option value="marbella">Marbella</option>
        <option value="estepona">Estepona</option>
    </select>
    <p>Comentarios:</p><textarea name="coment" id="coment"></textarea><br>
    <input type="checkbox" name="suscribir" id="suscribir"><p>Suscribirse al boletín de Novedades</p>
    <input type="submit" value="Guardar Cambios"> <input type="button" value="Borrar los datos introducidos">
</form>
    
</body>
</html>