<?php 
require_once('Connections/contratos_londres.php'); 
require_once('Funciones/funciones.php'); 
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "0,1";
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
<?php
$recordID=$_GET['parametro1'];

// *****Obtiene la cantidad de veces que un usuario es utilizado en otras tablas, si es utilizada.
// *****No se puede borrar.
// En las tablas folio_venta, folio_compra.
$cantidad_registros1=0;
$cantidad_registros2=0;

$cantidad_registros=$cantidad_registros1+$cantidad_registros2;

// *************************Fin de la cmparacion busqueda...


funciones_reemplazadas();

$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ($_POST["Grabar"]) { 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

//Verifica si ya se capturo un Login Igual, si es asi, no permite la captura...
//****************************
$colname_verifica = "-1";
if (isset($_POST['login_usuario'])) {
  $colname_verifica = $_POST['login_usuario']; }
else {
  $colname_verifica = $_POST['login_usuario']; 

}
//echo "----------->".$colname_verifica." ---:".GetSQLValueString($colname_verifica, "text");exit;

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_verifica = sprintf("SELECT * FROM usuarios WHERE TRIM(login_usuario) = "."'".trim($colname_verifica)."'");
//echo $query_verifica;exit;
$verifica = mysqli_query($contratos_londres, $query_verifica) or die(mysql_error($contratos_londres));
$row_verifica = mysqli_fetch_assoc($verifica);
$totalRows_verifica = mysqli_num_rows($verifica);
mysqli_free_result($verifica);
//echo "total de elementos encontrados: ".$totalRows_verifica;exit;
//************************
if ($totalRows_verifica > 0)  {
	//echo "El Login que se capturo esta repetido y esto no es posible.  Por favor oprima el boton atras para modificar el Login o para cancelar.";
	echo "<script language='javascript'> alert('El Login que se capturo esta repetido.  Por favor verifica la informacion.'); </script> ";
	//exit;
}
else {
if ($_POST['activo_usuario']<>1) {$_POST['activo_usuario']=0;}

  $insertSQL = sprintf("INSERT INTO usuarios (login_usuario, pass_usuario, nombre_usuario, permisos_usuario, activo_usuario) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString(trim($_POST['login_usuario']), "text"),
					   GetSQLValueString(md5(trim($_POST['pass_usuario'])), "text"),			
					   GetSQLValueString($_POST['nombre_usuario'], "text"),					   		   
					   GetSQLValueString($_POST['permisos_usuario'], "text"),
                       GetSQLValueString($_POST['activo_usuario'], "text"));

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $insertSQL) or die(mysql_error($contratos_londres));
  
  $updateGoTo = "usuarios_list.php";
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
}
else
{
 if ($_POST["Editar"]) {
 
 //Verifica si ya se capturo un Login Igual, si es asi, no permite la captura...
//****************************
$colname_verifica = "-1";
$colname_verifica2= "-1";
if (isset($_POST['login_usuario'])) {
  $colname_verifica = $_POST['login_usuario']; 
}

/*if (isset($_POST['clave_usuario'])) {
  $colname_verifica2 = $_POST['clave_usuario'];
}*/

mysqli_select_db($contratos_londres, $database_contratos_londres);
/*$query_verifica = sprintf("SELECT * FROM usuarios WHERE login_usuario = %s AND clave_usuario<> %s", GetSQLValueString($colname_verifica, "text"),GetSQLValueString($colname_verifica2, "text") ); */
$query_verifica = sprintf("SELECT * FROM usuarios WHERE TRIM(login_usuario) = %s ", GetSQLValueString(trim($colname_verifica), "text"));
$verifica = mysqli_query($contratos_londres, $query_verifica) or die(mysql_error($contratos_londres));
$row_verifica = mysqli_fetch_assoc($verifica);
$totalRows_verifica = mysqli_num_rows($verifica);
mysqli_free_result($verifica);
//************************
if ($totalRows_verifica > 1)  {
//echo "El Usuario que se capturo esta repetido y esto no es posible.  Por favor oprima el boton atras para modificar el Login o para cancelar."." usuario: ".$colname_verifica." clave:".$colname_verifica2;exit;
echo "<script language='javascript'> alert('El Login que se capturo esta repetido.  Por favor verifica la informacion.'); </script> ";
}
else {
//***
 if ($_POST['activo_usuario']<>1) {$_POST['activo_usuario']=0;}
 
// $updateSQL = sprintf("UPDATE usuarios SET login_usuario=%s, pass_usuario=%s, nombre_usuario=%s, permisos_usuario=%s, activo_usuario=%s WHERE clave_usuario='$recordID'",
   $updateSQL = sprintf("UPDATE usuarios SET nombre_usuario=%s, permisos_usuario=%s, activo_usuario=%s WHERE clave_usuario='$recordID'",
					   GetSQLValueString($_POST['nombre_usuario'], "text"),
					   GetSQLValueString($_POST['permisos_usuario'], "text"),
                       GetSQLValueString($_POST['activo_usuario'], "text"));

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysql_error($contratos_londres));

  $updateGoTo = "usuarios_list.php";
 
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


 if ($_POST["Borrar"]) {
 //echo "clave usuario: ".$_POST['clave_usuario'];exit;

 $tempo1='USUARIOS';
 $tempo2=$_POST['clave_usuario'];
 echo "<script language='javascript'> var $tempo1 = 'USUARIOS'; </script> ";
 echo "<script language='javascript'> var $tempo2 = <?php echo '$tempo2'; ?>; </script> ";

	
echo "<script language='javascript'> 
  if(confirm('Realmente deseas borrar al usuario?')) 
{ 
location.href='borrar.php?parametro1='+$tempo1+'&parametro2='+$tempo2; 
} 
</script> ";

/*
  if ($_POST['clave_usuario']<>1) {
  
 $updateSQL = sprintf("DELETE from usuarios WHERE clave_usuario='$recordID'");

  mysql_select_db($database_contratos_londres, $contratos_londres);
  $Result1 = mysql_query($updateSQL, $contratos_londres) or die(mysql_error());

  $updateGoTo = "usuarios_list.php";
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
	else {
		echo "El Login de Admin... no se puede borrar.";
		exit;
	}*/
}

///
 if ($_POST["Cancelar"]) {
  $updateGoTo = "usuarios_list.php";
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
///
 if ($_POST["Cambia"]) {
 	if ($_POST['clave_usuario']==1) {
		echo "<script language='javascript'> alert('El Password de Admin no se puede cambiar.'); </script> ";
	}
	else
	{
		$updateGoTo = "cpass.php?parametro1=".$_POST['clave_usuario'];
			Echo "<SCRIPT language=\"JavaScript\">
			<!--	
			window.location=\"$updateGoTo\";
			//-->
			</SCRIPT>";	
	}
}
}


mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_usuario = "SELECT * FROM usuarios";
$usuario = mysqli_query($contratos_londres, $query_usuario) or die(mysql_error($contratos_londres));
$row_usuario = mysqli_fetch_assoc($usuario);
$totalRows_usuario = mysqli_num_rows($usuario);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_usuario2 = "SELECT * FROM usuarios WHERE clave_usuario='$recordID'";
$usuario2 = mysqli_query($contratos_londres, $query_usuario2) or die(mysql_error($contratos_londres));
$row_usuario2 = mysqli_fetch_assoc($usuario2);
$totalRows_usuario2 = mysqli_num_rows($usuario2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Usuarios</title>

<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' debe contener una direccion de e-mail .\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
    } if (errors) alert('Los Siguientes errores han occurrido:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>
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
.style5 {color: #FFFF00}
.style7 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>

<body>
<div id='cssmenu'>
  <?php 
  //Inserta el Menu
  require_once('menu.php'); ?>
</div>
 <strong>Usuarios </strong>
<p class="style2">.</p>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">

  <div align="left"></div>
  <div align="left"></div>
  <table width="420" border="1" align="left" bordercolor="#000000">
    
    <tr valign="baseline">
      <td width="122" align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="style4">Login  </span></td>
      <td colspan="2" class="Texto_tabla"><input name="login_usuario" type="text" class="style3 " id="login_usuario" tabindex="0" value="<?php if ($parametro1 == 0) { echo '" "'; } else  { echo $row_usuario2['login_usuario']; }?> " <?php if ($recordID > 0 ) {echo "disabled";} else {echo "enabled";}?> size="65" />
        <input name="clave_usuario" type="hidden" id="clave_usuario" value="<?php echo $row_usuario2['clave_usuario']; ?>" /></td>
    </tr>
    
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="style4">Password </span></td>
      <td colspan="2" class="Texto_tabla"><input name="pass_usuario" type="password" class="style3 " value="<?php if ($parametro1 == 0) { echo '" "'; } else  { /*echo $row_usuario2['pass_usuario'];*/ echo '" "'; }?>" <?php if ($recordID > 0 ) {echo "disabled";} else {echo "enabled";}?> size="65" /></td>
    </tr>

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="style4">Nombre de Usuario </span></td>
      <td colspan="2" class="Texto_tabla"><input name="nombre_usuario" type="text" class="style3 " value="<?php if ($parametro1 == 0) { echo $row_usuario2['nombre_usuario']; } else  { echo $row_usuario2['nombre_usuario']; }?>" size="65" /></td>
    </tr>

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="style4">Permisos </span></td>
      <td width="126" class="Texto_tabla"><p class="style7">
        <label>
          <input <?php if (!(strcmp($row_usuario2['permisos_usuario'],"1"))) {echo "checked=\"checked\"";} ?> type="radio" name="permisos_usuario" value="1" id="permisos_usuario_0" />
          Administrador</label>
        <br />
        <label>
          <input <?php if (!(strcmp($row_usuario2['permisos_usuario'],"2"))) {echo "checked=\"checked\"";} ?> type="radio" name="permisos_usuario" value="2" id="permisos_usuario_1" />
          Acceso Sistema</label>
        <br />
        <label>
          <input <?php if (!(strcmp($row_usuario2['permisos_usuario'],"3"))) {echo "checked=\"checked\"";} ?> name="permisos_usuario" type="radio" id="permisos_usuario_2" value="3"  />
          Solo Reportes</label>
        <br />
      </p></td>
      <td width="150" class="Texto_tabla"><div align="center">
        <label>
        <input type="submit" name="Cambia" id="Cambia" value="Cambia Password" <?php if ($recordID > 0 ) {echo 'visible';} else {echo 'hidden';} ?> />
        </label>
      </div></td>
    </tr>

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="style4">¿Activo? </span></td>
      <td colspan="2" class="Texto_tabla"><input name="activo_usuario" type="checkbox" class="style3 " value="1" <?php if (!(strcmp($row_usuario2['activo_usuario'],1))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla style5">&nbsp;</td>
      <td colspan="2" class="Texto_tabla"><div align="center" class="style2">
        <div align="left">
          <?php //echo $parametro1; ?>
          <?php //echo $recordID; ?>
          <?php //echo '---->' . $cantidad_registros; ?>  
          <span class="Texto_tabla">
            <input name="Grabar" type="submit" class="style3" value="Grabar" <?php if ($recordID > 0 ) {echo "disabled";} else {echo "enabled";}?> />
            <input name="Editar" type="submit" class="style3" value="Editar" <?php if ($recordID > 0 ) {echo "enabled";} else {echo "disabled";}?> />
            <input name="Borrar" type="submit" class="style3" value="Borrar" <?php if ($recordID > 0 ) {if ($cantidad_registros >= 1 ) {echo "disabled";} else {echo "enabled";}} else {echo "disabled";}?> />
            <input name="Cancelar" type="submit" class="style3" id="Cancelar" value="Cancelar" />
            </span>          </div>
      </div></td>
    </tr>
  </table>
</div>

<input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="MM_update" value="form2" />


  
</form>
<p>&nbsp; </p>
</body>
</html>
<?php
mysqli_free_result($usuario);

mysqli_free_result($usuario2);
?>
