<?php require_once('Connections/contratos_londres.php'); ?>
<?php

$recordID=$_GET['parametro1'];
$aplica=0;

$total_desc=0;

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_desc = "SELECT clave_contrato FROM contrato where clave_contrato='$recordID'";
$desc = mysql_query($query_desc, $contratos_londres) or die(mysql_error());
$row_desc = mysql_fetch_assoc($desc);
$totalRows_desc = mysql_num_rows($desc);

$total_desc=$totalRows_desc;

mysql_free_result($desc);


if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "0,1,2";
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
?>
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

$colname_empresa = "-1";
if (isset($_SESSION['MM_Empresa'])) {
  $colname_empresa = $_SESSION['MM_Empresa'];
}

//$temporal=$_POST['clave_proveedor'];

if ($recordID>0){$_POST['contrato']=$parametro1;}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ($_POST["Grabar"]) {
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO contrato (contrato, credito, clave_empresa, clave_cliente, fecha_contrato, cprecio, cacuenta, civa, ctotal, cefectivo, no_cheque, ccheque, banco_cheque, forma_pago, promocion, no_pagos, interes, moratorio, cenganche, cinteres, clave_inv, clave_inv_acuenta, cacuenta, garantia, aspecto_mec, aspecto_car, fecha_garantia, partes_garantia, clave_vendedor, clave_cobrador, clave_testigo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['contrato'], "text"),
                       GetSQLValueString($_POST['credito'], "text"),
                       GetSQLValueString($_POST['clave_empresa'], "text"),
                       GetSQLValueString($_POST['clave_cliente'], "text"),
                       GetSQLValueString($_POST['fecha_contrato'], "text"),
                       GetSQLValueString($_POST['cprecio'], "text"),
					   GetSQLValueString($_POST['cacuenta'], "text"),
                       GetSQLValueString($_POST['civa'], "text"),
                       GetSQLValueString($_POST['ctotal'], "text"),					   
                       GetSQLValueString($_POST['ccefectivo'], "text"),					   
                       GetSQLValueString($_POST['no_cheque'], "text"),
                       GetSQLValueString($_POST['ccheque'], "text"),
                       GetSQLValueString($_POST['banco_cheque'], "text"),
                       GetSQLValueString($_POST['forma_pago'], "text"),
  				       GetSQLValueString($_POST['promocion'], "text"),					   					   					   					   GetSQLValueString($_POST['no_pagos'], "text"),
					   GetSQLValueString($_POST['interes'], "text"),
					   GetSQLValueString($_POST['moratorio'], "text"),
					   GetSQLValueString($_POST['cenganche'], "text"),
					   GetSQLValueString($_POST['cinteres'], "text"),
					   GetSQLValueString($_POST['clave_inv'], "text"),
					   GetSQLValueString($_POST['clave_inv_acuenta'], "text"),
					   GetSQLValueString($_POST['cacuenta'], "text"),
					   GetSQLValueString($_POST['garantia'], "text"),
					   GetSQLValueString($_POST['aspecto_mec'], "text"),
					   GetSQLValueString($_POST['aspecto_car'], "text"),
					   GetSQLValueString($_POST['fecha_garantia'], "text"),
					   GetSQLValueString($_POST['partes_garantia'], "text"),
					   GetSQLValueString($_POST['clave_vendedor'], "text"),
					   GetSQLValueString($_POST['clave_cobrador'], "text"),
					   GetSQLValueString($_POST['clave_testigo'], "text"));

  mysql_select_db($database_contratos_londres, $contratos_londres);
  $Result1 = mysql_query($insertSQL, $contratos_londres) or die(mysql_error());

  $insertGoTo = "contratos.php?parametro1=".$_POST['contrato'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
}


if ($_POST["Editar"])
{
 $prov=$_POST['clave_cliente'];
 $fec=$_POST['fecha_contrato'];
 
  $updateSQL = "UPDATE contrato SET fecha_contrato= '$fec', clave_cliente='$clie' WHERE contrato='$recordID'";
 mysql_query($updateSQL) or die ("Error en query: $updateSQL");

  $updateGoTo = "contratos.php?parametro1=".$_POST['folioc'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

}

if ($_POST["Aplicar"])
{

if ($totalRows_materiales>=1) {
 do { 
		$m=$row_materiales['clave_material'];
		mysql_select_db($database_contratos_londres, $contratos_londres);
		$query_empmat = "SELECT clave_empresa, clave_material, inventario_material  FROM empresa_material where clave_material='$m' AND clave_empresa='$colname_empresa'";
		$empmat = mysql_query($query_empmat, $recicladora) or die(mysql_error());
		$row_empmat = mysql_fetch_assoc($empmat);
		$totalRows_empmat = mysql_num_rows($empmat);
		
		if ($totalRows_empmat = 0) 
			{ 
				//Insertar
		    }
			else
			{
				
				$cantidad=$row_empmat['inventario_material']+$row_materiales['compra_kilos'];
				$mat=$row_empmat['clave_material'];
				//echo "Clave Material: ".$mat."<BR>";
				//echo "Clave Empresa: ".$colname_empresa."<BR>";
				//echo "Cantidad: ".$cantidad."<BR>";
				$updateSQL = "UPDATE empresa_material SET inventario_material= '$cantidad' WHERE clave_material='$mat' AND clave_empresa='$colname_empresa'";
				mysql_query($updateSQL) or die ("Error en query: $updateSQL");

			}


		mysql_free_result($empmat); 
		
 }while ($row_materiales = mysql_fetch_assoc($materiales)); 
// exit;

$colname_usuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarios = $_SESSION['MM_Username'];
}
$c=0;
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_usuarios2 = sprintf("SELECT * FROM usuarios WHERE login_usuario = %s ORDER BY login_usuario ASC", GetSQLValueString($colname_usuarios, "text"));
$usuarios2 = mysql_query($query_usuarios2, $contratos_londres) or die(mysql_error());
$row_usuarios2 = mysql_fetch_assoc($usuarios2);
$totalRows_usuarios2 = mysql_num_rows($usuarios2);
$c=$row_usuarios2['clave_usuario'];
mysql_free_result($usuarios2);

$updateSQL = "UPDATE contrato SET clave_usuario=".$c." ,aplicado= 1 WHERE contrato='$recordID'";
mysql_query($updateSQL) or die ("Error en query: $updateSQL");
}
 

  $updateGoTo = "contratos.php?parametro1=".$_POST['folioc'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

}


$cu=0;

if ($recordID>0){ 
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_contrato_maxico = "SELECT clave_usuario, contrato as contrato_max FROM contrato where contrato='$recordID'";
$contrato_maxico = mysql_query($query_contrato_maxico, $contratos_londres) or die(mysql_error());
$row_contrato_maxico = mysql_fetch_assoc($contrato_maxico);
$totalRows_contrato_maxico = mysql_num_rows($contrato_maxico);
$cu=$row_contrato_maxico['clave_usuario'];
}
else
{
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_contrato_maxico = "SELECT max(contrato)+1 as contrato_max FROM contrato";
$contrato_maxico = mysql_query($query_contrato_maxico, $contratos_londres) or die(mysql_error());
$row_contrato_maxico = mysql_fetch_assoc($contrato_maxico);
$totalRows_contrato_maxico = mysql_num_rows($contrato_maxico);
}

//$colname_empresa = "-1";
//if (isset($_SESSION['MM_Empresa'])) {
//  $colname_empresa = $_SESSION['MM_Empresa'];
//}

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_clientes = "SELECT * FROM clientes ORDER BY nombre_cliente ASC";
$clientes = mysql_query($query_clientes, $contratos_londres) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);

$colname_usuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarios = $_SESSION['MM_Username'];
}

if ($cu == 0) {

}
else
{
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_usuarios = sprintf("SELECT * FROM usuarios WHERE clave_usuario = %s ORDER BY login_usuario ASC", GetSQLValueString($cu,"text"));
$usuarios = mysql_query($query_usuarios, $contratos_londres) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);
}

$contra=0;

if ($recordID>0){ 
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_contratoc = "select * from contrato where contrato='$recordID'";
$contratoc = mysql_query($query_contratocc, $contratos_londres) or die(mysql_error());
$row_contratoc = mysql_fetch_assoc($contratoc);
$totalRows_contratoc = mysql_num_rows($contratoc);

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_empresas = "select * from empresa";
$empresas = mysql_query($query_empresas, $contratos_londres) or die(mysql_error());
$row_empresas = mysql_fetch_assoc($empresas);
$totalRows_empresas = mysql_num_rows($empresas);

$contra=$row_contrato_maxico['contrato_max'];
$aplica=$row_contratoc['aplicado'];

mysql_free_result($contratoc);

mysql_free_result($empresas);

}




//echo "Folio maximo: ".$folio_compra;


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contrato</title>
<link href="file:///D|/AppServ/www/recicladora/cuscosky.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:14px;
	top:21px;
	width:150px;
	height:29px;
	z-index:1;
}
#apDiv2 {
	position:absolute;
	left:18px;
	top:258px;
	width:254px;
	height:37px;
	z-index:2;
}
#apDiv3 {
	position:absolute;
	left:289px;
	top:256px;
	width:703px;
	height:82px;
	z-index:3;
}
#etiqueta_folio {
	position:absolute;
	left:14px;
	top:136px;
	width:116px;
	height:24px;
	z-index:4;
}
#folio {
	position:absolute;
	left:130px;
	top:136px;
	width:83px;
	height:24px;
	z-index:5;
}
.style4 {
	font-size: 14px;
	font-weight: bold;
}
.style5 {
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
}
#direccion_empresa {
	position:absolute;
	left:16px;
	top:14px;
	width:552px;
	height:86px;
	z-index:6;
}
#imagen {
	position:absolute;
	left:15px;
	top:18px;
	width:146px;
	height:79px;
	z-index:7;
}
#apDiv4 {
	position:absolute;
	left:16px;
	top:102px;
	width:1006px;
	height:133px;
	z-index:8;
}
.style7 {
	font-size: 12px;
	font-weight: bold;
	color: #000000;
}
.style10 {font-size: 12px}
-->
</style>

<link rel="stylesheet" type="text/css" media="all" href="jscalendar-0.9.6/calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script type="text/javascript" src="jscalendar-0.9.6/calendar.js"></script>
<script type="text/javascript" src="jscalendar-0.9.6/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar-0.9.6/calendar-setup.js"></script>

<style type="text/css">
<!--
@import url("jscalendar-0.9.6/calendar-win2k-cold-1.css");
#apDiv5 {
	position:absolute;
	left:16px;
	top:340px;
	width:1005px;
	height:1404px;
	z-index:9;
}
.style11 {
	font-size: 10px;
	color: #FFFF00;
}
.style14 {
	font-size: 10px;
	color: #FFFF00;
	font-weight: bold;
}
.style15 {
	font-size: 10
}
.style16 {font-size: 10px}
-->
</style>
</head>

<body>
<div class="style4" id="direccion_empresa">
<?php 
echo $row_empresa['nombre_empresa']." <BR>".$row_empresa['domicilio_empresa']." <BR>"."Codigo Postal ".$row_empresa['cp_empresa'].", ".$row_empresa['ciudad_empresa']."<BR>"."Telefono ".$row_empresa['tel_empresa'].", Fax ".$row_empresa['fax_empresa']."<BR>"."email: ".$row_empresa['email_empresa']; 
?></div>

<div id="apDiv4">
  <form id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>">
    <table width="969" border="1">
      <tr>
        <td bgcolor="#000033"><div align="center" class="style14">Folio de compra</div></td>
        <td bgcolor="#000033"><div align="center" class="style14">Fecha</div></td>
        <td bgcolor="#000033" class="style7"><div align="center" class="style14">Proveedor</div></td>
        <td bgcolor="#000033" class="style7"><div align="center" class="style14">Total de la  Compra</div></td>
        <td bgcolor="#000033"><div align="center" class="style7 style11"><strong>Usuario</strong></div></td>
      </tr>
      <tr>
        <td width="165"><div align="center"><span class="style5"><span class="style10"><?php echo $row_contrato_maxico['contrato_max']; ?></span></span></div></td>
        <td width="214"><div align="left"><span class="style7">
            <input name="fecha_contrato" type="text" class="style16" id="fecha_contrato" <?php if ($aplica == 1) {echo "disabled";} else {echo "enabled";}?> value="<?php 
			if ($recordID>0) echo $row_contratoc['fecha_contrato'];
			else
			echo date('Y-m-d G:i:s'); 
			?>" size="22" />
            
            <button id="trigger">...</button>
        </span></div></td>
        <td width="125" class="style7"><div align="left"><strong>
            <select name="clave_cliente" class="style16" id="clave_cliente" <?php if ($aplica == 1) {echo "disabled";} else {echo "enabled";}?>>
              <?php
do {  
?>
              <option value="<?php echo $row_clientes['clave_cliente']?>"<?php if (!(strcmp($row_clientes['clave_cliente'], $row_contratoc['clave_cliente']))) {echo "selected=\"selected\"";} ?>><?php echo $row_clientes['nombre_cliente']?></option>
              <?php
} while ($row_clientes = mysql_fetch_assoc($clientes));
  $rows = mysql_num_rows($clientes);
  if($rows > 0) {
      mysql_data_seek($clientes, 0);
	  $row_clientes = mysql_fetch_assoc($clientes);
  }
?> </select>
        </strong></div></td>
        <td width="150" class="style7"><div align="center">
            <input name="ctotal" type="text" class="style16" id="ctotal" dir="rtl" value="<?php 
			                     if ($recordID>0) echo $row_contratoc['ctotal'];
									else
								 echo "0.0"; ?>" size="20" readonly="true" />
        </div></td>
        <td width="281"><div align="center" class="style7">
            <div align="center" class="style15">
              <div align="center" class="style16"><?php echo $row_usuarios2['nombre_usuario']; ?></div>
            </div>
        </div></td>
      </tr>
      <tr>
        <td colspan="5"><input name="Grabar" type="submit" class="style7" value="Grabar" <?php if ($recordID > 0 || $aplica == 1 ) {echo "disabled";} else {echo "enabled";}?>/>
          <input name="Editar" type="submit" class="style7" id="edicion" value="Editar" <?php if ($aplica == 1 || $recordID == 0) {echo "disabled";} else {echo "enabled";}?>/>            
          <input name="Aplicar" type="submit" class="style7" id="aplicar" value="Aplicar" <?php if ($aplica == 1 || $recordID == 0 || $total_desc == 0) {echo "disabled";} else {echo "enabled";}?>/>
          <input name="contrato" type="hidden" id="contrato" value="<?php echo $row_folio_maxico['contrato_max']; ?>" />
            <input name="clave_empresa" type="hidden" id="clave_empresa" value="<?php echo $_SESSION['MM_Empresa']; ?>" />
            <input name="clave_usuario" type="hidden" id="clave_usuario" value="<?php echo $row_usuarios['clave_usuario']; ?>" />
            <input name="MM_insert" type="hidden" id="MM_insert" value="form1" />
Folio Aplicado:
<input name="aplicado" type="checkbox" disabled="disabled" id="aplicado" value="" <?php if (!(strcmp($row_contratoc['aplicado'],1))) {echo "checked=\"checked\"";} ?> /></td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </form>
  </div>

<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_contrato",      // id of the input field
        ifFormat       :    "%Y-%m-%d %H:%M:%S",       // format of the input field
        showsTime      :    true,            // will display a time selector
        button         :    "trigger",   // trigger for the calendar (button ID)
        singleClick    :    false,           // double-click mode
        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
    });
</script>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><span class="style7">
  <?php

// Si Ya esta aplicado, no muestra el link para capturar material...


 
 $link="<a href=desc_compra.php?parametro1=$recordID&amp;parametro2=$colname_empresa>Captura Material</a>";
 
 
 if ($aplica == 0 && $recordID>0) {echo $link;}
?>
</span></p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($contrato_maxico);

mysql_free_result($empresas);

mysql_free_result($clientes);

mysql_free_result($usuarios);
?>
