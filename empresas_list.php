<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "0,1,3,2";
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
<?php 
require_once('Connections/contratos_londres.php'); 
require_once('Funciones/funciones.php');


$recordID=$_GET['parametro1'];

funciones_reemplazadas();

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_empresas = 'SELECT clave_empresa, nombre_empresa, rfc_empresa, persona, domicilio_empresa, ciudad_empresa, cp_empresa, tel_empresa, fax_empresa, email_empresa, representante_empresa, activo_empresa FROM empresa';
$empresas = mysqli_query($contratos_londres, $query_empresas ) or die(mysqli_error($contratos_londres));
$row_empresas = mysqli_fetch_assoc($empresas);
$totalRows_empresas = mysqli_num_rows($empresas);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Empresas</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FFFF00}
.style3 {font-weight: bold}
.style4 {
	font-size: 10px;
	font-weight: bold;
}
.style5 {font-size: 10px}
-->
</style>
</head>

<body>
<div id='cssmenu'>
  <?php 
  //Inserta el Menu
  require_once('menu.php'); ?>
</div>
<p><strong>Empresas.</strong></p>
<p><a href="empresas_edit.php"><strong>Agregar</strong></a></p>
<table border="1">
  <tr>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Empresa</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">RFC</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Persona</span></td>  
    
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Domicilio</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Ciudad</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Codigo Postal</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Telefono</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Fax</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Representante</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Email</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">¿Activo?</span></td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="Texto_tabla"><a href="empresas_edit.php?parametro1=<?php echo $row_empresas['clave_empresa']; ?>" class="style4"><?php echo $row_empresas['nombre_empresa']; ?></a></td>
      <td class="style5 Texto_tabla"><strong><?php echo $row_empresas['rfc_empresa']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong><?php echo $row_empresas['persona']; ?></strong></td>    
      
      <td class="style5 Texto_tabla"><strong><?php echo $row_empresas['domicilio_empresa']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong><?php echo $row_empresas['ciudad_empresa']; ?></strong></td>
      <td class="Texto_tabla style3 style5"><?php echo $row_empresas['cp_empresa']; ?></td>
      <td class="style5 Texto_tabla"><strong><?php echo $row_empresas['tel_empresa']; ?></strong></td>
      <td class="Texto_tabla style3 style5"><?php echo $row_empresas['fax_empresa']; ?></td>
      <td class="Texto_tabla style3 style5"><?php echo $row_empresas['representante_empresa']; ?></td>
      <td class="Texto_tabla style3 style5"><?php echo $row_empresas['email_empresa']; ?></td>
      <td class="Texto_tabla style3 style5"><?php if($row_empresas['activo_empresa']==1) echo 'Si'; else echo 'No'; ?></td>
    </tr>
    <?php } while ($row_empresas = mysqli_fetch_assoc($empresas)); ?>
</table>
<p><a href="empresas_edit.php"><strong>Agregar</strong></a></p>
<div align="justify"></div>
</body>
</html>
<?php
mysqli_free_result($empresas);

?>
