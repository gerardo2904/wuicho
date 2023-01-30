<?php 
require_once('Connections/contratos_londres.php'); 
require_once('Funciones/funciones.php');

if (!isset($_SESSION)) {
  session_start();
}

$recordID=$_GET['parametro1'];

$recordID1=$_GET['nombre'];
$recordID2=$_GET['rfc'];
$recordID3=$_GET['domicilio'];
$recordID4=$_GET['ciudad'];
$recordID5=$_GET['activo'];


$variable="clave_vendedor>0";

if (strlen($recordID1) <> 0) 
	$variable .=" AND nombre_vendedor LIKE '%$recordID1%' ";

if (strlen($recordID2) <> 0) 
	$variable .=" AND rfc_vendedor LIKE '%$recordID2%' ";

if (strlen($recordID3) <> 0) 
	$variable .=" AND domicilio_vendedor LIKE '%$recordID3%' ";

if (strlen($recordID4) <> 0) 
	$variable .=" AND ciudad_vendedor LIKE '%$recordID4%' ";

if (strlen($recordID4) <> 0) 
	$variable .=" AND activo LIKE '%$recordID5%' ";
	

funciones_reemplazadas();

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_vendedores = 'SELECT clave_vendedor, nombre_vendedor, rfc_vendedor, persona, domicilio_vendedor, ciudad_vendedor, cp_vendedor, tel_vendedor, tel_vendedor_movil, tel_vendedor_trabajo, fax_vendedor, email_vendedor, activo FROM vendedores WHERE '.$variable.' ORDER BY nombre_vendedor ASC';
$vendedores = mysqli_query($contratos_londres, $query_vendedores) or die(mysqli_error($contratos_londres));
$row_vendedores = mysqli_fetch_assoc($vendedores);
$totalRows_vendedores = mysqli_num_rows($vendedores);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingenieros de Servicio</title>
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
.style6 {color: #FFFF00; font-weight: bold; font-size: 10px; }
-->
</style>
</head>

<body>
<div id='cssmenu'>
  <?php 
  //Inserta el Menu
  require_once('menu.php'); ?>
</div>
<p><strong>Ingenieros.</strong></p>
<form id="form1" name="form1" method="get" action="vendedores_list.php">
  <table width="660" border="1">
  <tr>
    <td width="183" bgcolor="#000033" class="style6"><div align="center">Nombre</div></td>
    <td width="176" bgcolor="#000033" class="style6"><div align="center">RFC</div></td>
    <td width="210" bgcolor="#000033" class="style6"><div align="center">Domicilio</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Ciudad</div></td>
    <td width="63" bgcolor="#000033" class="style6">¿Activo?</td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="center">
      <input name="nombre" type="text" class="style4" id="nombre" value="<?php echo $_GET['nombre']; ?>" />
    </div></td>
    <td><div align="center">
      <input name="rfc" type="text" class="style4" id="rfc" value="<?php echo $_GET['rfc']; ?>" />
    </div></td>
    <td><div align="center">
      <input name="domicilio" type="text" class="style4" id="domicilio" value="<?php echo $_GET['domicilio']; ?>" />
    </div></td>
    <td><div align="center">
      <input name="ciudad" type="text" class="style4" id="ciudad" value="<?php echo $_GET['ciudad']; ?>" />
    </div></td>
    <td><div align="center">
      <input name="activo" type="checkbox" id="activo" value="1" checked="checked" />
    </div></td>
    <td><input type="submit" name="Procesar" id="Procesar" value="Filtro" /></td>
  </tr>
</table>
</form>

<p><a href="vendedores_edit.php"><strong>Agregar</strong></a></p>
<table border="1">
  <tr>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Nombre</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">RFC</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Persona</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Domicilio</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Ciudad</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Codigo Postal</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Telefono</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Telefono Móvil</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Telefono Trabajo</span></td>  
    
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Email</span></td>
    <td bgcolor="#000066" class="style6">¿Activo?</td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="Texto_tabla"><a href="vendedores_edit.php?parametro1=<?php echo $row_vendedores['clave_vendedor']; ?>" class="style4"><?php echo $row_vendedores['nombre_vendedor']; ?></a></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_vendedores['rfc_vendedor']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_vendedores['persona']; ?></strong></td>    
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_vendedores['domicilio_vendedor']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_vendedores['ciudad_vendedor']; ?></strong></td>
      <td class="style4"><?php echo $row_vendedores['cp_vendedor']; ?></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_vendedores['tel_vendedor']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_vendedores['tel_vendedor_movil']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_vendedores['tel_vendedor_trabajo']; ?></strong></td>        
      
      <td class="style4"><?php echo $row_vendedores['email_vendedor']; ?></td>
      <td class="style4"><?php if($row_vendedores['activo']==1) echo 'Si'; else echo 'No';?></td>
    </tr>
    <?php } while ($row_vendedores = mysqli_fetch_assoc($vendedores)); ?>
</table>
<p><a href="vendedores_edit.php"><strong>Agregar</strong></a></p>
<div align="justify"></div>
</body>
</html>
<?php
mysqli_free_result($vendedores);

?>
