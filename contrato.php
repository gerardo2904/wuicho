<?php 
require_once('Connections/contratos_londres.php'); 
require_once('Funciones/funciones.php');

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

/**
 * @example truncate(-1.49999, 2); // returns -1.49
 * @example truncate(.49999, 3); // returns 0.499
 * @param float $val
 * @param int f
 * @return float
 */
function truncate($val, $f="0")
{
    if(($p = strpos($val, '.')) !== false) {
        $val = floatval(substr($val, 0, $p + 1 + $f));
    }
    return $val;
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

funciones_reemplazadas();


//funcion que suma dias a una fecha
/*function suma_fechas($fecha,$ndias)
            
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$año)=split("/", $fecha);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$año)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
            
}*/

//echo $_SESSION['MM_UserId']."-> ".$_SESSION['MM_Username']."<BR>";
$numero_parametros = count($_GET);

//echo "numero de parametros: ".$numero_parametros."<BR>";

$recordID=$_GET['parametro1'];
//$recordID0=$_SESSION['MM_Empresa'];
$recordID0=$_GET['clave_empresa'];
$recordID1=$_GET['contrato'];
$recordID2=$_GET['fecha_contrato'];
$recordID3=$_GET['clave_cliente'];
$recordID4=$_GET['equipo'];				
$recordID5=$_GET['modelo'];				
$recordID6=$_GET['serie'];					
$recordID7=$_GET['fecha_reporte'];	
$recordID8=$_GET['reporto'];		
$recordID9=$_GET['clave_vendedor'];
$recordID10=$_GET['visita_no'];				
$recordID11=$_GET['falla'];						
$recordID12=$_GET['contacto'];					
$recordID13=$_GET['fecha_inicio'];			
$recordID14=$_GET['fecha_fin'];				
$recordID15=$_GET['svc_terminado'];		
$recordID16=$_GET['reporte_ingeniero'];
$recordID17=$_GET['solucion'];					


if ((!isset($_GET['accion']) && $numero_parametros==0) ||  $numero_parametros==0) 
{
	$_GET['accion']="N";$recordID63=$_GET['accion'];
}

if (($numero_parametros==1 && $recordID>0 && !isset($_GET['accion'])) || ($numero_parametros==1 && $recordID>0)) 
{
	$_GET['accion']="E";$recordID63=$_GET['accion'];
}



if ($recordID1<>0 || $recordID<>0)
{
	mysqli_select_db($contratos_londres, $database_contratos_londres);
	if ($recordID<>0) {
		$query_veraplica = "select * from contrato WHERE clave_contrato=".$recordID;
	}
	else
	{
		$query_veraplica = "select * from contrato WHERE contrato=".$recordID1;
	}

	$veraplica = mysqli_query($contratos_londres, $query_veraplica) or die(mysqli_error($contratos_londres));
	$row_veraplica = mysqli_fetch_assoc($veraplica);
	$totalRows_veraplica = mysqli_num_rows($veraplica);
	
	if ($row_veraplica['aplicado']==1) {
		$_GET['accion']="A";$recordID63=$_GET['accion'];
	}
	mysqli_free_result($veraplica);
	
}

$recordID63=$_GET['accion'];

$recordID62=$_GET['clave_contrato'];



$var="";
if ($numero_parametros==1 AND $recordID>0) {
	$var=" where clave_contrato='$recordID'";
}
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_contratos = "select * from contrato".$var;
$contratos = mysqli_query($contratos_londres, $query_contratos) or die(mysqli_error($contratos_londres));
$row_contratos = mysqli_fetch_assoc($contratos);
$totalRows_contratos = mysqli_num_rows($contratos);

if ($numero_parametros==1 AND $recordID>0) {
	//$recordID61="E";
	//$_GET['accion']=$recordID61;
	$recordID0=$row_contratos['clave_empresa'];				$_GET['clave_empresa']=$recordID0;
	$recordID1=$row_contratos['contrato'];						$_GET['contrato']=$recordID1;
	$recordID2=$row_contratos['fecha_contrato'];			$_GET['fecha_contrato']=$recordID2;
	$recordID3=$row_contratos['clave_cliente'];				$_GET['clave_cliente']=$recordID3;
	$recordID4=$row_contratos['equipo'];							$_GET['equipo']=$recordID4;
	$recordID5=$row_contratos['modelo'];							$_GET['modelo']=$recordID5;
	$recordID6=$row_contratos['serie'];								$_GET['serie']=$recordID6;
	$recordID7=$row_contratos['fecha_reporte'];				$_GET['fecha_reporte']=$recordID7;
	$recordID8=$row_contratos['reporto'];							$_GET['reporto']=$recordID8;
	$recordID9=$row_contratos['clave_vendedor'];			$_GET['clave_vendedor']=$recordID9;
	$recordID10=$row_contratos['visita_no'];					$_GET['visita_no']=$recordID10;	
	$recordID11=$row_contratos['falla'];							$_GET['falla']=$recordID11;	
	$recordID12=$row_contratos['contacto'];						$_GET['contacto']=$recordID12;	
	$recordID13=$row_contratos['fecha_inicio'];				$_GET['fecha_inicio']=$recordID13;
	$recordID14=$row_contratos['fecha_fin'];					$_GET['fecha_fin']=$recordID14;		
	$recordID15=$row_contratos['svc_terminado'];			$_GET['svc_terminado']=$recordID15;	
	$recordID16=$row_contratos['reporte_ingeniero'];	$_GET['reporte_ingeniero']=$recordID16;	
	$recordID17=$row_contratos['solucion'];						$_GET['solucion']=$recordID17;	

	if (!isset($_GET['clave_contrato'])) {
		$_GET['clave_contrato']=$row_contratos['clave_contrato'];
	}

	$recordID62=$_GET['clave_contrato'];  
	
} 
else {
       if (strlen($recordID2)==0)
			   {
			   	$recordID2=date('d-m-Y');
					$_GET['fecha_contrato']=date('d-m-Y');	
			   }

			   if (strlen($recordID7)==0)
			   {
			   	$recordID7=date('d-m-Y');
					$_GET['fecha_reporte']=date('d-m-Y');					
			   }

			   if (strlen($recordID13)==0)
			   {
			   	$recordID13=date('d-m-Y');
					$_GET['fecha_inicio']=date('d-m-Y');					
			   }

			   if (strlen($recordID14)==0)
			   {
			   	$recordID14=date('d-m-Y');
					$_GET['fecha_fin']=date('d-m-Y');					
			   }

     /*  if (strlen($recordID5)==0)
	   {
	   		//$recordID5=date('d-m-Y');
			$recordID5=suma_fechas($recordID2, 61);
			//$_GET['fecha_garantia']=date('d-m-Y');
			$_GET['fecha_garantia']=suma_fechas($recordID2, 61);
			
	   }  */

}

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_clientes = "SELECT * FROM clientes ORDER BY clave_cliente, nombre_cliente ASC";
$clientes = mysqli_query($contratos_londres, $query_clientes) or die(mysqli_error($contratos_londres));
$row_clientes = mysqli_fetch_assoc($clientes);
$totalRows_clientes = mysqli_num_rows($clientes);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_vendedor = "select * from vendedores order by nombre_vendedor ASC";
$vendedor = mysqli_query($contratos_londres, $query_vendedor) or die(mysqli_error($contratos_londres));
$row_vendedor = mysqli_fetch_assoc($vendedor);
$totalRows_vendedor = mysqli_num_rows($vendedor);

$var="";
if ($recordID0<>0) { $var=" where clave_empresa='$recordID0'";} else { $var=" where clave_empresa=0";}
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_empresa = "select * from empresa".$var;
$empresa = mysqli_query($contratos_londres, $query_empresa) or die(mysqli_error($contratos_londres));
$row_empresa = mysqli_fetch_assoc($empresa);
$totalRows_empresa = mysqli_num_rows($empresa);

$var="";
if ($recordID3<>0) { $var=" where clave_cliente='$recordID3'";} else { $var=" where clave_cliente=0";}
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_cliente_datos = "select * from clientes".$var;
$cliente_datos = mysqli_query($contratos_londres, $query_cliente_datos) or die(mysqli_error($contratos_londres));
$row_cliente_datos = mysqli_fetch_assoc($cliente_datos);
$totalRows_cliente_datos = mysqli_num_rows($cliente_datos);

$var="";
if ($recordID9<>0) { $var=" where clave_vendedor='$recordID9'";} else { $var=" where clave_vendedor=0";}
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_vendedor_datos = "select * from vendedores".$var;
$vendedor_datos = mysqli_query($contratos_londres, $query_vendedor_datos) or die(mysqli_error($contratos_londres));
$row_vendedor_datos = mysqli_fetch_assoc($vendedor_datos);
$totalRows_vendedor_datos = mysqli_num_rows($vendedor_datos);


mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_empresas = "select * from empresa where activo_empresa=1;";
$empresas = mysqli_query($contratos_londres, $query_empresas) or die(mysqli_error($contratos_londres));
$row_empresas = mysqli_fetch_assoc($empresas);
$totalRows_empresas = mysqli_num_rows($empresas);


$varcont=$recordID;	

//echo "recordid= ".$recordID."<BR>"." Clave_contrato= ".$_GET['clave_contrato'];
if ($_GET['clave_contrato']<>0)
{
	$varcont=$_GET['clave_contrato'];	
}else{
	$varcont=0;
}

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_refacciones = "select * from refacciones where clave_contrato=$varcont;";
$refacciones = mysqli_query($contratos_londres, $query_refacciones) or die(mysqli_error($contratos_londres));
$row_refacciones = mysqli_fetch_assoc($refacciones);
$totalRows_refacciones = mysqli_num_rows($refacciones);


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
  $colname_verifica = $_GET['contrato'];
}

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_verifica = sprintf("SELECT * FROM contrato WHERE contrato = %s", GetSQLValueString($colname_verifica, "text"));
$verifica = mysqli_query($contratos_londres, $query_verifica) or die(mysqli_error($contratos_londres));
$row_verifica = mysqli_fetch_assoc($verifica);
$totalRows_verifica = mysqli_num_rows($verifica);
mysqli_free_result($verifica);


//************************
if (($totalRows_verifica > 0) || ($_GET['clave_empresa']==0))  {
//echo "El Contrato que se capturo esta repetido y esto no es posible.  Por favor oprima el boton atras para modificar el Contrato o para cancelar.";exit;
if ($totalRows_verifica > 0) { $mensaje="La orden de trabajo que se capturo esta repetido. "; }


if ($_GET['clave_empresa']==0) {$mensaje=$mensaje."Tienes que capturar la empresa.";}

echo "<script language='javascript'> var $mensaje = <?php echo '$mensaje'; ?>; </script> ";
echo "<script language='javascript'> alert('$mensaje'); </script> ";

}
else {

$dia=substr($_GET['fecha_contrato'],0,2);
$mes=substr($_GET['fecha_contrato'],3,2);
$ano=substr($_GET['fecha_contrato'],6,4);
$fechaC=$ano."-".$mes."-".$dia;

$dia=substr($_GET['fecha_reporte'],0,2);
$mes=substr($_GET['fecha_reporte'],3,2);
$ano=substr($_GET['fecha_reporte'],6,4);
$fechaR=$ano."-".$mes."-".$dia;

$dia=substr($_GET['fecha_inicio'],0,2);
$mes=substr($_GET['fecha_inicio'],3,2);
$ano=substr($_GET['fecha_inicio'],6,4);
$fechaI=$ano."-".$mes."-".$dia;

$dia=substr($_GET['fecha_fin'],0,2);
$mes=substr($_GET['fecha_fin'],3,2);
$ano=substr($_GET['fecha_fin'],6,4);
$fechaF=$ano."-".$mes."-".$dia;



 $insertSQL = sprintf("INSERT INTO contrato (contrato, clave_empresa, clave_cliente, fecha_contrato, clave_vendedor, fecha_reporte, equipo, modelo, serie, reporto, clave_contrato, visita_no, falla, contacto, fecha_inicio, fecha_fin, svc_terminado, reporte_ingeniero, solucion, clave_usuario) VALUES (%s ,%s , %s, %s,%s , %s, %s, %s ,%s , %s, %s, %s , %s, %s, %s, %s, %s, %s, %s, %s)", 
 GetSQLValueString($_GET['contrato'], "text"),
 GetSQLValueString(/*$recordID0*/$_GET['clave_empresa'], "text"),
 GetSQLValueString($_GET['clave_cliente'], "text"),
 GetSQLValueString($fechaC, "date"),                                                                          
 GetSQLValueString($_GET['clave_vendedor'], "text"),
 GetSQLValueString($fechaR, "date"),
 GetSQLValueString($_GET['equipo'], "text"),
 GetSQLValueString($_GET['modelo'], "text"),
 GetSQLValueString($_GET['serie'], "text"),
 GetSQLValueString($_GET['reporto'], "text"),
 GetSQLValueString($_GET['clave_contrato'], "text"),
 GetSQLValueString($_GET['visita_no'], "text"),
 GetSQLValueString($_GET['falla'], "text"),
 GetSQLValueString($_GET['contacto'], "text"),
 GetSQLValueString($fechaI, "date"),
 GetSQLValueString($fechaF, "date"),
 GetSQLValueString($_GET['svc_terminado'], "text"),
 GetSQLValueString($_GET['reporte_ingeniero'], "text"),
 GetSQLValueString($_GET['solucion'], "text"),
 GetSQLValueString($_SESSION['MM_UserId'], "text")
 );


  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $insertSQL) or die(mysqli_error($contratos_londres));
  
$var="";
$var=" where contrato='$recordID1'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_ver_contra = "select * from contrato ".$var;
$ver_contra = mysqli_query($contratos_londres, $query_ver_contra) or die(mysqli_error($contratos_londres));
$row_ver_contra = mysqli_fetch_assoc($ver_contra);
$totalRows_ver_contra = mysqli_num_rows($ver_contra);

  $var=$row_ver_contra["clave_contrato"];
  $updateGoTo = "contrato.php?parametro1=$var";
  //echo $updateGoTo;exit;
 /* if (isset($_SERVER['QUERY_STRING'])) {
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
 if ($_GET["Editar"]) {


//************************
if (($_GET['clave_empresa']==0))  {



$mensaje=$mensaje."Tienes que capturar la empresa.";

echo "<script language='javascript'> var $mensaje = <?php echo '$mensaje'; ?>; </script> ";
echo "<script language='javascript'> alert('$mensaje'); </script> ";

}
else {
	$dia=substr($_GET['fecha_contrato'],0,2);
	$mes=substr($_GET['fecha_contrato'],3,2);
	$ano=substr($_GET['fecha_contrato'],6,4);
	$fechaC=$ano."-".$mes."-".$dia;

	$dia=substr($_GET['fecha_reporte'],0,2);
	$mes=substr($_GET['fecha_reporte'],3,2);
	$ano=substr($_GET['fecha_reporte'],6,4);
	$fechaR=$ano."-".$mes."-".$dia;

	$dia=substr($_GET['fecha_inicio'],0,2);
	$mes=substr($_GET['fecha_inicio'],3,2);
	$ano=substr($_GET['fecha_inicio'],6,4);
	$fechaI=$ano."-".$mes."-".$dia;

	$dia=substr($_GET['fecha_fin'],0,2);
	$mes=substr($_GET['fecha_fin'],3,2);
	$ano=substr($_GET['fecha_fin'],6,4);
	$fechaF=$ano."-".$mes."-".$dia;

 
 $updateSQL_principal = sprintf("UPDATE contrato SET contrato=%s, clave_empresa=%s, clave_cliente=%s, fecha_contrato=%s, clave_vendedor=%s, fecha_reporte=%s, equipo=%s, modelo=%s, serie=%s, reporto=%s, visita_no=%s, falla=%s, contacto=%s, fecha_inicio=%s, fecha_fin=%s, svc_terminado=%s, reporte_ingeniero=%s, solucion=%s, clave_usuario=%s  
 	                               WHERE contrato.clave_contrato=".$_GET['clave_contrato'], 
 GetSQLValueString($_GET['contrato'], "text"),
 GetSQLValueString($_GET['clave_empresa'], "text"),
 GetSQLValueString($_GET['clave_cliente'], "text"),                           
 GetSQLValueString($fechaC, "date"),                                                                          
 GetSQLValueString($_GET['clave_vendedor'], "text"),
 GetSQLValueString($fechaR, "date"),
 GetSQLValueString($_GET['equipo'], "text"),
 GetSQLValueString($_GET['modelo'], "text"),
 GetSQLValueString($_GET['serie'], "text"),
 GetSQLValueString($_GET['reporto'], "text"),
 GetSQLValueString($_GET['visita_no'], "text"),
 GetSQLValueString($_GET['falla'], "text"),
 GetSQLValueString($_GET['contacto'], "text"),
GetSQLValueString($fechaI, "date"),
 GetSQLValueString($fechaF, "date"),
 GetSQLValueString($_GET['svc_terminado'], "text"),
 GetSQLValueString($_GET['reporte_ingeniero'], "text"),
 GetSQLValueString($_GET['solucion'], "text"),
 GetSQLValueString($_SESSION['MM_UserId'], "text"));


//  echo "clave contrato: ".$_GET['clave_contrato']."<BR>";
//  echo $updateSQL;
// Actualiza el estado de los Autos.
// si se edito el auto y es diferente, quitarle la marca de reservado al anterior y ponersela al nuevo...


  
// Actualiza el estado de los Autos a cuenta.
// si se edito el auto y es diferente, quitarle la marca de reservado al anterior y ponersela al nuevo...




//echo $updateSQL_principal;
 // se cierra secuancia SQL del update principal a tabla contrato.
  mysqli_select_db($contratos_londres, $database_contratos_londres);
  $Result1 = mysqli_query($contratos_londres, $updateSQL_principal) or die(mysqli_error($contratos_londres));
  

}
}

 if ($_GET["Borrar"]) {
	$tempo1=$_GET['clave_contrato'];
	

	echo "<script language='javascript'> var $tempo1 = <?php echo '$tempo1'; ?>; </script> ";

	echo "<script language='javascript'>
	if(confirm('Seguro que quieres eliminar el registro? ')) 
	{ 
		location.href='borrar_contrato.php?parametro1='+$tempo1; 
	} 
	</script> ";
}

 if ($_GET["Aplicar"]) {
	$tempo1=$_GET['clave_contrato'];
	
	
	echo "<script language='javascript'> var $tempo1 = <?php echo '$tempo1'; ?>; </script> ";
	
	echo "<script language='javascript'>
	if(confirm('Seguro que quieres Aplicar? Si lo haces ya no podras modificar informacion del contrato.')) 
	{ 
		location.href='aplicar_contrato.php?parametro1='+$tempo1; 
	} 
	</script> ";

}
///
 if ($_GET["Cancelar"]) {
  $updateGoTo = "contratos_list.php";
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




 if ($_GET["Imprimir"]) {
 
 $tempo1=$_GET['clave_contrato'];
 $tempo2=$_GET['clave_empresa'];
 $tempo3=$_GET['clave_cliente'];
 
 echo "<script language='javascript'> var $tempo1 = <?php echo '$tempo1'; ?>; </script> ";
 echo "<script language='javascript'> var $tempo2 = <?php echo '$tempo2'; ?>; </script> ";
 echo "<script language='javascript'> var $tempo3 = <?php echo '$tempo3'; ?>; </script> ";
 echo "<script language='javascript'>
 if(confirm('Ver contrato e imprimir?')) 
{ 
location.href='imp_contrato.php?parametro1='+$tempo1+'&parametro2='+$tempo2+'&parametro3='+$tempo3; 
} 
</script> ";

 /*imp_contrato.php?parametro1=<?php echo $row_contratos['clave_contrato']; ?>&amp;parametro2=<?php echo $row_contratos['clave_empresa']; ?>" target="_blank"*/
}

 if ($_GET["Generar"]) {
 //$tempo1=$row_contratos['clave_contrato'];
 //$tempo2=$row_contratos['clave_empresa'];
 
 $tempo1=$_GET['clave_contrato'];
 $tempo2=$_GET['clave_empresa'];
 $tempo3=$_GET['clave_cliente'];
 
 echo "<script language='javascript'> var $tempo1 = <?php echo '$tempo1'; ?>; </script> ";
 echo "<script language='javascript'> var $tempo2 = <?php echo '$tempo2'; ?>; </script> ";
 echo "<script language='javascript'> var $tempo3 = <?php echo '$tempo3'; ?>; </script> ";
 echo "<script language='javascript'>
 if(confirm('Ver Pagares?')) 
{ 
location.href='pagares.php?parametro1='+$tempo1+'&parametro2='+$tempo2+'&parametro3='+$tempo3; 
} 
</script> ";

 /*imp_contrato.php?parametro1=<?php echo $row_contratos['clave_contrato']; ?>&amp;parametro2=<?php echo $row_contratos['clave_empresa']; ?>" target="_blank"*/
}

 if ($_GET["Anexos"]) {
 //$tempo1=$row_contratos['clave_contrato'];
 //$tempo2=$row_contratos['clave_empresa'];
 
 $tempo1=$_GET['clave_contrato'];
 $tempo2=$_GET['clave_empresa'];
 $tempo3=$_GET['clave_cliente'];
 
 echo "<script language='javascript'> var $tempo1 = <?php echo '$tempo1'; ?>; </script> ";
 echo "<script language='javascript'> var $tempo2 = <?php echo '$tempo2'; ?>; </script> ";
 echo "<script language='javascript'> var $tempo3 = <?php echo '$tempo3'; ?>; </script> ";
 echo "<script language='javascript'>
 if(confirm('Ver Anexos?')) 
{ 
location.href='anexos.php?parametro1='+$tempo1+'&parametro2='+$tempo2+'&parametro3='+$tempo3; 
} 
</script> ";

 /*imp_contrato.php?parametro1=<?php echo $row_contratos['clave_contrato']; ?>&amp;parametro2=<?php echo $row_contratos['clave_empresa']; ?>" target="_blank"*/
}

if ($_GET["captura_refacciones"]) {
 //$tempo1=$row_contratos['clave_contrato'];
 //$tempo2=$row_contratos['clave_empresa'];
 
 $tempo1=$_GET['clave_contrato'];
 
 echo "<script language='javascript'> var $tempo1 = <?php echo '$tempo1'; ?>; </script> ";
 echo "<script language='javascript'>
 //if(confirm('Capturar refacciones?')) 
//{ 
location.href='captura_refacciones.php?parametro1='+$tempo1; 
//} 
</script> ";

 /*imp_contrato.php?parametro1=<?php echo $row_contratos['clave_contrato']; ?>&amp;parametro2=<?php echo $row_contratos['clave_empresa']; ?>" target="_blank"*/
}

}



///****************************************

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contrato</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
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

	
	function actualiza_saldo_inicial(s) {

		//Calcula el saldo inicial, restando del precio el enganche y el costo del automovil dado a cuenta.
		var cp=parseFloat(document.getElementById('cprecio').value);
		var ce=parseFloat(document.getElementById('cenganche').value);
		var ac=parseFloat(document.getElementById('cacuenta').value);

       	var total_saldo_inicial=eval(cp-ce-ac);
		
	   	document.getElementById('saldo_inicial').value = total_saldo_inicial.toFixed(2);
	}


	function actualiza_interes(s) {

		//Calcula los intereses.	
		var inte=parseFloat(document.getElementById('interes').value);
		    inte=eval(inte*0.01);
			
		var ti  =eval(inte*document.getElementById('saldo_inicial').value).toFixed(2);

		document.getElementById('cinteres').value = ti;		 
}

	function actualiza_iva(s) {
		//Calcula el IVA.
	   // var total_iva=parseFloat(document.getElementById('saldo_inicial').value);
	   var total_iva=parseFloat(document.getElementById('cprecio').value);
       var p_iva=parseFloat(document.getElementById('piva').value);
           p_iva=eval(p_iva*0.01);
	   	   //total_iva=eval(total_iva*0.16);
		   total_iva=eval(total_iva*p_iva).toFixed(2);
        
        document.getElementById('civa').value = total_iva;		 
        
	   //document.getElementById('civa').value = total_iva;
}
	function actualiza_total(s) {
		var saldo_inicial = parseFloat(document.getElementById('saldo_inicial').value);
		var cinteres      = parseFloat(document.getElementById('cinteres').value);
		var civa          = parseFloat(document.getElementById('civa').value);
		var total=eval(saldo_inicial+cinteres+civa).toFixed(2);
	    document.getElementById('ctotal').value = total;
}

//Funciones para calcular fechas...

      
	function sumafecha(s) {
		//alert("hola");
		//var myDate1=new Date();
		//myDate1.setFullYear(10,10,);
		
		//Obtiene la fecha capturada en el campo fecha_contrato
		var sFec0 = document.getElementById('fecha_contrato').value;
		//alert (sFec0);
		
		//Separa la fecha anteriormente mencionada y la separa en dia, mes ano.
		var nDia = parseInt(sFec0.substr(0, 2), 10); 
   		var nMes = parseInt(sFec0.substr(3, 2), 10); 
   		var nAno = parseInt(sFec0.substr(6, 4), 10);
		//alert ("nDia="+nDia+" ,nMes="+nMes+" ,nAno="+nAno);
		//myDate1.setFullYear(nAno,nMes,nDia);
		
		//Inicializa la nueva fecha
		var myDate1=new Date(nAno,nMes,nDia);

		//Inicializacion de variables
		var Dias   		= 60;
		//var dia    		= parseInt(myDate1.getDate());
		var dia    		= parseInt(nDia);
		//var mes  	 	= parseInt(myDate1.getMonth());
		var mes  	 	= parseInt(nMes);
		//var ano       	= parseInt(myDate1.getFullYear());
		var ano       	= parseInt(nAno);
		var diferencia 	= 0;
		var bandera     = false;
		//alert ("Fecha: "+dia+"-"+mes+"-"+ano);
		
		var variable=dia+"-"+mes+"-"+ano;
		
		//alert(variable);
		
		//compara si es ano bisiesto. Si si, pone 29 dias a febrero
		if ((ano % 4 == 0) && ((ano % 100 != 0) || (ano % 400 == 0)))
			var aFinMes = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		 else
			var aFinMes = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		
		//alert (aFinMes[mes-1]);
		
		//Mientras no se terminen de adicionar los dias requeridos a le fecha, continua
		while(!bandera){
		/*	if (aFinMes[mes-1] == 31) {
				bandera = true;
				alert ("mes: "+mes+" con dias: "+aFinMes[mes-1]);
				}
		*/
			var comparacion = 0;
			if (dia == 0)
				comparacion = Dias+dia;
			else
				comparacion = Dias;
			
			if (aFinMes[mes-1] >= comparacion)
			{
				dia=Dias;
				bandera = true;
			}
			else
			{
				diferencia = aFinMes[mes-1]-dia;
				Dias = Dias - diferencia;
				dia = 0;
				mes = mes + 1;
				if (mes == 13)
				{
					//alert (mes);
					mes = 1;
					ano = ano +1;
					//Vuelve a comparar si es ano bisiesto cuando cambia de ano
					if ((ano % 4 == 0) && ((ano % 100 != 0) || (ano % 400 == 0)))
						aFinMes[1]=29; 
					else
						aFinMes[1]=28;
				}
				bandera = false;
			}
		}		
		//alert ("Fecha: "+dia+"-"+mes+"-"+ano);
		//document.getElementById('fecha_contrato').value=variable;
		var myDate2=new Date();
		//myDate2.setFullYear(myDate1.getDate()+5);
		var ddia = String(dia);
		var mmes = String(mes);
		
		if (String(ddia).length == 1)
			ddia = "0"+String(dia);
		if (String(mmes).length == 1)
			mmes = "0"+String(mes);	
		//alert (ddia+"-"+mmes+"-"+ano);	
		var variable2=ddia+"-"+mmes+"-"+ano;
		//myDate2.setFullYear(dia,mes,ano);
		document.getElementById('fecha_garantia').value=variable2;
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
#apDiv1 {
	position:absolute;
	left:40px;
	top:1410px;
	width:1026px;
	height:106px;
	z-index:1;
	overflow: automatico;
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
<table width="1027" border="0">
  <tr>
    <td width="178"><img src="Imagenes/jedda-logo.jpeg" width="148" height="69" /></td>
    <td width="834"><p class="style4">
      <?php 
	  		if ($recordID0<>0) {
	  						 $fx="<BR>";
	  						 $em="<BR>";
	  						 if (strlen($row_empresa['fax_empresa'])>0){$fx=", Fax ".$row_empresa['fax_empresa']."<BR>";}
	  						 if (strlen($row_empresa['email_empresa'])>0){$em="email ".$row_empresa['email_empresa']."<BR>";}	
							 echo $row_empresa['nombre_empresa'].", RFC ".$row_empresa['rfc_empresa']."<BR>";
							 echo $row_empresa['domicilio_empresa'].", C.P. ".$row_empresa['cp_empresa']."<BR>";
							 echo $row_empresa['ciudad_empresa']."<BR>";
							 echo "Telefono(s): ".$row_empresa['tel_empresa'].$fx.$em;
                                if (strlen($row_empresa['registro_empresa'])>0)
                                {
                                    echo "Número de Asociado ANCA: ".$row_empresa['registro_empresa'];
                                 
                                }
							 }
							 else
							 {
							 $fx="<BR>";
	  						 $em="<BR>";
							 echo "Selecciona una empresa.";
							 }
	 ?>
    </p>    </td>
  </tr>
</table>

<form id="forma_general" name="forma_general" method="get" action="<?php echo $editFormAction; ?>">
  <table width="1024" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFCC99"><div class="style11" id="enc">
        <table width="1018" border="0" bordercolor="#000000" bordercolorlight="#FFCC99" bordercolordark="#FFCC99" bgcolor="#FFCC99" class="style18">
          <tr>
            <td width="280" bgcolor="#FFCC99"><div align="center" class="style19">Orden de trabajo</div></td>
            <td width="440" bgcolor="#FFCC99"><div align="center" class="style19">Empresa</div></td>
            <td width="280" bgcolor="#FFCC99"><div align="center" class="style19">Fecha</div></td>
          </tr>

          <tr>
            <td bgcolor="#FFCC99"><div align="center">
              <input name="contrato" type="text" class="style13" id="contrato" tabindex="1" dir="rtl" value="<?php 
echo $_GET['contrato']; ?>" size="10" <?php if ($recordID > 0 ) {echo "readonly='readonly'";} else {echo " ";}?>/>
            </div></td>
            <td bgcolor="#FFCC99"><div align="center">
              <select name="clave_empresa" class="style3" id="clave_empresa" tabindex="2" onchange="this.form.submit()">
                <option value="0" <?php if (!(strcmp(0, $_GET['clave_empresa']))) {echo "selected=\"selected\"";} ?>>Selecciona una empresa</option>
                <?php
do {  
?><option value="<?php echo $row_empresas['clave_empresa']?>"<?php if (!(strcmp($row_empresas['clave_empresa'], $_GET['clave_empresa']))) {echo "selected=\"selected\"";} ?>><?php echo $row_empresas['nombre_empresa']?></option>
                <?php
} while ($row_empresas = mysqli_fetch_assoc($empresas));
  $rows = mysqli_num_rows($empresas);
  if($rows > 0) {
      mysqli_data_seek($empresas, 0);
	  $row_empresas = mysqli_fetch_assoc($empresas);
  }
?>
           		</select>
            </td></div>

            <td bgcolor="#FFCC99"><div align="center"><span class="style3 style10 style19"><span class="style3">
              <input name="fecha_contrato" type="text" class="style3" id="fecha_contrato" tabindex="3" dir="rtl"  value="<?php echo date('d-m-Y',strtotime($_GET['fecha_contrato'])); ?>" size="9" />
              </span></span>
                <button class="style3" id="trigger2">...</button>
              <input name="clave_contrato" type="hidden" id="clave_contrato" value="<?php echo $_GET['clave_contrato']; ?>" />
                <input name="clave_usuario" type="hidden" id="clave_usuario" value="<?php echo $_SESSION['MM_UserId']; ?>" />
            </div></td>


    <tr>
      <td colspan="4" bgcolor="#000000" class="style11"><div align="center" class="style16">Cliente</div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFCC99"><span class="style3">Cliente:</span>
        <select name="clave_cliente" class="style3" id="clave_cliente" tabindex="8" onchange="this.form.submit()">
          <option value="0" <?php if (!(strcmp(0, $_GET['clave_cliente']))) {echo "selected=\"selected\"";} ?>>Selecciona cliente</option>
          <?php
do {  
?>
          <option value="<?php echo $row_clientes['clave_cliente']?>"<?php if (!(strcmp($row_clientes['clave_cliente'], $_GET['clave_cliente']))) {echo "selected=\"selected\"";} ?>><?php echo $row_clientes['nombre_cliente']?></option>
          <?php
} while ($row_clientes = mysqli_fetch_assoc($clientes));
  $rows = mysqli_num_rows($clientes);
  if($rows > 0) {
      mysqli_data_seek($clientes, 0);
	  $row_clientes = mysqli_fetch_assoc($clientes);
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
	  		echo "<BR>".$row_cliente_datos['domicilio_cliente'].", C.P. ".$row_cliente_datos['cp_cliente'].", ".$row_cliente_datos[	'ciudad_cliente'].", Telefono(s) ".$row_cliente_datos['tel_cliente'].$fx.$em; 
		}?>
        </span></td>
    </tr>
    
    <tr>
      <td colspan="4" bgcolor="#000000" class="style16"><div align="center">Mantenimiento correctivo</div></td>
    </tr>

		
        <table width="1018" border="0" bordercolor="#000000" bordercolorlight="#FFCC99" bordercolordark="#FFCC99" bgcolor="#FFCC99" class="style18">
          <tr>
            <td width="280" bgcolor="#FFCC99"><div align="center" class="style19">Equipo</div></td>
            <td width="440" bgcolor="#FFCC99"><div align="center" class="style19">Modelo</div></td>
            <td width="280" bgcolor="#FFCC99"><div align="center" class="style19">Número de serie</div></td>  
            <td width="280" bgcolor="#FFCC99"><div align="center" class="style19">Fecha de reporte</div></td>  
          </tr>
          <tr>
          	<td bgcolor="#FFCC99">
              <input name="equipo" type="text" class="style3" id="equipo" tabindex="11" value="<?php echo $_GET['equipo'];  ?>" size="15" />
            </td>
						<td bgcolor="#FFCC99">
							<input name="modelo" type="text" class="style3" id="modelo" tabindex="12" value="<?php echo $_GET['modelo'];  ?>" size="15" />
						</td>
						<td bgcolor="#FFCC99">
							<input name="serie" type="text" class="style3" id="serie" tabindex="13" value="<?php echo $_GET['serie'];  ?>" size="15" />
						</td>
          	<td bgcolor="#FFCC99">
	          	<input name="fecha_reporte" type="text" class="style3" id="fecha_reporte" tabindex="14" dir="rtl" value="<?php echo date('d-m-Y',strtotime($_GET['fecha_reporte'])); ?>" size="11" />
							<button class="style3" id="trigger3">...</button>
						</td>
   				</tr>

   				<tr>
            <td width="280" bgcolor="#FFCC99"><div align="center" class="style19">Quien reporto</div></td>
            <td width="440" bgcolor="#FFCC99"><div align="center" class="style19">No. de visita</div></td>
            <td width="280" bgcolor="#FFCC99"><div align="center" class="style19">Falla</div></td>  
            <td width="280" bgcolor="#FFCC99"><div align="center" class="style19">Contacto</div></td>  
          </tr>

          <tr>
          	<td bgcolor="#FFCC99">
              <input name="reporto" type="text" class="style3" id="reporto" tabindex="15" value="<?php echo $_GET['reporto'];  ?>" size="15" />
            </td>
						<td bgcolor="#FFCC99">
							<input name="visita_no" type="text" class="style3" id="visita_no" tabindex="16" value="<?php echo $_GET['visita_no'];  ?>" size="15" />
						</td>
						<td bgcolor="#FFCC99">
							<textarea name="falla" class="style3" id="falla" tabindex="17" value="<?php echo $_GET['falla'];  ?>" size="15"><?php echo $_GET['falla'];  ?></textarea>
						</td>
          	<td bgcolor="#FFCC99">
	          	<input name="contacto" type="text" class="style3" id="contacto" tabindex="18" dir="rtl" value="<?php echo $_GET['contacto']; ?>" size="11" />
						</td>
   				</tr>
   				<tr>
   					<td width="280" bgcolor="#FFCC99"><div align="center" class="style19">Fecha de inicio</div></td>
            <td width="440" bgcolor="#FFCC99"><div align="center" class="style19">Fecha de terminación</div></td>
            <td width="280" bgcolor="#FFCC99"><div align="center" class="style19">¿SVC terminado?</div></td>  
            <td width="280" bgcolor="#FFCC99"><div align="center" class="style19"></div></td>  
   				</tr>
   				<tr>
   					<td bgcolor="#FFCC99">
	          	<input name="fecha_inicio" type="text" class="style3" id="fecha_inicio" tabindex="14" dir="rtl" value="<?php echo date('d-m-Y',strtotime($_GET['fecha_inicio'])); ?>" size="11" />
							<button class="style3" id="trigger4">...</button>
						</td>
						<td bgcolor="#FFCC99">
	          	<input name="fecha_fin" type="text" class="style3" id="fecha_fin" tabindex="14" dir="rtl" value="<?php echo date('d-m-Y',strtotime($_GET['fecha_fin'])); ?>" size="11" />
							<button class="style3" id="trigger5">...</button>
						</td>

						<td bgcolor="#FFCC99">
	            <label>
	            <input name="svc_terminado" type="checkbox" id="svc_terminado" value="1" <?php if (!(strcmp($_GET['svc_terminado'],1))) {echo "checked=\"checked\"";} ?> />
	            </label>
            </td>

   				</tr>

        </table>  
   			
   			<tr>
      		<td colspan="4" bgcolor="#000000" class="style6"><div align="center" class="style16">Reporte del Ingeniero</div></td>
    		</tr>
    		
    		<td colspan="4" bgcolor="#FFCC99" class="style6"><div id="personal">
        <table width="1018" border="1">
          <tr>
          	
							<textarea name="reporte_ingeniero" class="style3" id="reporte_ingeniero" tabindex="19" value="<?php echo $_GET['reporte_ingeniero'];  ?>" size="15" cols="140" rows="2"><?php echo $_GET['reporte_ingeniero'];  ?></textarea>
						
          </tr>
        </table>
    
    		<tr>
      		<td colspan="4" bgcolor="#000000" class="style6"><div align="center" class="style16">Refacciones</div></td>
    		</tr>

    		<!-- tabla de refacciones -->
				<tr>
      <td colspan="4" bgcolor="#FFCC99"><table width="1000">
          <tr>
            <td width="60" bgcolor="#000033" class="style3"><div align="center" class="style1 style6">No. de parte</div></td>
            <td width="200" bgcolor="#000033" class="style3"><div align="center" class="style7">Descripción</div></td>
            <td width="60" bgcolor="#000033" class="style3"><div align="center" class="style7">Cantidad</div></td>
          </tr>
          <?php do { ?>
            <tr>
            <td class="style3 style19"><?php echo $row_refacciones['no_parte']; ?></td>
            <td class="style3 style19"><?php echo $row_refacciones['descripcion_parte']; ?></td>
            <td class="style3 style19"><?php echo $row_refacciones['cantidad_parte']; ?></td>
          </tr>
					<?php } while ($row_refacciones = mysqli_fetch_assoc($refacciones)); ?>
        </table>
       </tr>
    		<!-- Fin tabla refacciones -->
    		
    		<td colspan="4" bgcolor="#FFCC99" class="style6"><div id="personal">
        <table width="1018" border="1">
          <tr>
          	<!--   -->
						
          </tr>
        </table>

  			<tr>
      		<td colspan="4" bgcolor="#000000" class="style6"><div align="center" class="style16">Solución</div></td>
    		</tr>
    		
    		<td colspan="4" bgcolor="#FFCC99" class="style6"><div id="personal">
        <table width="1018" border="1">
          <tr>
          	
							<textarea name="solucion" class="style3" id="solucion" tabindex="19" value="<?php echo $_GET['solucion'];  ?>" size="15" cols="140" rows="2"><?php echo $_GET['solucion'];  ?></textarea>
						
          </tr>
        </table>
  

    
    <tr>
      <td colspan="4" bgcolor="#000000" class="style6"><div align="center" class="style16">Personal involucrado en el mantenimiento.</div></td>
    </tr>
    <tr>

      <td colspan="4" bgcolor="#FFCC99" class="style6"><div id="personal">
        <table width="1018" border="1">
          <tr>
            <td bgcolor="#FFCC99"><span class="style3"><span class="style18">Ingeniero</span></span></td>
            <td bgcolor="#FFCC99"><span class="style3">
              <select name="clave_vendedor" class="style3" id="clave_vendedor" tabindex="60" onchange="this.form.submit()">
                <option value="0" <?php if (!(strcmp(0, $_GET['clave_vendedor']))) {echo "selected=\"selected\"";} ?>>Seleccion un Vendedor</option>
                <?php
do {  
?>
                <option value="<?php echo $row_vendedor['clave_vendedor']?>"<?php if (!(strcmp($row_vendedor['clave_vendedor'], $_GET['clave_vendedor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_vendedor['nombre_vendedor']?></option>
                <?php
} while ($row_vendedor = mysqli_fetch_assoc($vendedor));
  $rows = mysqli_num_rows($vendedor);
  if($rows > 0) {
      mysqli_data_seek($vendedor, 0);
	  $row_vendedor = mysqli_fetch_assoc($vendedor);
  }
?>
              </select>
            </span></td>
            <td bgcolor="#FFCC99"><span class="style3"><span class="style18">
              <?php 
		if ($recordID9>0) {
	  $fx="<BR>";
	  $em="<BR>";
	  if (strlen($row_vendedor_datos['fax_vendedor'])>0){$fx=", Fax ".$row_vendedor_datos['fax_vendedor'];}
	  if (strlen($row_vendedor_datos['email_vendedor'])>0){$em=", email ".$row_vendedor_datos['email_vendedor']."<BR>";}	  
	  echo $row_vendedor_datos['domicilio_vendedor'].", C.P. ".$row_vendedor_datos['cp_vendedor'].", ".$row_vendedor_datos['ciudad_vendedor'].", Telefono(s) ".$row_vendedor_datos['tel_vendedor'].$fx.$em; 
	  }
	  ?>
            </span></span></td>
          </tr>

        </table>
      </div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#00CCFF"><span class="Texto_tabla">
        <input name="Grabar" type="submit" class="style3" tabindex="63" value="Grabar" <?php if ($recordID > 0 || $recordID63=="E" || $recordID63=="A") {echo "disabled";} else {echo "enabled";}?> />
        <input name="Editar" type="submit" class="style3" tabindex="64" value="Editar" <?php if ($recordID63=="E" ) {echo "enabled";} else {echo "disabled";}?> />
        <input name="Borrar" type="submit" class="style3" tabindex="65" value="Borrar" <?php if ($recordID63=="E" ) {if ($cantidad_registros >= 1 ) {echo "disabled";} else {echo "enabled";}} else {echo "disabled";}?> />
        <input name="Cancelar" type="submit" class="style3" id="Cancelar" tabindex="66" value="Cancelar" />
      </span><span class="style3 Encabezado_tabla style5">
      <input type="hidden" name="MM_insert" value="forma_general" />
      <input type="hidden" name="MM_update" value="form2" />
      <span class="Texto_tabla">
      	
      <input name="captura_refacciones" type="submit" class="style3" id="captura_refacciones" tabindex="67" value="Captura Refacciones" <?php if ($recordID63=="N" || $recordID63=="A") {echo "disabled";} else {echo "enabled";}?>/>

      <input name="Aplicar" type="submit" class="style3" id="Aplicar" tabindex="67" value="Aplicar" <?php if ($recordID63=="N" || $recordID63=="A") {echo "disabled";} else {echo "enabled";}?>/>
	  <input name="Imprimir" type="submit" class="style3" id="Imprimir" tabindex="67" value="Imprimir" <?php if ($recordID63<>"N" ) {echo "enabled";} else {echo "disabled";}?>/>
      
      </span></span></td>
    </tr>
  </table>
  <span class="style4">
  <input name="accion" type="hidden" id="accion" value="<?php echo $_GET['accion']; ?>" />
  </span>
</form>

<script type="text/javascript">
    /*Calendar.setup({
        inputField     :    "fecha_garantia",      // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    true,            // will display a time selector
        button         :    "trigger",   // trigger for the calendar (button ID)
        singleClick    :    false,           // double-click mode
        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
    }); */
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
        inputField     :    "fecha_reporte",      // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    true,            // will display a time selector
        button         :    "trigger3",   // trigger for the calendar (button ID)
        singleClick    :    false,           // double-click mode
        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
    });
</script>

<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_inicio",      // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    true,            // will display a time selector
        button         :    "trigger4",   // trigger for the calendar (button ID)
        singleClick    :    false,           // double-click mode
        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
    }); 
</script>

<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_fin",      // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    true,            // will display a time selector
        button         :    "trigger5",   // trigger for the calendar (button ID)
        singleClick    :    false,           // double-click mode
        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
    }); 
</script>

<p>&nbsp; </p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($clientes);

mysqli_free_result($vendedor);

mysqli_free_result($contratos);
mysqli_free_result($empresa);

mysqli_free_result($cliente_datos);
mysqli_free_result($vendedor_datos);
mysqli_free_result($empresas);


/*
echo "<script language='javascript'> var $mensaje = <?php echo '$mensaje'; ?>; </script> ";
echo "<script language='javascript'> alert('$mensaje'); </script> ";
*/
?>
