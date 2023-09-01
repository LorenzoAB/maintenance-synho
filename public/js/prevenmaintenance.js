// Función que verifica si todos los campos tienen un valor y habilita/deshabilita el botón según corresponda
function checkInputs() {
    var maquina = $("#pmaquina").val();
    var elementos = $("#pelementos").val();
    var revision = $("#prevision").val();
    var fechaprogramada = $("#pfechaprogramada").val();

    if (maquina && elementos && revision && fechaprogramada) {
        $("#add_detail").removeAttr("disabled");
    } else {
        $("#add_detail").attr("disabled", "disabled");
    }
}

// Evento change para el select y el input de fecha
$("#pmaquina, #pfechaprogramada").change(checkInputs);

// Evento keyup para los inputs de texto
$("#pelementos, #prevision, #pfechaprogramada").keyup(checkInputs);

// Agregar Detalle
$("#add_detail").click(function (e) {
    e.preventDefault();
    agregaCarrito();
    clean_detail();
    //bloquear_campos_pedido();
});

/* FUNCIONES DE LOS VIATICOS */
function agregaCarrito() {
    var maquina = $("#pmaquina").val();
    var elementos = $("#pelementos").val();
    var revision = $("#prevision").val();
    var fechaprogramada = $("#pfechaprogramada").val();

    if (maquina != "" && elementos != "" && revision != "" && fechaprogramada != "") {

        total = total + 1;

        var fila =
            '<tr class="selected" id="fila' +
            cont +
            '">' +
            "<td>" +
            '<input style="text-align: right; type="text" readonly name="maquina[]"  class="form-control" value="' +
            maquina +
            '">' +
            "</td>" +
            "<td>" +
            '<input style="text-align: right;" type="text" readonly name="elementos[]"  class="form-control" value="' +
            elementos +
            '">' +
            "</td>" +
            "<td>" +
            '<input style="text-align: right;" type="text" readonly name="revision[]"  class="form-control" value="' +
            revision +
            '">' +
            "</td>" +            
            "<td>" +
            '<input style="text-align: right;" type="text" readonly name="fechaprogramada[]" class="form-control" value="' +
            fechaprogramada +
            '">' +
            "</td>" +
            "<td>" +
            '<a class="btn btn-danger" type="button" onclick="eliminar(' +
            cont +
            ');"><i class="far fa-trash-alt"></i></a></td>';
        ("</tr>");
        cont++;

        clean_detail();
        //Validación
        $("#detalle_detail").append(fila);
        evaluar();
    } else {
        Swal.fire({
            type: "error",
            title: "Oops...",
            text: "Error al ingresar el detalle del pedido, revise los datos del viatico",
        });
    }
}

function evaluar() {
    if (total > 0) {
        $("#btn_add_detail").show();
    } else {
        $("#btn_add_detail").hide();
    }
}

function eliminar(index) {
    total = total - 1;
    $("#fila" + index).remove();
    evaluar();
}

//limpiar pedido
function clean_detail() {
    $("#pmaquina").val("");
    $("#pelementos").val("");
    $("#prevision").val("");
    $("#pfechaprogramada").val("");
    $("#add_detail").attr("disabled", "disabled");
}


