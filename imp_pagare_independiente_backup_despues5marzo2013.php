<?php include('Funciones/funciones.php'); ?>
<?php require_once('Connections/contratos_londres.php'); 
include('Funciones/EnLetras.php');

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

//*********************************************************************************
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

$recordID=$_GET['parametro1'];
//$recordID0=$_SESSION['MM_Empresa'];
$recordID0=$_GET['parametro2'];
$recordID1=$_GET['parametro3'];


$filtro="";
$filtro=" where clave_combo_pagare='$recordID'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_contra = "select clave_combo_pagare,  clave_empresa, combo_pagare.clave_cliente, numero_pagares, 
DATE_FORMAT(fecha_pagare, '%d-%m-%Y') AS fecha_pagare, clientes.nombre_cliente, clientes.rfc_cliente,
clientes.domicilio_cliente, clientes.ciudad_cliente, clientes.estado_cliente, clientes.cp_cliente, clientes.tel_cliente, clientes.fax_cliente, 
clientes.email_cliente, monedas.moneda from combo_pagare, clientes, monedas  ".$filtro." AND combo_pagare.clave_cliente=clientes.clave_cliente AND combo_pagare.clave_moneda=monedas.clave_moneda ";
$contra = mysql_query($query_contra, $contratos_londres) or die(mysql_error());
$row_contra = mysql_fetch_assoc($contra);
$totalRows_contra = mysql_num_rows($contra);


$filtro="";
$filtro=" where clave_empresa='$recordID0'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_emp = "select * from empresa".$filtro;
$emp = mysql_query($query_emp, $contratos_londres) or die(mysql_error());
$row_emp = mysql_fetch_assoc($emp);
$totalRows_emp = mysql_num_rows($emp);

$filtro="";
$filtro=" where clave_cliente='$recordID1'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_ava = "select * from avales".$filtro;
$ava = mysql_query($query_ava, $contratos_londres) or die(mysql_error());
$row_ava = mysql_fetch_assoc($ava);
$totalRows_ava = mysql_num_rows($ava);

$filtro="";
$filtro=" where clave_cliente='$recordID1'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_ava2 = "select * from avales".$filtro;
$ava2 = mysql_query($query_ava2, $contratos_londres) or die(mysql_error());
$row_ava2 = mysql_fetch_assoc($ava2);
$totalRows_ava2 = mysql_num_rows($ava2);

$filtro="";
$filtro=" where clave_combo_pagare='$recordID'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_pagares = "select clave_pagare, numero_pagare, DATE_FORMAT(fecha_pagare, '%d-%m-%Y') AS fecha_pagare, DATE_FORMAT(vence_pagare, '%d-%m-%Y') AS vence_pagare, importe_pagare, clave_combo_pagare, pagado, vencido from pagares_independientes ".$filtro;
$pagares = mysql_query($query_pagares, $contratos_londres) or die(mysql_error());
$row_pagares = mysql_fetch_assoc($pagares);
$totalRows_pagares = mysql_num_rows($pagares);


	$letras_numero = new EnLetras();
	$fecha_del_primerpago=$row_contra['primerpago'];

    $pdf=new PDF(P,'mm','Letter'); 
	$pdf->Open();  
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15); 
	$pdf->AliasNbPages();
	$pdf->Ln(2);
	
	$contador_pagares=0	;
	$contador_3pagares=0;
	do{
///Realizar aqui las modificaciones de especios de los pagares	
	if (($contador_pagares % 3 == 0) && ($contador_pagares>0)) {$pdf->AddPage(); $pdf->Ln(2);}
	if ($contador_3pagares==1) {$pdf->Ln(5);}
	if ($contador_3pagares==2) {$pdf->Ln(18);}
	// Encabezado Pagare
	$pdf->SetLeftMargin(20);
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(17,5,"PAGARE",1,0,L);
	$pdf->SetLeftMargin(37);
	$pdf->Cell(17,5,"NUMERO",1,0,L);
	$pdf->SetLeftMargin(54);
	$pdf->Cell(43,5,"LUGAR DE EXPEDICION",1,0,L);
	$pdf->SetLeftMargin(97);
	$pdf->Cell(31,5,"FECHA",1,0,C);
	$pdf->SetLeftMargin(128);
	$pdf->Cell(32,5,"VENCIMIENTO",1,0,C);
	$pdf->SetLeftMargin(160);
	$pdf->Cell(35,5,"IMPORTE",1,0,C);
	
	// Datos encabezado Pagare
	$pdf->SetLeftMargin(37);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8); 
	$pdf->Cell(17,5,trim($row_pagares["numero_pagare"])." / ".$row_contra['numero_pagares'],1,0,C);
	$pdf->SetLeftMargin(54);
	$pdf->Cell(43,5,"TIJUANA, B.C.",1,0,L);
	$pdf->SetLeftMargin(97);
	$texto=iconv('UTF-8', 'windows-1252',nombre_fecha($row_contra["fecha_pagare"],1));
	$pdf->Cell(31,5,trim($texto),1,0,C);
	$pdf->SetLeftMargin(128);
	$texto=iconv('UTF-8', 'windows-1252',nombre_fecha($row_pagares["vence_pagare"],1));
	$pdf->Cell(32,5,trim($texto),1,0,C);
	$pdf->SetLeftMargin(160);
	$pdf->SetFont('Arial','',8);
	$texto_moneda="";
	$texto_moneda2="";
	if (trim($row_contra["moneda"])=="Dolar") {$texto_moneda="Dolares US";$texto_moneda2="Dolares";}
	if (trim($row_contra["moneda"])=="Peso") {$texto_moneda="Pesos MN";$texto_moneda2="Pesos";}
	$pdf->Cell(35,5,"$".number_format($row_pagares["importe_pagare"],2)." ".trim($texto_moneda),1,0,C);
	//$pdf->Ln(1);
	
	// Cuerpo Pagare
	$pdf->SetLeftMargin(20);
	$pdf->Ln(5);
	$str=iconv("UTF-8", "windows-1252","Debo (emos) y pagare (emos) incondicionalmente por este PAGARE a la orden de:");
	$pdf->Cell(200,8,$str,0,0,L);
	$pdf->Ln(6);
	$str=iconv("UTF-8", "windows-1252","**".$row_emp["representante_empresa"]."**          en el lugar y fecha citados, la cantidad de:");
	$pdf->Cell(250,8,$str,0,0,L);
	//$importe_texto=convertir($row_pagares["importe_pagare"])  ;
	$importe_texto=$letras_numero->ValorEnLetras($row_pagares["importe_pagare"],$texto_moneda2);
	$pdf->Ln(6);
	//$str=iconv("UTF-8", "windows-1252","***".strtoupper($importe_texto)." ".strtoupper($texto_moneda)."***");
//$str=iconv("UTF-8", "windows-1252","***".strtoupper($importe_texto)."***");
	$str="***".strtoupper($importe_texto)."***";
	$pdf->Cell(160,8,$str,0,0,C);
	
	$pdf->SetFont('Arial','',8); 
	$pdf->Ln(7);
	$texto="Valor recibido a mi (nuestra) entera satisfacci??n.  Este PAGARE forma parte de una serie numerada del 1 al ".$row_contra['numero_pagares']." y todos estan sujetos a la condici??n de que, al no pagarse cualquiera de ellos a su vencimiento, seran exigibles todos los que le sigan en numeros, ademas de los ya vencidos desde la fecha de vencimiento hasta el dia de su liquidaci??n, causara intereses moratorios del 5 % mensual, pagadero en esta ciudad y justamente con el principal.";
	$str=iconv("UTF-8", "windows-1252",$texto);
	$pdf->MultiCell(175,4,$str,0,'J');
	
	// Area de firmas
	$pdf->SetFont('Arial','',8); 
	$pdf->Ln(1);

	
	//Obtiene Datos del Cliente...
	$nombre_del_cliente=trim($row_contra['nombre_cliente']);
	$domicilio_cliente=trim($row_contra['domicilio_cliente']);
	$cp_ciudad="";
	$cpi= (int) $row_contra['cp_cliente'];
	if ((strlen(trim($row_contra['cp_cliente']))<>0) && ($cpi<>0)) {$cp_ciudad=$cp_ciudad."C.P. ".trim($row_contra['cp_cliente'])."   ";}
	$cp_ciudad=$cp_ciudad.trim($row_contra['ciudad_cliente']).", ".trim($row_contra['estado_cliente']);
	if (strlen(trim($row_contra['tel_cliente']))<>0) {$cp_ciudad=$cp_ciudad."          Tel. ".trim($row_contra['tel_cliente']);}
	

	//Obtiene los datos del Aval...
	$nombre_del_aval=$row_ava2['nombre_aval'];
	$domicilio_aval=trim($row_ava2['domicilio_aval']);
	$cp_ciudada="";
	$cpa= (int) $row_ava2['cp_aval'];
	if ((strlen(trim($row_ava2['cp_aval']))<>0) && ($cpa<>0)) {$cp_ciudada=$cp_ciudada."C.P. ".trim($row_ava2['cp_aval'])."   ";}
	$cp_ciudada=$cp_ciudada.trim($row_ava2['ciudad_aval']).", ".trim($row_ava2['edo_aval']);
	if (strlen(trim($row_ava2['tel_aval']))<>0) {$cp_ciudada=$cp_ciudada."          Tel. ".trim($row_ava2['tel_aval']);}
	


	//Imprime nombre del cliente
	$pdf->SetLeftMargin(20);
	$str=iconv("UTF-8", "windows-1252",$nombre_del_cliente);
	//$pdf->Cell(87,4,$str,LTR);
	$pdf->MultiCell(87,3,$str,LTR);
	
	$salto=0;
	if (strlen($nombre_del_cliente)>70) {$salto=1;}
	
	
	//Imprime nombre del aval
	if ($salto==1 && strlen($nombre_del_aval)<70) {$pdf->Ln(-6);} else {$pdf->Ln(-3);}
	if ($salto==1 && strlen($nombre_del_aval)>70) {$pdf->Ln(-2);} 
	
	$pdf->SetLeftMargin(107);
	$str=iconv("UTF-8", "windows-1252",$nombre_del_aval);
	//$pdf->Cell(87,4,$str,LTR);
	$pdf->MultiCell(87,3,$str,LTR);
	
	//Imprime en blanco
	$pdf->SetLeftMargin(20);
	$pdf->Ln(0);
	$str=iconv("UTF-8", "windows-1252","");
	$pdf->Cell(87,4,$str,LR);
	
	//Imprime en blanco
	$pdf->SetLeftMargin(107);
	$str=iconv("UTF-8", "windows-1252","");
	$pdf->Cell(87,4,$str,LR);
	
	
	//Imprime domicilio del cliente
	$pdf->SetFont('Arial','',6);
	$pdf->SetLeftMargin(20);
	if ($salto==1 && strlen($nombre_del_aval)>70) {$pdf->Ln(2);}
	if ($salto==1 && strlen($nombre_del_aval)<70) {$pdf->Ln(2);}
	if ($salto==0 && strlen($nombre_del_aval)<70) {$pdf->Ln(2);}
	$str=iconv("UTF-8", "windows-1252",$domicilio_cliente);
	$pdf->Cell(87,4,$str,LR);
	
	//Imprime domicilio del aval
	$pdf->SetLeftMargin(100);
	$str=iconv("UTF-8", "windows-1252",$domicilio_aval);
	$pdf->Cell(87,4,$str,LR);
	
	//Imprime cp, ciudad, estado del cliente
	$pdf->SetLeftMargin(20);
	$pdf->Ln(3);
	$str=iconv("UTF-8", "windows-1252",$cp_ciudad);
	$pdf->Cell(87,4,$str,LR);
	
	//Imprime cp, ciudad, estado del aval
	$pdf->SetLeftMargin(100);
	$str=iconv("UTF-8", "windows-1252",$cp_ciudada);
	$pdf->Cell(87,4,$str,LR);
	
///
	//Imprime en blanco
	$pdf->SetLeftMargin(20);
	$pdf->Ln(2);
	$str=iconv("UTF-8", "windows-1252","");
	$pdf->Cell(87,4,$str,LR);
	
	//Imprime en blanco
	$pdf->SetLeftMargin(100);
	$str=iconv("UTF-8", "windows-1252","");
	$pdf->Cell(87,4,$str,LR);

	//Imprime en blanco
	$pdf->SetLeftMargin(20);
	$pdf->Ln(2);
	$str=iconv("UTF-8", "windows-1252","");
	$pdf->Cell(87,4,$str,LR);
	
	//Imprime en blanco
	$pdf->SetLeftMargin(100);
	$str=iconv("UTF-8", "windows-1252","");
	$pdf->Cell(87,4,$str,LR);

	//Imprime en blanco
	$pdf->SetLeftMargin(20);
	$pdf->Ln(2);
	$str=iconv("UTF-8", "windows-1252","");
	$pdf->Cell(87,4,$str,LR);
	
	//Imprime en blanco
	$pdf->SetLeftMargin(100);
	$str=iconv("UTF-8", "windows-1252","");
	$pdf->Cell(87,4,$str,LR);

	//Imprime en blanco
	$pdf->SetLeftMargin(20);
	$pdf->Ln(2);
	$str=iconv("UTF-8", "windows-1252","");
	$pdf->Cell(87,4,$str,LR);
	
	//Imprime en blanco
	$pdf->SetLeftMargin(100);
	$str=iconv("UTF-8", "windows-1252","");
	$pdf->Cell(87,4,$str,LR);

	//Imprime en blanco
	$pdf->SetLeftMargin(20);
	$pdf->Ln(2);
	$str=iconv("UTF-8", "windows-1252","Firma del Cliente");
	$pdf->Cell(87,4,$str,'LRB','C');
	
	//Imprime en blanco
	$pdf->SetLeftMargin(100);
	$str=iconv("UTF-8", "windows-1252","Firma del Aval");
	$pdf->Cell(87,4,$str,'LRB','C');

	
	
	
	$pdf->SetLeftMargin(20);
	$pdf->SetFont('Arial','',10); 
	//$pdf->Ln(20);
	
	$contador_pagares++;
	$contador_3pagares++;
///Realizar aqui las modificaciones de especios de los pagares		
	if ($contador_3pagares==1) {$pdf->Ln(20);} else {$pdf->Ln(20.2);}
	if ($contador_3pagares==3) {$contador_3pagares=0;}
	}while($row_pagares = mysql_fetch_assoc($pagares));
	
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
mysql_free_result($contra);
mysql_free_result($emp);
mysql_free_result($pagares);
mysql_free_result($ava);
mysql_free_result($ava2);
?>
