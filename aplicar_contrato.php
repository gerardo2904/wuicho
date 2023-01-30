
<?php require_once('Connections/contratos_londres.php'); 
require_once('Funciones/funciones.php');
?>

<?php

	funciones_reemplazadas();



	$recordID =$_GET['parametro1']; // Clave contrato (clave_contrato)
	
	$updateSQL=sprintf("UPDATE contrato SET aplicado=%s WHERE clave_contrato=".$recordID,GetSQLValueString("1","text"));
	mysqli_select_db($contratos_londres, $database_contratos_londres);
	$Result1 = mysqli_query($contratos_londres,$updateSQL) or die(mysqli_error($contratos_londres));
	
	echo "<SCRIPT language=\"JavaScript\">
		alert(\"Orden de trabajo apliacada...\");
	</script>";

	
    // redirige a pagina de listado de contratos...
	$updateGoTo = "contratos_list.php";
		 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
?>