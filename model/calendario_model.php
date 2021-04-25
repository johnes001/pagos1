<?php
 error_reporting(0);
	class url_calendario{
		private $nombre;
		private $tipo;
		private $url_limpia;
		
		public function __construct($n, $t){
			$this->nombre=$n;
			$this->tipo=$t;
		}
		public function limpiarUrl(){
			// Tranformamos todo a minusculas
			
			$nombre1 = strtolower($this->nombre);
			
			//Rememplazamos caracteres especiales latinos

			$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');

			$repl = array('a', 'e', 'i', 'o', 'u', 'n');

			$nombre1 = str_replace ($find, $repl, $nombre1);
			
			if($separar=explode(' ',$nombre1))
			{				//separamos por espacios
			$slug= ucwords($separar[0]); //ponemos primera letra de la palabra en mayusculas
			for($i=1; $i<count($separar); $i++)
				{
					$slug.=' ';
					$slug.=strtoupper($separar[$i]);
				}
			
			}
			

			// Añaadimos los guiones

			$find = array(' ', '\r\n', '\n');
			$slug = str_replace ($find, '_', $slug);
			
			// Eliminamos y Reemplazamos demás caracteres especiales

			$find = array('/[^a-zA-Z0-9\_+&<>-]/', '/[\-]+-/', '/<[^>]*>-/');
			//$find = array('/[^a-zA-Z0-9\_+&<>]/', '/[\-]+/', '/<[^>]*>/');
			
			$repl = array('', '_', '');

			$slug = preg_replace ($find, $repl, $slug);
			$this->url_limpia = $slug;
			
			return $this->url_limpia;
		}
		
	}
	
	
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
		

		$fecha_hoy=strtotime($FechaActual);
		
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
						if(strtotime($indice['fecha_evento']) <= $fecha_hoy)
						{
							$array_valores[$cont]['color']=$colores[1];
							
							$array_valores[$cont]['nombre']=$indice['nombre'];
							$array_valores[$cont]['descripcion']=$indice['descripcion'];
							$array_valores[$cont]['destino_url']="#";
						}
						else
						{
							$array_valores[$cont]['color']=$colores[0];
							
							$array_valores[$cont]['nombre']=$indice['nombre'];
							$array_valores[$cont]['descripcion']=$indice['descripcion'];
							$array_valores[$cont]['destino_url']=$indice['destino_url'];
						}
						
						// echo "Encontrado 1 ";
					}
				}
				
				mysqli_free_result($resultado);
				unset($resultado);
				
				//var_dump($evento_encontrado);
				//echo "Encontrado 2 ";
		}
		else
		{
			$conex1->cerrar();
			//echo "NO encontrado ";
		}	
		
		return $array_valores;
		//var_dump($array_valores);
	}
	public function verificar_url($url_destino, $variables)
	{
		
		if(strpos($url_destino, "?"))
		{	
			$url=explode("?", $url_destino);
				
			
			$url_completa='<form name="url" action="'.$url[0].'" method="get">';
			
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
				$resultado=$url_destino;
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
				document.forms["url"].submit();
			}
			</script> ';
		
	}
}//fin class
	
?>
