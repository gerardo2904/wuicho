<?php require_once('Connections/contratos_londres.php'); 

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
            
              list($dia,$mes,$año)=split("/", $fecha);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$año)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
}

function nombre_fecha($fecha) {
$d1="";
	$d2="";
	$d3="";
	
	if ( ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $fecha, $regs ) ) {
	
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

$recordID=$_GET['parametro1'];
//$recordID0=$_SESSION['MM_Empresa'];
$recordID0=$_GET['parametro2'];
$recordID1=$_GET['parametro3'];


$filtro="";
$filtro=" where clave_contrato='$recordID'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_contra = "select clave_contrato, contrato, credito,clave_empresa, contrato.clave_cliente,
DATE_FORMAT(fecha_contrato, '%d-%m-%Y') AS fecha_contrato, forma_pago, promocion, no_pagos, dia_pagos, DATE_FORMAT(primerpago, '%d-%m-%Y') AS primerpago, interes, moratorio, cenganche, 
cinteres, acuenta, cprecio, cacuenta, civa, ctotal, clave_inv, clave_inv_acuenta, cefectivo, no_cheque, ccheque, banco_cheque, 
clave_cobrador, garantia, DATE_FORMAT(fecha_garantia, '%d-%m-%Y') AS fecha_garantia,
partes_garantia, aspecto_mec, aspecto_car, aplicado, clave_usuario, saldo_inicial, aspecto_llantas, otros_aspectos, aspecto_otros, 
DATE_FORMAT(fecha_entrega, '%d-%m-%Y') AS fecha_entrega, u_luces, luces, antena, espejos, cristales, tapones, molduras, tapon_gas, 
carroceria_sin_golpes, tablero, calefaccion, aire, limpiadores, radio, bocinas, retrovisor, ceniceros, cinturones, gato, cruceta, 
llanta_refa, estuche_he, triangulo, extinguidor, clientes.nombre_cliente, clientes.rfc_cliente,
clientes.domicilio_cliente, clientes.ciudad_cliente, clientes.estado_cliente, clientes.cp_cliente, clientes.tel_cliente, clientes.fax_cliente, 
clientes.email_cliente, monedas.moneda, vendedores.nombre_vendedor, testigos.nombre_testigo    
from contrato, clientes, monedas, vendedores, testigos ".$filtro." AND contrato.clave_cliente=clientes.clave_cliente AND contrato.clave_moneda=monedas.clave_moneda AND contrato.clave_vendedor=vendedores.clave_vendedor AND contrato.clave_testigo=testigos.clave_testigo ";
$contra = mysql_query($query_contra, $contratos_londres) or die(mysql_error());
$row_contra = mysql_fetch_assoc($contra);
$totalRows_contra = mysql_num_rows($contra);


$filtro="";
$filtro=" where clave_empresa='$recordID0'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_emp = "select * from empresa".$filtro;
$emp = mysql_query($query_emp, $contratos_londres) or die(mysql_error());
$row_emp = mysql_fetch_assoc($emp);
$totalRows_emp = mysql_num_rows($emp);

$var=" AND clave_inv=".$row_contra['clave_inv'];
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_autos_d = "SELECT inventario_auto.*, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca
 FROM inventario_auto, tipo_auto, marca 
 WHERE inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca".$var;
$autos_d = mysql_query($query_autos_d, $contratos_londres) or die(mysql_error());
$row_autos_d = mysql_fetch_assoc($autos_d);
$totalRows_autos_d = mysql_num_rows($autos_d);

$filtro="";
$filtro=" where clave_cliente='$recordID1'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_ava = "select * from avales".$filtro;
$ava = mysql_query($query_ava, $contratos_londres) or die(mysql_error());
$row_ava = mysql_fetch_assoc($ava);
$totalRows_ava = mysql_num_rows($ava);

$filtro="";
$filtro=" where clave_cliente='$recordID1'";
mysql_select_db($database_contratos_londres, $contratos_londres);
$query_ava2 = "select * from avales".$filtro;
$ava2 = mysql_query($query_ava2, $contratos_londres) or die(mysql_error());
$row_ava2 = mysql_fetch_assoc($ava2);
$totalRows_ava2 = mysql_num_rows($ava2);

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
			/*echo "<script language='javascript'> var $wmax = <?php echo '$wmax'; ?> </script> ";
			echo "<script language='javascript'>alert('wmax='+$wmax); </script> ";
			
			echo "<script language='javascript'> var $txt = <?php echo '$txt'; ?> </script> ";
			echo "<script language='javascript'>alert('txt='+$txt); </script> ";
			*/
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

/*
//Cabecera de página
function Header()
{
//Color Header
//    $this->SetDrawColor(0,80,180);
//    $this->SetFillColor(230,230,0);
    $this->SetTextColor(0,0,0);

    //Logo
    $this->Image('Imagenes/londres_logo4.jpg',5,5,33);
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
*/

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



    $pdf=new PDF(P,'mm','Legal'); 
	$pdf->Open();  
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15); 
	$pdf->AliasNbPages();
	$pdf->Ln(10);
	$pdf->Image('Imagenes/londres_logo4.jpg',20,17,45);
	$pdf->SetLeftMargin(70);
	$pdf->Cell(100,-5,trim($row_emp["nombre_empresa"]),0,0,P);
	$pdf->SetFont('Arial','',10); 
	$pdf->Ln(1);
	if (strlen($row_emp["registro_empresa"])==0) {$t="";} else {$t=", ".trim($row_emp["registro_empresa"]);}
	$pdf->Cell(50,3,'RFC '.trim($row_emp["rfc_empresa"]).$t,0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(50,3,trim($row_emp["domicilio_empresa"]),0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(50,3,trim($row_emp["ciudad_empresa"]).', '.trim($row_emp["estado_empresa"]),0,0,P);	
	
	$t="";
	if (strlen($row_emp["tel_empresa"])>0)
	{$t="Telefono(s) ".trim($row_emp["tel_empresa"]);} else {$t="";}
	if (strlen($row_emp["tel_empresa"])>0 AND strlen($row_emp["fax_empresa"])>0)
	{$t=$t.", Fax ".trim($row_emp["fax_empresa"]);}
	if (strlen($row_emp["tel_empresa"])==0 AND strlen($row_emp["fax_empresa"])>0)
	{$t="Fax ".trim($row_emp["fax_empresa"]);}
	if (strlen($row_emp["tel_empresa"])>=1 || strlen($row_emp["fax_empresa"])>=1)
	{
		$pdf->Ln(4);
		$pdf->Cell(50,3,$t,0,0,P);	
	}
	if (strlen($row_emp["email_empresa"])>0)
	{
		$pdf->Ln(4);
		$pdf->Cell(10,3,"email ",0,0,L);
		$pdf->SetFont('Times','BIU');
		$pdf->SetTextColor(0,0,255);
		$pdf->Cell(0,3,trim($row_emp["email_empresa"]),0,0,"L",false,"mailto:\\".trim($row_emp["email_empresa"]));
	}
	$pdf->SetLeftMargin(20);
	$pdf->Ln(7);	
	$pdf->SetFont('Times','B');
	$pdf->SetTextColor(255,0,0);
	$pdf->Cell(53,3,'CONTRATO: '.trim($row_contra["contrato"]),0,0);
	$pdf->SetTextColor(0,0,255);
	$pdf->Ln(5);	
	if ($row_contra["garantia"]==1)
	{
		$pdf->Cell(53,3,'Tipo "A" VEHICULO MOTOR VENDIDO CON GARANTIA',0,0);
	}
	else
	{
		$pdf->Cell(53,3,'Tipo "B" VEHICULO MOTOR VENDIDO SIN GARANTIA',0,0);
	}
	$pdf->SetFont('Arial','',10); 
	$pdf->SetTextColor(0,0,0);
	$pdf->SetLeftMargin(20);
	//$pdf->SetRightMargin(30);
	$pdf->Ln(8);
	$str=iconv("UTF-8", "windows-1252","Contrato de compra venta con reserva de dominio de vehículo usado, que celebran por una parte el");
		$pdf->Cell(163,3,$str,0,0,"FJ");
	$pdf->Ln(4);
	$pdf->SetFont('Arial','BIU',9);
	$str=iconv("UTF-8", "windows-1252","C. ".trim($row_emp["representante_empresa"]).",");
		$pdf->Cell(163,3,$str,0,0,"C");
		$pdf->SetFont('Arial','',10);
	//$pdf->SetLeftMargin(95);
	$pdf->SetLeftMargin(20);
	$pdf->Ln(4);
	$str=iconv("UTF-8", "windows-1252","Propietario y/o Representante Legal de la negociación denominada");
		$pdf->Cell(163,3,$str,0,0,"FJ");
	$pdf->SetLeftMargin(20);
	$pdf->Ln(4);
	
	//$str=iconv("UTF-8", "windows-1252","Legal de la negociación denominada ");
	//$pdf->Cell(10,3,$str,0,0);
	$pdf->SetFont('Arial','BIU',10);
	$pdf->SetLeftMargin(20);
	
	$str=iconv("UTF-8", "windows-1252",trim($row_emp["nombre_empresa"]).",");
			$pdf->Cell(163 ,3,$str,0,0,"C");	
			$pdf->Ln(4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(20);
	$str=iconv("UTF-8", "windows-1252","a quien en lo sucesivo se le denominara el vendedor y por otra parte el:");
		$pdf->Cell(163,3,"a quien en lo sucesivo se le denominara el vendedor y por otra parte el",0,0,"FJ");	
	$pdf->SetLeftMargin(20);
	//$pdf->Ln(4);
	//$str=iconv("UTF-8", "windows-1252","denominara el vendedor y por otra parte el: ");
	//	$pdf->Cell(58,3,$str,0,0,"L");	
		$pdf->Ln(4);
	$pdf->SetFont('Arial','BIU',10);
	$pdf->SetLeftMargin(20);
	$str=iconv('UTF-8', 'windows-1252',"C. ".trim($row_contra["nombre_cliente"]).",");
	$pdf->Cell(163,3,$str,0,0,"C");	
	//$pdf->MultiCell(92,3,$str,0,'FJ');
	$pdf->SetLeftMargin(20);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"a quien se le denominara el comprador al tenor de la siguientes declaraciones y cláusulas:");
		$pdf->Cell(164,3,$str,0,0,"FJ");	

	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(0,3,"DECLARACIONES",0,0,'C');	
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(53,3,"DECLARA EL VENDEDOR:",0,0);	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"I.-  Ser una persona física, cuya actividad preponderante es la compra venta de vehículos usados. ");
		$pdf->Cell(164,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"II.- Tener su domicilio en: ");
		$pdf->Cell(41,3,$str,0,0);	
	//$pdf->Ln(4);
	$pdf->SetLeftMargin(40);
	
	$str=iconv('UTF-8', 'windows-1252',trim($row_emp["domicilio_empresa"]).",");
		$pdf->Cell(122,3,$str,0,0,"FJ");
	$pdf->SetLeftMargin(25);
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", con registro federal de contribuyentes ".trim($row_emp["rfc_empresa"])." con horario de atención");
		$pdf->Cell(158,3,$str,0,0,"FJ");
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"al público de ");
		$pdf->Cell(21,3,$str,0,0,P);
	$pdf->SetFont('Arial','B',10);
	$str=iconv('UTF-8', 'windows-1252',"LUNES A SABADO DE 9:00 A.M. A 7:00 P.M.");
		$pdf->Cell(57,3,$str,0,0,P);
	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(20);
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"III.-Que es una persona física con actividad empresarial.");
		$pdf->Cell(50,3,$str,0,0,P);
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"IV.-Declara el vendedor que previamente a la celebración del presente contrato le ha informado al ");
		$pdf->Cell(164,3,$str,0,0,FJ);
	$pdf->Ln(4);
	$pdf->SetLeftMargin(26);
	$str=iconv('UTF-8', 'windows-1252',"comprador de todas y cada una de las condiciones generales mecánicas del vehículo, para que");
		$pdf->Cell(157,3,$str,0,0,FJ);	
		
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"en su caso sea revisado por este último.");
	$pdf->Cell(157,3,$str,0,0,FJ);	
	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(10);
	$str=iconv('UTF-8', 'windows-1252',"DECLARA EL COMPRADOR:");
	$pdf->Cell(53,3,$str,0,0,FJ);	
	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"I.- Llamarse como ha quedado expresado, tener su domicilio: 	"); 
		$pdf->Cell(164,3,$str,0,0,FJ);
		
	$pdf->SetLeftMargin(24);
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',trim($row_contra["domicilio_cliente"]).",");
		$pdf->Cell(159,3,$str,0,0,FJ);
	//Revisar aqui.....	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',trim($row_contra["ciudad_cliente"]).",".trim($row_contra["estado_cliente"]).", con registro federal de causantes ".trim($row_contra["rfc_cliente"])."Y capacidad jurídica para obligarse  ");
		$pdf->Cell(161,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"y manifiesta que antes de firmar ha leído el clausulado de este contrato.");
		$pdf->Cell(0,3,$str,0,0,P);	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"II.-Que previamente a la celebración del presente contrato, se le informó al comprador sobre el precio");
		$pdf->Cell(164,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$pdf->SetLeftMargin(24);
	$str=iconv('UTF-8', 'windows-1252',"de contado del vehículo usado, objeto del presente contrato, el monto de los intereses. La tasa que se ");
		$pdf->Cell(161,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"calcularan, el monto y detalle de los cargos, el número de pagos a realizar, su periodicidad, la");
		$pdf->Cell(161,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"cantidad total a pagar por dicho vehículo y el derecho que tiene a liquidar anticipadamente el crédito");
		$pdf->Cell(161,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"con la consiguiente reducción de intereses.");
		$pdf->Cell(0,3,$str,0,0,P);	
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(0,3,"CLAUSULAS",0,0,'C');	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$str=iconv('UTF-8', 'windows-1252',"PRIMERA.- El vendedor vende y el comprador compra el vehículo que a continuación se describe:");
		$pdf->Cell(161,3,$str,0,0,"FJ");
	$pdf->SetLeftMargin(24);
	$pdf->Ln(6);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(25,3,"MODELO ",0,0);$pdf->Cell(55,3,$row_autos_d["ano"],0,0);$pdf->Cell(25,3,"UNIDAD",0,0);$pdf->Cell(55,3,$row_autos_d["marca"]);
	
	$i="";
	switch ($row_autos_d["estilo"]) {
    case "automovil":
        $i="Automovil";
        break;
    case "todoterreno":
        $i="Todo Terreno";
        break;
    case "pickup":
        $i="Pickup";
        break;
	case "minivan":
        $i="Mini Van";
        break;	
	}
	$pdf->Ln(4);
	$pdf->Cell(25,3,"TIPO ",0,0);$pdf->Cell(55,3,$i,0,0);$pdf->Cell(25,3,"LINEA",0,0);$pdf->Cell(55,3,$row_autos_d["modelo"]);
	//$pdf->Cell(0,3,$row_autos_d["marca"]." ".$row_autos_d["modelo"]." ".$row_autos_d["ano"].", el cual tiene motor de ".$row_autos_d["motor"]." cilindros y odometro con ".$row_autos_d["km"]." millas.",0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ODOMETRO ",0,0);$pdf->Cell(55,3,number_format($row_autos_d["km"]),0,0);$pdf->Cell(25,3,"COLOR",0,0);$pdf->Cell(55,3,$row_autos_d["color"]);
	//$pdf->Cell(0,3,$row_autos_d["especificaciones"],0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"CILINDROS ",0,0);$pdf->Cell(55,3,$row_autos_d["motor"],0,0);$pdf->Cell(25,3,"SERIE",0,0);$pdf->Cell(55,3,$row_autos_d["serie"]);
	//$pdf->Cell(0,3,"No. serie: ".trim($row_autos_d["serie"]).", No. pedimento: ".trim($row_autos_d["pedimento"]).", Aduana: ".trim($row_autos_d["aduana"]),0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ADUANA ",0,0);$pdf->Cell(55,3,$row_autos_d["aduana"],0,0);$pdf->Cell(25,3,"PEDIMENTO",0,0);$pdf->Cell(55,3,$row_autos_d["pedimento"]);
	
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(6);
	$pdf->Cell(0,3,"El cual cuenta con el siguiente inventario: ",0,0,P);
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(6);
    // Tabla con inventario del auto vendido.
	$header=array('EXTERIORES','INTERIORES','ACCESORIOS');
	$pdf->BasicTable($header,$data);
	$pdf->Cell(35,5,"Unidad de luces",1); 
	$pdf->Cell(5,5,($row_contra["u_luces"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Instrumento de tablero",1); 
	$pdf->Cell(5,5,($row_contra["tablero"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Gato",1); 
	$pdf->Cell(5,5,($row_contra["gato"]==0)?"No":"Si",1); 
	$pdf->Ln(5); 
	$pdf->Cell(35,5,"Luces",1); 
	$pdf->Cell(5,5,($row_contra["luces"]==0)?"No":"Si",1); 
	$str=iconv('UTF-8', 'windows-1252',"Calefaccion");
		$pdf->Cell(35,5,$str,1); 
	$pdf->Cell(5,5,($row_contra["calefaccion"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Llave de tuercas",1); 
	$pdf->Cell(5,5,($row_contra["cruceta"]==0)?"No":"Si",1); 
	$pdf->Ln(5); 
	$pdf->Cell(35,5,"Antena",1); 
	$pdf->Cell(5,5,($row_contra["antena"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Aire acondicionado",1); 
	$pdf->Cell(5,5,($row_contra["aire"]==0)?"No":"Si",1); 
	$str=iconv('UTF-8', 'windows-1252',"Llanta de refaccion");
		$pdf->Cell(35,5,$str,1); 
	$pdf->Cell(5,5,($row_contra["llanta_refa"]==0)?"No":"Si",1); 
	$pdf->Ln(5); 
	$pdf->Cell(35,5,"Espejos laterales",1); 
	$pdf->Cell(5,5,($row_contra["espejos"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Limpiadores (plumas)",1); 
	$pdf->Cell(5,5,($row_contra["limpiadores"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Estuche de herramientas",1); 
	$pdf->Cell(5,5,($row_contra["estuche_he"]==0)?"No":"Si",1); 
	$pdf->Ln(5); 	
	$pdf->Cell(35,5,"Cristales en buen estado",1); 
	$pdf->Cell(5,5,($row_contra["cristales"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Radio",1); 
	$pdf->Cell(5,5,($row_contra["radio"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"triangulo de seguridad",1); 
	$pdf->Cell(5,5,($row_contra["triangulo"]==0)?"No":"Si",1); 
	$pdf->Ln(5); 		
	$pdf->Cell(35,5,"Tapones de rueda",1); 
	$pdf->Cell(5,5,($row_contra["tapones"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Bocinas",1); 
	$pdf->Cell(5,5,($row_contra["bocinas"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Extinguidor",1); 
	$pdf->Cell(5,5,($row_contra["extinguidor"]==0)?"No":"Si",1); 
	$pdf->Ln(5); 	
	$pdf->Cell(35,5,"Molduras completas",1); 
	$pdf->Cell(5,5,($row_contra["molduras"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Espejo retrovisor",1); 
	$pdf->Cell(5,5,($row_contra["retrovisor"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"",1); 
	$pdf->Cell(5,5,"",1); 
	$pdf->Ln(5); 	
	$str=iconv('UTF-8', 'windows-1252',"Tapon de gasolina");
		$pdf->Cell(35,5,$str,1); 
	$pdf->Cell(5,5,($row_contra["tapon_gas"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Ceniceros",1); 
	$pdf->Cell(5,5,($row_contra["ceniceros"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5," ",1); 
	$pdf->Cell(5,5,"",1); 
	$pdf->Ln(5); 	
	$str=iconv('UTF-8', 'windows-1252',"Carroceria sin golpes");
		$pdf->Cell(35,5,$str,1); 
	$pdf->Cell(5,5,($row_contra["carroceria_sin_golpes"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5,"Cinturones de seguridad",1); 
	$pdf->Cell(5,5,($row_contra["cinturones"]==0)?"No":"Si",1); 
	$pdf->Cell(35,5," ",1); 
	$pdf->Cell(5,5,"",1); 
	$pdf->Ln(10);
	//$pdf->AddPage();
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(53,3,"OBSERVACIONES ACERCA DE LAS CONDICIONES GENERALES DEL VEHICULO",0,0);	
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(5);
	$pdf->Cell(38,3,"A) CARROCERIA ",0,0);	
	$pdf->Cell(0,3,$row_contra["aspecto_car"],0,0);	
	$pdf->Ln(5);
	$pdf->Cell(38,3,"B) MECANICO ",0,0);	
	$pdf->Cell(0,3,$row_contra["aspecto_mec"],0,0);	
	$pdf->Ln(5);
	$pdf->Cell(38,3,"C) LLANTAS ",0,0);	
	$pdf->Cell(0,3,$row_contra["aspecto_llantas"],0,0);	
	
	if (strlen($row_contra["otros_aspectos"])>=1){
	$pdf->Ln(5);
	$pdf->Cell(38,3,"D) ".$row_contra["otros_aspectos"],0,0);	
	$pdf->Cell(0,3,$row_contra["aspecto_otros"],0,0);	
	}
	$pdf->Ln(8);
	$str=iconv('UTF-8', 'windows-1252',"La Unidad descrita con anterioridad será entregada el dia: ");
		$pdf->Cell(95,3,$str,0,0);	
	$pdf->SetFont('Arial','BU',10);
	
	$dia=substr($row_contra["fecha_entrega"],0,2);
	$mes=substr($row_contra["fecha_entrega"],3,2);
	$ano=substr($row_contra["fecha_entrega"],6,4);
	$fecha_entrega=$dia."-".$mes."-".$ano;
	$fe="";
	$fe=nombre_fecha($fecha_entrega);
	if (intval($dia)==0 || intval($mes)==0 || intval($ano)==0) {$fe="";} 
	//$pdf->Cell(0,3,$row_contra["fecha_entrega"],0,0);
	$pdf->Cell(0,3,$fe,0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(12);
	//$pdf->Cell(163,3,"Nombre y firma del cliente: ",0,0,"C");	
	//$pdf->Ln(4);
	$pdf->SetFont('Arial','BU',10);
		$str=iconv('UTF-8', 'windows-1252',trim($row_contra["nombre_cliente"]));
		$pdf->Cell(163,3,$str,0,0,"C");	
	$pdf->SetFont('Arial','',10);	
	$pdf->Ln(4);
		$pdf->Cell(163,3,"Nombre y firma del cliente ",0,0,"C");	
	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(20);
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	$pdf->Ln(20);
	$str=iconv('UTF-8', 'windows-1252',"SEGUNDA.- El vendedor en este acto, exhibe al comprador la documentación en copia simple que ampara la propiedad del vehículo descrito en la cláusula anterior, cerciorado de que dicha documentación corresponde fielmente al citado vehículo y se encuentra en regla quedando en poder del vendedor la documentación original, hasta en tanto no sea liquidado totalmente el precio pactado.");
	$pdf->MultiCell(164,4,$str,0,'J');
	
	//$pdf->Cell(161,3,$str,0,0,"FJ");
	//$pdf->Ln(5);
	//$str=iconv('UTF-8', 'windows-1252',"la propiedad del vehículo descrito en la cláusula anterior, cerciorado de que dicha documentación");
	//	$pdf->Cell(161,3,$str,0,0,"FJ");
	//$pdf->Ln(5);
	//$str=iconv('UTF-8', 'windows-1252',"corresponde fielmente al citado vehículo y se encuentra en regla quedando en poder del vendedor la ");
	//	$pdf->Cell(162,3,$str,0,0,"FJ");
	//$pdf->Ln(5);
	//$str=iconv('UTF-8', 'windows-1252',"documentación original, hasta en tanto no sea liquidado totalmente el precio pactado.");
	//	$pdf->Cell(161,3,$str,0,0,P);
	$pdf->Ln(8);
	$pdf->SetLeftMargin(24);
	$str=iconv('UTF-8', 'windows-1252',"Factura Numero: ");
		$pdf->Cell(75,3,$str,0,0);
	$str=iconv('UTF-8', 'windows-1252',"Expedida por: ");
		$pdf->Cell(65,3,$str,0,0);
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Pago de tenencia Vehicular por los años:");
		$pdf->Cell(85,3,$str,0,0);
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Tarjeta de circulación número:");
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Otros documentos ");
		$pdf->Cell(85,3,$str,0,0);		
	$pdf->SetLeftMargin(20);
	$pdf->Ln(8);	
	$str=iconv('UTF-8', 'windows-1252',"TERCERA.- El precio de la compraventa lo han determinado de común acuerdo el vendedor y el comprador sobre las siguientes bases:");
	$pdf->MultiCell(164,4,$str,0,'J');
	//	$pdf->Cell(161,3,$str,0,0,FJ);
		
	//$pdf->Ln(4);
	//$str=iconv('UTF-8', 'windows-1252',"sobre las siguientes bases:");
	//	$pdf->Cell(0,3,$str,0,0,'');

		$pdf->Ln(8);
	$i="";
	//echo "Moneda: ".$row_contra["moneda"]."<BR>";
	switch ($row_contra["moneda"]) {
    case "Dolar":
        $i="DLLS. MONEDA DE LOS EUA.";
        break;
    case "Peso":
        $i="Pesos. MONEDA NACIONAL MEXICANA";
        break;
	}
	//echo "Moneda: ".$i."<BR>";
	
	$str=iconv('UTF-8', 'windows-1252',"VALOR DE LA UNIDAD ");
		$pdf->Cell(75,3,$str,0,0);
	
 	
		$str=iconv('UTF-8', 'windows-1252',"$".number_format($row_contra["cprecio"],2));
		$pdf->Cell(25,3,$str,0,0,"R");
	$str=iconv('UTF-8', 'windows-1252',$i);	
		$pdf->Cell(60,3,$str,0,0,"R");
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"ENGANCHE A LA FIRMA DEL CONTRATO");
		$pdf->Cell(75,3,$str,0,0);
	
	$pdf->Cell(26,3,"("."$".number_format($row_contra["cenganche"],2).")",0,0,"R");

		$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"UNIDAD USADA A CUENTA ");
		$pdf->Cell(75,3,$str,0,0);
		$v=$row_contra["cacuenta"];if (is_int((int) $v)) {$v=$v.".00";}
		$pdf->Cell(26,3,"("."$".number_format($row_contra["cacuenta"],2).")",0,0,"R");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"SALDO ");
		$pdf->Cell(75,3,$str,0,0);
		
		$pdf->Cell(25,3,"$".number_format($row_contra["saldo_inicial"],2),0,0,"R");
	$pdf->Ln(6);
	$str=iconv('UTF-8', 'windows-1252',"INTERESES ");
		$pdf->Cell(75,3,$str,0,0);
		
		$pdf->Cell(25,3,"$".number_format($row_contra["cinteres"],2),0,0,"R");
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"IVA ");
		$pdf->Cell(75,3,$str,0,0);
		$pdf->Cell(25,3,"$".number_format($row_contra["civa"],2),0,0,"R");	
	$pdf->Ln(6);	
	$str=iconv('UTF-8', 'windows-1252',"SALDO ");
		$pdf->Cell(75,3,$str,0,0);
	$str=iconv('UTF-8', 'windows-1252',"$".number_format($row_contra["ctotal"],2));
		$pdf->Cell(25,3,$str,0,0,"R");
	$str=iconv('UTF-8', 'windows-1252',$i);	
		$pdf->Cell(60,3,$str,0,0,"R");
	$pdf->Ln(6);	
	$str=iconv('UTF-8', 'windows-1252',"TENENCIA (POR CUENTA DEL CLIENTE)");
		$pdf->Cell(75,3,$str,0,0);
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"PLACAS (POR CUENTA DEL CLIENTE)");
		$pdf->Cell(75,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"OTROS (ESPECIFICAR)");
		$pdf->Cell(75,3,$str,0,0);	
	$pdf->Ln(6);	
	$str=iconv('UTF-8', 'windows-1252',"INTERES MORATORIO AL ".$row_contra["moratorio"]."% MENSUAL.");
		$pdf->Cell(75,3,$str,0,0);	
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(0,3,"MONTO DE INTERESES",0,0,'C');	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	
	$texto="";
	$texto=iconv('UTF-8', 'windows-1252',"Las partes convienen expresamente en que los intereses ordinarios causados por el total a que se refiere la cláusula tercera se cobraran a razón del porcentaje que acuerden al momento del otorgamiento del crédito y firma del presente contrato, los cuales se calcularan conforme a una tasa fija o variable en los términos de lo establecido en el artículo 66 de la Ley Federal de Protección al Consumidor y se causaran intereses moratorios, aplicando la tasa del 5%  mensual que de común acuerdo establecieron las partes al momento del otorgamiento del crédito y firma del presente contrato.");
	//$rec=suma_fechas($row_contra["fecha_contrato"], 31);
	$pdf->MultiCell(164,4,$texto,0,'J');	
	
	$texto="";
	$texto=iconv('UTF-8', 'windows-1252',"El comprador podrá en cualquier momento liquidar anticipadamente el saldo del precio del vehículo, en caso de estar aplicado a la promoción de cero enganche y cero intereses de financiamiento, el plazo que se acuerde puede ser de 24, 30 y 36 meses con cero de interes y cero de enganche. 

En caso de solicitar 12 meses más para el pago total de su vehículo la tasa de interés sera del 20% correspondiente a los 12 últimos meses, en caso de pagar anticipadamente habrá una reducción del monto de los intereses , que aun no estén vencidos.

Los pagos anticipados parciales se aplicarán en orden de fechas de los vencimientos más próximos.

CUARTA: El comprador se compromete a pagar al Vendedor como precio total de este contrato, la cantidad establecida en la cláusula que antecede, en mensualidades que asciende al monto de:
");
	$pdf->MultiCell(164,4,$texto,0,'J');	
	
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',10);
	$texto="";
	$texto=iconv('UTF-8', 'windows-1252',$row_contra["forma_pago"]);
	$pdf->MultiCell(164,4,$texto,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont('Arial','',10);
	
	$texto="";
	$texto=iconv('UTF-8', 'windows-1252',"Cada uno, que vencerán con la siguiente periodicidad   MENSUAL    y en forma sucesiva los dias   ".$row_contra["dia_pagos"]." a partir del dia ");
	//$rec=suma_fechas($row_contra["fecha_contrato"], 31);
	
	
	//////////////
	$rec=nombre_fecha($row_contra["primerpago"]);
	/////////////
	
	//$pdf->MultiCell(164,4,$texto.$rec.".",0,'J');	
	$pdf->MultiCell(164,4,$texto.$rec.".",0,'J');	
	
	$pdf->Ln(3);	
	$texto="";
	$texto=iconv('UTF-8', 'windows-1252',"Dichos pagos podrán ser liquidados en su equivalente en Moneda Nacional, al tipo de cambio libre que rija la banca el día que se efectúe el pago.  Para tal efecto se acepta  efectivo en dólares, moneda nacional, transferencias bancarias, depósitos en cuenta de cheques. NO SE ACEPTAN TARJETAS DE CREDITO NI TARJETAS DE DEBITO DE NINGUN TIPO. 

QUINTA:  Ambos contratantes convienen que el  Vendedor, de acuerdo con lo establecido en el artículo 2312 del Código Civil  para el Distrito Federal, se reserva el dominio del vehículo, materia del presente contrato, hasta que el precio pactado y derivaciones legales estén íntegramente pagados. 

SEXTA: Los documentos que amparan la propiedad descrita en la cláusula segunda, permanecerán en poder del vendedor, como garantía de la reserva de dominio del vehículo objeto del presente contrato expidiéndole al comprador las copias fotostáticas respectivas que acrediten su legítima propiedad. 
");
	$pdf->MultiCell(164,4,$texto,0,'J');	
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',15);
	$texto="";
	if ($row_contra["garantia"]==1){
	$pdf->Cell(0,3,"GARANTIA",0,0,'C');	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
		$texto="";
	$texto=iconv('UTF-8', 'windows-1252',"SEPTIMA.- El comprador acepta que por tratarse de una unidad usada adquiere el vehículo objeto del presente contrato, en el estado de uso en que se encuentra, el cual le fue facilitado para su revisión general, por cuyo motivo cuenta con una garantía de 60 días de acuerdo con el artículo 77 de la Ley Federal de Protección al Consumidor cuya reforma salio publicada en DOF el 04-02-2004, y para dar cumplimiento a lo dispuesto por la NOM-122-SCFI-2010, a partir del dia");
	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->AddPage();
	$pdf->Ln(20);
	
	//////////////
	$fecha1=nombre_fecha($row_contra["fecha_contrato"]);
	$fecha2=nombre_fecha($row_contra["fecha_garantia"]);
	/////////////
	
	$texto=iconv('UTF-8', 'windows-1252',$fecha1." y termina el dia ".$fecha2." o 3,000 millas, lo que suceda primero, en las siguientes partes: MOTOR Y TRANSMISION,   NO TIENEN GARANTIA PARTES ELECTRICAS  NI LA BOMBA DE GASOLINA. 

El cumplimiento a la Garantía arriba mencionada se hará en el domicilio ubicado en Blvd. Sánchez Taboada No. 53 Zona Río de esta ciudad de Tijuana, Baja California
");
	$pdf->MultiCell(164,4,$texto,0,'J');
	}
	else
	{
	$pdf->Cell(0,3,"AUTO SIN GARANTIA",0,0,'C');	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	$texto="";
	$texto=iconv('UTF-8', 'windows-1252',"SEPTIMA. El comprador acepta que por tratarse de una unidad usada adquiere el vehículo objeto del presente contrato, en el estado de uso en el que se encuentra, el cual le fue facilitado para su revisión general, ambas partes están  de acuerdo en que esta unidad NO TIENE GARANTIA, por lo");
	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->AddPage();
	$pdf->Ln(20);
	$texto=iconv('UTF-8', 'windows-1252',"cual se hace un ajuste en el precio del vehículo  por la cantidad de:___________________________
la cual aparece especificada en la Cláusula Tercera del presente contrato.");
	$pdf->MultiCell(164,4,$texto,0,'J');
	}
	$texto=iconv('UTF-8', 'windows-1252',"Firmo de Conformidad ya que el Vendedor me ha explicado y he entendido totalmente el concepto aquí contenido. 

FIRMA DEL COMPRADOR_____________________________________ FECHA____________
");
	
	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->Ln(10);
	$texto=iconv('UTF-8', 'windows-1252',"OCTAVA.- El comprador se obliga a no vender, ni gravar en forma alguna el vehículo objeto de este contrato, hasta que se liquide el precio en su totalidad. 

NOVENA.- El Comprador tendrá la obligación de informar al Vendedor durante la vigencia del contrato sobre el cambio de domicilio que llegare a tener, en un plazo máximo de 15 dias posteriores a la verificación del cambio . En caso de incumplimiento a esta cláusula el Comprador esta de acuerdo en pagar la cantidad de $ 1,000.00 Pesos M.N. por  gastos de localización.

DECIMA.- Para  dar cumplimiento a lo previsto por el artículo 70 de la Ley Federal de Protección al Consumidor, los contratantes de Común acuerdo y para el caso de que se rescindiera el presente contrato, deberán restituirse las prestaciones que se hubieran hecho si el comprador hubiera pagado 
mas de la tercera parte del importe de la compra venta, podrá optar por la rescisión o el pago del adeudo vencido, en términos de lo previsto por el artículo 71 del citado ordenamiento legal. 
");
	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->Ln(5);
	$texto=iconv('UTF-8', 'windows-1252',"DECIMA PRIMERA.- El comprador asumirá al momento de recibir el vehículo, la responsabilidad sobre el buen uso del mismo, desde la entrega del bien. 

DECIMA SEGUNDA.- Con base en lo previsto por el artículo 66 de la Ley Federal de Protección al Consumidor, los pagos no cubiertos a su vencimiento, además del interés ordinario pactado en la 
Cláusula Tercera del presente contrato causará un interés moratorio del 5% mensual convenidos por ambas partes de común acuerdo. 

DECIMA TERCERA.- El vendedor podrá demandar la rescisión o el vencimiento del saldo del adeudo del presente contrato y en consecuencia exigir su pago total cuando ocurran cualesquiera de las siguientes causas:

A) Cuando el vehículo objeto de la compra venta sufra destrucción total o daños parciales que afectan su naturaleza o éste sea materia de embargo, secuestro judicial u otro acontecimiento semejante a los citados en esta cláusula de lo que sea responsable el comprador, por cesión o traspaso de derechos o arrendamiento del vehículo y de cualquiera de los derechos que adquiere el Comprador y sin que medie consentimiento otorgado por escrito del Vendedor.
B) Por falta de pago, a la fecha del vencimiento de dos o mas abonos pactados con excepción de cuando el comprador haya cubierto mas de la tercera parte del precio estipulado, en cuyo caso se estará a la Cláusula Décima del presente contrato; 
C) Por haber cambiado su domicilio sin aviso al proveedor, en términos de la cláusula Novena del presente contrato. 
");

	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->Ln(5);
	$texto=iconv('UTF-8', 'windows-1252',"DECIMA CUARTA.- El  Comprador tendrá derecho a demandar la rescisión del presente contrato en los siguientes casos:
A) Por incumplimiento del Vendedor a cualesquiera de las obligaciones.
B) Si el vehículo presentare vicios ocultos que no hayan sido informados a el comprador a través del presente contrato.
C) Si el vendedor no entrega el vehículo en la fecha estipulada en la Cláusula Primera del presente contrato.
D) Si el vehículo le fuera entregado al comprador en condiciones con características distintas a las señaladas en la Cláusula Primera del presente contrato. 

DECIMA QUINTA.- El Vendedor se hace responsable de cualquier situación legal que anteceda a la fecha de compraventa relacionada con el vehículo anteriormente descrito sin ninguna responsabilidad para el comprador. 

DECIMA SEXTA.- El comprador se hace responsable de los daños que pudiera ocasionar con el vehículo objeto del presente contrato, desde la firma del mismo.

DECIMA SEPTIMA.- Los contratantes convienen que por el incumplimiento de cualesquiera de las obligaciones contenidas en el presente contrato, se aplicará una pena convencional, equivalente al 15% del precio de contado del vehículo materia del presente contrato. 

DECIMA OCTAVA.- Para garantizar y asegurar el cumplimiento de todas y cada una de las obligaciones por el comprador en el presente contrato el señor (a) 
");
	
	$pdf->MultiCell(164,4,$texto,0,'J');
	
	
	$pdf->AddPage();
	$pdf->Ln(20);
	do {
		
		$texto=iconv('UTF-8', 'windows-1252',$row_ava["nombre_aval"]);
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(5);
		$texto=iconv('UTF-8', 'windows-1252','Nacionalidad: '.$row_ava["nacionalidad"]);
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(5);
		$texto=iconv('UTF-8', 'windows-1252','Estado Civil: '.$row_ava["edo_civil"]);
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(5);
		$texto=iconv('UTF-8', 'windows-1252','Ocupación: '.$row_ava["ocupacion"]);
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(5);
		$texto=iconv('UTF-8', 'windows-1252','Domicilio: '.$row_ava["domicilio_aval"]);
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(10);
	 } while ($row_ava = mysql_fetch_assoc($ava));
	
	$texto=iconv('UTF-8', 'windows-1252',"Se constituye(n) FIADOR del comprador y se obliga con este al cumplimiento de dichas obligaciones y acepta expresamente que su responsabilidad no terminará hasta que termine por cualquier causa el presente contrato.");
	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->Ln(10);
	
	$texto=iconv('UTF-8', 'windows-1252',"DECIMO NOVENA.- Para todos los efectos legales de este contrato, los contratantes se someten a la competencia de la Procuraduria Federal del Consumidor y Tribunales del lugar en que se haya suscrito, el presente contrato se regirá por las disposiciones aplicables de la Ley Federal de Protección al Consumidor.");
	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->Ln(5);
    /*
	$d1="";
	$d2="";
	$d3="";
	
	if ( ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $row_contra["fecha_contrato"], $regs ) ) {
	
	//echo "$regs[3].$regs[2].$regs[1]";
	
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
	*/
	$texto=iconv('UTF-8', 'windows-1252',"Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]).".");
	//$texto=nombre_fecha($row_contra["fecha_contrato"]);
	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->Ln(20);
	
	$texto=iconv('UTF-8', 'windows-1252',$row_contra["nombre_cliente"]);
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(2);
	$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------------------------------------");
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(3);
	$texto=iconv('UTF-8', 'windows-1252',"Comprador");
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(15);
	
	$texto=iconv('UTF-8', 'windows-1252',$row_emp["representante_empresa"]);
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(2);
	$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------------------------------------");
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(3);
	$texto=iconv('UTF-8', 'windows-1252',"Vendedor");
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(15);
	
	$contador=1;
	do {
		
		/*if ($contador==2) {
			$pdf->Ln(15);
		}*/
		if ($contador==1) {
			$texto=iconv('UTF-8', 'windows-1252',$row_ava2["nombre_aval"]);
			$pdf->Cell(70,4,$texto,0,0,'C');
		}
		if ($contador==2) {
			$texto=iconv('UTF-8', 'windows-1252',$row_ava2["nombre_aval"]);
			$pdf->Cell(0,4,$texto,0,0,'C');
		}
		
		$contador=$contador+1;
	 } while ($row_ava2 = mysql_fetch_assoc($ava2));
	 $pdf->Ln(2);

	for ($i=1; $i<=$contador;$i++)
	{
		if ($i==1) {
			$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------");
			$pdf->Cell(70,4,$texto,0,0,'C');
		}
		if ($i==2) {
			$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------");
			$pdf->Cell(0,4,$texto,0,0,'C');
		}
	}
	$pdf->Ln(2);
	
	for ($i=1; $i<=$contador;$i++)
	{
		if ($i==1) {
			$texto=iconv('UTF-8', 'windows-1252',"Fiador");
			$pdf->Cell(70,4,$texto,0,0,'C');
		}
		if ($i==2) {
			$texto=iconv('UTF-8', 'windows-1252',"Fiador");
			$pdf->Cell(0,4,$texto,0,0,'C');
		}
	}
	$pdf->Ln(15);
	
	$texto=iconv('UTF-8', 'windows-1252',$row_contra["nombre_vendedor"]);
	$pdf->Cell(70,4,$texto,0,0,'C');
	
	$texto=iconv('UTF-8', 'windows-1252',$row_contra["nombre_testigo"]);
	$pdf->Cell(0,4,$texto,0,0,'C');
	$pdf->Ln(2);
	
	$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------");
	$pdf->Cell(70,4,$texto,0,0,'C');
	
	$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------");
	$pdf->Cell(0,4,$texto,0,0,'C');	
	$pdf->Ln(3);
	
	$texto=iconv('UTF-8', 'windows-1252',"Testigo");
	$pdf->Cell(70,4,$texto,0,0,'C');
	
	$texto=iconv('UTF-8', 'windows-1252',"Testigo");
	$pdf->Cell(0,4,$texto,0,0,'C');	
	/*
		$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------");
		$pdf->Cell(70,4,$texto,0,0,'C');
				
		if ($contador==1) {
			$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------");
			$pdf->Cell(0,4,$texto,0,0,'C');
			$pdf->Ln(2);
			
			//$texto=iconv('UTF-8', 'windows-1252',"Vendedor");
			//$pdf->Cell(0,4,$texto,0,0,'C');
		}else {
		$pdf->Ln(2);
		}
		
		$texto=iconv('UTF-8', 'windows-1252',"Fiador");
		$pdf->Cell(70,4,$texto,0,0,'C');
		if ($contador==1) {
			$texto=iconv('UTF-8', 'windows-1252',"Testigo");
			$pdf->Cell(0,4,$texto,0,0,'C');
		}

		*/
		//$pdf->Ln(15);
		
	
	 
	/*$texto=iconv('UTF-8', 'windows-1252',"Nombre del testigo 2");
	$pdf->Cell(0,4,$texto,0,0,'C');
	$pdf->Ln(2);
	 */
	 $pdf->Ln(20);
	 
	$texto=iconv('UTF-8', 'windows-1252',"CONTRATO REGISTRADO ANTE LA PROCURADURIA FEDERAL DEL CONSUMIDOR BAJO EL NUMERO DE REGISTRO 30788-001 DE FECHA 12-MAYO-1999 Y SOLO PODRA SER UTILIZADO POR SOCIOS ACTIVOS DE LA ASOCIACION DE COMERCIANTES EN AUTOMOVILES Y CAMIONES NUEVOS Y USADOS, A. C., QUEDANDO ESTRICTAMENTE PROHIBIDO SU USO POR PARTICULARES O PERSONAS MORALES NO AFILIADAS A LA A. N. C. A. A. C.");
	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->Ln(10);
	
//	$pdf->Cell(10,5,"Unidad de luces",1,0,L,true); 
//	$pdf->Cell(45,5,"Luces",1,0,L,true); 
//	$pdf->Cell(65,5,"Antena",1,0,L,true); 
	//	$pdf->AddPage(); 
//	$pdf->BasicTable($header,$data);
    //$pdf->AddPage(); 
    
/*
	$temporal="";
	$pdf->SetFillColor(230,230,0);
	$pdf->Cell(27,5,"Clave Electoral",1,0,L,true); 
	$pdf->Cell(55,5,"Nombre",1,0,L,true); 
	$pdf->Cell(7,5,"Edad",1,0,L,true); 
	$pdf->Cell(7,5,"Sexo",1,0,L,true); 
	$pdf->Cell(80,5,"Direccion",1,0,L,true); 
	$pdf->Cell(8,5,"C.P.",1,0,L,true); 
	$pdf->Cell(18,5,"Fol. Nac.",1,0,L,true); 
	$pdf->Cell(10,5,"Distrito",1,0,L,true); 
	$pdf->Cell(11,5,"Municipio",1,0,L,true); 
	$pdf->Cell(10,5,"Seccion",1,0,L,true); 
	$pdf->Cell(12,5,"Localidad",1,0,L,true); 
	$pdf->Cell(10,5,"Manzana",1,0,L,true); 
	$pdf->Cell(10,5,"Voto?",1,0,L,true); 
	$pdf->Cell(14,5,"Promovido?",1,0,L,true); 
	$pdf->Ln(5); 
	do {
	    $pdf->Cell(27,5,$row_Recordset1["CLAVE_ELEC"],1); 
		$pdf->Cell(55,5,$row_Recordset1["NOMBRE"]." ".$row_Recordset1["A_PATERNO"]." ".$row_Recordset1["A_MATERNO"],1); 
		$pdf->Cell(7,5,$row_Recordset1["EDAD"],1); 
		$pdf->Cell(7,5,$row_Recordset1["SEXO"],1); 
		if (strlen(trim($row_Recordset1["INTERIOR"])) > 0) {$temporal = " Int. ".$row_Recordset1["INTERIOR"];} else {$temporal="";}
		$pdf->Cell(80,5,$row_Recordset1["CALLE"]." ".$row_Recordset1["EXTERIOR"].$temporal."\n".$row_Recordset1["COLONIA"],1); 
		$pdf->Cell(8,5,$row_Recordset1["COD_POS"],1);
		$pdf->Cell(18,5,$row_Recordset1["FOL_NAC"],1);	
		$pdf->Cell(10,5,$row_Recordset1["DISTRITO"],1);	
		$pdf->Cell(11,5,$row_Recordset1["MUNICIPIO"],1);	
		$pdf->Cell(10,5,$row_Recordset1["SECCION"],1);	
		$pdf->Cell(12,5,$row_Recordset1["LOCALIDAD"],1);	
		$pdf->Cell(10,5,$row_Recordset1["MANZANA"],1);	
		if (strlen(trim($row_Recordset1["x"])) == "1") {$temporal = "Si";} else {$temporal="No";}
		$pdf->Cell(10,5,$temporal,1);	
		if (strlen(trim($row_Recordset1["INV_SOCIAL"])) == "1") {$temporal = "Si";} else {$temporal="No";}
		$pdf->Cell(14,5,$temporal,1);	
    	$pdf->Ln(5); 
	}while ( $row_Recordset1 = mysql_fetch_assoc($Recordset1) );
	//while ( $datos = mysql_fetch_array($Recordset1) );
*/
	$pdf->Output();
//	mysql_free_result($Recordset1);
	//echo "PDF";
	exit;

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
mysql_free_result($contra);
mysql_free_result($emp);
mysql_free_result($autos_d);
mysql_free_result($ava);
mysql_free_result($ava2);
?>
