<?php
session_start();
session_unset();
session_destroy();
?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Task-Control - Salus Laboris SAC</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta property="al:android:package" content="com.saluslaboris.app" />
    <meta property="al:android:app_name" content="saluslaboris" />


    <link rel="apple-touch-icon" href="../images/favicon.png">
    <link rel="shortcut icon" href="../images/favicon.png">
    <link rel="stylesheet" href="../assets/css/bootstrap@4.1.3.min.css">
    <link rel="stylesheet" href="../assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>
    <div class="container-fluid">
        <div class="row d-flex align-items-center" style="min-height: 700px;">
            <div class="col-12 col-md-6 d-none d-md-block">
                <div class="login-logo">
                    <img class="mx-auto d-none d-md-block" src="../images/logo-salus.png" height="500px" width="auto">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <img class="mx-auto d-block d-md-none mb-3" src="../images/salus.webp" height="80px" width="auto">
                <h4 class="text-center text-info d-none d-md-block"><strong>INTRANET SALUS LABORIS</strong></h4>
                <div class="login-form  offset-lg-2 col-lg-8">
                    <form method="post" id="frmAcceso">
                        <div class="form-group">
                            <label class="text-info"><strong>DNI</strong></label>
                            <input type="text" id="dni" name="dni" class="form-control border-info"
                                placeholder="Nro. DNI">
                        </div>
                        <div class="form-group">
                            <label class="text-info"><strong>Celular</strong></label>
                            <input type="text" id="celular" name="celular" class="form-control border-info"
                                placeholder="Nro. Celular">
                        </div>
     
                        <button type="button" id="btnlogin" class="btn btn-info btn-flat m-b-30 m-t-30 font-weight-bold">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <script src="../assets/js/bootstrap@4.1.3.min.js"></script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="scripts/soporte_tecnico.js"></script>

</body>

</html>
