<?php
session_start();
header('Cache-Control: no cache');
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//llega desde la plantilla, si no tiene valor es igual a listar
require_once('model/vista_calendario_model.php');


$Ob_evento=new vista_calendario();


if(isset($_REQUEST['calendar']))
{
	$conex_lectura=new base();
	$conectado=$conex_lectura->conectar_base(_host,_user_base_lectura,_pass_base_lectura,_nom_base);
	
	# definimos los valores iniciales para nuestro calendario
		$mes=date("n");
		$anio=date("Y");
		$hoy=date("j");
				
		$fecha_actual=$anio;
		$fecha_actual.="-";
		if($mes < 10)
		{
			$fecha_actual.=0;
		}
		$fecha_actual.=$mes;
		$fecha_actual.="-";
		if($hoy < 10)
		{
			$fecha_actual.=0;
		}
		$fecha_actual.=$hoy;
				 
		$meses=array(1=>"January", "February", "March", "April", "May", "Jun", "July", "August", "September", "October", "November", "December");
	
	
		switch ($_REQUEST['m']) {
					
			case "listar":
			
				//Listar CALENDARIO IELTS------------------------------------------
				
				if($_REQUEST['m2'] == 'ielts')
				{
					$centro_id=explode("-", $_REQUEST['calendar']);
					$centro_id[1]=$_REQUEST['testCentreLocationId'];
					$centro=implode("-", $centro_id);
					
					
					require_once($template_ruta.'calendarios_ver.phtml');
				}
else if($_REQUEST['m2'] == 'ielts-internacional')
				{
					$centro_id=explode("-", $_REQUEST['calendar']);
					$centro_id[1]=$_REQUEST['testCentreLocationId'];
					$centro=implode("-", $centro_id);
					
					
					require_once($template_ruta.'calendarios_ver_internacional.phtml');
				}
				
				//Listar CALENDARIO RENERAL------------------------------------------
				
				else if($_REQUEST['m2'] == 'general')
				{
					require_once($template_ruta.'calendarios_ver_general.phtml');
				}

							
				break;
				
				//ENVIAR ***********************************************************
				
			case "enviar":
			
				//echo $_POST['url_destino'];
				$variables=array(
				"testCentreLocationId"=>$_POST['testCentreLocationId'],
				"testmoduleid"=>$_POST['testmoduleid'],
				"testCentreId"=>$_POST['testCentreId'],
				"testVenueId"=>$_POST['testVenueId']);
				//$Ob_evento->verificar_url($_POST['url_destino'], $variables);
				
				$Ob_evento->enviar_url($Ob_evento->verificar_url($_POST['url_destino'], $variables));
				
			break;
			
			//ENVIAR CRON ----------------------------------------------------------
			
			case "enviar_cron":
				/* 1 Sacar ids de los eventos del dia actual "activo" de la tabla EVENTOS_RECORDATORIOS 
				 * 2 Buscar en la tabla EVENTOS nombre, descripcion, mail_usuario_creador, mail_usuarios_permisos, lista_mails  segun id "activo"
				 * 3 enviar recordatorio por mail (TITULO EVENTO, DESCRIPCION, FECHA DEL EVENTO)
				 * 
				 * */
				$resultado=$conex_lectura->listar($conectado, 'EVENTOS_RECORDATORIOS', "ID");
				$conex_lectura->cerrar();
				
				 
			break;
		} //FIN SWITCH
} //FIN if(isset($_REQUEST['calendar']))
else
{
	echo "Contenido sin mostrar";
}

?>
