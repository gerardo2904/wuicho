
<?php require_once('Connections/contratos_londres.php'); ?>

<?php

	if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

	$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

	switch ($theType) {
		case "text":
		$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		break;    
		case "long":
		case "int":
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		break;
		case "double":
		$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
		break;
		case "date":
		$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		break;
		case "defined":
		$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		break;
	}
	return $theValue;
	}
	}



	$recordID =$_GET['parametro1']; // Clave contrato (clave_contrato)
	$recordID1=$_GET['parametro2'];	// Auto (clave_inv)
	$recordID2=$_GET['parametro3'];	// Auto a cambio (clave_inv_acambio)
	
	// Actualiza el estado de los Autos.
	// Si se borra el auto, quitarle la marca de reservado...
	if ($recordID1<>0)
	{
		mysql_select_db($database_contratos_londres, $contratos_londres);
		$query_actualiza = "select * from contrato WHERE clave_contrato=".$recordID." AND clave_inv=".$recordID1;
		$actualiza = mysql_query($query_actualiza, $contratos_londres) or die(mysql_error());
		$row_actualiza = mysql_fetch_assoc($actualiza);
		$totalRows_actualiza = mysql_num_rows($actualiza);
		
		if ($totalRows_actualiza==1 && $row_actualiza['clave_inv']<>0) {  // Se encontro el contrato y el auto.
			//Actualiza a 0 la bandera de reservado al auto anterior.
				$updateSQL=sprintf("UPDATE inventario_auto SET reservado=%s WHERE clave_inv=".$row_actualiza['clave_inv'],GetSQLValueString("0","text"));
				mysqli_select_db($contratos_londres, $database_contratos_londres);
				$Result1 = mysqli_query($contratos_londres,$updateSQL) or die(mysql_error());
		}
		mysql_free_result($actualiza);
	}

	// Actualiza el estado de los Autos a cambio.
	// Si se borra el auto, quitarle la marca de reservado...
	if ($recordID2<>0)
	{
		mysql_select_db($database_contratos_londres, $contratos_londres);
		$query_actualiza = "select * from contrato WHERE clave_contrato=".$recordID." AND clave_inv_acuenta=".$recordID2;
		$actualiza = mysql_query($query_actualiza, $contratos_londres) or die(mysql_error());
		$row_actualiza = mysql_fetch_assoc($actualiza);
		$totalRows_actualiza = mysql_num_rows($actualiza);
	
		if ($totalRows_actualiza==1 && $row_actualiza['clave_inv_acuenta']<>0) {  // Se encontro el contrato y el auto.
			//Actualiza a 0 la bandera de reservado al auto anterior
				$updateSQL=sprintf("UPDATE inventario_auto SET reservado=%s WHERE clave_inv=".$row_actualiza['clave_inv_acuenta'],GetSQLValueString("0","text"));
				mysqli_select_db($contratos_londres, $database_contratos_londres);
				$Result1 = mysqli_query($contratos_londres,$updateSQL) or die(mysqli_error());
		}
		mysqli_free_result($actualiza);
	}
	
	// Borra el contrato...
	$updateSQL = sprintf("DELETE from contrato WHERE clave_contrato='$recordID'");
	mysqli_select_db($contratos_londres, $database_contratos_londres);
	$Result1 = mysqli_query($contratos_londres,$updateSQL) or die(mysql_error());
	
	
    // redirige a pagina de listado de contratos...
	$updateGoTo = "contratos_list.php";
		 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
?>