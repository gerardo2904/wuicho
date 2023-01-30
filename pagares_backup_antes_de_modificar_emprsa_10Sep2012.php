<?php require_once('Connections/contratos_londres.php'); 

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
            
              list($dia,$mes,$a�o)=split("/", $fecha);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$a�o)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$a�o) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
}

function suma_meses($fecha,$nmeses)
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$a�o)=split("/", $fecha);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$a�o)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes+$nmeses,$dia,$a�o);
        $nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
}

function cerrar_querys() {
	mysql_free_result($contra);
	mysql_free_result($pagares);
	mysql_free_result($ava);
	mysql_free_result($ava2);
	mysql_free_result($autos_d);
	mysql_free_result($emp);	
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
	$fecha=iconv('UTF-8', 'windows-1252',$d1." de ".$d2." del ".$d3);
	return $fecha;
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

$recordID=$_GET['parametro1'];
$recordID0=$_GET['parametro2'];
$recordID1=$_GET['parametro3'];

$filtro="";
$filtro=" where clave_contrato='$recordID'";
mysql_select_db($database_contratos_londres, $contratos_londres);
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
$contra = mysql_query($query_contra, $contratos_londres) or die(mysql_error());
$row_contra = mysql_fetch_assoc($contra);
$totalRows_contra = mysql_num_rows($contra);

//Numero de pagares
$filtro="";
$filtro=" where clave_contrato='$recordID'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_pagares = "select clave_pagare, numero_pagare, DATE_FORMAT(fecha_pagare, '%d-%m-%Y') AS fecha_pagare, DATE_FORMAT(vence_pagare, '%d-%m-%Y') AS vence_pagare, importe_pagare, clave_contrato, pagado, vencido from pagares".$filtro;
$pagares = mysql_query($query_pagares, $contratos_londres) or die(mysql_error());
$row_pagares = mysql_fetch_assoc($pagares);
$totalRows_pagares = mysql_num_rows($pagares);

//Total de pagares
$filtro="";
$filtro=" where clave_contrato='$recordID' group by clave_contrato";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_tpagares = "select sum(importe_pagare) as suma_pagares, count(*) as nos_pagares from pagares".$filtro;
$tpagares = mysql_query($query_tpagares, $contratos_londres) or die(mysql_error());
$row_tpagares = mysql_fetch_assoc($tpagares);
$totalRows_tpagares = mysql_num_rows($tpagares);


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

$numero_pagares=$row_contra["no_pagos"];

$fecha_del_contrato=$row_contra['fecha_contrato'];

$dia=substr($fecha_del_contrato,0,2);
$mes=substr($fecha_del_contrato,3,2);
$ano=substr($fecha_del_contrato,6,4);
$fechaV=$ano."-".$mes."-".$dia;

$fecha_del_primerpago=$row_contra['primerpago'];
$dia_primer_pago=substr($fecha_del_primerpago,0,2);
$mes_primer_pago=substr($fecha_del_primerpago,3,2);


$suma_pagares=0;
$suma_pagares=$row_tpagares["suma_pagares"];

$nos_pagares=$row_tpagares["nos_pagares"];

if (($numero_pagares<>$nos_pagares)&&($nos_pagares<>0)){
	$tempo1=$recordID;
	if ($tempo3==0) {$tempo3=0;}
	echo "<script language='javascript'> var $tempo1 = <?php echo '$tempo1'; ?>; </script> ";
	echo "<script language='javascript'>
	if(!confirm('El número de Pagares creados difiere del Número especificado en el contrato, Quieres Crearlos nuevamente? ')) 
	{ 
		location.href='contrato.php?parametro1='+$tempo1; 
	} 
	</script> ";

	$updateSQL = sprintf("DELETE from pagares WHERE clave_contrato='$recordID'");
	mysql_select_db($database_contratos_londres, $contratos_londres);
	$Result1 = mysql_query($updateSQL, $contratos_londres) or die(mysql_error());
	
	$updateGoTo = "pagares.php?parametro1=".$recordID."&parametro2=".$recordID0."&parametro3=".$recordID1;
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

if ($_POST["Editar"]) { 

for ($i=1;$i<=$numero_pagares;$i++) {
	//$dia=substr($_POST['v'.$i],0,2);
	$dia=$dia_primer_pago;
	$mes=substr($_POST['v'.$i],3,2);
	$ano=substr($_POST['v'.$i],6,4);
	$fechaT=$ano."-".$mes."-".$dia;
	
	$updateSQL = sprintf("UPDATE pagares SET vence_pagare=%s, importe_pagare=%s WHERE clave_contrato='$recordID' AND numero_pagare='$i'",
                       GetSQLValueString($fechaT, "date"),
					   GetSQLValueString($_POST['i'.$i], "text"));	
 	mysql_select_db($database_contratos_londres, $contratos_londres);
 	$Result1 = mysql_query($updateSQL, $contratos_londres) or die(mysql_error());
 }

	$dia=substr($_POST['v1'],0,2);
	$mes=substr($_POST['v1'],3,2);
	$ano=substr($_POST['v1'],6,4);
	$fechaT=$ano."-".$mes."-".$dia;
	
 	$updateSQL = sprintf("UPDATE contrato SET primerpago=%s WHERE clave_contrato='$recordID'",GetSQLValueString($fechaT, "date"));	
	mysql_select_db($database_contratos_londres, $contratos_londres);
 	$Result1 = mysql_query($updateSQL, $contratos_londres) or die(mysql_error());

	echo "<script language='javascript'> alert('Pagares Actualizados.'); </script> "; 

   $updateGoTo = "pagares.php?parametro1=".$recordID."&parametro2=".$recordID0."&parametro3=".$recordID1;
  echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";

}

 if ($_POST["Cancelar"]) {
  $updateGoTo = "contrato.php?parametro1=".$recordID;
  echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";
}

 if ($_POST["Imprimir"]) {
	 $updateGoTo = "imp_pagare.php?parametro1=".$recordID."&parametro2=".$recordID0."&parametro3=".$recordID1;
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
	left:600px;
	top:9px;
	width:517px;
	height:252px;
	z-index:2;
}
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

  <form id="forma_pagare" name="forma_pagare" method="post" action="<?php echo $editFormAction; ?>">
    <table width="569" border="0">
      <tr>
        <td colspan="4" align="left" bgcolor="#000033" class="style6"><input type="submit" name="Editar" id="Editar" value="Guardar" class="style6"/>
          <input type="submit" name="Cancelar" id="Cancelar" value="Regresar al Contrato" class="style6"/>
          <input type="submit" name="Imprimir" id="Imprimir" value="Imprimir Pagares" class="style6"/>
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
				//$rec=suma_fechas($fecha_del_primerpago, 30*($i-1));
				$rec=suma_meses($fecha_del_primerpago, 1*($i-1));
				//$dia=substr($rec,0,2);
				$dia=$dia_primer_pago;
				$mes=substr($rec,3,2);
				$ano=substr($rec,6,4);
				$fechaVence=$ano."-".$mes."-".$dia;
			}
			  $insertSQL = sprintf("INSERT INTO pagares (numero_pagare, fecha_pagare, vence_pagare, importe_pagare, clave_contrato, pagado, vencido) VALUES (%s , %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($i, "text"),
					   GetSQLValueString($fechaV, "date"),					   						   
					   GetSQLValueString($fechaVence, "date"),					   						   
					   GetSQLValueString($row_contra['ctotal']/$numero_pagares, "text"),					   						   
                       GetSQLValueString($recordID, "text"),					   
					   GetSQLValueString('0', "text"),
					   GetSQLValueString('0', "text"));

				mysql_select_db($database_contratos_londres, $contratos_londres);
				$Result1 = mysql_query($insertSQL, $contratos_londres) or die(mysql_error());
				
				echo "<script language='javascript'> alert('Se dieron de alta los Pagares.'); </script> "; 
				//cerrar_querys() ;

   $updateGoTo = "pagares.php?parametro1=".$recordID."&parametro2=".$recordID0."&parametro3=".$recordID1;
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
			echo '<td width="60" align="center"> <input type="text" name="i'.$i.'" id="i'.$i.'" value="'.$row_pagares["importe_pagare"].'" class="style6" onchange="actualiza_total(this);"/>'.'<img src="copiar.jpg" name="Image1" width="14" height="17" hspace="0" vspace="0"   title="Copia el valor de este Pagare al resto de los que estan por debajo"  border="0" onclick="copia_valores(this,'.$i.');" />'.'</td>';
			// Este funciona, encontrar la forma de que se declara en formulario para que no cause falla javascript.
			//echo '<td width="100"> <input type="text" name="v1" id="v1" value="'.$row_pagares["vence_pagare"].'" />'.'<button id="trigger1">...</button></td>';
		}while ($row_pagares = mysql_fetch_assoc($pagares));
	}
  ?>
    </table>
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
	showsTime      :    true,
	button         :    \"trigger".$i."\",
	singleClick    :    false,
	step           :    1
	}); 
	</script>";

}
?>
  </p>

<div id="apDiv1">
  <table width="502" border="1" class="style6">
    <tr>
      <td width="124" bgcolor="#000033" class="style4">Número de Pagos</td>
      <td width="362"><?php echo $numero_pagares;  ?>
      <input name="numero_pagares" type="hidden" id="numero_pagares" value="<?php echo $numero_pagares; ?>" />
      <label for="xx"></label></td>
    </tr>
    <tr>
      <td bgcolor="#000033" class="style4">Fecha del Contrato</td>
      <td><?php echo $fecha_del_contrato; ?></td>
    </tr>
    <tr>
      <td bgcolor="#000033" class="style4">Fecha del Primer Pago</td>
      <td><?php echo $fecha_del_primerpago;?></td>
    </tr>
    <tr>
      <td bgcolor="#000033" class="style4">Pagare a la orden de</td>
      <td><?php echo $row_emp['representante_empresa']; ?></td>
    </tr>
    <tr>
      <td bgcolor="#000033" class="style4">Cliente</td>
      <td><?php  echo $row_contra['nombre_cliente']; ?></td>
    </tr>
    <tr>
      <td bgcolor="#000033" class="style4">Aval</td>
      <td><?php    
	  		$texto="";
			$contador=1;
			do{
				if ($contador==1){ $texto=$texto.$row_ava["nombre_aval"];} else { $texto=$texto.", ".$row_ava["nombre_aval"];}
				$contador++;
			}while ($row_ava = mysql_fetch_assoc($ava));
			echo $texto;
	  ?></td>
    </tr>
    <tr>
      <td bgcolor="#000033" class="style4">Moneda</td>
      <td><?php  echo $row_contra['moneda']; ?></td>
    </tr>
    <tr>
      <td bgcolor="#000033" class="style4">Total Contrato</td>
      <td><?php  echo "$".number_format($row_contra['ctotal'],2); ?></td>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
</body>
</html>

<?php
mysql_free_result($contra);
mysql_free_result($pagares);
mysql_free_result($tpagares);
mysql_free_result($ava);
mysql_free_result($ava2);
mysql_free_result($emp);
?>