<?php require_once('Connections/contratos_londres.php'); ?>
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

if (isset($_POST['login_usuario'])) {
  $loginUsername=$_POST['login_usuario'];
  $password=md5($_POST['pass_usuario']);
  $MM_fldUserAuthorization = "permisos_usuario";
  $MM_redirectLoginSuccess = "principal.html";
  $MM_redirectLoginFailed = "conectar.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_contratos_londres, $contratos_londres);
  
 	
  $LoginRS__query=sprintf("SELECT login_usuario, pass_usuario, permisos_usuario FROM usuarios WHERE login_usuario=%s AND pass_usuario=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $contratos_londres) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
//    echo "si se encontro...";
    $loginStrGroup  = mysql_result($LoginRS,0,'permisos_usuario');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
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
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FFFF00;
	font-size: 10px;
}
.style3 {
	color: #FFFF00;
	font-size: 10px;
	font-weight: bold;
}
.style4 {font-size: 10px}
-->
</style>
</head>

<body>
<p>&nbsp;</p>
<form action="<?php echo $loginFormAction; ?>" method="POST" name="Forma_Usuario" class="Texto_tabla" id="Forma_Usuario">
  <label>
  <table width="217" border="1" align="center">
    <tr>
      <td width="51" bgcolor="#000033"><span class="style3">Login</span></td>
      <td width="150" class="style4"><span class="style4 Encabezado_tabla"><strong>
        <input name="login_usuario" type="text" class="style4" id="login_usuario" />
      </strong></span></td>
    </tr>
    <tr>
      <td bgcolor="#000033"><span class="Encabezado_tabla style1"><strong>Password</strong></span></td>
      <td><span class="Encabezado_tabla style4">
        <input name="pass_usuario" type="password" class="style4" id="pass_usuario" />
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
