<?php require_once('Connections/contratos_londres.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2,1";
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

$MM_restrictGoTo = "conectar_empresa.php";
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

//echo $_SESSION['MM_UserId']."-> ".$_SESSION['MM_Username']."<BR>";
$numero_parametros = count($_GET);

//echo "numero de parametros: ".$numero_parametros."<BR>";

$recordID=$_GET['parametro1'];
$recordID0=$_SESSION['MM_Empresa'];
$recordID1=$_GET['contrato'];
$recordID2=$_GET['fecha_contrato'];
$recordID3=$_GET['clave_cliente'];
$recordID4=$_GET['garantia'];

if (!isset($_GET['garantia'])) {$recordID4=0;$_GET['garantia']=$recordID4;}

$recordID5=$_GET['fecha_garantia'];
$recordID6=$_GET['clave_inv'];
$recordID7=$_GET['acuenta'];

if (!isset($_GET['acuenta'])) {$recordID7=0;$_GET['acuenta']=$recordID7;}

$recordID8=$_GET['clave_inv_acuenta'];
$recordID9=$_GET['clave_vendedor'];
$recordID10=$_GET['clave_cobrador'];
$recordID11=$_GET['clave_testigo'];
$recordID12=$_GET['credito'];
$recordID13=$_GET['aspecto_mec'];
$recordID14=$_GET['aspecto_car'];
$recordID15=$_GET['forma_pago'];
$recordID16=$_GET['promocion'];
$recordID17=$_GET['no_pagos'];
$recordID18=$_GET['interes'];

if (!isset($_GET['interes']) OR $recordID12==2) {$recordID18=0;$_GET['interes']=$recordID18;}

$recordID19=$_GET['moratorio'];

if (!isset($_GET['moratorio']) OR $recordID12==2) {$recordID19=0;$_GET['moratorio']=$recordID19;}

$recordID20=$_GET['cprecio'];
$recordID21=$_GET['cenganche'];

if (!isset($_GET['cenganche']) OR $recordID12==2) {$recordID21=0;$_GET['cenganche']=$recordID19;}

$recordID22=$_GET['cacuenta'];
$recordID23=$_GET['saldo_inicial'];
$recordID24=$_GET['cinteres'];

if (!isset($_GET['cinteres']) OR $recordID12==2) {$recordID24=0;$_GET['cinteres']=$recordID24;}

$recordID25=$_GET['civa'];
$recordID26=$_GET['ctotal'];
$recordID27=$_GET['cefectivo'];
$recordID28=$_GET['ccheque'];
$recordID29=$_GET['no_cheque'];
$recordID30=$_GET['banco_cheque'];

if(!$_GET['acuenta']) 						{$_GET['acuenta']=0;	$recordID7=0;} 

if (!isset($_GET['u_luces'])) 				{$recordID31=0;	$_GET['u_luces']=$recordID31;}
if (!isset($_GET['luces'])) 				{$recordID32=0;	$_GET['luces']=$recordID32;}
if (!isset($_GET['antena'])) 				{$recordID33=0;	$_GET['antena']=$recordID33;}
if (!isset($_GET['espejos'])) 				{$recordID34=0;	$_GET['espejos']=$recordID34;}
if (!isset($_GET['cristales'])) 			{$recordID35=0;	$_GET['cristales']=$recordID35;}
if (!isset($_GET['tapones'])) 				{$recordID36=0;	$_GET['tapones']=$recordID36;}
if (!isset($_GET['molduras'])) 				{$recordID37=0;	$_GET['molduras']=$recordID37;}
if (!isset($_GET['tapon_gas'])) 			{$recordID38=0;	$_GET['tapon_gas']=$recordID38;}
if (!isset($_GET['carroceria_sin_golpes'])) {$recordID39=0;	$_GET['carroceria_sin_golpes']=$recordID39;}
if (!isset($_GET['tablero'])) 				{$recordID40=0;	$_GET['tablero']=$recordID40;}
if (!isset($_GET['calefaccion'])) 			{$recordID41=0;	$_GET['calefaccion']=$recordID41;}
if (!isset($_GET['aire'])) 					{$recordID42=0;	$_GET['aire']=$recordID42;}
if (!isset($_GET['limpiadores'])) 			{$recordID43=0;	$_GET['limpiadores']=$recordID43;}
if (!isset($_GET['radio'])) 				{$recordID44=0;	$_GET['radio']=$recordID44;}
if (!isset($_GET['bocinas']))				{$recordID45=0;	$_GET['bocinas']=$recordID45;}
if (!isset($_GET['retrovisor'])) 			{$recordID46=0;	$_GET['retrovisor']=$recordID46;}
if (!isset($_GET['ceniceros'])) 			{$recordID47=0;	$_GET['ceniceros']=$recordID47;}
if (!isset($_GET['cinturones'])) 			{$recordID48=0;	$_GET['cinturones']=$recordID48;}
if (!isset($_GET['gato'])) 					{$recordID49=0;	$_GET['gato']=$recordID49;}
if (!isset($_GET['cruceta'])) 				{$recordID50=0;	$_GET['cruceta']=$recordID50;}
if (!isset($_GET['llanta_refa'])) 			{$recordID51=0;	$_GET['llanta_refa']=$recordID51;}
if (!isset($_GET['estuche_he'])) 			{$recordID52=0;	$_GET['estuche_he']=$recordID52;}
if (!isset($_GET['triangulo'])) 			{$recordID53=0;	$_GET['triangulo']=$recordID53;}
if (!isset($_GET['extinguidor'])) 			{$recordID54=0;	$_GET['extinguidor']=$recordID54;}

$recordID55=$_GET['fecha_entrega'];
$recordID56=$_GET['aspecto_llantas'];
$recordID57=$_GET['otros_aspectos'];
$recordID58=$_GET['aspecto_otros'];



//echo "Garantia: ".$recordID4."<BR>";
//echo "A Cuenta: ".$recordID7."<BR>";
//echo "Numero de pagos: ".$recordID17."<BR>";

//echo "garantia: ".$recordID4;


/*echo "contrato: ".$recordID1."<BR>";
echo "fecha contrato: ".$recordID2."<BR>";
echo "clave_cliente: ".$recordID3."<BR>";
echo "garantia: ".$recordID4."<BR>";
echo "clave_inv: ".$recordID6."<BR>";
*/


$var="";
if ($numero_parametros==1 AND $recordID>0) {
	$var=" where clave_contrato='$recordID'";
}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_contratos = "select clave_contrato, contrato, credito,clave_empresa, clave_cliente, DATE_FORMAT(fecha_contrato, '%d-%m-%Y') AS fecha_contrato, forma_pago, promocion, no_pagos, interes, moratorio, cenganche, cinteres, acuenta, cprecio, cacuenta, civa, ctotal, clave_inv, clave_inv_acuenta, cefectivo, no_cheque, ccheque, banco_cheque, clave_vendedor, clave_cobrador, clave_testigo, garantia, DATE_FORMAT(fecha_garantia, '%d-%m-%Y') AS fecha_garantia, partes_garantia, aspecto_mec, aspecto_car, aplicado, clave_usuario, saldo_inicial from contrato".$var;
$contratos = mysql_query($query_contratos, $contratos_londres) or die(mysql_error());
$row_contratos = mysql_fetch_assoc($contratos);
$totalRows_contratos = mysql_num_rows($contratos);


if ($numero_parametros==1 AND $recordID>0) {

	$recordID1=$row_contratos['contrato'];					$_GET['contrato']=$recordID1;
	$recordID2=$row_contratos['fecha_contrato'];			$_GET['fecha_contrato']=$recordID2;
	$recordID3=$row_contratos['clave_cliente'];				$_GET['clave_cliente']=$recordID3;
	$recordID4=$row_contratos['garantia'];					$_GET['garantia']=$recordID4;
	$recordID5=$row_contratos['fecha_garantia'];			$_GET['fecha_garantia']=$recordID5;
	$recordID6=$row_contratos['clave_inv'];					$_GET['clave_inv']=$recordID6;
	$recordID7=$row_contratos['acuenta'];					$_GET['acuenta']=$recordID7;
	$recordID8=$row_contratos['clave_inv_acuenta'];			$_GET['clave_inv_acuenta']=$recordID8;
	$recordID9=$row_contratos['clave_vendedor'];			$_GET['clave_vendedor']=$recordID9;
	$recordID10=$row_contratos['clave_cobrador'];			$_GET['clave_cobrador']=$recordID10;
	$recordID11=$row_contratos['clave_testigo'];			$_GET['clave_testigo']=$recordID11;
	$recordID12=$row_contratos['credito'];					$_GET['credito']=$recordID12;
	$recordID13=$row_contratos['aspecto_mec'];				$_GET['aspecto_mec']=$recordID13;
	$recordID14=$row_contratos['aspecto_car'];				$_GET['aspecto_car']=$recordID14;
	$recordID15=$row_contratos['forma_pago'];				$_GET['forma_pago']=$recordID15;
	$recordID16=$row_contratos['promocion'];				$_GET['promocion']=$recordID16;
	$recordID17=$row_contratos['no_pagos'];					$_GET['no_pagos']=$recordID17;
	$recordID18=$row_contratos['interes'];					$_GET['interes']=$recordID18;
	$recordID19=$row_contratos['moratorio'];				$_GET['moratorio']=$recordID19;
	$recordID20=$row_contratos['cprecio'];					$_GET['cprecio']=$recordID20;
	$recordID21=$row_contratos['cenganche'];				$_GET['cenganche']=$recordID21;
	$recordID22=$row_contratos['cacuenta'];					$_GET['cacuenta']=$recordID22;
	$recordID23=$row_contratos['saldo_inicial'];			$_GET['saldo_inicial']=$recordID23;
	$recordID24=$row_contratos['cinteres'];					$_GET['cinteres']=$recordID24;
	$recordID25=$row_contratos['civa'];						$_GET['civa']=$recordID25;
	$recordID26=$row_contratos['ctotal'];					$_GET['ctotal']=$recordID26;
	$recordID27=$row_contratos['cefectivo'];				$_GET['cefectivo']=$recordID27;
	$recordID28=$row_contratos['ccheque'];					$_GET['ccheque']=$recordID28;
	$recordID29=$row_contratos['no_cheque'];				$_GET['no_cheque']=$recordID29;
	$recordID30=$row_contratos['banco_cheque'];				$_GET['banco_cheque']=$recordID30;
	$recordID31=$row_contratos['u_luces'];					$_GET['u_luces']=$recordID31;
	$recordID32=$row_contratos['luces'];					$_GET['luces']=$recordID32;
	$recordID33=$row_contratos['antena'];					$_GET['antena']=$recordID33;
	$recordID34=$row_contratos['espejos'];					$_GET['espejos']=$recordID34;
	$recordID35=$row_contratos['cristales'];				$_GET['cristales']=$recordID35;
	$recordID36=$row_contratos['tapones'];					$_GET['tapones']=$recordID36;
	$recordID37=$row_contratos['molduras'];					$_GET['molduras']=$recordID37;
	$recordID38=$row_contratos['tapon_gas'];				$_GET['tapon_gas']=$recordID38;
	$recordID39=$row_contratos['carroceria_sin_golpes'];	$_GET['carroceria_sin_golpes']=$recordID39;
	$recordID40=$row_contratos['tablero'];					$_GET['tablero']=$recordID40;
	$recordID41=$row_contratos['calefaccion'];				$_GET['calefaccion']=$recordID41;
	$recordID42=$row_contratos['aire'];						$_GET['aire']=$recordID42;
	$recordID43=$row_contratos['limpiadores'];				$_GET['limpiadores']=$recordID43;
	$recordID44=$row_contratos['radio'];					$_GET['radio']=$recordID44;
	$recordID45=$row_contratos['bocinas'];					$_GET['bocinas']=$recordID45;
	$recordID46=$row_contratos['retrovisor'];				$_GET['retrovisor']=$recordID46;
	$recordID47=$row_contratos['ceniceros'];				$_GET['ceniceros']=$recordID47;
	$recordID48=$row_contratos['cinturones'];				$_GET['cinturones']=$recordID48;
	$recordID49=$row_contratos['gato'];						$_GET['gato']=$recordID49;
	$recordID50=$row_contratos['cruceta'];					$_GET['cruceta']=$recordID50;
	$recordID51=$row_contratos['llanta_refa'];				$_GET['llanta_refa']=$recordID51;
	$recordID52=$row_contratos['estuche_he'];				$_GET['estuche_he']=$recordID52;
	$recordID53=$row_contratos['triangulo'];				$_GET['triangulo']=$recordID53;
	$recordID54=$row_contratos['extinguidor'];				$_GET['extinguidor']=$recordID54;
	$recordID55=$row_contratos['fecha_entrega'];			$_GET['fecha_entrega']=$recordID55;
	$recordID56=$row_contratos['aspecto_llantas'];			$_GET['aspecto_llantas']=$recordID56;
	$recordID57=$row_contratos['otros_aspectos'];			$_GET['otros_aspectos']=$recordID57;
	$recordID58=$row_contratos['aspecto_otros'];			$_GET['aspecto_otros']=$recordID58;

} 
else {
       if (strlen($recordID2)==0)
	   {
	   		$recordID2=date('d-m-Y');
			$_GET['fecha_contrato']=date('d-m-Y');
			
	   }
       if (strlen($recordID5)==0)
	   {
	   		$recordID5=date('d-m-Y');
			$_GET['fecha_garantia']=date('d-m-Y');
			
	   }
       
}
//if ($numero_parametros==1 AND $recordID>0) {
//	$recordID7=$row_contratos['acuenta'];
//	$_GET['acuenta']=$recordID7;
//}


mysql_select_db($database_contratos_londres, $contratos_londres);
$query_clientes = "SELECT * FROM clientes ORDER BY clave_cliente, nombre_cliente ASC";
$clientes = mysql_query($query_clientes, $contratos_londres) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_autos = "SELECT inventario_auto.*, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca, CONCAT(TRIM(marca.marca),' - ',TRIM(tipo_auto.modelo),' - ',TRIM(inventario_auto.ano),' - Serie: ',TRIM(inventario_auto.serie),' - Pedimento:',TRIM(inventario_auto.pedimento)) as datos_autos FROM inventario_auto, tipo_auto, marca WHERE inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca AND (inventario_auto.vendido=0 OR inventario_auto.vendido is null) ORDER BY clave_inv, marca ASC";
$autos = mysql_query($query_autos, $contratos_londres) or die(mysql_error());
$row_autos = mysql_fetch_assoc($autos);
$totalRows_autos = mysql_num_rows($autos);

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_autos_acambio = "SELECT inventario_auto.*, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca, CONCAT(TRIM(marca.marca),' - ',TRIM(tipo_auto.modelo),' - ',TRIM(inventario_auto.ano),' - Serie: ', TRIM(inventario_auto.serie),' - Pedimento:',TRIM(inventario_auto.pedimento)) as datos_autos  FROM inventario_auto, tipo_auto, marca WHERE (inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca)  AND (inventario_auto.acambio=1 AND inventario_auto.acambio is not null) ORDER BY clave_inv, marca, modelo, estilo, ano, clave_empresa";
$autos_acambio = mysql_query($query_autos_acambio, $contratos_londres) or die(mysql_error());
$row_autos_acambio = mysql_fetch_assoc($autos_acambio);
$totalRows_autos_acambio = mysql_num_rows($autos_acambio);

$var="";
if ($recordID3<>0) { $var=" where clave_cliente='$recordID3'";} else { $var=" where clave_cliente=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_avales = "select * from avales ".$var." order by nombre_aval ASC";
$avales = mysql_query($query_avales, $contratos_londres) or die(mysql_error());
$row_avales = mysql_fetch_assoc($avales);
$totalRows_avales = mysql_num_rows($avales);

$var="";
if ($recordID3<>0) { $var=" where clave_cliente='$recordID3'";} else { $var=" where clave_cliente=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_referencias = "select * from referencias ".$var." order by nombre_referencia ASC";
$referencias = mysql_query($query_referencias, $contratos_londres) or die(mysql_error());
$row_referencias = mysql_fetch_assoc($referencias);
$totalRows_referencias = mysql_num_rows($referencias);

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_vendedor = "select * from vendedores order by nombre_vendedor ASC";
$vendedor = mysql_query($query_vendedor, $contratos_londres) or die(mysql_error());
$row_vendedor = mysql_fetch_assoc($vendedor);
$totalRows_vendedor = mysql_num_rows($vendedor);

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_cobrador = "SELECT * FROM cobradores ORDER BY nombre_cobrador ASC";
$cobrador = mysql_query($query_cobrador, $contratos_londres) or die(mysql_error());
$row_cobrador = mysql_fetch_assoc($cobrador);
$totalRows_cobrador = mysql_num_rows($cobrador);

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_testigo = "SELECT * FROM testigos ORDER BY nombre_testigo ASC";
$testigo = mysql_query($query_testigo, $contratos_londres) or die(mysql_error());
$row_testigo = mysql_fetch_assoc($testigo);
$totalRows_testigo = mysql_num_rows($testigo);


$var="";
if ($recordID0<>0) { $var=" where clave_empresa='$recordID0'";} else { $var=" where clave_empresa=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_empresa = "select * from empresa".$var;
$empresa = mysql_query($query_empresa, $contratos_londres) or die(mysql_error());
$row_empresa = mysql_fetch_assoc($empresa);
$totalRows_empresa = mysql_num_rows($empresa);

$var="";
if ($recordID6<>0) { $var=" AND clave_inv='$recordID6'";} else { $var=" AND clave_inv=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_autos_datos = "SELECT inventario_auto.*, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca FROM inventario_auto, tipo_auto, marca WHERE inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca AND (inventario_auto.vendido=0 OR inventario_auto.vendido is null)".$var;
$autos_datos = mysql_query($query_autos_datos, $contratos_londres) or die(mysql_error());
$row_autos_datos = mysql_fetch_assoc($autos_datos);
$totalRows_autos_datos = mysql_num_rows($autos_datos);


$var="";
if ($recordID7<>0) { $var=" AND clave_inv='$recordID8'";} else { $var=" AND clave_inv=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_autos_acambio_datos = "SELECT inventario_auto.*, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca FROM inventario_auto, tipo_auto, marca WHERE inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca AND (inventario_auto.acambio=1 AND inventario_auto.acambio is not null)".$var;
$autos_acambio_datos = mysql_query($query_autos_acambio_datos, $contratos_londres) or die(mysql_error());
$row_autos_acambio_datos = mysql_fetch_assoc($autos_acambio_datos);
$totalRows_autos_acambio_datos = mysql_num_rows($autos_acambio_datos);

$var="";
if ($recordID3<>0) { $var=" where clave_cliente='$recordID3'";} else { $var=" where clave_cliente=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_cliente_datos = "select * from clientes".$var;
$cliente_datos = mysql_query($query_cliente_datos, $contratos_londres) or die(mysql_error());
$row_cliente_datos = mysql_fetch_assoc($cliente_datos);
$totalRows_cliente_datos = mysql_num_rows($cliente_datos);

$var="";
if ($recordID9<>0) { $var=" where clave_vendedor='$recordID9'";} else { $var=" where clave_vendedor=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_vendedor_datos = "select * from vendedores".$var;
$vendedor_datos = mysql_query($query_vendedor_datos, $contratos_londres) or die(mysql_error());
$row_vendedor_datos = mysql_fetch_assoc($vendedor_datos);
$totalRows_vendedor_datos = mysql_num_rows($vendedor_datos);

$var="";
if ($recordID10<>0) { $var=" where clave_cobrador='$recordID10'";} else { $var=" where clave_cobrador=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_cobrador_datos = "select * from cobradores".$var;
$cobrador_datos = mysql_query($query_cobrador_datos, $contratos_londres) or die(mysql_error());
$row_cobrador_datos = mysql_fetch_assoc($cobrador_datos);
$totalRows_cobrador_datos = mysql_num_rows($cobrador_datos);

$var="";
if ($recordID11<>0) { $var=" where clave_testigo='$recordID11'";} else { $var=" where clave_testigo=0";}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_testigo_datos = "select * from testigos".$var;
$testigo_datos = mysql_query($query_testigo_datos, $contratos_londres) or die(mysql_error());
$row_testigo_datos = mysql_fetch_assoc($testigo_datos);
$totalRows_testigo_datos = mysql_num_rows($testigo_datos);

///****************************************

$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ($_GET["Grabar"]) { 
if ((isset($_GET["MM_insert"])) && ($_GET["MM_insert"] == "forma_general")) {

//Verifica si ya se capturo un Contrato Igual, si es asi, no permite la captura...
//****************************
$colname_verifica = "-1";
if (isset($_GET['contrato'])) {
  $colname_verifica = $_POST['contrato'];
  //echo "----------->".$colname_verifica;
}
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_verifica = sprintf("SELECT * FROM contrato WHERE contrato = %s", GetSQLValueString($colname_verifica, "text"));
$verifica = mysql_query($query_verifica, $contratos_londres) or die(mysql_error());
$row_verifica = mysql_fetch_assoc($verifica);
$totalRows_verifica = mysql_num_rows($verifica);
mysql_free_result($verifica);

//************************
if ($totalRows_verifica > 0)  {echo "El Contrato que se capturo esta repetido y esto no es posible.  Por favor oprima el boton atras para modificar el Contrato o para cancelar.";exit;}
else {
 $insertSQL = sprintf("INSERT INTO contrato (contrato, credito, clave_empresa, clave_cliente, fecha_contrato, forma_pago, promocion, no_pagos, interes, moratorio, cenganche, cinteres, acuenta, cprecio, cacuenta, civa, ctotal, clave_inv, clave_inv_acuenta, cefectivo, no_cheque, ccheque, banco_cheque, clave_vendedor, clave_cobrador, clave_testigo, garantia, fecha_garantia, partes_garantia, aspecto_mec, aspecto_car, clave_usuario, saldo_inicial, aspecto_llantas, otros_aspectos, aspecto_otros, fecha_entrega, u_luces, luces, antena, espejos, cristales, tapones, molduras, tapon_gas, carroceria_sin_golpes, tablero, calefaccion, aire, limpiadores, radio, bocinas, retrovisor, ceniceros, cinturones, gato, cruceta, llanta_refa, estuche_he, triangulo, extinguidor) VALUES (%s , %s, %s, %s, %s, %s, %s, %s, %s, %s,%s , %s, %s, %s, %s, %s, %s, %s, %s, %s,%s , %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", 
 GetSQLValueString($_GET['contrato'], "text"),
 GetSQLValueString($_GET['credito'], "text"),                                                                                 
 GetSQLValueString($recordID0, "text"),                                                                           
 GetSQLValueString($_GET['clave_cliente'], "text"),                                                                           
 GetSQLValueString($_GET['fecha_contrato'], "date"),                                                                          
 GetSQLValueString($_GET['forma_pago'], "text"),                                                                              
 GetSQLValueString($_GET['promocion'], "text"),                                                                               
 GetSQLValueString($_GET['no_pagos'], "text"),                                                                                
 GetSQLValueString($_GET['interes'], "text"),                                                                                 
 GetSQLValueString($_GET['moratorio'], "text"),                                                                               
 GetSQLValueString($_GET['cenganche'], "text"),                                                                               
 GetSQLValueString($_GET['cinteres'], "text"),                                                                                
 GetSQLValueString($_GET['acuenta'], "text"),                                                                                 
 GetSQLValueString($_GET['cprecio'], "text"),                                                                                 
 GetSQLValueString($_GET['cacuenta'], "text"),                                                                                
 GetSQLValueString($_GET['civa'], "text"),                                                                                    
 GetSQLValueString($_GET['ctotal'], "text"),                                                                                  
 GetSQLValueString($_GET['clave_inv'], "text"),                                                                               
 GetSQLValueString($_GET['clave_inv_acuenta'], "text"),                                                                       
 GetSQLValueString($_GET['cefectivo'], "text"),                                                                               
 GetSQLValueString($_GET['no_cheque'], "text"),                                                                               
 GetSQLValueString($_GET['ccheque'], "text"),                                                                                 
 GetSQLValueString($_GET['banco_cheque'], "text"),                                                                            
 GetSQLValueString($_GET['clave_vendedor'], "text"),                                                                          
 GetSQLValueString($_GET['clave_cobrador'], "text"),                                                                          
 GetSQLValueString($_GET['clave_testigo'], "text"),                                                                           
 GetSQLValueString($_GET['garantia'], "text"),                                                                                
 GetSQLValueString($_GET['fecha_garantia'], "text"),                                                                          
 GetSQLValueString($_GET['partes_garantia'], "text"),                                                                         
 GetSQLValueString($_GET['aspecto_mec'], "text"),                                                                             
 GetSQLValueString($_GET['aspecto_car'], "text"),                                                                             
 GetSQLValueString($_GET['clave_usuario'], "text"),
 GetSQLValueString($_GET['saldo_inicial'], "text"),
 GetSQLValueString($_GET['aspecto_llantas'], "text"),
 GetSQLValueString($_GET['otros_aspectos'], "text"),
 GetSQLValueString($_GET['aspecto_otros'], "text"),
 GetSQLValueString($_GET['fecha_entrega'], "text"),
 GetSQLValueString($_GET['u_luces'], "text"),
 GetSQLValueString($_GET['luces'], "text"),
 GetSQLValueString($_GET['antena'], "text"),
 GetSQLValueString($_GET['espejos'], "text"),
 GetSQLValueString($_GET['cristales'], "text"),
 GetSQLValueString($_GET['tapones'], "text"),
 GetSQLValueString($_GET['molduras'], "text"),
 GetSQLValueString($_GET['tapon_gas'], "text"),
 GetSQLValueString($_GET['carroceria_sin_golpes'], "text"),
 GetSQLValueString($_GET['tablero'], "text"),
 GetSQLValueString($_GET['calefaccion'], "text"),
 GetSQLValueString($_GET['aire'], "text"),
 GetSQLValueString($_GET['limpiadores'], "text"),
 GetSQLValueString($_GET['radio'], "text"),
 GetSQLValueString($_GET['bocinas'], "text"),
 GetSQLValueString($_GET['retrovisor'], "text"),
 GetSQLValueString($_GET['ceniceros'], "text"),
 GetSQLValueString($_GET['cinturones'], "text"),
 GetSQLValueString($_GET['gato'], "text"),
 GetSQLValueString($_GET['cruceta'], "text"),
 GetSQLValueString($_GET['llanta_refa'], "text"),
 GetSQLValueString($_GET['estuche_he'], "text"),
 GetSQLValueString($_GET['triangulo'], "text"),
 GetSQLValueString($_GET['extinguidor'], "text"));


//echo "SQL: ".$insertSQL."<BR>";//exit;
  mysql_select_db($database_contratos_londres, $contratos_londres);
  $Result1 = mysql_query($insertSQL, $contratos_londres) or die(mysql_error());
  
  exit;
  
  $updateGoTo = "contrato.php";
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
//Verifica si ya se capturo un RFC Igual, si es asi, no permite la captura...
//****************************
$colname_verifica = "-1";
$colname_verifica2= "-1";

if (isset($_POST['rfc_cliente'])) {
  $colname_verifica = $_POST['rfc_cliente'];
}

if (isset($_POST['clave_cliente'])) {
  $colname_verifica2 = $_POST['clave_cliente'];
}

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_verifica = sprintf("SELECT * FROM clientes WHERE rfc_cliente = %s AND clave_cliente<> %s", GetSQLValueString($colname_verifica, "text"),GetSQLValueString($colname_verifica2, "text") );
$verifica = mysql_query($query_verifica, $contratos_londres) or die(mysql_error());
$row_verifica = mysql_fetch_assoc($verifica);
$totalRows_verifica = mysql_num_rows($verifica);
mysql_free_result($verifica);

if (isset($_POST['nombre_cliente'])) {
  $colname_verifica = $_POST['nombre_cliente'];
}

if (isset($_POST['clave_cliente'])) {
  $colname_verifica2 = $_POST['clave_cliente'];
}
//echo "nombre del cliente: ".$colname_verifica. "<BR>";
//echo "clave  del cliente: ".$colname_verifica2."<BR>";
//exit;

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_verifica2 = sprintf("SELECT * FROM clientes WHERE nombre_cliente = %s AND clave_cliente<> %s", GetSQLValueString($colname_verifica, "text"),GetSQLValueString($colname_verifica2, "text") );
$verifica2 = mysql_query($query_verifica2, $contratos_londres) or die(mysql_error());
$row_verifica2 = mysql_fetch_assoc($verifica2);
$totalRows_verifica2 = mysql_num_rows($verifica2);

mysql_select_db($database_contratos_londres, $contratos_londres);
$query_moneda = "select * from monedas";
$moneda = mysql_query($query_moneda, $contratos_londres) or die(mysql_error());
$row_moneda = mysql_fetch_assoc($moneda);
$totalRows_moneda = mysql_num_rows($moneda);
mysql_free_result($verifica2);

mysql_free_result($moneda);


//************************
if (($totalRows_verifica > 0 || $totalRows_verifica2 > 0) && $row_verifica['clave_cliente']<>$_POST['clave_cliente'])  {echo "El RFC o el Nombre del Cliente que se capturo esta repetido y esto no es posible.  Por favor oprima el boton atras para modificar el RFC o para cancelar.";exit;}
else {
// if ($_POST['activo_proveedor']<>1) {$_POST['activo_proveedor']=0;}
 
 $updateSQL = sprintf("UPDATE clientes SET nombre_cliente=%s, rfc_cliente=%s, domicilio_cliente=%s, ciudad_cliente=%s, cp_cliente=%s, tel_cliente=%s, fax_cliente=%s, email_cliente=%s WHERE clave_cliente='$recordID'",
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
					   GetSQLValueString($_POST['rfc_cliente'], "text"),
					   GetSQLValueString($_POST['domicilio_cliente'], "text"),
					   GetSQLValueString($_POST['ciudad_cliente'], "text"),
					   GetSQLValueString($_POST['cp_cliente'], "text"),
					   GetSQLValueString($_POST['tel_cliente'], "text"),
					   GetSQLValueString($_POST['fax_cliente'], "text"),
					   GetSQLValueString($_POST['email_cliente'], "text"));

  mysql_select_db($database_contratos_londres, $contratos_londres);
  $Result1 = mysql_query($updateSQL, $contratos_londres) or die(mysql_error());

  $updateGoTo = "clientes_list.php";
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
 
 $updateSQL = sprintf("DELETE from clientes WHERE clave_cliente='$recordID'");

  mysql_select_db($database_contratos_londres, $contratos_londres);
  $Result1 = mysql_query($updateSQL, $contratos_londres) or die(mysql_error());

  $updateGoTo = "clientes_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];  
	}
	header(sprintf("Location: %s", $updateGoTo));  
}

///
 if ($_POST["Cancelar"]) {
  $updateGoTo = "contrato.php";
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
}



///****************************************

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contrato</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script type="text/javascript" src="jscalendar-0.9.6/calendar.js"></script>
<script type="text/javascript" src="jscalendar-0.9.6/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar-0.9.6/calendar-setup.js"></script>

<script type="text/javascript">
function format(input)
{
var num = input.value.replace(/\./g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
num = num.split('').reverse().join('').replace(/^[\.]/,'');
input.value = num;
}
else{ alert('Solo se permiten numeros');
input.value = input.value.replace(/[^\d\.]*/g,'');
}
}
</script>


<script type="text/javascript">
	
	function actualiza_saldo_inicial(s) {

		//Calcula el saldo inicial, restando del precio el enganche y el costo del automovil dado a cuenta.
		var cp=parseFloat(document.getElementById('cprecio').value);
		var ce=parseFloat(document.getElementById('cenganche').value);
		var ac=parseFloat(document.getElementById('cacuenta').value);

       	var total_saldo_inicial=eval(cp-ce-ac);
		
	   	document.getElementById('saldo_inicial').value = total_saldo_inicial;
	}


	function actualiza_interes(s) {

		//Calcula los intereses.	
		var inte=parseFloat(document.getElementById('interes').value);
		    inte=eval(inte*0.01);
			
		var ti  =eval(inte*document.getElementById('saldo_inicial').value);
		document.getElementById('cinteres').value = ti;		 
}

	function actualiza_iva(s) {
		//Calcula el IVA.
	   var total_iva=parseFloat(document.getElementById('saldo_inicial').value);
	   	   total_iva=eval(total_iva*0.11);
	   document.getElementById('civa').value = total_iva;
}
	function actualiza_total(s) {
		var saldo_inicial = parseFloat(document.getElementById('saldo_inicial').value);
		var cinteres      = parseFloat(document.getElementById('cinteres').value);
		var civa          = parseFloat(document.getElementById('civa').value);
		var total=eval(saldo_inicial+cinteres+civa);
	   document.getElementById('ctotal').value = total;
}


	function valida() {
		//venta=document.getElementById('venta_kilos').value;
		//alert("si"+venta);
		var errors='';
		if (document.getElementById('venta_kilos').value>document.getElementById('inventario').value) {
			errors="1";
			alert("No debe ser mayor la venta a el inventario...");
		}
		document.MM_returnValue = (errors == '');
	   //$total=document.getElementById('precio_pesos').value*document.getElementById('venta_kilos').value;
	   //document.getElementById('venta_pesos').value = $total;
	}
		
	function nuevoAjax() {
	var xmlhttp=false;
	var ids = ["Msxml2.XMLHTTP.7.0","Msxml2.XMLHTTP.6.0","Msxml2. XMLHTTP.5.0","Msxml2.XMLHTTP.4.0","Msxml2.XMLHTTP. 3.0","Msxml2.XMLHTTP","Microsoft.XMLHTTP"];
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		try {
			xmlhttp = new XMLHttpRequest();
		} catch (e) {
			xmlhttp=false;
		}
	}
	if (!xmlhttp && window.createRequest) {
		try {
			xmlhttp = window.createRequest();
		} catch (e) {
			xmlhttp=false;
		}
	}
	return xmlhttp;
}


var cargarDatos = function (obj){
	obj.onchange = function (){
		var ajax = nuevoAjax();
		ajax.open('POST', 'obtieneprecio.php', true);
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4) {
				// verificar que esta respondiendo
				//alert(ajax.responseText);
				// response = eval(ajax.responseText);
				response = eval('(' + ajax.responseText + ')');

				document.getElementById('precio_pesos').value = response.preciov; //igual a la columna en db
				document.getElementById('inventario').value = response.inventario_material; //igual a la columna en db
		 	}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("clave_material=" + obj.value);
	}
}

</script>

<style type="text/css">
@import url("jscalendar-0.9.6/calendar-win2k-cold-1.css");
<!--
#generales {
	position:absolute;
	left:19px;
	top:264px;
	width:922px;
	height:445px;
	z-index:1;
	visibility: visible;
}
#fechagarantia {
	position:absolute;
	left:454px;
	top:332px;
	width:418px;
	height:25px;
	z-index:2;
	visibility: visible;
}
.style1 {font-size: 10px}
.style3 {font-size: 10px; font-weight: bold; }
.style4 {
	font-size: 12px;
	font-weight: bold;
}
.style6 {color: #FFFFFF}
.style7 {font-size: 10px; color: #FFFFFF; }
.style8 {font-size: 10px; font-weight: bold; color: #FFFFFF; }
.style10 {color: #0000CC}
.style11 {font-size: 10px; font-weight: bold; color: #0000CC; }
.style13 {font-size: 10px; font-weight: bold; color: #CC0000}
.style16 {
	font-size: 12px;
	color: #FFFFFF;
}
.style18 {font-size: 10px; font-weight: bold; color: #000000; }
.style19 {color: #000000}
-->
</style>
</head>

<body>
<table width="1024" border="0">
  <tr>
    <td width="178"><img src="Imagenes/londres_logo4.PNG" width="148" height="69" /></td>
    <td width="834"><p class="style4">
      <?php 
	  						 $fx="<BR>";
	  						 $em="<BR>";
	  						 if (strlen($row_empresa['fax_empresa'])>0){$fx=", Fax ".$row_empresa['fax_empresa']."<BR>";}
	  						 if (strlen($row_empresa['email_empresa'])>0){$em="email ".$row_empresa['email_empresa']."<BR>";}	
							 echo $row_empresa['nombre_empresa'].", RFC ".$row_empresa['rfc_empresa']."<BR>";
							 echo $row_empresa['domicilio_empresa'].", C.P. ".$row_empresa['cp_empresa']."<BR>";
							 echo $row_empresa['ciudad_empresa']."<BR>";
							 echo "Telefono(s): ".$row_empresa['tel_empresa'].$fx.$em;
						?>
    </p>    </td>
  </tr>
</table>
<form id="forma_general" name="forma_general" method="get" action="<?php echo $editFormAction; ?>">
  <table width="1024" border="0">
    <tr>
      <td width="191" bgcolor="#FFCC99"><span class="style18">Contrato:</span>
      <input name="contrato" type="text" class="style13" id="contrato" dir="rtl" value="<?php 
echo $_GET['contrato']; ?>" size="15"/></td>
      <td width="308" bgcolor="#FFCC99"><span class="style18">Fecha Venta:</span>
        <input name="fecha_contrato" type="text" class="style3" id="fecha_contrato" dir="rtl" value="<?php echo $_GET['fecha_contrato']; ?>" size="11" />
      <button class="style3" id="trigger2">...</button>        
      
      <input name="clave_contrato" type="hidden" id="clave_contrato" value="<?php echo $_GET['clave_contrato']; ?>" />
      <input name="clave_usuario" type="hidden" id="clave_usuario" value="<?php echo $_SESSION['MM_UserId']; ?>" /></td>
      <td width="356" bgcolor="#FFCC99"><span class="style18">¿Garantia?</span>
        <input name="garantia" type="checkbox" class="style3" id="garantia" onclick="JavaScript:document.forma_general.fecha_garantia.disabled = !this.checked" value="1" <?php if (!(strcmp($_GET['garantia'],1))) {echo "checked=\"checked\"";} ?> />
        <span class="style18">        Fecha del fin de garantia</span><span class="style3">:</span><span class="odd">
        <input name="fecha_garantia" type="text" class="style3" id="fecha_garantia" dir="rtl" value="<?php echo $_GET['fecha_garantia'];?>" size="11" <?php if ($recordID4 == 0 ) {echo "disabled";} else {echo "enabled";}?>/>
        <button class="style3" id="trigger">...</button>
      </span></td>
      <td width="149" bgcolor="#FFCC99" class="style3">
        <div align="left" class="style18">
          <input name="credito" type="radio" id="credito" onblur="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onchange="this.form.submit();
actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onclick="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" value="1" checked="checked"  <?php if (!(strcmp($_GET['credito'],"1"))) {echo "checked=\"checked\"";} ?> />
          Crédito 
          <input name="credito" type="radio" id="credito2" onblur="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onchange="this.form.submit();
actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onclick="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" value="2"  <?php if (!(strcmp($_GET['credito'],"2"))) {echo "checked=\"checked\"";} ?> />
      Contado</div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#000000" class="style11"><div align="center" class="style16">Informacion del Cliente, Avales y referencias.</div></td>
    </tr>
    <tr>
      <td colspan="4"><span class="style3">Cliente:</span>
        <select name="clave_cliente" class="style3" id="clave_cliente" onchange="this.form.submit()">
          <option value="0" <?php if (!(strcmp(0, $_GET['clave_cliente']))) {echo "selected=\"selected\"";} ?>>Selecciona cliente</option>
          <?php
do {  
?>
          <option value="<?php echo $row_clientes['clave_cliente']?>"<?php if (!(strcmp($row_clientes['clave_cliente'], $_GET['clave_cliente']))) {echo "selected=\"selected\"";} ?>><?php echo $row_clientes['nombre_cliente']?></option>
          <?php
} while ($row_clientes = mysql_fetch_assoc($clientes));
  $rows = mysql_num_rows($clientes);
  if($rows > 0) {
      mysql_data_seek($clientes, 0);
	  $row_clientes = mysql_fetch_assoc($clientes);
  }
?>
        </select>
        <span class="style18">
        <?php 
		if ($recordID3>0) {
	  		$fx="<BR>";
	  		$em="<BR>";
	  		if (strlen($row_cliente_datos['fax_cliente'])>0){$fx=", Fax ".$row_cliente_datos['fax_cliente'];}
	  		if (strlen($row_cliente_datos['email_cliente'])>0){$em=", email ".$row_cliente_datos['email_cliente']."<BR>";}	  
	  		echo $row_cliente_datos['domicilio_cliente'].", C.P. ".$row_cliente_datos['cp_cliente'].", ".$row_cliente_datos[	'ciudad_cliente'].", Telefono(s) ".$row_cliente_datos['tel_cliente'].$fx.$em; 
		}?>
        </span></td>
    </tr>
    <tr>
      <td colspan="4"><table width="1000">
          <tr>
            <td width="0" bgcolor="#000033" class="style3"><div align="center" class="style1 style6">Nombre Aval</div></td>
            <td width="60" bgcolor="#000033" class="style3"><div align="center" class="style7">RFC</div></td>
            <td width="200" bgcolor="#000033" class="style3"><div align="center" class="style7">Domicilio</div></td>
            <td width="70" bgcolor="#000033" class="style3"><div align="center" class="style7">Ciudad</div></td>
            <td width="120" bgcolor="#000033" class="style3"><div align="center" class="style7">Telefono</div></td>
            <td width="150" bgcolor="#000033" class="style3"><div align="center" class="style7">Email</div></td>
          </tr>
          <?php do { ?>
            <tr>
              <td class="style3 style19"><?php echo $row_avales['nombre_aval']; ?></td>
            <td class="style3 style19"><?php echo $row_avales['rfc_aval']; ?></td>
            <td class="style3 style19"><?php echo $row_avales['domicilio_aval']; ?></td>
            <td class="style3 style19"><?php echo $row_avales['ciudad_aval']; ?></td>
            <td class="style3 style19"><?php echo $row_avales['tel_aval']; ?></td>
            <td class="style3 style19"><?php echo $row_avales['email_aval']; ?></td>
          </tr>
<?php } while ($row_avales = mysql_fetch_assoc($avales)); ?>
        </table>
        <table width="1000">
          <tr>
            <td width="0" bgcolor="#000033"><div align="center" class="style8">Nombre Referencia</div></td>
            <td width="60" bgcolor="#000033"><div align="center" class="style8">RFC</div></td>
            <td width="200" bgcolor="#000033"><div align="center" class="style8">Domicilio</div></td>
            <td width="70" bgcolor="#000033"><div align="center" class="style8">Ciudad</div></td>
            <td width="120" bgcolor="#000033"><div align="center" class="style8">Telefono</div></td>
            <td width="150" bgcolor="#000033"><div align="center" class="style8">Email</div></td>
          </tr>
          <?php do { ?>
          <tr>
            <td class="style3 style19"><?php echo $row_referencias['nombre_referencia']; ?></td>
            <td class="style3 style19"><?php echo $row_referencias['rfc_referencia']; ?></td>
            <td class="style3 style19"><?php echo $row_referencias['domicilio_referencia']; ?></td>
            <td class="style3 style19"><?php echo $row_referencias['ciudad_referencia']; ?></td>
            <td class="style3 style19"><?php echo $row_referencias['tel_referencia']; ?></td>
            <td class="style3 style19"><?php echo $row_referencias['email_referencia']; ?></td>
          </tr>
<?php } while ($row_referencias = mysql_fetch_assoc($referencias)); ?>
      </table>        </td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#000000" class="style16"><div align="center">Informacion de Automoviles</div></td>
    </tr>
    <tr>
      <td colspan="4"><span class="style18"><span class="style3">Auto:</span>
          <select name="clave_inv" class="style3" id="clave_inv" onchange="this.form.submit()">
            <option value="0" <?php if (!(strcmp(0, $_GET['clave_inv']))) {echo "selected=\"selected\"";} ?>>Selecciona un auto</option>
            <?php
do {  
?>
            <option value="<?php echo $row_autos['clave_inv']?>"<?php if (!(strcmp($row_autos['clave_inv'], $_GET['clave_inv']))) {echo "selected=\"selected\"";} ?>><?php echo $row_autos['datos_autos']?></option>
<?php
} while ($row_autos = mysql_fetch_assoc($autos));
  $rows = mysql_num_rows($autos);
  if($rows > 0) {
      mysql_data_seek($autos, 0);
	  $row_autos = mysql_fetch_assoc($autos);
  }
?>
          </select>
      Fecha de Entrega: 
      <input name="fecha_entrega" type="text" class="style3" id="fecha_entrega" dir="rtl" value="<?php echo $_GET['fecha_entrega']; ?>" size="11" />
      <button class="style3" id="trigger3">...</button>
      </span>
        <p class="style3 style10 style19">
          <?php 
							if ($recordID6>0) {
	  						echo $row_autos_datos['marca']." ".$row_autos_datos['modelo']." ".$row_autos_datos['ano'].", ";
							echo "Motor: ".$row_autos_datos['motor'].", ".$row_autos_datos['puertas']." puertas. ";
							echo "Millas: ".$row_autos_datos['km'].", ";
							echo "No. Serie: ".$row_autos_datos['serie'].", Pedimento: ".$row_autos_datos['pedimento']."<BR>";
							echo "Especificaciones del auto: ".$row_autos_datos['especificaciones'];
							}
	   					 ?>
        </p>
      <p class="style3 style10 style19"><span class="style1"><span class="style3">Aspecto Mécanico
            <input name="aspecto_mec" type="text" class="style3" id="aspecto_mec" value="<?php echo $_GET['aspecto_mec'];  ?>" size="15" />
Aspecto Carrocería
<input name="aspecto_car" type="text" class="style3" id="aspecto_car" value="<?php echo $_GET['aspecto_car'];  ?>" size="15" />
      </span></span> Aspecto llantas <span class="style3">
      <input name="aspecto_llantas" type="text" class="style3" id="aspecto_llantas" value="<?php echo $_GET['aspecto_llantas'];  ?>" size="15" />
      </span> Otros Aspectos <span class="style3">
      <input name="otros_aspectos" type="text" class="style3" id="otros_aspectos" value="<?php echo $_GET['otros_aspectos'];  ?>" size="15" />
      </span> Aspecto Otros <span class="style3">
      <input name="aspecto_otros" type="text" class="style3" id="aspecto_otros" value="<?php echo $_GET['aspecto_otros'];  ?>" size="15" />
      </span></p>
      <p class="style3 style10 style19">Garantia en las siguientes partes <span class="style3">
        <input name="partes_garantia" type="text" class="style3" id="partes_garantia" value="<?php echo $_GET['partes_garantia'];  ?>" size="50" />
      </span></p>
      <table width="693" border="1">
        <tr>
          <td colspan="2"><div align="center"><span class="style3">Exteriores</span></div></td>
          <td colspan="2"><div align="center"><span class="style3">Interiores</span></div></td>
          <td colspan="2"><div align="center"><span class="style3">Accesorios</span></div></td>
        </tr>
        <tr>
          <td width="204"><span class="style3">Unidad de luces</span></td>
          <td width="24"><span class="style3">
            <label>
            <input <?php if (!(strcmp($_GET['u_luces'],1))) {echo "checked=\"checked\"";} ?> name="u_luces" type="checkbox" id="u_luces" checked="checked" />
            </label>
          </span></td>
          <td width="204"><span class="style3">Instrumento de tablero</span></td>
          <td width="24"><label>
            <input <?php if (!(strcmp($_GET['tablero'],1))) {echo "checked=\"checked\"";} ?> name="tablero" type="checkbox" id="tablero" checked="checked" />
          </label></td>
          <td width="204"><span class="style3">Gato</span></td>
          <td width="24"><label>
            <input <?php if (!(strcmp($_GET['gato'],1))) {echo "checked=\"checked\"";} ?> name="gato" type="checkbox" id="gato" checked="checked" />
          </label></td>
        </tr>
        <tr>
          <td><span class="style3">Luces</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['luces'],1))) {echo "checked=\"checked\"";} ?> name="luces" type="checkbox" id="luces" checked="checked" />
          </label></td>
          <td><span class="style3">Calefaccion</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['calefaccion'],1))) {echo "checked=\"checked\"";} ?> name="calefaccion" type="checkbox" id="calefaccion" checked="checked" />
          </label></td>
          <td><span class="style3">Llave de tuercas</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['cruceta'],1))) {echo "checked=\"checked\"";} ?> name="cruceta" type="checkbox" id="cruceta" checked="checked" />
          </label></td>
        </tr>
        <tr>
          <td><span class="style3">Antena</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['antena'],1))) {echo "checked=\"checked\"";} ?> name="antena" type="checkbox" id="antena" checked="checked" />
          </label></td>
          <td><span class="style3">Aire acondicionado</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['aire'],1))) {echo "checked=\"checked\"";} ?> name="aire" type="checkbox" id="aire" checked="checked" />
          </label></td>
          <td><span class="style3">Llanta de refaccion</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['llanta_refa'],1))) {echo "checked=\"checked\"";} ?> name="llanta_refa" type="checkbox" id="llanta_refa" checked="checked" />
          </label></td>
        </tr>
        <tr>
          <td><span class="style3">Espejos laterales</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['espejos'],1))) {echo "checked=\"checked\"";} ?> name="espejos" type="checkbox" id="espejos" checked="checked" />
          </label></td>
          <td><span class="style3">Limpiadores (plumas)</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['limpiadores'],1))) {echo "checked=\"checked\"";} ?> name="limpiadores" type="checkbox" id="limpiadores" checked="checked" />
          </label></td>
          <td><span class="style3">Estuche de herramientas</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['estuche_he'],1))) {echo "checked=\"checked\"";} ?> name="estuche_he" type="checkbox" id="estuche_he" checked="checked" />
          </label></td>
        </tr>
        <tr>
          <td><span class="style3">Cristales en buen estado</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['cristales'],1))) {echo "checked=\"checked\"";} ?> name="cristales" type="checkbox" id="cristales" checked="checked" />
          </label></td>
          <td><span class="style3">Radio</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['radio'],1))) {echo "checked=\"checked\"";} ?> name="radio" type="checkbox" id="radio" checked="checked" />
          </label></td>
          <td><span class="style3">Triangulo de seguridad</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['triangulo'],1))) {echo "checked=\"checked\"";} ?> name="triangulo" type="checkbox" id="triangulo" checked="checked" />
          </label></td>
        </tr>
        <tr>
          <td><span class="style3">Tapones de rueda</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['tapones'],1))) {echo "checked=\"checked\"";} ?> name="tapones" type="checkbox" id="tapones" checked="checked" />
          </label></td>
          <td><span class="style3">Bocinas</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['bocinas'],1))) {echo "checked=\"checked\"";} ?> name="bocinas" type="checkbox" id="bocinas" checked="checked" />
          </label></td>
          <td><span class="style3">Extinguidor
            
          </span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['extinguidor'],1))) {echo "checked=\"checked\"";} ?> name="extinguidor" type="checkbox" id="extinguidor" checked="checked" />
          </label></td>
        </tr>
        <tr>
          <td><span class="style3">Molduras completas</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['molduras'],1))) {echo "checked=\"checked\"";} ?> name="molduras" type="checkbox" id="molduras" checked="checked" />
          </label></td>
          <td><span class="style3">Espejo retrovisor</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['retrovisor'],1))) {echo "checked=\"checked\"";} ?> name="retrovisor" type="checkbox" id="retrovisor" checked="checked" />
          </label></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><span class="style3">Tapon de gasolina</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['tapon_gas'],1))) {echo "checked=\"checked\"";} ?> name="tapon_gas" type="checkbox" id="tapon_gas" checked="checked" />
          </label></td>
          <td><span class="style3">Ceniceros</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['ceniceros'],1))) {echo "checked=\"checked\"";} ?> name="ceniceros" type="checkbox" id="ceniceros" checked="checked" />
          </label></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><span class="style3">Carroceria sin golpes</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['carroceria_sin_golpes'],1))) {echo "checked=\"checked\"";} ?> name="carroceria_sin_golpes" type="checkbox" id="carroceria_sin_golpes" checked="checked" />
          </label></td>
          <td><span class="style3">Cinturones de seguridad</span></td>
          <td><label>
            <input <?php if (!(strcmp($_GET['cinturones'],1))) {echo "checked=\"checked\"";} ?> name="cinturones" type="checkbox" id="cinturones" checked="checked" />
          </label></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>      
      <p class="style3 style10 style19">&nbsp;</p></td>
    </tr>
    <tr>
      <td colspan="4" class="style1"><p><span class="style3">¿Entrego vehiculo a cambio?
            <input name="acuenta" type="checkbox" class="style3" id="acuenta" onclick="JavaScript:document.forma_general.clave_inv_acuenta.disabled = !this.checked" value="1" <?php if (!(strcmp($_GET['acuenta'],1))) {echo "checked=\"checked\"";} ?> />
      </span>Vehiculo a cambio:
        <select name="clave_inv_acuenta" class="style3" id="clave_inv_acuenta" onchange="this.form.submit()">
          <option value="0" <?php if (!(strcmp(0, $_GET['clave_inv_acuenta']))) {echo "selected=\"selected\"";} ?>>Selecciona un auto</option>
          <?php
do {  
?>
          <option value="<?php echo $row_autos_acambio['clave_inv']?>"<?php if (!(strcmp($row_autos_acambio['clave_inv'], $_GET['clave_inv_acuenta']))) {echo "selected=\"selected\"";} ?>><?php echo $row_autos_acambio['datos_autos']?></option>
          <?php
} while ($row_autos_acambio = mysql_fetch_assoc($autos_acambio));
  $rows = mysql_num_rows($autos_acambio);
  if($rows > 0) {
      mysql_data_seek($autos_acambio, 0);
	  $row_autos_acambio = mysql_fetch_assoc($autos_acambio);
  }
?>
        </select>
      </p>
        <p>          <span class="style18">
          <?php 
		if ($recordID8>0) {
		echo $row_autos_acambio_datos['marca']." ".$row_autos_acambio_datos['modelo']." ".$row_autosacambio__datos['ano'].", ";
		echo "Motor: ".$row_autos_acambio_datos['motor'].", ".$row_autos_acambio_datos['puertas']." puertas. ";
		echo "Millas: ".$row_autos_acambio_datos['km'].", ";
		echo "No. Serie: ".$row_autos_acambio_datos['serie'].", Pedimento: ".$row_autos_acambio_datos['pedimento']."<BR>";
		echo "Especificaciones del auto: ".$row_autos_acambio_datos['especificaciones'];
		}
	    ?>
      </span> </p></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#000000" class="style16"><div align="center">Formas de Pago y Financiamiento</div></td>
    </tr>
    <tr>
      <td class="style3">Forma de Pago      </td>
      <td><span class="style3">
        <input name="forma_pago" type="text" class="style3" id="forma_pago" value="<?php echo $_GET['forma_pago'];  ?>" size="50" />
      </span></td>
      <td colspan="2" rowspan="7" valign="top" class="style3"><table width="472" border="0">
        <tr>
          <td width="122" bgcolor="#000033"><span class="style8">Precio</span></td>
          <td width="132"><input name="cprecio" type="text" class="style3" id="cprecio" dir="rtl" onfocus="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onblur="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onselect="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onchange="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onclick="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" value="<?php echo $_GET['cprecio'];  ?>" size="15" /></td>
          <td colspan="2" bgcolor="#000033"><div align="center"><span class="style8">Pago de contado o enganche</span></div></td>
          </tr>
        <tr>
          <td bgcolor="#000033"><span class="style8">(-) Enganche</span></td>
          <td><input name="cenganche" type="text" class="style3" id="cenganche" dir="rtl" onfocus="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onblur="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onselect="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onchange="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onclick="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" value="<?php echo $_GET['cenganche'];  ?>" size="15" <?php if ($recordID12==2 ) {echo "disabled";} else {echo "enabled";}?>/></td>
          <td width="98" bgcolor="#000033" class="style8">Efectivo</td>
          <td width="100"><input name="cefectivo" type="text" class="style3" id="cefectivo" dir="rtl" value="<?php echo $_GET['cefectivo'];  ?>" size="15" /></td>
        </tr>
        <tr>
          <td bgcolor="#000033"><span class="style8">(-) Unidad a Cuenta</span></td>
          <td><input name="cacuenta" type="text" class="style3" id="cacuenta" dir="rtl" onfocus="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onblur="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onselect="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onchange="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onclick="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" value="<?php echo $_GET['cacuenta'];  ?>" size="15" /></td>
          <td bgcolor="#000033" class="style8">Cheque</td>
          <td><input name="ccheque" type="text" class="style3" id="ccheque" dir="rtl" value="<?php echo $_GET['ccheque'];  ?>" size="15" /></td>
        </tr>
        <tr>
          <td bgcolor="#000033"><span class="style8">Saldo inicial</span></td>
          <td><input name="saldo_inicial" type="text" class="style3" id="saldo_inicial" dir="rtl" onfocus="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onblur="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onselect="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onchange="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onclick="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" value="<?php echo $_GET['saldo_inicial'];  ?>" size="15" /></td>
          <td bgcolor="#000033" class="style8">No. Cheque</td>
          <td><input name="no_cheque" type="text" class="style3" id="no_cheque" dir="rtl" value="<?php echo $_GET['no_cheque'];  ?>" size="15" /></td>
        </tr>
        <tr>
          <td bgcolor="#000033"><span class="style8">(+) Intereses</span></td>
          <td><input name="cinteres" type="text" class="style3" id="cinteres" dir="rtl" onfocus="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onblur="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onselect="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onchange="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onclick="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" ondblclick="actualiza_interes(this)" value="<?php echo $_GET['cinteres'];  ?>" size="15" <?php if ($recordID12==2 ) {echo "disabled";} else {echo "enabled";}?>/></td>
          <td bgcolor="#000033"><span class="style8">Banco</span></td>
          <td><input name="banco_cheque" type="text" class="style3" id="banco_cheque" value="<?php echo $_GET['banco_cheque'];  ?>" size="15" /></td>
        </tr>
        <tr>
          <td bgcolor="#000033"><span class="style8">(+) IVA</span></td>
          <td><input name="civa" type="text" class="style3" id="civa" dir="rtl" onfocus="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onblur="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onselect="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onchange="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onclick="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" value="<?php echo $_GET['civa'];  ?>" size="15" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#000033"><span class="style8">Total</span></td>
          <td><input name="ctotal" type="text" class="style3" id="ctotal" dir="rtl" onfocus="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onblur="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onselect="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onchange="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onclick="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" value="<?php echo $_GET['ctotal'];  ?>" size="15" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><span class="style3">Promoción</span></td>
      <td width="308"><span class="style3">
        <input name="promocion" type="text" class="style3" id="promocion" value="<?php echo $_GET['promocion'];  ?>" size="50" />
      </span></td>
    </tr>
    <tr>
      <td class="style3">Número de pagos</td>
      <td><input name="no_pagos" type="text" class="style3" id="no_pagos" dir="rtl" value="<?php echo $_GET['no_pagos']; ?>" size="5" <?php if ($recordID12==2 ) {echo "disabled";} else {echo "enabled";}?>/></td>
    </tr>
    <tr>
      <td class="style3">Tasa de interes</td>
      <td><input name="interes" type="text" class="style3" id="interes" dir="rtl" onfocus="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onblur="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onselect="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onchange="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" onclick="actualiza_saldo_inicial(this);
actualiza_interes(this);
actualiza_iva(this);
actualiza_total(this);" value="<?php  echo $_GET['interes'];  ?>" size="5" <?php if ($recordID12==2 ) {echo "disabled";} else {echo "enabled";}?>/></td>
    </tr>
    <tr>
      <td class="style3">Interes moratorio</td>
      <td><input name="moratorio" type="text" class="style3" id="moratorio" dir="rtl" value="<?php echo $_GET['moratorio']; ?>" size="5" <?php if ($recordID12==2 ) {echo "disabled";} else {echo "enabled";}?>/></td>
    </tr>
    <tr>
      <td><span class="style3">Moneda</span></td>
      <td><label></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#000000" class="style6"><div align="center" class="style16">Personal involucrado en la venta.</div></td>
    </tr>
    <tr>
      <td class="style3">Vendedor</td>
      <td colspan="3"><select name="clave_vendedor" class="style3" id="clave_vendedor" onchange="this.form.submit()">
          <option value="0" <?php if (!(strcmp(0, $_GET['clave_vendedor']))) {echo "selected=\"selected\"";} ?>>Seleccion un Vendedor</option>
          <?php
do {  
?><option value="<?php echo $row_vendedor['clave_vendedor']?>"<?php if (!(strcmp($row_vendedor['clave_vendedor'], $_GET['clave_vendedor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_vendedor['nombre_vendedor']?></option>
          <?php
} while ($row_vendedor = mysql_fetch_assoc($vendedor));
  $rows = mysql_num_rows($vendedor);
  if($rows > 0) {
      mysql_data_seek($vendedor, 0);
	  $row_vendedor = mysql_fetch_assoc($vendedor);
  }
?>
      </select>        <span class="style18">
        <?php 
		if ($recordID9>0) {
	  $fx="<BR>";
	  $em="<BR>";
	  if (strlen($row_vendedor_datos['fax_vendedor'])>0){$fx=", Fax ".$row_vendedor_datos['fax_vendedor'];}
	  if (strlen($row_vendedor_datos['email_vendedor'])>0){$em=", email ".$row_vendedor_datos['email_vendedor']."<BR>";}	  
	  echo $row_vendedor_datos['domicilio_vendedor'].", C.P. ".$row_vendedor_datos['cp_vendedor'].", ".$row_vendedor_datos['ciudad_vendedor'].", Telefono(s) ".$row_vendedor_datos['tel_vendedor'].$fx.$em; 
	  }
	  ?>
        </span></td>
    </tr>
    <tr>
      <td><span class="style3">Cobrador</span></td>
      <td colspan="3"><select name="clave_cobrador" class="style3" id="clave_cobrador" onchange="this.form.submit()">
        <option value="0" <?php if (!(strcmp(0, $_GET['clave_cobrador']))) {echo "selected=\"selected\"";} ?>>Seleccion un Vendedor</option>
        <?php
do {  
?>
        <option value="<?php echo $row_cobrador['clave_cobrador']?>"<?php if (!(strcmp($row_cobrador['clave_cobrador'], $_GET['clave_cobrador']))) {echo "selected=\"selected\"";} ?>><?php echo $row_cobrador['nombre_cobrador']?></option>
        <?php
} while ($row_cobrador = mysql_fetch_assoc($cobrador));
  $rows = mysql_num_rows($cobrador);
  if($rows > 0) {
      mysql_data_seek($cobrador, 0);
	  $row_cobrador = mysql_fetch_assoc($cobrador);
  }
?>
      </select>        <span class="style18">
        <?php 
		if ($recordID10>0) {
	  $fx="<BR>";
	  $em="<BR>";
	  if (strlen($row_cobrador_datos['fax_cobrador'])>0){$fx=", Fax ".$row_cobrador_datos['fax_cobrador'];}
	  if (strlen($row_cobrador_datos['email_cobrador'])>0){$em=", email ".$row_cobrador_datos['email_cobrador']."<BR>";}	  
	  echo $row_cobrador_datos['domicilio_cobrador'].", C.P. ".$row_cobrador_datos['cp_cobrador'].", ".$row_cobrador_datos['ciudad_cobrador'].", Telefono(s) ".$row_cobrador_datos['tel_cobrador'].$fx.$em; 
	  }
	  ?>
        </span></td>
    </tr>
    <tr>
      <td><span class="style3">Testigo</span></td>
      <td colspan="3"><select name="clave_testigo" class="style3" id="clave_testigo" onchange="this.form.submit()">
        <option value="0" <?php if (!(strcmp(0, $_GET['clave_testigo']))) {echo "selected=\"selected\"";} ?>>Seleccion un Vendedor</option>
        <?php
do {  
?>
        <option value="<?php echo $row_testigo['clave_testigo']?>"<?php if (!(strcmp($row_testigo['clave_testigo'], $_GET['clave_testigo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_testigo['nombre_testigo']?></option>
        <?php
} while ($row_testigo = mysql_fetch_assoc($testigo));
  $rows = mysql_num_rows($testigo);
  if($rows > 0) {
      mysql_data_seek($testigo, 0);
	  $row_testigo = mysql_fetch_assoc($testigo);
  }
?>
      </select>        <span class="style18">
      <?php 
	  if ($recordID11>0) {
	  $fx="<BR>";
	  $em="<BR>";
	  if (strlen($row_testigo_datos['fax_testigo'])>0){$fx=", Fax ".$row_testigo_datos['fax_testigo'];}
	  if (strlen($row_testigo_datos['email_testigo'])>0){$em=", email ".$row_testigo_datos['email_testigo']."<BR>";}	  
	  echo $row_testigo_datos['domicilio_testigo'].", C.P. ".$row_testigo_datos['cp_testigo'].", ".$row_testigo_datos['ciudad_testigo'].", Telefono(s) ".$row_testigo_datos['tel_testigo'].$fx.$em; 
	  }
	  ?>
        </span></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#00CCFF"><span class="Texto_tabla">
        <input name="Grabar" type="submit" class="style3" value="Grabar" <?php if ($recordID > 0 ) {echo "disabled";} else {echo "enabled";}?> />
        <input name="Editar" type="submit" class="style3" value="Editar" <?php if ($recordID > 0 ) {echo "enabled";} else {echo "disabled";}?> />
        <input name="Borrar" type="submit" class="style3" value="Borrar" <?php if ($recordID > 0 ) {if ($cantidad_registros >= 1 ) {echo "disabled";} else {echo "enabled";}} else {echo "disabled";}?> />
        <input name="Cancelar" type="submit" class="style3" id="Cancelar" value="Cancelar" />
      </span><span class="style3 Encabezado_tabla style5">
      <input type="hidden" name="MM_insert" value="forma_general" />
      <input type="hidden" name="MM_update" value="form2" />
      <span class="Texto_tabla">
      <input name="Aplicar" type="submit" class="style3" id="Aplicar" value="Aplicar" />
      <a href="imp_contrato.php?parametro1=<?php echo $row_contratos['clave_contrato']; ?>">Imprimir contrato</a></span></span></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_garantia",      // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    true,            // will display a time selector
        button         :    "trigger",   // trigger for the calendar (button ID)
        singleClick    :    false,           // double-click mode
        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
    });
</script>

<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_contrato",      // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    true,            // will display a time selector
        button         :    "trigger2",   // trigger for the calendar (button ID)
        singleClick    :    false,           // double-click mode
        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
    });
</script>

<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_entrega",      // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    true,            // will display a time selector
        button         :    "trigger3",   // trigger for the calendar (button ID)
        singleClick    :    false,           // double-click mode
        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
    });
</script>

<p>&nbsp; </p>

<p>&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($clientes);

mysql_free_result($autos);

mysql_free_result($autos_acambio);

mysql_free_result($avales);

mysql_free_result($referencias);

mysql_free_result($vendedor);

mysql_free_result($cobrador);

mysql_free_result($testigo);

mysql_free_result($contratos);

mysql_free_result($empresa);

mysql_free_result($autos_datos);

mysql_free_result($autos_acambio_datos);

mysql_free_result($cliente_datos);

mysql_free_result($vendedor_datos);

mysql_free_result($cobrador_datos);

mysql_free_result($testigo_datos);
?>
