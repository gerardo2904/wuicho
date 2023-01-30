<?php 
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

require_once('Connections/contratos_londres.php');
require_once('Funciones/funciones.php');

$recordID=$_GET['parametro1'];

funciones_reemplazadas();

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_refacciones = 'SELECT * FROM refacciones WHERE clave_contrato='.$recordID;
$refacciones = mysqli_query($contratos_londres, $query_refacciones) or die(mysqli_error($contratos_londres));
$row_refacciones = mysqli_fetch_assoc($refacciones);
$totalRows_refacciones = mysqli_num_rows($refacciones);


if (isset($_POST['no_parte']) && (isset($_POST['descripcion_parte'])) && (isset($_POST['cantidad_parte'])))
{
  $insertSQL = sprintf("INSERT INTO refacciones (clave_contrato, no_parte, descripcion_parte, cantidad_parte) VALUES (%s , %s, %s , %s)",
             GetSQLValueString($recordID, "text"),
             GetSQLValueString($_POST['no_parte'], "text"),
             GetSQLValueString($_POST['descripcion_parte'], "text"),
             GetSQLValueString($_POST['cantidad_parte'], "text"));

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $insertSQL) or die(mysqli_error($contratos_londres));
  
  $updateGoTo = "captura_refacciones.php?parametro1=".$recordID;
  
     Echo "<SCRIPT language=\"JavaScript\">
     <!-- 
    window.location=\"$updateGoTo\";
    //-->
    </SCRIPT>"; 
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Refacciones del contrato <?php echo $recordID; ?></title>
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
<p><strong>Captura de Refacciones.</strong></p>

<form id="form1" name="form1" method="post" action="captura_refacciones.php?parametro1=<?php echo $recordID;?>">
  <table width="660" border="1">
  <tr>
    <td width="183" bgcolor="#000033" class="style6"><div align="center">Número de parte</div></td>
    <td width="176" bgcolor="#000033" class="style6"><div align="center">Descripción</div></td>
    <td width="210" bgcolor="#000033" class="style6"><div align="center">Cantidad</div></td>
    <td width="63" bgcolor="#000033" class="style6"><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="center">
      <input name="no_parte" type="text" class="style4" id="no_parte"/>
    </div></td>
    <td><div align="center">
      <input name="descripcion_parte" type="text" class="style4" id="descripcion_parte" />
    </div></td>
    <td><div align="center">
      <input name="cantidad_parte" type="text" class="style4" id="cantidad_parte" />
    </div></td>
    <td><input type="submit" name="Guardar" id="Procesar" value="Guardar" /></td>
  </tr>
</table>
</form>

<p></p>
<table border="1">
  <tr>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">No. de parte</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Descripción</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Cantidad</span></td>
    <td bgcolor="#000066" class="style1 Encabezado_tabla"><span class="style6">Acción</span></td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="style5 Texto_tabla"><?php echo $row_refacciones['no_parte']; ?></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_refacciones['descripcion_parte']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><?php echo $row_refacciones['cantidad_parte']; ?></strong></td>
      <td class="style5 Texto_tabla"><strong class="style4"><a href="borrar.php?parametro1=REFACCIONES&parametro2=<?php echo $recordID; ?>&parametro3=<?php echo $row_refacciones['id_refaccion']; ?>">Borrar</a></strong></td>
    </tr>
    <?php } while ($row_refacciones = mysqli_fetch_assoc($refacciones)); ?>
</table>
<p><a href="contrato.php?parametro1=<?php echo $recordID; ?>"><strong>Regresar a la orden de Trabajo</strong></a></p>
<div align="justify"></div>
</body>
</html>
<?php
mysqli_free_result($refacciones);

?>
