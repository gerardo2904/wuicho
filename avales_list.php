<?php 
require_once('Connections/contratos_londres.php');
require_once('Funciones/funciones.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}


$recordID=$_GET['parametro1'];

$recordID1=$_GET['nombre'];
$recordID2=$_GET['rfc'];
$recordID3=$_GET['domicilio'];
$recordID4=$_GET['ciudad'];
$recordID5=$_GET['cliente'];


$variable="avales.clave_cliente=clientes.clave_cliente";

if (strlen($recordID1) <> 0) 
	$variable .=" AND nombre_aval LIKE '%$recordID1%' ";

if (strlen($recordID2) <> 0) 
	$variable .=" AND rfc_aval LIKE '%$recordID2%' ";

if (strlen($recordID3) <> 0) 
	$variable .=" AND domicilio_aval LIKE '%$recordID3%' ";

if (strlen($recordID4) <> 0) 
	$variable .=" AND ciudad_aval LIKE '%$recordID4%' ";

if (strlen($recordID5) <> 0) 
	$variable .=" AND nombre_cliente LIKE '%$recordID5%' ";
	

funciones_reemplazadas();

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_avales = 'SELECT avales.clave_aval, avales.clave_cliente, avales.nombre_aval, avales.rfc_aval, avales.persona, avales.domicilio_aval, avales.ciudad_aval, avales.cp_aval, avales.tel_aval, avales.tel_aval_movil, avales.tel_aval_trabajo, avales.fax_aval, avales.email_aval, clientes.nombre_cliente FROM avales, clientes WHERE '.$variable.' ORDER BY clave_cliente, nombre_aval ASC';
$avales = mysqli_query($contratos_londres, $query_avales) or die(mysqli_error($contratos_londres));
$row_avales = mysqli_fetch_assoc($avales);
$totalRows_avales = mysqli_num_rows($avales);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Avales</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FFFF00}
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
<p><strong>Avales.</strong></p>
<form id="form1" name="form1" method="get" action="avales_list.php">
  <table width="660" border="1">
  <tr>
    <td width="183" bgcolor="#000033" class="style6"><div align="center">Nombre</div></td>
    <td width="176" bgcolor="#000033" class="style6"><div align="center">RFC</div></td>
    <td width="210" bgcolor="#000033" class="style6"><div align="center">Domicilio</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Ciudad</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Cliente</div></td>
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
    <td><input name="cliente" type="text" class="style4" id="cliente" value="<?php echo $_GET['cliente']; ?>" /></td>
    <td><input type="submit" name="Procesar" id="Procesar" value="Filtro" /></td>
  </tr>
</table>
</form>

<table border="1">
  <tr>
    <td width="132" bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Nombre Aval</span></td>
    <td width="108" bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">RFC</span></td>
    <td width="108" bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Persona</span></td>  
    <td width="138" bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Domicilio</span></td>
    <td width="125" bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Ciudad</span></td>
    <td width="105" bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Codigo Postal</span></td>
    <td width="107" bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Telefono</span></td>
    <td width="107" bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Telefono Movil</span></td>
    <td width="107" bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Telefono Trabajo</span></td>
    <td width="109" bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Fax</span></td>
    <td width="120" bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Email</span></td>
    <td width="129" nowrap="nowrap" bgcolor="#000066" class="style6">Nombre Cliente</td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="Texto_tabla"><a href="avales_edit.php?parametro1=<?php echo $row_avales['clave_cliente']; ?>&amp;parametro2=<?php echo $row_avales['clave_aval']; ?>" class="style4"><?php echo $row_avales['nombre_aval']; ?></a></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_avales['rfc_aval']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_avales['persona']; ?></strong></td>    
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_avales['domicilio_aval']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_avales['ciudad_aval']; ?></strong></td>
      <td class="style4"><?php echo $row_avales['cp_aval']; ?></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_avales['tel_aval']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_avales['tel_aval_movil']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_avales['tel_aval_trabajo']; ?></strong></td>
      <td class="style4"><?php echo $row_avales['fax_aval']; ?></td>
      <td class="style4"><?php echo $row_avales['email_aval']; ?></td>
      <td class="style4"><a href="clientes_edit.php?parametro1=<?php echo $row_avales['clave_cliente']; ?>"><?php echo $row_avales['nombre_cliente']; ?></a></td>
    </tr>
    <?php } while ($row_avales = mysqli_fetch_assoc($avales)); ?>
</table>
<p>&nbsp;</p>
<div align="justify"></div>
</body>
</html>
<?php
mysqli_free_result($avales);

?>
