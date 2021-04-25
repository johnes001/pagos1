<?php

class vista_calendario{
	private $fecha_evento;
	private $nom_calendario;
	private $activo_evento;
	public function __construct()
	{
		
	}
	public function inicializar($fecha_event,$nombre_calendario,$activo_event)
	{
		$this->fecha_evento=$fecha_event;
		$this->nom_calendario=$nombre_calendario;
		$this->activo_evento=$activo_event;
	}
	public function calendario_eventos($FechaActual)
	{
		
		 $fecha_hoy=$FechaActual;
		 $conex1=new base();
		$conex1->conectar_base(_host,_user_base_lectura,_pass_base_lectura,_nom_base);
		$cont=0;
		if($evento_encontrado=$conex1->buscar3("EVENTOS", "nombre_calendario", $this->nom_calendario))
		{
			$conex1->cerrar();
				while ($indice = mysqli_fetch_array($evento_encontrado, MYSQLI_ASSOC)) {
				
					if($indice['activo'] == "activo" && $indice['fecha_evento'] == $this->fecha_evento)
					{
						$cont+=1;
						$colores=explode(",", $indice['color']);
						
						if($fecha_hoy >= $indice['fecha_inactivo'])
						{
							
							$array_valores[$cont]['color']=$colores[1];
							$array_valores[$cont]['nombre']=$indice['nombre'];
							$array_valores[$cont]['descripcion']=$indice['descripcion'];
							$array_valores[$cont]['destino_url']="#";
							
							
							/* 
							echo "<br> INACTIVO =".$cont;
							echo "<br> EVENTO ".$indice['fecha_evento'];
							echo "<br> CADUCADO ".$indice['fecha_inactivo'];
							echo "<BR>FECHA HOY ".$fecha_hoy;
							echo "<br> URL INACTIVO ".$indice['destino_url'];
							echo "<br> COLOR ".$colores[1];
							echo "<br> RUTA INACTIVA".$_SERVER['HTTP_REFERER'];
							echo "<hr>";
							 */
						}
						
						else
						{
							$array_valores[$cont]['color']=$colores[0];
							
							$array_valores[$cont]['nombre']=$indice['nombre'];
							$array_valores[$cont]['descripcion']=$indice['descripcion'];
							$array_valores[$cont]['destino_url']=$indice['destino_url'];
							
							/*
							echo "<br> ACTIVO =".$cont;
							echo "<br> EVENTO ".$indice['fecha_evento'];
							echo "<BR>FECHA HOY ".$fecha_hoy;
							echo "<br> CADUCADO ".$indice['fecha_inactivo'];
							echo "<br> URL ACTIVO ".$indice['destino_url'];
							echo "<br> COLOR ".$colores[0];
							echo "<hr>";
							* */
						}
						
						
					}
				}
				
				mysqli_free_result($resultado);
				unset($resultado);
				
		}
		else
		{
			$conex1->cerrar();
		}	
		
		return $array_valores;
		
	}
	public function verificar_url($url_destino, $variables)
	{
		
		if(strpos($url_destino, "?"))
		{	
			$url=explode("?", $url_destino);
				
			
			$url_completa='<form name="url" action="'.$url[0].'" method="get" target="_top">';
			
			$var=explode("&", $url[1]);
			
			for($z=0; $z<count($var); $z++)
			{
								  
				  $variable0=explode("=", $var[$z]);
				 
					  if($variable0[0] == 'testCentreLocationId')
						  {
							 
							 $url_completa.='<input name="testCentreLocationId" type="hidden" value="'.$variables['testCentreLocationId'].'">';
							 
						  }
					  else if($variable0[0] == 'testmoduleid')
						{
							
							 $url_completa.='<input name="testmoduleid" type="hidden" value="'.$variables['testmoduleid'].'">';
									
						}
						else if($variable0[0] == 'testCentreId')
						{
							
							$url_completa.='<input name="testCentreId" type="hidden" value="'.$variables['testCentreId'].'">';
									
						}
						else if($variable0[0] == 'testVenueId')
						{
							
							$url_completa.='<input name="testVenueId" type="hidden" value="'.$variables['testVenueId'].'">';
						}
						else
						{
							
							$url_completa.='<input name="'.$variable0[0].'" type="hidden" value="'.$variable0[1].'">';
							
						}
			}
			$url_completa.='<!-- <input type="submit" value="Submit"> --></form>';
			}//fin if
			else
			{
				$url_completa='<form name="url" action="'.$url_destino.'" method="get"></form>';
			}
			$resultado=$url_completa;
			return $resultado;
		
	}
	public function enviar_url($url_final)
	{
		echo $url_final;
		echo '<script>
			window.onload=function(){
						// Una vez cargada la página, el formulario se enviara automáticamente.
 				//window.open();
				document.forms["url"].submit()
				
			}
			
			</script> ';
		echo ' <meta http-equiv="refresh" content="1">';
	}
	
	public function enviar_recordatorio_cron($fecha_recordatorio, $correos, $titulos, $mensajes)
	{
		//url del cron a ejecutar https://multilingua.edu.co/pagos/?m=enviar_cron&calendar=1
		
		
	}
}//fin class



?>




















