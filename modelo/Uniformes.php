<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Uniformes
{

	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	public function login_uniforme($id)
	{
		$sql = "select * from tb_persona where id_persona=$id";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function select_medida($medida)
	{
		$sql="select * from tb_parametros where NombreTabla='$medida'";
		return ejecutarConsulta($sql);
	}

	public function mostrar_uniformes_persona($idpersona)
	{
		$sql="select * from tb_persona where id_persona=$idpersona";
		return ejecutarConsultaSimpleFila($sql);
	}

function guardar_uniforme($idpersona,$pecho,$cintura,$hombro,$cuerpo,$manga,$cintura_pantalon,$cadera,$muslo,$piernas,$calzado,$casaca,$chaleco,$ubicacion,$envio,$nombre,$celular,$dni,$tipo){
	$sql="CALL sp_uniforme_grabar($idpersona,'$pecho','$cintura','$hombro','$cuerpo','$manga','$cintura_pantalon','$cadera','$muslo','$piernas','$calzado','$casaca','$chaleco','$ubicacion','$envio','$nombre','$celular','$dni',$tipo)";
	//var_dump($sql);die();
	return ejecutarConsultaSimpleFila($sql);
}
	
}
