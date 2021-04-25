<?php
//error_reporting(0);
session_start();
require_once('model/base.php');
require_once('libs/config.php');
require_once('model/session_model.php');


if(isset($_REQUEST['c']))
{
	$controlador=$_REQUEST['c'];
}

else
{
}
$permiso=0;
$titulo="";
$mensaje="";
//$conex_lectura=new base();
//$conex_lectura->conectar_base(_host,_user_base_lectura,_pass_base_lectura,_nom_base);
$conex=new base();
$conexion=$conex->conectar_base(_host,_user_base,_pass_base,_nom_base);
if(isset($_SESSION['session_usuario'], $_SESSION['session_id_usuario']) && $_SESSION['session_estado'] === 'activo')
{
	
	$menu=explode(",", $_SESSION['session_menu']);
	$permisos=explode(",", $_SESSION['session_permisos']);
	if(isset($_REQUEST['m']))
	{
		
		
		for($i=0; $i < count($menu); $i++)
		{
			
			if($controlador == $menu[$i] AND $permisos[$i] == $_REQUEST['m'])
			{
				$permiso=1;				
			}
			
		}
		
	}
	else if(in_array($controlador, $menu))
    {
        
        $permiso=2;
    }
    else 
    {
		$permiso=0;
	}
	
	
    
	
}

else if(isset($_REQUEST['calendar']))
{
	
	require_once('controller/vista_calendarios_controller.php');
}
else 
{
	$permiso=3;
}

switch ($permiso)
{
	case 0:
		$controlador=$menu[0];
		unset($_REQUEST['m']);
		//echo "<br><br><br> CERO = ".$permiso;
		require_once('controller/'.$controlador.'_controller.php');
	break;
	case 1:
		//echo "<br><br><br> UNO = ".$permiso;
		require_once('controller/'.$controlador.'_controller.php');
	break;
	case 2:
		//$controlador=$menu[0];
		//echo "<br><br><br> DOS = ".$permiso;
		require_once('controller/'.$controlador.'_controller.php');
	break;
	case 3:
		$controlador='session';
		//echo "<br><br><br> TRES = ".$permiso;
		require_once('controller/'.$controlador.'_controller.php');
	break;
}

?>

