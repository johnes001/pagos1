<?php
//error_reporting(0);

class session
{
	public function menu($m, $p)
	{
		$menu=explode(",", $m);
		$metodo=explode(",", $p);
		echo '<div class="w3-bar w3-black  w3-card-2">';
		echo ' <button class="w3-padding-large w3-button" style="margin-left: 50%; text-align: right;" >'.ucwords($_SESSION['session_usuario']).'</button>';
		echo '<a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a><a href="index.php?c='.$menu[0].'" class="w3-bar-item w3-button w3-padding-large">'.ucwords($menu[0]).'</a>';
		$cont=0;
		for($i=1; $i<count($menu); $i++)
		{
			
			
			if($menu[$i] != $menu[$i-1])
			{
				if($cont == 1)
				{
					$cont=0;
					echo '</div></div>';
				}
				echo '<div class="w3-dropdown-hover w3-hide-small">';
				echo '<button class="w3-padding-large w3-button" title="'.ucwords($menu[$i]).'">'.ucwords($menu[$i]).' <i class="fa fa-caret-down"></i></button> ';
				echo '<div class="w3-dropdown-content w3-bar-block w3-card-5">';
				echo '<a href="index.php?c='.$menu[$i].'&m='.$metodo[$i].'" class="w3-bar-item w3-button">'.ucwords($metodo[$i]).'</a>';
				
				
				
			}
			else 
			{
				echo '<a href="index.php?c='.$menu[$i].'&m='.$metodo[$i].'" class="w3-bar-item w3-button">'.ucwords($metodo[$i]).'</a>';
				
			}
			$cont=1;
			
		}
		
		
		
		echo '</div></div></div>';
	}
	
	public function mail_recuperacion($para, $titulo, $usuario, $contrasena, $url_aplicacion)
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
