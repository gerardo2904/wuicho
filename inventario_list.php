<?php
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

$MM_restrictGoTo = "conectar.php";
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
<?php require_once('Connections/contratos_londres.php'); ?>
<?php

$recordID=$_GET['parametro1'];

$recordID1=$_GET['marca'];
$recordID2=$_GET['modelo'];
$recordID3=$_GET['estilo'];
$recordID4=$_GET['especificaciones'];
$recordID5=$_GET['ano'];
$recordID6=$_GET['motor'];
$recordID7=$_GET['puertas'];
$recordID8=$_GET['serie'];
$recordID9=$_GET['pedimento'];
$recordID10=$_GET['proveedor'];
$recordID11=$_GET['sucursal'];
$recordID12=$_GET['vendido'];
$recordID13=$_GET['acambio'];

//$variable="referencias.clave_cliente=clientes.clave_cliente";
$variable="";

if (strlen($recordID1) <> 0) 
	$variable .=" AND marca.marca LIKE '%$recordID1%' ";

if (strlen($recordID2) <> 0) 
	$variable .=" AND tipo_auto.modelo LIKE '%$recordID2%' ";

if (strlen($recordID3) <> 0) 
	$variable .=" AND tipo_auto.estilo LIKE '%$recordID3%' ";

if (strlen($recordID4) <> 0) 
	$variable .=" AND inventario_auto.especificaciones LIKE '%$recordID4%' ";

if (strlen($recordID5) <> 0) 
	$variable .=" AND inventario_auto.ano LIKE '%$recordID5%' ";

if (strlen($recordID6) <> 0) 
	$variable .=" AND inventario_auto.motor LIKE '%$recordID6%' ";

if (strlen($recordID7) <> 0) 
	$variable .=" AND inventario_auto.puertas LIKE '%$recordID7%' ";

if (strlen($recordID8) <> 0) 
	$variable .=" AND inventario_auto.serie LIKE '%$recordID8%' ";

if (strlen($recordID9) <> 0) 
	$variable .=" AND inventario_auto.pedimento LIKE '%$recordID9%' ";

if (strlen($recordID10) <> 0) 
	$variable .=" AND inventario_auto.proveedor LIKE '%$recordID10%' ";

if (strlen($recordID11) <> 0) 
	$variable .=" AND empresa.nombre_empresa LIKE '%$recordID11%' ";

if (strlen($recordID12) == 1) {
	$variable .=" AND inventario_auto.vendido=1 ";
	}

if (strlen($recordID13) == 1) {
	$variable .=" AND inventario_auto.acambio=1 ";
	}

	

$orden="marca.marca";
/*$orden=$_GET['orden'];

if ($orden=='') {$orden='marca';}

if ($orden=='marca') {$orden='marca';}
if ($orden=='modelo') {$orden='modelo';}
if ($orden=='estilo') {$orden='estilo';}
if ($orden=='ano') {$orden='ano';}
if ($orden=='motor') {$orden='motor';}
if ($orden=='km') {$orden='km';}
if ($orden=='puertas') {$orden='puertas';}
if ($orden=='sucursal') {$orden='clave_sucursal';}
*/

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

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_inventariodeautos = "SELECT inventario_auto.clave_inv, inventario_auto.clave_auto, inventario_auto.especificaciones, inventario_auto.km, inventario_auto.precio, inventario_auto.ano, inventario_auto.puertas, inventario_auto.motor, inventario_auto.clave_empresa, inventario_auto.fotos, inventario_auto.pedimento, inventario_auto.vendido, inventario_auto.acambio, inventario_auto.serie, inventario_auto.proveedor, tipo_auto.modelo, tipo_auto.estilo, marca.marca, empresa.nombre_empresa FROM inventario_auto, tipo_auto, marca, empresa WHERE inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca AND inventario_auto.clave_empresa=empresa.clave_empresa ".$variable." GROUP BY clave_inv ORDER BY '$orden' ASC";
//echo $query_inventariodeautos;exit;
$inventariodeautos = mysqli_query($contratos_londres, $query_inventariodeautos) or die(mysql_error());
$row_inventariodeautos = mysqli_fetch_assoc($inventariodeautos);
$totalRows_inventariodeautos = mysqli_num_rows($inventariodeautos);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inventario de Autos Londres</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 10px}
.style2 {font-weight: bold}
.style3 {font-weight: bold}
.style5 {color: #FFFF00}
.style6 {
	font-size: 10px;
	color: #FFFF00;
	font-weight: bold;
}
.style7 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>

<body>
<div id='cssmenu'>
  <?php 
  //Inserta el Menu
  require_once('menu.php'); ?>
</div>

<p class="style2 style3">Inventario de Autos Londres.</p>

<form id="form1" name="form1" method="get" action="inventario_list.php">
  <table width="660" border="1">
  <tr>
    <td width="183" bgcolor="#000033" class="style6"><div align="center">Marca</div></td>
    <td width="176" bgcolor="#000033" class="style6"><div align="center">Modelo</div></td>
    <td width="210" bgcolor="#000033" class="style6"><div align="center">Estilo</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Especificaciones</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Año</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Motor</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Puertas</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Serie</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Pedimento</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Proveedor</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Sucursal</div></td>
    </tr>
  <tr>
    <td><div align="center">
      <input name="marca" type="text" class="style1" id="marca" value="<?php echo $_GET['marca']; ?>" size="15" />
    </div></td>
    <td><div align="center">
      <input name="modelo" type="text" class="style1" id="modelo" value="<?php echo $_GET['modelo']; ?>" size="15" />
    </div></td>
    <td><div align="center">
      <input name="estilo" type="text" class="style1" id="estilo" value="<?php echo $_GET['estilo']; ?>" size="15" />
    </div></td>
    <td><div align="center">
      <input name="especificaciones" type="text" class="style1" id="especificaciones" value="<?php echo $_GET['especificaciones']; ?>" />
    </div></td>
    <td><input name="ano" type="text" class="style1" id="ano" value="<?php echo $_GET['ano']; ?>" size="6" /></td>
    <td><div align="center">
      <input name="motor" type="text" class="style1" id="motor" value="<?php echo $_GET['motor']; ?>" size="6" />
    </div></td>
    <td><input name="puertas" type="text" class="style1" id="puertas" value="<?php echo $_GET['puertas']; ?>" size="6" /></td>
    <td><input name="serie" type="text" class="style1" id="serie" value="<?php echo $_GET['serie']; ?>" size="20" /></td>
    <td><input name="pedimento" type="text" class="style1" id="pedimento" value="<?php echo $_GET['pedimento']; ?>" size="20" /></td>
    <td><input name="proveedor" type="text" class="style1" id="proveedor" value="<?php echo $_GET['proveedor']; ?>" size="20" /></td>
    <td><input name="sucursal" type="text" class="style1" id="sucursal" value="<?php echo $_GET['sucursal']; ?>" size="25" /></td>
    </tr>
  <tr>
    <td colspan="11"><span class="style1">
<input name="vendido" type="checkbox" id="vendido" value="1" <?php if (!(strcmp($_GET['vendido'],1))) {echo "checked=\"checked\"";} ?> />      
¿Vendido? 
<input <?php if (!(strcmp($_GET['acambio'],1))) {echo "checked=\"checked\"";} ?> name="acambio" type="checkbox" id="acambio" value="1" />
¿A cambio?    </span> 
      <input name="Procesar" type="submit" class="style1" id="Procesar" value="Filtro" /></td>
    </tr>
</table>
</form>

<p><a href="inventario_edit.php"><strong>Agregar</strong></a></p>
<table border="1">
  <tr>
    <td bgcolor="#000066" class="Encabezado_tabla"><div align="center" class="style6"><strong><strong>Marca</strong></strong></div></td>
    <td bgcolor="#000066" class="Encabezado_tabla"><div align="center" class="style6"><strong>Modelo</strong></div></td>
    <td bgcolor="#000066" class="Encabezado_tabla"><div align="center" class="style6">Estilo</div></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><div align="center"><span class="style5"><strong>Especificaciones</strong></span></div></td>
    <td bgcolor="#000066" class="style6"><div align="center">Año</div></td>
    <td bgcolor="#000066" class="style6"><div align="center">Motor</div></td>
    <td bgcolor="#000066" class="style6"><div align="center">Millas</div></td>
    <td bgcolor="#000066" class="style6"><div align="center">Puertas</div></td>
    <td bgcolor="#000066" class="style6"><div align="center">No. Serie</div></td>
    <td bgcolor="#000066" class="style6"><div align="center">No. Pedimento</div></td>
    <td bgcolor="#000066" class="style6"><div align="center">Proveedor</div></td>
    <td bgcolor="#000066" class="style6"><div align="center">¿Vendido?</div></td>
    <td bgcolor="#000066" class="style6"><div align="center">¿A cambio?</div></td>
    <td bgcolor="#000066" class="style6"><div align="center">Sucursal</div></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><div align="center"><span class="style5"><strong>Fotos</strong></span></div></td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="style1"><a href="inventario_edit.php?parametro1=<?php echo $row_inventariodeautos['clave_inv']; ?>"><strong><?php echo $row_inventariodeautos['marca']; ?></strong></a></td>
      <td class="style7"><?php echo $row_inventariodeautos['modelo']; ?></td>
      <td class="style7"><?php echo $row_inventariodeautos['estilo']; ?></td>
      <td class="style7"><?php echo $row_inventariodeautos['especificaciones']; ?></td>
      <td class="style7"><?php echo $row_inventariodeautos['ano']; ?></td>
      <td class="style7"><?php echo $row_inventariodeautos['motor']; ?></td>
      <td class="style7"><?php echo $row_inventariodeautos['km']; ?></td>
      <td class="style7"><div align="center"><?php echo $row_inventariodeautos['puertas']; ?></div></td>
      <td class="style7"><?php echo $row_inventariodeautos['serie']; ?></td>
      <td class="style7"><?php echo $row_inventariodeautos['pedimento']; ?></td>
      <td class="style7"><?php echo $row_inventariodeautos['proveedor']; ?></td>
      <td class="style7"><div align="center"><?php echo ($row_inventariodeautos['vendido'])?"Sí":"No"; ?></div></td>
      <td class="style7"><div align="center"><?php echo ($row_inventariodeautos['acambio'])?"Sí":"No"; ?></div></td>
      <td class="style7"><?php echo $row_inventariodeautos['nombre_empresa']; ?></td>
      <td class="style1"><div align="center"><a href="fotos.php?carro=<?php echo $row_inventariodeautos['clave_inv']; ?>"><strong><?php echo $row_inventariodeautos['fotos']; ?></strong></a></div></td>
    </tr>
    <?php } while ($row_inventariodeautos = mysqli_fetch_assoc($inventariodeautos)); ?>
</table>
<p><a href="inventario_edit.php"><strong>Agregar</strong></a> </p>
<div align="justify"></div>
</body>
</html>
<?php
mysqli_free_result($inventariodeautos);

?>
