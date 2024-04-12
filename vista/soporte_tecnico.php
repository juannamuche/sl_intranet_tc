<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["persona_id"])) {
    header("Location: login.php");
} else {
    $fecha_actual = date('Y-m-d');
    $fecha_actual_dia_menos = date('Y-m-d', strtotime($fecha_actual . '- 1 days'));

?>

    <!doctype html>
    <html class="no-js" lang="">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Task-Control - Salus Laboris SAC</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="../images/favicon.png">
        <link rel="shortcut icon" href="../images/favicon.png">


        <link rel="stylesheet" href="../assets/css/bootstrap@4.1.3.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">

        <!-- Css Bootstrap Selectpicker bootstrap-select.min.css -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css"> -->
        <link rel="stylesheet" href="../assets/css/bootstrap-select@1.13.1.min.css">
        <link rel="stylesheet" href="../assets/css/cs-skin-elastic.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <!-- Css DataTables -->
        <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" /> -->
        <link rel="stylesheet" href="../assets/css/jquery.dataTables@1.13.7.css" />
        <link rel="stylesheet" href="../assets/css/buttons.dataTables@2.1.0.min.css">
        <link rel="stylesheet" href="../assets/css/responsive.dataTables.min.css">

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    </head>

    <body>
        <style>
            .switch-field {
                display: flex;
                margin-bottom: 0px;
                overflow: hidden;
            }

            .switch-field input {
                position: absolute !important;
                clip: rect(0, 0, 0, 0);
                height: 1px;
                width: 1px;
                border: 0;
                overflow: hidden;
            }

            .switch-field label {
                background-color: #e4e4e4;
                color: black;
                font-size: 14px;
                line-height: 1;
                text-align: center;
                padding: 8px 16px;
                margin-right: -1px;
                border: 1px solid rgba(0, 0, 0, 0.2);
                box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
                transition: all 0.1s ease-in-out;
            }

            .switch-field label:hover {
                cursor: pointer;
            }

            .switch-field input:checked+label {
                background-color: #17a2b8;
                box-shadow: none;
                color: white;
            }

            .switch-field label:first-of-type {
                border-radius: 4px 0 0 4px;
            }

            .switch-field label:last-of-type {
                border-radius: 0 4px 4px 0;
            }

            .dataTables_wrapper .dataTables_filter input {
                border: 1px solid #17a2b8;
            }

            button.dt-button,
            div.dt-button,
            a.dt-button,
            input.dt-button {
                color: white;
                background: #17a2b8;
                border: 1px solid #17a2b8;
            }

            button.dt-button:hover {
                color: white !important;
                background: #17a2b8 !important;
                border: 1px solid #17a2b8;
            }

            .dataTables_wrapper .dataTables_length select {
                border: 1px solid #17a2b8;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current,
            .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
                color: white !important;
                border: 1px solid #17a2b8;
                background-color: #17a2b8;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                color: white !important;
                border: 1px solid #17a2b8;
                background: #17a2b8 !important;
            }

            .card {
                border: 1px solid #17a2b8;
            }

            @media screen and (max-width: 640px) {
                div.dt-buttons {
                    float: none !important;
                    text-align: left !important;
                }
            }
        </style>



        <div class="content-wrapper container-fluid">
            <!-- Main content -->
            <header>
                <div class="row mt-2">
                    <div class="col-10">
                        <img class="img-fluid mx-auto d-block" src="../images/salus.webp">
                    </div>
                    <div class="col-2 d-none d-md-block">
                        <span><strong>USUARIO:<strong><?php echo $_SESSION['persona_nombre'] ?></span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Animated -->
                <div class="">
                    <!-- Widgets  -->
                    <div class="row">

                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header bg-info">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 text-center">
                                            <strong>
                                                <a href="portal.php" class="float-left text-white" data-toggle="tooltip" data-placement="bottom" title="Volver a menu"><i class="fa-solid fa-right-from-bracket text-white " style="font-size:20px;cursor:pointer;"></i> </a>
                                                <span class="text-center text-white">SOLICITUD DE SOPORTE TÉCNICO</span>
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body card-block" id="div-requerimientos">
                                    <div class="p-md-3">
                                        <div class="row">

                                            <div class="col-6">
                                                <button class="btn btn-success btn-sm mb-3" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Registrar Requerimiento</button>
                                            </div>
                                            <div class="col-6 d-flex justify-content-end justify-content-md-end">
                                                <button class="btn btn-info btn-sm mb-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                    <i class="fa fa-filter"></i> Filtros
                                                </button>
                                            </div>

                                            <div class="collapse col-12" id="collapseExample">
                                                <div class="card card-body" style="max-width:100% !important">
                                                    <form id="filtros">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-12 mb-3">
                                                                <label for="fdesde" class="form-label"><strong>Desde:</strong></label>
                                                                <input type="date" class="form-control border-info" id="fdesde" name="fdesde" value="<?php echo $fecha_actual_dia_menos ?>">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-12 mb-3">
                                                                <label for="fhasta" class="form-label"><strong>Hasta:</strong></label>
                                                                <input type="date" class="form-control border-info" id="fhasta" name="fhasta" value="<?php echo $fecha_actual ?>">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-12 mb-3">
                                                                <label for="fservicio" class="form-label"><strong>Asignado:</strong></label>
                                                                <select class="form-control form-select selectpicker" data-actions-box="true" multiple data-live-search="true" id="fasignado" name="fasignado">
                                                                    <option value="-1">TODOS</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-12 mb-3">
                                                                <label for="fservicio" class="form-label"><strong>Servicio:</strong></label>
                                                                <select class="form-control form-select selectpicker border-info" data-size="5" data-actions-box="true" data-live-search="true" multiple id="fservicio" name="fservicio">
                                                                    <option value="-1" selected disabled>SELECCIONE UN SERVICIO</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-12 mb-3">
                                                                <label for="festado" class="form-label"><strong>Estado:</strong></label>
                                                                <select class="form-control form-select selectpicker border-info" id="festado" name="festado">
                                                                    <option value="0">TODOS</option>
                                                                    <option value="1">REGISTRADO</option>
                                                                    <option value="2">EN PROCESO</option>
                                                                    <option value="3">TERMINADO</option>
                                                                    <option value="4">ANULADO</option>
                                                                    <option value="5">SUSPENDIDO</option>
                                                                    <option value="6">PRE ATENDIDO</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-12 mb-3 d-flex align-items-end">
                                                                <button type="button" class="btn btn-info col-12" onclick="buscarFiltros()"><i class="fa fa-search"></i> Buscar</button>
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <h5 class="font-weight-bold d-flex align-items-sm-center">Agrupar requerimientos:</h5>&nbsp;&nbsp;
                                            <div class="switch-field">

                                                <input type="radio" id="radio-one" name="switch-one" value="1">
                                                <label for="radio-one">Si</label>
                                                <input type="radio" id="radio-two" name="switch-one" value="0" checked="">
                                                <label for="radio-two">No</label>
                                            </div>

                                        </div>

                                        <div class="panel-body table-responsive" id="lista-requerimientos">
                                            <table id="tabla_requerimientos" class="table table-bordered table-condensed table-hover">
                                                <thead class="bg-info text-white">
                                                    <th></th>
                                                    <th>Opciones</th>
                                                    <th>Fecha Registro</th>
                                                    <th>Centro Utilidad</th>
                                                    <th>Centro Costo</th>
                                                    <th>Sede</th>
                                                    <th>Estado</th>
                                                    <th class="d-none">Id</th>
                                                </thead>

                                            </table>
                                        </div>

                                        <div class=" table-responsive col-12" id="lista-detalles">
                                            <table id="tabla_det_requerimientos" class="table table-bordered table-condensed table-hover">
                                                <thead class="bg-info text-white">
                                                    <th></th>
                                                    <th>Servicio</th>
                                                    <th>F.Registro</th>
                                                    <th>F.Plazo</th>
                                                    <!-- <th>F.Propuesta</th> -->
                                                    <th>F.Termino</th>
                                                    <!-- <th>N°Reprog.</th>
                                                    <th>Ult. F.Reprog.</th>
                                                    <th>Solicitado</th> -->
                                                    <th>Asignado</th>
                                                    <!-- <th>Depende</th>
                                                    <th>Delegado</th> -->
                                                    <th>C. Utilidad</th>
                                                    <th>C. Costo</th>
                                                    <th>Sede</th>
                                                    <!-- <th>Detalle</th> -->
                                                    <th>Detalle</th>
                                                    <!-- <th>Prioridad</th> -->
                                                    <th>Estado</th>
                                                    <th>Opciones</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>

                                <div class="card-body card-block" id="div-anadir">
                                    <div class="col-12">
                                        <form method="post" id="frm_req_logistico" enctype="multipart/form-data">
                                            <input type="hidden" id="ultimo_asignado" name="ultimo_asignado" value="0">
                                            <input type="hidden" id="nombre_ultimo_asignado" name="nombre_ultimo_asignado" value="">
                                            <div class="row mb-3">
                                                <div class="col-lg-4 col-md-4 col-12 mb-3">
                                                    <label for="centro_utilidad" class="form-label"><strong>Centro de Utilidad:(*)</strong></label>
                                                    <select class="form-control form-select selectpicker border-info" data-live-search="true" data-size="10" id="centro_utilidad" name="centro_utilidad" onchange="listar_centro_costo()">

                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-12 mb-3">
                                                    <label for="centro_costo" class="form-label"><strong>Centro de Costo:(*)</strong></label>
                                                    <select class="form-control form-select selectpicker border-info" data-live-search="true" data-size="10" id="centro_costo" name="centro_costo" onchange="listar_sede()">
                                                        <option value="0" disabled selected>Seleccione un Centro de Costo</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-12 mb-3">
                                                    <label for="sede" class="form-label"><strong>Sede:(*)</strong></label>
                                                    <select class="form-control form-select selectpicker border-info" data-live-search="true" data-size="10" id="sede" name="sede">
                                                        <option value="0" disabled selected>Seleccione una Sede</option>
                                                    </select>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-lg-12 col-md-12 col-12 d-flex align-items-end">
                                                        <div class="col-12 mb-3">
                                                            <!-- <button class="btn btn-primary" type="button" onclick="BotonNuevo()" id="agregar_requerimiento_nuevo" style="display: none;"><i class="fa fa-save"></i> Nuevo</button> -->
                                                            <button class="btn btn-primary" type="button" id="agregar_requerimiento"><i class="fa fa-save"></i> Guardar</button>
                                                            <button class="btn btn-danger" type="button" id="btncancelar" onclick="cancelarform()"><i class="fa fa-arrow-circle-left"></i> Volver</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>


                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="col-lg-8 col-md-8 col-12 mb-3">
                                                    <button class="btn btn-success" type="button" id="agregar_requerimiento_detalle" data-toggle="modal" data-target="#ModalAgregarDetalles"><i class="fa fa-plus-circle"></i> Añadir detalle</button>
                                                </div>
                                            </div>

                                            <div class=" table-responsive">
                                                <table id="tabla_detalles" class="table table-bordered table-condensed table-hover" style="width: 100%;">
                                                    <thead class="bg-info text-white">
                                                        <tr>
                                                            <th scope="col">Opciones</th>
                                                            <th scope="col">Categoria</th>
                                                            <th scope="col">Detalle</th>
                                                            <th scope="col">F. Plazo</th>
                                                            <th scope="col">Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- <footer>
                <div class="row col-12 bg-info p-3" style="position:absolute;bottom:0px"><div class="col-12 text-center text-white"><span>Copyright © 2024. Salus Laboris</span></div></div>
            </footer> -->

            <!-- Modal -->
            <div class="modal fade" id="ModalAgregarDetalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-lg" role="document">
                    <form id="frm_req_logistico_det" method="post" enctype="multipart/form-data">

                        <input type="hidden" id="id_requerimiento" name="id_requerimiento" value="0"> <!-- id del requerimiento -->
                        <input type="hidden" id="id_detalle_req" name="id_detalle_req" value=""><!-- id del detalle requerimiento por defecto vacio-->
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <span class="modal-title text-center" id="exampleModalLabel"><strong>Agregar Detalles de Requerimiento</strong></span>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" onclick="limpiar_detalles()">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 col-lg-12 mb-3">
                                        <label for="servicio" class="form-label"><strong>Tipo de Servicio:(*)</strong></label>
                                        <select class="form-control form-select selectpicker show-tick border-info" id="servicio" name="servicio" onchange="listar_sub_catalogo_soporte()"></select>
                                    </div>

                                    <div class="col-12 col-lg-12 mb-3">
                                        <label for="categoria" class="form-label"><strong>Categoria:(*)</strong></label>
                                        <select class="form-control form-select selectpicker show-tick border-info" data-live-search="true" data-size="10" id="categoria" name="categoria" onchange="mostrar_asignado()">
                                            <option value="-1" selected disabled>Seleccione una Categoria</option>
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="detalle_requerimiento" class="form-label"><strong>Asignado</strong></label>
                                        <label class="form-control border-info" id="asignado" name="asignado"></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="detalle_requerimiento" class="form-label"><strong>Detalle su Requerimiento:(*)</strong></label>
                                        <textarea class="form-control border-info" id="detalle_requerimiento" name="detalle_requerimiento" rows="2" required placeholder="INGRESE DETALLE DE REQUERIMIENTO"></textarea>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-12 col-lg-6 mb-3">
                                        <label for="plazo" class="form-label"><strong>Fecha de plazo</strong></label>
                                        <input type="date" class="form-control border-info" id="plazo" name="plazo" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>">
                                    </div>

                                    <div class="col-12 col-lg-6 mb-3">
                                        <label for="formFile" class="form-label"><strong>Subir Archivo</strong></label>
                                        <input class="form-control border-info" type="file" title="*Subir Archivos / Hasta 10 archivos permitidos, tam. por archivo :10MB" id="subir_archivo" style="border: 0px;" name="subir_archivo" onchange="subir_archivos()">
                                    </div>
                                </div>
                                <div id="div_tabla_archivos" class="col-12 table-responsive" style="display:none">
                                    <table id="tabla_archivos" class="table table-bordered table-condensed table-hover">
                                        <thead class="bg-info text-white">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Archivo</th>
                                                <th scope="col">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tb_archivos">

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="limpiar_detalles()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i>Cancelar</button>
                                <button type="button" onclick="insertar_detalle_requerimiento()" class="btn btn-primary" id="btn_guardar_detalles"><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div id="ModalAnular" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <div class="row pr-4 pl-4">
                                <span><strong>Anular Requerimiento</strong></span>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row col-12">
                                <div class="form-group col-md-12">
                                    <label><strong>Ingrese motivo de anulación: </strong></label>
                                    <input type="hidden" id="IdRequerimientoAnular" name="IdRequerimientoAnular" value="0">
                                    <input type="hidden" id="IdRequerimientoDetalleAnular" name="IdRequerimientoDetalleAnular" value="0">
                                    <textarea class="form-control border-info" id="motivoanulacion" name="motivoanulacion" rows="5" placeholder="Escriba motivo de anulación">

                            </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                            <button class="btn btn-info" type="button" onclick="anular_requerimiento()">Anular</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <script src="../assets/js/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
        <script src="../assets/js/bootstrap@4.1.3.min.js"></script>
        <script src="../assets/js/sweetalert2.all.min.js"></script>
        <script src="../assets/js/jquery.dataTables@1.13.7.min.js"></script>
        <script src="../assets/js/dataTables.buttons@2.1.0.min.js"></script>
        <script src="../assets/js/buttons.html5@2.1.0.min.js"></script>
        <script src="../assets/js/buttons@2.1.0.print.min.js"></script>
        <script src="../assets/js/jszip@3.1.3.min.js"></script>




        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> -->
        <script src="../assets/js/bootstrap-select@1.13.1.min.js"></script>
        <script type="text/javascript" src="scripts/soporte_tecnico.js?=<?php echo time() ?>"></script>

    </body>

    </html>

<?php

}
?>