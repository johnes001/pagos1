<?php
error_reporting(0);
class vista
{
	public function enviar_mail($mail_destino, $asunto, $titulo, $texto1, $texto2, $texto3, $mail_quien_envia)
	{
		

		$mensage = "
		<!DOCTYPE html>
<html>
<head>
<style>
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 10%;
  padding-top: 5%;
  
}
th {
  background-color: teal;
  color: white;
  padding: 3%;
}
</style>
</head>
<body>

<table>
  <tr>
    <th><a href="https://multilingua.edu.co" target="_blank" ><img alt="MULTILINGUA" src="https://multilingua.edu.co/pagos/view/default/images/Logo.png" title="multilingua" width="200"></a></th>
   
  </tr>
 
  <tr>
    <td>
    <h1>
      ".$titulo."
      </h1>
      <p>
        ".$texto1."
      </p>
      <p>
        ".$texto2."
      </p>
      <p>
        ".$texto3."
      </p>
    </td>
   
  </tr>
  <tr>
    <th><a href="https://www.facebook.com/multilinguaco" target="_blank" ><img alt="Facebook" height="32" src="https://multilingua.edu.co/pagos/view/default/img/vista/instagram.png" title="instagram" width="32"></a>
    <a href="https://www.instagram.com/multilinguaco/" target="_blank" ><img alt="Instagram" height="32" src="https://multilingua.edu.co/pagos/view/default/img/vista/facebook.png" title="instagram" width="32"></a>
    </th>
   
   
</tr>
</table>

</body>
</html>

		";

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: <'.$mail_quien_envia.'>' . "\r\n";
		

		mail($mail_destino,$asunto,$mensage,$headers);
	}

//****************UPLOAD FILES
	public function upload_file ($nombre_archivo, $nombre_archivo_temporal, $ruta_destino)
	{
		
		$fichero_subido = $ruta_destino . basename($nombre_archivo);

		echo '<pre>';
		if (move_uploaded_file($nombre_archivo_temporal, $fichero_subido)) {
			echo "El fichero es válido y se subió con éxito.\n";
		} else {
			echo "¡Posible ataque de subida de ficheros!\n";
		}

		echo 'Más información de depuración:';
		print_r($_FILES);

		print "</pre>";
	}
}

	
?>
