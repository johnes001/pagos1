 <?php
error_reporting(E_ERROR);
//error_reporting(E_ALL);
//require_once('productos.php');
//echo $_SERVER['DOCUMENT_ROOT'];
if(isset($_REQUEST['product']))
{

	//*************************************************
		switch ($_REQUEST['form'])
		{
			case NULL:
				echo 'NULL';
				require_once($_SERVER['DOCUMENT_ROOT'].'/pagos/view/default/registro_cliente_ventas.phtml');
			break;
			case 'datos':
				echo "<br><br><br> DATOS ".$_REQUEST['product'];
				
				
				//****************************************************
				require_once($_SERVER['DOCUMENT_ROOT'].'/pagos/model/base.php');
				require_once($_SERVER['DOCUMENT_ROOT'].'/pagos/libs/config.php');
				$base_select=new base();
				$conectar=$base_select->conectar_base(_host,_user_base,_pass_base,_nom_base);
				if($datos=$base_select->buscar2("PRODUCTOS", "NOMBRE_PASARELA", $_REQUEST['product']))
				{

					if($datos['ACTIVO'] == "si")
					{
				//****************************************************
						
						$description=$datos['TITULO'];
						$description.=$datos['DESCRIPCION'];
						$amount=$datos['PRECIO'];
						$referencecode=time();
						$referencecode.=$datos['NOMBRE_PASARELA'];
						
						$nombre_estudiante=$_REQUEST['NOMBRE'];
						$nombre_estudiante.=" ";
						$nombre_estudiante.=$_REQUEST['APELLIDO'];
						
						$datos=array("PRODUCTO" => $referencecode,	
						"NOMBRE_ESTUDIANTE" => $nombre_estudiante,
						"CEDULA_ESTUDIANTE" => $_REQUEST['CEDULA'],
						"CORREO_ESTUDIANTE" => $_REQUEST['MAIL'],
						"DIRECCION_ESTUDIANTE" => $_REQUEST['DIRECCION'],
						"CELULAR_ESTUDIANTE" => $_REQUEST['CELULAR'],
						"PAGO_SELECCIONADO" => $_REQUEST['metodo_pago'],
						"NOMBRE_COMPRADOR" => 'NULL',
						"DESCRIPCION" => 'NULL',
						"MENSAJE_RESPUESTA_PAYU" => 'NULL',
						"VALOR" => 'NULL', 
						"DIRECCION_FACTURACION" => 'NULL',
						"CIUDAD_FACTURACION" => 'NULL',
						"TELEFONO_COMPRADOR" => 'NULL',
						"DOCUMENTO" => 'NULL',
						"EMAIL_COMPRADOR" => 'NULL',
						"ID_TRANSACCION" => 'NULL',	
						"REFERENCIA" => 'NULL',	
						"COD_SEGUIMIENTO" => 'NULL',	
						"BANCO_PSE" => 'NULL',
						"ENTIDAD" => 'NULL',	
						"MONEDA" => 'NULL',	
						"FECHA_TRANSACCION" => 'NULL', 
						"IP" => 'NULL');
						
						if($base_select->insertar("PAGOS",$datos))
							{
								//crear la firma 
								$firm="LvGBS307frpxu2iOLgBm7Y6P1U~624633~";
								$firm.=$referencecode;
								$firm.="~";
								$firm.=$amount;
								$firm.="~";
								$firm.="COP";
								$signature=MD5($firm);
								
						//llenar el formulario de envio a payu
		
								echo '<form method="post" action="https://gateway.payulatam.com/ppp-web-gateway" id="form" name="form">
								  <input name="ApiKey"    type="hidden"  value="LvGBS307frpxu2iOLgBm7Y6P1U"   >
								  <input name="merchantId"    type="hidden"  value="624633"   >
								  <input name="accountId"     type="hidden"  value="626985" >
								  <input name="description"   type="hidden"  value="'.$description.'"  >
								  <input name="referenceCode" type="hidden"  value="'.$referencecode.'" >
								  <input name="amount"        type="hidden"  value="'.$amount.'"   >
								  <input name="tax"           type="hidden"  value="0"  >
								  <input name="taxReturnBase" type="hidden"  value="0" >
								  <input name="currency"      type="hidden"  value="COP" >
								  <input name="signature"     type="hidden"  value="'.$signature.'">
								  <input name="test"          type="hidden"  value="0" >
								  <input name="confirmationUrl"    type="hidden"  value="https://www.multilingua.edu.co/pagos/libs/pasarela/confirmacion.php" >
								  <input name="responseUrl"    type="hidden"  value="https://www.multilingua.edu.co/pagos/libs/pasarela/respuesta.php" >
								 <!--<input name="Submit"        type="submit"  value="Continuar" >-->
								</form>
								
								<script>
									window.onload=function(){
												// Una vez cargada la página, el formulario se enviara automáticamente.
										document.forms["form"].submit();
									}
									</script> ';
								$base_select->cerrar();
							}
							else
							{
								echo "Datos no han sido guardados en la base";
								$base_select->cerrar();
							}

						
						
						
						
					}
					else
						{
							echo "El producto se encuentra inactivo";
							
						}
				}
								
				$base_select->cerrar();
			break;
			case 2:
				//$controlador=$menu[0];
				//echo "<br><br><br> DOS = ".$permiso;
				require_once('controller/'.$controlador.'_controller.php');
			break;
			case 3:
				$controlador='session';
				//echo "<br><br><br> TRES = ".$permiso;
				require_once('controller/'.$controlador.'_controller.php');
			break;
		}
	//*************************************************
		
		
		
		
	
}
else 
{
	
echo "PRODUCTO NO EXISTE";
}

	
?>