<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
 
    <script>
    window.onload=function(){
               
		document.forms["form"].submit();
    }
    </script>
</head>
 
<body>
	
<?php
error_reporting(0);
//error_reporting(E_ERROR);
//error_reporting(E_ALL);
//echo "confirmacion";
$ApiKey = "LvGBS307frpxu2iOLgBm7Y6P1U";
$merchant_id = $_REQUEST['merchantId'];
$referenceCode = $_REQUEST['referenceCode'];
$TX_VALUE = $_REQUEST['TX_VALUE'];
$New_value = number_format($TX_VALUE, 1, '.', '');
$currency = $_REQUEST['currency'];
$transactionState = $_REQUEST['transactionState'];
$firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
$firmacreada = md5($firma_cadena);
$firma = $_REQUEST['signature'];
$reference_pol = $_REQUEST['reference_pol'];
$cus = $_REQUEST['cus'];
$extra1 = $_REQUEST['description'];
$pseBank = $_REQUEST['pseBank'];
$lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
$transactionId = $_REQUEST['transactionId'];

$ruta_base=$_SERVER['DOCUMENT_ROOT'];
$host="multi022.mysql.guardedhost.com";
    $user_base="multi022_pagos";
    $pass_base="zvGw4Se4sh^8";
    $nom_base="multi022_pagos";
require_once($ruta_base.'/pagos/model/base.php');
$nombre_comprador=$_REQUEST['cc_holder'];
$nombre_comprador.=$_REQUEST['nickname_buyer'];
$conex=new base();
$conexion=$conex->conectar_base($host,$user_base,$pass_base,$nom_base);

$datos=array("PRODUCTO" => $_REQUEST['reference_sale'],	
"NOMBRE_COMPRADOR" => $nombre_comprador,
"DESCRIPCION" => $_REQUEST['description'],
"MENSAJE_RESPUESTA_PAYU" => $_REQUEST['response_message_pol'],
"VALOR" => $_REQUEST['value'], 
"DIRECCION_FACTURACION" => $_REQUEST['billing_address'],
"CIUDAD_FACTURACION" => $_REQUEST['billing_city'],
"TELEFONO_COMPRADOR" => $_REQUEST['phone'],
"DOCUMENTO" => $_REQUEST['pse_reference3'],
"EMAIL_COMPRADOR" => $_REQUEST['email_buyer'],
"ID_TRANSACCION" => $_REQUEST['transaction_id'],	
"REFERENCIA" => $_REQUEST['reference_pol'],	
"COD_SEGUIMIENTO" => $_REQUEST['cus'],	
"BANCO_PSE" => $_REQUEST['pse_bank'],
"ENTIDAD" => $_REQUEST['payment_method_name'],	
"MONEDA" => $_REQUEST['currency'],	
"FECHA_TRANSACCION" => $_REQUEST['transaction_date'], 
"IP" => $_REQUEST['ip']);
				
            $conex->insertar("PAGOS",$datos);
			$conex->cerrar();
			
			$mensaje="CONFIRMACION";
foreach ($_REQUEST as $variable => $valor)  
        {
            //echo "<br> Variable ".$variable;
			//echo " = ".$valor;
			$mensaje.=$variable;
			$mensaje.=" = ";
			$mensaje.=$valor;
			$mensaje.=" ;  ";
		}
mail('john@multilingua.edu.co', 'CONFIRMACION PAYU', $mensaje);

//$datos1="datos";
//$datos1.="datos2";
//$datos1.="datos3 ";

//echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=http://www.multilingua.com.co">';
			
//-------------------------***************-----------------------------------------
/*$mensaje="RESPUESTA";
foreach ($_REQUEST as $variable => $valor)  
        {
            echo "<br> Variable ".$variable;
			echo " = ".$valor;
			$mensaje.=$variable;
			$mensaje.=" = ";
			$mensaje.=$valor;
			$mensaje.=" ;  ";
		}
mail('john@multilingua.edu.co', 'prueba Payu', $mensaje);

if ($_REQUEST['transactionState'] == 4 ) {
	$estadoTx = "Transacción aprobada";
}

else if ($_REQUEST['transactionState'] == 6 ) {
	$estadoTx = "Transacción rechazada";
}

else if ($_REQUEST['transactionState'] == 104 ) {
	$estadoTx = "Error";
}

else if ($_REQUEST['transactionState'] == 7 ) {
	$estadoTx = "Transacción pendiente";
}

else {
	$estadoTx=$_REQUEST['mensaje'];
}


if (strtoupper($firma) == strtoupper($firmacreada)) {
?>
	<h2>Resumen Transacción</h2>
	<table>
	<tr>
	<td>Estado de la transaccion</td>
	<td><?php echo $estadoTx; ?></td>
	</tr>
	<tr>
	<tr>
	<td>ID de la transaccion</td>
	<td><?php echo $transactionId; ?></td>
	</tr>
	<tr>
	<td>Referencia de la venta</td>
	<td><?php echo $reference_pol; ?></td> 
	</tr>
	<tr>
	<td>Referencia de la transaccion</td>
	<td><?php echo $referenceCode; ?></td>
	</tr>
	<tr>
	<?php
	if($pseBank != null) {
	?>
		<tr>
		<td>cus </td>
		<td><?php echo $cus; ?> </td>
		</tr>
		<tr>
		<td>Banco </td>
		<td><?php echo $pseBank; ?> </td>
		</tr>
	<?php
	}
	?>
	<tr>
	<td>Valor total</td>
	<td>$<?php echo number_format($TX_VALUE); ?></td>
	</tr>
	<tr>
	<td>Moneda</td>
	<td><?php echo $currency; ?></td>
	</tr>
	<tr>
	<td>Descripción</td>
	<td><?php echo ($extra1); ?></td>
	</tr>
	<tr>
	<td>Entidad:</td>
	<td><?php echo ($lapPaymentMethod); ?></td>
	</tr>
	</table>
<?php
}
else
{
?>
	<h1>Error validando firma digital.</h1>
<?php
}*/

echo "respuesta";
?>

</body>
	</html>
