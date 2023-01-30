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
$recordID5=$_GET['activo'];


$variable="clave_testigo>0";

if (strlen($recordID1) <> 0) 
	$variable .=" AND nombre_testigo LIKE '%$recordID1%' ";

if (strlen($recordID2) <> 0) 
	$variable .=" AND rfc_testigo LIKE '%$recordID2%' ";

if (strlen($recordID3) <> 0) 
	$variable .=" AND domicilio_testigo LIKE '%$recordID3%' ";

if (strlen($recordID4) <> 0) 
	$variable .=" AND ciudad_testigo LIKE '%$recordID4%' ";

if (strlen($recordID4) <> 0) 
	$variable .=" AND activo LIKE '%$recordID5%' ";
	

funciones_reemplazadas();

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_testigos = 'SELECT clave_testigo, nombre_testigo, rfc_testigo, persona, domicilio_testigo, ciudad_testigo, cp_testigo, tel_testigo, tel_testigo_movil, tel_testigo_trabajo, fax_testigo, email_testigo, activo FROM testigos WHERE '.$variable.' ORDER BY nombre_testigo ASC';
$testigos = mysqli_query($contratos_londres, $query_testigos) or die(mysqli_error($contratos_londres));
$row_testigos = mysqli_fetch_assoc($testigos);
$totalRows_testigos = mysqli_num_rows($testigos);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Testigos</title>
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
<p><strong>Testigos.</strong></p>
<form id="form1" name="form1" method="get" action="testigos_list.php">
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

<p><a href="testigos_edit.php"><strong>Agregar</strong></a></p>
<table border="1">
  <tr>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Nombre</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">RFC</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Persona</span></td>    
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Domicilio</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Ciudad</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Codigo Postal</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Telefono</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Teléfono Movil</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Teléfono Trabajo</span></td>  
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Fax</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Email</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">¿Activo?</span></td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="Texto_tabla"><a href="testigos_edit.php?parametro1=<?php echo $row_testigos['clave_testigo']; ?>" class="style4"><?php echo $row_testigos['nombre_testigo']; ?></a></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_testigos['rfc_testigo']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_testigos['persona']; ?></strong></td>    
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_testigos['domicilio_testigo']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_testigos['ciudad_testigo']; ?></strong></td>
      <td class="style4"><?php echo $row_testigos['cp_testigo']; ?></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_testigos['tel_testigo']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_testigos['tel_testigo_movil']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_testigos['tel_testigo_trabajo']; ?></strong></td>        
      <td class="style4"><?php echo $row_testigos['fax_testigo']; ?></td>
      <td class="style4"><?php echo $row_testigos['email_testigo']; ?></td>
      <td class="style4"><?php if($row_testigos['activo']==1) echo 'Si'; else echo 'No';?></td>
    </tr>
    <?php } while ($row_testigos = mysqli_fetch_assoc($testigos)); ?>
</table>
<p><a href="testigos_edit.php"><strong>Agregar</strong></a></p>
<div align="justify"></div>
</body>
</html>
<?php
mysqli_free_result($testigos);

?>
