<?php
error_reporting(0);
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

class base
{
	public $link;
	public function conectar_base($host, $usuario, $contrasena, $bd)
	{
		// Conectando, seleccionando la base de datos
		$this->link = mysqli_connect($host, $usuario, $contrasena, $bd)
		or die('No se pudo conectar: ' . mysql_error());
		return $this->link;
	}
	public function listar($connect, $tabla_0, $ordenar_0)
	{
		$tabla = mysqli_real_escape_string($connect, $tabla_0);
		$ordenar = mysqli_real_escape_string($connect,$ordenar_0);
		// Realizar una consulta MySQL
				
		$query = 'SELECT * FROM '.$tabla.' ORDER BY '.$ordenar;
		$result = mysqli_query($this->link, $query) or die (mysqli_error($this->link));
		
		return $result;

	}
	
	
	public function listar_columnas($propiedad_0, $tabla_0, $columnas_0)
	{
		$propiedad = mysqli_real_escape_string($this->link, $propiedad_0);
		$tabla = mysqli_real_escape_string($this->link, $tabla_0);
		$columnas = mysqli_real_escape_string($this->link, $columnas_0);
		
		$query = 'SELECT '.$propiedad.' '.$columnas.' FROM '.$tabla;
		$result = mysqli_query($this->link, $query);		
		return $result;
		
	}
	
	public function buscar($tabla_0,$columnas_mostrar_0, $donde_columna_0, $parametro_0)
	{
		$tabla=mysqli_real_escape_string($this->link, $tabla_0);
		$columnas_mostrar=$columnas_mostrar_0;
		$columna=mysqli_real_escape_string($this->link, $donde_columna_0);
		$parametro=mysqli_real_escape_string($this->link, $parametro_0);
		
		$query = "SELECT ".$columnas_mostrar." FROM ".$tabla." WHERE ".$columna." LIKE '".$parametro."' ";
		$result = mysqli_query($this->link, $query);
		
		
		return $result;
	}
	
	public function buscar2($tabla_0, $columna_0, $parametro_0)
	{
		$tabla = mysqli_real_escape_string($this->link, $tabla_0);
		$columna = mysqli_real_escape_string($this->link, $columna_0);
		$parametro = mysqli_real_escape_string($this->link, $parametro_0);
		// Realizar una consulta MySQL
		$query = "SELECT * FROM ".$tabla." WHERE ".$columna." LIKE '".$parametro."' ";
		$result = mysqli_query($this->link, $query); 
		$resultado= mysqli_fetch_array($result);
		return $resultado;

	}
	
	public function buscar3($tabla_0, $columna_0, $parametro_0)
	{
		$tabla = mysqli_real_escape_string($this->link, $tabla_0);
		$columna = mysqli_real_escape_string($this->link, $columna_0);
		$parametro = mysqli_real_escape_string($this->link, $parametro_0);
		// Realizar una consulta MySQL
		$query = "SELECT * FROM ".$tabla." WHERE ".$columna." LIKE '".$parametro."' ";
		$result = mysqli_query($this->link, $query); 
		
		return $result;

	}
	
	public function sesion_autenticar($tabla_0, $columna_0, $columna_1, $parametro_0, $parametro_1)
	{
		$tabla = mysqli_real_escape_string($this->link, $tabla_0);
		$columna = mysqli_real_escape_string($this->link, $columna_0);
		$parametro = mysqli_real_escape_string($this->link, $parametro_0);
		$columna1 = mysqli_real_escape_string($this->link, $columna_1);
		$parametro1 = mysqli_real_escape_string($this->link, $parametro_1);
		// Realizar una consulta MySQL
		$query = "SELECT * FROM ".$tabla." WHERE ".$columna." LIKE '".$parametro."' AND ".$columna1." LIKE '".$parametro1."'";
		$result = mysqli_query($this->link, $query); 
		$resultado= mysqli_fetch_array($result);
		return $resultado;

	}
	
	public function insertar($tableName, $insData)
	{
		$columna='';
		$dato='';
		foreach($insData as $col => $valor)
		{
			$dato.="'";
			$dato.=mysqli_real_escape_string($this->link, $valor);
			$columna.=mysqli_real_escape_string($this->link, $col);
			$columna.=',';
			$dato.="',";
		}
		 $datos=trim($dato,',');
		 $columnas=trim($columna,',');
				 
		$sql = "INSERT INTO $tableName (".$columnas.") VALUES (".$datos.")";

		 return mysqli_query($this->link, $sql);
		
	}
	
	public function actualizar($tableName_0, $col, $id_0, $insData)
	{
		$tableName = mysqli_real_escape_string($this->link, $tableName_0);
		$id = mysqli_real_escape_string($this->link, $id_0);
		foreach($insData as $columna => $dato_0) {
			
			$dato= mysqli_real_escape_string($this->link, $dato_0);
			$respuesta=mysqli_query($this->link, "UPDATE $tableName SET $columna = '".$dato."' WHERE $col = ".$id."") or die (mysqli_error($this->link));// or die(mysql_error());

		}
    	return $respuesta;
	}
	
	public function eliminar($tableName_0, $id_0)
	{
		$tableName = mysqli_real_escape_string($this->link, $tableName_0);
		for ($i=0; $i< count($id_0); $i++)
		{
			$id[$i] = mysqli_real_escape_string($this->link, $id_0[$i]);
			$sql="DELETE FROM $tableName WHERE ID='".$id[$i]."'";
			$respuesta=mysqli_query($this->link, $sql);  
		}
		return $respuesta;
	}
	
	public function cerrar()
	{
		mysqli_close($this->link);
	}
}

//PRUEBA DE INSERTAR EN BD

//$datos=array("CONTRASENA" => '123456');
/*
$host="multi022.mysql.guardedhost.com";
    $user_base="multi022_pagos";
    $pass_base="zvGw4Se4sh^8";
    $nom_base="multi022_pagos";

$prueba=new base();
$prueba->conectar_base($host, $user_base, $pass_base, $nom_base);

if ($datos=$prueba->actualizar('USUARIOS', 'ID', '31', $datos))
{
	echo "dato encontrado".$datos['TITULO'];
}
else 
{
	echo "Error al actualizar".$datos['TITULO'];
}




//PRUEBA BUSCAR 3


if ($datos=$prueba->buscar3('EVENTOS_RECORDATORIO', 'id_eventos', '12'))
{
	while ($indice = mysqli_fetch_array($datos, MYSQL_ASSOC)) {
		echo "<tr>";
		foreach ($indice as $ind => $col_value) {
        echo 'indice ='.$ind.' ='.$col_value.'<br>';
        if($ind == "ID")
			{
											//$conex->eliminar('EVENTOS_RECORDATORIO', $col_value);
				echo "<hr> INDICE = ".$col_value;
			}
		}
		echo "<hr>";
		}
	
}
else 
{
	echo "Error al buscar 2".$datos['TITULO'];
}

*/
?>
