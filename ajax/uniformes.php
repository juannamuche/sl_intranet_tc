<?php
ob_start();
date_default_timezone_set("America/Lima"); //Zona horaria de Peru

if (strlen(session_id()) < 1) {
	session_start(); //Validamos si existe o no la sesión
}

require_once "../modelo/Uniformes.php";
$uniformes = new Uniformes();

switch ($_GET["op"]) {

	case "select_medida":
		$tipoMedida = isset($_POST["tipomedida"]) ? limpiarCadena($_POST["tipomedida"]) : "";
		$option = "";
		$array = array();
		$rspta = $uniformes->select_medida($tipoMedida);
		$option .= '<option value="0" disabled selected>Seleccione una medida</option>';
		while ($reg = $rspta->fetch_object()) {
			$option .= '<option value=' . $reg->NombreValue . '>' . $reg->ValorParametro . '</option>';
		//	$option .= '<option value=' . $reg->ValorParametro . '>' . $reg->ValorParametro . '</option>';
		}
		$array = array(
			"status" => true,
			"html" => $option
		);
		echo json_encode($array);

		break;

		case "mostrar_uniformes_persona":		
			$idpersona=$_SESSION['persona_id'];
			$array = array();
			$rspta = $uniformes->mostrar_uniformes_persona($idpersona);

			if (!empty($rspta)) {

				$array = array(
					"status" => true,
					"datos" => $rspta,
					"ico" => "success",
					"msg" => "Exito"
				);
			} else {
				$array = array(
					"status" => false,
					"datos" => 0,
					"ico" => "error",
					"msg" => "Sin información"
				);
			}
	
			echo json_encode($array);

			break;

	case "guardar_uniforme":

		$pechovaron = isset($_POST["pechovaron"]) ? limpiarCadena($_POST["pechovaron"]) : "";
		$cinturavaron = isset($_POST["cinturavaron"]) ? limpiarCadena($_POST["cinturavaron"]) : "";
		$hombrovaron = isset($_POST["hombrovaron"]) ? limpiarCadena($_POST["hombrovaron"]) : "";
		$lcuerpovaron = isset($_POST["lcuerpovaron"]) ? limpiarCadena($_POST["lcuerpovaron"]) : "";
		$lmangavaron = isset($_POST["lmangavaron"]) ? limpiarCadena($_POST["lmangavaron"]) : "";
		$pcinturavaron = isset($_POST["pcinturavaron"]) ? limpiarCadena($_POST["pcinturavaron"]) : "";
		$pcaderavaron = isset($_POST["pcaderavaron"]) ? limpiarCadena($_POST["pcaderavaron"]) : "";
		$pmuslovaron = isset($_POST["pmuslovaron"]) ? limpiarCadena($_POST["pmuslovaron"]) : "";
		$lpiernasvaron = isset($_POST["lpiernasvaron"]) ? limpiarCadena($_POST["lpiernasvaron"]) : "";

		$pechomujer = isset($_POST["pechomujer"]) ? limpiarCadena($_POST["pechomujer"]) : "";
		$cinturamujer = isset($_POST["cinturamujer"]) ? limpiarCadena($_POST["cinturamujer"]) : "";
		$lcuerpomujer = isset($_POST["lcuerpomujer"]) ? limpiarCadena($_POST["lcuerpomujer"]) : "";
		$lmangamujer = isset($_POST["lmangamujer"]) ? limpiarCadena($_POST["lmangamujer"]) : "";
		$pcinturamujer = isset($_POST["pcinturamujer"]) ? limpiarCadena($_POST["pcinturamujer"]) : "";
		$pcaderamujer = isset($_POST["pcaderamujer"]) ? limpiarCadena($_POST["pcaderamujer"]) : "";
		$lpiernasmujer = isset($_POST["lpiernasmujer"]) ? limpiarCadena($_POST["lpiernasmujer"]) : "";

		$calzado = isset($_POST["calzado"]) ? limpiarCadena($_POST["calzado"]) : "";
		$casaca = isset($_POST["casaca"]) ? limpiarCadena($_POST["casaca"]) : "";
		$chaleco = isset($_POST["chaleco"]) ? limpiarCadena($_POST["chaleco"]) : "";
		$lentes = isset($_POST["lentes"]) ? limpiarCadena($_POST["lentes"]) : "";

		$ubicacion = isset($_POST["ubicacion"]) ? limpiarCadena($_POST["ubicacion"]) : "";
		$datos = isset($_POST["datos"]) ? limpiarCadena($_POST["datos"]) : "";
		$nombres = isset($_POST["nombres"]) ? limpiarCadena($_POST["nombres"]) : "";
		$celular = isset($_POST["celular"]) ? limpiarCadena($_POST["celular"]) : "";
		$dni = isset($_POST["DNI"]) ? limpiarCadena($_POST["DNI"]) : "";

		$array = array();
		if ($_SESSION['sexo'] == 'MASCULINO') {
			$rspta = $uniformes->guardar_uniforme($_SESSION['persona_id'],$pechovaron, $cinturavaron,$hombrovaron,$lcuerpovaron,$lmangavaron,$pcinturavaron,$pcaderavaron,$pmuslovaron,$lpiernasvaron,$calzado,$casaca,$chaleco,$ubicacion,$datos,$nombres,$celular,$dni,1,$lentes);
		} else {
			$rspta = $uniformes->guardar_uniforme($_SESSION['persona_id'],$pechomujer, $cinturamujer,'',$lcuerpomujer,$lmangamujer,$pcinturamujer,$pcaderamujer,'',$lpiernasmujer,$calzado,$casaca,$chaleco,$ubicacion,$datos,$nombres,$celular,$dni,1,$lentes);
		}

		if (!empty($rspta)) {

			$array = array(
				"status" => true,
				"dni" => $rspta['idpersona'],
				"ico" => "success",
				"msg" => "Solicitud enviada exitosamente"
			);
		} else {
			$array = array(
				"status" => false,
				"dni" => 0,
				"ico" => "error",
				"msg" => "No se puedo enviar la solicitud"
			);
		}

		echo json_encode($array);
		break;
}
ob_end_flush();
