<?php 
//Ip de la pc servidor de base de datos
define("DB_HOST","10.0.0.15");
//define("DB_HOST","localhost");

//Nombre de la base de datos

define("DB_NAME", "sl_prueba_task"); // pruebas
//define("DB_NAME", "sl_prueba_task_v2");//produccion

//Usuario de la base de datos
define("DB_USERNAME", "root");

//Contraseña del usuario de la base de datos 
define("DB_PASSWORD", "Salus.2021");
//define("DB_PASSWORD", "");

//definimos la codificación de los caracteres
define("DB_ENCODE","utf8");

//Definimos una constante como nombre del proyecto
define("PRO_NOMBRE","task_control");

//funcion depurar
function dep($data){
    $format = '';
    $format .= print_r("<pre>");
    $format .= print_r($data);
    $format .= print_r("</pre>");
    return $format;
}

?>
