
<?php 
require_once('Connections/contratos_londres.php');
require_once('Funciones/funciones.php');


funciones_reemplazadas();




	$recordID1=$_GET['parametro1'];	// Tipo de dato a borrar
	$recordID2=$_GET['parametro2'];	// Clave de dato a borrar
	$recordID3=$_GET['parametro3'];	// Clave de dato a borrar
	
///USUARIOS

	if ($recordID1=="USUARIOS") {
	
		// Antes de borrar, necesitamos saber si el usuario esta en los movimientos de algun contrato.
		// Si es asi, no permitir borrar y sugerir que solo se ponga inactivo al usuario.
        /*	
		mysqli_select_db( $contratos_londres, $database_contratos_londres);
		$query_verifica_usuario = "select * from contrato WHERE clave_usuario=".$recordID2;
		$verifica_usuario = mysqli_query($contratos_londres, $query_verifica_usuario) or die(mysqli_error($contratos_londres));
		$row_verifica_usuario = mysqli_fetch_assoc($verifica_usuario);
		$totalRows_verifica_usuario = mysqli_num_rows($verifica_usuario);
		mysqli_free_result($verifica_usuario);
		*/
		$totalRows_verifica_usuario = 0; // por lo pronto, evitando que aborte una condicion que evaluaba en otra tabla (contrato)
		if ($totalRows_verifica_usuario<>0) {
			echo "<script language='javascript'> alert('No se puede borrar Usuario porque ya tiene movimientos en algun contrato. Te sugerimos ponerlo Inactivo.'); </script> ";
		}
		else {
			if ($recordID2<>1 && $recordID2<>0) {
				$updateSQL = sprintf("DELETE from usuarios WHERE clave_usuario='$recordID2'");
				mysqli_select_db( $contratos_londres, $database_contratos_londres);
				$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
			}
			else
			{
				if ($recordID2==1) {
					echo "<script language='javascript'> alert('El usuario Admin no se puede borrar.'); </script> ";
				}
			}
		}
		
		// redirige a pagina de listado de Usuarios...
		$updateGoTo = "usuarios_list.php";
		Echo "<SCRIPT language=\"JavaScript\">
		<!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
	}
	
///EMPRESAS

	if ($recordID1=="EMPRESAS") {
	
		// Antes de borrar, necesitamos saber si la empresa esta en los movimientos de algun contrato.
		// Si es asi, no permitir borrar y sugerir que solo se ponga inactivo la empresa.
		/*
		mysqli_select_db( $contratos_londres, $database_contratos_londres);
		$query_verifica_empresa = "select * from contrato WHERE clave_empresa=".$recordID2;
		$verifica_empresa = mysqli_query($contratos_londres, $query_verifica_empresa) or die(mysqli_error($contratos_londres));
		$row_verifica_empresa = mysqli_fetch_assoc($verifica_empresa);
		$totalRows_verifica_empresa = mysqli_num_rows($verifica_empresa);
		mysqli_free_result($verifica_empresa);
		*/

		$totalRows_verifica_empresa = 0;

		if ($totalRows_verifica_empresa<>0) {
			echo "<script language='javascript'> alert('No se puede borrar Empresa porque ya tiene movimientos en algun contrato. Te sugerimos ponerlo Inactivo.'); </script> ";
		}
		else {
			$updateSQL = sprintf("DELETE from empresa WHERE clave_empresa='$recordID2'");
			mysqli_select_db( $contratos_londres, $database_contratos_londres);
			$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
		}
		
		// redirige a pagina de listado de Empresas...
		$updateGoTo = "empresas_list.php";
		Echo "<SCRIPT language=\"JavaScript\">
		<!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
	}

///MONEDAS

	if ($recordID1=="MONEDAS") {
	
		// Antes de borrar, necesitamos saber si la moneda esta en los movimientos de algun contrato.
		// Si es asi, no permitir borrar y sugerir que solo se ponga inactivo la moneda.
		/*
		mysqli_select_db( $contratos_londres, $database_contratos_londres);
		$query_verifica_moneda = "select * from contrato WHERE clave_moneda=".$recordID2;
		$verifica_moneda = mysqli_query($contratos_londres, $query_verifica_moneda) or die(mysqli_error($contratos_londres));
		$row_verifica_moneda = mysqli_fetch_assoc($verifica_moneda);
		$totalRows_verifica_moneda = mysqli_num_rows($verifica_moneda);
		mysqli_free_result($verifica_moneda);
		
		*/
		$totalRows_verifica_moneda = 0;

		if ($totalRows_verifica_moneda<>0) {
			echo "<script language='javascript'> alert('No se puede borrar Moneda porque ya tiene movimientos en algun contrato. Te sugerimos ponerlo Inactivo.'); </script> ";
		}
		else {
			$updateSQL = sprintf("DELETE from monedas WHERE clave_moneda='$recordID2'");
			mysqli_select_db( $contratos_londres, $database_contratos_londres);
			$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
		}
		
		// redirige a pagina de listado de monedas...
		$updateGoTo = "monedas_list.php";
		Echo "<SCRIPT language=\"JavaScript\">
		<!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
	}
	
 ///COBRADORES

	if ($recordID1=="COBRADORES") {
	
		// Antes de borrar, necesitamos saber si el cobrador esta en los movimientos de algun contrato.
		// Si es asi, no permitir borrar y sugerir que solo se ponga inactivo el cobrador.
		/*
		mysqli_select_db( $contratos_londres, $database_contratos_londres);
		$query_verifica_cobrador = "select * from contrato WHERE clave_cobrador=".$recordID2;
		$verifica_cobrador = mysqli_query($contratos_londres, $query_verifica_cobrador) or die(mysqli_error($contratos_londres));
		$row_verifica_cobrador = mysqli_fetch_assoc($verifica_cobrador);
		$totalRows_verifica_cobrador = mysqli_num_rows($verifica_cobrador);
		mysqli_free_result($verifica_cobrador);
		
		*/

		$totalRows_verifica_cobrador = 0;

		if ($totalRows_verifica_cobrador<>0) {
			echo "<script language='javascript'> alert('No se puede borrar el Cobrador porque ya tiene movimientos en algun contrato. Te sugerimos ponerlo Inactivo.'); </script> ";
		}
		else {
			$updateSQL = sprintf("DELETE from cobradores WHERE clave_cobrador='$recordID2'");
			mysqli_select_db( $contratos_londres, $database_contratos_londres);
			$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
		}
		
		// redirige a pagina de listado de cobradores...
		$updateGoTo = "cobradores_list.php";
		Echo "<SCRIPT language=\"JavaScript\">
		<!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
	}
 
///TESTIGOS

	if ($recordID1=="TESTIGOS") {
	
		// Antes de borrar, necesitamos saber si el testigo esta en los movimientos de algun contrato.
		// Si es asi, no permitir borrar y sugerir que solo se ponga inactivo el testigo.
		/*
		mysqli_select_db( $contratos_londres, $database_contratos_londres);
		$query_verifica_testigo = "select * from contrato WHERE clave_testigo=".$recordID2;
		$verifica_testigo = mysqli_query($contratos_londres, $query_verifica_testigo) or die(mysqli_error($contratos_londres));
		$row_verifica_testigo = mysqli_fetch_assoc($verifica_testigo);
		$totalRows_verifica_testigo = mysqli_num_rows($verifica_testigo);
		mysqli_free_result($verifica_testigo);
		
		*/

		$totalRows_verifica_testigo = 0;

		if ($totalRows_verifica_testigo<>0) {
			echo "<script language='javascript'> alert('No se puede borrar el Testigo porque ya tiene movimientos en algun contrato. Te sugerimos ponerlo Inactivo.'); </script> ";
		}
		else {
			$updateSQL = sprintf("DELETE from testigos WHERE clave_testigo='$recordID2'");
			mysqli_select_db( $contratos_londres, $database_contratos_londres);
			$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
		}
		
		// redirige a pagina de listado de testigos...
		$updateGoTo = "testigos_list.php";
		Echo "<SCRIPT language=\"JavaScript\">
		<!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
	}

///VENDEDORES

	if ($recordID1=="VENDEDORES") {
	
		// Antes de borrar, necesitamos saber si el vendedor esta en los movimientos de algun contrato.
		// Si es asi, no permitir borrar y sugerir que solo se ponga inactivo el vendedor.
		/*
		mysqli_select_db( $contratos_londres, $database_contratos_londres);
		$query_verifica_vendedor = "select * from contrato WHERE clave_vendedor=".$recordID2;
		$verifica_vendedor = mysqli_query($contratos_londres, $query_verifica_vendedor) or die(mysqli_error($contratos_londres));
		$row_verifica_vendedor = mysqli_fetch_assoc($verifica_vendedor);
		$totalRows_verifica_vendedor = mysqli_num_rows($verifica_vendedor);
		mysqli_free_result($verifica_vendedor);
		
		*/

		$totalRows_verifica_vendedor = 0;

		if ($totalRows_verifica_vendedor<>0) {
			echo "<script language='javascript'> alert('No se puede borrar el Vendedor porque ya tiene movimientos en algun contrato. Te sugerimos ponerlo Inactivo.'); </script> ";
		}
		else {
			$updateSQL = sprintf("DELETE from vendedores WHERE clave_vendedor='$recordID2'");
			mysqli_select_db( $contratos_londres, $database_contratos_londres);
			$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
		}
		
		// redirige a pagina de listado de vendedores...
		$updateGoTo = "vendedores_list.php";
		Echo "<SCRIPT language=\"JavaScript\">
		<!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
	}	

///CLIENTES

	if ($recordID1=="CLIENTES") {
	
		// Antes de borrar, necesitamos saber si el cliente esta en los movimientos de algun contrato.
		// Si es asi, no permitir borrar y sugerir que solo se ponga inactivo el cliente.
		/*
		mysqli_select_db( $contratos_londres, $database_contratos_londres);
		$query_verifica_cliente = "select * from contrato WHERE clave_cliente=".$recordID2;
		$verifica_cliente = mysqli_query($contratos_londres, $query_verifica_cliente) or die(mysqli_error($contratos_londres));
		$row_verifica_cliente = mysqli_fetch_assoc($verifica_cliente);
		$totalRows_verifica_cliente = mysqli_num_rows($verifica_cliente);
		mysqli_free_result($verifica_cliente);
		
		*/
		
		$totalRows_verifica_cliente = 0;

		if ($totalRows_verifica_cliente<>0) {
			echo "<script language='javascript'> alert('No se puede borrar el Cliente porque ya tiene movimientos en algun contrato. Te sugerimos ponerlo Inactivo.'); </script> ";
		}
		else {
			$updateSQL = sprintf("DELETE from clientes WHERE clave_cliente='$recordID2'");
			mysqli_select_db( $contratos_londres, $database_contratos_londres);
			$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
		}
		
		// redirige a pagina de listado de clientes...
		$updateGoTo = "clientes_list.php";
		Echo "<SCRIPT language=\"JavaScript\">
		<!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
	}	

	if($recordID1=="REFACCIONES"){

		mysqli_select_db( $contratos_londres, $database_contratos_londres);
		$query_verifica_contrato = "select * from contrato WHERE clave_contrato=".$recordID2." AND aplicado=0";
		$verifica_contrato = mysqli_query($contratos_londres, $query_verifica_contrato) or die(mysqli_error($contratos_londres));
		$row_verifica_contrato = mysqli_fetch_assoc($verifica_contrato);
		$totalRows_verifica_contrato = mysqli_num_rows($verifica_contrato);
		mysqli_free_result($verifica_contrato);

		if ($totalRows_verifica_contrato==0) {
			echo "<script language='javascript'> alert('No se puede borrar la refacción porque la orden de trabajo ya se cerro.'); </script> ";
		}else{
			$updateSQL = sprintf("DELETE from refacciones WHERE id_refaccion='$recordID3'");
			mysqli_select_db( $contratos_londres, $database_contratos_londres);
			$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
		}

		// redirige a pagina de listado de clientes...
		$updateGoTo = "captura_refacciones.php?parametro1=".$recordID2;
		Echo "<SCRIPT language=\"JavaScript\">
		<!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	



	}
 
?>