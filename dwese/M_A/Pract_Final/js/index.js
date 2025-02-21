function cargar_libros_normal()
{
    $.ajax({
        url:DIR_API+"/obtenerLibros",
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        if(data.error)
        {
            $('#errores').html(data.error);
            $('#principal').html("");
            localStorage.clear();
        }
        else
        {
            let html_libros="";
            $.each(data.libros,function(key,tupla){
                html_libros+="<div>";
                html_libros+="<img src='images/"+tupla["portada"]+"' alt='Portada' title='Portada'><br>";
                html_libros+=tupla["titulo"]+" - "+tupla["precio"]+" €";
                html_libros+="</div>";
            });
            $('.contenedor_libros').html(html_libros);
        }
    })
    .fail(function(a,b){
        $('#errores').html(error_ajax_jquery(a,b));
        $('#principal').html("");
        localStorage.clear();
    });
}

function cargar_libros_admin()
{
    $.ajax({
        url:DIR_API+"/obtenerLibros",
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        if(data.error)
        {
            $('#errores').html(data.error);
            $('#principal').html("");
            localStorage.clear();
        }
        else
        {
            let html_libros="<table class='centrado txt_centrado'>";
            html_libros+="<tr><th>Referencia</th><th>Título</th><th>Acción</th></tr>";
            $.each(data.libros,function(key,tupla){
                html_libros+="<tr>";
                html_libros+="<td>"+tupla["referencia"]+"</td>";
                html_libros+="<td><button class='enlace' onclick='mostrar_detalles("+tupla["referencia"]+")';'>"+tupla["titulo"]+"</button></td>";
                html_libros+="<td><button class='enlace' onclick='return false;'>Borrar</button> - <button class='enlace' onclick='return false;'>Editar</button></td>";
                html_libros+="</tr>";
            });
            $('#libros').html(html_libros);
        }
    })
    .fail(function(a,b){
        $('#errores').html(error_ajax_jquery(a,b));
        $('#principal').html("");
        localStorage.clear();
    });
}

function cargar_formulario_agregar()
{
    let html_form_agregar="<h2>Agregar un nuevo Libro</h2>";
    $('#respuestas').html(html_form_agregar);
}

function mostrar_detalles(referencia)
{
    
    if(((new Date()/1000)-localStorage.ultm_accion)<MINUTOS*60)
    {
        $.ajax({
            url:DIR_API+"/obtenerLibro/"+referencia,
            dataType:"json",
            type:"GET",
            headers:{Authorization:"Bearer "+localStorage.token}
        })
        .done(function(data){
            if(data.error)
            {
                $("#errores").html(data.error);
                $("#principal").html("");
            }
            else if(data.no_auth)
            {
                localStorage.clear();
                cargar_vista_login("El tiempo de sesión de la API ha expirado.");
            }
            else if(data.mensaje_baneo)
            {
                localStorage.clear();
                cargar_vista_login("Usted ya no se encuentra registrado en la BD.");
            }
            else
            {
                localStorage.setItem("ultm_accion",(new Date()/1000));
                localStorage.setItem("token",data.token);

                let html_detalles_libro="<h2>Detalles del Libro "+referencia+"</h2>";
                html_detalles_libro+="<p>";
                html_detalles_libro+="<strong>Título:</strong>"+data.libro["titulo"]+"<br>";
                html_detalles_libro+="<strong>Autor:</strong>"+data.libro["autor"]+"<br>";
                html_detalles_libro+="<strong>Descripción:</strong>"+data.libro["descripcion"]+"<br>";
                html_detalles_libro+="<strong>Precio:</strong>"+data.libro["precio"]+" €<br>";
                html_detalles_libro+="<img src='images/"+data.libro["portada"]+"' alt='Portada' title='Portada'>";
                html_detalles_libro+="</p>";
                html_detalles_libro+="<p><button onclick='cargar_formulario_agregar()'>Volver</button></p>";

                $("#respuestas").html(html_detalles_libro);

            }
          
        })
        .fail(function(a,b){
            $("#errores").html(error_ajax_jquery(a,b)); 
            $("#principal").html("");
            localStorage.clear();
        });
    }
    else
    {
        localStorage.clear();
        cargar_vista_login("Su tiempo de sesión ha expirado");
    }

}