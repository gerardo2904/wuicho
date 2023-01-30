<?php require_once('Connections/contratos_londres.php'); 
      require_once('Funciones/numerosletras.php'); 
	  

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


//funcion que suma dias a una fecha
function suma_fechas($fecha,$ndias)
            
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$año)=explode("/", $fecha);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$año)=explode("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
}

function suma_meses($fecha,$nmeses)
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            list($dia,$mes,$año)=explode("/", $fecha);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            list($dia,$mes,$año)=explode("-",$fecha);

    $nuevomes=0;  
    $nuevomes=$mes+$nmeses;
    $añooriginal=$año;
    if ($nuevomes>12 && $nuevomes<24) {$nuevomes=$nuevomes-12; $año=$año+1;}
    if ($nuevomes>24 && $nuevomes<36) {$nuevomes=$nuevomes-24; $año=$año+2;}
    if ($nuevomes>36 && $nuevomes<48) {$nuevomes=$nuevomes-36; $año=$año+3;}
    if ($nuevomes>48 && $nuevomes<60) {$nuevomes=$nuevomes-48; $año=$año+4;}
    
  
    if ($nuevomes==2)
      {
        
        $ultimodia=0;
        if (esBisiesto($año))
        {
          $ultimodia=29;
        }
        else {
          $ultimodia=28;
        }
      if ($dia>$ultimodia)
        $dia=$ultimodia;
      }
  
    $nueva = mktime(0,0,0, $mes+$nmeses,$dia,$añooriginal);
    $nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
}

function nombre_fecha($fecha) {
$d1="";
	$d2="";
	$d3="";
	
	if ( preg_match( "/([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})/", $fecha, $regs ) ) {
	
	$d1=$regs[1];
	$d2=$regs[2];
		switch ($d2) {
			case 1:		$d2="Enero";		break;
			case 2:		$d2="Febrero";		break;
			case 3:		$d2="Marzo";		break;
			case 4:		$d2="Abril";		break;
			case 5:		$d2="Mayo";			break;
			case 6:		$d2="Junio";		break;
			case 7:		$d2="Julio";		break;
			case 8:		$d2="Agosto";		break;
			case 9:		$d2="Septiembre";	break;
			case 10:	$d2="Octubre";		break;
			case 11:	$d2="Noviembre";	break;
			case 12:	$d2="Diciembre";	break;
		}
	$d3=$regs[3];
	}
	$fecha=iconv('UTF-8', 'windows-1252',$d1." de ".$d2." del ".$d3);
	return $fecha;
}

function funciones_reemplazadas(){
    
    if (!function_exists("GetSQLValueString")) {
        function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
        {
            $contratos_londres= mysqli_connect('localhost', 'inmobi10_londres', 'atomicstatus',"inmobi10_contratos_londres");
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

            $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($contratos_londres, $theValue) : mysqli_escape_string($contratos_londres, $theValue);

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

    if (!function_exists('mysql_result')) {
        function mysql_result($result, $number, $field=0) {
            mysqli_data_seek($result, $number);
            $row = mysqli_fetch_array($result);
            return $row[$field];
        }
    }
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

$recordID=$_GET['parametro1'];
//$recordID0=$_SESSION['MM_Empresa'];
$recordID0=$_GET['parametro2'];
$recordID1=$_GET['parametro3'];


$filtro="";
$filtro=" where clave_contrato='$recordID'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_contra = "select clave_contrato, contrato, clave_empresa, contrato.clave_vendedor, contrato.clave_cliente,
DATE_FORMAT(fecha_contrato, '%d-%m-%Y') AS fecha_contrato, vendedores.nombre_vendedor, clave_usuario, equipo, modelo, serie, reporto, DATE_FORMAT(fecha_reporte, '%d-%m-%Y') AS fecha_reporte, visita_no, contacto, DATE_FORMAT(fecha_inicio, '%d-%m-%Y') AS fecha_inicio, DATE_FORMAT(fecha_fin, '%d-%m-%Y') AS fecha_fin, svc_terminado, falla, reporte_ingeniero, solucion, aplicado, clientes.nombre_cliente, clientes.rfc_cliente,
clientes.domicilio_cliente, clientes.ciudad_cliente, clientes.estado_cliente, clientes.cp_cliente, clientes.tel_cliente, clientes.tel_cliente_movil, clientes.tel_cliente_trabajo, clientes.fax_cliente, 
clientes.email_cliente from contrato, clientes, vendedores ".$filtro." AND contrato.clave_cliente=clientes.clave_cliente AND contrato.clave_vendedor=vendedores.clave_vendedor  ";
$contra = mysqli_query($contratos_londres, $query_contra) or die(mysql_error());
$row_contra = mysqli_fetch_assoc($contra);
$totalRows_contra = mysqli_num_rows($contra);


$filtro="";
$filtro=" where clave_empresa='$recordID0'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_emp = "select * from empresa".$filtro;
$emp = mysqli_query($contratos_londres, $query_emp) or die(mysql_error());
$row_emp = mysqli_fetch_assoc($emp);
$totalRows_emp = mysqli_num_rows($emp);


$var=" clave_contrato=".$recordID;
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_refacciones = "SELECT * FROM refacciones WHERE ".$var;
$refacciones = mysqli_query($contratos_londres, $query_refacciones) or die(mysql_error($query_refacciones));
$row_refacciones = mysqli_fetch_assoc($refacciones);
$totalRows_refacciones = mysqli_num_rows($refacciones);




require('fpdf.php');
class PDF extends FPDF
{

function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
{
    $k=$this->k;
    if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
    {
        $x=$this->x;
        $ws=$this->ws;
        if($ws>0)
        {
            $this->ws=0;
            $this->_out('0 Tw');
        }
        $this->AddPage($this->CurOrientation);
        $this->x=$x;
        if($ws>0)
        {
            $this->ws=$ws;
            $this->_out(sprintf('%.3F Tw',$ws*$k));
        }
    }
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $s='';
    if($fill || $border==1)
    {
        if($fill)
            $op=($border==1) ? 'B' : 'f';
        else
            $op='S';
        $s=sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
    }
    if(is_string($border))
    {
        $x=$this->x;
        $y=$this->y;
        if(is_int(strpos($border,'L')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
        if(is_int(strpos($border,'T')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
        if(is_int(strpos($border,'R')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
        if(is_int(strpos($border,'B')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
    }
    if($txt!='')
    {
        if($align=='R')
            $dx=$w-$this->cMargin-$this->GetStringWidth($txt);
        elseif($align=='C')
            $dx=($w-$this->GetStringWidth($txt))/2;
        elseif($align=='FJ')
        {	
			//Set word spacing
            $wmax=($w-2*$this->cMargin);
			//echo $txt."<BR>";
            $this->ws=($wmax-$this->GetStringWidth($txt))/substr_count($txt,' ');
            $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
            $dx=$this->cMargin;
        }
        else
            $dx=$this->cMargin;
        $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
        if($this->ColorFlag)
            $s.='q '.$this->TextColor.' ';
        $s.=sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$txt);
        if($this->underline)
            $s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
        if($this->ColorFlag)
            $s.=' Q';
        if($link)
        {
            if($align=='FJ')
                $wlink=$wmax;
            else
                $wlink=$this->GetStringWidth($txt);
            $this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$wlink,$this->FontSize,$link);
        }
    }
    if($s)
        $this->_out($s);
    if($align=='FJ')
    {
        //Remove word spacing
        $this->_out('0 Tw');
        $this->ws=0;
    }
    $this->lasth=$h;
    if($ln>0)
    {
        $this->y+=$h;
        if($ln==1)
            $this->x=$this->lMargin;
    }
    else
        $this->x+=$w;
}

//Tabla simple
function BasicTable($header,$data)
{
    //Cabecera
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    //Datos
//    foreach($data as $row)
//    {
//        foreach($row as $col)
//            $this->Cell(40,6,$col,1);
//        $this->Ln();
//    }
}


//Cabecera de página
function Header()
{
//Color Header
//    $this->SetDrawColor(0,80,180);
//    $this->SetFillColor(230,230,0);
    $this->SetTextColor(0,0,0);

    //Logo
    //$this->Image('Imagenes/londres_logo4.jpg',5,5,33);
    //Arial bold 15
    $this->SetFont('Arial','B',15);
    //Movernos a la derecha
    $this->Cell(30);
    //Título
	//$x=$row_emp["nombre_empresa"];
	$this->Cell(150,10,$x,0,0,'C');
    //Salto de línea
    $this->Ln(20);
}



//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}



require_once('orden_trabajo.php'); 





?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysqli_free_result($contra);
mysqli_free_result($emp);

?>
