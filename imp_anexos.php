<?php include('Funciones/funciones.php'); ?>
<?php require_once('Connections/contratos_londres.php'); 

//echo "parametro1=".$parametro1."&parametro2=".$parametro2."&parametro3=".$parametro3."&autorizacion=".$autorizacion."&moneda=".$moneda."&bomba=".$bomba."&pedido=".$pedido."&apertura=".$apertura."&costo_apertura=".$costo_apertura."&placas=".$placas."&calendario=".$calendario."&vendedor=".$vendedor."&doc_contratos=".$doc_contratos."&doc_pagares=".$doc_pagares."&doc_solcredcliente=".$doc_solcredcliente."&doc_solcredaval=".$doc_solcredaval."&doc_identiclientes=".$doc_identiclientes."&doc_identiaval=".$doc_identiaval."&doc_comprodomicilio=".$doc_comprodomicilio."&doc_predial=".$doc_predial."&ventas=".$ventas."&puntualidad=".$puntualidad."&bono_puntualidad=".$bono_puntualidad."&cobranza_tardia=".$cobranza_tardia."&doc_observaciones=".$doc_observaciones."&domicilio_lote=".$domicilio_lote;

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2,1";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}


$MM_restrictGoTo = "conectar_empresa.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

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

	

$recordID=$_GET['parametro1'];   // clave_contrato
$recordID0=$_GET['parametro2'];  // clave_empresa
$recordID1=$_GET['parametro3'];  // clave_cliente

//$autorizacion=$_GET["autorizacion"];



$filtro="";
$filtro=" where clave_contrato='$recordID'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_contra = "select clave_contrato, contrato, contrato.clave_empresa, contrato.clave_cliente, contrato.no_pagos, contrato.clave_inv, forma_pago, 
DATE_FORMAT(fecha_contrato, '%d-%m-%Y') AS fecha_contrato, interes, moratorio, saldo_inicial, cprecio, cenganche, civa, ctotal, cacuenta,  promocion, clientes.nombre_cliente, clientes.rfc_cliente,
clientes.domicilio_cliente, clientes.ciudad_cliente, clientes.estado_cliente, clientes.cp_cliente, clientes.tel_cliente, clientes.fax_cliente, 
clientes.email_cliente, monedas.moneda, vendedores.nombre_vendedor, empresa.representante_empresa, empresa.domicilio_empresa from contrato, clientes, monedas, empresa, vendedores  ".$filtro." AND contrato.clave_cliente=clientes.clave_cliente AND contrato.clave_moneda=monedas.clave_moneda AND contrato.clave_vendedor=vendedores.clave_vendedor AND contrato.clave_empresa=empresa.clave_empresa ";
$contra = mysqli_query($contratos_londres, $query_contra) or die(mysql_error());
$row_contra = mysqli_fetch_assoc($contra);
$totalRows_contra = mysqli_num_rows($contra);

$filtro="";
$filtro=" where clave_empresa='$recordID0'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_emp = "select * from empresa".$filtro;
$emp = mysqli_query($contratos_londres, $query_emp) or die(mysql_error());
$row_emp = mysqli_fetch_assoc($emp);
$totalRows_emp = mysqli_num_rows($emp);

$filtro="";
$filtro=" where clave_cliente='$recordID1'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_ava = "select * from avales".$filtro;
$ava = mysqli_query($contratos_londres, $query_ava) or die(mysql_error());
$row_ava = mysqli_fetch_assoc($ava);
$totalRows_ava = mysqli_num_rows($ava);

$filtro="";
$filtro=" where clave_cliente='$recordID1'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_ava2 = "select * from avales".$filtro;
$ava2 = mysqli_query($contratos_londres, $query_ava2) or die(mysql_error());
$row_ava2 = mysqli_fetch_assoc($ava2);
$totalRows_ava2 = mysqli_num_rows($ava2);

$filtro="";
$filtro=" where clave_contrato='$recordID'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_pagares = "select clave_pagare, numero_pagare, DATE_FORMAT(fecha_pagare, '%d-%m-%Y') AS fecha_pagare, DATE_FORMAT(vence_pagare, '%d-%m-%Y') AS vence_pagare, importe_pagare, clave_contrato, pagado, vencido from pagares".$filtro;
$pagares = mysqli_query($contratos_londres, $query_pagares) or die(mysql_error());
$row_pagares = mysqli_fetch_assoc($pagares);
$totalRows_pagares = mysqli_num_rows($pagares);


$var=" AND clave_inv=".$row_contra['clave_inv']; 
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_autos_d = "SELECT inventario_auto.*, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca
 FROM inventario_auto, tipo_auto, marca 
 WHERE inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca".$var;
$autos_d = mysqli_query($contratos_londres, $query_autos_d) or die(mysql_error());
$row_autos_d = mysqli_fetch_assoc($autos_d);
$totalRows_autos_d = mysqli_num_rows($autos_d);

	$fecha_del_primerpago=$row_contra['primerpago'];
	
	ob_end_clean();
	$pdf=new PDF('P','mm','Letter'); 
	$pdf->Open();  

	if ($autorizacion='1')
	{
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',15); 
		$pdf->AliasNbPages();
		$pdf->Ln(6);
		$pdf->Image('Imagenes/londres_logo4.jpg',20,17,45);
		$pdf->Ln(35);
		$pdf->SetLeftMargin(20);
				
		$texto=iconv('UTF-8', 'windows-1252',"Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".");
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(25);
		$pdf->SetFont('Arial','UB',15); 
		$texto=iconv('UTF-8', 'windows-1252',"AUTORIZACION DEL CLIENTE PARA INVESTIGACION");
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->Ln(15);
		$pdf->SetFont('Arial','B',12); 
		$texto='Estoy solicitando un crédito a AUTOS LONDRES en su promoción "'.strtoupper(trim($row_contra["promocion"])).'", ';
		$texto=$texto.'por lo que no tengo ningún inconveniente en dar mi autorización para que realicen una investigación sobre ';
		$texto=$texto.'los datos proporcionados en mi solicitud.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(10);
		$texto='Esperando sea aprobado mi crédito y asi aprovechar esta promoción, firmo de autorización.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(40);
		$texto=trim($row_contra["nombre_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->Ln(-3);
		$texto='_________________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->Ln(1);
		$texto='NOMBRE Y FIRMA DEL CLIENTE';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'C'); 
	}


	if ($moneda='1')
	{
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->Ln(6);
		$pdf->Image('Imagenes/londres_logo4.jpg',20,17,45);
		$pdf->Ln(30);
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','B',12); 
		
		$texto=iconv('UTF-8', 'windows-1252',"Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".");
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(15);
		$texto=iconv('UTF-8', 'windows-1252',"Al momento de llenar la solicitud de crédito, tuve dos opciones:");
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(15);
		$texto='A) Contratar en MONEDA NACIONAL, que causa un interés de financiamiento a razon del 2% mensual.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(10);
		$texto='B) Contratar en Dolares, moneda de LOS ESTADOS UNIDOS DE NORTE AMERICA.  El crédito se otorga sin intereses de financiamiento.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		
		if (trim($row_contra["moneda"])=='Dolar') {
			$pdf->Ln(10);
			$pdf->SetFont('Arial','UB',12); 
			$texto='POR LO QUE LA DESICION QUE TOME, ES LA OPCION "B" A CELEBRAR EL CONTRATO DE COMPRA VENTA EN DOLARES.';
			$texto=iconv('UTF-8', 'windows-1252',$texto);
			$pdf->MultiCell(164,4,$texto,0,'J');
		}else {
			$pdf->Ln(10);
			$pdf->SetFont('Arial','UB',12); 
			$texto='POR LO QUE LA DESICION QUE TOME, ES LA OPCION "A" A CELEBRAR EL CONTRATO DE COMPRA VENTA EN MONEDA NACIONAL, CON INTERES DEL 2% MENSUAL POR FINANCIEMIENTO.';
			$texto=iconv('UTF-8', 'windows-1252',$texto);
			$pdf->MultiCell(164,4,$texto,0,'J');	
		}

		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',12); 
		$texto='No tengo ningún inconveniente en otorgar mi autorización para que realicen una investigación sobre los datos proporcionados en mi solicitud.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');
		

		$pdf->Ln(10);
		$texto='Asimismo, hago constar que acepto pagar el costo que tiene la apertura de crédito y que consiste en la cantidad de $110.00 DOLARES MAS IVA.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');

		$pdf->Ln(10);
		$texto='DE CONFORMIDAD:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->Ln(17);
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','B',10); 
		$texto=trim($row_contra["nombre_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->Ln(-1);
		$texto='__________________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,2,$texto,0,'C');
		
		$pdf->Ln(2);
		$texto='NOMBRE Y FIRMA DEL CLIENTE';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,2,$texto,0,'C');
		
		$pdf->Ln(17);
		$pdf->SetLeftMargin(20);
		$texto=trim($row_ava["nombre_aval"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,1,$texto,0,'C');
		
		$pdf->Ln(-1);		
		$texto='__________________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,2,$texto,0,'C');
		
		$pdf->Ln(2);		
		$texto='NOMBRE Y FIRMA DEL AVAL';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,2,$texto,0,'C');
		
		$pdf->SetLeftMargin(20);
		
		$pdf->Ln(17);
		$texto='__________________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->Ln(1);
		$texto='AUTOS LONDRES';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'C');
	}


	if ($bomba='1')
	{
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->Ln(6);
		$pdf->Image('Imagenes/londres_logo4.jpg',20,17,45);
		$pdf->Ln(35);
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','B',12); 
		
		$texto=iconv('UTF-8', 'windows-1252',"Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".");
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(15);
		$pdf->SetFont('Arial','B',15); 
		$texto=iconv('UTF-8', 'windows-1252',"BOMBA DE GASOLINA Y CATALIZADORES SIN GARANTIA");
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',12); 
		$texto='A todos nuestros clientes, les hacemos una coordial invitación para mantener en buenas condiciones el estado de su vehículo.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(5);
		$texto='Al momento de recibir el automovil, la bomba de gasolina trabaja normalmente.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(5);
		$texto='La falta de gasolina en el tanque, descompone la bomba, ya que esta es eléctrica y absorbe basura, puede dañar el ';
		$texto=$texto.'sistema de inyección del automovil. LA BOMBA DE GASOLINA NO TIENE GARANTIA.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(5);
		$texto='Se recomienda utilizar gasolina de buena calidad, como medida precautoria y de esta manera conservar en buen estado ';
		$texto=$texto.'y con mayor rendimiento la bomba de gasolina.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');

		$pdf->Ln(5);
		$texto='En la actualidad ha aumentado el robo de los catalizadores de los vehículos en nuestra ciudad, por lo que se ';
		$texto=$texto.'recomienda tener cuidado en donde dejan estacionado su automovil. LOS CATALIZADORES NO TIENEN GARANTIA.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');

		$pdf->Ln(5);
		$texto='Después de revisar el automovil de los catalizadores, estoy de acuerdo que tiene su(s) catalizador(es) instalado(s). ';
		$texto=$texto.'De existir algún problema en el futuro, AUTOS LONDRES NO SERA RESPONSABLE, YA QUE NO EXISTE GARANTIA ALGUNA.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(17);
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','B',10); 
		$texto=trim($row_contra["nombre_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->Ln(-1);
		$texto='__________________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,2,$texto,0,'C');
		
		$pdf->Ln(2);
		$texto='NOMBRE Y FIRMA DEL CLIENTE';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,2,$texto,0,'C');
		
		$pdf->Ln(17);
		$pdf->SetLeftMargin(20);
		$texto=trim($row_ava["nombre_aval"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,1,$texto,0,'C');
		
		$pdf->Ln(-1);		
		$texto='__________________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,2,$texto,0,'C');
		
		$pdf->Ln(2);		
		$texto='NOMBRE Y FIRMA DEL AVAL';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,2,$texto,0,'C');
		
		$pdf->SetLeftMargin(20);
		
		$pdf->Ln(17);
		$texto='__________________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->Ln(1);
		$texto='AUTOS LONDRES';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'C');
	}

///////

	if ($pedido='1')
	{
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->Ln(6);
		$pdf->Image('Imagenes/londres_logo4.jpg',20,17,45);
		
		
		
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',15); 
		$texto=iconv('UTF-8', 'windows-1252',"PEDIDO");
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->Ln(15);
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','B',12); 
		$texto=iconv('UTF-8', 'windows-1252',"Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".");
		$pdf->Cell(80,4,$texto,0,'J');
		$pdf->SetLeftMargin(130);
		$pdf->Cell(0,4,"Pedido:________________",0,'J');
		$pdf->SetLeftMargin(20);
		$pdf->Ln(8);
		$pdf->Cell(15,4,"LOTE: ",0,'J');
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,4,$row_emp["nombre_empresa"],0,'J');
		$pdf->SetFont('Arial','B',12);
		$pdf->Ln(8);
		$pdf->SetFont('Arial','UB',12); 
		$texto='Datos del Cliente.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');

		$pdf->Ln(3);
		$pdf->SetFont('Arial','B',10); 
		$texto='Nombre:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["nombre_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Domicilio:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["domicilio_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='C.P.:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["cp_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Ciudad:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=trim($row_contra["ciudad_cliente"]).", ".trim($row_contra["estado_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');

		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Telefono(s):';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["tel_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Fax:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["fax_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='email:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["email_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(8);
		$pdf->SetFont('Arial','UB',12); 
		$texto='Datos del Vehículo.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');

	$pdf->SetLeftMargin(20);
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(25,3,"MODELO ",0,0);$pdf->Cell(55,3,$row_autos_d["ano"],0,0);$pdf->Cell(25,3,"MARCA",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["marca"]));
	
	$i="";
	switch ($row_autos_d["estilo"]) {
    case "automovil":
        $i="Automovil";
        break;
    case "todoterreno":
        $i="Todo Terreno";
        break;
    case "pickup":
        $i="Pickup";
        break;
	case "minivan":
        $i="Mini Van";
        break;	
	}
	
	$pdf->Ln(4);
	$pdf->Cell(25,3,"TIPO ",0,0);$pdf->Cell(55,3,strtoupper($i),0,0);$pdf->Cell(25,3,"LINEA",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["modelo"]));
	//$pdf->Cell(0,3,$row_autos_d["marca"]." ".$row_autos_d["modelo"]." ".$row_autos_d["ano"].", el cual tiene motor de ".$row_autos_d["motor"]." cilindros y odometro con ".$row_autos_d["km"]." millas.",0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ODOMETRO ",0,0);$pdf->Cell(55,3,number_format($row_autos_d["km"]),0,0);$pdf->Cell(25,3,"COLOR",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["color"]));
	//$pdf->Cell(0,3,$row_autos_d["especificaciones"],0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"CILINDROS ",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["motor"]),0,0);$pdf->Cell(25,3,"SERIE",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["serie"]));
	//$pdf->Cell(0,3,"No. serie: ".trim($row_autos_d["serie"]).", No. pedimento: ".trim($row_autos_d["pedimento"]).", Aduana: ".trim($row_autos_d["aduana"]),0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ADUANA ",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["aduana"]),0,0);$pdf->Cell(25,3,"PEDIMENTO",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["pedimento"]));
	
	//*********************************
	
	$pdf->Ln(8);
	$i="";
	//echo "Moneda: ".$row_contra["moneda"]."<BR>";
	switch ($row_contra["moneda"]) {
    case "Dolar":
        $i="DLLS. MONEDA DE LOS EUA.";
        break;
    case "Peso":
        $i="Pesos. MONEDA NACIONAL MEXICANA";
        break;
	}
	//echo "Moneda: ".$i."<BR>";
	
	$str=iconv('UTF-8', 'windows-1252',"VALOR DE LA UNIDAD ");
		$pdf->Cell(75,3,$str,0,0);
	
 	
		$str=iconv('UTF-8', 'windows-1252',"$".number_format($row_contra["cprecio"],2));
		$pdf->Cell(25,3,$str,0,0,"R");
	$str=iconv('UTF-8', 'windows-1252',$i);	
		$pdf->Cell(60,3,$str,0,0,"R");
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"ENGANCHE A LA FIRMA DEL CONTRATO");
		$pdf->Cell(75,3,$str,0,0);
	
	$pdf->Cell(26,3,"("."$".number_format($row_contra["cenganche"],2).")",0,0,"R");

		$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"UNIDAD USADA A CUENTA ");
		$pdf->Cell(75,3,$str,0,0);
		$v=$row_contra["cacuenta"];if (is_int((int) $v)) {$v=$v.".00";}
		$pdf->Cell(26,3,"("."$".number_format($row_contra["cacuenta"],2).")",0,0,"R");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"SALDO ");
		$pdf->Cell(75,3,$str,0,0);
		
		$pdf->Cell(25,3,"$".number_format($row_contra["saldo_inicial"],2),0,0,"R");
	$pdf->Ln(6);
	$str=iconv('UTF-8', 'windows-1252',"INTERESES ");
		$pdf->Cell(75,3,$str,0,0);
		
		$pdf->Cell(25,3,"$".number_format($row_contra["cinteres"],2),0,0,"R");
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"IVA ");
		$pdf->Cell(75,3,$str,0,0);
		$pdf->Cell(25,3,"$".number_format($row_contra["civa"],2),0,0,"R");	
	$pdf->Ln(6);	
	$str=iconv('UTF-8', 'windows-1252',"SALDO ");
		$pdf->Cell(75,3,$str,0,0);
	$str=iconv('UTF-8', 'windows-1252',"$".number_format($row_contra["ctotal"],2));
		$pdf->Cell(25,3,$str,0,0,"R");
	$str=iconv('UTF-8', 'windows-1252',$i);	
		$pdf->Cell(60,3,$str,0,0,"R");
		
		
	$pdf->SetLeftMargin(20);
		$pdf->Ln(10);
		$pdf->SetFont('Arial','UB',10); 
		$texto=strtoupper('Forma de Pago:');
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->Ln(5);
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','',8);
		$texto=strtoupper($row_contra["forma_pago"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'J');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(10);
		$pdf->SetFont('Arial','UB',12); 
		$texto='Datos del Aval.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');

		$pdf->Ln(3);
		$pdf->SetFont('Arial','B',10); 
		$texto='Nombre:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_ava["nombre_aval"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Domicilio:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_ava["domicilio_aval"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='C.P.:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_ava["cp_aval"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Ciudad:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=trim($row_ava["ciudad_aval"]).", ".trim($row_ava["estado_aval"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');

		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Telefono(s):';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_ava["tel_aval"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Fax:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_ava["fax_aval"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='email:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_ava["email_aval"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetFont('Arial','',10);
		$pdf->SetLeftMargin(20);
		$pdf->Ln(20);
		$texto=trim($row_contra["nombre_vendedor"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(-3);
		$texto='________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(1);
		$texto='VENDEDOR';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
	}

//////////////////////////////////////////////////////////////////////////////////

	if ($apertura='1')
	{
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->SetLeftMargin(10);
		$pdf->Ln(2);
	
		$pdf->SetFont('Arial','B',12); 
		$texto="\nCORPORATIVO DE SERVICIOS LUXOR, S.C. \n\n";
		$texto=$texto."SERVICIOS DE ASESORIA EN ADMINISTRACION Y ORGANIZACION DE EMPRESAS\n\n";
		$texto=$texto."R.F.C. CSL940715L27\n\n";
		$texto=$texto."REPORTE DE APERTURA DE CREDITO\n\n";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,4,$texto,'TLR','C');
		
		$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(194,4,$texto,'LR','C');
		//$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(174,4,$texto,'LR','C');

		$pdf->SetFont('Arial','B',10); 
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\tFECHA:");
		$pdf->Cell(14,4,$texto,0,'L');

		$pdf->SetFont('Arial','',9); 
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\t\t\t\t\t\t\t\t\tTijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]));
		$pdf->Cell(60,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(130);
		$pdf->SetFont('Arial','B',10); 
		$texto=iconv('UTF-8', 'windows-1252',"IMPORTE:");
		$pdf->Cell(14,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(150);
		$pdf->SetFont('Arial','',10); 
		$texto=iconv('UTF-8', 'windows-1252',"$".number_format($_GET['costo_apertura'],2). "  M.N.");
		$pdf->Cell(54,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto="\t\t\tCLIENTE:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["nombre_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,0,'L');
		

		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto="\t\t\tDOMICILIO:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["domicilio_cliente"];

		if (strlen($row_contra["cp_cliente"])>0) {$texto=$texto.", C.P. ".trim($row_contra["cp_cliente"]);}		
		
		$texto=$texto.", ".trim($row_contra["ciudad_cliente"]).", ".trim($row_contra["estado_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,0,'L');


		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto="\t\t\tTEL(s):";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["tel_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,0,'L');

		
		
	$pdf->SetLeftMargin(10);
	$pdf->Ln(4);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(25,3,"\t\t\tMODELO: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["ano"]),0,0);$pdf->Cell(25,3,"MARCA:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["marca"]),'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tLINEA: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["modelo"]),0,0);$pdf->Cell(25,3,"SERIE:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["serie"]),'R',0);

	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tCOLOR:",'L',0);$pdf->Cell(169,3,strtoupper($row_autos_d["color"]),'R',0);
	
	//Pone 10 renglones en blanco...
	for ($i=1;$i<10;$i++) {
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR');
	}
		$pdf->SetLeftMargin(10);
		$pdf->Ln(2);
		$pdf->SetFont('Arial','',9);
		$texto=trim($row_contra["nombre_vendedor"]);
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\t".$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		
		$pdf->Ln(0);
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
		$pdf->Ln(4);
		$texto="VENDEDOR";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		$texto="RECIBI";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR');
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR');
	
	$pdf->Ln(2);
	$pdf->Cell(194,3,"",'LR');
	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Ln(0);
	$pdf->Cell(194,3,"O     R     I     G     I     N     A     L",'B',0,'C');


///////***************************
		$pdf->SetLeftMargin(10);
		$pdf->Ln(25);
	
		$pdf->SetFont('Arial','B',12); 
		$texto="\nCORPORATIVO DE SERVICIOS LUXOR, S.C. \n\n";
		$texto=$texto."SERVICIOS DE ASESORIA EN ADMINISTRACION Y ORGANIZACION DE EMPRESAS\n\n";
		$texto=$texto."R.F.C. CSL940715L27\n\n";
		$texto=$texto."REPORTE DE APERTURA DE CREDITO\n\n";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,4,$texto,'TLR','C');
		
		$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(194,4,$texto,'LR','C');
		//$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(174,4,$texto,'LR','C');

		$pdf->SetFont('Arial','B',10); 
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\tFECHA:");
		$pdf->Cell(14,4,$texto,'L','L');

		$pdf->SetFont('Arial','',9); 
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\t\t\t\t\t\t\t\t\tTijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]));
		$pdf->Cell(60,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(130);
		$pdf->SetFont('Arial','B',10); 
		$texto=iconv('UTF-8', 'windows-1252',"IMPORTE:");
		$pdf->Cell(14,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(150);
		$pdf->SetFont('Arial','',10); 
		$texto=iconv('UTF-8', 'windows-1252',"$".number_format($_GET['costo_apertura'],2). "  M.N.");
		$pdf->Cell(54,4,$texto,'R','L');
		
		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto="\t\t\tCLIENTE:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["nombre_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');
		

		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto="\t\t\tDOMICILIO:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["domicilio_cliente"];

		if (strlen($row_contra["cp_cliente"])>0) {$texto=$texto.", C.P. ".trim($row_contra["cp_cliente"]);}		
		
		$texto=$texto.", ".trim($row_contra["ciudad_cliente"]).", ".trim($row_contra["estado_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');


		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto="\t\t\tTEL(s):";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["tel_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');

		
		
	$pdf->SetLeftMargin(10);
	$pdf->Ln(4);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(25,3,"\t\t\tMODELO: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["ano"]),0,0);$pdf->Cell(25,3,"MARCA:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["marca"]),'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tLINEA: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["modelo"]),0,0);$pdf->Cell(25,3,"SERIE:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["serie"]),'R',0);

	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tCOLOR:",'L',0);$pdf->Cell(169,3,strtoupper($row_autos_d["color"]),'R',0);
	
	//Pone 10 renglones en blanco...
	for ($i=1;$i<10;$i++) {
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR');
	}
		$pdf->SetLeftMargin(10);
		$pdf->Ln(2);
		$pdf->SetFont('Arial','',9);
		$texto=trim($row_contra["nombre_vendedor"]);
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\t".$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		
		$pdf->Ln(0);
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
		$pdf->Ln(4);
		$texto="VENDEDOR";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		$texto="RECIBI";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(2);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Ln(0);
	$pdf->Cell(194,3,"A     R     C     H     I     V     O",'B',0,'C');
		
	
	
///////***************************
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->SetLeftMargin(10);
		$pdf->Ln(2);
	
		$pdf->SetFont('Arial','B',12); 
		$texto="\nCORPORATIVO DE SERVICIOS LUXOR, S.C. \n\n";
		$texto=$texto."SERVICIOS DE ASESORIA EN ADMINISTRACION Y ORGANIZACION DE EMPRESAS\n\n";
		$texto=$texto."R.F.C. CSL940715L27\n\n";
		$texto=$texto."REPORTE DE APERTURA DE CREDITO\n\n";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,4,$texto,'TLR','C');
		
		$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(194,4,$texto,'LR','C');
		//$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(174,4,$texto,'LR','C');

		$pdf->SetFont('Arial','B',10); 
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\tFECHA:");
		$pdf->Cell(14,4,$texto,'L','L');

		$pdf->SetFont('Arial','',9); 
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\t\t\t\t\t\t\t\t\tTijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]));
		$pdf->Cell(60,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(130);
		$pdf->SetFont('Arial','B',10); 
		$texto=iconv('UTF-8', 'windows-1252',"IMPORTE:");
		$pdf->Cell(14,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(150);
		$pdf->SetFont('Arial','',10); 
		$texto=iconv('UTF-8', 'windows-1252',"$".number_format($_GET['costo_apertura'],2). "  M.N.");
		$pdf->Cell(54,4,$texto,'R','L');
		
		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto="\t\t\tCLIENTE:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["nombre_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');
		

		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto="\t\t\tDOMICILIO:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["domicilio_cliente"];

		if (strlen($row_contra["cp_cliente"])>0) {$texto=$texto.", C.P. ".trim($row_contra["cp_cliente"]);}		
		
		$texto=$texto.", ".trim($row_contra["ciudad_cliente"]).", ".trim($row_contra["estado_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');


		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto="\t\t\tTEL(s):";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["tel_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');

		
		
	$pdf->SetLeftMargin(10);
	$pdf->Ln(4);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(25,3,"\t\t\tMODELO: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["ano"]),0,0);$pdf->Cell(25,3,"MARCA:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["marca"]),'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tLINEA: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["modelo"]),0,0);$pdf->Cell(25,3,"SERIE:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["serie"]),'R',0);

	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tCOLOR:",'L',0);$pdf->Cell(169,3,strtoupper($row_autos_d["color"]),'R',0);
	
	//Pone 10 renglones en blanco...
	for ($i=1;$i<10;$i++) {
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	}
		$pdf->SetLeftMargin(10);
		$pdf->Ln(2);
		$pdf->SetFont('Arial','',9);
		$texto=trim($row_contra["nombre_vendedor"]);
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\t".$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		
		$pdf->Ln(0);
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
		$pdf->Ln(4);
		$texto="VENDEDOR";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		$texto="RECIBI";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(2);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Ln(0);
	$pdf->Cell(194,3,"C     O     B     R     A     N     Z     A",'B',0,'C');
	
	}
	
////PLACAS
	if ($placas='1')
	{
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->Ln(6);
		$pdf->Image('Imagenes/londres_logo4.jpg',20,17,45);
		
		
		
		$pdf->Ln(30);
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','B',12); 
		$texto=iconv('UTF-8', 'windows-1252',"Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".");
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		
		$pdf->Ln(18);
		$pdf->SetFont('Arial','',10); 
		$texto="A quien corresponda:\n";
		$texto=$texto.'Presente:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(18);
		$texto="Por medio de la presente, autorizo a:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(60,4,$texto,0,'J');
		
		$pdf->SetFont('Arial','BU',10); 
		$texto="Autos Londres,";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(24,4,$texto,0,'J');
		
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$texto="para que en mi nombre, tramite placas de la unidad que se describe a continuación:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(60,4,$texto,0,'J');
		
		
		
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(18);
		$pdf->SetFont('Arial','UB',10); 
		$texto='Datos del Vehículo.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');

	$pdf->SetLeftMargin(20);
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(25,3,"MODELO ",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["ano"]),0,0);$pdf->Cell(25,3,"MARCA",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["marca"]));
	
	$i="";
	switch ($row_autos_d["estilo"]) {
    case "automovil":
        $i="Automovil";
        break;
    case "todoterreno":
        $i="Todo Terreno";
        break;
    case "pickup":
        $i="Pickup";
        break;
	case "minivan":
        $i="Mini Van";
        break;	
	}
	
	$pdf->Ln(4);
	$pdf->Cell(25,3,"TIPO ",0,0);$pdf->Cell(55,3,strtoupper($i),0,0);$pdf->Cell(25,3,"LINEA",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["modelo"]));
	//$pdf->Cell(0,3,$row_autos_d["marca"]." ".$row_autos_d["modelo"]." ".$row_autos_d["ano"].", el cual tiene motor de ".$row_autos_d["motor"]." cilindros y odometro con ".$row_autos_d["km"]." millas.",0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ODOMETRO ",0,0);$pdf->Cell(55,3,number_format($row_autos_d["km"]),0,0);$pdf->Cell(25,3,"COLOR",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["color"]));
	//$pdf->Cell(0,3,$row_autos_d["especificaciones"],0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"CILINDROS ",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["motor"]),0,0);$pdf->Cell(25,3,"SERIE",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["serie"]));
	//$pdf->Cell(0,3,"No. serie: ".trim($row_autos_d["serie"]).", No. pedimento: ".trim($row_autos_d["pedimento"]).", Aduana: ".trim($row_autos_d["aduana"]),0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ADUANA ",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["aduana"]),0,0);$pdf->Cell(25,3,"PEDIMENTO",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["pedimento"]));
	
		$pdf->Ln(12);
		$texto="Registrado a nombre de ".trim($row_contra["representante_empresa"].".");
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(60,4,$texto,0,'J');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(40);
		$texto=trim($row_contra["nombre_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(-3);
		$texto='________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(1);
		$texto='FIRMA DEL COMPRADOR';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(15);
		$texto='________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(1);
		$texto='TESTIGO';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');

		$pdf->Ln(15);
		$texto='________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(1);
		$texto='TESTIGO';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');

	}


////PAGARES
	if ($calendario='1')
	{
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->Ln(6);
		$pdf->Image('Imagenes/londres_logo4.jpg',20,17,45);
		
		$pdf->Ln(30);
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','B',12); 
		$texto=iconv('UTF-8', 'windows-1252',"Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".");
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',10); 
		$texto="Cliente:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(20,4,$texto,0,'J');
		
		$pdf->SetFont('Arial','BU',8); 
		$texto=trim($row_contra["nombre_cliente"]);;
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(24,4,$texto,0,'J');
		
		$pdf->Ln(10);
		
		$pdf->SetFont('Arial','BUI',10);
		$texto="No. Pagare";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(60,4,$texto,0,'J'); 
		
		$pdf->SetFont('Arial','BUI',10);
		$texto="Importe";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(60,4,$texto,0,'J'); 
		
		$pdf->SetFont('Arial','BUI',10);
		$texto="Vencimiento";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(60,4,$texto,0,'J'); 
		
		
		
		do{
			$pdf->Ln(4);
			$pdf->SetFont('Arial','',10);
			$texto=$row_pagares["numero_pagare"];
			$texto=iconv('UTF-8', 'windows-1252',$texto);
			$pdf->Cell(60,4,$texto,0,'J'); 
		
			
			$texto=number_format($row_pagares["importe_pagare"],2);
			$texto=iconv('UTF-8', 'windows-1252',$texto);
			$pdf->Cell(60,4,$texto,0,'J'); 
		
			
			$texto=$row_pagares["vence_pagare"];
			$texto=iconv('UTF-8', 'windows-1252',$texto);
			$pdf->Cell(60,4,$texto,0,'J'); 
		
		}while($row_pagares = mysqli_fetch_assoc($pagares));
	}
	
	

///////

	if ($vendedor='1')
	{
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->Ln(6);
		$pdf->Image('Imagenes/londres_logo4.jpg',20,17,45);
		
		
		$pdf->SetLeftMargin(35);
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',15); 
		$texto=iconv('UTF-8', 'windows-1252',"REPORTE DEL VENDEDOR");
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(15);
		$pdf->SetFont('Arial','B',12); 
		$texto=iconv('UTF-8', 'windows-1252',"Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".");
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->Ln(8);
		$pdf->Cell(15,4,"LOTE: ",0,'J');
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,4,$row_emp["nombre_empresa"],0,'J');
		$pdf->SetFont('Arial','B',12);
		
		$pdf->Ln(8);
		$pdf->SetFont('Arial','B',10); 
		$texto='Vendedor:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetFont('Arial','BU',10); 
		$texto=trim($row_contra["nombre_vendedor"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->Ln(8);
		$pdf->SetFont('Arial','UB',12); 
		$texto='Datos del Cliente.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');

		$pdf->Ln(3);
		$pdf->SetFont('Arial','B',10); 
		$texto='Nombre:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["nombre_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Domicilio:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["domicilio_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='C.P.:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["cp_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Ciudad:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=trim($row_contra["ciudad_cliente"]).", ".trim($row_contra["estado_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');

		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Telefono(s):';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["tel_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='Fax:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["fax_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',10); 
		$texto='email:';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(45);
		$pdf->SetFont('Arial','',8);
		$texto=$row_contra["email_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(74,4,$texto,0,'L');
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(8);
		$pdf->SetFont('Arial','UB',12); 
		$texto='Datos del Vehículo.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');

	$pdf->SetLeftMargin(20);
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(25,3,"MODELO ",0,0);$pdf->Cell(55,3,$row_autos_d["ano"],0,0);$pdf->Cell(25,3,"MARCA",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["marca"]));
	
	$i="";
	switch ($row_autos_d["estilo"]) {
    case "automovil":
        $i="Automovil";
        break;
    case "todoterreno":
        $i="Todo Terreno";
        break;
    case "pickup":
        $i="Pickup";
        break;
	case "minivan":
        $i="Mini Van";
        break;	
	}
	
	$pdf->Ln(4);
	$pdf->Cell(25,3,"TIPO ",0,0);$pdf->Cell(55,3,strtoupper($i),0,0);$pdf->Cell(25,3,"LINEA",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["modelo"]));
	//$pdf->Cell(0,3,$row_autos_d["marca"]." ".$row_autos_d["modelo"]." ".$row_autos_d["ano"].", el cual tiene motor de ".$row_autos_d["motor"]." cilindros y odometro con ".$row_autos_d["km"]." millas.",0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ODOMETRO ",0,0);$pdf->Cell(55,3,number_format($row_autos_d["km"]),0,0);$pdf->Cell(25,3,"COLOR",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["color"]));
	//$pdf->Cell(0,3,$row_autos_d["especificaciones"],0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"CILINDROS ",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["motor"]),0,0);$pdf->Cell(25,3,"SERIE",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["serie"]));
	//$pdf->Cell(0,3,"No. serie: ".trim($row_autos_d["serie"]).", No. pedimento: ".trim($row_autos_d["pedimento"]).", Aduana: ".trim($row_autos_d["aduana"]),0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ADUANA ",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["aduana"]),0,0);$pdf->Cell(25,3,"PEDIMENTO",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["pedimento"]));
	
	//*********************************

		$pdf->Ln(15);
		$pdf->SetFont('Arial','UB',12); 
		$texto='Documentación que se envía.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');
		
		$pdf->SetFont('Arial','B',10); 	
		$pdf->SetLeftMargin(20);
		$pdf->Ln(10);
		$texto="CONTRATOS";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(80);
		$pdf->SetFont('Arial','UB',10);
		if ($doc_contratos=='1') {$texto="SI";} else {$texto="NO";}
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(100);
		$pdf->SetFont('Arial','B',10);
		$texto="IDENTIFICACIONES DEL CLIENTE";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(165);
		$pdf->SetFont('Arial','UB',10);
		if ($doc_identiclientes=='1') {$texto="SI";} else {$texto="NO";}
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		//-------------------------
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln(5);
		$texto="PAGARES";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(80);
		$pdf->SetFont('Arial','UB',10);
		if ($doc_pagares=='1') {$texto="SI";} else {$texto="NO";}
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(100);
		$pdf->SetFont('Arial','B',10);
		$texto="IDENTIFICACIONES AVAL";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(165);
		$pdf->SetFont('Arial','UB',10);
		if ($doc_identiaval=='1') {$texto="SI";} else {$texto="NO";}
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		//-------------------------
		
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln(5);
		$texto="SOLICITUD DE CREDITO CLIENTE";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(80);
		$pdf->SetFont('Arial','UB',10);
		if ($doc_solcredcliente=='1') {$texto="SI";} else {$texto="NO";}
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(100);
		$pdf->SetFont('Arial','B',10);
		$texto="COMPROBANTES DE DOMICILIO";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(165);
		$pdf->SetFont('Arial','UB',10);
		if ($doc_comprodomicilio=='1') {$texto="SI";} else {$texto="NO";}
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		//------------------------
		
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln(5);
		$texto="SOLICITUD DE CREDITO AVAL";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(80);
		$pdf->SetFont('Arial','UB',10);
		if ($doc_solcredaval=='1') {$texto="SI";} else {$texto="NO";}
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(100);
		$pdf->SetFont('Arial','B',10);
		$texto="PREDIAL ACTUALIZADO";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetLeftMargin(165);
		$pdf->SetFont('Arial','UB',10);
		if ($doc_predial=='1') {$texto="SI";} else {$texto="NO";}
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		//------------------------
		
		$pdf->SetLeftMargin(20);
		$pdf->SetFont('Arial','UB',10);
		$pdf->Ln(10);
		$texto="OBSERVACIONES.";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(25,3,$texto,0);
		
		$pdf->SetFont('Arial','',10);
		$pdf->Ln(5);
		$texto=trim($doc_observaciones);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(180,5,$texto,0,'J');
		
		
		
		$pdf->SetFont('Arial','B',10);
		$pdf->SetLeftMargin(20);
		$pdf->Ln(15);
		$texto=trim($row_contra["nombre_vendedor"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(-3);
		$texto='________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(1);
		$texto='VENDEDOR';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(20);
		$texto='________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(1);
		$texto='REVISADOR';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
	}

////********************

	if ($ventas='1')
	{
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->SetLeftMargin(10);
		$pdf->Ln(2);

		$pdf->SetFont('Arial','B',10); 
		$texto="\nREPORTE DE VENTAS                       Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,5,$texto,'TLR','C');
		
		$pdf->Ln(-1);
		$pdf->Cell(194,5,"",'LR',0);
		//$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(194,4,$texto,'LR','C');
		//$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(174,4,$texto,'LR','C');
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Ln(3);
		$pdf->Cell(23,4,"\t\t\tLOTE: ",'L','J');
		$pdf->SetFont('Arial','BU',9);
		$pdf->Cell(171,4,"\t\t\t".$row_emp["nombre_empresa"],'R','J');
		$pdf->SetFont('Arial','B',12);

		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tCLIENTE:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(23,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["nombre_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(171,4,$texto,'R','L');
		

		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tDOMICILIO:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["domicilio_cliente"];

		if (strlen($row_contra["cp_cliente"])>0) {$texto=$texto.", C.P. ".trim($row_contra["cp_cliente"]);}		
		
		$texto=$texto.", ".trim($row_contra["ciudad_cliente"]).", ".trim($row_contra["estado_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');


		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tTEL(s):";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(23,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["tel_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(171,4,$texto,'R','L');

		
		
	$pdf->SetLeftMargin(10);
	$pdf->Ln(4);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(25,3,"\t\t\tMODELO: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["ano"]),0,0);$pdf->Cell(25,3,"MARCA:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["marca"]),'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tLINEA: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["modelo"]),0,0);$pdf->Cell(25,3,"SERIE:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["serie"]),'R',0);

	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tCOLOR:",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["color"]),0,0);$pdf->Cell(25,3,"PEDIMENTO:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["pedimento"]),'R',0);

	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tMILLAS:",'L',0);$pdf->Cell(169,3,strtoupper($row_autos_d["km"]),'R',0);

	$pdf->Ln(1);
	$pdf->Cell(194,5,"",'LR',0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(5);
	$pdf->Cell(45,3,"\t\t\tPRECIO DE VENTA:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cprecio"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tANTICIPO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cenganche"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tAUTO RECIBIDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cacuenta"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tSALDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["saldo_inicial"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tINTERESES:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cinteres"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tIVA:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["civa"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tSALDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["ctotal"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	

	
	$i="";
	//echo "Moneda: ".$row_contra["moneda"]."<BR>";
	switch ($row_contra["moneda"]) {
    case "Dolar":
        $i="DLLS. MONEDA DE LOS EUA.";
        break;
    case "Peso":
        $i="Pesos. MONEDA NACIONAL MEXICANA";
        break;
	}
	$pdf->Ln(3);
	$pdf->Cell(194,3,"\t\t\tLAS CANTIDADES ESTAN EN ".$i ,'LR',0);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"\t\t\tFORMA DE PAGO:",'LR',0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(3);
	$pdf->MultiCell(194,3,$row_contra["forma_pago"],'LR','J');
	
	$pdf->Ln(-1);
	$pdf->Cell(194,3,"",'LR',);
	
	//Pone 10 renglones en blanco...
	for ($i=1;$i<3;$i++) {
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	}
		$pdf->SetLeftMargin(10);
		$pdf->Ln(2);
		$pdf->SetFont('Arial','',8);
		$texto=trim($row_contra["nombre_vendedor"]);
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\t".$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		
		$pdf->Ln(0);
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
		$pdf->Ln(4);
		$texto="VENDEDOR";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		$texto="RECIBI";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(2);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Ln(0);
	$pdf->Cell(194,3,"O     R     I     G     I     N     A     L",'B',0,'C');   

		$pdf->SetLeftMargin(10);
		$pdf->Ln(22);

		$pdf->SetFont('Arial','B',10); 
		$texto="\nREPORTE DE VENTAS                       Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,5,$texto,'TLR','C');
		
		$pdf->Ln(-1);
		$pdf->Cell(194,5,"",'LR',0);
		//$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(194,4,$texto,'LR','C');
		//$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(174,4,$texto,'LR','C');
		
				$pdf->SetFont('Arial','B',9);
		$pdf->Ln(3);
		$pdf->Cell(21,4,"\t\t\tLOTE: ",'L','J');
		$pdf->SetFont('Arial','BU',9);
		$pdf->Cell(173,4,"\t\t\t".$row_emp["nombre_empresa"],'R','J');
		$pdf->SetFont('Arial','B',12);


		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tCLIENTE:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["nombre_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');
		

		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tDOMICILIO:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["domicilio_cliente"];

		if (strlen($row_contra["cp_cliente"])>0) {$texto=$texto.", C.P. ".trim($row_contra["cp_cliente"]);}		
		
		$texto=$texto.", ".trim($row_contra["ciudad_cliente"]).", ".trim($row_contra["estado_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');


		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tTEL(s):";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["tel_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');

		
		
	$pdf->SetLeftMargin(10);
	$pdf->Ln(4);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(25,3,"\t\t\tMODELO: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["ano"]),0,0);$pdf->Cell(25,3,"MARCA:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["marca"]),'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tLINEA: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["modelo"]),0,0);$pdf->Cell(25,3,"SERIE:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["serie"]),'R',0);

	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tCOLOR:",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["color"]),0,0);$pdf->Cell(25,3,"PEDIMENTO:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["pedimento"]),'R',0);

	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tMILLAS:",'L',0);$pdf->Cell(169,3,strtoupper($row_autos_d["km"]),'R',0);

	$pdf->Ln(1);
	$pdf->Cell(194,5,"",'LR',0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(5);
	$pdf->Cell(45,3,"\t\t\tPRECIO DE VENTA:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cprecio"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tANTICIPO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cenganche"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tAUTO RECIBIDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cacuenta"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tSALDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["saldo_inicial"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tINTERESES:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cinteres"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tIVA:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["civa"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tSALDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["ctotal"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	

	
	$i="";
	//echo "Moneda: ".$row_contra["moneda"]."<BR>";
	switch ($row_contra["moneda"]) {
    case "Dolar":
        $i="DLLS. MONEDA DE LOS EUA.";
        break;
    case "Peso":
        $i="Pesos. MONEDA NACIONAL MEXICANA";
        break;
	}
	$pdf->Ln(3);
	$pdf->Cell(194,3,"\t\t\tLAS CANTIDADES ESTAN EN ".$i ,'LR',0);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"\t\t\tFORMA DE PAGO:",'LR',0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(3);
	$pdf->MultiCell(194,3,$row_contra["forma_pago"],'LR','J');
	
	$pdf->Ln(-1);
	$pdf->Cell(194,3,"",'LR',);
	
	//Pone 10 renglones en blanco...
	for ($i=1;$i<3;$i++) {
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	}
		$pdf->SetLeftMargin(10);
		$pdf->Ln(2);
		$pdf->SetFont('Arial','',8);
		$texto=trim($row_contra["nombre_vendedor"]);
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\t".$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		
		$pdf->Ln(0);
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
		$pdf->Ln(4);
		$texto="VENDEDOR";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		$texto="RECIBI";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(2);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Ln(0);
	$pdf->Cell(194,3,"A     R     C     H     I     V     O",'B',0,'C');				

///*******************************
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->SetLeftMargin(10);
		$pdf->Ln(2);
	
		$pdf->SetFont('Arial','B',10); 
		$texto="\nREPORTE DE VENTAS                       Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,5,$texto,'TLR','C');
		
		$pdf->Ln(-1);
		$pdf->Cell(194,5,"",'LR',0);
		//$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(194,4,$texto,'LR','C');
		//$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(174,4,$texto,'LR','C');
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Ln(3);
		$pdf->Cell(21,4,"\t\t\tLOTE: ",'L','J');
		$pdf->SetFont('Arial','BU',9);
		$pdf->Cell(173,4,"\t\t\t".$row_emp["nombre_empresa"],'R','J');
		$pdf->SetFont('Arial','B',12);

		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tCLIENTE:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["nombre_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');
		

		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tDOMICILIO:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["domicilio_cliente"];

		if (strlen($row_contra["cp_cliente"])>0) {$texto=$texto.", C.P. ".trim($row_contra["cp_cliente"]);}		
		
		$texto=$texto.", ".trim($row_contra["ciudad_cliente"]).", ".trim($row_contra["estado_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');


		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tTEL(s):";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["tel_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');

		
		
	$pdf->SetLeftMargin(10);
	$pdf->Ln(4);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(25,3,"\t\t\tMODELO: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["ano"]),0,0);$pdf->Cell(25,3,"MARCA:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["marca"]),'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tLINEA: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["modelo"]),0,0);$pdf->Cell(25,3,"SERIE:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["serie"]),'R',0);

	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tCOLOR:",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["color"]),0,0);$pdf->Cell(25,3,"PEDIMENTO:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["pedimento"]),'R',0);

	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tMILLAS:",'L',0);$pdf->Cell(169,3,strtoupper($row_autos_d["km"]),'R',0);

	$pdf->Ln(1);
	$pdf->Cell(194,5,"",'LR',0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(5);
	$pdf->Cell(45,3,"\t\t\tPRECIO DE VENTA:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cprecio"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tANTICIPO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cenganche"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tAUTO RECIBIDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cacuenta"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tSALDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["saldo_inicial"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tINTERESES:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cinteres"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tIVA:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["civa"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tSALDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["ctotal"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	

	
	$i="";
	//echo "Moneda: ".$row_contra["moneda"]."<BR>";
	switch ($row_contra["moneda"]) {
    case "Dolar":
        $i="DLLS. MONEDA DE LOS EUA.";
        break;
    case "Peso":
        $i="Pesos. MONEDA NACIONAL MEXICANA";
        break;
	}
	$pdf->Ln(3);
	$pdf->Cell(194,3,"\t\t\tLAS CANTIDADES ESTAN EN ".$i ,'LR',0);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"\t\t\tFORMA DE PAGO:",'LR',0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(3);
	$pdf->MultiCell(194,3,$row_contra["forma_pago"],'LR','J');
	
	$pdf->Ln(-1);
	$pdf->Cell(194,3,"",'LR',);
	
	//Pone 10 renglones en blanco...
	for ($i=1;$i<3;$i++) {
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	}
		$pdf->SetLeftMargin(10);
		$pdf->Ln(2);
		$pdf->SetFont('Arial','',8);
		$texto=trim($row_contra["nombre_vendedor"]);
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\t".$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		
		$pdf->Ln(0);
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
		$pdf->Ln(4);
		$texto="VENDEDOR";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		$texto="RECIBI";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(2);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Ln(0);
	$pdf->Cell(194,3,"C     O     B     R     A     N     Z     A",'B',0,'C');

		$pdf->SetLeftMargin(10);
		$pdf->Ln(22);

		$pdf->SetFont('Arial','B',10); 
		$texto="\nREPORTE DE VENTAS                       Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,5,$texto,'TLR','C');
		
		$pdf->Ln(-1);
		$pdf->Cell(194,5,"",'LR',0);
		//$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(194,4,$texto,'LR','C');
		//$texto=iconv('UTF-8', 'windows-1252',"");$pdf->MultiCell(174,4,$texto,'LR','C');
		
				$pdf->SetFont('Arial','B',9);
		$pdf->Ln(3);
		$pdf->Cell(21,4,"\t\t\tLOTE: ",'L','J');
		$pdf->SetFont('Arial','BU',9);
		$pdf->Cell(173,4,"\t\t\t".$row_emp["nombre_empresa"],'R','J');
		$pdf->SetFont('Arial','B',12);


		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tCLIENTE:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["nombre_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');
		

		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tDOMICILIO:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["domicilio_cliente"];

		if (strlen($row_contra["cp_cliente"])>0) {$texto=$texto.", C.P. ".trim($row_contra["cp_cliente"]);}		
		
		$texto=$texto.", ".trim($row_contra["ciudad_cliente"]).", ".trim($row_contra["estado_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');


		$pdf->SetLeftMargin(10);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',9); 
		$texto="\t\t\tTEL(s):";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(21,4,$texto,'L','L');
		
		$pdf->SetFont('Arial','',9);
		$texto="\n\n\n".$row_contra["tel_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(173,4,$texto,'R','L');

		
		
	$pdf->SetLeftMargin(10);
	$pdf->Ln(4);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',0);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(25,3,"\t\t\tMODELO: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["ano"]),0,0);$pdf->Cell(25,3,"MARCA:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["marca"]),'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tLINEA: ",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["modelo"]),0,0);$pdf->Cell(25,3,"SERIE:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["serie"]),'R',0);

	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tCOLOR:",'L',0);$pdf->Cell(55,3,strtoupper($row_autos_d["color"]),0,0);$pdf->Cell(25,3,"PEDIMENTO:",0,0);$pdf->Cell(89,3,strtoupper($row_autos_d["pedimento"]),'R',0);

	$pdf->Ln(3);
	$pdf->Cell(25,3,"\t\t\tMILLAS:",'L',0);$pdf->Cell(169,3,strtoupper($row_autos_d["km"]),'R',0);

	$pdf->Ln(1);
	$pdf->Cell(194,5,"",'LR',0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(5);
	$pdf->Cell(45,3,"\t\t\tPRECIO DE VENTA:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cprecio"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tANTICIPO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cenganche"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tAUTO RECIBIDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cacuenta"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tSALDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["saldo_inicial"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tINTERESES:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["cinteres"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tIVA:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["civa"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(45,3,"\t\t\tSALDO:",'L',0);$pdf->Cell(17,3,"$".number_format($row_contra["ctotal"],2),0,0,'R');$pdf->Cell(40,3,"\t\t\t\t\t____________________",0,0);$pdf->Cell(40,3,"   ____________________",0,0);$pdf->Cell(52,3,"",'R',0);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	

	
	$i="";
	//echo "Moneda: ".$row_contra["moneda"]."<BR>";
	switch ($row_contra["moneda"]) {
    case "Dolar":
        $i="DLLS. MONEDA DE LOS EUA.";
        break;
    case "Peso":
        $i="Pesos. MONEDA NACIONAL MEXICANA";
        break;
	}
	$pdf->Ln(3);
	$pdf->Cell(194,3,"\t\t\tLAS CANTIDADES ESTAN EN ".$i ,'LR',0);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"\t\t\tFORMA DE PAGO:",'LR',0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(3);
	$pdf->MultiCell(194,3,$row_contra["forma_pago"],'LR','J');
	
	$pdf->Ln(-1);
	$pdf->Cell(194,3,"",'LR',);
	
	//Pone 10 renglones en blanco...
	for ($i=1;$i<3;$i++) {
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	}
		$pdf->SetLeftMargin(10);
		$pdf->Ln(2);
		$pdf->SetFont('Arial','',8);
		$texto=trim($row_contra["nombre_vendedor"]);
		$texto=iconv('UTF-8', 'windows-1252',"\t\t\t".$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		
		$pdf->Ln(0);
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='___________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,5,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
		$pdf->Ln(4);
		$texto="VENDEDOR";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,'L',0,'C');
		
		$texto="RECIBI";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(90,4,$texto,0,0,'C');
		
		$texto='';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(14,4,$texto,'R',0,'C');
		
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(3);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->Ln(2);
	$pdf->Cell(194,3,"",'LR',);
	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Ln(0);
	$pdf->Cell(194,3,"C     O     N     T     R     A     T     O",'B',0,'C');				

///*******************************
}
///////
////////////*******************BONO PUNTUTALIDAD O COBRANZA TARDIA

	if ($puntualidad='1')
	{
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->Ln(6);
		$pdf->Image('Imagenes/londres_logo4.jpg',15,17,45);
		
		$pdf->Ln(10);
		$pdf->SetLeftMargin(40);
		$pdf->SetFont('Arial','B',13); 
		$texto=iconv('UTF-8', 'windows-1252',"BONO DE PUNTUALIDAD O COBRANZA TARDIA");
		$pdf->MultiCell(164,4,$texto,0,'C');
		
		$pdf->SetLeftMargin(10);
		$pdf->Ln(15);
		$pdf->SetFont('Arial','',12); 
		$texto=iconv('UTF-8', 'windows-1252',"Con fecha del");
		$pdf->Cell(28,4,$texto,0,'J');
		
		$pdf->SetFont('Arial','U',12); 
		$texto=iconv('UTF-8', 'windows-1252',nombre_fecha($row_contra["fecha_contrato"]));
		$pdf->Cell(50,4,$texto,0,'J');
		
		$pdf->SetFont('Arial','',12); 
		$texto=iconv('UTF-8', 'windows-1252'," , celebramos operación de compra venta con nuestro cliente");
		$pdf->Cell(28,4,$texto,0,'J');
		
		$pdf->Ln(6);
		$pdf->SetFont('Arial','UB',12);
		$texto=$row_contra["nombre_cliente"];
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,4,$texto,0,'C');
		
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$texto="de la unidad que a continuación se describe:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,4,$texto,0,'L');
		
		
		$pdf->SetLeftMargin(20);
		$pdf->Ln(6);
		$pdf->SetFont('Arial','UB',12); 
		$texto='Datos del Vehículo.';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(164,4,$texto,0,'J');

	$pdf->SetLeftMargin(20);
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(25,3,"MODELO ",0,0);$pdf->Cell(55,3,$row_autos_d["ano"],0,0);$pdf->Cell(25,3,"MARCA",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["marca"]));
	
	$i="";
	switch ($row_autos_d["estilo"]) {
    case "automovil":
        $i="Automovil";
        break;
    case "todoterreno":
        $i="Todo Terreno";
        break;
    case "pickup":
        $i="Pickup";
        break;
	case "minivan":
        $i="Mini Van";
        break;	
	}
	

	$pdf->Ln(4);
	$pdf->Cell(25,3,"TIPO ",0,0);$pdf->Cell(55,3,strtoupper($i),0,0);$pdf->Cell(25,3,"LINEA",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["modelo"]));
	//$pdf->Cell(0,3,$row_autos_d["marca"]." ".$row_autos_d["modelo"]." ".$row_autos_d["ano"].", el cual tiene motor de ".$row_autos_d["motor"]." cilindros y odometro con ".$row_autos_d["km"]." millas.",0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ODOMETRO ",0,0);$pdf->Cell(55,3,number_format($row_autos_d["km"]),0,0);$pdf->Cell(25,3,"COLOR",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["color"]));
	//$pdf->Cell(0,3,$row_autos_d["especificaciones"],0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"CILINDROS ",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["motor"]),0,0);$pdf->Cell(25,3,"SERIE",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["serie"]));
	//$pdf->Cell(0,3,"No. serie: ".trim($row_autos_d["serie"]).", No. pedimento: ".trim($row_autos_d["pedimento"]).", Aduana: ".trim($row_autos_d["aduana"]),0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ADUANA ",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["aduana"]),0,0);$pdf->Cell(25,3,"PEDIMENTO",0,0);$pdf->Cell(55,3,strtoupper($row_autos_d["pedimento"]));
	
		$pdf->SetLeftMargin(10);
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',12);
		$texto="Sí el cliente paga puntualmente o antes del vencimiento del documento en las oficinas ubicadas en ";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,4,$texto,0,'L');
		
		$pdf->Ln(2);
		$pdf->SetFont('Arial','UB',12);
		$texto=$_GET['domicilio_lote'];//$row_contra['domicilio_empresa']; //$domicilio_lote;
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,4,$texto,0,'C');
		
		
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);
		$texto="donde adquirio el automóvil arriba descrito, se le bonificara el 10% del valor del documento, el cual ";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,4,$texto,0,'L');
		
		$pdf->Ln(1);
		$texto="es por valor de:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(32,4,$texto,0,'L');
		
		$pdf->SetFont('Arial','UB',12);
		$texto=$_GET['bono_puntualidad'].".";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(50,4,$texto,0,'L');
		
		$pdf->Ln(9);
		$pdf->SetFont('Arial','B',13);
		$texto="CONDICIONES DEL BONO DE PUNTUALIDAD";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(194,4,$texto,0,'C');
		
		$pdf->SetFont('Arial','',12);
		$pdf->Ln(6);
		$texto="1.- Pagar puntualmente en su vencimiento o antes en las oficinas donde se realizo la compra.";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(5,4,$texto,0,'L');

		$pdf->Ln(4);
		$texto="     (El bono de puntualidad no opera si se le cobra a domicilio).";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(5,4,$texto,0,'L');
		
		$pdf->Ln(6);
		$texto="2.- En caso de que el vencimiento sea en domingo o dia festivo, se tendrá que realizar el pago un dia";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(5,4,$texto,0,'L');
			
		$pdf->Ln(4);
		$texto="     antes. (Sin excepción).";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(5,4,$texto,0,'L');

		$pdf->Ln(6);
		$texto="3.- No se puede hablar por telefono para posponer el pago para los siguientes dias.";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(5,4,$texto,0,'L');
			
		$pdf->Ln(4);
		$texto="     (No proceden prorrogas).";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(5,4,$texto,0,'L');

		$pdf->Ln(6);
		$texto="4.- En caso de que se pague con cheque y este no se haga efectivo, no se considera como pago";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(5,4,$texto,0,'L');
			
		$pdf->Ln(4);
		$texto="     aun teniendo su recibo.";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(5,4,$texto,0,'L');
		
		$pdf->Ln(10);
		$texto="En caso de atrasarse con un solo dia a partir de la fecha de vencimiento, no podra recibir el descuento";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(5,4,$texto,0,'L');

		$pdf->Ln(4);
		$texto="y tendra un cargo por cobranza tardia del 10% del valor del documento y es de:";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(150,4,$texto,0,'L');

		$pdf->SetFont('Arial','UB',12);
		$texto=$_GET['cobranza_tardia'].".";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->Cell(50,4,$texto,0,'L');
				
		$pdf->SetFont('Arial','',12);
		$pdf->SetLeftMargin(20);
		
		$pdf->Ln(10);
		$texto="ACEPTO DE CONFORMIDAD";
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(12);
		$texto=trim($row_contra["nombre_cliente"]);
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(-3);
		$texto='________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(1);
		$texto='NOMBRE Y FIRMA DEL CLIENTE';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');

		$pdf->SetLeftMargin(20);
		$pdf->Ln(18);
		
		$texto='________________________________________';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');
		
		$pdf->Ln(1);
		$texto='AUTOS LONDRES';
		$texto=iconv('UTF-8', 'windows-1252',$texto);
		$pdf->MultiCell(174,4,$texto,0,'C');

	}

////////////
	$pdf->Output();
	exit;

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysqli_free_result($contra);
mysqli_free_result($emp);
mysqli_free_result($pagares);
mysqli_free_result($ava);
mysqli_free_result($ava2);
mysqli_free_result($autos_d);
?>
