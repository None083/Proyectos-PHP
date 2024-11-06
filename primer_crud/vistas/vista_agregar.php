
<h2>Agregando un nuevo usuario</h2>
<form action="index.php" method="post">
    <p>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value=""/>
    </p>
    <p>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value=""/>
    </p>  
    <p>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave" value=""/>
    </p>
    <p>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value=""/>
    </p>
    <p>
        <button type="submit" name="btnContAgregar">Continuar</button> 
        <button type="submit">Volver</button>
    </p>
</form>
