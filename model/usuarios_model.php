<?php
error_reporting(0);
class usuarios
{
	public function mail_confirm($para, $titulo, $usuario, $contrasena, $url_aplicacion)
	{
		

		$mensage = "
		<html>
		<head>
		<title>HTML email</title>
		</head>
		<body>
		<p>Bienvenido a la aplicaci&oacute;n de administracion de pagos de Multilingua, su cuenta ha sido creada, &oacute; actualizada por el administrador.<br> Para ingresar click aqu&iacute; ".$url_aplicacion."</p>
		<table>
		<tr>
		<th>Usuario</th>
		<th>Contrase&ntilde;a</th>
		</tr>
		<tr>
		<td>".$usuario."</td>
		<td>".$contrasena."</td>
		</tr>
		</table>
		</body>
		</html>
		";

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: <info@multilingua.edu.co>' . "\r\n";
		

		mail($para,$titulo,$mensage,$headers);
	}
}

	
?>
