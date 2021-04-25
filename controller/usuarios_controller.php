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
	
		//LISTAR ***********************************************************
	
	case "listar":
		//echo "LISTAR DATOS <br>";
		
		if(!isset($_REQUEST['orden']))
		{
			$orden="ID";
		}
		else{
			$orden=$_REQUEST['orden'];
		}
		$orden.=" ASC";
		$resultado=$conex->listar($conexion, 'USUARIOS', $orden);
		require_once($template_ruta.'usuarios_listar.phtml');
		
		break;
		
		//INSERTAR ***********************************************************
		
	case "insertar":
		//echo "INSERTAR DATOS <br>";
		if(isset($_REQUEST['guardar'])) {
			//echo "GUARDANDO DATOS";
			//ordenando permisos
			$permiso="";
			$menu="";
			foreach($menu_header as $c => $m)
			{
				//$permiso.=$c;
				//$permiso.="/";
				foreach($_REQUEST as $co => $me)
				{
					$con=explode("_",$co);
					if($con[0]==$c)
					{
						$permiso.=$me;
						$permiso.=",";
						$menu.=$con[0];
						$menu.=",";
					}
					
				}
			
			}
			$menu.="perfil,perfil";
			$permiso.="editar,salir";
			//fin ordenar permisos
			
			//Envio de mail al usuario creado
			$url_aplicacion=$hostname;
			$url_aplicacion.='/pagos';
			$envio=new usuarios();
			$envio->mail_confirm($_REQUEST['MAIL'], 'Cuenta Pagos Multilingua', $_REQUEST['MAIL'], $_REQUEST['CONTRASENA'], $url_aplicacion);
			
			//envio mail
			
			// generar contraseña
			
			$contrasena=password_hash($_REQUEST['CONTRASENA'], PASSWORD_DEFAULT);
			
			//fin generar contraseña
					
			$datos=array("MENU" => $menu,
			"PERMISOS" => $permiso,	
			"NOMBRE" => $_REQUEST['NOMBRE'],
			"APELLIDOS" => $_REQUEST['APELLIDOS'],
			"CEDULA" => $_REQUEST['CEDULA'],
			"MAIL" => $_REQUEST['MAIL'], 
			"CONTRASENA" => $contrasena,
			"ESTADO" => $_REQUEST['ESTADO']);
				
			if($conex->insertar("USUARIOS",$datos))
			{
				$conex->cerrar();
				$titulo="Buen trabajo";
				$mensaje= "Acci&oacute;n realizada correctamente";
				
			}
			else
			{
				$conex->cerrar();
				$titulo="Verifique las siguientes recomendaciones";
				$mensaje= "El usuario que esta creando con documento <b>".$_REQUEST['CEDULA']."</b> ya existe, verifique los datos nuevamente.";
				
			}
			require($template_ruta.'respuesta.phtml');
		}
		else {
			//$permisos=new usuarios();
			//$permisos->permisos_vista($menu_header);
			require_once($template_ruta.'usuarios_crear.phtml');
		}
		break;
		
		//EDITAR ***********************************************************
		
	case "editar":
		//echo "EDITAR DATOS <br>";
			
			if(!isset($_REQUEST['orden']))
				{
					$orden="ID";
				}
		else{
			$orden=$_REQUEST['orden'];
			}
		$orden.=" ASC";
		$resultado=$conex->listar($conexion, 'USUARIOS', $orden);
			
			if(isset($_REQUEST['guardar_editar'])) {
			echo "ACTUALIZANDO DATOS usuarios";
			
			$permiso="";
			$menu="";
			foreach($menu_header as $c => $m)
			{
				//$permiso.=$c;
				//$permiso.="/";
				foreach($_REQUEST as $co => $me)
				{
					$con=explode("_",$co);
					if($con[0]==$c)
					{
						$permiso.=$me;
						$permiso.=",";
						$menu.=$con[0];
						$menu.=",";
					}
					
				}
			
			}
			$menu.="perfil,perfil";
			$permiso.="editar,salir";
			//fin ordenar permisos
			$url_aplicacion=$hostname;
			$url_aplicacion.='/pagos';
			$envio=new usuarios();
			$envio->mail_confirm($_REQUEST['MAIL'], 'Cuenta Pagos Multilingua', $_REQUEST['MAIL'], $_REQUEST['CONTRASENA'], $url_aplicacion);
			// generar contraseña
			if(empty($_REQUEST['CONTRASENA']))
			{
				$datos=array("MENU" => $menu,
				"PERMISOS" => $permiso,	
				"NOMBRE" => $_REQUEST['NOMBRE'],
				"APELLIDOS" => $_REQUEST['APELLIDOS'],
				"CEDULA" => $_REQUEST['CEDULA'],
				"MAIL" => $_REQUEST['MAIL'], 
				"ESTADO" => $_REQUEST['ESTADO']);
				
			}
			else
			{
				$contrasena=password_hash($_REQUEST['CONTRASENA'], PASSWORD_DEFAULT);
				$datos=array("MENU" => $menu,
				"PERMISOS" => $permiso,	
				"NOMBRE" => $_REQUEST['NOMBRE'],
				"APELLIDOS" => $_REQUEST['APELLIDOS'],
				"CEDULA" => $_REQUEST['CEDULA'],
				"MAIL" => $_REQUEST['MAIL'], 
				"CONTRASENA" => $contrasena,
				"ESTADO" => $_REQUEST['ESTADO']);
			}
			//fin generar contraseña
									
			if($conex->actualizar("USUARIOS", 'ID', $_REQUEST['ID'], $datos))
			{
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
		else if(isset($_REQUEST['editar_form']))
		{
			require_once($template_ruta.'usuarios_editar_form.phtml');
		}
		else
		{
			require_once($template_ruta.'usuarios_editar.phtml');
		}
			
		break;
		
		//ELIMINAR ***********************************************************
		
	case "eliminar":
		//echo "ELIMINAR DATOS <br>";
					if(!isset($_REQUEST['orden']))
				{
					$orden="ID";
				}
		else{
			$orden=$_REQUEST['orden'];
			}
		$orden.=" ASC";
		$resultado=$conex->listar($conexion, 'USUARIOS', $orden);
			
			if(isset($_REQUEST['guardar_eliminar'])) {
			//echo "ELIMINANDO DATOS";
			
			$cont=0;
			foreach ($_REQUEST as $indices => $valor) {
				$indice=explode("_", $indices);
				if ($indice[0] == 'ID')
			{
				$id[$cont]=$valor;
				$cont+=1;
			}
			
			}
				
			if($conex->eliminar('USUARIOS', $id))
			{
				$conex->cerrar();
				$titulo="Buen trabajo";
				$mensaje= "Elemento eliminado correctamente";
				
			}
			else
			{
				$conex->cerrar();
				$titulo="Verifique las siguientes recomendaciones";
				$mensaje= "No es posible eliminar alguno de los elementos, porfavor recargue la pagina e intentelo de nuevo, ó inicie sesión nuevamente";
				
			}
			require($template_ruta.'respuesta.phtml');
		}
		
		else
		{
			require_once($template_ruta.'usuarios_eliminar.phtml');
		}
		
		break;
		
}
?>
