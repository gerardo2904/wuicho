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

$filtro="";
$filtro=" where clave_contrato='$recordID'";

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_contra = "select clave_contrato, contrato, credito,clave_empresa, contrato.clave_cliente,
DATE_FORMAT(fecha_contrato, '%d-%m-%Y') AS fecha_contrato, forma_pago, promocion, no_pagos, interes, moratorio, cenganche, 
cinteres, acuenta, cprecio, cacuenta, civa, ctotal, clave_inv, clave_inv_acuenta, cefectivo, no_cheque, ccheque, banco_cheque, 
clave_vendedor, clave_cobrador, clave_testigo, garantia, DATE_FORMAT(fecha_garantia, '%d-%m-%Y') AS fecha_garantia,
partes_garantia, aspecto_mec, aspecto_car, aplicado, clave_usuario, saldo_inicial, aspecto_llantas, otros_aspectos, aspecto_otros, 
DATE_FORMAT(fecha_entrega, '%d-%m-%Y') AS fecha_entrega, u_luces, luces, antena, espejos, cristales, tapones, molduras, tapon_gas, 
carroceria_sin_golpes, tablero, calefaccion, aire, limpiadores, radio, bocinas, retrovisor, ceniceros, cinturones, gato, cruceta, 
llanta_refa, estuche_he, triangulo, extinguidor, clientes.nombre_cliente, clientes.rfc_cliente,
clientes.domicilio_cliente, clientes.ciudad_cliente, clientes.estado_cliente, clientes.cp_cliente, clientes.tel_cliente, clientes.fax_cliente, 
clientes.email_cliente, monedas.moneda   
from contrato, clientes, monedas ".$filtro." AND contrato.clave_cliente=clientes.clave_cliente AND contrato.clave_moneda=monedas.clave_moneda";
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

$var=" AND clave_inv=".$row_contra['clave_inv'];
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_autos_d = "SELECT inventario_auto.*, tipo_auto.clave_marca, tipo_auto.modelo, tipo_auto.estilo, marca.marca
 FROM inventario_auto, tipo_auto, marca 
 WHERE inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca".$var;
$autos_d = mysqli_query($contratos_londres, $query_autos_d) or die(mysql_error());
$row_autos_d = mysqli_fetch_assoc($autos_d);
$totalRows_autos_d = mysqli_num_rows($autos_d);



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
//Cabecera de p??gina
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
    //T??tulo
	//$x=$row_emp["nombre_empresa"];
	$this->Cell(150,10,$x,0,0,'C');
    //Salto de l??nea
    $this->Ln(20);
}
*/

//Pie de p??gina
function Footer()
{
    //Posici??n: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //N??mero de p??gina
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
		$pdf->Cell(5,3,"email ",0,0,L);
		$pdf->SetFont('Times','BIU');
		$pdf->SetTextColor(0,0,255);
		$pdf->Cell(53,3,trim($row_emp["email_empresa"]),0,0,"R",false,"mailto:\\".trim($row_emp["email_empresa"]));
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
	$str=iconv("UTF-8", "windows-1252","Contrato de compra venta con reserva de dominio de veh??culo usado, que celebran por una parte el");
		$pdf->Cell(163,3,$str,0,0,"FJ");
	$pdf->Ln(4);
	$pdf->SetFont('Arial','BIU',10);
	$str=iconv("UTF-8", "windows-1252","C. ".trim($row_emp["representante_empresa"]).",");
		$pdf->Cell(113,3,$str,0,0,"FJ");	
	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(95);
	
	$str=iconv("UTF-8", "windows-1252","  Propietario y/o Representante");
		$pdf->Cell(53,3,$str,0,0);
	$pdf->SetLeftMargin(20);
	$pdf->Ln(4);
	
	$str=iconv("UTF-8", "windows-1252","Legal de la negociaci??n denominada ");
		$pdf->Cell(10,3,$str,0,0);
	$pdf->SetFont('Arial','BIU',10);
	$pdf->SetLeftMargin(81);
	
	$str=iconv("UTF-8", "windows-1252",trim($row_emp["nombre_empresa"]).",");
			$pdf->Cell(58 ,3,$str,0,0);	
	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(60);
	$str=iconv("UTF-8", "windows-1252","a quien en lo sucesivo se le");
		$pdf->Cell(0,3,"a quien en lo sucesivo se le",0,0);	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(4);
	$str=iconv("UTF-8", "windows-1252","denominara el vendedor y por otra parte el C.");
		$pdf->Cell(72,3,$str,0,0,"FJ");	
	$pdf->SetFont('Arial','BIU',10);
	$pdf->SetLeftMargin(53);
	$str=iconv('UTF-8', 'windows-1252',trim($row_contra["nombre_cliente"]).",");
		$pdf->Cell(92,3,$str,0,0,"FJ");	
	$pdf->SetLeftMargin(20);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"a quien se le denominara el comprador al tenor de la siguientes declaraciones y cl??usulas:");
		$pdf->Cell(164,3,$str,0,0,"FJ");	

	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(0,3,"DECLARACIONES",0,0,'C');	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(53,3,"DECLARA EL VENDEDOR:",0,0);	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"I.-  Ser una persona f??sica, cuya actividad preponderante es la compra venta de veh??culos usados. ");
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
	$str=iconv('UTF-8', 'windows-1252',trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", con registro federal de contribuyentes ".trim($row_emp["rfc_empresa"])." con horario de atenci??n");
		$pdf->Cell(158,3,$str,0,0,"FJ");
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"al p??blico de ");
		$pdf->Cell(21,3,$str,0,0,P);
	$pdf->SetFont('Arial','B',10);
	$str=iconv('UTF-8', 'windows-1252',"LUNES A SABADO DE 9:00 A.M. A 7:00 P.M.");
		$pdf->Cell(57,3,$str,0,0,P);
	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(20);
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"III.-Que es una persona f??sica con actividad empresarial.");
		$pdf->Cell(50,3,$str,0,0,P);
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"IV.-Declara el vendedor que previamente a la celebraci??n del presente contrato le ha informado al ");
		$pdf->Cell(164,3,$str,0,0,"FJ");
	$pdf->Ln(4);
	$pdf->SetLeftMargin(26);
	$str=iconv('UTF-8', 'windows-1252',"comprador de todas y cada una de las condiciones generales mec??nicas del veh??culo, para que");
		$pdf->Cell(157,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"en su caso sea revisado por este ??ltimo. 	");
		$pdf->Cell(50,3,$str,0,0,P);	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(10);
	$pdf->Cell(53,3,"DECLARA EL COMPRADOR:",0,0);	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"I.- Llamarse como ha quedado expresado, tener su domicilio: 	"); 
		$pdf->Cell(164,3,$str,0,0);	
	$pdf->SetLeftMargin(24);
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',trim($row_contra["domicilio_cliente"]).",");
		$pdf->Cell(159,3,$str,0,0,"FJ");
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',trim($row_contra["ciudad_cliente"]).",".trim($row_contra["estado_cliente"]).", con registro federal de causantes ".trim($row_contra["rfc_cliente"])."Y capacidad jur??dica para obligarse  ");
		$pdf->Cell(161,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"y manifiesta que antes de firmar ha le??do el clausulado de este contrato.");
		$pdf->Cell(0,3,$str,0,0,P);	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"II.-Que previamente a la celebraci??n del presente contrato, se le inform?? al comprador sobre el precio");
		$pdf->Cell(164,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$pdf->SetLeftMargin(24);
	$str=iconv('UTF-8', 'windows-1252',"de contado del veh??culo usado, objeto del presente contrato, el monto de los intereses. La tasa que se ");
		$pdf->Cell(161,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"calcularan, el monto y detalle de los cargos, el n??mero de pagos a realizar, su periodicidad, la");
		$pdf->Cell(161,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"cantidad total a pagar por dicho veh??culo y el derecho que tiene a liquidar anticipadamente el cr??dito");
		$pdf->Cell(161,3,$str,0,0,"FJ");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"con la consiguiente reducci??n de intereses.");
		$pdf->Cell(0,3,$str,0,0,P);	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(0,3,"CLAUSULAS",0,0,'C');	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	$str=iconv('UTF-8', 'windows-1252',"PRIMERA.- El vendedor vende y el comprador compra el veh??culo que a continuaci??n se describe:");
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
	$pdf->Cell(25,3,"ODOMETRO ",0,0);$pdf->Cell(55,3,$row_autos_d["km"],0,0);$pdf->Cell(25,3,"COLOR",0,0);$pdf->Cell(55,3,$row_autos_d["color"]);
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
	$str=iconv('UTF-8', 'windows-1252',"La Unidad descrita con anterioridad ser?? entregada el dia: ");
		$pdf->Cell(95,3,$str,0,0);	
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell(0,3,$row_contra["fecha_entrega"],0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(12);
	$pdf->Cell(45,3,"Nombre y firma del cliente: ",0,0);	
	$pdf->SetFont('Arial','BU',10);
	$str=iconv('UTF-8', 'windows-1252',$row_contra["nombre_cliente"]."                                                           ");
		$pdf->Cell(0,3,$str,0,0);	
	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(20);
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	$pdf->Ln(20);
	$str=iconv('UTF-8', 'windows-1252',"SEGUNDA.- El vendedor en este acto, exhibe al comprador la documentaci??n en copia simple que ampara");
	$pdf->Cell(161,3,$str,0,0,"FJ");
	$pdf->Ln(5);
	$str=iconv('UTF-8', 'windows-1252',"la propiedad del veh??culo descrito en la cl??usula anterior, cerciorado de que dicha documentaci??n");
		$pdf->Cell(161,3,$str,0,0,"FJ");
	$pdf->Ln(5);
	$str=iconv('UTF-8', 'windows-1252',"corresponde fielmente al citado veh??culo y se encuentra en regla quedando en poder del vendedor la ");
		$pdf->Cell(162,3,$str,0,0,"FJ");
	$pdf->Ln(5);
	$str=iconv('UTF-8', 'windows-1252',"documentaci??n original, hasta en tanto no sea liquidado totalmente el precio pactado.");
		$pdf->Cell(161,3,$str,0,0,P);
	$pdf->Ln(8);
	$pdf->SetLeftMargin(24);
	$str=iconv('UTF-8', 'windows-1252',"Factura Numero: ");
		$pdf->Cell(75,3,$str,0,0);
	$str=iconv('UTF-8', 'windows-1252',"Expedida por: ");
		$pdf->Cell(65,3,$str,0,0);
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Pago de tenencia Vehicular por los a??os:");
		$pdf->Cell(85,3,$str,0,0);
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Tarjeta de circulaci??n n??mero:");
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Otros documentos ");
		$pdf->Cell(85,3,$str,0,0);		
	$pdf->SetLeftMargin(20);
	$pdf->Ln(8);	
	$str=iconv('UTF-8', 'windows-1252',"TERCERA.- El precio de la compraventa lo han determinado de com??n acuerdo el vendedor y el comprador");
		$pdf->Cell(161,3,$str,0,0,"FJ");
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"sobre las siguientes bases:");
		$pdf->Cell(0,3,$str,0,0,P);
	$pdf->Ln(8);
	$i="";
	switch ($row_contra["moneda"]) {
    case "Dolar":
        $i="DLLS. MONEDA DE LOS EUA.";
        break;
    case "Peso":
        $i="Pesos. MONEDA NACIONAL MEXICANA";
        break;
	}
	$str=iconv('UTF-8', 'windows-1252',"VALOR DE LA UNIDAD ");
		$pdf->Cell(75,3,$str,0,0);
	$str=iconv('UTF-8', 'windows-1252',$row_contra["cprecio"]);
		$pdf->Cell(25,3,$str,0,0,"R");
	$str=iconv('UTF-8', 'windows-1252',$i);	
		$pdf->Cell(60,3,$str,0,0,"R");
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"ENGANCHE A LA FIRMA DEL CONTRATO");
		$pdf->Cell(75,3,$str,0,0);
		$pdf->Cell(26,3,"(".$row_contra["cenganche"].")",0,0,"R");
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"UNIDAD USADA A CUENTA ");
		$pdf->Cell(75,3,$str,0,0);
		$pdf->Cell(26,3,"(".$row_contra["cacuenta"].")",0,0,"R");	
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"SALDO ");
		$pdf->Cell(75,3,$str,0,0);
		$pdf->Cell(25,3,$row_contra["saldo_inicial"],0,0,"R");
	$pdf->Ln(6);
	$str=iconv('UTF-8', 'windows-1252',"INTERESES ");
		$pdf->Cell(75,3,$str,0,0);
		$pdf->Cell(25,3,$row_contra["cinteres"],0,0,"R");
	$pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"IVA ");
		$pdf->Cell(75,3,$str,0,0);
		$pdf->Cell(25,3,$row_contra["civa"],0,0,"R");	
	$pdf->Ln(6);	
	$str=iconv('UTF-8', 'windows-1252',"SALDO ");
		$pdf->Cell(75,3,$str,0,0);
	$str=iconv('UTF-8', 'windows-1252',$row_contra["ctotal"]);
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
		
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(0,3,"MONTO DE INTERESES",0,0,'C');	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	
	$texto="";
	$texto=iconv('UTF-8', 'windows-1252',"Las partes convienen expresamente en que los intereses ordinarios causados por el total a que se refiere la cl??usula tercera se cobraran a raz??n del porcentaje que acuerden al momento del otorgamiento del cr??dito y firma del presente contrato, los cuales se calcularan conforme a una tasa fija o variable en los t??rminos de lo establecido en el art??culo 66 de la Ley Federal de Protecci??n al Consumidor y se causaran intereses moratorios, aplicando la tasa del 5%  mensual que de com??n acuerdo establecieron las partes al momento del otorgamiento del cr??dito y firma del presente contrato.");
	$pdf->MultiCell(164,4,$texto,0,'J');	
	
	$texto="";
	$texto=iconv('UTF-8', 'windows-1252',"El comprador podr?? en cualquier momento liquidar anticipadamente el saldo del precio del veh??culo, en caso de estar aplicado a la promoci??n de cero enganche y cero intereses de financiamiento, el plazo que se acuerde puede ser de 24, 30 y 36 meses con cero de interes y cero de enganche. 

En caso de solicitar 12 meses m??s para el pago total de su veh??culo la tasa de inter??s sera del 20% correspondiente a los 12 ??ltimos meses, en caso de pagar anticipadamente habr?? una reducci??n del monto de los intereses , que aun no est??n vencidos.

Los pagos anticipados parciales se aplicar??n en orden de fechas de los vencimientos m??s pr??ximos.

CUARTA: El comprador se compromete a pagar al Vendedor como precio total de este contrato, la cantidad establecida en la cl??usula que antecede, en mensualidades que asciende al monto de:
");
	$pdf->MultiCell(164,4,$texto,0,'J');	
	
	$texto="";
	$texto=iconv('UTF-8', 'windows-1252',"_______________________________________________________________________________
_______________________________________________________________________________
Cada uno, que vencer??n con la siguiente periodicidad ______________________ y en forma sucesiva los dias _____________ a partir del dia ________________________________________
");
	$pdf->MultiCell(164,4,$texto,0,'J');	
	$pdf->Ln(4);	
	$texto="";
	$texto=iconv('UTF-8', 'windows-1252',"Dichos pagos podr??n ser liquidados en su equivalente en Moneda Nacional, al tipo de cambio libre que rija la banca el d??a que se efect??e el pago.  Para tal efecto se acepta  efectivo en d??lares, moneda nacional, transferencias bancarias, dep??sitos en cuenta de cheques. NO SE ACEPTAN TARJETAS DE CREDITO NI TARJETAS DE DEBITO DE NINGUN TIPO. 

QUINTA:  Ambos contratantes convienen que el  Vendedor, de acuerdo con lo establecido en el art??culo 2312 del C??digo Civil  para el Distrito Federal, se reserva el dominio del veh??culo, materia del presente contrato, hasta que el precio pactado y derivaciones legales est??n ??ntegramente pagados. 

SEXTA: Los documentos que amparan la propiedad descrita en la cl??usula segunda, permanecer??n en poder del vendedor, como garant??a de la reserva de dominio del veh??culo objeto del presente contrato expidi??ndole al comprador las copias fotost??ticas respectivas que acrediten su leg??tima propiedad. 
");
	$pdf->MultiCell(164,4,$texto,0,'J');	
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',15);
	$texto="";
	if ($row_contra["garantia"]==1){
	$pdf->Cell(0,3,"GARANTIA",0,0,'C');	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
		$texto="";
	$texto=iconv('UTF-8', 'windows-1252',"SEPTIMA.- El comprador acepta que por tratarse de una unidad usada adquiere el veh??culo objeto del presente contrato, en el estado de uso en que se encuentra, el cual le fue facilitado para su revisi??n general, por cuyo motivo cuenta con una garant??a de 60 d??as de acuerdo con el art??culo 77 de la Ley Federal de Protecci??n al Consumidor cuya reforma salio publicada en DOF el 04-02-2004, y para dar cumplimiento a lo dispuesto por la NOM-122-SCFI-2010, a partir del dia");
	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->AddPage();
	$pdf->Ln(20);
	$texto=iconv('UTF-8', 'windows-1252'," ____________________  y termina el dia _______________________ o 3,000 millas, lo que suceda primero, en las siguientes partes: MOTOR Y TRANSMICION,   NO TIENEN GARANTIA PARTES ELECTRICAS  NI  LA BOMBA DE GASOLINA. 

El cumplimiento a la Garant??a arriba mencionada se har?? en el domicilio ubicado en Blvd. S??nchez Taboada No. 53 Zona R??o de esta ciudad de Tijuana, Baja California
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
	$texto=iconv('UTF-8', 'windows-1252',"SEPTIMA. El comprador acepta que por tratarse de una unidad usada adquiere el veh??culo objeto del presente contrato, en el estado de uso en el que se encuentra, el cual le fue facilitado para su revisi??n general, ambas partes est??n  de acuerdo en que esta unidad NO TIENE GARANTIA, por lo");
	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->AddPage();
	$pdf->Ln(20);
	$texto=iconv('UTF-8', 'windows-1252',"cual se hace un ajuste en el precio del veh??culo  por la cantidad de:___________________________
la cual aparece especificada en la Cl??usula Tercera del presente contrato.");
	$pdf->MultiCell(164,4,$texto,0,'J');
	}
	$texto=iconv('UTF-8', 'windows-1252',"Firmo de Conformidad ya que el Vendedor me ha explicado y he entendido totalmente el concepto aqu?? contenido. 

FIRMA DEL COMPRADOR_____________________________________ FECHA____________
");
	$pdf->MultiCell(164,4,$texto,0,'J');
	
	$texto=iconv('UTF-8', 'windows-1252',"OCTAVA.- El comprador se obliga a no vender, ni gravar en forma alguna el veh??culo objeto de este contrato, hasta que se liquide el precio en su totalidad. 

NOVENA.- El Comprador tendr?? la obligaci??n de informar al Vendedor durante la vigencia del contrato sobre el cambio de domicilio que llegare a tener, en un plazo m??ximo de 15 dias posteriores a la verificaci??n del cambio . En caso de incumplimiento a esta cl??usula el Comprador esta de acuerdo en pagar la cantidad de $ 1,000.00 Pesos M.N. por  gastos de localizaci??n.

DECIMA.- Para  dar cumplimiento a lo previsto por el art??culo 70 de la Ley Federal de Protecci??n al Consumidor, los contratantes de Com??n acuerdo y para el caso de que se rescindiera el presente contrato, deber??n restituirse las prestaciones que se hubieran hecho si el comprador hubiera pagado 
mas de la tercera parte del importe de la compra venta, podr?? optar por la rescisi??n o el pago del adeudo vencido, en t??rminos de lo previsto por el art??culo 71 del citado ordenamiento legal. 
");
	$pdf->MultiCell(164,4,$texto,0,'J');
	
	$texto=iconv('UTF-8', 'windows-1252',"DECIMA PRIMERA.- El comprador asumir?? al momento de recibir el veh??culo, la responsabilidad sobre el buen uso del mismo, desde la entrega del bien. 

DECIMA SEGUNDA.- Con base en lo previsto por el art??culo 66 de la Ley Federal de Protecci??n al Consumidor, los pagos no cubiertos a su vencimiento, adem??s del inter??s ordinario pactado en la 
Cl??usula Tercera del presente contrato causar?? un inter??s moratorio del 5% mensual convenidos por ambas partes de com??n acuerdo. 

DECIMA TERCERA.- El vendedor podr?? demandar la rescisi??n o el vencimiento del saldo del adeudo del presente contrato y en consecuencia exigir su pago total cuando ocurran cualesquiera de las siguientes causas:

A) Cuando el veh??culo objeto de la compra venta sufra destrucci??n total o da??os parciales que afectan su naturaleza o ??ste sea materia de embargo, secuestro judicial u otro acontecimiento semejante a los citados en esta cl??usula de lo que sea responsable el comprador, por cesi??n o traspaso de derechos o arrendamiento del veh??culo y de cualquiera de los derechos que adquiere el Comprador y sin que medie consentimiento otorgado por escrito del Vendedor.
B) Por falta de pago, a la fecha del vencimiento de dos o mas abonos pactados con excepci??n de cuando el comprador haya cubierto mas de la tercera parte del precio estipulado, en cuyo caso se estar?? a la Cl??usula D??cima del presente contrato; 
C) Por haber cambiado su domicilio sin aviso al proveedor, en t??rminos de la cl??usula Novena del presente contrato. 
");
	$pdf->MultiCell(164,4,$texto,0,'J');
	
	$texto=iconv('UTF-8', 'windows-1252',"DECIMA CUARTA.- El  Comprador tendr?? derecho a demandar la rescisi??n del presente contrato en los siguientes casos:
A) Por incumplimiento del Vendedor a cualesquiera de las obligaciones.
B) Si el veh??culo presentare vicios ocultos que no hayan sido informados a el comprador a trav??s del presente contrato.
C) Si el vendedor no entrega el veh??culo en la fecha estipulada en la Cl??usula Primera del presente contrato.
D) Si el veh??culo le fuera entregado al comprador en condiciones con caracter??sticas distintas a las se??aladas en la Cl??usula Primera del presente contrato. 

DECIMA QUINTA.- El Vendedor se hace responsable de cualquier situaci??n legal que anteceda a la fecha de compraventa relacionada con el veh??culo anteriormente descrito sin ninguna responsabilidad para el comprador. 

DECIMA SEXTA.- El comprador se hace responsable de los da??os que pudiera ocasionar con el veh??culo objeto del presente contrato, desde la firma del mismo.

DECIMA SEPTIMA.- Los contratantes convienen que por el incumplimiento de cualesquiera de las obligaciones contenidas en el presente contrato, se aplicar?? una pena convencional, equivalente al 15% del precio de contado del veh??culo materia del presente contrato. 

DECIMA OCTAVA.- Para garantizar y asegurar el cumplimiento de todas y cada una de las obligaciones por el comprador en el presente contrato el se??or (a) 
");
	$pdf->MultiCell(164,4,$texto,0,'J');
	
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
	}while ( $row_Recordset1 = mysqli_fetch_assoc($Recordset1) );
	//while ( $datos = mysql_fetch_array($Recordset1) );
*/
	$pdf->Output();
//	mysqli_free_result($Recordset1);
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
mysqli_free_result($contra);
mysqli_free_result($emp);
mysqli_free_result($autos_d);

?>
