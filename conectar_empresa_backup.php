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

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_empresa = "SELECT * FROM empresa ORDER BY nombre_empresa ASC";
$empresa = mysql_query($query_empresa, $contratos_londres) or die(mysql_error());
$row_empresa = mysql_fetch_assoc($empresa);
$totalRows_empresa = mysql_num_rows($empresa);
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
  $password=$_POST['pass_usuario'];
  $empresa=$_POST['clave_empresa'];
  $loginStrId=$_POST['clave_usuario'];
  $MM_fldUserAuthorization = "permisos_usuario";
  $MM_redirectLoginSuccess = "principal.html";
  $MM_redirectLoginFailed = "conectar_empresa.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_contratos_londres, $contratos_londres);
  	
  $LoginRS__query=sprintf("SELECT clave_usuario, login_usuario, pass_usuario, permisos_usuario FROM usuarios WHERE login_usuario=%s AND pass_usuario=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString(md5($password), "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $contratos_londres) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'permisos_usuario');
	$loginStrId     = mysql_result($LoginRS,0,'clave_usuario');
    
    //declare 3 session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	  
	$_SESSION['MM_Empresa'] = $empresa;	 
	$_SESSION['MM_UserId'] = $loginStrId;	     

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
<link href="file:///D|/AppServ/www/recicladora/cuscosky.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FFFF00}
.style3 {font-size: 10}
.style4 {font-size: 10px}
.style5 {
	color: #FFFF00;
	font-size: 10px;
	font-weight: bold;
}
.style7 {font-size: 10; font-weight: bold; }
-->
</style>
</head>

<body>
<p>&nbsp;</p>
<form action="<?php echo $loginFormAction; ?>" method="POST" name="Forma_Usuario" class="Texto_tabla" id="Forma_Usuario">
  <label>
  <table width="200" border="1" align="center">
    <tr>
      <td bgcolor="#000033" class="style1"><span class="Encabezado_tabla style1 style4"><strong>Login</strong></span></td>
      <td><span class="Encabezado_tabla style3"><strong>
        <input name="login_usuario" type="text" class="style4" id="login_usuario" />
      </strong></span></td>
    </tr>
    <tr>
      <td bgcolor="#000033" class="style1"><span class="Encabezado_tabla style1 style4"><strong>Password</strong></span></td>
      <td><span class="Encabezado_tabla style3"><strong>
        <input name="pass_usuario" type="password" class="style4" id="pass_usuario" />
      </strong></span></td>
    </tr>
    <tr>
      <td bgcolor="#000033" class="style1"><span class="style5">Empresa</span></td>
      <td><span class="style7">
        <select name="clave_empresa" class="style4" id="clave_empresa">
          <?php
do {  
?>
          <option value="<?php echo $row_empresa['clave_empresa']?>"><?php echo $row_empresa['nombre_empresa']?></option>
          <?php
} while ($row_empresa = mysql_fetch_assoc($empresa));
  $rows = mysql_num_rows($empresa);
  if($rows > 0) {
      mysql_data_seek($empresa, 0);
	  $row_empresa = mysql_fetch_assoc($empresa);
  }
?>
          </select>
        <input type="hidden" name="clave_usuario" id="clave_usuario" />
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
<?php
mysql_free_result($empresa);
?>
