<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["id_persona"])) {
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
        </style>



        <div class="content-wrapper container-fluid">
            <!-- Main content -->
            <header>
            <div class="row mt-2">                 
                        <div class="col-10">
                            <img class="img-fluid mx-auto d-block" src="../images/salus.webp">
                        </div>
                        <div class="col-2 d-none d-md-block">
                            <span><strong>USUARIO:<strong><?php echo $_SESSION['persona']?></span>
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
                                                <span class="text-center text-white">SOLICITUD DE UNIFORME</span>
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body card-block">
                                    <input type="hidden" id="sexo" name="sexo" value="<?php echo $_SESSION['sexo'] ?>">
                                    <div class="p-md-3">
                                        <form id="formUniforme">
                                            <div id="divcamisa" class="row">
                                                <div class="col-12 mb-3">
                                                    <h4 class="text-info text-center font-weight-bold">CAMISAS</h4>
                                                </div>
                                                <div id="img-camisa-varon" class="col-12 col-lg-4 d-flex mb-3">
                                                    <img src="../images/camisa.jpg" class="mx-auto" height="350px" width="auto">
                                                </div>
                                                <div id="div-camisa-varon" class="col-12 col-lg-8">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="pechovaron" class="form-label"><strong>Medida de pecho:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="pechovaron" name="pechovaron">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="cinturavaron" class="form-label"><strong>Medida de cintura:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="cinturavaron" name="cinturavaron">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="hombrovaron" class="form-label"><strong>Medida de hombro:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="hombrovaron" name="hombrovaron">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="lcuerpovaron" class="form-label"><strong>Medida de L. Cuerpo:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="lcuerpovaron" name="lcuerpovaron">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="lmangavaron" class="form-label"><strong>Medida de L. Manga:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="lmangavaron" name="lmangavaron">

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="divpantalonhombre" class="row">
                                                <div class="col-12 mb-3">
                                                    <h4 class="text-info text-center font-weight-bold">PANTALON</h4>
                                                </div>
                                                <div id="img-pantalon-varon" class="col-12 col-lg-4 d-flex mb-3">
                                                    <img id="pantalon-varon" src="../images/VARONES.jpg" class="mx-auto" height="350px" width="auto">
                                                </div>
                                                <div id="div-pantalon-varon" class="col-12 col-lg-8">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="pcinturavaron" class="form-label"><strong>Medida de cintura:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="pcinturavaron" name="pcinturavaron">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="pcaderavaron" class="form-label"><strong>Medida de cadera:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="pcaderavaron" name="pcaderavaron">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="pmuslovaron" class="form-label"><strong>Medida de muslo:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="pmuslovaron" name="pmuslovaron">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="lpiernasvaron" class="form-label"><strong>Medida del largo de piernas en cm:(*)</strong></label>
                                                            <input type="text" id="lpiernasvaron" name="lpiernasvaron" class="form-control border-info" placeholder="medida en cm.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="divblusa" class="row">
                                                <div class="col-12 mb-3">
                                                    <h4 class="text-info text-center font-weight-bold">BLUSAS</h4>
                                                </div>
                                                <div id="img-blusa-mujer" class="col-12 col-lg-4 d-flex mb-3">
                                                    <img src="../images/blusa.jpg" class="mx-auto" height="350px" width="auto">
                                                </div>
                                                <div id="div-blusa-mujer" class="col-12 col-lg-8">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="pechomujer" class="form-label"><strong>Medida de Pecho:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="pechomujer" name="pechomujer">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="cinturamujer" class="form-label"><strong>Medida de Cintura:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="cinturamujer" name="cinturamujer">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="lcuerpomujer" class="form-label"><strong>Medida de L. Cuerpo:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="lcuerpomujer" name="lcuerpomujer">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="lmangamujer" class="form-label"><strong>Medida de L. Manga:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="lmangamujer" name="lmangamujer">

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="divpantalonmujer" class="row">
                                                <div class="col-12 mb-3">
                                                    <h4 class="text-info text-center font-weight-bold">PANTALON</h4>
                                                </div>
                                                <div id="img-pantalon-mujer" class="col-12 col-lg-4 d-flex mb-3">
                                                    <img id="pantalon-mujer" src="../images/DAMA.jpg" class="mx-auto" height="350px" width="auto">
                                                </div>
                                                <div id="div-pantalon-mujer" class="col-12 col-lg-8">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="pcinturamujer" class="form-label"><strong>Medida de cintura:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="pcinturamujer" name="pcinturamujer">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="pcaderamujer" class="form-label"><strong>Medida de cadera:(*)</strong></label>
                                                            <select class="form-control form-select border-info" id="pcaderamujer" name="pcaderamujer">

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="lpiernasmujer" class="form-label"><strong>Medida del largo de piernas en cm:(*)</strong></label>
                                                            <input type="text" id="lpiernasmujer" name="lpiernasmujer" class="form-control border-info" placeholder="medida en cm.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="divadicionales" class="row">
                                                <div class="col-12 mb-3">
                                                    <h4 class="text-info text-center font-weight-bold">TALLAS ADICIONALES</h4>
                                                </div>
                                                <div class="col-12 col-lg-4 mb-3">
                                                    <label for="calzado" class="form-label"><strong>Ingrese la medida de calzado:(*)</strong></label>
                                                    <select class="form-control form-select border-info" id="calzado" name="calzado">

                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-4 mb-3">
                                                    <label for="casaca" class="form-label"><strong>Talla de Casaca:(*)</strong></label>
                                                    <select class="form-control form-select border-info" id="casaca" name="casaca">

                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-4 mb-3">
                                                    <label for="chaleco" class="form-label"><strong>Talla de Chaleco:(*)</strong></label>
                                                    <select class="form-control form-select border-info" id="chaleco" name="chaleco">

                                                    </select>
                                                </div>
                                            </div>
                                            <div id="divdatos" class="row">
                                                <div class="col-12 mb-3">
                                                    <h4 class="text-info text-center font-weight-bold mb-3">DATOS DE ENVIO</h4>
                                                </div>
                                                <div class="col-12 col-lg-4 mb-3">
                                                    <label for="ubicacion" class="form-label"><strong>Ubicación:(*)</strong></label>
                                                    <select class="form-control form-select border-info" id="ubicacion" name="ubicacion" onchange="ubicacion_envio()">
                                                        <option value="0" disabled selected>Seleccione una Ubicación</option>
                                                        <option value="1">Lima</option>
                                                        <option value="2">Provincia</option>

                                                    </select>
                                                </div>
                                                <div id="div-datos" class="col-12 col-lg-4 mb-3">
                                                    <label for="datos" class="form-label"><strong>Enviar con:(*)</strong></label>
                                                    <select class="form-control form-select border-info" id="datos" name="datos" onchange="envio()">
                                                        <option value="0" disabled selected>Seleccione una Ubicación</option>
                                                        <option value="1">Usar mis datos</option>
                                                        <option value="2">Otros datos</option>

                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-6 mb-3 otros-datos">
                                                    <label for="nombres" class="form-label"><strong>Apellidos y Nombres:(*)</strong></label>
                                                    <input type="text" id="nombres" name="nombres" class="form-control border-info" placeholder="Nombres y Apellidos">
                                                </div>
                                                <div class="col-12 col-lg-3 mb-3 otros-datos">
                                                    <label for="celular" class="form-label"><strong>Celular:(*)</strong></label>
                                                    <input type="text" id="celular" name="celular" class="form-control border-info" placeholder="Celular">
                                                </div>
                                                <div class="col-12 col-lg-3 mb-3 otros-datos">
                                                    <label for="dni" class="form-label"><strong>DNI:(*)</strong></label>
                                                    <input type="text" id="DNI" name="DNI" class="form-control border-info" placeholder="DNI">
                                                </div>
                                                <p class="col-12">Para personal de Lima deben de acercarse a la siguiente ubicación.<br>
                                                    <strong>Lugar: calle Cerro Sechin Mz. C Lt. 18</strong><br>
                                                    <strong>Horario: 2 pm a 4 pm</strong>
                                                </p>
                                            </div>
                                            <div class="row col-12 d-flex justify-content-end">
                                                <button type="button" id="btnatras" class="btn btn-danger btn-sm" onclick="mostrar(1)"><i class="fa fa-arrow-left"></i> ANTERIOR</button>
                                                &nbsp;&nbsp;
                                                <button type="button" id="btnsiguiente" class="btn btn-info btn-sm" onclick="mostrar(2)">SIGUIENTE <i class="fa fa-arrow-right"></i></button>
                                                &nbsp;&nbsp;
                                                <button type="button" id="btnguardar" class="btn btn-success btn-sm" onclick="guardar()">GUARDAR <i class="fa fa-save"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- <footer>
                <div class="row col-12 bg-info p-3" style="position:relative;bottom:0px"><div class="col-12 text-center text-white"><span>Copyright © 2024. Salus Laboris</span></div></div>
            </footer> -->
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
        <script type="text/javascript" src="scripts/uniformes.js?=<?php echo time() ?>"></script>

    </body>

    </html>

<?php

}
?>