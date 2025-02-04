const DIR_API1 = "http://localhost/Proyectos/Curso24_25/Teor_SW/API";
const DIR_API2 = "http://localhost/Proyectos/dwese/Tema3/SW/Actividad1/servicios_rest";

$(function () {
    obtener_productos();
});



function obtener_productos() {
    $.ajax({
        url: DIR_API2 + "/productos",
        dataType: "json",
        type: "GET"
    })
        .done(function (data) {
            if (data.error) {
                $("#respuesta").html(data.error);
            } else {
                let html_tabla_productos = "<table>";
                html_tabla_productos += "<tr><th>COD</th><th>Nombre Corto</th><th>PVP (€)</th></tr>";

                $.each(data.productos, function (key, tupla) {
                    html_tabla_productos += "<tr>";
                    html_tabla_productos += `<td><a href="#" class="producto" data-cod="${tupla["cod"]}">${tupla["cod"]}</a></td>`;
                    html_tabla_productos += "<td>" + tupla["nombre_corto"] + "</td>";
                    html_tabla_productos += "<td>" + tupla["PVP"] + " €</td>";
                    html_tabla_productos += "</tr>";
                });

                html_tabla_productos += "</table>";
                $("#respuesta").html(html_tabla_productos);

                $(".producto").on("click", function (e) {
                    e.preventDefault()
                    let cod = $(this).data("cod");
                    obtener_detalles_producto(cod);
                });
            }
        })
        .fail(function (a, b) {
            $("#respuesta").html(error_ajax_jquery(a, b));
        });
}

function obtener_detalles_producto(cod) {
    $.ajax({
        url: DIR_API2 + "/producto/" + cod,
        dataType: "json",
        type: "GET"
    })
        .done(function (data) {
            if (data.error) {
                $("#detalles").html("<p style='color: red;'>" + data.error + "</p>");
            } else {
                let detalles_html = "<h3>Detalles del Producto</h3>";
                detalles_html += `<p><strong>Código:</strong> ${data.producto.cod} </p>`;
                detalles_html += "<p><strong>Nombre:</strong> " + data.producto.nombre_corto + "</p>";
                detalles_html += "<p><strong>Descripción:</strong> " + data.producto.descripcion + "</p>";
                detalles_html += "<p><strong>Precio:</strong> " + data.producto.PVP + " €</p>";
                detalles_html += "<p><strong>Familia:</strong> " + data.producto.familia + "</p>";
                $("#detalles").html(detalles_html);
            }
        })
        .fail(function (a, b) {
            $("#detalles").html(error_ajax_jquery(a, b));
        });
}

function error_ajax_jquery(jqXHR, textStatus) {
    var respuesta;
    if (jqXHR.status === 0) {

        respuesta = 'Not connect: Verify Network.';

    } else if (jqXHR.status == 404) {

        respuesta = 'Requested page not found [404]';

    } else if (jqXHR.status == 500) {

        respuesta = 'Internal Server Error [500].';

    } else if (textStatus === 'parsererror') {

        respuesta = 'Requested JSON parse failed.';

    } else if (textStatus === 'timeout') {

        respuesta = 'Time out error.';

    } else if (textStatus === 'abort') {

        respuesta = 'Ajax request aborted.';

    } else {

        respuesta = 'Uncaught Error: ' + jqXHR.responseText;

    }
    return respuesta;
}

