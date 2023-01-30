<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "0,1,2";
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
<?php require_once('Connections/contratos_londres.php');
      require_once('Funciones/funciones.php'); ?>
<?php


$recordID=$_GET['parametro1'];

// *****Obtiene la cantidad de veces que un tipo de auto es utilizado en otras tablas, si es utilizada.
// *****No se puede borrar.

$cantidad_registros=0;
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_cantidad = "SELECT clave_auto FROM inventario_auto where clave_auto='$recordID'";
$cantidad = mysqli_query($contratos_londres, $query_cantidad) or die(mysql_error());
$row_cantidad = mysqli_fetch_assoc($cantidad);
$totalRows_cantidad = mysqli_num_rows($cantidad);

$cantidad_registros=$totalRows_cantidad;
//echo "----> " . $cantidad;
mysqli_free_result($cantidad);
//echo "----> " . $cantidad;

// *************************Fin de la cmparacion de Marca...




funciones_reemplazadas();

$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ($_POST["Grabar"]) { 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tipo_auto (clave_marca, modelo, estilo, comentarios) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['clave_marca'], "text"),
					   GetSQLValueString($_POST['modelo'], "text"),
					   GetSQLValueString($_POST['estilo'], "text"),
                       GetSQLValueString($_POST['comentarios'], "text"));

mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $insertSQL) or die(mysql_error());
  
  $updateGoTo = "tipo_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}
	//header(sprintf("Location: %s", $updateGoTo));
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
 $updateSQL = sprintf("UPDATE tipo_auto SET clave_marca=%s, modelo=%s, estilo=%s, comentarios=%s WHERE clave_auto='$recordID'",
                       GetSQLValueString($_POST['clave_marca'], "text"),
					   GetSQLValueString($_POST['modelo'], "text"),
					   GetSQLValueString($_POST['estilo'], "text"),
                       GetSQLValueString($_POST['comentarios'], "text"));

mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysql_error());

  $updateGoTo = "tipo_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}
	//header(sprintf("Location: %s", $updateGoTo));  
		 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
}

 if ($_POST["Borrar"]) {
 $updateSQL = sprintf("DELETE from tipo_auto WHERE clave_auto='$recordID'");

mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysql_error());

  $updateGoTo = "tipo_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}
	//header(sprintf("Location: %s", $updateGoTo));  
		 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
}

///
 if ($_POST["Cancelar"]) {
  $updateGoTo = "tipo_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}
	//header(sprintf("Location: %s", $updateGoTo));  
		 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
}

///
}


mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_tipos = "SELECT * FROM tipo_auto";
$tipos = mysqli_query($contratos_londres, $query_tipos) or die(mysql_error());
$row_tipos = mysqli_fetch_assoc($tipos);
$totalRows_tipos = mysqli_num_rows($tipos);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_tipos2 = "SELECT * FROM tipo_auto WHERE clave_auto='$recordID'";
$tipos2 = mysqli_query($contratos_londres, $query_tipos2) or die(mysql_error());
$row_tipos2 = mysqli_fetch_assoc($tipos2);
$totalRows_tipos2 = mysqli_num_rows($tipos2);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_marcas = "SELECT clave_marca, marca FROM marca group by marca ORDER BY marca ASC ";
$marcas = mysqli_query($contratos_londres, $query_marcas) or die(mysql_error());
$row_marcas = mysqli_fetch_assoc($marcas);
$totalRows_marcas = mysqli_num_rows($marcas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tipos de Autos</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 10px;
	font-weight: bold;
	color: #FFFF00;
}
.style2 {font-size: 10px}
.style3 {
	font-size: 16px;
	font-weight: bold;
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

<p class="style3">Alta, Edicion y Baja de Tipos de Autos.</p>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table border="1" align="left" bordercolor="#000000">
    <tr valign="baseline">
      <td width="65" align="right" nowrap="nowrap" bgcolor="#000033" class="Encabezado_tabla"><div align="center" class="style1">Marca</div></td>
      <td width="297" class="style2"><select name="clave_marca" class="style2" id="clave_marca">
        <?php
do {  
?>
        <option value="<?php echo $row_marcas['clave_marca']?>"<?php if (!(strcmp($row_marcas['clave_marca'], $row_tipos2['clave_marca']))) {echo "selected=\"selected\"";} ?>><?php echo $row_marcas['marca']?></option>
        <?php
} while ($row_marcas = mysqli_fetch_assoc($marcas));
  $rows = mysqli_num_rows($marcas);
  if($rows > 0) {
      mysqli_data_seek($marcas, 0);
	  $row_marcas = mysqli_fetch_assoc($marcas);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="Encabezado_tabla"><div align="center" class="style1">Modelo</div></td>
      <td class="style2"><input name="modelo" type="text" class="style2" id="modelo" value="<?php echo $row_tipos2['modelo']; ?>" size="52" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="Encabezado_tabla"><div align="center" class="style1">Estilo</div></td>
      <td class="style2"><select name="estilo" class="style2" id="estilo">
        <option value="automovil" <?php if (!(strcmp("automovil", $row_tipos2['estilo']))) {echo "selected=\"selected\"";} ?>>Automovil</option>
        <option value="pickup" <?php if (!(strcmp("pickup", $row_tipos2['estilo']))) {echo "selected=\"selected\"";} ?>>Pickup</option>
        <option value="todoterreno" <?php if (!(strcmp("todoterreno", $row_tipos2['estilo']))) {echo "selected=\"selected\"";} ?>>Todo terreno</option>
        <option value="minivan" <?php if (!(strcmp("minivan", $row_tipos2['estilo']))) {echo "selected=\"selected\"";} ?>>Mini Van</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="Encabezado_tabla"><div align="center" class="style1">Comentarios</div></td>
      <td class="style2"><input name="comentarios" type="text" class="style2" id="comentarios" value="<?php echo $row_tipos2['comentarios']; ?>" size="52" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap" class="Encabezado_tabla"><div align="center">
        <?php //echo $parametro1; ?>
        <?php //echo $recordID; ?>
        
        <span class="Texto_tabla">
          <input name="Grabar" type="submit" class="style2" value="Grabar" <?php if ($recordID > 0 ) {echo "disabled";} else {echo "enabled";}?> />
          <input name="Editar" type="submit" class="style2" value="Editar" <?php if ($recordID > 0 ) {echo "enabled";} else {echo "disabled";}?> />
          <input name="Borrar" type="submit" class="style2" value="Borrar" <?php if ($recordID > 0 ) {if ($cantidad_registros >= 1 ) {echo "disabled";} else {echo "enabled";}} else {echo "disabled";}?> />
          <input name="Cancelar" type="submit" class="style2" id="Cancelar" value="Cancelar" />
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
mysqli_free_result($tipos);

mysqli_free_result($tipos2);

mysqli_free_result($marcas);
?>
