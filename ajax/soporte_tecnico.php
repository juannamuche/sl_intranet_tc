<?php
ob_start();
date_default_timezone_set("America/Lima"); //Zona horaria de Peru

if (strlen(session_id()) < 1) {
	session_start(); //Validamos si existe o no la sesión
}

require_once "../modelo/Soporte_Tecnico.php";
$soporte = new Soporte();

switch ($_GET["op"]) {

		/*************************funciones de acceso a soporte */
	case "login_soporte":
		$dni = isset($_POST["dni"]) ? limpiarCadena($_POST["dni"]) : "";
		$celular = isset($_POST["celular"]) ? limpiarCadena($_POST["celular"]) : "";

		$array = array();

		$rspta = $soporte->login_soporte($dni, $celular);

		if (!empty($rspta)) {

			$_SESSION['dni'] = $rspta['dni'];
			$_SESSION['persona_id'] = $rspta['id_persona'];
			$_SESSION['persona_nombre'] = $rspta['nombre'];
			$_SESSION['sexo'] = $rspta['sexo'];
			$array = array(
				"status" => true,
				"dni" => $rspta['dni'],
				"ico" => "success",
				"msg" => "Acceso autorizado"
			);
		} else {
			$array = array(
				"status" => false,
				"dni" => 0,
				"ico" => "error",
				"msg" => "Acceso denegado, verifique sus datos"
			);
		}

		echo json_encode($array);
		break;

	case 'centro_utilidad_listar':

		$array = array();
		$option = "";

		$rspta = $soporte->select_centro_utilidad();

		$option .= '<option value="0" disabled selected>Seleccione un Centro de Utilidad</option>';
		while ($reg = $rspta->fetch_object()) {
			$option .= '<option value="' . $reg->id_centro_utilidad . '">' . $reg->centro_utilidad . '</option>';
		}
		$array = array(
			"status" => true,
			"html" => $option
		);
		echo json_encode($array);

		break;

	case 'centro_costo_listar':

		$id_centro_utilidad = isset($_POST["id_centro_utilidad"]) ? limpiarCadena($_POST["id_centro_utilidad"]) : "";

		$array = array();
		$option = "";

		$rspta = $soporte->select_centro_costo($id_centro_utilidad);

		$option .= '<option value="0" disabled selected>Seleccione un Centro de Costo</option>';
		while ($reg = $rspta->fetch_object()) {
			$option .= '<option value="' . $reg->id_centro_costo . '">' . $reg->centro_costo . '</option>';
		}
		$array = array(
			"status" => true,
			"html" => $option
		);
		echo json_encode($array);

		break;

	case 'sede_listar':

		$id_centro_costo = isset($_POST["id_centro_costo"]) ? limpiarCadena($_POST["id_centro_costo"]) : "";

		$array = array();
		$option = "";

		$rspta = $soporte->select_sede($id_centro_costo);

		$option .= '<option value="0" disabled selected>Seleccione una Sede</option>';
		while ($reg = $rspta->fetch_object()) {
			$option .= '<option value="' . $reg->id_sede . '">' . $reg->sede . '</option>';
		}
		$array = array(
			"status" => true,
			"html" => $option
		);
		echo json_encode($array);

		break;

	case 'catalogo_soporte_listar':

		$array = array();
		$option = "";

		$rspta = $soporte->select_catalogo_soporte();

		$option .= '<option value="0" disabled selected>Seleccione un Servicio</option>';
		while ($reg = $rspta->fetch_object()) {
			$option .= '<option value="' . $reg->id_catalogo . '">' . $reg->nombre . '</option>';
		}
		$array = array(
			"status" => true,
			"html" => $option
		);
		echo json_encode($array);

		break;

	case 'sub_catalogo_soporte_listar':
		$idcatalogo = isset($_POST["idcatalogo"]) ? limpiarCadena($_POST["idcatalogo"]) : "";
		$array = array();
		$option = "";

		$rspta = $soporte->select_subcatalogo_soporte($idcatalogo);

		$option .= '<option value="0" disabled selected>Seleccione una Categoria</option>';
		while ($reg = $rspta->fetch_object()) {
			$option .= '<option value="' . $reg->idsubcatalogo . '">' . $reg->subcatalogo . '</option>';
		}

		$array = array(
			"status" => true,
			"html" => $option
		);
		echo json_encode($array);

		break;

	case 'insertar_requerimiento':
		$array = array();
		$centro_utilidad = isset($_POST["centro_utilidad"]) ? limpiarCadena($_POST["centro_utilidad"]) : "";
		$centro_costo = isset($_POST["centro_costo"]) ? limpiarCadena($_POST["centro_costo"]) : "";
		$sede = isset($_POST["sede"]) ? limpiarCadena($_POST["sede"]) : "";

		$importancia = "";
		$origen = 15;

		$rspta = $soporte->insertar_requerimiento($importancia, $centro_utilidad, $centro_costo, $sede, $origen);
		if (!empty($rspta)) {
			$array = array(
				"status" => true,
				"idRetorno" => $rspta['id_requerimiento'],
				"ico" => "success",
				"msg" => "Requerimiento insertado con exito"
			);
		} else {
			$array = array(
				"status" => false,
				"idRetorno" => 0,
				"ico" => "error",
				"msg" => "No se pudo registrar el requerimiento"
			);
		}
		//}

		echo json_encode($array);

		break;

	case 'subir_archivo':
		//numero de archivos cargados
		$numero_archivos = isset($_POST["ConteoList"]) ? limpiarCadena($_POST["ConteoList"]) : 0;

		$error = "ok";
		$html = "";

		if ($_FILES['subir_archivo']['size'] > 0) {
			if ($_FILES['subir_archivo']['size'] <= 10485760) {
				$conteolistado = $_POST['ConteoList'];
				$item = 1;
				if ($conteolistado != 0) {
					$item = $conteolistado + 1;
				}

				$nombre_fichero = $_FILES['subir_archivo']['tmp_name'];
				$datos = addslashes(file_get_contents($nombre_fichero));
				$valor_a_capturar = base64_encode($datos);
				$name_archivo = $_FILES['subir_archivo']['name'];

				$html = '<tr id="List_Archivo_' . $item . '">
										<td>' . $item . '</td>
										<td>
											<input type="text" style="display:none;" name="file_agregar[]" id="file_agregar_' . $item . '" class="form-control" value="' . $valor_a_capturar . '" >
											<input type="text" name="file_name_agregar[]" id="txtfilesname_' . $item . '" value="' . $name_archivo . '" class="form-control" readonly>
										</td>
										<td>
											<button class="btn btn-danger btn-sm" type="button"  onclick="eliminar_archivo(' . $item . ')" ><i class="fa fa-trash"></i></button>
										</td>
								   </tr>';
			} else {
				$error = "excedido";
			}
		} else {
			$error = "error";
		}

		$results = array(
			"errorproceso" => $error,
			"htmlreturn" => $html
		);
		echo json_encode($results);

		break;

	case 'insertar_requerimiento_detalles':
		$array = array();
		$id_requerimiento = isset($_POST["id_requerimiento"]) ? limpiarCadena($_POST["id_requerimiento"]) : "";
		$catalogo = isset($_POST["servicio"]) ? limpiarCadena($_POST["servicio"]) : "";
		$detalle = isset($_POST["detalle_requerimiento"]) ? limpiarCadena($_POST["detalle_requerimiento"]) : "";
		$plazo = isset($_POST["plazo"]) ? limpiarCadena($_POST["plazo"]) : "";
		$categoria = isset($_POST["categoria"]) ? limpiarCadena($_POST["categoria"]) : "";
		$asignado = isset($_POST["asignado"]) ? limpiarCadena($_POST["asignado"]) : "";
		$persona = $_SESSION['persona_id'];

		$rspta = $soporte->insertar_detalle_requerimiento($id_requerimiento, $catalogo, $categoria, $detalle, $plazo, $persona, 1, $asignado);


		if (!empty($rspta)) {

			if (!empty($_POST['file_name_agregar'])) {
				$archivos = $_POST['file_agregar'];
				$name_archivos = $_POST['file_name_agregar'];
				$datos_adjuntos = "";
				$i = 0;
				foreach ($archivos as $adjuntos) {
					$datos_adjuntos = base64_decode($adjuntos);
					$name_adjuntos = $name_archivos[$i++];
					$rspta_id = $soporte->GuardarArchivo($id_requerimiento, $datos_adjuntos, $name_adjuntos, $rspta['id_detalle_requerimiento']);
				}
			}

			$array = array(
				"status" => true,
				"idRetorno" => $rspta['id_detalle_requerimiento'],
				"ico" => "success",
				"msg" => "Detalle insertado con exito"
			);
		} else {
			$array = array(
				"status" => false,
				"idRetorno" => 0,
				"ico" => "error",
				"msg" => "No se pudo registrar el Detalle"
			);
		}

		echo json_encode($array);
		break;

	case 'obtener_asignado':
		$array = array();

		$rspta = $soporte->obtener_asignado(63);
		if (!empty($rspta)) {
			$array = array(
				"status" => true,
				"detalles" => $rspta,
				"ico" => "success",
				"msg" => "tiene detalles."
			);
		} else {
			$array = array(
				"status" => false,
				"detalles" => 0,
				"ico" => "error",
				"msg" => "vacio."
			);
		}
		echo json_encode($array);
		break;

	case 'mostrar_asignado':
		$id = isset($_POST["idcatalogo"]) ? limpiarCadena($_POST["idcatalogo"]) : "";

		$array = array();

		$rspta = $soporte->obtener_asignado($id);
		if (!empty($rspta)) {
			$array = array(
				"status" => true,
				"detalles" => $rspta,
				"ico" => "success",
				"msg" => "tiene detalles."
			);
		} else {
			$array = array(
				"status" => false,
				"detalles" => 0,
				"ico" => "error",
				"msg" => "vacio."
			);
		}
		echo json_encode($array);
		break;

	case 'listar_tabla_detalles':
		$id_requerimiento = isset($_GET["id"]) ? limpiarCadena($_GET["id"]) : "";
		$rspta = $soporte->listar_requerimiento_detalle($id_requerimiento);
		//Vamos a declarar un array
		$data = array();



		while ($reg = $rspta->fetch_object()) {

			$data[] = array(
				"0" => ($reg->estado) ?
					// ' <button class="btn btn-warning btn-sm" onclick="mostrar(' . $reg->id_detalle_requerimiento . ')"><i class="fa fa-eye"></i></button>' .
					' <button class="btn btn-danger btn-sm btn-det" onclick="desactivar(' . $reg->id_detalle_requerimiento . ')"><i class="fa fa-close"></i></button>' :
					// ' <button class="btn btn-warning btn-sm" onclick="mostrar(' . $reg->id_detalle_requerimiento . ')"><i class="fa fa-eye"></i></button>' .
					' <button class="btn btn-primary btn-sm btn-det" onclick="activar(' . $reg->id_detalle_requerimiento . ')"><i class="fa fa-check"></i></button>',
				"1" => $reg->nombre_subcatalogo,
				"2" => $reg->detalle_rq,
				"3" => $reg->fecha_plazo,
				"4" => ($reg->estado) ? '<span class="badge badge-warning">ACTIVADO</span>' : '<span class="badge badge-danger">ANULADO</span>'
			);
		}

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;


	case 'listar_requerimientos':
		$id_origen = isset($_GET["id"]) ? limpiarCadena($_GET["id"]) : "";

		$fecha_inicio = isset($_GET["fdesde"]) ? limpiarCadena($_GET["fdesde"]) : "";
		$fecha_fin = isset($_GET["fhasta"]) ? limpiarCadena($_GET["fhasta"]) : "";
		$servicio = isset($_GET["fservicio"]) ? limpiarCadena($_GET["fservicio"]) : "";
		$asignado = isset($_GET["fasignado"]) ? limpiarCadena($_GET["fasignado"]) : "";
		$estado = isset($_GET["festado"]) ? limpiarCadena($_GET["festado"]) : "";
		$persona = $_SESSION['persona_id'];
		$rspta = $soporte->listar_requerimientos($fecha_inicio, $fecha_fin, $id_origen, $estado, $persona, $servicio,$asignado);

		$data = array();
		while ($reg = $rspta->fetch_object()) {
			//$validarEstadosDetalles = $requerimiento->validarEstadosDetalles($reg->id_requerimiento);

			if ($reg->estado == 4) {
				$status = '<span class="badge badge-danger">ANULADO</span>';
			} else {

				$status = '<span class="badge badge-warning">ACTIVADO(' . $reg->terminados . '/' . $reg->totales . ')</span>';
			}

			$data[] = array(
				"0" => '',
				"1" => ($reg->estado == 4) ? ' <button class="btn btn-warning btn-sm" onclick="mostrar(' . $reg->id_requerimiento . ')"><i class="fa fa-eye"></i></button>' .
					' <button class="btn btn-secondary btn-sm" disabled><i class="fa fa-trash"></i></button>' :
					' <button class="btn btn-warning btn-sm" onclick="mostrar(' . $reg->id_requerimiento . ')"><i class="fa fa-eye"></i></button>' .
					' <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#ModalAnular" onclick="abrirModalAnular(' . $reg->id_requerimiento . ',0)"><i class="fa fa-trash"></i></button>',

				"2" => $reg->fecha_registro,
				"3" => $reg->centro_utilidad,
				"4" => $reg->centro_costo,
				"5" => $reg->sede,
				//  "6" => ($reg->importancia == 1) ? 'ALTA' : 'NORMAL',
				"6" => $status,
				"7" => $reg->id_requerimiento
			);
		}

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;

	case 'listar_detalle_por_requerimiento':

		$id_requerimiento = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";

		$array = array();
		$rspta = $soporte->listar_detalles($id_requerimiento, $_SESSION['persona_id']);

		while ($reg = $rspta->fetch_object()) {
			//	$personas_asignadas =  explode(",", $reg->asignados);
			$data[] = array(
				"id_detalle_requerimiento" => $reg->id_detalle_requerimiento,
				"id_requerimiento" => $reg->id_requerimiento,
				"fecha_plazo" => $reg->fecha_plazo,
				"nro_reprogramado" => $reg->nro_reprogramado,
				"id_usuario" => $reg->id_usuario,
				"id_catalogo" => $reg->id_catalogo,
				"id_subcatalogo" => $reg->id_subcatalogo,
				"detalle_rq" => $reg->detalle_rq,
				"estado" => $reg->estado,
				"contacto_entrega" => $reg->contacto_entrega,
				"n_ad_oc" => $reg->n_ad_oc,
				"estado_firma" => $reg->estado_firma,
				"notificado" => $reg->notificado,
				"tipo_registro" => $reg->tipo_registro,
				"direccion_entrega" => $reg->direccion_entrega,
				"notifica_terminado" => $reg->notifica_terminado,
				"id_persona" => $reg->id_persona,
				"nombre_catalogo" => $reg->nombre_catalogo,
				"nombre_subcatalogo" => $reg->nombre_subcatalogo,
				"asignados" => $reg->asignados,
				"estadoDesc" => $reg->estadoDesc,
				"opciones" => ($reg->estado == 4) ? '<button class="btn btn-secondary btn-sm mt-2" data-toggle="tooltip" data-placement="bottom" title="Anulado" disabled><i class="fa fa-trash"></i></button> ' :
					'<button class="btn btn-danger btn-sm mt-2" data-toggle="modal" data-target="#ModalAnular" onclick="abrirModalAnular(' . $reg->id_requerimiento . ',' . $reg->id_detalle_requerimiento . ')" data-toggle="tooltip" data-placement="bottom" title="Anular RQ"><i class="fa fa-trash"></i></button> '
			);
		}

		if ($rspta != "") {
			$array = array(
				"status" => true,
				"data" => $data,
				"ico" => "success",
				"msg" => "ok!"
			);
		} else {
			$array = array(
				"status" => false,
				"data" => 0,
				"ico" => "error",
				"msg" => "No se cargo la información!"

			);
		}
		echo json_encode($array);
		break;

	case 'listar_detalles_requerimientos':

		$id_origen = isset($_GET["id"]) ? limpiarCadena($_GET["id"]) : "";

		$fecha_inicio = isset($_GET["fdesde"]) ? limpiarCadena($_GET["fdesde"]) : "";
		$fecha_fin = isset($_GET["fhasta"]) ? limpiarCadena($_GET["fhasta"]) : "";
		$servicio = isset($_GET["fservicio"]) ? limpiarCadena($_GET["fservicio"]) : "";
		$asignado = isset($_GET["fasignado"]) ? limpiarCadena($_GET["fasignado"]) : "";
		$estado = isset($_GET["festado"]) ? limpiarCadena($_GET["festado"]) : "";
		$persona = $_SESSION['persona_id'];
		$data = array();

		$rspta = $soporte->soporte_persona_detalle_listar($fecha_inicio, $fecha_fin, $id_origen, $estado, $persona, $servicio, $asignado);

		$data = array();
		while ($reg = $rspta->fetch_object()) {

			$data[] = array(
				"0" => $reg->Id_detalle_requerimiento,
				"1" => $reg->ServicioNombre,
				"2" => $reg->fecha_registro,
				"3" => $reg->fecha_plazo,
				"4" => $reg->fecha_propuesta,
				"5" => $reg->fecha_termino,
				"6" => ($reg->NumeroReprogramacion != "0") ? ' <span  class="badge badge-dark " style="font-size:15px;cursor:pointer;"  data-toggle="modal" data-target="#modalreprogramacion"  onclick="listar_reprogramaciones(' . $reg->Id_detalle_requerimiento . ')" data-toggle="tooltip" data-placement="top" title="Historial" >' . $reg->NumeroReprogramacion . '</span>' : '<span  class="badge badge-dark " style="font-size:15px;cursor:pointer;">' . $reg->NumeroReprogramacion . '</span>',
				"7" => $reg->UltimaReprogramacion,
				"8" => $reg->usuario,
				"9" => $reg->Asignado,
				"10" => $reg->depende_de,
				"11" => $reg->Delegado,
				"12" => $reg->centro_utilidad,
				"13" => $reg->centro_costo,
				"14" => $reg->sede,
				//"15"=>$reg->detalle_rq,
				//  "15" => ($reg->detalle_corto != "") ? '<span data-toggle="tooltip" data-placement="left" data-html="true" title="' . $reg->detalle_rq . '">' . $reg->detalle_corto . '</span>' : '',
				"16" => $reg->detalle_rq,
				"17" => $reg->Prioridad,
				"18" => $reg->estadoDesc,
				"19" => ($reg->estado == 4) ? '<button class="btn btn-secondary btn-sm mt-2"  data-toggle="tooltip" data-placement="bottom" title="Anulado" disabled><i class="fa fa-trash"></i></button> ' :
					'<button class="btn btn-danger btn-sm mt-2" data-toggle="modal" data-target="#ModalAnular" onclick="abrirModalAnular(' . $reg->id_requerimiento . ',' . $reg->Id_detalle_requerimiento . ')" data-toggle="tooltip" data-placement="bottom" title="Anular RQ"><i class="fa fa-trash"></i></button> '
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;

	case 'anular_requerimiento':
		$array = array();
		$id_requerimiento = isset($_POST["id_requerimiento"]) ? limpiarCadena($_POST["id_requerimiento"]) : 0;
		$id_detalle_requerimiento = isset($_POST["id_detalle_requerimiento"]) ? limpiarCadena($_POST["id_detalle_requerimiento"]) : 0;
		$comentario = isset($_POST["comentario"]) ? limpiarCadena($_POST["comentario"]) : "";

		if ($id_detalle_requerimiento == 0) {
			$rspta = $soporte->anular_requerimiento($id_requerimiento,  0/*sin usuario */, $comentario, $_SESSION['persona_id']);
			if (!empty($rspta)) {
				$array = array(
					"status" => true,
					"IdRetorno" => $rspta["id_requerimiento"],
					"ico" => "success",
					"msg" => "Se anulo el requerimiento."
				);
			} else {
				$array = array(
					"status" => false,
					"IdRetorno" => 0,
					"ico" => "error",
					"msg" => "No se pudo anular el requerimiento."
				);
			}
		} else if ($id_detalle_requerimiento > 0) {

			$rspta = $soporte->anular_requerimiento_detalle($id_detalle_requerimiento, 0/*sin usuario */, $comentario, $_SESSION['persona_id'], 2);
			if (!empty($rspta)) {
				$array = array(
					"status" => true,
					"IdRetorno" => $rspta["id_requerimiento_detalle"],
					"ico" => "success",
					"msg" => "Se anulo el detalle del requerimiento."
				);
			} else {
				$array = array(
					"status" => false,
					"IdRetorno" => 0,
					"ico" => "error",
					"msg" => "No se pudo anular el detalle del requerimiento."
				);
			}
		}

		echo json_encode($array);

		break;

	case 'mostrar_requerimiento':

		$id_requerimiento = isset($_POST["id_requerimiento"]) ? limpiarCadena($_POST["id_requerimiento"]) : "";

		$array = array();
		$rspta = $soporte->mostrar_requerimiento($id_requerimiento);

		if (!empty($rspta)) {
			$array = array(
				"status" => true,
				"data" => $rspta,
				"ico" => "success",
				"msg" => "ok!"
			);
		} else {
			$array = array(
				"status" => false,
				"data" => 0,
				"ico" => "error",
				"msg" => "No se cargo la información!"

			);
		}
		echo json_encode($array);
		break;

	case 'activar':

		$id_detalle_requerimiento = isset($_POST["id_detalle_requerimiento"]) ? limpiarCadena($_POST["id_detalle_requerimiento"]) : "";

		$array = array();
		$rspta = $soporte->activar($id_detalle_requerimiento);

		if ($rspta["id_detalle_requerimiento"] > 0) {
			$array = array(
				"status" => true,
				"IdRetorno" => $rspta["id_detalle_requerimiento"],
				"ico" => "success",
				"msg" => "detalle activado con exito!"
			);
		} else {
			$array = array(
				"status" => false,
				"IdRetorno" => 0,
				"ico" => "error",
				"msg" => "Error al activar detalle!"

			);
		}
		echo json_encode($array);
		break;

	case 'desactivar':

		$id_detalle_requerimiento = isset($_POST["id_detalle_requerimiento"]) ? limpiarCadena($_POST["id_detalle_requerimiento"]) : "";

		$array = array();

		$rspta = $soporte->desactivar($id_detalle_requerimiento);

		if ($rspta["id_detalle_requerimiento"] > 0) {
			$array = array(
				"status" => true,
				"IdRetorno" => $rspta["id_detalle_requerimiento"],
				"ico" => "success",
				"msg" => "detalle desactivado con exito!"
			);
		} else {
			$array = array(
				"status" => false,
				"IdRetorno" => 0,
				"ico" => "error",
				"msg" => "Error al desactivar detalle!"

			);
		}
		echo json_encode($array);
		break;

	case 'eliminar_requerimientos_vacios':

		$id_requerimiento = isset($_POST["id_requerimiento"]) ? limpiarCadena($_POST["id_requerimiento"]) : "";

		$array = array();

		$rspta = $soporte->eliminar_requerimientos_vacios($id_requerimiento);

		if (!empty($rspta)) {
			$array = array(
				"status" => true,
				"IdRetorno" => $rspta["id_requerimiento"],
				"ico" => "success",
				"msg" => "Se elimino el requerimiento con exito."
			);
		} else {
			$array = array(
				"status" => false,
				"IdRetorno" => 0,
				"ico" => "error",
				"msg" => "No se pudo eliminar el requerimiento."

			);
		}
		echo json_encode($array);
		break;

	case "select_personas_asignar":
		$option = "";
		$array = array();
		$rspta = $soporte->select_personas_asignar();
		$option .= '<option value="0" selected>TODOS</option>';
		while ($reg = $rspta->fetch_object()) {
			$option .= '<option value="' . $reg->id_persona . '">' . $reg->nombre . '</option>';
		}
		$array = array(
			"status" => true,
			"html" => $option
		);
		echo json_encode($array);
		break;
}
ob_end_flush();
