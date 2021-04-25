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
		
		$resultado=$conex->listar($conexion, 'PRODUCTOS', $orden);
		$conex->cerrar();
		require_once($template_ruta.'productos_listar.phtml');
		
		break;
		
		//INSERTAR ***********************************************************
		
	case "insertar":
		//echo "INSERTAR DATOS <br>";
		if(isset($_REQUEST['guardar'])) {
			echo "GUARDANDO DATOS";
			
			//creando la URL
			$boton= new botones($_REQUEST['TITULO'], " ");
			$nombre_pasarela=$boton->limpiarUrl();
			$url=$boton->imagenBoton();
			//fin creando la URL
			
			$datos=array("IMAGEN" => $_REQUEST['IMAGEN'],	
			"TITULO" => $_REQUEST['TITULO'],
			"DESCRIPCION" => $_REQUEST['DESCRIPCION'],
			"PRECIO" => $_REQUEST['PRECIO'],
			"URL" => $url, 
			"NOMBRE_PASARELA" => $nombre_pasarela,
			"ACTIVO" => $_REQUEST['ACTIVO'],
			"GRUPO" => $_REQUEST['GRUPO']);
				
			if($conex->insertar("PRODUCTOS",$datos,$conexion))
			{
				$conex->cerrar();
				$titulo="Buen trabajo";
				$mensaje= "Acci&oacute;n realizada correctamente";
				
			}
			else
			{
				$conex->cerrar();
				$titulo="Verifique las siguientes recomendaciones";
				$mensaje= "El producto que esta creando con el nombre <b>".$_REQUEST['TITULO']."</b> ya existe, cambie el t&iacute;tulo o ponga al final un n&uacute;mero para identificarlo";
				
			}
			require($template_ruta.'respuesta.phtml');
		}
		else {
			require_once($template_ruta.'productos_crear.phtml');
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
		
		$resultado=$conex->listar($conexion, 'PRODUCTOS', $orden);
			
			if(isset($_REQUEST['guardar_editar'])) {
			echo "ACTUALIZANDO DATOS";
			
			//creando la URL
			$boton= new botones($_REQUEST['TITULO'], " ");
			$nombre_pasarela=$boton->limpiarUrl();
			$url=$boton->imagenBoton();
			//fin creando la URL
			
			$datos=array("IMAGEN" => $_REQUEST['IMAGEN'],	
			"TITULO" => $_REQUEST['TITULO'],
			"DESCRIPCION" => $_REQUEST['DESCRIPCION'],
			"PRECIO" => $_REQUEST['PRECIO'],
			"URL" => $url, 
			"NOMBRE_PASARELA" => $nombre_pasarela,
			"ACTIVO" => $_REQUEST['ACTIVO'],
			"GRUPO" => $_REQUEST['GRUPO']);
			$id=$_REQUEST['ID'];
				
			if($conex->actualizar("PRODUCTOS", 'ID', $id, $datos))
			{
				$conex->cerrar();
				$titulo="Buen trabajo";
				$mensaje= "Acci&oacute;n realizada correctamente";
				
			}
			else
			{
				$conexion->cerrar();
				$titulo="Verifique las siguientes recomendaciones";
				$mensaje= "El producto que est&aacute; actualizando con el nombre <b>".$_REQUEST['TITULO']."</b> contiene un t&iacutetulo duplicado &oacute; revise los campos para corregir la informaci&oacute;n, si desea cambiar este producto por uno similar, cambie el t&iacute;tulo o ponga al final un n&uacute;mero para identificarlo";
				
			}
			require($template_ruta.'respuesta.phtml');
		}
		else if(isset($_REQUEST['editar_form']))
		{
			require_once($template_ruta.'productos_editar_form.phtml');
		}
		else
		{
			require_once($template_ruta.'productos_editar.phtml');
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
		
		$resultado=$conex->listar($conexion, 'PRODUCTOS', $orden);
			
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
			
			if($conex->eliminar('PRODUCTOS', $id))
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
			require_once($template_ruta.'productos_eliminar.phtml');
		}
		
		break;
		
		//CREAR BOTON ***************************************************
		
		case "boton":
			//echo "CREAR BOTON <br>";
					if(!isset($_REQUEST['orden']))
				{
					$orden="ID";
				}
		else{
			$orden=$_REQUEST['orden'];
			}
		
		
			
			if(isset($_REQUEST['guardar_crear_boton'])) {
			//echo "CREANDO BOTON";
			
			$cont=0;
			foreach ($_REQUEST as $indices => $valor) {
				$indice=explode("_", $indices);
				if ($indice[0] == 'ID')
			{
				$result=$conex->buscar2('PRODUCTOS', 'ID', $valor);
				$titulos[$cont]=$result['TITULO'];
				$slugs[$cont]=$result['NOMBRE_PASARELA'];
				$cont+=1;
			}
			
			
			}
			$conex->cerrar();
			//creamos el objeto crear boton y enviamos el array $id con los slug
				$boton_web=new botones("","");
				$formulario=$boton_web->selectBoton($titulos, $slugs);
				
				$titulo='Bot&oacute;n agrupado fué Creado';
				$mensaje='Para utilizar el bot&oacute;n, seleccione y copie completamente el c&oacute;digo de la caja de texto, peguelo en el lugar de la p&aacute;gina web donde desea poner el bot&oacute;n';
				
				require_once($template_ruta.'productos_boton_mostrar.phtml');
			
				
				
				
			
			require($template_ruta.'respuesta.phtml');
		}
		
		else
		{
			$resultado=$conex->listar($conexion, 'PRODUCTOS', $orden);
			$conex->cerrar();
			require_once($template_ruta.'productos_boton_crear.phtml');
		}
		
			
		break;
}


/*
 * case "boton":
			//echo "CREAR BOTON <br>";	
			
			//comprobar si la variable GRUPO GET existe para crear el boton
			if(isset($_REQUEST['GRUPO']))
			{
				
				
				$columnas_mostrar="TITULO, NOMBRE_PASARELA";
				$columnas_grupos=$conex->buscar('PRODUCTOS',$columnas_mostrar, 'GRUPO', $_REQUEST['GRUPO']);
				
				$boton_web=new botones("","");
				$formulario=$boton_web->selectBoton($_REQUEST['GRUPO'], $columnas_grupos);
				
				$titulo='Bot&oacute;n para el grupo '.$_REQUEST['GRUPO'].' Creado';
				$mensaje='Para utilizar el bot&oacute;n, seleccione y copie completamente el c&oacute;digo de la caja de texto, peguelo en el lugar de la p&aacute;gina web donde desea poner el bot&oacute;n';
				
				require_once($template_ruta.'productos_boton_mostrar.phtml');
				
			}
			// FIN GRUPO GET
			
			else 
			{
			$columnas='GRUPO';
			$grupos=$conex->listar_columnas('DISTINCT', 'PRODUCTOS', $columnas);
			
			require_once($template_ruta.'productos_boton.phtml');
			}
			
		break;
		* */

?>
