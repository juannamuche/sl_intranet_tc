<?php
session_start();

if (!isset($_SESSION["persona_id"])) {
    header("Location: login.php");
} else {
?>
    <!doctype html>
    <html class="no-js" lang="">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Task-Control - Salus Laboris SAC</title>
        <meta name="description" content="Ela Admin - HTML5 Admin Template">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="../images/favicon.png">
        <link rel="shortcut icon" href="../images/favicon.png">
        <link rel="stylesheet" href="../assets/css/bootstrap@4.1.3.min.css">
        <link rel="stylesheet" href="../assets/css/cs-skin-elastic.css">
        <link rel="stylesheet" href="../assets/css/style.css">

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    </head>

    <body>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-12">
                        <img class="img-fluid mx-auto d-block" src="../images/salus.webp">
                    </div>
                </div>
            </header>
            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="card border border-info">
                        <img class="card-img-top p-2" src="../images/apoyo-tecnico.png" height="230px" width="auto">
                        <div class="card-body bg-info text-center">
                            <a class="card-text text-white font-weight-bold" href="soporte_tecnico.php">SOPORTE TÉCNICO</a>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="card border border-info">
                        <img class="card-img-top p-2" src="../images/uniforme.png" height="230px" width="auto">
                        <div class="card-body bg-info text-center">
                            <a class="card-text text-white font-weight-bold" href="uniformes.php">UNIFORMES</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <a class="btn btn-danger btn-lg" href="login.php"><i class="fa fa-door-closed"></i>SALIR</a>
                </div>
            </div>

            <!-- <footer>
                <div class="row col-12 bg-info p-3" style="position:absolute;bottom:0px"><div class="col-12 text-center text-white"><span>Copyright © 2024. Salus Laboris</span></div></div>
            </footer> -->
        </div>

        <script src="../assets/js/bootstrap@4.1.3.min.js"></script>
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="scripts/soporte_tecnico.js"></script>

    </body>

    </html>
<?php
}
?>