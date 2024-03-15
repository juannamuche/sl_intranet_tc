<?php 
require_once "global.php";

$conexion = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
mysqli_query( $conexion, 'SET NAMES "'.DB_ENCODE.'"');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);//NUEVO


//Si tenemos un posible error en la conexión lo mostramos
if (mysqli_connect_errno())
{
	printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
	exit();
}

if (!function_exists('ejecutarConsulta'))
{
	function ejecutarConsulta($sql)
	{
		global $conexion;
		limpiardatosmysql();
		try{
			$query = $conexion->query($sql);
			return $query;
		}catch(Exception $e){
			return "Hubo un problema al conectar al servidor, Excepcion:".$e;
		}
		mysqli_close($conexion);
		
	}

	function ejecutarConsultaSimpleFila($sql)
	{
		global $conexion;
		limpiardatosmysql();
		
		try{
			$query = $conexion->query($sql);		
			$row = $query->fetch_assoc();
			return $row;

		}catch(Exception $e){
			return "Hubo un problema al conectar al servidor, Excepcion:".$e;
		}
		mysqli_close($conexion);
	}

	function ejecutarConsulta_retornarID($sql)
	{
		global $conexion;
		limpiardatosmysql();
		try{
			$query = $conexion->query($sql);		
			return $conexion->insert_id;
		
		}catch(Exception $e){
			return "Hubo un problema al conectar al servidor, Excepcion:".$e;
		}
		mysqli_close($conexion);
	}

	function limpiarCadena($str)
	{
		global $conexion;
		limpiardatosmysql();
		$str = mysqli_real_escape_string($conexion,trim($str));
		return htmlspecialchars($str);
	}
	function limpiardatosmysql(){
		global $conexion;
			while (mysqli_more_results($conexion) && mysqli_next_result($conexion)) {

			$dummyResult = mysqli_use_result($conexion);

			if ($dummyResult instanceof mysqli_result) {
				mysqli_free_result($dummyResult);
			}
		}
	
	}

}
?>