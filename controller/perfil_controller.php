<?php
error_reporting(0);
//llega desde la plantilla, si no tiene valor es igual a listar
require_once('model/'.$controlador.'_model.php');
if(!isset($_REQUEST['m']))
{
	$metodo="listar";
}
else
{
	$metodo=$_REQUEST['m'];
}

switch ($metodo) {
				
		//EDITAR ***********************************************************
		
	case "editar":
		//echo "EDITAR DATOS <br>";
		
		$tabla="USUARIOS";
		
		$columna="ID";
		$parametro=$_SESSION['session_id_usuario'];
		$resultado=$conex->buscar2($tabla, $columna, $parametro);
		
			if(isset($_REQUEST['guardar_editar'])) {
			
			if(empty($_REQUEST['CONTRASENA']))
			{
				$datos=array("NOMBRE" => $_REQUEST['NOMBRE'],
				"APELLIDOS" => $_REQUEST['APELLIDOS'],
				"CEDULA" => $_REQUEST['CEDULA'],
				"MAIL" => $_REQUEST['MAIL']);
			}
			else
			{
				$contrasena=password_hash($_REQUEST['CONTRASENA'], PASSWORD_DEFAULT);
				$datos=array("NOMBRE" => $_REQUEST['NOMBRE'],
				"APELLIDOS" => $_REQUEST['APELLIDOS'],
				"CEDULA" => $_REQUEST['CEDULA'],
				"MAIL" => $_REQUEST['MAIL'], 
				"CONTRASENA" => $contrasena);
			}
			if($conex->actualizar("USUARIOS", 'ID', $_REQUEST['ID'], $datos))
			{
				//Envio de mail al usuario creado
				
					$url_aplicacion=$hostname;
					$url_aplicacion.='/pagos';
					$envio=new perfil();
					$envio->mail_confirm($_REQUEST['MAIL'], 'Cuenta Pagos Multilingua', $_REQUEST['MAIL'], $_REQUEST['CONTRASENA'], $url_aplicacion);
				
				//envio mail
				$conex->cerrar();
				$titulo="Buen trabajo";
				$mensaje= "Acci&oacute;n realizada correctamente";
				
			}
			else
			{
				$conex->cerrar();
				$titulo="Verifique las siguientes recomendaciones";
				$mensaje= "El usuario que est&aacute; actualizando con el titulo<b>".$_REQUEST['CEDULA']."</b> contiene un error, revise los campos para corregir la informaci&oacute;n.";
				
			}
			require($template_ruta.'respuesta.phtml');
		}
		
		else
		{
			require_once($template_ruta.'perfil_editar.phtml');
		}
			
		break;
		
	case "salir":
		session_destroy();
		require_once($template_ruta.'session_login.phtml');
		break;
		
}
?>
