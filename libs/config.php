<?php

define("_host", "");
define("_user_base", "");
define("_pass_base", "");
define("_nom_base", "");
	
define("_user_base_lectura", "");
define("_pass_base_lectura", "");
	
    //url para el template en las vistas
    $template_ruta="view/default/";
    
    //Menu que aparecera en la aplicacion con sus metodos (permisos)
    $hostname=$_SERVER['SERVER_NAME'];
    $menu_header=array(
    "ventas" => "listar",
    "usuarios" => "listar,insertar,editar,eliminar",
    "productos" => "listar,insertar,editar,eliminar,boton",
    "calendario" => "listar,insertar,editar,eliminar,listar-eventos,crear-evento,editar-evento,eliminar-evento",
    "examen" => "crear-examen,editar-examen,eliminar-examen,crear-sede,editar-sede,eliminar-sede,listar-candidatos,editar-candidatos,eliminar-candidatos",
	"clientes" => "listar,insertar,editar,eliminar");

?>
