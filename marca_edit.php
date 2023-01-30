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
      require_once('Funciones/funciones.php'); 
?>

<?php

$recordID=$_GET['parametro1'];

// *****Obtiene la cantidad de veces que una marca es utilizada en otras tablas, si es utilizada.
// *****No se puede borrar.

$cantidad_registros=0;
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_cantidad = "SELECT clave_marca FROM tipo_auto where clave_marca='$recordID'";
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
  $insertSQL = sprintf("INSERT INTO marca (marca, comentario) VALUES (%s, %s)",
                       GetSQLValueString($_POST['marca'], "text"),
                       GetSQLValueString($_POST['comentario'], "text"));

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $insertSQL) or die(mysql_error());
  
  $updateGoTo = "marca_list.php";
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
 $updateSQL = sprintf("UPDATE marca SET comentario=%s, marca=%s WHERE clave_marca='$recordID'",
                       GetSQLValueString($_POST['comentario'], "text"),
                       GetSQLValueString($_POST['marca'], "text"));

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysql_error());

  $updateGoTo = "marca_list.php";
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
 
 $updateSQL = sprintf("DELETE from marca WHERE clave_marca='$recordID'");

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysql_error());

  $updateGoTo = "marca_list.php";
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
  $updateGoTo = "marca_list.php";
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
$query_marcas = "SELECT * FROM marca";
$marcas = mysqli_query($contratos_londres, $query_marcas) or die(mysql_error());
$row_marcas = mysqli_fetch_assoc($marcas);
$totalRows_marcas = mysqli_num_rows($marcas);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_marcas2 = "SELECT * FROM marca WHERE clave_marca='$recordID'";
$marcas2 = mysqli_query($contratos_londres, $query_marcas2) or die(mysql_error());
$row_marcas2 = mysqli_fetch_assoc($marcas2);
$totalRows_marcas2 = mysqli_num_rows($marcas2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Marcas</title>


<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {
	font-size: 10;
	font-weight: bold;
}
.style3 {font-size: 10px}
.style8 {
	font-size: 10px;
	font-weight: bold;
	color: #FFFF00;
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

<p align="left" class="style2">Marcas.</p>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <p align="left">&nbsp;</p>
  <div align="left">
    <table border="1" align="left" bordercolor="#000000">
      <tr valign="baseline">
        <td width="65" align="right" nowrap="nowrap" bgcolor="#000033" class="Encabezado_tabla"><span class="style8">Marca</span></td>
        <td width="297" class="style3"><input name="marca" type="text" class="style3" id="marca" value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_marcas2['marca']; }?>" size="52" /></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap="nowrap" bgcolor="#000033" class="Encabezado_tabla"><span class="style6"><span class="style8">Comentari</span></span><span class="style8">os:</span></td>
        <td class="style3"><input name="comentario" type="text" class="style3" value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_marcas2['comentario']; }?>" size="52" /></td>
      </tr>
      <tr valign="baseline">
        <td colspan="2" align="right" nowrap="nowrap" class="Encabezado_tabla"><div align="center">
          <?php //echo $parametro1; ?>
          <?php //echo $recordID; ?>
          <?php //echo '---->' . $cantidad_registros; ?>  
          <span class="Texto_tabla">
            <input name="Grabar" type="submit" class="style3" value="Grabar" <?php if ($recordID > 0 ) {echo "disabled";} else {echo "enabled";}?> />
            <input name="Editar" type="submit" class="style3" value="Editar" <?php if ($recordID > 0 ) {echo "enabled";} else {echo "disabled";}?> />
            <input name="Borrar" type="submit" class="style3" value="Borrar" <?php if ($recordID > 0 ) {if ($cantidad_registros >= 1 ) {echo "disabled";} else {echo "enabled";}} else {echo "disabled";}?> />
            <input name="Cancelar" type="submit" class="style3" id="Cancelar" value="Cancelar" />
            </span>        
        </div></td>
      </tr>
    </table>  
    <input type="hidden" name="MM_insert" value="form1" />
    <input type="hidden" name="MM_update" value="form2" />
    
    
    
  </div>
</form>
<p align="left">&nbsp; </p>
</body>
</html>
<?php
mysqli_free_result($marcas);

mysqli_free_result($marcas2);
?>
