<?php require_once('Connections/londres.php'); ?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=$_POST['pass'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "marca_list.php";
  $MM_redirectLoginFailed = "conectar.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_londres, $londres);
  
  $LoginRS__query=sprintf("SELECT usuario, pass FROM usuarios WHERE usuario=%s AND pass=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $londres) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="file:///D|/AppServ/www/phpMyAdmin/Rutinas/estilos_Rutinas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
@import url("estilos_Rutinas.css");
-->
</style>
</head>

<body>
<p>Autos Londres</p>
<form action="<?php echo $loginFormAction; ?>" method="POST" name="Forma_Usuario" class="Texto_tabla" id="Forma_Usuario">
  <label>
  <table width="200" border="1" align="center">
    <tr>
      <td bgcolor="#000033" class="Encabezado_tabla"><span class="Encabezado_tabla">Login</span></td>
      <td class="Texto_tabla"><span class="Encabezado_tabla">
        <input name="usuario" type="text" class="Texto_tabla" id="usuario" />
      </span></td>
    </tr>
    <tr>
      <td bgcolor="#000033" class="Encabezado_tabla"><span class="Encabezado_tabla">Password</span></td>
      <td class="Texto_tabla"><span class="Encabezado_tabla">
        <input name="pass" type="password" class="Texto_tabla" id="pass" />
      </span></td>
    </tr>
  </table>
  </label>
  <label></label>
  <label></label>
  <div align="center">
    <input name="Submit" type="submit" class="Texto_tabla" value="Entrar" />
  </div>
</form>
<p>&nbsp;</p>
</body>
</html>
