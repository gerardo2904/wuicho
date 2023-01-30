<?php 
require_once('Connections/contratos_londres.php'); 
require_once('Funciones/funciones.php');

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


/*function suma_meses($fecha,$nmeses)
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$a�o)=preg_split("/", $fecha);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$a�o)=preg_split("-",$fecha);
        $nueva = mktime(0,0,0, $mes+$nmeses,$dia,$a�o);
        $nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
}*/

    function esBisiesto($year=NULL) {
        $year = ($year==NULL)? date('Y'):$year;
        return ( ($year%4 == 0 && $year%100 != 0) || $year%400 == 0 );
    }

	function suma_meses($fechat,$nmeses)
	{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fechat))
            list($diat,$mest,$añot)=preg_split("/\/|-/",$fechat); 
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fechat))
            list($diat,$mest,$añot)=preg_split("/\/|-/",$fechat); 
		$nuevomes=0;	
		$nuevomes=$mest+$nmeses;
		$añooriginal=$añot;
		if ($nuevomes>12 && $nuevomes<24) {$nuevomes=$nuevomes-12; $añot=$añot+1;}
		if ($nuevomes>24 && $nuevomes<36) {$nuevomes=$nuevomes-24; $añot=$añot+2;}
		if ($nuevomes>36 && $nuevomes<48) {$nuevomes=$nuevomes-36; $añot=$añot+3;}
		if ($nuevomes>48 && $nuevomes<60) {$nuevomes=$nuevomes-48; $añot=$añot+4;}
		
//		echo "Mes: ".$nuevomes."<BR>";
//		echo "Año: ".$año."<BR>";
		if ($nuevomes==2)
			{
				$ultimodia=0;
				if (esBisiesto($añot))
				{
					$ultimodia=29;
				}
				else {
					$ultimodia=28;
				}
			if ($diat>$ultimodia)
				$diat=$ultimodia;
				//echo "Dia: ".$diat;
			}
//		echo "Dia: ".$dia."<BR>";
        //$nueva = mktime(0,0,0, $mes+$nmeses,$dia,$a?o);
        //echo "dia: ".$diat." mes: ".$mest." año ".$añooriginal." incremento en meses: ".$nmeses."<BR>";
		$nueva = mktime(0,0,0, $mest+$nmeses,$diat,$añooriginal);
		$nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
}


function cerrar_querys() {
//	mysqli_free_result($contra);
	mysqli_free_result($pagares);
//	mysqli_free_result($ava);
//	mysqli_free_result($ava2);
//	mysqli_free_result($autos_d);
	mysqli_free_result($emp);	
	mysqli_free_result($empresas);	
	mysqli_free_result($clientes);
	mysqli_free_result($money);	
	mysqli_free_result($combo);		
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

funciones_reemplazadas();

$recordID=$_GET['parametro1'];
$recordID0=$_GET['parametro2'];
$recordID1=$_GET['parametro3'];

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_clientes = "SELECT * FROM clientes ORDER BY clave_cliente, nombre_cliente ASC";
$clientes = mysqli_query($contratos_londres, $query_clientes) or die(mysqli_error($contratos_londres));
$row_clientes = mysqli_fetch_assoc($clientes);
$totalRows_clientes = mysqli_num_rows($clientes);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_empresas = "select * from empresa where activo_empresa=1;";
$empresas = mysqli_query($contratos_londres, $query_empresas) or die(mysqli_error($contratos_londres));
$row_empresas = mysqli_fetch_assoc($empresas);
$totalRows_empresas = mysqli_num_rows($empresas);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_money = "SELECT clave_moneda, moneda FROM monedas WHERE activo=1 ORDER BY moneda";
$money = mysqli_query($contratos_londres, $query_money) or die(mysqli_error($contratos_londres));
$row_money = mysqli_fetch_assoc($money);
$totalRows_money = mysqli_num_rows($money);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_combo = "SELECT clave_combo_pagare, DATE_FORMAT(fecha_pagare, '%d-%m-%Y') AS fecha_pagare, DATE_FORMAT(fecha_primerpago, '%d-%m-%Y') AS fecha_primerpago, clave_cliente, numero_pagares, clave_empresa, clave_moneda, importe_total, hora, periodo FROM combo_pagare WHERE clave_combo_pagare='$recordID' ORDER BY fecha_pagare ASC";
$combo = mysqli_query($contratos_londres, $query_combo) or die(mysqli_error($contratos_londres));
$row_combo = mysqli_fetch_assoc($combo);
$totalRows_combo = mysqli_num_rows($combo);


/*
$filtro="";
$filtro=" where clave_contrato='$recordID'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_contra = "select clave_contrato, contrato, credito,clave_empresa, contrato.clave_cliente,
DATE_FORMAT(fecha_contrato, '%d-%m-%Y') AS fecha_contrato, forma_pago, promocion, no_pagos, dia_pagos, DATE_FORMAT(primerpago, '%d-%m-%Y') AS primerpago, interes, moratorio, cenganche, 
cinteres, acuenta, cprecio, cacuenta, civa, ctotal, clave_inv, clave_inv_acuenta, cefectivo, no_cheque, ccheque, banco_cheque, 
clave_cobrador, garantia, DATE_FORMAT(fecha_garantia, '%d-%m-%Y') AS fecha_garantia,
partes_garantia, aspecto_mec, aspecto_car, aplicado, clave_usuario, saldo_inicial, aspecto_llantas, otros_aspectos, aspecto_otros, 
DATE_FORMAT(fecha_entrega, '%d-%m-%Y') AS fecha_entrega, u_luces, luces, antena, espejos, cristales, tapones, molduras, tapon_gas, 
carroceria_sin_golpes, tablero, calefaccion, aire, limpiadores, radio, bocinas, retrovisor, ceniceros, cinturones, gato, cruceta, 
llanta_refa, estuche_he, triangulo, extinguidor, clientes.nombre_cliente, clientes.rfc_cliente,
clientes.domicilio_cliente, clientes.ciudad_cliente, clientes.estado_cliente, clientes.cp_cliente, clientes.tel_cliente, clientes.fax_cliente, 
clientes.email_cliente, monedas.moneda, vendedores.nombre_vendedor, testigos.nombre_testigo    
from contrato, clientes, monedas, vendedores, testigos ".$filtro." AND contrato.clave_cliente=clientes.clave_cliente AND contrato.clave_moneda=monedas.clave_moneda AND contrato.clave_vendedor=vendedores.clave_vendedor AND contrato.clave_testigo=testigos.clave_testigo ";
$contra = mysqli_query($query_contra, $contratos_londres) or die(mysqli_error($contratos_londres));
$row_contra = mysqli_fetch_assoc($contra);
$totalRows_contra = mysqli_num_rows($contra);
*/

//Numero de pagares
$filtro="";
$filtro=" where clave_combo_pagare='$recordID'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_pagares = "select clave_pagare, numero_pagare, DATE_FORMAT(fecha_pagare, '%d-%m-%Y') AS fecha_pagare, DATE_FORMAT(vence_pagare, '%d-%m-%Y') AS vence_pagare, importe_pagare, clave_combo_pagare, pagado, vencido from pagares_independientes".$filtro;
$pagares = mysqli_query($contratos_londres, $query_pagares) or die(mysqli_error($contratos_londres));
$row_pagares = mysqli_fetch_assoc($pagares);
$totalRows_pagares = mysqli_num_rows($pagares);

//Total de pagares
$filtro="";
$filtro=" where clave_combo_pagare='$recordID' group by clave_combo_pagare";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_tpagares = "select ROUND(sum(importe_pagare),2) as suma_pagares, count(*) as nos_pagares from pagares_independientes".$filtro;
$tpagares = mysqli_query($contratos_londres, $query_tpagares) or die(mysqli_error($contratos_londres));
$row_tpagares = mysqli_fetch_assoc($tpagares);
$totalRows_tpagares = mysqli_num_rows($tpagares);


$filtro="";
$filtro=" where clave_empresa='$recordID0'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_emp = "select * from empresa".$filtro;
$emp = mysqli_query($contratos_londres, $query_emp) or die(mysqli_error($contratos_londres));
$row_emp = mysqli_fetch_assoc($emp);
$totalRows_emp = mysqli_num_rows($emp);


$filtro="";
$filtro=" where clave_cliente='$recordID1'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_ava = "select * from avales".$filtro;
$ava = mysqli_query($contratos_londres, $query_ava) or die(mysqli_error($contratos_londres));
$row_ava = mysqli_fetch_assoc($ava);
$totalRows_ava = mysqli_num_rows($ava);

$filtro="";
$filtro=" where clave_cliente='$recordID1'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_ava2 = "select * from avales".$filtro;
$ava2 = mysqli_query($contratos_londres, $query_ava2) or die(mysqli_error($contratos_londres));
$row_ava2 = mysqli_fetch_assoc($ava2);
$totalRows_ava2 = mysqli_num_rows($ava2);


if ($_POST["Guardar"]) { 

	$fecha_delpagare=$_POST["fecha_pagare"];
	$dia=substr($fecha_delpagare,0,2);
	$mes=substr($fecha_delpagare,3,2);
	$ano=substr($fecha_delpagare,6,4);
	$fechaP=$ano."-".$mes."-".$dia;

	$fecha_delprimerpago=$_POST["fecha_primerpago"];
	$dia=substr($fecha_delprimerpago,0,2);
	$mes=substr($fecha_delprimerpago,3,2);
	$ano=substr($fecha_delprimerpago,6,4);
	$fechaPP=$ano."-".$mes."-".$dia;

  $insertSQL = sprintf("INSERT INTO combo_pagare (clave_cliente, clave_empresa, clave_moneda, fecha_pagare, fecha_primerpago, importe_total, hora, numero_pagares, periodo) VALUES (%s , %s, %s, %s, %s, %s, %s, %s,%s)",
                       GetSQLValueString($_POST['clave_cliente'], "text"),
					   GetSQLValueString($_POST['clave_empresa'], "text"),					   						   
					   GetSQLValueString($_POST['clave_moneda'], "text"),					   						   
					   GetSQLValueString($fechaP, "text"),					   						   
					   GetSQLValueString($fechaPP, "text"),
					   GetSQLValueString($_POST['importe_total'], "text"),
					   GetSQLValueString($_POST['hora'], "text"),
					   GetSQLValueString($_POST['numero_pagares'], "text"),
					   GetSQLValueString($_POST['periodo'], "text"));

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $insertSQL) or die(mysqli_error($contratos_londres));

/// Identificar la clave del combo_pagare y asignarlo como parametro...
	$p1="";
	mysqli_select_db($contratos_londres, $database_contratos_londres);
	$query_iden = "select * from combo_pagare WHERE clave_cliente='".$_POST['clave_cliente']."'"." AND clave_empresa='".$_POST['clave_empresa']."' AND trim(hora)='".trim($_POST['hora'])."'";
	
	//echo $query_iden;exit;
	//echo $query_iden;
	$iden = mysqli_query($contratos_londres, $query_iden) or die(mysqli_error($contratos_londres));
	$row_iden = mysqli_fetch_assoc($iden);
	$totalRows_iden = mysqli_num_rows($iden);
	$p1=$row_iden['clave_combo_pagare'];
	$p2=$row_iden['clave_empresa'];
	$p3=$row_iden['clave_cliente'];
	
	mysqli_free_result($iden);

	$updateGoTo = "pagares_independientes.php?parametro1=".$p1."&parametro2=".$p2."&parametro3=".$p3;
	
			 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";

		
/*	echo "<script language='javascript'> alert('Guardar.'); </script> "; exit;*/
}

if ($_POST["Editar"]) { 

//$hora=$row_combo['hora'];

	$fecha_delpagare=$_POST["fecha_pagare"];
	$dia=substr($fecha_delpagare,0,2);
	$mes=substr($fecha_delpagare,3,2);
	$ano=substr($fecha_delpagare,6,4);
	$fechaP=$ano."-".$mes."-".$dia;

	$fecha_delprimerpago=$_POST["fecha_primerpago"];
	$dia=substr($fecha_delprimerpago,0,2);
	$mes=substr($fecha_delprimerpago,3,2);
	$ano=substr($fecha_delprimerpago,6,4);
	$fechaPP=$ano."-".$mes."-".$dia;

 $updateSQL = sprintf("UPDATE combo_pagare SET clave_cliente=%s, clave_empresa=%s, clave_moneda=%s, fecha_pagare=%s, fecha_primerpago=%s, importe_total=%s, numero_pagares=%s, periodo=%s  WHERE clave_combo_pagare='$recordID' ",
                       GetSQLValueString($_POST['clave_cliente'], "text"),
					   GetSQLValueString($_POST['clave_empresa'], "text"),					   						   
					   GetSQLValueString($_POST['clave_moneda'], "text"),					   						   
					   GetSQLValueString($fechaP, "text"),					   						   
					   GetSQLValueString($fechaPP, "text"),
					   GetSQLValueString($_POST['importe_total'], "text"),
					   GetSQLValueString($_POST['numero_pagares'], "text"),
					   GetSQLValueString($_POST['periodo'], "text"));

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));

echo "<script language='javascript'> alert('Edición exitosa.'); </script> "; 

    $p1=$row_iden['clave_combo_pagare'];
	$p2=$_POST['clave_empresa'];
	$p3=$_POST['clave_cliente'];

  $updateGoTo = "pagares_independientes.php?parametro1=$p1&amp;parametro2=$p2&amp;parametro3=$p3";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}
//	header(sprintf("Location: %s", $updateGoTo));
		 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";


}

if ($_POST["Borrar"]) { 

	echo "<script language='javascript'> alert('Borrar.'); </script> "; exit;
}

if ($_POST["Cancelar"]) { 

	echo "<script language='javascript'> alert('Cancelar.'); </script> "; exit;
}

/*if ($_POST["Imprimir"]) { 

	echo "<script language='javascript'> alert('Imprimir.'); </script> "; exit;
}
*/
/*if ($_POST["Editar_pagares"]) { 

	echo "<script language='javascript'> alert('Editar_pagares.'); </script> "; exit;
}
*/


$numero_pagares=$row_combo["numero_pagares"];

$fecha_del_pagare=$row_combo['fecha_pagare'];

$dia=substr($fecha_del_pagare,0,2);
$mes=substr($fecha_del_pagare,3,2);
$ano=substr($fecha_del_pagare,6,4);
$fechaV=$ano."-".$mes."-".$dia;

$fecha_del_primerpago=$row_combo['primerpago'];
$dia_primer_pago=substr($fecha_del_primerpago,0,2);
$mes_primer_pago=substr($fecha_del_primerpago,3,2);
$ano_primer_pago=substr($fecha_del_primerpago,6,4);

$suma_pagares=0;
$suma_pagares=$row_tpagares["suma_pagares"];

$nos_pagares=$row_tpagares["nos_pagares"];


/*
if (isset($nos_pagares) || is_null($nos_pagares)) {
    $nos_pagares=0;
}
*/

/*
//REVISAR...
// Preguntar si el importe es entero, si es asi 
if ($numero_pagares>0 && $nos_pagares>0){
//echo "numero de pagares: ".$numero_pagares."<BR>";
//echo "nos  pagares: ".$nos_pagares."<BR>";

$sp=intval($row_combo['importe_total']);
$operacion=$row_combo['importe_total']-$sp;

    if($operacion==0)
        $suma_pagares=intval($suma_pagares);
    
   // echo "suma de pagares: ".$suma_pagares."<BR>";
    

    
//echo "total pagarea: ".$row_combo['importe_total'];
//return false;
} */

/*
if ($nos_pagares>0){
echo "numero de pagares: ".$numero_pagares."<BR>";
echo "nos  pagares: ".$nos_pagares."<BR>";
echo "suma  pagares: ".$suma_pagares."<BR>";
echo "importe  pagares: ".$row_combo['importe_total']."<BR>";
}
*/
if ((($numero_pagares<>$nos_pagares)&&($nos_pagares<>0))||($suma_pagares<>$row_combo['importe_total'])){
	$tempo1=$recordID;
	if ($tempo3==0) {$tempo3=0;}
	echo "<script language='javascript'> var $tempo1 = <?php echo '$tempo1'; ?>; </script> ";
	echo "<script language='javascript'>
	if(!confirm('El número de Pagares creados difiere del Número especificado o el importe de los pagares no es correcto, Quieres Crearlos nuevamente? ')) 
	{ 
		location.href='contrato.php?parametro1='+$tempo1; 
	} 
	</script> ";

	$updateSQL = sprintf("DELETE from pagares_independientes WHERE clave_combo_pagare='$recordID'");
	mysqli_select_db($contratos_londres, $database_contratos_londres);
	$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
	
	$updateGoTo = "pagares_independientes.php?parametro1=".$recordID."&parametro2=".$recordID0."&parametro3=".$recordID1;
  echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";
}


$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ($_POST["Editar_pagares"]) { 

for ($i=1;$i<=$numero_pagares;$i++) {
	//$dia=substr($_POST['v'.$i],0,2);
	
	$fecpp=$row_combo['fecha_primerpago'];
	$dia_primer_pago=substr($fecpp,0,2);
	
	//$dia=$dia_primer_pago;
	$dia=substr($_POST['v'.$i],0,2);
	$mes=substr($_POST['v'.$i],3,2);
	$ano=substr($_POST['v'.$i],6,4);
	
/////////////////////
if ($mes=="02")
			{
				/*echo "<script language='javascript'> alert('es febrero'); </script> ";*/
				$ultimodia=0;
				if (esBisiesto($ano))
				{
					$ultimodia=29;
				}
				else {
					$ultimodia=28;
				}
			if ($dia>$ultimodia)
				$dia=$ultimodia;
			}
/////////////////////

	$fechaT=$ano."-".$mes."-".$dia;
	
	$updateSQL = sprintf("UPDATE pagares_independientes SET vence_pagare=%s, importe_pagare=%s WHERE clave_combo_pagare='$recordID' AND numero_pagare='$i'",
                       GetSQLValueString($fechaT, "date"),
					   GetSQLValueString($_POST['i'.$i], "text"));	
 	mysqli_select_db($contratos_londres, $database_contratos_londres);
 	$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
 }

	$dia=substr($_POST['v1'],0,2);
	$mes=substr($_POST['v1'],3,2);
	$ano=substr($_POST['v1'],6,4);
	$fechaT=$ano."-".$mes."-".$dia;
	
 	$updateSQL = sprintf("UPDATE combo_pagare SET fecha_primerpago=%s WHERE clave_combo_pagare='$recordID'",GetSQLValueString($fechaT, "date"));	
	mysqli_select_db($contratos_londres, $database_contratos_londres);
 	$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));

	echo "<script language='javascript'> alert('Pagares Actualizados.'); </script> "; 

   $updateGoTo = "pagares_independientes.php?parametro1=".$recordID."&parametro2=".$recordID0."&parametro3=".$recordID1;
  echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";

}


 if ($_POST["Imprimir"]) {
	 $updateGoTo = "imp_pagare_independiente.php?parametro1=".$recordID."&parametro2=".$recordID0."&parametro3=".$recordID1;
  echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";
 }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t�tulo</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script type="text/javascript" src="jscalendar-0.9.6/calendar.js"></script>
<script type="text/javascript" src="jscalendar-0.9.6/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar-0.9.6/calendar-setup.js"></script>
<style type="text/css">
@import url("jscalendar-0.9.6/calendar-win2k-cold-1.css");
</style>

<style type="text/css">
<!--
.style2 {font-size: 10}
.style3 {font-size: 10px}
.style4 {
	color: #FFFF00;
	font-weight: bold;
	font-size: 10px;
}
.style5 {color: #FFFF00}
.style6 {
	color:#000000;
	font-weight:bold;
	font-size:10px;
}
#formulario {
	position:absolute;
	left:12px;
	top:15px;
	width:578px;
	height:196px;
	z-index:1;
	overflow: desplaz
.;
	overflow: automatico;
}
#apDiv1 {
	position:absolute;
	left:580px;
	top:9px;
	width:537px;
	height:309px;
	z-index:2;
}
.style31 {font-size: 10px; font-weight: bold; }
-->
</style>




<script type="text/javascript">

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function NumberFormat(num, numDec, decSep, thousandSep){ 
    var arg; 
    var Dec; 
    Dec = Math.pow(10, numDec);  
    if (typeof(num) == 'undefined') return;  
    if (typeof(decSep) == 'undefined') decSep = ','; 
    if (typeof(thousandSep) == 'undefined') thousandSep = '.'; 
    if (thousandSep == '.') 
     arg=/./g; 
    else 
     if (thousandSep == ',') arg=/,/g; 
    if (typeof(arg) != 'undefined') num = num.toString().replace(arg,''); 
    num = num.toString().replace(/,/g, '.');  
    if (isNaN(num)) num = "0"; 
    sign = (num == (num = Math.abs(num))); 
    num = Math.floor(num * Dec + 0.50000000001); 
    cents = num % Dec; 
    num = Math.floor(num/Dec).toString();  
    if (cents < (Dec / 10)) cents = "0" + cents;  
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++) 
     num = num.substring(0, num.length - (4 * i + 3)) + thousandSep + num.substring(num.length - (4 * i + 3));
     if (Dec == 1) 
     return (((sign)? '': '-') + num); 
    else 
     return (((sign)? '': '-') + num + decSep + cents); 
   }  

   function EvaluateText(cadena, obj){ 
    opc = false;  
    if (cadena == "%d") 
     if (event.keyCode > 47 && event.keyCode < 58) 
      opc = true; 
    if (cadena == "%f"){  
     if (event.keyCode > 47 && event.keyCode < 58) 
      opc = true; 
     if (obj.value.search("[.*]") == -1 && obj.value.length != 0) 
      if (event.keyCode == 46) 
       opc = true; 
    } 
    if(opc == false) 
     event.returnValue = false;  
   } 



	function actualiza_total(s) {
		var suma_de_pagares=0;
		var limite = document.getElementById('numero_pagares').value;
		j = 1;
		while (j<=limite)
 	    {
			elemento='i'+j.toString();
			suma_de_pagares=parseFloat(suma_de_pagares) + parseFloat(document.getElementById(elemento).value);
			j++;	 			
		}
		suma_de_pagares_formato=NumberFormat(suma_de_pagares, '2', '.', ',');
	   document.getElementById('total_pagares').value = suma_de_pagares_formato;
   }
   
	function copia_valores(s,puntero) {
		var valor_a_copiar=document.getElementById('i'+puntero).value;
		//alert(puntero);
		//alert(valor_a_copiar);
		var limite = document.getElementById('numero_pagares').value;
		j = puntero+1;
		//alert ('Puntero'+j);
		while (j <= limite) {
			document.getElementById('i'+j).value=valor_a_copiar;
			j++;		
		}
		
	actualiza_total(this);
   }
   
</script>

</head>
<body>
<div id='cssmenu'>
  <?php 
  //Inserta el Menu
  require_once('menu.php'); ?>
</div>

  <p><strong>Pagares (No ligados a contratos).</strong></p>
  <form id="forma_combo" name="forma_combo" method="post" action="">
    <table width="567" border="1" class="style6">
      <tr>
        <td width="167" bgcolor="#000033" class="style4">Número de Pagos</td>
        <td width="209"><input name="numero_pagares" type="text" class="style31" id="numero_pagares" value="<?php if ($recordID>0) {echo $row_combo['numero_pagares'];} ?>" />
		 Semanal?  
		 <input name="periodo" type="checkbox" class="style3" id="periodo" tabindex="2" value="1" <?php if (!(strcmp($row_combo['periodo'],1))) {echo "checked=\"checked\"";} ?> />

          <label for="xx">
            <input name="hora" type="hidden" class="style31" id="hora" value="<?php if ($recordID<=0) {echo time();} ?>" />
          </label>
		  </td>
      </tr>
      <tr>
        <td bgcolor="#000033" class="style4">Fecha de Pagare</td>
        <td><span class="style3 style10 style19"><span class="style31">
          <input name="fecha_pagare" type="text" class="style31" id="fecha_pagare" tabindex="3" dir="rtl" onfocus="sumafecha(this);" onselect="sumafecha(this);" onchange="sumafecha(this);" value="<?php if ($recordID>0) {echo $row_combo['fecha_pagare'];} ?>" size="9" />
          </span></span>
        <button class="style31" id="trigger_1">...</button></td>
      </tr>
      <tr>
        <td bgcolor="#000033" class="style4">Fecha del Primer Pago</td>
        <td><span class="style3 style10 style19"><span class="style31">
          <input name="fecha_primerpago" type="text" class="style31" id="fecha_primerpago" tabindex="3" dir="rtl" onfocus="sumafecha(this);" onselect="sumafecha(this);" onchange="sumafecha(this);" value="<?php if ($recordID>0) {echo $row_combo['fecha_primerpago'];} ?>" size="9" />
          </span></span>
        <button class="style31" id="trigger_2">...</button></td>
      </tr>
      <tr>
        <td bgcolor="#000033" class="style4">Pagare a la orden de</td>
        <td><select name="clave_empresa" class="style31" id="clave_empresa" tabindex="2" style="visibility: visible">
          <option value="0" <?php if (!(strcmp(0, $row_combo['clave_empresa']))) {echo "selected=\"selected\"";} ?>>Selecciona una empresa</option>
          <?php
do {  
?>
<option value="<?php echo $row_empresas['clave_empresa']?>"<?php if (!(strcmp($row_empresas['clave_empresa'], $row_combo['clave_empresa']))) {echo "selected=\"selected\"";} ?>><?php echo $row_empresas['nombre_empresa']?></option>
          <?php
} while ($row_empresas = mysqli_fetch_assoc($empresas));
  $rows = mysqli_num_rows($empresas);
  if($rows > 0) {
      mysqli_data_seek($empresas, 0);
	  $row_empresas = mysqli_fetch_assoc($empresas);
  }
?>
        </select></td>
      </tr>
      <tr>
        <td bgcolor="#000033" class="style4">Cliente</td>
        <td><select name="clave_cliente" class="style31" id="clave_cliente" tabindex="8" style="visibility: visible">
          <option value="0" <?php if (!(strcmp(0, $row_combo['clave_cliente']))) {echo "selected=\"selected\"";} ?>>Selecciona cliente</option>
          <?php
do {  
?>
<option value="<?php echo $row_clientes['clave_cliente']?>"<?php if (!(strcmp($row_clientes['clave_cliente'], $row_combo['clave_cliente']))) {echo "selected=\"selected\"";} ?>><?php echo $row_clientes['nombre_cliente']?></option>
          <?php
} while ($row_clientes = mysqli_fetch_assoc($clientes));
  $rows = mysqli_num_rows($clientes);
  if($rows > 0) {
      mysqli_data_seek($clientes, 0);
	  $row_clientes = mysqli_fetch_assoc($clientes);
  }
?>
        </select></td>
      </tr>
      <tr>
        <td bgcolor="#000033" class="style4">Moneda</td>
        <td><select name="clave_moneda" class="style31" id="clave_moneda" tabindex="8" style="visibility: visible">
          <option value="0" <?php if (!(strcmp(0, $row_combo['clave_moneda']))) {echo "selected=\"selected\"";} ?>>Selecciona Moneda</option>
          <?php
do {  
?>
<option value="<?php echo $row_money['clave_moneda']?>"<?php if (!(strcmp($row_money['clave_moneda'], $row_combo['clave_moneda']))) {echo "selected=\"selected\"";} ?>><?php echo $row_money['moneda']?></option>
          <?php
} while ($row_money = mysqli_fetch_assoc($money));
  $rows = mysqli_num_rows($money);
  if($rows > 0) {
      mysqli_data_seek($money, 0);
	  $row_money = mysqli_fetch_assoc($money);
  }
?>
        </select></td>
      </tr>
      <tr>
        <td bgcolor="#000033" class="style4">Importe total de Documentos</td>
        <td><input name="importe_total" type="text" class="style31" id="importe_total" value="<?php if ($recordID>0) {echo $row_combo['importe_total'];} ?>" /></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#000033" class="style4"><input type="submit" name="Guardar" id="Guardar" value="Guardar" class="style6"  <?php if ($recordID <= 0 ) {echo "enabled";} else {echo "disabled";}?>/>
        <input type="submit" name="Editar" id="Editar" value="Editar" class="style6"  <?php if ($recordID > 0 ) {echo "enabled";} else {echo "disabled";}?>/>
        <input type="submit" name="Borrar" id="Borrar" value="Borrar" class="style6"  <?php if ($recordID > 0 ) {echo "enabled";} else {echo "disabled";}?>/>
        <input type="submit" name="Cancelar" id="Cancelar" value="Cancelar" class="style6"/></td>
      </tr>
    </table>
  </form>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_pagare",      // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,            // will display a time selector
        button         :    "trigger_1",   // trigger for the calendar (button ID)
        singleClick    :    true,           // double-click mode
        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
    });
</script>

<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_primerpago",      // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,            // will display a time selector
        button         :    "trigger_2",   // trigger for the calendar (button ID)
        singleClick    :    true,           // double-click mode
        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
    });
</script>

  <p>&nbsp;</p>
  <form id="forma_pagare" name="forma_pagare" method="post" action="<?php echo $editFormAction; ?>">
  <table width="569" border="0">
    <tr>
        <td colspan="4" align="left" bgcolor="#000033" class="style6"><input type="submit" name="Editar_pagares" id="Editar_pagares" value="Guardar" class="style6" <?php if ($recordID > 0 ) {echo "enabled";} else {echo "disabled";}?>/>
          <input type="submit" name="Imprimir" id="Imprimir" value="Imprimir Pagares" class="style6" <?php if ($recordID > 0 ) {echo "enabled";} else {echo "disabled";}?>/>
          <span class="style4"> <span class="estilo7">Total  Pagares:$</span></span>
          <input name="total_pagares" type="text" class="style6" id="total_pagares" value="<?php echo number_format($suma_pagares,2);?>" size="14" readonly="readonly"/></td>
      </tr>
      <tr>
        <td width="76" align="center" bgcolor="#000033" class="style4">No. Pagáre</td>
        <td width="111" align="center" bgcolor="#000033" class="style4">Fecha Pagáre</td>
        <td width="175" align="center" bgcolor="#000033" class="style4">Vencimiento Pagáre</td>
        <td width="187" align="center" bgcolor="#000033" class="style4">Importe</td>
      </tr>
      <?php
  
	//$fecven=$fecha_del_primerpago;
	$fecven=$row_combo['fecha_primerpago'];
	$dia_primer_pago=substr($fecven,0,2);
	//echo "Fecha del primer pago: ".$fecven." fecha: ".$row_combo['fecha_primerpago']." dia del primer pago: ".$dia_primer_pago;
	//sleep(10);
	
	if ($totalRows_pagares==0){
		for ($i=1;$i<=$numero_pagares;$i++)
		{
			if ($i==1) {
				//$fecven=$row_combo['fecha_primerpago'];
				$dia=substr($fecven,0,2);
				$mes=substr($fecven,3,2);
				$ano=substr($fecven,6,4);
				$fechaVence=$ano."-".$mes."-".$dia;
			}
			else
			{
				//$rec=suma_fechas($fecha_del_primerpago, 30*($i-1));
				//$rec=suma_meses($row_combo['fecha_primerpago'], 1*($i-1));

				if ($row_combo['periodo']=="1"){
					$rec=suma_fechas($fecven,7*($i-1));
				}else
				{
					$rec=suma_meses($fecven, 1*($i-1));
				}
				//$dia=substr($rec,0,2);
				//$dia=$dia_primer_pago;
				$dia=substr($rec,0,2);
				$mes=substr($rec,3,2);
				$ano=substr($rec,6,4);
				$fechaVence=$ano."-".$mes."-".$dia;
				
			}
			  
                       if ($i == $numero_pagares){
                           echo "<script language='javascript'> alert('Si'.$i); </script> "; 
                           $diferencia=round($row_combo['importe_total'],2)-(round(($row_combo['importe_total']/$numero_pagares),2)*$numero_pagares);
                            
                           $insertSQL = sprintf("INSERT INTO pagares_independientes (numero_pagare, fecha_pagare, vence_pagare, importe_pagare, clave_combo_pagare, pagado, vencido) VALUES (%s , %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($i, "text"),
                            GetSQLValueString($fechaV, "date"),					   						   
                            GetSQLValueString($fechaVence, "date"),					   						                       
                            GetSQLValueString((round(($row_combo['importe_total']/$numero_pagares),2)+$diferencia), "text"),	
                            GetSQLValueString($recordID, "text"),					   
                            GetSQLValueString('0', "text"),
                            GetSQLValueString('0', "text"));    
                       }else {
                        $insertSQL = sprintf("INSERT INTO pagares_independientes (numero_pagare, fecha_pagare, vence_pagare, importe_pagare, clave_combo_pagare, pagado, vencido) VALUES (%s , %s, %s, %s, %s, %s, %s)",
                        GetSQLValueString($i, "text"),
					    GetSQLValueString($fechaV, "date"),					   						   
					    GetSQLValueString($fechaVence, "date"),					   						                       
                        GetSQLValueString(round(($row_combo['importe_total']/$numero_pagares),2), "text"),
                        GetSQLValueString($recordID, "text"),					   
					    GetSQLValueString('0', "text"),
					    GetSQLValueString('0', "text"));    
                       }
                       

				mysqli_select_db($contratos_londres, $database_contratos_londres);
				$Result1 = mysqli_query($contratos_londres, $insertSQL) or die(mysqli_error($contratos_londres));
				
				echo "<script language='javascript'> alert('Se dieron de alta los Pagares.'); </script> "; 
				//cerrar_querys() ;

   // REVISAR:::::::::::::::::::::
            
    $updateGoTo = "pagares_independientes.php?parametro1=".$recordID."&parametro2=".$recordID0."&parametro3=".$recordID1;
  echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>"; 
  
		}
		$totalRows_pagares=$numero_pagares;
	}
  
	if ($totalRows_pagares<>0){
		/*for ($i=1;$i<=$totalRows_pagares;$i++)
		{
			echo '<tr>';
			echo '<td width="100">'.$row_pagares["numero_pagare"][$i].'</td>';
		}*/
		$i=0;
		do {
			$i++;
			echo '<tr>';
			echo '<td width="70" class="style6" align="center">'.$row_pagares["numero_pagare"].'</td>';
			echo '<td width="70" class="style6" align="center">'.$row_pagares["fecha_pagare"].' </td>';
			//echo '<td width="100">'.$row_pagares["vence_pagare"].'</td>';
			//echo '<td width="100">'.'$'.number_format($row_pagares["importe_pagare"],2).'</td>';
			//echo $i,"<BR>";
			echo '<td width="90" align="center"> <input type="text" name="v'.$i.'" id="v'.$i.'" value="'.$row_pagares["vence_pagare"].'" class="style6" size="8"/>'.'<button id="trigger'.$i.'" class="style6">...</button></td>';
			echo '<td width="90" align="center"> <input type="text" name="i'.$i.'" id="i'.$i.'" value="'.$row_pagares["importe_pagare"].'" class="style6" size="8" onchange="actualiza_total(this);"/>'.'<img src="copiar.jpg" name="Image1" width="14" height="17" hspace="0" vspace="0"   title="Copia el valor de este Pagare al resto de los que estan por debajo"  border="0" onclick="copia_valores(this,'.$i.');" />'.'</td>';
			// Este funciona, encontrar la forma de que se declara en formulario para que no cause falla javascript.
			//echo '<td width="100"> <input type="text" name="v1" id="v1" value="'.$row_pagares["vence_pagare"].'" />'.'<button id="trigger1">...</button></td>';
		}while ($row_pagares = mysqli_fetch_assoc($pagares));
	}
  ?>
    </table>
<p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </form>


<p>
    <?php
for ($i=1;$i<=$numero_pagares;$i++)
{
	
	echo "<script type=\"text/javascript\">
	Calendar.setup({
	inputField     :    \"v".$i."\",
	ifFormat       :    \"%d-%m-%Y\",
	showsTime      :    false,
	button         :    \"trigger".$i."\",
	singleClick    :    true,
	step           :    1
	}); 
	</script>";

}
?>
  </p>
<p>&nbsp;</p>
</body>
</html>

<?php

mysqli_free_result($pagares);
mysqli_free_result($tpagares);
mysqli_free_result($ava);
mysqli_free_result($ava2);
mysqli_free_result($emp);
?>