<?php 
require_once('Connections/contratos_londres.php');
require_once('Funciones/funciones.php');

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

$recordID=$_GET['parametro1'];

//$recordID1=$_GET['contrato'];
$recordID2=$_GET['nombre'];
$recordID3=$_GET['domicilio'];
$recordID4=$_GET['ciudad'];


$variable="clave_combo_pagare>0 AND combo_pagare.clave_cliente=clientes.clave_cliente ";

/*
if (strlen($recordID1) <> 0) 
	$variable .=" AND contrato LIKE '%$recordID1%' ";
*/
if (strlen($recordID2) <> 0) 
	$variable .=" AND nombre_cliente LIKE '%$recordID2%' ";

if (strlen($recordID3) <> 0) 
	$variable .=" AND domicilio_cliente LIKE '%$recordID3%' ";

if (strlen($recordID4) <> 0) 
	$variable .=" AND ciudad_cliente LIKE '%$recordID4%' ";

	

funciones_reemplazadas();

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_clientes = 'SELECT clientes.clave_cliente, clientes.nombre_cliente, clientes.domicilio_cliente, clientes.ciudad_cliente, combo_pagare.clave_combo_pagare, combo_pagare.hora, combo_pagare.fecha_pagare, combo_pagare.clave_empresa FROM clientes, combo_pagare WHERE '.$variable.' ORDER BY fecha_pagare ASC';
$clientes = mysqli_query($contratos_londres, $query_clientes) or die(mysqli_error($contratos_londres));
$row_clientes = mysqli_fetch_assoc($clientes);
$totalRows_clientes = mysqli_num_rows($clientes);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista de Contratos</title>
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
<p><strong>Pagares (No ligados a contratos).</strong></p>
<form id="form1" name="form1" method="get" action="clientes_list.php">
  <table width="660" border="1">
  <tr>
    <td width="183" bgcolor="#000033" class="style6"><div align="center">Contrato</div></td>
    <td width="176" bgcolor="#000033" class="style6"><div align="center">Cliente</div></td>
    <td width="210" bgcolor="#000033" class="style6"><div align="center">Domicilio</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center">Ciudad</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="center">
      <input name="Contrato" type="text" class="style4" id="Contrato" value="<?php echo $_GET['contrato']; ?>" />
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
    <td><input type="submit" name="Procesar" id="Procesar" value="Filtro" /></td>
  </tr>
</table>
</form>

<p><a href="pagares_independientes.php"><strong>Agregar</strong></a></p>
<table border="1">
  <tr>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Contrato</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Cliente</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Domicilio</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Ciudad</span></td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="Texto_tabla"><a href="pagares_independientes.php?parametro1=<?php echo $row_clientes['clave_combo_pagare']; ?>&parametro2=<?php echo $row_clientes['clave_empresa']; ?>&parametro3=<?php echo $row_clientes['clave_cliente']; ?>" class="style4"><?php echo $row_clientes['fecha_pagare']; ?></a></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_clientes['nombre_cliente']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_clientes['domicilio_cliente']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_clientes['ciudad_cliente']; ?></strong></td>
    </tr>
    <?php } while ($row_clientes = mysqli_fetch_assoc($clientes)); ?>
</table>
<p><a href="pagares_independientes.php"><strong>Agregar</strong></a></p>
<div align="justify"></div>
</body>
</html>
<?php
mysqli_free_result($clientes);

?>
