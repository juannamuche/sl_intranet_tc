<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Soporte
{

	//Implementamos nuestro constructor
	public function __construct()
	{
	}


	public function login_soporte($dni, $telefono)
	{
		$sql = "select * from tb_persona where dni='$dni' and (celular_trabajo='$telefono' OR celular_personal='$telefono')";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function select_centro_utilidad()
	{
		$sql = "CALL sp_centro_utilidad_select();";
		return ejecutarConsulta($sql);
	}

	public function select_centro_costo($id_centro_utilidad)
	{
		$sql = "CALL sp_centro_costo_select2($id_centro_utilidad);";
		return ejecutarConsulta($sql);
	}

	public function select_sede($id_centro_costo)
	{
		$sql = "CALL sp_sede_select($id_centro_costo);";
		return ejecutarConsulta($sql);
	}

	public function select_catalogo_soporte()
	{
		$sql = "SELECT * FROM tb_catalogo WHERE id_catalogo=87 or id_catalogo=121;";
		return ejecutarConsulta($sql);
	}

	public function select_subcatalogo_soporte($id_catalogo)
	{
		$sql = "SELECT * FROM tb_sub_catalogo WHERE idcatalogo=$id_catalogo AND estado=1;";
		return ejecutarConsulta($sql);
	}

	public function insertar_requerimiento($importancia, $id_cu, $id_cc, $id_sede, $origen)
	{
		$sql = "CALL sp_requerimiento_insertar('$importancia',$id_cu,$id_cc,$id_sede,$origen);";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function validar_requerimiento($id_requerimiento)
	{
		$sql = "SELECT COUNT(*) AS total_detalles FROM tb_detalle_requerimiento WHERE id_requerimiento=$id_requerimiento;";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function insertar_detalle_requerimiento($id_requerimiento, $catalogo, $subcatalogo, $detalle, $plazo, $idpersona,$tipo,$asignado,$urgente,$comentariourgente,$tiposolicitante, $persona_contacto, $contacto_externo, $telefono_contacto, $correo_contacto)
	{
		$sql = "CALL sp_soporte_requerimiento_detalle_insertar($id_requerimiento,$catalogo,$subcatalogo,'$detalle','$plazo',$idpersona,$tipo,$asignado,$urgente,'$comentariourgente',$tiposolicitante,$persona_contacto,'$contacto_externo','$telefono_contacto','$correo_contacto');";
		//var_dump($sql);die();
		return ejecutarConsultaSimpleFila($sql);
	}

	public function GuardarArchivo($idrequerimiento, $archivo, $name_archivo, $id_detalle_requerimiento)
	{
		$sql = "CALL sp_logistico_guardar_archivos($idrequerimiento,'$archivo','$name_archivo',$id_detalle_requerimiento)";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listar_requerimiento_detalle($id_requerimiento)
	{
		$sql = "CALL sp_logistico_requerimiento_detalle_listar($id_requerimiento)";
	//	var_dump($sql);die();
		return ejecutarConsulta($sql);
	}

	public function listar_requerimientos($fecha_inicio, $fecha_fin, $origen, $estado, $persona, $servicio,$asignado)
	{
		$sql = "CALL sp_soporte_persona_listar_requerimiento_agrupado('$fecha_inicio','$fecha_fin',$origen,'$estado',$persona,'$servicio','$asignado')";
		//var_dump($sql);die();
		return ejecutarConsulta($sql);
	}

	public function listar_detalles($id_requerimiento, $persona)
	{
		$sql = "CALL sp_soporte_persona_listar_requerimientos_detalles($id_requerimiento,$persona)";
		//var_dump($sql);die();
		return ejecutarConsulta($sql);
	}

	public function soporte_persona_detalle_listar($fecha_inicio, $fecha_fin, $origen, $estado, $persona, $servicio,$asignado)
	{
		$sql = "CALL sp_soporte_persona_detalle_listar('$fecha_inicio','$fecha_fin',$origen,'$estado',$persona,'$servicio','$asignado')";
//var_dump($sql);die();
		return ejecutarConsulta($sql);
	}

	public function anular_requerimiento($id_requerimiento, $usuario, $comentario,$persona)
	{
		$sql = "CALL sp_logistico_requerimiento_anular($id_requerimiento,$usuario,'$comentario',$persona)";

		return ejecutarConsultaSimpleFila($sql);
	}

	public function anular_requerimiento_detalle($id_requerimiento_detalle, $usuario, $comentario,$persona,$rol)
	{
		$sql = "CALL sp_logistico_requerimiento_detalle_anular($id_requerimiento_detalle,$usuario,'$comentario',$persona,$rol)";

		return ejecutarConsultaSimpleFila($sql);
	}

	public function mostrar_requerimiento($id_requerimiento)
	{
		$sql = "CALL sp_logistico_requerimiento_mostrar($id_requerimiento);";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function activar($id_detalle_requerimiento)
	{
		$sql = "CALL sp_logistico_requerimiento_detalle_estado($id_detalle_requerimiento,'1')";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function desactivar($id_detalle_requerimiento)
	{
		$sql = "CALL sp_logistico_requerimiento_detalle_estado($id_detalle_requerimiento,'0')";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function eliminar_requerimientos_vacios($id_requerimiento)
	{
		$sql = "CALL sp_requerimiento_eliminar_vacios($id_requerimiento)";
		return ejecutarConsultaSimpleFila($sql);
	
	}

	public function obtener_asignado($catalogo)
	{
		$sql="CALL sp_soporte_persona_asignada($catalogo)"; 
	//	var_dump($sql);die();
	//	$sql = "select max(r.id_requerimiento) as id_requerimiento,drp.id_persona_asignada,p.nombre from tb_det_req_persona drp join tb_detalle_requerimiento dr on dr.Id_detalle_requerimiento=drp.Id_detalle_requerimiento  JOIN tb_requerimiento r on r.id_requerimiento=dr.id_requerimiento join tb_persona p on drp.id_persona_asignada= p.id_persona where dr.id_origen=15 and dr.id_catalogo=87 ;";
		return ejecutarConsultaSimpleFila($sql);
	}
	
	public function select_personas_asignar(){
		$sql = "select p.id_persona,p.nombre from tb_persona p inner join tb_usuario u on u.id_persona=p.id_persona inner join tb_modulo_usuario mu on mu.id_usuario=u.id_usuario where mu.IdModulo=13 and mu.IdRol=9";
		return ejecutarConsulta($sql);
	}

	public function select_solicitante()
	{
		$sql = "select * from tb_persona where estado=1";
		return ejecutarConsulta($sql);
	}

	public function datosSolicitante($id)
	{
		$sql = "select * from tb_persona where id_persona=$id";
		return ejecutarConsultaSimpleFila($sql);
	}

	
}
