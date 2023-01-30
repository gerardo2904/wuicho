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

$recordID1=$_GET['marcat'];
$recordID2=$_GET['modelot'];
$recordID3=$_GET['estilot'];


$variable="clave_auto>0";

if (strlen($recordID1) <> 0) 
	$variable .=" AND marca.marca LIKE '%$recordID1%' ";

if (strlen($recordID2) <> 0) 
	$variable .=" AND tipo_auto.modelo LIKE '%$recordID2%' ";

if (strlen($recordID3) <> 0) 
	$variable .=" AND tipo_auto.estilo LIKE '%$recordID3%' ";


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
$query_tipos = "SELECT tipo_auto.clave_auto, tipo_auto.clave_marca, marca.marca  ,tipo_auto.modelo, tipo_auto.estilo,tipo_auto.comentarios FROM tipo_auto, marca WHERE tipo_auto.clave_marca=marca.clave_marca AND ".$variable." ORDER BY marca, modelo";
$tipos = mysqli_query($contratos_londres, $query_tipos) or die(mysql_error());
$row_tipos = mysqli_fetch_assoc($tipos);
$totalRows_tipos = mysqli_num_rows($tipos);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tipos de Autos</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style3 {font-size: 10px}
.style1 {
	color: #FFFF00;
	font-weight: bold;
}
.style4 {
	font-size: 10px;
	color: #FFFF00;
	font-weight: bold;
}
.style5 {font-size: 10px; font-weight: bold; }
.style6 {color: #FFFF00}
.style7 {color: #000000}
-->
</style>
</head>

<body>
<div id='cssmenu'>
  <?php 
  //Inserta el Menu
  require_once('menu.php'); ?>
</div>

<p class="style2"><strong>Lista de Tipos de Autos.</strong></p>
<form id="form1" name="form1" method="get" action="tipo_list.php">
  <table width="660" border="1" class="style3">
  <tr>
    <td width="183" bgcolor="#000033" class="style6"><div align="center" class="style3 style6"><strong>Marca</strong></div></td>
    <td width="176" bgcolor="#000033" class="style6"><div align="center" class="style5">Modelo</div></td>
    <td width="210" bgcolor="#000033" class="style6"><div align="center" class="style5">Estilo</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="center" class="style7">
      <input name="marcat" type="text" class="style5" id="marcat" value="<?php echo $_GET['marcat']; ?>" />
    </div></td>
    <td><div align="center" class="style7">
      <input name="modelot" type="text" class="style5" id="modelot" value="<?php echo $_GET['modelot']; ?>" />
    </div></td>
    <td><div align="center" class="style7">
      <input name="estilot" type="text" class="style5" id="estilot" value="<?php echo $_GET['estilot']; ?>" />
    </div></td>
    <td><input name="Procesar" type="submit" class="style3" id="Procesar" value="Filtro" /></td>
  </tr>
</table>
</form>
<p><a href="tipo_edit.php"><strong>Agregar</strong></a></p>
<table border="1">
  <tr>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><div align="center"><span class="style4">Marca</span></div></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><div align="center"><span class="style4">Modelo</span></div></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><div align="center"><span class="style4">Estilo</span></div></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><div align="center"><span class="style4">Comentarios</span></div></td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="Texto_tabla"><a href="tipo_edit.php?parametro1=<?php echo $row_tipos['clave_auto']; ?>" class="style5"><strong><?php echo $row_tipos['marca']; ?></strong></a></td>
      <td class="style5 Texto_tabla"><strong><?php echo $row_tipos['modelo']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong><?php echo $row_tipos['estilo']; ?></strong></td>
      <td class="Texto_tabla style3 style5"><?php echo $row_tipos['comentarios']; ?></td>
    </tr>
    <?php } while ($row_tipos = mysqli_fetch_assoc($tipos)); ?>
</table>
<p><a href="tipo_edit.php"><strong>Agregar</strong></a></p>
<div align="justify"></div>
</body>
</html>
<?php
mysqli_free_result($tipos);

?>
