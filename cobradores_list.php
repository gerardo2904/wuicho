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


$variable="clave_cobrador>0";

if (strlen($recordID1) <> 0) 
	$variable .=" AND nombre_cobrador LIKE '%$recordID1%' ";

if (strlen($recordID2) <> 0) 
	$variable .=" AND rfc_cobrador LIKE '%$recordID2%' ";

if (strlen($recordID3) <> 0) 
	$variable .=" AND domicilio_cobrador LIKE '%$recordID3%' ";

if (strlen($recordID4) <> 0) 
	$variable .=" AND ciudad_cobrador LIKE '%$recordID4%' ";

if (strlen($recordID4) <> 0) 
	$variable .=" AND activo LIKE '%$recordID5%' ";
	

funciones_reemplazadas();

mysqli_select_db( $contratos_londres, $database_contratos_londres);
$query_cobradores = 'SELECT clave_cobrador, nombre_cobrador, rfc_cobrador, persona, domicilio_cobrador, ciudad_cobrador, cp_cobrador, tel_cobrador, tel_cobrador_movil, tel_cobrador_trabajo, fax_cobrador, email_cobrador, activo FROM cobradores WHERE '.$variable.' ORDER BY nombre_cobrador ASC';
$cobradores = mysqli_query($contratos_londres, $query_cobradores) or die(mysqli_error($contratos_londres));
$row_cobradores = mysqli_fetch_assoc($cobradores);
$totalRows_cobradores = mysqli_num_rows($cobradores);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cobradores</title>
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
<p><strong>Cobradores.</strong></p>
<form id="form1" name="form1" method="get" action="cobradores_list.php">
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

<p><a href="cobradores_edit.php"><strong>Agregar</strong></a></p>
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
      <td class="Texto_tabla"><a href="cobradores_edit.php?parametro1=<?php echo $row_cobradores['clave_cobrador']; ?>" class="style4"><?php echo $row_cobradores['nombre_cobrador']; ?></a></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_cobradores['rfc_cobrador']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_cobradores['persona']; ?></strong></td>    
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_cobradores['domicilio_cobrador']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_cobradores['ciudad_cobrador']; ?></strong></td>
      <td class="style4"><?php echo $row_cobradores['cp_cobrador']; ?></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_cobradores['tel_cobrador']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_cobradores['tel_cobrador_movil']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_cobradores['tel_cobrador_trabajo']; ?></strong></td>    
      <td class="style4"><?php echo $row_cobradores['fax_cobrador']; ?></td>
      <td class="style4"><?php echo $row_cobradores['email_cobrador']; ?></td>
      <td class="style4"><?php if($row_cobradores['activo']==1) echo 'Si'; else echo 'No';?></td>
    </tr>
    <?php } while ($row_cobradores = mysqli_fetch_assoc($cobradores)); ?>
</table>
<p><a href="cobradores_edit.php"><strong>Agregar</strong></a></p>
<div align="justify"></div>
</body>
</html>
<?php
mysqli_free_result($cobradores);

?>
