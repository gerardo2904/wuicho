<?php require_once('Connections/contratos_londres.php'); ?>
<?php

$recordID=$_GET['parametro1'];

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

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_clientes = 'SELECT clave_cliente, nombre_cliente, rfc_cliente, domicilio_cliente, ciudad_cliente, cp_cliente, tel_cliente, fax_cliente, email_cliente FROM clientes ORDER BY nombre_cliente ASC';
$clientes = mysql_query($query_clientes, $contratos_londres) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Clientes</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
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
<p><strong>Clientes.</strong></p>
<p><a href="clientes_edit.php"><strong>Agregar</strong></a></p>
<table border="1">
  <tr>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Nombre</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">RFC</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Domicilio</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Ciudad</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Codigo Postal</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Telefono</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Fax</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style4">Email</span></td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="Texto_tabla"><a href="clientes_edit.php?parametro1=<?php echo $row_clientes['clave_cliente']; ?>" class="style4"><?php echo $row_clientes['nombre_cliente']; ?></a></td>
      <td class="style5 Texto_tabla"><strong><?php echo $row_clientes['rfc_cliente']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong><?php echo $row_clientes['domicilio_cliente']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong><?php echo $row_clientes['ciudad_cliente']; ?></strong></td>
      <td class="Texto_tabla style3 style5"><?php echo $row_clientes['cp_cliente']; ?></td>
      <td class="style5 Texto_tabla"><strong><?php echo $row_clientes['tel_cliente']; ?></strong></td>
      <td class="Texto_tabla style3 style5"><?php echo $row_clientes['fax_cliente']; ?></td>
      <td class="Texto_tabla style3 style5"><?php echo $row_clientes['email_cliente']; ?></td>
    </tr>
    <?php } while ($row_clientes = mysql_fetch_assoc($clientes)); ?>
</table>
<p><a href="clientes_edit.php"><strong>Agregar</strong></a></p>
<div align="justify"></div>
</body>
</html>
<?php
mysql_free_result($clientes);

?>
