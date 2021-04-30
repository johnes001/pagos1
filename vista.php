<?php


switch ($_REQUEST['var'])
{
    case "registro":
		$examen=$_REQUEST['examen'];
        require_once("view/default/vista-php/registro_examen_form.phtml");
    break;
	 case "enviar":

	 	require_once("model/vista_model.php");
	 	
        $nombre_archivo=$_FILES['documento_identidad']['name'];
        $nombre_archivo_temporal= $_FILES['documento_identidad']['tmp_name'];
        $ruta_destino="archivos_subidos/";
        $upload_f=new vista;
        $upload_f->upload_file ($nombre_archivo, $nombre_archivo_temporal, $ruta_destino);
        
        
        require_once("view/default/vista-php/registro_examen_form_enviar.phtml");
    break;
    default:
        
        require_once("view/default/vista-php/lista_examenes.phtml");
    
}

?>
