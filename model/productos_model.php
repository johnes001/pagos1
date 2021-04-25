 <?php
 error_reporting(0);
	class botones{
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

			$find = array('/[^a-zA-Z0-9\_+&<>]/', '/[\-]+/', '/<[^>]*>/');
			//$find = array('/[^a-zA-Z0-9\_+&<>]/', '/[\-]+/', '/<[^>]*>/');

			$repl = array('', '_', '');

			$slug = preg_replace ($find, $repl, $slug);
			$this->url_limpia = $slug;
			
			return $this->url_limpia;
		}
		public function imagenBoton(){
			return $url_imagen='https://'.$_SERVER['SERVER_NAME'].'/pagos/libs/pasarela/index.php?product='.$this->url_limpia;
		}
		public function radioBoton(){
			
		}
		public function selectBoton($titulo, $slug){
			
			$formulario='<!-- Boton agrupado -->
			<style>
		  .contenedor_form{
			background-image: url("https://multilingua.edu.co/pagos/libs/pasarela/img/carrito-01.png");
			background-repeat: no-repeat;
			background-size: 100% 100%;
			height: 30px;
			padding-top: 10px;
			padding-bottom: 10px;
			padding-right: 0px;
			padding-left: 90px;
			width:213px; 
			vertical-align: center;
			align-content: right;
		  }
		  select.met{
			border-radius: 0px 7px 7px 0px;
			border-style:none;
			width:180px;
			height: 30px;
			background-color: #fff;
			position: relative;
			text-align-last:center;
		  }
		</style>
		<div class="contenedor_form">
				<form   method="get" action="https://multilingua.edu.co/pagos/libs/pasarela/index.php">
				<select name="product" class="met" onchange="this.form.submit()"> 
				<option value="" select>  Click Aqu&iacute;  </option>';
			
			for($i=0; $i< count($titulo); $i++) 
			{
				
						$formulario.='<option value="'.$slug[$i].'" select>'.$titulo[$i].'</option>';				
				
			}
		$formulario.='</select>
		</form>	
		</div> 
		<!-- Fin Boton  -->';
		return $formulario;
		}
	}
	
	//$boton=new botones("esto Es una PRUEba mads ñl jlpñoñ", " ");
	//$boton->limpiarUrl();
	
 ?>
