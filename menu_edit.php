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
<?php require_once('Connections/contratos_londres.php'); ?>

<?php

$recordID=$_GET['parametro1'];

// *****Obtiene la cantidad de veces que una opcion de menu es utilizada en otras tablas, si es utilizada.
// *****No se puede borrar.

$cantidad_registros=0;
/*mysql_select_db($database_contratos_londres, $contratos_londres);
$query_cantidad = "SELECT id FROM menu_priv where clave_marca='$recordID'";
$cantidad = mysql_query($query_cantidad, $contratos_londres) or die(mysql_error());
$row_cantidad = mysql_fetch_assoc($cantidad);
$totalRows_cantidad = mysql_num_rows($cantidad);
*/
$totalRows_cantidad=0;

$cantidad_registros=$totalRows_cantidad;
//echo "----> " . $cantidad;
//mysql_free_result($cantidad);
//echo "----> " . $cantidad;

// *************************Fin de la cmparacion de Menu...



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

$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ($_POST["Grabar"]) { 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO menu (opcion, link, id_padre) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['opcion'], "text"),
                       GetSQLValueString($_POST['link'], "text"),
					   GetSQLValueString($_POST['id_padre'], "text"));

  mysql_select_db($database_contratos_londres, $contratos_londres);
  $Result1 = mysql_query($insertSQL, $contratos_londres) or die(mysql_error());
  
  $updateGoTo = "menu_list.php";
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
 $updateSQL = sprintf("UPDATE marca SET opcion=%s, link=%s, id_padre=%s WHERE id='$recordID'",
                       GetSQLValueString($_POST['opcion'], "text"),
                       GetSQLValueString($_POST['link'], "text"),
					   GetSQLValueString($_POST['id_padre'], "text"));

  mysql_select_db($database_contratos_londres, $contratos_londres);
  $Result1 = mysql_query($updateSQL, $contratos_londres) or die(mysql_error());

  $updateGoTo = "menu_list.php";
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
 
 $updateSQL = sprintf("DELETE from menu WHERE id='$recordID'");

  mysql_select_db($database_contratos_londres, $contratos_londres);
  $Result1 = mysql_query($updateSQL, $contratos_londres) or die(mysql_error());

  $updateGoTo = "menu_list.php";
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
  $updateGoTo = "menu_list.php";
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


mysql_select_db($database_contratos_londres, $contratos_londres);
$query_menus = "SELECT * FROM menu";
$menus = mysql_query($query_menus, $contratos_londres) or die(mysql_error());
$row_menus = mysql_fetch_assoc($menus);
$totalRows_menus = mysql_num_rows($menus);

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_menus2 = "SELECT * FROM menu WHERE id='$recordID'";
$menus2 = mysql_query($query_menus2, $contratos_londres) or die(mysql_error());
$row_mmenus2 = mysql_fetch_assoc($menus2);
$totalRows_menus2 = mysql_num_rows($menus2);

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_menus3 = "SELECT * FROM menu WHERE id_padre=0 AND link='#'";
$menus3 = mysql_query($query_menus3, $contratos_londres) or die(mysql_error());
$row_mmenus3 = mysql_fetch_assoc($menus3);
$totalRows_menus3 = mysql_num_rows($menus3);
?>

<?php include("cabecera.html"); ?>

<p align="left" class="style2">Menus.</p>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <p align="left">&nbsp;</p>
  <div align="left">
    <table border="1" align="left" bordercolor="#000000">
      <tr valign="baseline">
        <td width="65" align="right" nowrap="nowrap" bgcolor="#000033" class="Encabezado_tabla"><span class="style8">Opción</span></td>
        <td width="297" class="style3"><input name="opcion" type="text" class="style3" id="opcion" value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_menus2['opcion']; }?>" size="52" /></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap="nowrap" bgcolor="#000033" class="Encabezado_tabla"><span class="style6"><span class="style8">Link</span></span></td>
        <td class="style3"><input name="link" type="text" class="style3" value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_menus2['link']; }?>" size="52" /></td>
	  </tr>
	  <tr>
		<td align="right" nowrap="nowrap" bgcolor="#000033" class="Encabezado_tabla"><span class="style6"><span class="style8">Opción Padre</span></span></td>
		<td colspan="3" class="Texto_tabla"><select name="id_padre" id="id_padre" tabindex="0" <?php if ($recordID > 0 ) {echo "disabled";} else {echo "enabled";}?>>
        <?php
			do {  
		?>
        <option value="<?php echo $row_menus3['id']?>"<?php if (!(strcmp($row_menus3['id'], ($recordID2>0) ? $row_menus2['id'] :$recordID))) {echo "selected=\"selected\"";} ?>><?php echo $row_menus3['opcion']?></option>
        <?php
			} while ($row_menus3 = mysql_fetch_assoc($menus3));
			$rows = mysql_num_rows($menus3);
			if($rows > 0) {
				mysql_data_seek($menus3, 0);
				$row_menus3 = mysql_fetch_assoc($menus3);
			}
		?>    
      </select>
      </td>
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
mysql_free_result($menus);

mysql_free_result($menus2);
?>
