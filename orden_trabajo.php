<?php
    $pdf=new PDF('L','mm','Legal'); 
	$pdf->Open();  
	
	


// *********************************************
// ************ CARATULA ***********************
// *********************************************


	$pdf->AddPage();
	$pdf->SetFont('Arial','B',12); 
	$pdf->AliasNbPages();
	//$pdf->Ln(1);
	$pdf->Image('Imagenes/jedda-logo.jpeg',20,17,45);
	$pdf->SetLeftMargin(70);
	$pdf->Cell(100,-20,trim($row_emp["nombre_empresa"]),0,0,'P');
	$pdf->SetFont('Arial','',12); 
	$pdf->Ln(-6);
	if (strlen($row_emp["registro_empresa"])==0) {$t="";} else {$t=", ".trim($row_emp["registro_empresa"]);}
	$pdf->Cell(50,3,'RFC '.trim($row_emp["rfc_empresa"]).$t,0,0,'P');
	$pdf->Ln(4);
	$pdf->Cell(50,3,trim($row_emp["domicilio_empresa"]),0,0,'P');
	$pdf->Ln(4);
	$pdf->Cell(50,3,trim($row_emp["ciudad_empresa"]).', '.trim($row_emp["estado_empresa"]),0,0,'P');	
	
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
		$pdf->Cell(50,3,$t,0,0,'P');	
	}
	if (strlen($row_emp["email_empresa"])>0)
	{
		$pdf->Ln(4);
		$pdf->Cell(11,3,"email ",0,0,'L');
		$pdf->SetFont('Times','BIU');
		$pdf->SetTextColor(0,0,255);
		$pdf->Cell(0,3,trim($row_emp["email_empresa"]),0,0,"L",false,"mailto:\\".trim($row_emp["email_empresa"]));
	}
	$pdf->SetLeftMargin(300);
	$pdf->Ln(-22);	
	$pdf->SetFont('Times','B');
	$pdf->SetTextColor(255,0,0);
	$pdf->Cell(53,3,'Orden de trabajo: '.trim($row_contra["contrato"]),0,0);
	$pdf->SetTextColor(0,0,255);
	$pdf->Ln(5);	
	$pdf->Cell(53,3,'Fecha: '.trim($row_contra["fecha_contrato"]),0,0);
	
	$pdf->SetLeftMargin(10);
	$pdf->Ln(30);	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFillColor(243,136,113);
	$pdf->MultiCell(330,10,'MANTENIMIENTO CORRECTIVO',1,'C',1);
	
	$pdf->Ln(1);
	$pdf->SetFillColor(255,255,255);
	$var=trim($row_contra["equipo"]);
	$pdf->MultiCell(130,6,'Equipo: '.$var,1,'L');
	
	$pdf->SetLeftMargin(140);
	$pdf->Ln(-6);
	$var=trim($row_contra["modelo"]);
	$pdf->MultiCell(130,6,'Modelo: '.$var,1,'L');

	$pdf->SetLeftMargin(270);
	$pdf->Ln(-6);
	$var=trim($row_contra["modelo"]);
	$pdf->MultiCell(70,6,'No. de serie: '.$var,1,'L');	

	$pdf->SetLeftMargin(10);
	$pdf->Ln(0);
	$pdf->SetFillColor(255,255,255);
	$var=trim($row_contra["reporto"]);
	$pdf->MultiCell(130,6,'Reporto: '.$var,1,'L');
	
	$pdf->SetLeftMargin(140);
	$pdf->Ln(-6);
	$var=trim($row_contra["fecha_reporte"]);
	$pdf->MultiCell(130,6,'Fecha: '.$var,1,'L');

	$pdf->SetLeftMargin(270);
	$pdf->Ln(-6);
	$var=trim($row_contra["visita_no"]);
	$pdf->MultiCell(70,6,'Visita: '.$var,1,'L');	

	$pdf->SetLeftMargin(10);
	$pdf->Ln(0);
	$pdf->SetFillColor(255,255,255);
	$var=trim($row_contra["falla"]);
	$pdf->MultiCell(330,6,'Falla: '.$var,1,'L');

	$pdf->SetLeftMargin(10);
	$pdf->Ln(0);
	$pdf->SetFillColor(255,255,255);
	$var=trim($row_contra["contacto"]);
	$pdf->MultiCell(130,6,'Contacto: '.$var,1,'L');
	
	$pdf->SetLeftMargin(140);
	$pdf->Ln(-6);
	$var=trim($row_contra["fecha_inicio"]);
	$pdf->MultiCell(70,6,'Fecha inicio: '.$var,1,'L');

	$pdf->SetLeftMargin(210);
	$pdf->Ln(-6);
	$var=trim($row_contra["fecha_fin"]);
	$pdf->MultiCell(75,6,'Fecha termino: '.$var,1,'L');

	$pdf->SetLeftMargin(285);
	$pdf->Ln(-6);
	$var=(trim($row_contra["visita_no"])=="1" ? 'Si' : 'No');
	$pdf->MultiCell(55,6,'SVC terminado: '.$var,1,'L');	

	$pdf->SetLeftMargin(10);
	$pdf->Ln(1);	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFillColor(243,136,113);
	$pdf->MultiCell(330,6,'REPORTE DEL INGENIERO',1,'C',1);

	$pdf->SetLeftMargin(10);
	$pdf->Ln(0);
	$pdf->SetFillColor(255,255,255);
	$var=trim($row_contra["reporte_ingeniero"]);
	$pdf->MultiCell(330,20,iconv("UTF-8", "windows-1252",$var),1,'L');

	$pdf->SetLeftMargin(10);
	$pdf->Ln(1);	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFillColor(243,136,113);
	$pdf->MultiCell(330,6,'REFACCIONES',1,'C',1);

	$pdf->Ln(0);
	$pdf->SetLeftMargin(10);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFillColor(255,255,255);
	do{
		$pdf->MultiCell(20,6,$row_refacciones["cantidad_parte"],1,'C',1);
		$pdf->Ln(-6);
		$pdf->SetLeftMargin(30);
		$pdf->MultiCell(130,6,$row_refacciones["no_parte"],1,'C',1);
		$pdf->Ln(-6);
		$pdf->SetLeftMargin(140);
		$pdf->MultiCell(200,6,$row_refacciones["descripcion_parte"],1,'C',1);
		
		$pdf->SetLeftMargin(10);
		$pdf->Ln(0);

	} while ($row_refacciones = mysqli_fetch_assoc($refacciones));

	$pdf->SetLeftMargin(10);
	$pdf->Ln(1);	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFillColor(243,136,113);
	$pdf->MultiCell(330,6,'SOLUCION',1,'C',1);

	$pdf->Ln(0);
	$pdf->SetLeftMargin(10);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFillColor(255,255,255);
	$var=trim($row_contra["solucion"]);
	$pdf->MultiCell(330,20,iconv("UTF-8", "windows-1252",$var),1,'L');

	$pdf->SetLeftMargin(240);
	$pdf->Ln(10);
	$texto=iconv('UTF-8', 'windows-1252',$row_contra['nombre_vendedor']);
	$pdf->Cell(70,4,$texto,0,0,'C');
	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(3);
	$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------");
	$pdf->Cell(70,4,$texto,0,0,'C');

	$pdf->SetLeftMargin(130);
	$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------");
	$pdf->Cell(70,4,$texto,0,0,'C');

	$pdf->SetLeftMargin(240);
	$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------");
	$pdf->Cell(70,4,$texto,0,0,'C');	

	$pdf->SetLeftMargin(20);
	$pdf->Ln(5);
	$texto=iconv('UTF-8', 'windows-1252',"NOMBRE");
	$pdf->Cell(70,4,$texto,0,0,'C');

	$pdf->SetLeftMargin(130);
	$texto=iconv('UTF-8', 'windows-1252',"FIRMA");
	$pdf->Cell(70,4,$texto,0,0,'C');

	$pdf->SetLeftMargin(240);
	$texto=iconv('UTF-8', 'windows-1252',"NOMBRE Y FIRMA INGENIERO");
	$pdf->Cell(70,4,$texto,0,0,'C');	


	$pdf->Output();

	exit;
?>