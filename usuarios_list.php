<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "0,1";
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
?><?php 
require_once('Connections/contratos_londres.php'); 
require_once('Funciones/funciones.php'); 
?>
<?php

$recordID=$_GET['parametro1'];

funciones_reemplazadas();

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_usuarios = 'SELECT clave_usuario, login_usuario, nombre_usuario, permisos_usuario, activo_usuario FROM usuarios';
$usuarios = mysqli_query($contratos_londres, $query_usuarios) or die(mysql_error($contratos_londres));
$row_usuarios = mysqli_fetch_assoc($usuarios);
$totalRows_usuarios = mysqli_num_rows($usuarios);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Usuarios</title>
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
<p><strong>Usuarios.</strong></p>
<p><a href="usuarios_edit.php"><strong>Agregar</strong></a></p>
<table border="1">
  <tr>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Login</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Nombre del Usuario</span></td>
        <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Permisos</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">¿Activo?</span></td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="Texto_tabla"><a href="usuarios_edit.php?parametro1=<?php echo $row_usuarios['clave_usuario']; ?>" class="style4"><?php echo $row_usuarios['login_usuario']; ?></a></td>
      <td class="style4"><?php echo $row_usuarios['nombre_usuario']; ?></td>
      <td class="Texto_tabla style3 style5"><?php if($row_usuarios['permisos_usuario']==0) echo 'Administrador'; else { if($row_usuarios['permisos_usuario']==1) echo 'Administrador'; else {if($row_usuarios['permisos_usuario']==2) echo 'Acceso al Sistema'; else echo 'Solo Reportes'; }}?></td>
      <td class="Texto_tabla style3 style5"><?php if($row_usuarios['activo_usuario']==1) echo 'Si'; else echo 'No'; ?></td>
    </tr>
    <?php } while ($row_usuarios = mysqli_fetch_assoc($usuarios)); ?>
</table>
<p><a href="usuarios_edit.php"><strong>Agregar</strong></a></p>
<div align="justify"></div>
</body>
</html>
<?php
mysqli_free_result($usuarios);

?>
