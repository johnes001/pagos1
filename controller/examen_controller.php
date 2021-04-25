<?php
error_reporting(1);
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
	
		
				
		//INSERTAR ***********************************************************
		
	case "crear-examen":
		
		if(isset($_REQUEST['guardar'])) {
			echo "GUARDANDO DATOS";
			
			
			$datos=array("nombre" => $_REQUEST['NOMBRE'],	
			"editor" => $_REQUEST['EDITOR'],
			"estado" => $_REQUEST['ACTIVO']);
				
			if($conex->insertar("EXAMEN",$datos,$conexion))
			{
				$conex->cerrar();
				$titulo="Examen";
				$mensaje= "Se ha creado el Examen correctamente";
			}
			else
			{
				$conex->cerrar();
				$titulo="Verifique las siguientes recomendaciones";
				$mensaje= "El Examen que está creando con el nombre <b>".$_REQUEST['NOMBRE']."</b> ya existe, cambie el Nombre o ponga al final un n&uacute;mero para identificarlo";
				
			}
			
			require($template_ruta.'respuesta.phtml');
		}
		else {
			
			require_once($template_ruta.'examen_crear.phtml');
		}
		break;
		
		//EDITAR ***********************************************************
		
	case "editar-examen":
			
			if(!isset($_REQUEST['orden']))
				{
					$orden="ID";
				}
		else{
			$orden=$_REQUEST['orden'];
			}
		
		$resultado=$conex->listar($conexion, 'EXAMEN', $orden);
			
			if(isset($_REQUEST['guardar_editar'])) {
			echo "ACTUALIZANDO DATOS";
			
			
			$datos=array("nombre" => $_REQUEST['NOMBRE'],	
			"editor" => $_REQUEST['EDITOR'],
			"estado" => $_REQUEST['ESTADO']);
			$id=$_REQUEST['ID'];
				
			if($conex->actualizar("EXAMEN", 'ID', $id, $datos))
			{
				$conex->cerrar();
				$titulo="Examen actualizado";
				$mensaje= "La información se ha actualizado correctamente.";
				
			}
			else
			{
				$conexion->cerrar();
				$titulo="Verifique las siguientes recomendaciones";
				$mensaje= "El Examen que est&aacute; actualizando con el nombre <b>".$_REQUEST['NOMBRE']."</b> contiene un Nombre duplicado &oacute; revise los campos para corregir la informaci&oacute;n, si desea cambiar este Calendario por uno similar, cambie el Nombre o ponga al final un n&uacute;mero para identificarlo";
				
			}
			require($template_ruta.'respuesta.phtml');
		}
		else if(isset($_REQUEST['editar_form']))
		{
			$propietarios=$conex->listar_columnas('DISTINCT', 'USUARIOS', 'MAIL');
			$conex->cerrar();
			require_once($template_ruta.'examen_editar_form.phtml');
		}
		else
		{
			require_once($template_ruta.'examen_editar.phtml');
		}
		
		
		// LISTAR IELTS-----------------------------------------------
		
		if($_REQUEST['m2'] == "ielts")
		{
			
			
			$Ob_evento=new vista_calendario();
			
			if(isset($_REQUEST['calendar']))
			{
				
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
						 
						$meses=array(1=>"January", "February", "March", "April", "May", "Jun", "July",
						"August", "September", "October", "November", "December");
						
						require_once($template_ruta.'vista_previa_calendario.phtml');				
				
			
			} //FIN if(isset($_REQUEST['calendar']))
			else
			{
				echo "Contenido sin mostrar";
			}

			
		}
		
			
		break;
		
		//ELIMINAR ***********************************************************
		
	case "eliminar":
		
					if(!isset($_REQUEST['orden']))
				{
					$orden="ID";
				}
		else{
			$orden=$_REQUEST['orden'];
			}
		
		$resultado=$conex->listar($conexion, 'CALENDARIOS', $orden);
			
			if(isset($_REQUEST['guardar_eliminar'])) {

			
			$cont=0;
			foreach ($_REQUEST as $indices => $valor) {
				$indice=explode("_", $indices);
				if ($indice[0] == 'ID')
			{
				$id[$cont]=$valor;
				$cont+=1;
			}
			
			}
				
			if($conex->eliminar('CALENDARIOS', $id))
			{
				$conex->cerrar();
				$titulo="Calendario(s) Eliminado(s)";
				$mensaje= "El/Los calendrio(s) se han eliminado correctamente.";
				
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
			require_once($template_ruta.'calendario_eliminar.phtml');
		}
		
		break;
		
		//LISTAR EVENTO***********************************************************
	
	case "listar-eventos":

		
		if(!isset($_REQUEST['orden']))
		{
			$orden="ID";
		}
		else{
			$orden=$_REQUEST['orden'];
		}
		
		$resultado=$conex->listar($conexion, 'EVENTOS', $orden);
		$conex->cerrar();
		require_once($template_ruta.'eventos_listar.phtml');
		
		break;
		
		//INSERTAR EVENTO***********************************************************
		
	case "crear-evento":
	
		if(isset($_REQUEST['guardar'])) {
			echo "GUARDANDO DATOS";
			$color_estado= "";
			$id_nombre_calendario=explode(",",$_REQUEST['CALENDARIO']);
			
			$color_estado= $_REQUEST['COLOR1'];
			$color_estado.=",";
			$color_estado.=$_REQUEST['COLOR2'];
			$datos=array("nombre" => $_REQUEST['NOMBRE'],	
			"descripcion" => $_REQUEST['DESCRIPCION'],
			"fecha_evento" => $_REQUEST['FECHA_EVENTO'],
			"mail_usuario_creador" =>$_REQUEST['USUARIO_CREADOR'],
			"mail_usuarios_permisos" => $_REQUEST['USUARIOS_PERMISOS'],
			"lista_mails" => $_REQUEST['LISTA_MAILS'],
			"id_calendario" => $id_nombre_calendario[0],
			"nombre_calendario" => $id_nombre_calendario[1],
			"activo" => $_REQUEST['ACTIVO'],
			"destino_url" => $_REQUEST['DESTINO_URL'],
			"color" => $color_estado,
			"fecha_inactivo" => $_REQUEST['FECHA_INACTIVO']);
			
			if($conex->insertar("EVENTOS",$datos,$conexion))
			{
				
				
				$titulo="Evento";
				$mensaje= "Se ha creado el evento correctamente";
				
				if(isset($_REQUEST['FECHA_RECORDATORIO']))
				{
					$id_evento=$conex->listar_columnas('DISTINCT', 'EVENTOS', 'ID,nombre,activo');
					
					while ($indice = mysqli_fetch_array($id_evento, MYSQL_ASSOC)) {
						if($indice['nombre'] == $_REQUEST['NOMBRE'])
						{
						//Agregar recordatorio
						$datos_recordar=array("id_eventos" => $indice['ID'],	
						"fecha_recordar" => $_GET['FECHA_RECORDATORIO'],
						"activo" => $indice['activo']);
						}
					}
					
					
					if($conex->insertar("EVENTOS_RECORDATORIO",$datos_recordar,$conexion))
					{
						
						$titulo.=" + Recordatorio";
						$mensaje.= " y se ha agregado un recordatorio para el día ".$_GET['FECHA_RECORDATORIO'];
					}
					else
					{
						$titulo.=" no se pudo insertar recordatorio";
					}
				
				}
				else
				{
					$titulo.=" fecha recordatorio no existe";
				}
				$conex->cerrar();
			}
			else
			{
				$conex->cerrar();
				$titulo="Verifique las siguientes recomendaciones";
				$mensaje= "El Evento que esta creando con el nombre <b>".$_REQUEST['NOMBRE']."</b> ya existe, cambie el Nombre o ponga al final un n&uacute;mero para identificarlo";
				
			}
			
			require($template_ruta.'respuesta.phtml');
		}
		else {
			$list_calendarios=$conex->listar_columnas('DISTINCT', 'CALENDARIOS', 'ID,nombre,activo');
			$conex->cerrar();
			require_once($template_ruta.'eventos_crear.phtml');
		}
		break;
		
	//EDITAR EVENTO***********************************************************
		
	case "editar-evento":
			
			if(!isset($_REQUEST['orden']))
				{
					$orden="ID";
				}
		else{
			$orden=$_REQUEST['orden'];
			}
		
		$resultado=$conex->listar($conexion, 'EVENTOS', $orden);
			
			if(isset($_REQUEST['guardar_editar'])) {
			echo "ACTUALIZANDO DATOS";
			
			$color_estado= "";
			$id_nombre_calendario=explode(",",$_REQUEST['CALENDARIO']);
			
			$color_estado= $_REQUEST['COLOR1'];
			$color_estado.=",";
			$color_estado.=$_REQUEST['COLOR2'];
			$datos=array("nombre" => $_REQUEST['NOMBRE'],	
			"descripcion" => $_REQUEST['DESCRIPCION'],
			"fecha_evento" => $_REQUEST['FECHA_EVENTO'],
			"mail_usuario_creador" =>$_REQUEST['USUARIO_CREADOR'],
			"mail_usuarios_permisos" => $_REQUEST['USUARIOS_PERMISOS'],
			"lista_mails" => $_REQUEST['LISTA_MAILS'],
			"id_calendario" => $id_nombre_calendario[0],
			"nombre_calendario" => $id_nombre_calendario[1],
			"activo" => $_REQUEST['ACTIVO'],
			"destino_url" => $_REQUEST['DESTINO_URL'],
			"color" => $color_estado,
			"fecha_inactivo" => $_REQUEST['FECHA_INACTIVO']);
				
			if($conex->actualizar("EVENTOS", 'ID', $_REQUEST['ID_EVENTO'], $datos))
			{
				$conex->cerrar();
				$titulo="Evento actualizado";
				$mensaje= "La información se ha actualizado correctamente.";
				
			}
			else
			{
				$conex->cerrar();
				$titulo="Verifique las siguientes recomendaciones";
				$mensaje= "El Evento que est&aacute; actualizando con el nombre <b>".$_REQUEST['NOMBRE']."</b> contiene un Nombre duplicado &oacute; revise los campos para corregir la informaci&oacute;n, si desea cambiar este evento por uno similar, cambie el Nombre o ponga al final un n&uacute;mero para identificarlo";
				
			}
			require($template_ruta.'respuesta.phtml');
		}
		else if(isset($_REQUEST['editar_form']))
		{
			
			$list_calendarios=$conex->listar_columnas('DISTINCT', 'CALENDARIOS', 'ID,nombre,activo');
			$conex->cerrar();
			require_once($template_ruta.'eventos_editar_form.phtml');
		}
		else if(isset($_GET['eliminar-recordatorio']))
		{
			//ELIMINAR recordatorio***********************************************************
		
									
				if($conex->eliminar('EVENTOS_RECORDATORIO', $_GET['id-recordatorio']))
				{
					$conex->cerrar();
					$titulo="Recordatorio";
					$mensaje= "El recordatorio se ha eliminado correctamente";
					require($template_ruta.'respuesta.phtml');
					
				}
				else
				{
					$conex->cerrar();
					$titulo="Verifique las siguientes recomendaciones";
					$mensaje= "No es posible eliminar alguno de los elementos, porfavor recargue la pagina e intentelo de nuevo, ó inicie sesión nuevamente";
					require($template_ruta.'respuesta.phtml');
				}
				
		}
		else if(isset($_GET['agregar-recordatorio-form']))
		{
			//AGREGAR  recordatorio***********************************************************

		
				$datos=array("id_eventos" => $_REQUEST['ID-EVENTO'],	
				"fecha_recordar" => $_REQUEST['FECHA_RECORDAR_EVENTO'],
				"activo" => $_REQUEST['ACTIVO_EVENTO']);
								
				if($conex->insertar('EVENTOS_RECORDATORIO',$datos,$conexion))
				{
					$conex->cerrar();
					$titulo="Recordatorio";
					$mensaje= "Se ha agregado un recordatorio al elvento.";
					
					
				}
				else
				{
					$conex->cerrar();
					$titulo="Verifique las siguientes recomendaciones";
					$mensaje= "No es posible agregar alguno de los elementos, porfavor recargue la pagina e intentelo de nuevo, ó inicie sesión nuevamente";
					
				}
					require($template_ruta.'respuesta.phtml');
				
		}
		//AGREGAR RECORDATORIO
		else if(isset($_GET['agregar-recordatorio']))
		{
			require_once($template_ruta.'recordatorio_crear.phtml');
		}
		//EDITAR RECORDATORIO
		else if(isset($_GET['editar-recordatorio-form']))
		{
				$datos=array("id_eventos" => $_REQUEST['ID-EVENTO'],	
				"fecha_recordar" => $_REQUEST['FECHA_RECORDAR_EVENTO'],
				"activo" => $_REQUEST['ACTIVO_EVENTO']);
			if($conex->actualizar("EVENTOS_RECORDATORIO", 'ID', $_GET['ID-RECORDATORIO'], $datos))
			{
				$conex->cerrar();
				$titulo="Recordatorio actualizado";
				$mensaje= "La información se ha actualizado correctamente.";
				
			}
			else
			{
				$conex->cerrar();
				$titulo="Verifique las siguientes recomendaciones";
				$mensaje= "El recordatorio que est&aacute; actualizando, presenta problemas, intentelo más tarde.";
				
			}
			require($template_ruta.'respuesta.phtml');
		}

		else if(isset($_GET['editar-recordatorio']))
		{
			require_once($template_ruta.'recordatorio_editar.phtml');
		}
		else
		{
			//$conexion->cerrar();
			require_once($template_ruta.'eventos_editar.phtml');
		}
			
		break;
	//ELIMINAR evento***********************************************************
		
		case "eliminar-evento":
			if(!isset($_REQUEST['orden']))
				{
					$orden="ID";
				}
			else{
					$orden=$_REQUEST['orden'];
				}
			
			$resultado=$conex->listar($conexion, 'EVENTOS', $orden);
			
				if(isset($_REQUEST['guardar_eliminar'])) {
				
				$cont=0;
				foreach ($_REQUEST as $indices => $valor) {
					$indice=explode("_", $indices);
					if ($indice[0] == 'ID')
					{
						$id[$cont]=$valor;
						$cont+=1;
					}
				
				}
					
				if($conex->eliminar('EVENTOS', $id))
				{
					
					//BUSCAR RECORDATORIOS QUE TENGAN id_eventos PARA ELIMINARLOS
					
					for($e=0; $e<count($id); $e++)
					{
						echo "dentro for <br>";
						if ($datos=$conex->buscar3('EVENTOS_RECORDATORIO', 'id_eventos', $id[$e]))
							{
								$acum=0;
																
								while ($indice = mysqli_fetch_array($datos, MYSQL_ASSOC)) 
								{
									
									foreach ($indice as $ind => $col_value) 
									{
										
										
										if($ind == "ID")
										{
											$ids_recordatorios[$acum]=$col_value;
											$acum+=1;
																					
										}
									}
									
								}
								if($conex->eliminar('EVENTOS_RECORDATORIO', $ids_recordatorios))
								{
									$titulo_recordatorios="<hr> Recordatorios asociados, también se han eliminado.";
								}
								else 
								{
									$titulo_recordatorios="<hr> ERROR INTERNO, no se han eliminado los recordatorios asociados ...";
								}
							}
					}
					
					$conex->cerrar();				
					$titulo="Evento(s) Eliminado(s)";
					$mensaje= "El/Los evento(s) se han eliminado correctamente.".$titulo_recordatorios;
					
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
				require_once($template_ruta.'eventos_eliminar.phtml');
			}
			
			break;
			
			
}




?>
