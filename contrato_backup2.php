<?php require_once('Connections/contratos_londres.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2,1";
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

$MM_restrictGoTo = "conectar_empresa.php";
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
?>
<?php
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

$recordID0=$_SESSION['MM_Empresa'];

$recordID=$_GET['parametro1'];

$recordID1=$_GET['contrato'];
$recordID2=$_GET['fecha_contrato'];
$recordID3=$_GET['clave_cliente'];
$recordID4=$_GET['garantia'];
$recordID5=$_GET['fecha_garantia'];
$recordID6=$_GET['clave_inv'];
$recordID7=$_GET['acambio'];
$recordID8=$_GET['clave_inv_acuenta'];

/*echo "contrato: ".$recordID1."<BR>";
echo "fecha contrato: ".$recordID2."<BR>";
echo "clave_cliente: ".$recordID3."<BR>";
echo "garantia: ".$recordID4."<BR>";
echo "clave_inv: ".$recordID6."<BR>";
*/

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_clientes = "SELECT * FROM clientes ORDER BY clave_cliente, nombre_cliente ASC";
$clientes = mysql_query($query_clientes, $contratos_londres) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_autos = "SELECT inventario_auto.*, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca FROM inventario_auto, tipo_auto, marca WHERE inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca AND (inventario_auto.vendido=0 OR inventario_auto.vendido is null) ORDER BY clave_inv, marca ASC";
$autos = mysql_query($query_autos, $contratos_londres) or die(mysql_error());
$row_autos = mysql_fetch_assoc($autos);
$totalRows_autos = mysql_num_rows($autos);

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_autos_acambio = "SELECT inventario_auto.*, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca FROM inventario_auto, tipo_auto, marca WHERE (inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca)  AND (inventario_auto.acambio=1 AND inventario_auto.acambio is not null) ORDER BY clave_inv, marca, modelo, estilo, ano, clave_empresa";
$autos_acambio = mysql_query($query_autos_acambio, $contratos_londres) or die(mysql_error());
$row_autos_acambio = mysql_fetch_assoc($autos_acambio);
$totalRows_autos_acambio = mysql_num_rows($autos_acambio);

$var="";
if ($recordID3<>0) { $var=" where clave_cliente='$recordID3'";} else { $var=" where clave_cliente=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_avales = "select * from avales ".$var." order by nombre_aval ASC";
$avales = mysql_query($query_avales, $contratos_londres) or die(mysql_error());
$row_avales = mysql_fetch_assoc($avales);
$totalRows_avales = mysql_num_rows($avales);

$var="";
if ($recordID3<>0) { $var=" where clave_cliente='$recordID3'";} else { $var=" where clave_cliente=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_referencias = "select * from referencias ".$var." order by nombre_referencia ASC";
$referencias = mysql_query($query_referencias, $contratos_londres) or die(mysql_error());
$row_referencias = mysql_fetch_assoc($referencias);
$totalRows_referencias = mysql_num_rows($referencias);

$var="";
if ($recordID0<>0) { $var=" where clave_empresa='$recordID0'";} else { $var=" where clave_empresa=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_empresa = "select * from empresa".$var;
$empresa = mysql_query($query_empresa, $contratos_londres) or die(mysql_error());
$row_empresa = mysql_fetch_assoc($empresa);
$totalRows_empresa = mysql_num_rows($empresa);

$var="";
if ($recordID6<>0) { $var=" AND clave_inv='$recordID6'";} else { $var=" AND clave_inv=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_autos_datos = "SELECT inventario_auto.*, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca FROM inventario_auto, tipo_auto, marca WHERE inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca AND (inventario_auto.vendido=0 OR inventario_auto.vendido is null)".$var;
$autos_datos = mysql_query($query_autos_datos, $contratos_londres) or die(mysql_error());
$row_autos_datos = mysql_fetch_assoc($autos_datos);
$totalRows_autos_datos = mysql_num_rows($autos_datos);

$var="";
if ($recordID3<>0) { $var=" where clave_cliente='$recordID3'";} else { $var=" where clave_cliente=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_cliente_datos = "select * from clientes".$var;
$cliente_datos = mysql_query($query_cliente_datos, $contratos_londres) or die(mysql_error());
$row_cliente_datos = mysql_fetch_assoc($cliente_datos);
$totalRows_cliente_datos = mysql_num_rows($cliente_datos);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contrato</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#generales {
	position:absolute;
	left:19px;
	top:264px;
	width:922px;
	height:445px;
	z-index:1;
	visibility: visible;
}
#fechagarantia {
	position:absolute;
	left:454px;
	top:332px;
	width:418px;
	height:25px;
	z-index:2;
	visibility: visible;
}
.style1 {font-size: 10px}
.style3 {font-size: 10px; font-weight: bold; }
.style4 {
	font-size: 12px;
	font-weight: bold;
}
.style5 {color: #FFFF00}
-->
</style>
</head>

<body>
<table width="849" border="0">
  <tr>
    <td width="150"><img src="Imagenes/londres_logo4.PNG" width="148" height="69" /></td>
    <td width="687"><p class="style4">
      <?php 
							 $fx="<BR>";
	  						 $em="<BR>";
	  						 if (strlen($row_empresa['fax_empresa'])>0){$fx=", Fax ".$row_empresa['fax_empresa']."<BR>";}
	  						 if (strlen($row_empresa['email_empresa'])>0){$em="email ".$row_empresa['email_empresa']."<BR>";}	
							 echo $row_empresa['nombre_empresa'].", RFC ".$row_empresa['rfc_empresa']."<BR>";
							 echo $row_empresa['domicilio_empresa'].", C.P. ".$row_empresa['cp_empresa']."<BR>";
							 echo $row_empresa['ciudad_empresa']."<BR>";
							 echo "Telefono(s): ".$row_empresa['tel_empresa'].$fx.$em;;
						?>
    </p>    </td>
  </tr>
</table>
<p><strong>Contrato.</strong></p>
<form id="forma_general" name="forma_general" method="get" action="">
  <table width="1000" border="0">
    <tr>
      <td><span class="style3">Contrato:</span>
      <input name="contrato" type="text" class="style1" id="contrato" value="<?php echo $_GET['contrato']; ?>" /></td>
      <td width="300"><span class="style3">Fecha Venta:</span>
        <input name="fecha_contrato" type="text" class="style1" id="fecha_contrato" value="<?php echo $_GET['fecha_contrato']; ?>" /></td>
      <td width="820">&nbsp;</td>
    </tr>
    <tr>
      <td><span class="style3">Cliente:</span>        <select name="clave_cliente" class="style1" id="clave_cliente" onchange="this.form.submit()">
          <option value="0" <?php if (!(strcmp(0, $_GET['clave_cliente']))) {echo "selected=\"selected\"";} ?>>Selecciona cliente</option>
          <?php
do {  
?>
          <option value="<?php echo $row_clientes['clave_cliente']?>"<?php if (!(strcmp($row_clientes['clave_cliente'], $_GET['clave_cliente']))) {echo "selected=\"selected\"";} ?>><?php echo $row_clientes['nombre_cliente']?></option>
          <?php
} while ($row_clientes = mysql_fetch_assoc($clientes));
  $rows = mysql_num_rows($clientes);
  if($rows > 0) {
      mysql_data_seek($clientes, 0);
	  $row_clientes = mysql_fetch_assoc($clientes);
  }
?>
        </select></td>
      <td width="300" class="style3"><?php 
	  $fx="<BR>";
	  $em="<BR>";
	  if (strlen($row_cliente_datos['fax_cliente'])>0){$fx=", Fax ".$row_cliente_datos['fax_cliente']."<BR>";}
	  if (strlen($row_cliente_datos['email_cliente'])>0){$em="email ".$row_cliente_datos['email_cliente']."<BR>";}	  
	  echo $row_cliente_datos['domicilio_cliente']."<BR>"."C.P. ".$row_cliente_datos['cp_cliente'].", ".$row_cliente_datos['ciudad_cliente']."<BR>"."Telefono(s) ".$row_cliente_datos['tel_cliente'].$fx.$em; ?></td>
      <td><table width="817">
        <tr>
          <td width="0" bgcolor="#000033" class="style3"><div align="center" class="style5"><span class="style1">Nombre Aval</span></div></td>
          <td width="60" bgcolor="#000033" class="style3"><div align="center" class="style5"><span class="style1">RFC</span></div></td>
          <td width="200" bgcolor="#000033" class="style3"><div align="center" class="style5"><span class="style1">Domicilio</span></div></td>
          <td width="70" bgcolor="#000033" class="style3"><div align="center" class="style5"><span class="style1">Ciudad</span></div></td>
          <td width="120" bgcolor="#000033" class="style3"><div align="center" class="style5"><span class="style1">Telefono</span></div></td>
          <td width="150" bgcolor="#000033" class="style3"><div align="center" class="style5"><span class="style1">Email</span></div></td>
        </tr>
        <?php do { ?>
        <tr>
          <td><span class="style1"><?php echo $row_avales['nombre_aval']; ?></span></td>
          <td><span class="style1"><?php echo $row_avales['rfc_aval']; ?></span></td>
          <td><span class="style1"><?php echo $row_avales['domicilio_aval']; ?></span></td>
          <td><span class="style1"><?php echo $row_avales['ciudad_aval']; ?></span></td>
          <td><span class="style1"><?php echo $row_avales['tel_aval']; ?></span></td>
          <td><span class="style1"><?php echo $row_avales['email_aval']; ?></span></td>
        </tr>
        <?php } while ($row_avales = mysql_fetch_assoc($avales)); ?>
      </table>
        <table width="817">
          <tr>
            <td width="0" bgcolor="#000033"><div align="center" class="style5"><span class="style3">Nombre Referencia</span></div></td>
            <td width="60" bgcolor="#000033"><div align="center" class="style5"><span class="style3">RFC</span></div></td>
            <td width="200" bgcolor="#000033"><div align="center" class="style5"><span class="style3">Domicilio</span></div></td>
            <td width="70" bgcolor="#000033"><div align="center" class="style5"><span class="style3">Ciudad</span></div></td>
            <td width="120" bgcolor="#000033"><div align="center" class="style5"><span class="style3">Telefono</span></div></td>
            <td width="150" bgcolor="#000033"><div align="center" class="style5"><span class="style3">Email</span></div></td>
          </tr>
          <?php do { ?>
          <tr>
            <td><span class="style1"><?php echo $row_referencias['nombre_referencia']; ?></span></td>
            <td><span class="style1"><?php echo $row_referencias['rfc_referencia']; ?></span></td>
            <td><span class="style1"><?php echo $row_referencias['domicilio_referencia']; ?></span></td>
            <td><span class="style1"><?php echo $row_referencias['ciudad_referencia']; ?></span></td>
            <td><span class="style1"><?php echo $row_referencias['tel_referencia']; ?></span></td>
            <td><span class="style1"><?php echo $row_referencias['email_referencia']; ?></span></td>
          </tr>
          <?php } while ($row_referencias = mysql_fetch_assoc($referencias)); ?>
        </table>
      <p>&nbsp;</p></td>
    </tr>
    <tr>
      <td><span class="style3">¿Garantia?</span>
      <input name="garantia" type="checkbox" class="style1" id="garantia" onclick="JavaScript:document.forma_general.fecha_garantia.disabled = !this.checked" value="1" checked="checked" /></td>
      <td width="300"><span class="style3">Fecha del fin de garantia:</span><span class="odd">
        <input name="fecha_garantia" type="text" class="style1" id="fecha_garantia" />
      </span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="style1"><span class="style3">Auto:</span>        <select name="clave_inv" class="style1" id="clave_inv" onchange="this.form.submit()">
          <option value="0" <?php if (!(strcmp(0, $_GET['clave_inv']))) {echo "selected=\"selected\"";} ?>>Selecciona un auto</option>
          <?php
do {  
?><option value="<?php echo $row_autos['clave_inv']?>"<?php if (!(strcmp($row_autos['clave_inv'], $_GET['clave_inv']))) {echo "selected=\"selected\"";} ?>><?php echo $row_autos['marca']?></option>
          <?php
} while ($row_autos = mysql_fetch_assoc($autos));
  $rows = mysql_num_rows($autos);
  if($rows > 0) {
      mysql_data_seek($autos, 0);
	  $row_autos = mysql_fetch_assoc($autos);
  }
?>
        </select></td>
      <td width="300" class="style3"><?php 
	  						echo $row_autos_datos['marca']." ".$row_autos_datos['marca']." ".$row_autos_datos['ano']."<BR>";
							echo "Motor: ".$row_autos_datos['motor'].", ".$row_autos_datos['puertas']." puertas.<BR>";
							echo "Millas: ".$row_autos_datos['km']."<BR>";
							echo "No. Serie: ".$row_autos_datos['serie'].", Pedimento: ".$row_autos_datos['pedimento']."<BR>";
							echo "Especificaciones del auto: ".$row_autos_datos['especificaciones'];
	   					 ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="style3">¿Se entrego vehiculo a cambio?
      <input name="acambio" type="checkbox" id="acambio" onclick="JavaScript:document.forma_general.clave_inv_acuenta.disabled = !this.checked" value="1" /></td>
      <td width="300">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span class="style3">Vehiculo a cambio:
        </span>        <select name="clave_inv_acuenta" disabled="disabled" class="style1" id="clave_inv_acuenta">
          <option value="0" <?php if (!(strcmp(0, $row_autos_acambio['clave_inv']))) {echo "selected=\"selected\"";} ?>>Selecciona un auto</option>
          <?php
do {  
?>
          <option value="<?php echo $row_autos_acambio['clave_inv']?>"<?php if (!(strcmp($row_autos_acambio['clave_inv'], $row_autos_acambio['clave_inv']))) {echo "selected=\"selected\"";} ?>><?php echo $row_autos_acambio['marca']?></option>
          <?php
} while ($row_autos_acambio = mysql_fetch_assoc($autos_acambio));
  $rows = mysql_num_rows($autos_acambio);
  if($rows > 0) {
      mysql_data_seek($autos_acambio, 0);
	  $row_autos_acambio = mysql_fetch_assoc($autos_acambio);
  }
?>
        </select></td>
      <td width="300">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p>&nbsp; </p>

<p>&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($clientes);

mysql_free_result($autos);

mysql_free_result($autos_acambio);

mysql_free_result($avales);

mysql_free_result($referencias);

mysql_free_result($empresa);

mysql_free_result($autos_datos);

mysql_free_result($cliente_datos);
?>
