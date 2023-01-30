<?php require_once('Connections/contratos_londres.php'); ?>
<?php

$recordID=$_GET['parametro1'];

$recordID1=$_GET['contrato'];
$recordID2=$_GET['nombre'];
$recordID3=$_GET['domicilio'];
$recordID4=$_GET['ciudad'];


$variable="clave_contrato>0 AND contrato.clave_cliente=clientes.clave_cliente ";

if (strlen($recordID1) <> 0) 
	$variable .=" AND contrato LIKE '%$recordID1%' ";

if (strlen($recordID2) <> 0) 
	$variable .=" AND nombre_cliente LIKE '%$recordID2%' ";

if (strlen($recordID3) <> 0) 
	$variable .=" AND domicilio_cliente LIKE '%$recordID3%' ";

if (strlen($recordID4) <> 0) 
	$variable .=" AND ciudad_cliente LIKE '%$recordID4%' ";

	

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
$query_clientes = 'SELECT clientes.clave_cliente, clientes.nombre_cliente, clientes.domicilio_cliente, clientes.ciudad_cliente, contrato.clave_contrato, contrato.contrato, DATE_FORMAT(contrato.fecha_contrato, \'%d/%m/%Y\') as fecha, contrato.fecha_contrato, aplicado, if(aplicado=0,"Sí","No") as aplicadot FROM clientes, contrato WHERE '.$variable.' ORDER BY fecha DESC';
$clientes = mysql_query($query_clientes, $contratos_londres) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista de Contratos</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FFFF00}
.style3 {font-weight: bold}
.style4 {
	font-size: 10px;
	font-weight: bold;
	text-align: center;
}
.style5 {font-size: 10px}
.style6 {color: #FFFF00; font-weight: bold; font-size: 10px; }
-->
</style>
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p><strong>Contratos.</strong></p>
<div id="filtros" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">Filtros de Busqueda...</div>
  <div class="CollapsiblePanelContent">
    <form id="form1" name="form1" method="get" action="contratos_list.php">
      <table width="660" border="1">
        <tr>
          <td width="183" bgcolor="#000033" class="style6"><div align="center">Contrato</div></td>
          <td width="176" bgcolor="#000033" class="style6"><div align="center">Cliente</div></td>
          <td width="210" bgcolor="#000033" class="style6"><div align="center">Domicilio</div></td>
          <td width="63" bgcolor="#000033" class="style6"><div align="center">Ciudad</div></td>
          <td width="63" bgcolor="#000033" class="style6"><div align="center">¿Aplicado?</div></td>
          <td width="63" bgcolor="#000033" class="style6">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center">
            <input name="contrato" type="text" class="style4" id="contrato" value="<?php echo $_GET['contrato']; ?>" />
          </div></td>
          <td><div align="center">
            <input name="nombre" type="text" class="style4" id="nombre" value="<?php echo $_GET['nombre']; ?>" />
          </div></td>
          <td><div align="center">
            <input name="domicilio" type="text" class="style4" id="domicilio" value="<?php echo $_GET['domicilio']; ?>" />
          </div></td>
          <td><div align="center">
            <input name="ciudad" type="text" class="style4" id="ciudad" value="<?php echo $_GET['ciudad']; ?>" />
          </div></td>
          <td><input <?php if (!(strcmp($_GET['aplicado'],1))) {echo "checked=\"checked\"";} ?> name="aplicado" type="checkbox" id="aplicado" value="1" />
            <label for="aplicado"></label></td>
          <td><input type="submit" name="Procesar" id="Procesar" value="Filtro" /></td>
        </tr>
      </table>
  </form>
  </div>
</div>
<p>&nbsp;</p>
<p><a href="contrato.php"><strong>Agregar</strong></a></p>
<table border="1">
  <tr>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Fecha de Venta</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Contrato</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Cliente</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Domicilio</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Ciudad</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Aplicado</span></td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="Texto_tabla"><a href="contrato.php?parametro1=<?php echo $row_clientes['clave_contrato']; ?>" class="style4"><?php echo $row_clientes['fecha']; ?></a></td>
      <td class="Texto_tabla"><a href="contrato.php?parametro1=<?php echo $row_clientes['clave_contrato']; ?>" class="style4"><?php echo $row_clientes['contrato']; ?></a></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_clientes['nombre_cliente']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_clientes['domicilio_cliente']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_clientes['ciudad_cliente']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_clientes['aplicadot']; ?></strong></td>
    </tr>
    <?php } while ($row_clientes = mysql_fetch_assoc($clientes)); ?>
</table>
<p><a href="contrato.php"><strong>Agregar</strong></a></p>
<div align="justify"></div>
<script type="text/javascript">
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("filtros");
</script>
</body>
</html>
<?php
mysql_free_result($clientes);

?>
