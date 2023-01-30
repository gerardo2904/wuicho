<?php
$numero_pagares=13;
$fp=fopen("prueba.txt","x");

$c='
<?php require_once("Connections/contratos_londres.php"); 

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

//funcion que suma dias a una fecha
function suma_fechas($fecha,$ndias)
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$a?o)=split("/", $fecha);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$a?o)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$a?o) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
}

function nombre_fecha($fecha) {
$d1="";
	$d2="";
	$d3="";
	
	if ( ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $fecha, $regs ) ) {
	
	$d1=$regs[1];
	$d2=$regs[2];
		switch ($d2) {
			case 1:		$d2="Enero";		break;
			case 2:		$d2="Febrero";		break;
			case 3:		$d2="Marzo";		break;
			case 4:		$d2="Abril";		break;
			case 5:		$d2="Mayo";			break;
			case 6:		$d2="Junio";		break;
			case 7:		$d2="Julio";		break;
			case 8:		$d2="Agosto";		break;
			case 9:		$d2="Septiembre";	break;
			case 10:	$d2="Octubre";		break;
			case 11:	$d2="Noviembre";	break;
			case 12:	$d2="Diciembre";	break;
		}
	$d3=$regs[3];
	}
	$fecha=iconv("UTF-8", "windows-1252",$d1." de ".$d2." del ".$d3);
	return $fecha;
}

$MM_restrictGoTo = "conectar_empresa.php";
if (!((isset($_SESSION["MM_Username"])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION["MM_Username"], $_SESSION["MM_UserGroup"])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER["PHP_SELF"];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

';

$c2='
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "\'" . $theValue . "\'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "\'" . doubleval($theValue) . "\'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "\'" . $theValue . "\'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

}

$recordID=$_GET[\'parametro1\'];
//$recordID0=$_SESSION[\'MM_Empresa\'];
$recordID0=$_GET[\'parametro2\'];
$recordID1=$_GET[\'parametro3\'];

$filtro="";
$filtro=" where clave_contrato=\'$recordID\'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_contra = "select clave_contrato, contrato, credito,clave_empresa, contrato.clave_cliente,
DATE_FORMAT(fecha_contrato, \'%d-%m-%Y\') AS fecha_contrato, forma_pago, promocion, no_pagos, dia_pagos, DATE_FORMAT(primerpago, \'%d-%m-%Y\') AS primerpago, interes, moratorio, cenganche, 
cinteres, acuenta, cprecio, cacuenta, civa, ctotal, clave_inv, clave_inv_acuenta, cefectivo, no_cheque, ccheque, banco_cheque, 
clave_cobrador, garantia, DATE_FORMAT(fecha_garantia, \'%d-%m-%Y\') AS fecha_garantia,
partes_garantia, aspecto_mec, aspecto_car, aplicado, clave_usuario, saldo_inicial, aspecto_llantas, otros_aspectos, aspecto_otros, 
DATE_FORMAT(fecha_entrega, \'%d-%m-%Y\') AS fecha_entrega, u_luces, luces, antena, espejos, cristales, tapones, molduras, tapon_gas, 
carroceria_sin_golpes, tablero, calefaccion, aire, limpiadores, radio, bocinas, retrovisor, ceniceros, cinturones, gato, cruceta, 
llanta_refa, estuche_he, triangulo, extinguidor, clientes.nombre_cliente, clientes.rfc_cliente,
clientes.domicilio_cliente, clientes.ciudad_cliente, clientes.estado_cliente, clientes.cp_cliente, clientes.tel_cliente, clientes.fax_cliente, 
clientes.email_cliente, monedas.moneda, vendedores.nombre_vendedor, testigos.nombre_testigo    
from contrato, clientes, monedas, vendedores, testigos ".$filtro." AND contrato.clave_cliente=clientes.clave_cliente AND contrato.clave_moneda=monedas.clave_moneda AND contrato.clave_vendedor=vendedores.clave_vendedor AND contrato.clave_testigo=testigos.clave_testigo ";
$contra = mysql_query($query_contra, $contratos_londres) or die(mysql_error());
$row_contra = mysql_fetch_assoc($contra);
$totalRows_contra = mysql_num_rows($contra);

//Numero de pagares
$filtro="";
$filtro=" where clave_contrato=\'$recordID\'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_pagares = "select clave_pagare, numero_pagare, DATE_FORMAT(fecha_pagare, \'%d-%m-%Y\') AS fecha_pagare, DATE_FORMAT(vence_pagare, \'%d-%m-%Y\') AS vence_pagare, importe_pagare, clave_contrato, pagado, vencido from pagares".$filtro;
$pagares = mysql_query($query_pagares, $contratos_londres) or die(mysql_error());
$row_pagares = mysql_fetch_assoc($pagares);
$totalRows_pagares = mysql_num_rows($pagares);

$filtro="";
$filtro=" where clave_empresa=\'$recordID0\'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_emp = "select * from empresa".$filtro;
$emp = mysql_query($query_emp, $contratos_londres) or die(mysql_error());
$row_emp = mysql_fetch_assoc($emp);
$totalRows_emp = mysql_num_rows($emp);

$var=" AND clave_inv=".$row_contra[\'clave_inv\'];
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_autos_d = "SELECT inventario_auto.*, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca
 FROM inventario_auto, tipo_auto, marca 
 WHERE inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca".$var;
$autos_d = mysql_query($query_autos_d, $contratos_londres) or die(mysql_error());
$row_autos_d = mysql_fetch_assoc($autos_d);
$totalRows_autos_d = mysql_num_rows($autos_d);

$filtro="";
$filtro=" where clave_cliente=\'$recordID1\'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_ava = "select * from avales".$filtro;
$ava = mysql_query($query_ava, $contratos_londres) or die(mysql_error());
$row_ava = mysql_fetch_assoc($ava);
$totalRows_ava = mysql_num_rows($ava);

$filtro="";
$filtro=" where clave_cliente=\'$recordID1\'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_ava2 = "select * from avales".$filtro;
$ava2 = mysql_query($query_ava2, $contratos_londres) or die(mysql_error());
$row_ava2 = mysql_fetch_assoc($ava2);
$totalRows_ava2 = mysql_num_rows($ava2);

$numero_pagares=$row_contra["no_pagos"];

$fecha_del_contrato=$row_contra[\'fecha_contrato\'];

$dia=substr($fecha_del_contrato,0,2);
$mes=substr($fecha_del_contrato,3,2);
$ano=substr($fecha_del_contrato,6,4);
$fechaV=$ano."-".$mes."-".$dia;


$fecha_del_primerpago=$row_contra[\'primerpago\'];

echo "Numero de pagos: ".$numero_pagares."<BR>";
echo "Fecha del contrato: ".$fecha_del_contrato."<BR>";
echo "Fecha del primer pago: ".$fecha_del_primerpago;

?>

';

$c3='


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t?tulo</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script type="text/javascript" src="jscalendar-0.9.6/calendar.js"></script>
<script type="text/javascript" src="jscalendar-0.9.6/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar-0.9.6/calendar-setup.js"></script>
<style type="text/css">
@import url("jscalendar-0.9.6/calendar-win2k-cold-1.css");
</style>
</head>
<body>
<form id="forma_pagare" name="form1" method="post" action="<?php echo $editFormAction; ?>">
<table width="800" border="0">
  <tr>
    <td width="100">No. Pagare</td>
    <td width="100">Fecha Pagare</td>
    <td width="100">Vencimiento Pagare</td>
    <td width="100">Importe</td>
	<td width="100"> <input type="text" name="vv1" id="vv1" value="" /><button id="triggerv1">...</button></td>
  </tr>
  <?php
  
	$fecven=$fecha_del_primerpago;
	
	if ($totalRows_pagares==0){
		for ($i=1;$i<=$numero_pagares;$i++)
		{
			if ($i==1) {
				$fecven=$fecha_del_primerpago;
				$dia=substr($fecven,0,2);
				$mes=substr($fecven,3,2);
				$ano=substr($fecven,6,4);
				$fechaVence=$ano."-".$mes."-".$dia;
			}
			else
			{
				$rec=suma_fechas($fecha_del_primerpago, 30*($i-1));
				$dia=substr($rec,0,2);
				$mes=substr($rec,3,2);
				$ano=substr($rec,6,4);
				$fechaVence=$ano."-".$mes."-".$dia;
			}
			  $insertSQL = sprintf("INSERT INTO pagares (numero_pagare, fecha_pagare, vence_pagare, importe_pagare, clave_contrato, pagado, vencido) VALUES (%s , %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($i, "text"),
					   GetSQLValueString($fechaV, "date"),					   						   
					   GetSQLValueString($fechaVence, "date"),					   						   
					   GetSQLValueString($row_contra[\'ctotal\']/$numero_pagares, "text"),					   						   
                       GetSQLValueString($recordID, "text"),					   
					   GetSQLValueString(\'0\', "text"),
					   GetSQLValueString(\'0\', "text"));

				mysql_select_db($database_contratos_londres, $contratos_londres);
				$Result1 = mysql_query($insertSQL, $contratos_londres) or die(mysql_error());
  
		}
		$totalRows_pagares=$numero_pagares;
	}
 
'; 

$c4='
	if ($totalRows_pagares<>0){
		for ($i=1;$i<=$totalRows_pagares;$i++)
		{
			echo \'<tr>\';
			echo \'<td width="100">\'.$row_pagares["numero_pagare"][$i].\'</td>\';
		}
		do {
			echo \'<tr>\';
			echo \'<td width="100">\'.$row_pagares["numero_pagare"].\'</td>\';
			echo \'<td width="100">\'.$row_pagares["fecha_pagare"].\'</td>\';
			echo \'<td width="100"> <input type="text" name="v\'.$i.\'" id="v\'.$i.\'" value="\'.$row_pagares["vence_pagare"].\'" />\'.\'<button id="trigger\'.$i.\'">...</button></td>\';
			echo \'<td width="100"> <input type="text" name="i\'.$i.\'" id="i\'.$i.\'" value="\'.$row_pagares["importe_pagare"].\'" />\'.\'</td>\';
		}while ($row_pagares = mysql_fetch_assoc($pagares));
		
	}
  ?>
</table>
</form>

';


fwrite($fp,$c);
fwrite($fp,$c2);
fwrite($fp,$c3);
for ($i=1;$i<=$numero_pagares;$i++)
{
$contenido= '<script type="text/javascript">
	Calendar.setup({
	inputField     :    "v'.$i.'",
	ifFormat       :    "%d-%m-%Y",
	showsTime      :    true,
	button         :    "trigger'.$i.'",
	singleClick    :    false,
	step           :    1
	}); 
	</script>
	';
//$contenido2= '<td width="100"> <input type="text" name="v'.$i.'" id="v'.$i.'" value="'.$row_pagares["vence_pagare"].'" />'.'<button id="trigger'.$i.'">...</button></td>';

fwrite($fp,$contenido);
//fwrite($fp,$contenido2);
}
fclose($fp) ;

?>
