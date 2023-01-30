<?php 
require_once('Connections/contratos_londres.php'); 
require_once('Funciones/funciones.php');

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

$recordID=$_GET['parametro1'];


funciones_reemplazadas();

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_monedas = 'SELECT * FROM monedas ORDER BY moneda ASC';
$monedas = mysqli_query($contratos_londres, $query_monedas) or die(mysqli_error($contratos_londres));
$row_monedas = mysqli_fetch_assoc($monedas);
$totalRows_monedas = mysqli_num_rows($monedas);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Monedas</title>
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
<p><strong>Monedas.</strong></p>
<table border="1">
  <tr>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Moneda</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">¿Activo?</span></td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="Texto_tabla"><a href="monedas_edit.php?parametro1=<?php echo $row_monedas['clave_moneda']; ?>" class="style4"><?php echo $row_monedas['moneda']; ?></a></td>
      <td class="style4"><?php if ($row_monedas['activo']) {echo "Sí";}else {echo "No";}; ?></td>
    </tr>
    <?php } while ($row_monedas = mysqli_fetch_assoc($monedas)); ?>
</table>
<p><a href="monedas_edit.php"><strong>Agregar</strong></a></p>
<div align="justify"></div>
</body>
</html>
<?php
mysqli_free_result($monedas);

?>
