function cargar_libros_normal() {
    $.ajax({
        url: DIR_API + "/obtenerLibros",
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            if (data.error) {
                $('#errores').html(data.error);
                $('#principal').html("");
                localStorage.clear();
            }
            else {
                let html_libros = "";
                $.each(data.libros, function (key, tupla) {
                    html_libros += "<div>";
                    html_libros += "<img src='images/" + tupla["portada"] + "' alt='Portada' title='Portada'><br>";
                    html_libros += tupla["titulo"] + " - " + tupla["precio"] + "€";
                    html_libros += "</div>";
                });
                html_libros += "</div>";
                $('.contenedor_libros').html(html_libros);
            }
        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#principal').html("");
        });
}

function cargar_libros_admin() {
    $.ajax({
        url: DIR_API + "/obtenerLibros",
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            if (data.error) {
                $('#errores').html(data.error);
                $('#principal').html("");
                localStorage.clear();
            }
            else {
                let html_libros = "<table class='centrado txt_centrado'>";
                html_libros += "<tr><th>Referencia</th><th>Título</th><th>Acción</th></tr>";
                $.each(data.libros, function (key, tupla) {
                    html_libros += "<tr>";
                    html_libros += "<td>" + tupla["referencia"] + "</td>";
                    html_libros += "<td><button class='enlace' onClick='mostrar_detalles(" + tupla["referencia"] + ")'>" + tupla["titulo"] + "</button></td>";
                    html_libros += "<td><button class='enlace' onClick='return false;'>Borrar</button> - <button class='enlace' onClick='return false;'>Editar</button></td>";
                    html_libros += "</tr>";
                });
                html_libros += "</table>";
                $('#libros').html(html_libros);

            }
        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#principal').html("");
        });
}

function mostrar_detalles(referencia) {
    if (((new Date() / 1000) - localStorage.ultm_accion) < MINUTOS * 60) {
        $.ajax({
            url: DIR_API + "/obtenerLibro/" + referencia,
            type: "GET",
            dataType: "json",
            headers: { Authorization: "Bearer " + localStorage.token }
        })
            .done(function (data) {
                if (data.error) {
                    $('#errores').html(data.error);
                    $('#principal').html("");
                }
                else if (data.no_auth) {
                    localStorage.clear();
                    cargar_vista_login("El tiempo de sesión de la API ha expirado.");
                }
                else if (data.mensaje_baneo) {
                    localStorage.clear();
                    cargar_vista_login("Usted ya no se encuentra registrado en la BD.");
                }
                else {
                    localStorage.setItem("ultm_accion", new Date() / 1000);
                    localStorage.setItem("token", data.token);
                    let html_detalles_libro = "<h2>Detalles del libro" + referencia + "</h2>";
                    html_detalles_libro += "<p>";
                    html_detalles_libro += "<strong>Referencia:</strong> " + data.libro["referencia"] + "<br>";
                    html_detalles_libro += "<strong>Título:</strong> " + data.libro["titulo"] + "<br>";
                    html_detalles_libro += "<strong>Autor:</strong> " + data.libro["autor"] + "<br>";
                    html_detalles_libro += "<strong>Descripción:</strong> " + data.libro["descripcion"] + "<br>";
                    html_detalles_libro += "<strong>Precio:</strong> " + data.libro["precio"] + "€<br>";
                    html_detalles_libro += "<img src='images/" + data.libro["portada"] + "' alt='Portada' title='Portada'><br>";
                    html_detalles_libro += "</p>";
                    html_detalles_libro += "<p><button onClick='cargar_formulario_agregar()'>Volver</button></p>";
                    $("respuestas").html(html_detalles_libro);
                }
            })
            .fail(function (a, b) {
                $('#errores').html(error_ajax_jquery(a, b));
                $('#principal').html("");
            });
    } else {
        localStorage.clear();
        cargar_vista_login("Su tiempo e sesión ha cadicado");
    }
}


function cargar_formulario_agregar() {
    let html_form_agregar = "<h2>Agregar un nuevo libro</h2>";
    $.ajax({
        url: DIR_API + "/crearLibro",
        type: "POST",
        dataType: "json"
    })
        .done(function (data) {
            if (data.error) {
                $('#errores').html(data.error);
                $('#principal').html("");
                localStorage.clear();
            }
            else {
                html_form_agregar += "<form id='form_agregar' action='#' method='post'>";
                html_form_agregar += "<label for='referencia'>Referencia: </label>";
                html_form_agregar += "<input type='text' id='referencia' name='referencia' required><br>";
                html_form_agregar += "<label for='titulo'>Título:</label>";
                html_form_agregar += "<input type='text' id='titulo' name='titulo' required><br>";
                html_form_agregar += "<label for='autor'>Autor: </label>";
                html_form_agregar += "<input type='text' id='autor' name='autor' required><br>";
                html_form_agregar += "<label for='descripcion'>Descripción: </label>";
                html_form_agregar += "<input type='text' id='descripcion' name='descripcion' required><br>";
                html_form_agregar += "<label for='precio'>Precio: </label>";
                html_form_agregar += "<input type='number' id='precio' name='precio' required><br>";
                html_form_agregar += "<input type='submit' value='Agregar'>";
                html_form_agregar += "</form>";
                $('#respuestas').html(html_form_agregar);
            }
        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#principal').html("");
        });

}