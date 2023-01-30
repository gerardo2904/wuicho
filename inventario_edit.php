<?php require_once('Connections/contratos_londres.php'); ?>
<?php require_once('Funciones/funciones.php'); ?>
<?php

$conexion = $database_contratos_londres;
$linkbd = $contratos_londres;

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "conectar.php";
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


$recordID=$_GET['parametro1'];

funciones_reemplazadas();

$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ($_POST["Grabar"]) { 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO inventario_auto (clave_auto, especificaciones, km, precio, ano, puertas, color, motor, fotos, clave_empresa, pedimento, repuve, vendido, acambio, serie, proveedor, factura, ffactura, expedida, tenencia, tcirculacion, verificacion, engomados, poliza_seg, pago_multas, pago_recargos, manual_usuario, otros_docs) VALUES (%s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",                      GetSQLValueString($_POST['clave_auto'], "text"),
					   GetSQLValueString($_POST['especificaciones'], "text"),
					   GetSQLValueString($_POST['km'], "text"),
					   GetSQLValueString($_POST['precio'], "text"),
                       GetSQLValueString($_POST['ano'], "text"),
					   GetSQLValueString($_POST['puertas'], "text"),
					   GetSQLValueString($_POST['color'], "text"),
					   GetSQLValueString($_POST['motor'], "text"),
					   GetSQLValueString($_POST['fotos1'], "text"),
					   GetSQLValueString($_POST['clave_empresa'], "text"),
					   GetSQLValueString($_POST['pedimento'], "text"),
                       GetSQLValueString($_POST['repuve'], "text"),
					   GetSQLValueString($_POST['vendido'], "text"),
					   GetSQLValueString($_POST['acambio'], "text"),
					   GetSQLValueString($_POST['serie'], "text"),
					   GetSQLValueString($_POST['proveedor'], "text"),
             GetSQLValueString($_POST['factura'], "text"),
             GetSQLValueString($_POST['ffactura'], "text"),
             GetSQLValueString($_POST['expedida'], "text"),
             GetSQLValueString($_POST['tenencia'], "text"),
             GetSQLValueString($_POST['tcirculacion'], "text"),
             GetSQLValueString($_POST['verificacion'], "text"),
             GetSQLValueString($_POST['engomados'], "text"),
             GetSQLValueString($_POST['poliza_seg'], "text"),
             GetSQLValueString($_POST['pago_multas'], "text"),
             GetSQLValueString($_POST['pago_recargos'], "text"),
             GetSQLValueString($_POST['manual_usuario'], "text"),
             GetSQLValueString($_POST['otros_docs'], "text"));

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $insertSQL) or die(mysql_error());
  
  $updateGoTo = "inventario_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}
//	header(sprintf("Location: %s", $updateGoTo));
		 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";
}
}
else
{
 if ($_POST["Editar"]) {
 $updateSQL = sprintf("UPDATE inventario_auto SET clave_auto=%s, especificaciones=%s, km=%s, precio=%s, ano=%s, puertas=%s, color=%s, motor=%s, clave_empresa=%s, pedimento=%s, repuve=%s, vendido=%s, acambio=%s, serie=%s, proveedor=%s, factura=%s, ffactura=%s, expedida=%s, tenencia=%s, tcirculacion=%s, verificacion=%s, engomados=%s, poliza_seg=%s, pago_multas=%s, pago_recargos=%s, manual_usuario=%s, otros_docs=%s WHERE clave_inv='$recordID'",
                       GetSQLValueString($_POST['clave_auto'], "text"),
					   GetSQLValueString($_POST['especificaciones'], "text"),
					   GetSQLValueString($_POST['km'], "text"),
					   GetSQLValueString($_POST['precio'], "text"),
                       GetSQLValueString($_POST['ano'], "text"),
					   GetSQLValueString($_POST['puertas'], "text"),
					   GetSQLValueString($_POST['color'], "text"),
					   GetSQLValueString($_POST['motor'], "text"),
					   GetSQLValueString($_POST['clave_empresa'], "text"),
					   GetSQLValueString($_POST['pedimento'], "text"),
                       GetSQLValueString($_POST['repuve'], "text"),
					   GetSQLValueString($_POST['vendido'], "text"),
					   GetSQLValueString($_POST['acambio'], "text"),
					   GetSQLValueString($_POST['serie'], "text"),
					   GetSQLValueString($_POST['proveedor'], "text"),
             GetSQLValueString($_POST['factura'], "text"),
             GetSQLValueString($_POST['ffactura'], "text"),
             GetSQLValueString($_POST['expedida'], "text"),
             GetSQLValueString($_POST['tenencia'], "text"),
             GetSQLValueString($_POST['tcirculacion'], "text"),
             GetSQLValueString($_POST['verificacion'], "text"),
             GetSQLValueString($_POST['engomados'], "text"),
             GetSQLValueString($_POST['poliza_seg'], "text"),
             GetSQLValueString($_POST['pago_multas'], "text"),
             GetSQLValueString($_POST['pago_recargos'], "text"),
             GetSQLValueString($_POST['manual_usuario'], "text"),
             GetSQLValueString($_POST['otros_docs'], "text"));

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysql_error());

  $updateGoTo = "inventario_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}
	header(sprintf("Location: %s", $updateGoTo));  
}

 if ($_POST["Borrar"]) {
 $updateSQL = sprintf("DELETE from inventario_auto WHERE clave_inv='$recordID'");
  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysql_error());
  
  $conexion = $database_contratos_londres;
  $linkbd = $contratos_londres;

  if (borra_foto($recordID,$conexion,$linkbd)){
  	echo "Fotos borradas...";
  }


 $updateSQL = sprintf("DELETE from fotos WHERE clave_inv='$recordID'");
  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysql_error());


  $updateGoTo = "inventario_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}
	header(sprintf("Location: %s", $updateGoTo));  
}

///
 if ($_POST["Cancelar"]) {
  $updateGoTo = "inventario_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}
	header(sprintf("Location: %s", $updateGoTo));  
}

///
}


mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_inventario = "SELECT * FROM inventario_auto";
$inventario = mysqli_query($contratos_londres, $query_inventario) or die(mysql_error());
$row_inventario = mysqli_fetch_assoc($inventario);
$totalRows_inventario = mysqli_num_rows($inventario);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_inventario2 = "SELECT * FROM inventario_auto WHERE clave_inv='$recordID'";
$inventario2 = mysqli_query($contratos_londres, $query_inventario2) or die(mysql_error());
$row_inventario2 = mysqli_fetch_assoc($inventario2);
$totalRows_inventario2 = mysqli_num_rows($inventario2);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_sucursal = "select * from empresa order by nombre_empresa";
$sucursal = mysqli_query($contratos_londres, $query_sucursal) or die(mysql_error());
$row_sucursal = mysqli_fetch_assoc($sucursal);
$totalRows_sucursal = mysqli_num_rows($sucursal);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_tipoauto = "SELECT tipo_auto.clave_auto, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca, CONCAT(marca.marca,'->',tipo_auto.modelo,'->',tipo_auto.estilo) as descripcion FROM tipo_auto, marca WHERE tipo_auto.clave_marca=marca.clave_marca GROUP BY tipo_auto.clave_auto ORDER BY marca.marca";
$tipoauto = mysqli_query($contratos_londres, $query_tipoauto) or die(mysql_error());
$row_tipoauto = mysqli_fetch_assoc($tipoauto);
$totalRows_tipoauto = mysqli_num_rows($tipoauto);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inventario de autos</title>

<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {font-size: 10}
.style3 {font-size: 10px}
.style4 {
	color: #FFFF00;
	font-weight: bold;
}
.style7 {font-size: 10; font-weight: bold; }
.style8 {color: #FFFF00; font-weight: bold; font-size: 10px; }
.style9 {color: #FFFF00; font-size: 10px; }
.style10 {
	font-size: 18px
}
-->
</style>
</head>

<body>
<div id='cssmenu'>
  <?php 
  //Inserta el Menu
  require_once('menu.php'); ?>
</div>

<p class="style1 style10"><strong>Inventario de Autos</strong></p>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1"><table border="1" align="left" bordercolor="#000000">
    <tr valign="baseline">
      <td width="65" align="right" nowrap="nowrap" bgcolor="#000033" class="style4"><div align="center" class="style8">Auto</div>
      </td>
      <td width="297" class="Texto_tabla style3 style3"><select name="clave_auto" class="style3" id="clave_auto">
      <?php
        do {  
      ?>
      <option value="<?php echo $row_tipoauto['clave_auto']?>"<?php if (!(strcmp($row_tipoauto['clave_auto'], $row_inventario2['clave_auto']))) {echo "selected=\"selected\"";} ?>><?php echo $row_tipoauto['descripcion']?></option>
      <?php
        } while ($row_tipoauto = mysqli_fetch_assoc($tipoauto));
        $rows = mysqli_num_rows($tipoauto);
        if($rows > 0) {
          mysqli_data_seek($tipoauto, 0);
	       $row_tipoauto = mysqli_fetch_assoc($tipoauto);
        }
      ?>
      </select>
      <input type="hidden" name="hiddenField" id="hiddenField" /></td>

      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4"><div align="center" class="style8">Especificaciones</div>
      </td>
      <td class="Texto_tabla"><input name="especificaciones" type="text" class="style3" id="especificaciones" value="<?php echo $row_inventario2['especificaciones']; ?>" size="52" /></td>
    </tr>
    
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4">
        <div align="right" class="style9">
        <div align="center">Km</div>
        </div>
      </td>
      <td class="Texto_tabla"><input name="km" type="text" class="style3" id="km" value="<?php echo $row_inventario2['km']; ?>" size="52" /></td>

      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4"><div align="right" class="style9">
        <div align="center">Precio</div>
        </div>
      </td>
      <td class="Texto_tabla"><input name="precio" type="text" class="style3" id="precio" value="<?php echo $row_inventario2['precio']; ?>" size="52" />
      </td>
    </tr>


    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4"><div align="right" class="style9">
        <div align="center">Año</div>
      </div></td>
      <td class="Texto_tabla"><input name="ano" type="text" class="style3" id="ano" value="<?php echo $row_inventario2['ano']; ?>" size="52" /></td>
    
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4"><div align="right" class="style9">
        <div align="center">Motor</div>
      </div></td>
      <td class="Texto_tabla"><input name="motor" type="text" class="style3" id="motor" value="<?php echo $row_inventario2['motor']; ?>" size="52" /></td>
    </tr>


    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style9"><div align="center">Color</div></td>
      <td class="Texto_tabla"><input name="color" type="text" class="style3" id="color" value="<?php echo $row_inventario2['color']; ?>" size="52" /></td>

      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4"><div align="right" class="style9">
        <div align="center">Puertas</div>
      </div></td>
      <td class="Texto_tabla"><input name="puertas" type="text" class="style3" id="puertas" value="<?php echo $row_inventario2['puertas']; ?>" size="52" /></td>
    </tr>
    

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4"><div align="right" class="style9">
       <div align="center">Sucursal</div>
      </div></td>
      <td class="Texto_tabla style7 style3 style3"><select name="clave_empresa" class="style3" id="clave_empresa">
        <?php
          do {  
        ?>
        <option value="<?php echo $row_sucursal['clave_empresa']?>"<?php if (!(strcmp($row_sucursal['clave_empresa'], $row_inventario2['clave_empresa']))) {echo "selected=\"selected\"";} ?>><?php echo $row_sucursal['nombre_empresa']?></option>
        <?php
          } while ($row_sucursal = mysqli_fetch_assoc($sucursal));
          $rows = mysqli_num_rows($sucursal);
          if($rows > 0) {
            mysqli_data_seek($sucursal, 0);
	        $row_sucursal = mysqli_fetch_assoc($sucursal);
          }
        ?>
      </select> <input name="fotos1" type="hidden" id="fotos1" value="0" /></td>

      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4 style3"><div align="center">No. Serie</div></td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="serie" type="text" class="style3" id="serie" value="<?php echo $row_inventario2['serie']; ?>" size="52" />
      </span></td>
    </tr>
    
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4 style3">No. Pedimento</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="pedimento" type="text" class="style3" id="pedimento" value="<?php echo $row_inventario2['pedimento']; ?>" size="52" />
      </span></td>

      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4 style3">Constancia REPUVE</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="repuve" type="text" class="style3" id="repuve" value="<?php echo $row_inventario2['repuve']; ?>" size="52" />
      </span></td>
    </tr>
    
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4 style3"><div align="center">Proveedor</div></td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="proveedor" type="text" class="style3" id="proveedor" value="<?php echo $row_inventario2['proveedor']; ?>" size="52" />
      </span></td>

      <td align="right" nowrap="nowrap" bgcolor="#000033" class="Encabezado_tabla style2"><div align="center" class="style4 style3">No. Fotos</div></td>
      <td class="Texto_tabla"><input name="fotos" type="text" class="style3" id="fotos" value="<?php echo $row_inventario2['fotos']; ?>" size="52" readonly="true" /></td>
    </tr>


    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4 style3"><div align="center">¿Vendido?</div></td>
      <td class="Texto_tabla style7 style3 style3"><input name="vendido" type="checkbox" disabled="disabled" class="style3" id="vendido" value="1" <?php if (!(strcmp($row_inventario2['vendido'],1))) {echo "checked=\"checked\"";} ?> /></td>

      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4 style3"><div align="center">¿A cambio?</div></td>
      <td class="Texto_tabla style7 style3 style3"><input name="acambio" type="checkbox" id="acambio" value="1" <?php if (!(strcmp($row_inventario2['acambio'],1))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">No. Factura</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="factura" type="text" class="style3" id="factura" value="<?php echo $row_inventario2['factura']; ?>" size="52" />
      </span></td>

      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">Fecha Factura</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="ffactura" type="text" class="style3" id="ffactura" value="<?php echo $row_inventario2['ffactura']; ?>" size="52" />
      </span></td>
    </tr>
    

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">Expedida por</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="expedida" type="text" class="style3" id="expedida" value="<?php echo $row_inventario2['expedida']; ?>" size="52" />
      </span></td>

      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">Pago de tenencia (años)</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="tenencia" type="text" class="style3" id="tenencia" value="<?php echo $row_inventario2['tenencia']; ?>" size="52" />
      </span></td>
    </tr>

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">Tarjeta de Circulación</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="tcirculacion" type="text" class="style3" id="tcirculacion" value="<?php echo $row_inventario2['tcirculacion']; ?>" size="52" />
      </span></td>

      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">Verificación Vehícular</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="verificacion" type="text" class="style3" id="verificacion" value="<?php echo $row_inventario2['verificacion']; ?>" size="52" />
      </span></td>
    </tr>

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">Engomados</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="engomados" type="text" class="style3" id="engomados" value="<?php echo $row_inventario2['engomados']; ?>" size="52" />
      </span></td>

      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">Poliza de Seguro</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="poliza_seg" type="text" class="style3" id="poliza_seg" value="<?php echo $row_inventario2['poliza_seg']; ?>" size="52" />
      </span></td>
    </tr>

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">Pago de multas</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="pago_multas" type="text" class="style3" id="pago_multas" value="<?php echo $row_inventario2['pago_multas']; ?>" size="52" />
      </span></td>

      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">Pago de Recargos</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="pago_recargos" type="text" class="style3" id="pago_recargos" value="<?php echo $row_inventario2['pago_recargos']; ?>" size="52" />
      </span></td>
    </tr>

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">Manual de Usuario</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="manual_usuario" type="text" class="style3" id="manual_usuario" value="<?php echo $row_inventario2['manual_usuario']; ?>" size="52" />
      </span></td>

      <td align="right" nowrap="nowrap" bgcolor="#003300" class="style4 style3">Otros Documentos</td>
      <td class="Texto_tabla style7 style3 style3"><span class="Texto_tabla">
        <input name="otros_docs" type="text" class="style3" id="otros_docs" value="<?php echo $row_inventario2['otros_docs']; ?>" size="52" />
      </span></td>
    </tr>


    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap" class="Encabezado_tabla style7"><div align="right"></div>        <div align="center"><?php echo $parametro1; ?>
          <?php echo $recordID; ?>
          
          <span class="Texto_tabla">
          <input name="Grabar" type="submit" class="style3" value="Grabar" <?php if ($recordID > 0 ) {echo "disabled";} else {echo "enabled";}?> />
          <input name="Editar" type="submit" class="style3" value="Editar" <?php if ($recordID > 0 ) {echo "enabled";} else {echo "disabled";}?> />
          <input name="Borrar" type="submit" class="style3" value="Borrar" <?php if ($recordID > 0 ) {echo "enabled";} else {echo "disabled";}?> />
          <input name="Cancelar" type="submit" class="style3" id="Cancelar" value="Cancelar" />
          </span>        
        </div></td>
    </tr>
  </table>

  <input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="MM_update" value="form2" />


  
</form>
<p>&nbsp; </p>
</body>
</html>
<?php
mysqli_free_result($inventario);

mysqli_free_result($inventario2);

mysqli_free_result($tipoauto);

mysqli_free_result($sucursal);
?>
