<?php

//FECHA DE ENTREGA

$pdf->Ln(8);
	$str=iconv('UTF-8', 'windows-1252',"La Unidad descrita con anterioridad será entregada el dia: ");
		$pdf->Cell(101,3,$str,0,0);	
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
    
// DETALLES FACTURA

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
	

?>