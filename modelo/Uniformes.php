<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Uniformes
{

	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	public function select_medida($medida)
	{
		$sql="select * from tb_parametros where NombreTabla='$medida'";
		return ejecutarConsulta($sql);
	}


function guardar_uniforme($idpersona,$pecho,$cintura,$hombro,$cuerpo,$manga,$cintura_pantalon,$cadera,$muslo,$piernas,$calzado,$casaca,$chaleco,$ubicacion,$envio,$nombre,$celular,$dni){
	$sql="CALL sp_uniforme_grabar($idpersona,'$pecho','$cintura','$hombro','$cuerpo','$manga','$cintura_pantalon','$cadera','$muslo','$piernas','$calzado','$casaca','$chaleco','$ubicacion','$envio','$nombre','$celular','$dni')";
	//var_dump($sql);die();
	return ejecutarConsultaSimpleFila($sql);
}
	
}
