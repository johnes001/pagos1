<?php


switch ($_REQUEST['var'])
{
    case "exam_met":
        require_once("view/default/vista-php/registro_examen_form.phtml");
    break;
    default:
        echo "Carga por defecto";
        require_once("view/default/vista-php/lista_examenes.phtml");
    
}

?>
