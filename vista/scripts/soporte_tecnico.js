var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000
});

const OrigenSoporte = 15;
var tablaDetalles;
var tablaRequerimientos;
var tablaDetallesRequerimientos;
function init() {
    $("#lista-requerimientos").hide();
    $("#div-anadir").hide();
    listar_centro_utilidad();
    llenar_tabla_requerimientos();
    listar_sub_catalogo_soporte();
    $("#agregar_requerimiento_detalle").prop("disabled", true);
    Lista_Det_Requerimiento();
}


/*****login */
$("#btnlogin").on('click', function (e) {
    let dni = $("#dni").val();
    let telefono = $("#celular").val();

    if (dni == "") {
        Toast.fire({
            icon: 'info',
            title: 'Debe ingresar Número de DNI'
        });
        return false;
    }
    if (telefono == "") {
        Toast.fire({
            icon: 'info',
            title: 'Debe ingresar Número de Celular'
        });
        return false;
    }

    $.ajax({
        url: "../ajax/soporte_tecnico.php?op=login_soporte",
        type: "POST",
        data: { "dni": dni, "celular": telefono },
        dataType: "json",
        success: function (data) {
            //  console.log(data)
            Toast.fire({
                icon: data.ico,
                title: data.msg
            });
            location.href = "portal.php";
        }
    });
})

/***** */
function mostrarform(flag) {

    if (flag) {
        $("#div-anadir").show();
        $("#div-requerimientos").hide();
        $('#agregar_requerimiento').prop('disabled', false);
        $('#agregar_requerimiento_detalle').prop('disabled', true);
        $('#centro_utilidad').prop("disabled", false);
        $('#centro_costo').prop("disabled", false);
        $('#sede').prop("disabled", false);

        llenar_tabla_detalles();
    }
    else {
        $("#div-anadir").show();
        $("#div-requerimientos").hide();
        $('#agregar_requerimiento').prop('disabled', true);
        $('#agregar_requerimiento_detalle').prop('disabled', true);

    }
}

function cancelarform() {
    eliminar_requerimientos_vacios();
    $("#div-anadir").hide();
    $("#div-requerimientos").show();
    $("#id_requerimiento").val("0");
    llenar_tabla_requerimientos();
    Lista_Det_Requerimiento();
    limpiar_detalles();
    limpiar_cabecera();
    llenar_tabla_detalles();

}

function limpiar_cabecera() {
    $("#centro_utilidad").val('0');
    $("#centro_costo").val('0');
    $("#sede").val('0');

    $("#centro_utilidad").selectpicker('refresh');
    $("#centro_costo").selectpicker('refresh');
    $("#sede").selectpicker('refresh');

    $("#id_requerimiento").val('0');
}

function limpiar_detalles() {
    $("#categoria").val('0');
    $("#categoria").selectpicker('refresh');
    $("#detalle_requerimiento").val('');
    $("#plazo").val('');
    $("#subir_archivo").val('');
    $("#tb_archivos").html("");
    document.querySelector('#div_tabla_archivos').style.display = "none";
}
function listar_centro_utilidad() {

    $.ajax({
        url: "../ajax/soporte_tecnico.php?op=centro_utilidad_listar",
        type: "POST",
        data: {},
        dataType: "json",
        success: function (data) {
            console.log(data)
            $('#centro_utilidad').html(data.html);
            $('#centro_utilidad').selectpicker('refresh');
        }
    });
}

function listar_centro_costo() {

    $.ajax({
        url: "../ajax/soporte_tecnico.php?op=centro_costo_listar",
        type: "POST",
        data: { id_centro_utilidad: $('#centro_utilidad').val() },
        dataType: "json",
        success: function (data) {
            console.log(data)
            $('#centro_costo').html(data.html);
            $('#centro_costo').selectpicker('refresh');
        }
    });
}

function listar_sede() {

    $.ajax({
        url: "../ajax/soporte_tecnico.php?op=sede_listar",
        type: "POST",
        data: { id_centro_costo: $('#centro_costo').val() },
        dataType: "json",
        success: function (data) {
            console.log(data)
            $('#sede').html(data.html);
            $('#sede').selectpicker('refresh');
        }
    });
}

function listar_catalogo_soporte() {

    $.ajax({
        url: "../ajax/soporte_tecnico.php?op=catalogo_soporte_listar",
        type: "POST",
        data: {},
        dataType: "json",
        success: function (data) {
            console.log(data)
            $('#tipo_servicio').html(data.html);
            $('#tipo_servicio').selectpicker('refresh');

        }
    });
}

function listar_sub_catalogo_soporte() {

    $.ajax({
        url: "../ajax/soporte_tecnico.php?op=sub_catalogo_soporte_listar",
        type: "POST",
        data: {},
        dataType: "json",
        success: function (data) {
            console.log(data)
            $('#categoria').html(data.html);
            $('#categoria').selectpicker('refresh');
            $('#fservicio').html(data.html);
            $('#fservicio').selectpicker('refresh');
        }
    });
}

function obtener_asignado() {
    $.ajax({
        url: "../ajax/soporte_tecnico.php?op=obtener_asignado",
        type: "POST",
        data: {},
        dataType: "json",
        success: function (data) {
            console.log(data)
            $('#ultimo_asignado').val(data.detalles.id_persona);
            $('#nombre_ultimo_asignado').val(data.detalles.nombre);
        }
    });
}
/***************anadir requerimiento */
$("#agregar_requerimiento").on('click', function (e) {
    let centro_utilidad = $("#centro_utilidad").val();
    let centro_costo = $("#centro_costo").val();
    let sede = $("#sede").val();
    //let id_requerimiento = $("#id_requerimiento").val();

    if (centro_utilidad < 1) {
        Toast.fire({
            icon: 'info',
            title: 'Debe seleccionar Centro de Utilidad'
        });
        return false;
    }
    if (centro_costo < 1) {
        Toast.fire({
            icon: 'info',
            title: 'Debe seleccionar Centro de Costo'
        });
        return false;
    }
    if (sede < 1) {
        Toast.fire({
            icon: 'info',
            title: 'Debe seleccionar una Sede'
        });
        return false;
    }

    $.ajax({
        url: "../ajax/soporte_tecnico.php?op=insertar_requerimiento",
        type: "POST",
        data: {
            "centro_utilidad": centro_utilidad,
            "centro_costo": centro_costo,
            "sede": sede
            // "id_requerimiento":id_requerimiento
        },
        dataType: "json",
        success: function (data) {
            if (data.status) {
                $("#agregar_requerimiento_detalle").prop("disabled", false);
                $("#id_requerimiento").val(data.idRetorno);
                //   $("#centro_utilidad").prop("disabled", true);
                //  $("#centro_costo").prop("disabled", true);
                // $("#sede").prop("disabled", true);
                $("#agregar_requerimiento").prop("disabled", true);
                limpiar_detalles();
                llenar_tabla_detalles();
                obtener_asignado();
            }
            console.log(data)
            Toast.fire({
                icon: data.ico,
                title: data.msg
            });

        }
    });


})

function subir_archivos() {

    var formData = new FormData($('#frm_req_logistico_det')[0]);
    var rowCount = $("#tb_archivos tr").length;
    var ext = $("#subir_archivo").val().split('.').pop();
    formData.append("ConteoList", rowCount);

    if (ext == "pdf" || ext == "xls" || ext == "xlsx" || ext == "csv" || ext == "docx") {

        $.ajax({
            url: "../ajax/soporte_tecnico.php?op=subir_archivo",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {

                if (data.errorproceso === "ok") {

                    if (rowCount >= 10) {
                        Toast.fire({
                            icon: "error",
                            title: "Excedio la cantidad de archivos permitidos"
                        });
                    } else if (rowCount == 0) {
                        $("#tb_archivos").html(data.htmlreturn);
                        Toast.fire({
                            icon: "success",
                            title: "Se agrego el archivo al requerimiento"
                        });
                    } else {
                        $("#tb_archivos").append(data.htmlreturn);
                        Toast.fire({
                            icon: "success",
                            title: "Se agrego el archivo al requerimiento"
                        });
                    }
                    $("#subir_archivo").val("");
                    rowCount = $("#tb_archivos tr").length;

                    if (rowCount == 0) {
                        document.querySelector('#div_tabla_archivos').style.display = "none";
                    } else {
                        document.querySelector('#div_tabla_archivos').style.display = "flex";
                    }

                } else {
                    rowCount = $("#tb_archivos tr").length;

                    if (data.errorproceso == "error") {
                        Toast.fire({
                            icon: "error",
                            title: "archivo no subido / archivo dañado"
                        });

                    } else if (data.errorproceso == "excedido") {
                        Toast.fire({
                            icon: "error",
                            title: "archivo excedio el tamaño limite permitido"
                        });

                    }

                    if (rowCount == 0) {
                        document.querySelector('#div_tabla_archivos').style.display = "none";
                    } else {
                        document.querySelector('#div_tabla_archivos').style.display = "flex";
                    }
                }
            }

        });

    } else {
        Toast.fire({
            icon: "error",
            title: "Cargue un archivo con formato PDF* / EXCEL* / WORD*"
        });
    }

}

function eliminar_archivo(item) {

    var itemListado = $("#List_Archivo_" + item).text();
    var itemListado = $("#List_Archivo_" + item).remove();

    var rowCount = $("#tb_archivos tr").length;

    if (rowCount == 0) {
        document.querySelector('#div_tabla_archivos').style.display = "none";
    } else {
        document.querySelector('#div_tabla_archivos').style.display = "flex";
    }

}


function insertar_detalle_requerimiento() {
    if ($('#categoria').val() < 1) {
        Toast.fire({
            icon: 'info',
            title: 'Debe seleccionar Categoria'
        });
        return false;
    }
    if ($('#detalle_requerimiento').val() == "") {
        Toast.fire({
            icon: 'info',
            title: 'Debe rellenar el detalle del requerimiento'
        });
        return false;
    }
    if ($('#plazo').val() == "") {
        Toast.fire({
            icon: 'info',
            title: 'Debe seleccionar una fecha de plazo'
        });
        return false;
    }


    var formData = new FormData($("#frm_req_logistico_det")[0]);
    formData.append("asignado", $('#ultimo_asignado').val());
    $.ajax({
        url: "../ajax/soporte_tecnico.php?op=insertar_requerimiento_detalles",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (datos) {
            console.log(datos)
            Toast.fire({
                icon: datos.ico,
                title: datos.msg
            });
            $('#agregar_requerimiento').prop('disabled', false);
            llenar_tabla_detalles();
            limpiar_detalles();
            $('#ModalAgregarDetalles').hide();
            $('.modal-backdrop').remove();
        }
    });
}

function llenar_tabla_detalles() {
    var id_requerimiento = $("#id_requerimiento").val();

    tablaDetalles = $('#tabla_detalles').dataTable(
        {
            "responsive": true,
            "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [
            ],
            "ajax":
            {
                url: '../ajax/soporte_tecnico.php?op=listar_tabla_detalles&id=' + id_requerimiento,
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "language": {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "loadingRecords": "Cargando...",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }, "buttons": {
                    "copyTitle": "Tabla Copiada",
                    "copySuccess": {
                        _: '%d líneas copiadas',
                        1: '1 línea copiada'
                    }
                }
            },
            Response: true,
            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();

}


function llenar_tabla_requerimientos() {

    let fdesde = $('#fdesde').val();
    let fhasta = $('#fhasta').val();
    let fservicio = $('#fservicio').val() == null ? "" : $('#fservicio').val().toString();
    let festado = $('#festado').val();


    tablaRequerimientos = $('#tabla_requerimientos').dataTable(
        {
            "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Excel', // Texto personalizado para el botón de exportación a Excel
                    titleAttr: 'Excel', // Texto que se muestra al pasar el ratón sobre el botón
                    filename: function () {
                        // Función para personalizar el nombre del archivo de exportación
                        return `Reporte Requerimineto Logistio ${new Date().toLocaleDateString('es-ES')}`;
                    },
                    exportOptions: {
                        columns: [2, 3, 4, 5], // Columnas específicas para la exportación                   
                    },
                },
            ],
            "ajax":
            {
                url: '../ajax/soporte_tecnico.php?op=listar_requerimientos&id=' + OrigenSoporte,
                type: "get",
                data: { "fdesde": fdesde, "fhasta": fhasta, "fservicio": fservicio, "festado": festado },
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "language": {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "loadingRecords": "Cargando...",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }, "buttons": {
                    "copyTitle": "Tabla Copiada",
                    "copySuccess": {
                        _: '%d líneas copiadas',
                        1: '1 línea copiada'
                    }
                }
            },
            "autoWidth": false,
            "responsive": true,
            "scrollX": true,
            columns: [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: '0'
                },
                { data: '1', orderable: false },
                { data: '2' },
                { data: '3' },
                { data: '4' },
                { data: '5' },
                { data: '6' },
                { data: '7', className: 'd-none' }
            ],
            initComplete: function (setting, json) {
                $('#tabla_requerimientos tbody').on('click', 'td.dt-control', function (event) {
                    var tr = $(this).closest('tr');
                    var row = tablaRequerimientos.row(tr);
                    var id = row.data()[7];
                    //   console.log('CLICK')
                    if (row.child.isShown()) {
                        row.child.hide();
                    } else {
                        $.ajax({
                            url: "../ajax/soporte_tecnico.php?op=listar_detalle_por_requerimiento",
                            type: "POST",
                            data: { id: id },
                            dataType: "json",
                            success: function (data) {
                                console.log(data);
                                var datos = data.data;
                                var html = "";
                                html = '<table class="col-12"><thead class="bg-info text-white"><th>Id</th><th>Servicio</th><th>Categoria</th><th>Detalle</th><th>Plazo</th><th>Estado</th><th>Acciones</th></thead>';
                                datos.forEach(function (element) {
                                    //  var opciones = (element.opciones!=0)?element.opciones:"";
                                    html += '<tr><td>' + element.id_detalle_requerimiento + '</td>' +
                                        ' <td>' + element.nombre_catalogo + '</td>' +
                                        ' <td>' + element.nombre_subcatalogo + '</td>' +
                                        ' <td>' + element.detalle_rq + '</td>' +
                                        ' <td>' + element.fecha_plazo + '</td>' +
                                        `<td><span class="badge badge-${element.estado == 4 ? 'danger' : 'warning'}">${element.estadoDesc}</span></td>` +
                                        ' <td>' + element.opciones + '</td>' +
                                        '</tr>';
                                });
                                html += '</table>';
                                row.child(html).show();
                            },
                            error: function (error) {
                                console.error('Error en la solicitud AJAX:', error);
                            }
                        });
                    }
                    event.stopImmediatePropagation();
                });
            },
            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
    // $('#tabla_requerimientos').off('click', 'td.dt-control');
}

function Lista_Det_Requerimiento() {
    let fdesde = $('#fdesde').val();
    let fhasta = $('#fhasta').val();
    let fservicio = $('#fservicio').val() == null ? "" : $('#fservicio').val().toString();
    let festado = $('#festado').val();

    tablaDetallesRequerimientos = $('#tabla_det_requerimientos').dataTable({

        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla

        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Excel', // Texto personalizado para el botón de exportación a Excel
                titleAttr: 'Excel', // Texto que se muestra al pasar el ratón sobre el botón
                filename: function () {
                    // Función para personalizar el nombre del archivo de exportación
                    return `Reporte Requerimineto Logistio ${new Date().toLocaleDateString('es-ES')}`;
                },
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9], // Columnas específicas para la exportación                   
                },
            },

        ],

        "responsive": true,
        //   scrollX: true,

        //"autoWidth": true,
        "columns": [
            { data: '0', name: 'opt', className: "text-center" },
            { data: '1', name: 'opt', className: "text-center" },
            { data: '2', name: 'opt', className: "text-center" },
            { data: '3', name: 'opt', className: "text-center" },
            // { data: '4', name: 'opt', className: "text-center" },
            { data: '5', name: 'opt', className: "text-center" },
            // { data: '6', name: 'opt', className: "text-center" },
            // { data: '7', name: 'opt', className: "text-center" },
            // { data: '8', name: 'opt', className: "text-right" },
            // { data: '9', name: 'opt', className: "text-center" },
            // { data: '10', name: 'opt', className: "text-center" },
            // { data: '11', name: 'opt', className: "text-right" },
            { data: '12', name: 'opt', className: "text-right" },
            { data: '13', name: 'opt', className: "text-right" },
            { data: '14', name: 'opt', className: "text-right" },
            // { data: '15', name: 'opt', className: "text-right" },
            { data: '16', name: 'opt', className: "text-center" },
            // { data: '17', name: 'opt', className: "text-center" },
            { data: '18', name: 'opt', className: "text-center" },
            { data: '19', name: 'opt', className: "text-center" },
            //{ data: '20', name: 'opt', className: "text-center" },
        ],
        "ajax":
        {
            url: '../ajax/soporte_tecnico.php?op=listar_detalles_requerimientos&id=' + OrigenSoporte,
            data: {
                "fdesde": fdesde,
                "fhasta": fhasta,
                "fservicio": fservicio,
                "festado": festado,
            },
            type: "get",
            dataType: "json",

            error: function (e) {
                console.log(e.responseText);
            }
        },
        "language": {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "loadingRecords": "Cargando...",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }, "buttons": {
                "copyTitle": "Tabla Copiada",
                "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,//Paginación
        "order": [[0, "desc"]]//Ordenar (columna,orden)
    }).DataTable();
    //   tablaDetallesRequerimientos.column(17).visible(false);
    // alternar(false);
}

var radioButtons = document.querySelectorAll('input[type="radio"][name="switch-one"]');
// Agregar un controlador de eventos para cada elemento de radio
radioButtons.forEach(function (radioButton) {
    radioButton.addEventListener('change', function () {

        // Verificar cuál de los elementos de radio está marcado
        if (radioButton.value == 1) {
            //console.log('1');

            $(`#lista-requerimientos`).show();
            $(`#lista-detalles`).hide();

            llenar_tabla_requerimientos();
        } else {

            $(`#lista-requerimientos`).hide();
            $(`#lista-detalles`).show();
            Lista_Det_Requerimiento();
        }

    });
});

function buscarFiltros() {

    if ($(`#radio-one`).prop('checked')) {
        llenar_tabla_requerimientos();
    } else if ($(`#radio-two`).prop('checked')) {
        Lista_Det_Requerimiento();
    }

}

function abrirModalAnular(idrequerimiento, idrequerimientodetalle) {

    $('#IdRequerimientoAnular').val(idrequerimiento);
    $('#IdRequerimientoDetalleAnular').val(idrequerimientodetalle);
    $('#motivoanulacion').val('');

}

function anular_requerimiento() {
    var id_requerimiento = $('#IdRequerimientoAnular').val();
    var id_detalle_requerimiento = $('#IdRequerimientoDetalleAnular').val();
    var comentario = $('#motivoanulacion').val();
    if (comentario == '') {
        Toast.fire({
            icon: 'info',
            title: 'Debe ingresar motivo de anulación'
        });
        return false;
    }
    swal.fire({
        title: '¿Está seguro de anular el Requerimiento?',
        icon: 'warning',
        showConfirmButton: true,
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../ajax/soporte_tecnico.php?op=anular_requerimiento",
                type: "POST",
                data: { id_requerimiento: id_requerimiento, id_detalle_requerimiento: id_detalle_requerimiento, comentario: comentario },
                dataType: "json",
                success: function (data) {
                    Toast.fire({
                        icon: data.ico,
                        title: data.msg
                    });
                    $('#ModalAnular').modal('hide');
                    if (document.querySelector("#lista-requerimientos").style.display == "none") {
                        Lista_Det_Requerimiento();
                    } else {
                        llenar_tabla_requerimientos();
                    }
                }
            });
        }
    });
}

function mostrar(iddetalle) {

    mostrarform();
    $("#id_requerimiento").val(iddetalle);
    llenar_tabla_detalles();

    var datos;
    $.ajax({
        url: "../ajax/soporte_tecnico.php?op=mostrar_requerimiento",
        type: "POST",
        data: { "id_requerimiento": iddetalle },
        dataType: "json",
        success: function (data) {
            console.log(data)
            datos = data.data;
            $('#centro_utilidad').val(datos.id_centro_utilidad);
            $('#centro_utilidad').selectpicker('refresh');

            $.ajax({
                url: "../ajax/soporte_tecnico.php?op=centro_costo_listar",
                type: "POST",
                data: { id_centro_utilidad: datos.id_centro_utilidad },
                dataType: "json",
                success: function (data) {
                    $("#sede").html('<option value="-1" disabled selected>Seleccione una Sede</option>');
                    $("#centro_costo").html(data.html);
                    $('#centro_costo').val(datos.id_centro_costo);
                    $("#centro_costo").selectpicker('refresh');
                    $.ajax({
                        url: "../ajax/soporte_tecnico.php?op=sede_listar",
                        type: "POST",
                        data: { id_centro_costo: datos.id_centro_costo },
                        dataType: "json",
                        success: function (data) {
                            $("#sede").html(data.html);
                            $('#sede').val(datos.id_sede);
                            $("#sede").selectpicker('refresh');
                            $('.btn-det').prop("disabled", true);
                        }
                    });
                }
            });
        }
    });

}


function activar(iddetalle) {
    //Función para activar registros

    swal.fire({
        title: '¿Está Seguro de Activar el detalle?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../ajax/soporte_tecnico.php?op=activar", { id_detalle_requerimiento: iddetalle }, function (data) {
                data = JSON.parse(data);

                Toast.fire({
                    icon: data.ico,
                    title: data.msg
                });
                tablaDetalles.ajax.reload();
            });
        }
    })
}

function desactivar(iddetalle) {
    swal.fire({
        title: '¿Está Seguro de Desactivar el detalle?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../ajax/soporte_tecnico.php?op=desactivar",
                type: "POST",
                data: { id_detalle_requerimiento: iddetalle },
                dataType: "json",
                success: function (data) {
                    Toast.fire({
                        icon: data.ico,
                        title: data.msg
                    });
                    tablaDetalles.ajax.reload();
                }
            });

        }
    })
}

function eliminar_requerimientos_vacios() {

    let id_requerimiento = $('#id_requerimiento').val();

    $.ajax({
        url: "../ajax/soporte_tecnico.php?op=eliminar_requerimientos_vacios",
        type: "POST",
        data: { id_requerimiento: id_requerimiento },
        dataType: "json",
        success: function (data) {
            console.log(data)
        }
    });
}
init()