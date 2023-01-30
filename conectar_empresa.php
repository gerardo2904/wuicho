<?php 
require_once('Connections/contratos_londres.php');
require_once('Funciones/funciones.php');


// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}



funciones_reemplazadas();
    
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['login_usuario'])) {
  $loginUsername=$_POST['login_usuario'];
  $password=$_POST['pass_usuario'];
  $loginStrId=$_POST['clave_usuario'];
  $loginStrId=$_POST['clave_usuario'];  
  $MM_fldUserAuthorization = "permisos_usuario";
  $MM_redirectLoginSuccess = "principal.html";
  $MM_redirectLoginFailed = "conectar_empresa.php";
  $MM_redirecttoReferrer = true;
  mysqli_select_db($contratos_londres, $database_contratos_londres);
  	
  $LoginRS__query=sprintf("SELECT clave_usuario, login_usuario, pass_usuario, permisos_usuario FROM usuarios WHERE trim(login_usuario)=%s AND trim(pass_usuario)=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString(md5($password), "text")); 
   
  $LoginRS = mysqli_query($contratos_londres, $LoginRS__query) or die(mysqli_error($contratos_londres));
  $loginFoundUser = mysqli_num_rows($LoginRS);
  
  if ($loginFoundUser) {
      $row_LoginRS = mysqli_fetch_assoc($LoginRS);
    $loginStrGroup = $row_LoginRS["permisos_usuario"];  
    $loginStrId    = $row_LoginRS["clave_usuario"];  
          
    //$loginStrGroup  = mysql_result($LoginRS,0,'permisos_usuario');
	//$loginStrId     = mysql_result($LoginRS,0,'clave_usuario');	
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	   
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
.style7 {font-size: 10; font-weight: bold; }
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
        <span class="style7">
        <input type="hidden" name="clave_usuario" id="clave_usuario" />
      </span></span></td>
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
