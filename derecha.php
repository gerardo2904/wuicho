<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "principal.html";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:5px;
	top:143px;
	width:163px;
	height:268px;
	z-index:1;
}
#apDiv2 {
	position:absolute;
	left:6px;
	top:7px;
	width:187px;
	height:103px;
	z-index:2;
}
#apDiv3 {
	position:absolute;
	left:12px;
	top:160px;
	width:181px;
	height:30px;
	z-index:3;
}
.style1 {
	font-size: 12px;
	font-weight: bold;
}
-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body>
<div id="apDiv1">
  <p>&nbsp;</p>
  <p>
    <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','192','height','302','src','menus/menu_contratos','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','menus/menu_contratos' ); //end AC code
    </script>
    <noscript>
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="192" height="302">
        <param name="movie" value="menus/menu_contratos.swf" />
        <param name="quality" value="high" />
        <embed src="menus/menu_contratos.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="192" height="302"></embed>
      </object>
    </noscript>
  </p>
  <p class="style1"><a href="<?php echo $logoutAction; ?>" target="principal">Desconectar</a></p>
</div>
<div id="apDiv2"><a href="http://localhost/contratos_londres" target="_parent"><img src="Imagenes/placa.png" width="189" height="134" border="0" /></a></div>
<div id="apDiv3">
  <div align="center"><strong>Seleccione una Opción</strong></div>
</div>
</body>
</html>
