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
                    html_libros += tupla["titulo"] + " - " + tupla["precio"] + " €";
                    html_libros += "</div>";
                });
                $('.contenedor_libros').html(html_libros);
            }
        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#principal').html("");
            localStorage.clear();
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
                    html_libros += "<td><button class='enlace' onclick='mostrar_detalles(" + tupla["referencia"] + ")';'>" + tupla["titulo"] + "</button></td>";
                    html_libros += "<td><button class='enlace' onclick='borrar_libro("+ tupla["referencia"] +");'>Borrar</button> - <button class='enlace' onclick='return false;'>Editar</button></td>";
                    html_libros += "</tr>";
                });
                $('#libros').html(html_libros);
            }
        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#principal').html("");
            localStorage.clear();
        });
}

function cargar_formulario_agregar() {
    let html_form_agregar = "<h2>Agregar un nuevo Libro owo</h2>";
    html_form_agregar += "<form id='form_agregar' action='#' method='post'>";
    html_form_agregar += "<p><label for='referencia'>Referencia: </label>";
    html_form_agregar += "<input type='text' id='referencia' name='referencia' required></p>";
    html_form_agregar += "<p><label for='titulo'>Título:</label>";
    html_form_agregar += "<input type='text' id='titulo' name='titulo' required></p>";
    html_form_agregar += "<p><label for='autor'>Autor: </label>";
    html_form_agregar += "<input type='text' id='autor' name='autor' required></p>";
    html_form_agregar += "<p><label for='descripcion'>Descripción: </label>";
    html_form_agregar += "<input type='text' id='descripcion' name='descripcion' required></p>";
    html_form_agregar += "<p><label for='precio'>Precio: </label>";
    html_form_agregar += "<input type='number' id='precio' name='precio' required></p>";
    html_form_agregar += "<input type='submit' value='Agregar'>";
    html_form_agregar += "</form>";
    $('#respuestas').html(html_form_agregar);

    // Manejar el envío del formulario
    $('#form_agregar').on('submit', function (event) {
        event.preventDefault(); // Prevenir el envío del formulario por defecto

        const formData = {
            referencia: $('#referencia').val(),
            titulo: $('#titulo').val(),
            autor: $('#autor').val(),
            descripcion: $('#descripcion').val(),
            precio: $('#precio').val()
        };

        $.ajax({
            url: DIR_API + "/crearLibro",
            type: "POST",
            dataType: "json",
            data: formData,
            headers: {
                Authorization: "Bearer " + localStorage.token
            }
        })
            .done(function (data) {
                if (data.error) {
                    $('#errores').html(data.error);
                    $('#principal').html("");
                    localStorage.clear();
                } else {
                    //alert('Libro agregado correctamente');
                    $('#respuestas').html('Libro agregado correctamente :)');
                    $('#form_agregar')[0].reset(); // Limpiar el formulario
                }
            })
            .fail(function (a, b) {
                $('#errores').html(error_ajax_jquery(a, b));
                $('#principal').html("");
            });
    });
}

function mostrar_detalles(referencia) {

    if (((new Date() / 1000) - localStorage.ultm_accion) < MINUTOS * 60) {
        $.ajax({
            url: DIR_API + "/obtenerLibro/" + referencia,
            dataType: "json",
            type: "GET",
            headers: { Authorization: "Bearer " + localStorage.token }
        })
            .done(function (data) {
                if (data.error) {
                    $("#errores").html(data.error);
                    $("#principal").html("");
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
                    localStorage.setItem("ultm_accion", (new Date() / 1000));
                    localStorage.setItem("token", data.token);

                    let html_detalles_libro = "<h2>Detalles del Libro " + referencia + "</h2>";
                    html_detalles_libro += "<p>";
                    html_detalles_libro += "<strong>Título:</strong>" + data.libro["titulo"] + "<br>";
                    html_detalles_libro += "<strong>Autor:</strong>" + data.libro["autor"] + "<br>";
                    html_detalles_libro += "<strong>Descripción:</strong>" + data.libro["descripcion"] + "<br>";
                    html_detalles_libro += "<strong>Precio:</strong>" + data.libro["precio"] + " €<br>";
                    html_detalles_libro += "<img src='images/" + data.libro["portada"] + "' alt='Portada' title='Portada'>";
                    html_detalles_libro += "</p>";
                    html_detalles_libro += "<p><button onclick='cargar_formulario_agregar()'>Volver</button></p>";

                    $("#respuestas").html(html_detalles_libro);

                }

            })
            .fail(function (a, b) {
                $("#errores").html(error_ajax_jquery(a, b));
                $("#principal").html("");
                localStorage.clear();
            });
    }
    else {
        localStorage.clear();
        cargar_vista_login("Su tiempo de sesión ha expirado");
    }

}

function borrar_libro(cod) {
    $.ajax({
        url: DIR_API + "/borrarLibro/" + cod,
        dataType: "json",
        type: "DELETE"
    })
        .done(function (data) {
            if (data.error) {
                $("#errores").html(data.error);
                $("#respuestas").html("");
                $("#productos").html("");
            }
            else {
                $("#respuestas").html("<p class='txt_centrado mensaje'>¡¡ Libro borrado con éxito !!"+ cod +"</p>");
                obtener_productos();
            }
        })
        .fail(function (a, b) {
            $("#errores").html(error_ajax_jquery(a, b));
            $("#respuestas").html("");
            $("#productos").html("");
        });
}