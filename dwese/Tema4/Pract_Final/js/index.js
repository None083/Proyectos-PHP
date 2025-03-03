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
                    html_libros += "<td><button class='enlace' onclick='montar_vista_borrar(" + tupla["referencia"] + ");'>Borrar</button> - <button class='enlace' onclick='cargar_formulario_editar(" + tupla["referencia"] + ");'>Editar</button></td>";
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
    let html_form_agregar = "<h2>Agregar un nuevo Libro</h2>";
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
            referencia: $('#referencia').val().trim(),
            titulo: $('#titulo').val().trim(),
            autor: $('#autor').val().trim(),
            descripcion: $('#descripcion').val().trim(),
            precio: $('#precio').val().trim()
        };

        if (!formData.referencia) {
            $('#errores').html("Error: La referencia no puede estar vacía.<br/><button onclick='borrar_errores()'>Aceptar</button>");
            return;
        }

        // Verificar si el libro ya existe antes de enviarlo
        $.ajax({
            url: DIR_API + "/repetido/libros/referencia/" + formData.referencia,
            type: "GET",
            dataType: "json",
            headers: { Authorization: "Bearer " + localStorage.token }
        })
            .done(function (data) {
                if (data.repetido) {
                    $('#errores').html("Error: Ya existe un libro con esta referencia.<br/><button onclick='borrar_errores()'>Aceptar</button>");
                } else {
                    // Si no existe, proceder con la inserción
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
                            } else {
                                cargar_libros_admin();
                                $('#respuestas').html("<p class='mensaje'>¡¡ Libro agregado con éxito !!</p><p><button onclick='cargar_formulario_agregar()'>Aceptar</button></p>");
                                $('#form_agregar')[0].reset(); // Limpiar el formulario
                            }
                        })
                        .fail(function (a, b) {
                            $('#errores').html("Error al agregar el libro: " + error_ajax_jquery(a, b));
                        });
                }
            })
            .fail(function () {
                $('#errores').html("Error al verificar si el libro ya existe.<br/><button onclick='borrar_errores()'>Aceptar</button>");
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

function borrar_respuestas() {
    $("#respuestas").html("");
}

function borrar_errores() {
    $("#errores").html("");
}

function montar_vista_borrar(referencia) {
    if (((new Date() / 1000) - localStorage.ultm_accion) < MINUTOS * 60) {
        localStorage.setItem("ultm_accion", (new Date() / 1000));

        let html_vista_borrar = "<p class='txt_centrado'>Se dispone usted a borrar el libro: <strong>" + referencia + "</strong></p>";
        html_vista_borrar += "<p class='txt_centrado'>¿Estás seguro?</p>";
        html_vista_borrar += "<p class='txt_centrado'><button onclick='borrar_respuestas()'>Cancelar</button> <button onclick='borrar_libro(\"" + referencia + "\")'>Continuar</button></p>";
        $("#respuestas").html(html_vista_borrar);
    }
    else {
        localStorage.clear();
        cargar_vista_login("Su tiempo de sesión ha expirado");
    }
}

function borrar_libro(referencia) {
    if (((new Date() / 1000) - localStorage.ultm_accion) < MINUTOS * 60) {
        localStorage.setItem("ultm_accion", (new Date() / 1000));
        $.ajax({
            url: DIR_API + "/borrarLibro/" + referencia,
            dataType: "json",
            type: "DELETE",
            headers: { Authorization: "Bearer " + localStorage.token }
        })

            .done(function (data) {
                if (data.error) {
                    $("#errores").html(data.error);
                    $("#respuestas").html("");
                    $("#principal").html("");
                }
                else if (data.no_auth) {
                    localStorage.clear();
                    cargar_vista_login("El tiempo de sesión de la API ha expirado.");
                }
                else if (data.mensaje_baneo) {
                    localStorage.clear();
                    cargar_vista_login("Usted ya no se encuentra registrado en la BD");
                }
                else {
                    $("#respuestas").html("<p class='mensaje'>¡¡ Libro borrado con éxito !!</p><p><button onclick='cargar_formulario_agregar()'>Aceptar</button></p>");
                    cargar_libros_admin();
                }
            })
            .fail(function (a, b) {
                $("#errores").html(error_ajax_jquery(a, b));
                $("#respuestas").html("");
                $("#principal").html("");
            });
    }
    else {
        localStorage.clear();
        cargar_vista_login("Su tiempo de sesión ha expirado");
    }
}

function cargar_formulario_editar(referencia) {
    $.ajax({
        url: DIR_API + "/obtenerLibro/" + referencia,
        type: "GET",
        dataType: "json",
        headers: { Authorization: "Bearer " + localStorage.token }
    })
    .done(function (data) {
        if (data.error) {
            $('#errores').html(data.error);
            return;
        }

        let libro = data.libro;
        let html_form_editar = "<h2>Editar Libro</h2>";
        html_form_editar += "<form id='form_editar' action='#' method='post'>";
        html_form_editar += "<p><label for='referencia'>Referencia: </label>";
        html_form_editar += "<input type='text' id='referencia' name='referencia' value='" + libro.referencia + "' readonly required></p>";
        html_form_editar += "<p><label for='titulo'>Título:</label>";
        html_form_editar += "<input type='text' id='titulo' name='titulo' value='" + libro.titulo + "' required></p>";
        html_form_editar += "<p><label for='autor'>Autor: </label>";
        html_form_editar += "<input type='text' id='autor' name='autor' value='" + libro.autor + "' required></p>";
        html_form_editar += "<p><label for='descripcion'>Descripción: </label>";
        html_form_editar += "<input type='text' id='descripcion' name='descripcion' value='" + libro.descripcion + "' required></p>";
        html_form_editar += "<p><label for='precio'>Precio: </label>";
        html_form_editar += "<input type='number' id='precio' name='precio' value='" + libro.precio + "' required></p>";
        html_form_editar += "<input type='submit' value='Actualizar'>";
        html_form_editar += "</form>";
        $('#respuestas').html(html_form_editar);

        // Manejar el envío del formulario
        $('#form_editar').on('submit', function (event) {
            event.preventDefault();

            const formData = {
                referencia: $('#referencia').val().trim(),
                titulo: $('#titulo').val().trim(),
                autor: $('#autor').val().trim(),
                descripcion: $('#descripcion').val().trim(),
                precio: $('#precio').val().trim()
            };

            if (!formData.titulo) {
                $('#errores').html("Error: El título no puede estar vacío.<br/><button onclick='borrar_errores()'>Aceptar</button>");
                return;
            }

            // Verificar si el libro con la misma referencia y un título diferente ya existe
            $.ajax({
                url: `${DIR_API}/repetido/libros/titulo/${formData.titulo}/referencia/${formData.referencia}`,
                type: "GET",
                dataType: "json",
                headers: { Authorization: "Bearer " + localStorage.token }
            })
            .done(function (data) {
                if (data.repetido) {
                    $('#errores').html("Error: Ya existe otro libro con este título.<br/><button onclick='borrar_errores()'>Aceptar</button>");
                } else {
                    // Si no hay repetición, actualizar el libro
                    $.ajax({
                        url: `${DIR_API}/actualizarLibro/${formData.referencia}`,
                        type: "PUT",
                        dataType: "json",
                        data: formData,
                        headers: { Authorization: "Bearer " + localStorage.token }
                    })
                    .done(function (data) {
                        if (data.error) {
                            $('#errores').html(data.error);
                        } else {
                            cargar_libros_admin();
                            $('#respuestas').html("<p class='mensaje'>¡¡ Libro editado con éxito !!</p><p><button onclick='cargar_formulario_agregar()'>Aceptar</button></p>");
                        }
                    })
                    .fail(function (a, b) {
                        $('#errores').html("Error al actualizar el libro: " + error_ajax_jquery(a, b));
                    });
                }
            })
            .fail(function () {
                $('#errores').html("Error al verificar si el título ya existe.<br/><button onclick='borrar_errores()'>Aceptar</button>");
            });
        });
    })
    .fail(function (a, b) {
        $('#errores').html(error_ajax_jquery(a, b));
    });
}
