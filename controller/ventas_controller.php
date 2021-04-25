<?php
error_reporting(0);
     //llega desde la plantilla, si no tiene valor es igual a listar

if(!isset($_REQUEST['m']))
{
    $metodo="listar";
}
else
{
    $metodo=$_REQUEST['m'];
}



switch ($metodo) {
    case "listar":
        
        if(!isset($_REQUEST['orden']))
        {
        	$orden='ID';
        }
        else{
        	$orden=$_REQUEST['orden'];
        }
        $resultado=$conex->listar($conexion, 'PAGOS', $orden);
        $conex->cerrar();
        require_once($template_ruta.'ventas_listar.phtml');

        break;
   
}
?>
