<?php
error_reporting(0);
//llega desde la plantilla, si no tiene valor es igual a listar
require_once('model/session_model.php');
if(!isset($_REQUEST['m']))
{
	$metodo="principal";
}
else
{
	$metodo=$_REQUEST['m'];
}


switch ($metodo) {
	
	
	
		//AUTENTICAR ***********************************************************
	
	case "autenticar":
		if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response'] && !empty($_POST['usuario']) AND !empty($_POST['contrasena']))
		{
			//var_dump($_POST);
			$secret="6Ldk-DAUAAAAAJcLXtc7UFeu6c9PwnrBHQE7QXvv";
			$ip=$_SERVER['REMOTE_ADDR'];
			$capcha=$_POST['g-recaptcha-response'];
			$result= file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$capcha&remoteip=$ip");
			$correcto_capcha= json_decode($result,TRUE);
			
			if($correcto_capcha['success'] && $array_usuario=$conex->buscar2('USUARIOS', 'MAIL', $_POST['usuario']))
			{
				$conex->cerrar();
				if(password_verify($_POST['contrasena'], $array_usuario['CONTRASENA']) AND $array_usuario['ESTADO'] == 'activo')
				{
					$_SESSION['session_usuario']=$array_usuario['NOMBRE'];
					$_SESSION['session_usuario'].=' ';
					$_SESSION['session_usuario'].=$array_usuario['APELLIDOS'];
					$_SESSION['session_id_usuario']=$array_usuario['ID'];
					$_SESSION['session_menu']=$array_usuario['MENU'];
					$_SESSION['session_permisos']=$array_usuario['PERMISOS'];
					$_SESSION['session_estado']=$array_usuario['ESTADO'];
					$_SESSION['session_email']=$array_usuario['MAIL'];
					$titulo="Bienvenido";
					$mensaje="Has iniciado session como ".$_SESSION['session_usuario'];
					$controlador="session";
					require_once($template_ruta.'respuesta.phtml');
				}
				else 
				{
					$titulo="Error de autenticación";
				$mensaje="Comrpruebe las credenciales del usuario ".$_POST['usuario']." ó contacte con el administrador";
					require_once($template_ruta.'session_login.phtml');
				}
			}
			else
			{
				$conex->cerrar();
				$titulo="Error con usuario";
				$mensaje="El usuario ".$_POST['usuario'].", no se autentico correctamente, intentelo nuevamente, &oacute; contacte con el administrador. ";
				require_once($template_ruta.'session_login.phtml');
			}
			
			
						
		}
		else
		{
			$titulo="Campos incompletos";
			$mensaje="Uno o más campos no se encuentran llenos correctamente".
			require_once($template_ruta.'session_login.phtml');
			
		}
		
		break;
		
		//RECUPERAR ***********************************************************
		
	case "recuperar":
	//echo "<br> RECUPERAR";
		if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response'] && !empty($_POST['usuario']))
		{
			//var_dump($_POST);
			$secret="6Ldk-DAUAAAAAJcLXtc7UFeu6c9PwnrBHQE7QXvv";
			$ip=$_SERVER['REMOTE_ADDR'];
			$capcha=$_POST['g-recaptcha-response'];
			$result= file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$capcha&remoteip=$ip");
			$correcto_capcha= json_decode($result,TRUE);
			
			//GENERAR CONTRASEÑA
			$password = "";
			$charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		  
			 for($i = 0; $i < 8; $i++)
				{
				  $random_int = mt_rand();
				  $password .= $charset[$random_int % strlen($charset)];
				}
			 
				$contrasena=password_hash($password, PASSWORD_DEFAULT);
				$datos=array("CONTRASENA" => $contrasena);
			//GENERAR CONTRASEÑA
			
				if($array_usuario=$conex->buscar2('USUARIOS', 'MAIL', $_POST['usuario']))
				{
					$conex->actualizar("USUARIOS", 'ID', $array_usuario['ID'], $datos);
					$url_aplicacion=$hostname;
					$url_aplicacion.='/pagos';
					$mensaje_recuperar=new session();
					$mensaje_recuperar->mail_recuperacion($_POST['usuario'], 'Pagos Multilingua Recuperacion cuenta', $_POST['usuario'], $password, $url_aplicacion);
					$conex->cerrar();
					$titulo="Correcto";
					$mensaje= "Se ha enviado un mensaje a su cuenta de correo para proceder con la restauración de la cuenta ".$_POST['usuario'];
					$mensaje.='<p><a href="index.php">Click aquí para iniciar sessión</a></p>';
					
					require($template_ruta.'respuesta.phtml');
				}
				else
				{
					$conex->cerrar();
					$titulo="Correo no valido";
					$mensaje= "La cuenta que est&aacute; recuperando con el correo <b>".$_POST['usuario']."</b> no hace parte del sistema, contacte al administrador.";
					
				}
				
		}
		else
		{
			$titulo='Mensaje';
			$mensaje='Porfavor digite los datos solicitados.';
			
		}
		require_once($template_ruta.'session_recuperar.phtml');
		break;
		
			
	case "principal":
		
			require_once($template_ruta.'session_login.phtml');
		
		break;
	default:
		require_once($template_ruta.'session_login.phtml');
	break;
	
}
?>
