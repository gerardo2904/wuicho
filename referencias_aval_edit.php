<?php 
require_once('Connections/contratos_londres.php'); 
require_once('Funciones/funciones.php');

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
<?php
$recordID=$_GET['parametro1'];
$recordID2=$_GET['parametro2'];
//echo "recordid=".$recordID;exit;

// *****Obtiene la cantidad de veces que un proveedor es utilizada en otras tablas, si es utilizada.
// *****No se puede borrar.
// En las Proveedor
$cantidad_registros1=0;
//$cantidad_registros2=0;
//$cantidad_registros3=0;

// habilitar cuando este el sistema, obviamente, modificar las condiciones actuales...
/*
// Verifica en tabla folio_compra
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_cantidad = "SELECT clave_proveedor FROM folio_compra where clave_proveedor='$recordID'";
$cantidad = mysqli_query($query_cantidad, $contratos_londres) or die(mysqli_error($contratos_londres));
$row_cantidad = mysqli_fetch_assoc($cantidad);
$totalRows_cantidad = mysqli_num_rows($cantidad);

$cantidad_registros1=$totalRows_cantidad;

mysqli_free_result($cantidad);
*/
// Verifica en tabla folio_venta
//mysqli_select_db($contratos_londres, $database_contratos_londres);
//$query_cantidad = "SELECT clave_proveedor FROM folio_venta where clave_proveedor='$recordID'";
//$cantidad = mysqli_query($query_cantidad, $contratos_londres) or die(mysqli_error($contratos_londres));
//$row_cantidad = mysqli_fetch_assoc($cantidad);
//$totalRows_cantidad = mysqli_num_rows($cantidad);

//$cantidad_registros2=$totalRows_cantidad;
//mysqli_free_result($cantidad);

// Verifica en tabla folio_compra
//mysqli_select_db($contratos_londres, $database_contratos_londres);
//$query_cantidad = "SELECT clave_proveedor FROM folio_compra where clave_proveedor='$recordID'";
//$cantidad = mysqli_query($query_cantidad, $contratos_londres) or die(mysqli_error($contratos_londres));
//$row_cantidad = mysqli_fetch_assoc($cantidad);
//$totalRows_cantidad = mysqli_num_rows($cantidad);

//$cantidad_registros3=$totalRows_cantidad;
//mysqli_free_result($cantidad);

$cantidad_registros=$cantidad_registros1;
//$cantidad_registros=$cantidad_registros1+$cantidad_registros2+$cantidad_registros3;
//echo "----> " . $cantidad;
//echo "----> " . $cantidad;

// *************************Fin de la cmparacion busqueda...


funciones_reemplazadas();

$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ($_POST["Grabar"]) { 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

//Verifica si ya se capturo un RFC Igual, si es asi, no permite la captura...
//****************************
$colname_verifica = "-1";
if (isset($_POST['rfc_referencia'])) {
  $colname_verifica = $_POST['rfc_referencia'];
  //echo "----------->".$colname_verifica;
}
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_verifica = sprintf("SELECT * FROM referencias_aval WHERE rfc_referencia = %s", GetSQLValueString($colname_verifica, "text"));
$verifica = mysqli_query($contratos_londres, $query_verifica) or die(mysqli_error($contratos_londres));
$row_verifica = mysqli_fetch_assoc($verifica);
$totalRows_verifica = mysqli_num_rows($verifica);
mysqli_free_result($verifica);

if (isset($_POST['nombre_referencia'])) {
  $colname_verifica = $_POST['nombre_referencia'];
  //echo "----------->".$colname_verifica;
}
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_verifica2 = sprintf("SELECT * FROM referencias_aval WHERE nombre_referencia = %s", GetSQLValueString($colname_verifica, "text"));
$verifica2 = mysqli_query($contratos_londres, $query_verifica2) or die(mysqli_error($contratos_londres));
$row_verifica2 = mysqli_fetch_assoc($verifica2);
$totalRows_verifica2 = mysqli_num_rows($verifica2);
mysqli_free_result($verifica2);
//************************
if ($totalRows_verifica > 0 || $totalRows_verifica2 > 0)  {echo "El RFC o el Nombre del Referente que se capturo esta repetido y esto no es posible.  Por favor oprima el boton atras para modificar el Nombre o RFC,  o para cancelar.";exit;}
else {
//if ($_POST['activo_proveedor']<>1) {$_POST['activo_proveedor']=0;}

  $insertSQL = sprintf("INSERT INTO referencias_aval (nombre_referencia, clave_aval, rfc_referencia, persona, domicilio_referencia, ciudad_referencia, cp_referencia, tel_referencia, tel_referencia_aval_movil, tel_referencia_aval_trabajo, fax_referencia, email_referencia) VALUES (%s , %s, %s, %s , %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre_referencia'], "text"),
//                       GetSQLValueString($_POST['clave_cliente'], "text"),					   
                       GetSQLValueString($recordID, "text"),					   
					   GetSQLValueString($_POST['rfc_referencia'], "text"),
                       GetSQLValueString($_POST['persona'], "text"),
					   GetSQLValueString($_POST['domicilio_referencia'], "text"),
					   GetSQLValueString($_POST['ciudad_referencia'], "text"),
					   GetSQLValueString($_POST['cp_referencia'], "text"),
					   GetSQLValueString($_POST['tel_referencia'], "text"),
                       GetSQLValueString($_POST['tel_referencia_aval_movil'], "text"),
                       GetSQLValueString($_POST['tel_referencia_aval_trabajo'], "text"),
					   GetSQLValueString($_POST['fax_referencia'], "text"),
					   GetSQLValueString($_POST['email_referencia'], "text"));

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $insertSQL) or die(mysqli_error($contratos_londres));
  
  /// Identificar la clave del cliente y asignarlo como parametro...
	$p1="";
	$p2="";
	mysqli_select_db($contratos_londres, $database_contratos_londres);
	$query_iden = "select * from avales WHERE clave_aval=".$recordID;
	//echo $query_iden;
	$iden = mysqli_query($contratos_londres, $query_iden) or die(mysqli_error($contratos_londres));
	$row_iden = mysqli_fetch_assoc($iden);
	$totalRows_iden = mysqli_num_rows($iden);
	$p1=$row_iden['clave_cliente'];
	$p2=$recordID;
	mysqli_free_result($iden);
	
  //$updateGoTo = "avales_edit.php";
  $updateGoTo = "avales_edit.php?parametro1=$p1&amp;parametro2=$p2";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}*/
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
//Verifica si ya se capturo un RFC Igual, si es asi, no permite la captura...
//****************************
$colname_verifica = "-1";
$colname_verifica2= "-1";

if (isset($_POST['rfc_referencia'])) {
  $colname_verifica = $_POST['rfc_referencia'];
}

if (isset($_POST['clave_referencia'])) {
  $colname_verifica2 = $_POST['clave_referencia'];
}

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_verifica = sprintf("SELECT * FROM referencias_aval WHERE rfc_referencia = %s AND clave_referencia<> %s", GetSQLValueString($colname_verifica, "text"),GetSQLValueString($colname_verifica2, "text") );
$verifica = mysqli_query($contratos_londres, $query_verifica) or die(mysqli_error($contratos_londres));
$row_verifica = mysqli_fetch_assoc($verifica);
$totalRows_verifica = mysqli_num_rows($verifica);
mysqli_free_result($verifica);

if (isset($_POST['nombre_referencia'])) {
  $colname_verifica = $_POST['nombre_referencia'];
}

if (isset($_POST['clave_referencia'])) {
  $colname_verifica2 = $_POST['clave_referencia'];
}
//echo "nombre del aval: ".$colname_verifica. "<BR>";
//echo "clave  del aval: ".$colname_verifica2."<BR>";
//exit;

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_verifica2 = sprintf("SELECT * FROM referencias_aval WHERE nombre_referencia = %s AND clave_referencia<> %s", GetSQLValueString($colname_verifica, "text"),GetSQLValueString($colname_verifica2, "text") );
$verifica2 = mysqli_query($contratos_londres, $query_verifica2) or die(mysqli_error($contratos_londres));
$row_verifica2 = mysqli_fetch_assoc($verifica2);
$totalRows_verifica2 = mysqli_num_rows($verifica2);
mysqli_free_result($verifica2);


//************************
if (($totalRows_verifica > 0 || $totalRows_verifica2 > 0) && $row_verifica['clave_referencia']<>$_POST['clave_referencia'])  {echo "El RFC o el Nombre del Referente que se capturo esta repetido y esto no es posible.  Por favor oprima el boton atras para modificar el RFC o para cancelar.";exit;}
else {
// if ($_POST['activo_proveedor']<>1) {$_POST['activo_proveedor']=0;}
 
 $updateSQL = sprintf("UPDATE referencias_aval SET nombre_referencia=%s, rfc_referencia=%s, persona=%s, domicilio_referencia=%s, ciudad_referencia=%s, cp_referencia=%s, tel_referencia=%s, tel_referencia_aval_movil=%s, tel_referencia_aval_trabajo=%s, fax_referencia=%s, email_referencia=%s WHERE clave_referencia='$recordID2' AND clave_aval='$recordID'",
                       GetSQLValueString($_POST['nombre_referencia'], "text"),
                       GetSQLValueString($_POST['rfc_referencia'], "text"),
                       GetSQLValueString($_POST['persona'], "text"),
					   GetSQLValueString($_POST['domicilio_referencia'], "text"),
					   GetSQLValueString($_POST['ciudad_referencia'], "text"),
					   GetSQLValueString($_POST['cp_referencia'], "text"),
					   GetSQLValueString($_POST['tel_referencia'], "text"),
                       GetSQLValueString($_POST['tel_referencia_aval_movil'], "text"),
                       GetSQLValueString($_POST['tel_referencia_aval_trabajo'], "text"),
					   GetSQLValueString($_POST['fax_referencia'], "text"),
					   GetSQLValueString($_POST['email_referencia'], "text"));

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));

  /// Identificar la clave del cliente y asignarlo como parametro...
	$p1="";
	$p2="";
	mysqli_select_db($contratos_londres, $database_contratos_londres);
	$query_iden = "select * from avales WHERE clave_aval=".$recordID;
	//echo $query_iden;
	$iden = mysqli_query($contratos_londres, $query_iden) or die(mysqli_error($contratos_londres));
	$row_iden = mysqli_fetch_assoc($iden);
	$totalRows_iden = mysqli_num_rows($iden);
	$p1=$row_iden['clave_cliente'];
	$p2=$recordID;
	mysqli_free_result($iden);
  
  $updateGoTo = "avales_edit.php?parametro1=$p1&amp;parametro2=$p2";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}*/
//	header(sprintf("Location: %s", $updateGoTo));
		 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";
}
}

 if ($_POST["Borrar"]) {
 
 $updateSQL = sprintf("DELETE from referencias_aval WHERE clave_referencia='$recordID2'");

  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
  
  /// Identificar la clave del cliente y asignarlo como parametro...
	$p1="";
	$p2="";
	mysqli_select_db($contratos_londres, $database_contratos_londres);
	$query_iden = "select * from avales WHERE clave_aval=".$recordID;
	//echo $query_iden;
	$iden = mysqli_query($contratos_londres, $query_iden) or die(mysqli_error($contratos_londres));
	$row_iden = mysqli_fetch_assoc($iden);
	$totalRows_iden = mysqli_num_rows($iden);
	$p1=$row_iden['clave_cliente'];
	$p2=$recordID;
	mysqli_free_result($iden);
  
  $updateGoTo = "avales_edit.php?parametro1=$p1&amp;parametro2=$p2";
  

  /*
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}*/
	//header(sprintf("Location: %s", $updateGoTo));  
	 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";
}

///
 if ($_POST["Cancelar"]) {
	 /// Identificar la clave del cliente y asignarlo como parametro...
	$p1="";
	$p2="";
	mysqli_select_db($contratos_londres, $database_contratos_londres);
	$query_iden = "select * from avales WHERE clave_aval=".$recordID;
	//echo $query_iden;
	$iden = mysqli_query($contratos_londres, $query_iden) or die(mysqli_error($contratos_londres));
	$row_iden = mysqli_fetch_assoc($iden);
	$totalRows_iden = mysqli_num_rows($iden);
	$p1=$row_iden['clave_cliente'];
	$p2=$recordID;
	mysqli_free_result($iden);
  
  $updateGoTo = "avales_edit.php?parametro1=$p1&amp;parametro2=$p2";
/*
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}*/
//	header(sprintf("Location: %s", $updateGoTo));
		 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";
}
///
}


mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_referencia = "SELECT * FROM referencias_aval";
$referencia = mysqli_query($contratos_londres, $query_referencia) or die(mysqli_error($contratos_londres));
$row_referencia = mysqli_fetch_assoc($referencia);
$totalRows_referencia = mysqli_num_rows($referencia);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_referencia2 = "SELECT * FROM referencias_aval WHERE clave_referencia='$recordID2' AND clave_aval='$recordID'";
$referencia2 = mysqli_query($contratos_londres, $query_referencia2) or die(mysqli_error($contratos_londres));
$row_referencia2 = mysqli_fetch_assoc($referencia2);
$totalRows_referencia2 = mysqli_num_rows($referencia2);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_cliente_combo = "select * from avales order by nombre_aval ASC";
$cliente_combo = mysqli_query($contratos_londres, $query_cliente_combo) or die(mysqli_error($contratos_londres));
$row_cliente_combo = mysqli_fetch_assoc($cliente_combo);
$totalRows_cliente_combo = mysqli_num_rows($cliente_combo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Referencias de Avales</title>

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
-->
</style>
</head>

<body>
<div id='cssmenu'>
  <?php 
  //Inserta el Menu
  require_once('menu.php'); ?>
</div>
<p class="style2"><strong>Referencias de Avales.</strong></p>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" onsubmit="MM_validateForm('nombre_proveedor','','R','rfc_proveedor','','R','domicilio_proveedor','','R','ciudad_proveedor','','R','cp_proveedor','','R');return document.MM_returnValue">
  <div id="Bienvenida_text" onfocus="MM_validateForm('nombre_proveedor','','R','rfc_proveedor','','R','domicilio_proveedor','','R','ciudad_proveedor','','R','cp_proveedor','','R');return document.MM_returnValue">
  <table width="628" border="1" align="left" bordercolor="#000000">
    
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style4 style3">Nombre del Aval</td>
      <td colspan="3" class="Texto_tabla"><select name="clave_cliente" id="clave_cliente" tabindex="0" <?php if ($recordID > 0 ) {echo "disabled";} else {echo "enabled";}?>>
        <?php
do {  
?>
        <option value="<?php echo $row_cliente_combo['clave_aval']?>"<?php if (!(strcmp($row_cliente_combo['clave_aval'], ($recordID2>0) ? $row_referencia2['clave_aval'] :$recordID))) {echo "selected=\"selected\"";} ?>><?php echo $row_cliente_combo['nombre_aval']?></option>
        <?php
} while ($row_cliente_combo = mysqli_fetch_assoc($cliente_combo));
  $rows = mysqli_num_rows($cliente_combo);
  if($rows > 0) {
      mysqli_data_seek($cliente_combo, 0);
	  $row_cliente_combo = mysqli_fetch_assoc($cliente_combo);
  }
?>    
      </select>
        <?php echo "Aval: ".$recordID." Referencia: ".$recordID2; ?></td>
      </tr>
    <tr valign="baseline">
      <td width="105" align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="style4">Nombre del Referente</span></td>
      <td width="267" class="Texto_tabla"><input name="nombre_referencia" type="text" class="style3 " id="nombre_referencia" tabindex="0" value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_referencia2['nombre_referencia']; }?>" size="65" />
        <input name="clave_referencia" type="hidden" id="clave_referencia" value="<?php echo $row_referencia2['clave_referencia']; ?>" /></td>
      <td width="114" bgcolor="#000033" class="Texto_tabla"><div align="center"><span class="style3 Encabezado_tabla"><span class="style4">RFC</span></span></div></td>
      <td width="114" class="Texto_tabla"><input name="rfc_referencia" type="text" class="style3 " value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_referencia2['rfc_referencia']; }?>" size="65" /></td>
    </tr>
      
      <tr valign="baseline">
            <!-- Salta una columna  -->
          <td width="105" align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="style4"></span></td>
          <td width="267" class="Texto_tabla"></td>
          
      
          
          
      <td width="114" bgcolor="#000033" class="Texto_tabla"><div align="center"><span class="style3 Encabezado_tabla"><span class="style4">Persona</span></span></div></td>
      <td  class="Texto_tabla">
        <!--  <input name="persona" type="text" class="style3 " value="<?php //if ($parametro1 = 0) { echo '" "'; } else  { echo $row_cliente2['persona']; }?>" size="65" />  -->
            <input name="persona" type="radio" id="Fisica" tabindex="6" value="Fisica" checked="checked"  <?php if (!(strcmp($row_referencia2['persona'],"Fisica"))) {echo "checked=\"checked\"";} ?> />Fisica
            <input name="persona" type="radio" id="Moral" tabindex="7" value="Moral"  <?php if (!(strcmp($row_referencia2['persona'],"Moral"))) {echo "checked=\"checked\"";} ?> />Moral
          
          </td>
      </tr>
      
      
    
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="Texto_tabla"><span class="style4">Domicilio</span></span></td>
      <td class="Texto_tabla"><input name="domicilio_referencia" type="text" class="style3 " value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_referencia2['domicilio_referencia']; }?>" size="65" /></td>
      <td bgcolor="#000033" class="Texto_tabla"><span class="style3 Encabezado_tabla"><span class="style4">Ciudad</span></span></td>
      <td class="Texto_tabla"><input name="ciudad_referencia" type="text" class="style3 " value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_referencia2['ciudad_referencia']; }?>" size="65" /></td>
    </tr>
    
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="style4">Codigo Postal </span></td>
      <td class="Texto_tabla"><input name="cp_referencia" type="text" class="style3 " value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_referencia2['cp_referencia']; }?>" size="65" /></td>
      <td bgcolor="#000033" class="Texto_tabla"><span class="style3 Encabezado_tabla"><span class="style4">Telefono</span></span></td>
      <td class="Texto_tabla"><input name="tel_referencia" type="text" class="style3 " value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_referencia2['tel_referencia']; }?>" size="65" /></td>
    </tr>

      
      <tr valign="baseline">
        <!-- Salta una columna  -->
          <td width="105" align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="style4"></span></td>
          <td width="267" class="Texto_tabla"></td>
          
          <td bgcolor="#000033" class="Texto_tabla"><span class="style3 Encabezado_tabla"><span class="style4">Teléfono móvil</span></span></td>
      <td class="Texto_tabla"><input name="tel_referencia_aval_movil" type="text" class="style3 " value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_referencia2['tel_referencia_aval_movil']; }?>" size="65" /></td>
      </tr>
      
      <tr valign="baseline">
        <!-- Salta una columna  -->
          <td width="105" align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="style4"></span></td>
          <td width="267" class="Texto_tabla"></td>
          
          <td bgcolor="#000033" class="Texto_tabla"><span class="style3 Encabezado_tabla"><span class="style4">Teléfono Trabajo</span></span></td>
      <td class="Texto_tabla"><input name="tel_referencia_aval_trabajo" type="text" class="style3 " value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_referencia2['tel_referencia_aval_trabajo']; }?>" size="65" /></td>
      </tr>
      
      
      
      
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla"><span class="style4">Fax</span></td>
      <td class="Texto_tabla"><input name="fax_referencia" type="text" class="style3 " value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_referencia2['fax_referencia']; }?>" size="65" /></td>
      <td bgcolor="#000033" class="Texto_tabla"><span class="style3 Encabezado_tabla"><span class="style4">Email</span></span></td>
      <td class="Texto_tabla"><input name="email_referencia" type="text" class="style3 " value="<?php if ($parametro1 = 0) { echo '" "'; } else  { echo $row_referencia2['email_referencia']; }?>" size="65" /></td>
    </tr>

    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#000033" class="style3 Encabezado_tabla style5"><input type="hidden" name="MM_insert" value="form1" />
        <input type="hidden" name="MM_update" value="form2" /></td>
      <td colspan="3" class="Texto_tabla"><div align="center" class="style2">
        <div align="left">
          <?php //echo $parametro1; ?>
          <?php //echo $recordID; ?>
          <?php //echo '---->' . $cantidad_registros; ?>  
          <span class="Texto_tabla">
            <input name="Grabar" type="submit" class="style3" value="Grabar" <?php if ($recordID2 > 0 ) {echo "disabled";} else {echo "enabled";}?> />
            <input name="Editar" type="submit" class="style3" value="Editar" <?php if ($recordID2 > 0 ) {echo "enabled";} else {echo "disabled";}?> />
            <input name="Borrar" type="submit" class="style3" value="Borrar" <?php if ($recordID2 > 0 ) {if ($cantidad_registros >= 1 ) {echo "disabled";} else {echo "enabled";}} else {echo "disabled";}?> />
            <input name="Cancelar" type="submit" class="style3" id="Cancelar" value="Cancelar" />
            </span>          </div>
      </div></td>
      </tr>
  </table>
</div>

</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($referencia);

mysqli_free_result($referencia2);

mysqli_free_result($cliente_combo);
?>
