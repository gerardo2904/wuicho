<?php
    $pdf=new PDF('P','mm','Legal'); 
	$pdf->Open();  
	
	


// *********************************************
// ************ CARATULA ***********************
// *********************************************


	$pdf->AddPage();
	$pdf->SetFont('Arial','B',12); 
	$pdf->AliasNbPages();
	//$pdf->Ln(1);
	$pdf->Image('Imagenes/londres_logo4.jpg',20,17,45);
	$pdf->SetLeftMargin(70);
	$pdf->Cell(100,-5,trim($row_emp["nombre_empresa"]),0,0,'P');
	$pdf->SetFont('Arial','',12); 
	$pdf->Ln(1);
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
	$pdf->SetLeftMargin(20);
	$pdf->Ln(7);	
	$pdf->SetFont('Times','B');
	$pdf->SetTextColor(255,0,0);
	$pdf->Cell(53,3,'CONTRATO: '.trim($row_contra["contrato"]),0,0);
	$pdf->SetTextColor(0,0,255);
	$pdf->Ln(5);	
	if ($row_contra["garantia"]==1)
	{
		$pdf->Cell(53,3,'VEHICULO MOTOR VENDIDO CON GARANTIA',0,0);
	}
	else
	{
		$pdf->Cell(53,3,'VEHICULO MOTOR VENDIDO SIN GARANTIA',0,0);
	}
	
	$pdf->Ln(6);
	$pdf->SetTextColor(0,0,0);
	$cadena="Siendo las ".date("G")." horas con ".date("i")." minutos en la ciudad de "."Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"]);
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		
	
	$pdf->SetFont('Arial','',11); 
	$pdf->SetTextColor(0,0,0);
	$pdf->SetLeftMargin(20);
	//$pdf->SetRightMargin(30);
	$pdf->Ln(8);
	if (trim($row_emp["representante_empresa"])=="SUCESION A BIENES DE MARIA ANGELICA DIAZ DE LEON FLEURY") {
		$str=iconv("UTF-8", "windows-1252","Contrato de compra venta a plazos con reserva de dominio de veh??culo usado, que celebran por una parte la");
	}else{
		$str=iconv("UTF-8", "windows-1252","Contrato de compra venta a plazos con reserva de dominio de veh??culo usado, que celebran por una parte el");
	}
		
    $pdf->MultiCell(163,4,$str,0,'C');

	$pdf->Ln(2);
	$pdf->SetFont('Arial','BIU',11);
	if (trim($row_emp["representante_empresa"])=="SUCESION A BIENES DE MARIA ANGELICA DIAZ DE LEON FLEURY") {
		$str=iconv("UTF-8", "windows-1252",trim($row_emp["representante_empresa"]).",");
	}else{
		$str=iconv("UTF-8", "windows-1252","C. ".trim($row_emp["representante_empresa"]).",");
	}
	

	$pdf->Cell(163,3,$str,0,0,"C");
    $pdf->SetFont('Arial','',11);
	$pdf->SetLeftMargin(20);
	$pdf->Ln(6);
	$str=iconv("UTF-8", "windows-1252","apoderado y/o Representante Legal de la negociaci??n denominada");
    //$pdf->Cell(163,3,$str,0,0,"FJ");
    $pdf->MultiCell(163,3,$str,0,'C');

	$pdf->SetLeftMargin(20);
	$pdf->Ln(2);
	
	//$str=iconv("UTF-8", "windows-1252","Legal de la negociaci??n denominada ");
	//$pdf->Cell(10,3,$str,0,0);
	$pdf->SetFont('Arial','BIU',11);
	$pdf->SetLeftMargin(20);
	
	if (trim($row_emp["representante_empresa"])=="SUCESION A BIENES DE MARIA ANGELICA DIAZ DE LEON FLEURY") {
		$str=iconv("UTF-8", "windows-1252","MARIA ANGELICA DIAZ DE LEON FLEURY".",");
		
	}else{
		$str=iconv("UTF-8", "windows-1252",trim($row_emp["nombre_empresa"]).",");
	}
	//$pdf->Cell(163 ,3,$str,0,0,"C");	
    $pdf->MultiCell(163,3,$str,0,'C');
	$pdf->Ln(2);

	$pdf->SetFont('Arial','',11);
	$pdf->SetLeftMargin(20);
	
	if (trim($row_emp["representante_empresa"])=="SUCESION A BIENES DE MARIA ANGELICA DIAZ DE LEON FLEURY") {
	$cadena="representada por conducto de su Albacea, el Sr. C??sar Antonio C??zares D??az de Le??n, ";
    $cadena.="a quien en lo sucesivo se le denominara el vendedor y por la otra parte, el (la) se??or(a)";    
        
    //$str=iconv("UTF-8", "windows-1252","representada por conducto de su Albacea, el Sr. C??sar Antonio C??zares D??az de Le??n,");
		//$pdf->Cell(163,3,$str,0,0,"FJ");		
	
	//$pdf->Ln(4);
	//$str=iconv("UTF-8", "windows-1252","a quien en lo sucesivo se le denominara el vendedor y por otra parte el");
	//	$pdf->Cell(163,3,$str,0,0,"FJ");		
		
	}else{
	    //$str=iconv("UTF-8", "windows-1252","a quien en lo sucesivo se le denominara el vendedor y por otra parte el");
		//$pdf->Cell(163,3,$str,0,0,"FJ");	
        $cadena.="a quien en lo sucesivo se le denominara el vendedor y por la otra parte, el (la) se??or(a)";    
	}
    $str=iconv("UTF-8", "windows-1252",$cadena);
    $pdf->Ln(1);
    $pdf->MultiCell(163,4,$str,0,'C');

	
	$pdf->SetLeftMargin(20);
	//$pdf->Ln(4);
	//$str=iconv("UTF-8", "windows-1252","denominara el vendedor y por otra parte el: ");
	//	$pdf->Cell(58,3,$str,0,0,"L");	
    $pdf->Ln(2);
	$pdf->SetFont('Arial','BIU',11);
	$pdf->SetLeftMargin(20);
	$str=iconv('UTF-8', 'windows-1252',"C. ".trim($row_contra["nombre_cliente"]).",");
	$pdf->Cell(163,3,$str,0,0,"C");	
	//$pdf->MultiCell(92,3,$str,0,'FJ');
	$pdf->SetLeftMargin(20);
	$pdf->SetFont('Arial','',11);
	$pdf->Ln(5);
	$str=iconv('UTF-8', 'windows-1252',"a quien en lo sucesivo, se le denominara el comprador, y el (la) se??or(a)");
    $pdf->MultiCell(164,3,$str,0,'C');	

    $pdf->Ln(2);
	$pdf->SetFont('Arial','BIU',11);
	$pdf->SetLeftMargin(20);
	$str=iconv('UTF-8', 'windows-1252',"C. ".trim($row_ava["nombre_aval"]).",");
	$pdf->Cell(163,3,$str,0,0,"C");	

    $pdf->SetLeftMargin(20);
	$pdf->SetFont('Arial','',11);
	$pdf->Ln(5);
	$str=iconv('UTF-8', 'windows-1252',"en su car??cter de deudor(a) solidario(a) y aval, para responder a todas las obligaciones contra??das en el presente acto, a quien en lo sucesivo se le denominara el deudor solidario, al tenor de las siguientes declaraciones y clausulas:");
    $pdf->MultiCell(164,4,$str,0,'C');	


	$pdf->Ln(6);
	$pdf->SetFont('Arial','B',15);
	//$pdf->Cell(0,3,"DECLARACIONES",0,0,'C');	
	$pdf->MultiCell(164,4,"DECLARACIONES",0,'C');	
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(53,3,"I.- DECLARA EL VENDEDOR:",0,0);	
	$pdf->Ln(4);

    $asociado="__________";
    if (strlen(trim($row_emp["registro_empresa"]))>=1){
        $asociado=trim($row_emp["registro_empresa"]);
    }

    $cadena="a) Ser una persona ".trim($row_emp["persona"]).", cuya actividad preponderante es la compra venta de veh??culos usados, que se encuentra debidamente registrada como socio activo en la Asociaci??n Nacional de Comerciantes en Automoviles y Camiones Nuevos y Usados, A. C. (ANCA) con el n??mero de asociado ".$asociado."; informaci??n que se puede consultar, asi como obtener servicios de orientaci??n para la venta y/o adquisici??n de veh??culos usados en el tel??fono de ANCA: 018002602622; fax 5555352608; correo electr??nico contacto@anca.com.mx de manera gratuita.";
	$str=iconv('UTF-8', 'windows-1252',$cadena);
    $pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $rep="_________________________________________";
    
    if (strlen(trim($row_emp["representante_empresa"]))>=1) 
        $rep=trim($row_emp["representante_empresa"]); 

    $tnrep="___________";
        
    if (strlen(trim($row_emp["testimonio_notarial_rep"]))>=1)    
        $tnrep=trim($row_emp["testimonio_notarial_rep"]);

    $nrep="___________";
        
    if (strlen(trim($row_emp["notario_rep"]))>=1)    
        $nrep=trim($row_emp["notario_rep"]);

    $crep="___________";

    if (strlen(trim($row_emp["ciudad_rep"]))>=1)    
        $crep=trim($row_emp["ciudad_rep"]);

    $nnrep="_______________________________________";

    if (strlen(trim($row_emp["nombre_notario_rep"]))>=1)    
        $nnrep=trim($row_emp["nombre_notario_rep"]);


    $cadena="b) Que esta representada por ".$rep." seg??n testimonio notarial No.".$tnrep." pasado ante la fe del Notario P??blico No.".$nrep." de ".$crep.", Lic.".$nnrep;
	$str=iconv('UTF-8', 'windows-1252',$cadena);
    $pdf->MultiCell(164,4,$str,0,'J');


	$pdf->Ln(2);

    $cadena="c) Tener su domicilio en ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", con registro federal de contribuyentes ".trim($row_emp["rfc_empresa"]).", con tel??fonos  ".trim($row_emp["tel_empresa"])." con horario de atenci??n al p??blico de LUNES A SABADO DE 9:00 A.M. A 7:00 P.M.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');


	$pdf->Ln(2);	
    $cadena="d) Que cuenta con la infraestructura y capacidad necesarias para la comercializaci??n de veh??culos usados y cuenta con las licencias, permisos, avisos o autorizaciones necesarias para llevar a cabo su actividad y que el veh??culo usado cumple con los lineamientos en materia de control de emisi??n de contaminantes, protecci??n al medio ambiente, todas las especificaciones legales y comerciales para poder ser comercializado.";
	$str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');



	//////////////////////////////////////////////// SI es susesion a bienes...
	if (trim($row_emp["representante_empresa"])=="SUCESION A BIENES DE MARIA ANGELICA DIAZ DE LEON FLEURY") {
	   $pdf->Ln(2);	
       $cadena="Que cuenta con personalidad jur??dica toda vez que le fue designado el car??cter de albacea por parte de la Se??ora Mar??a Ang??lica D??az de Le??n Fleury, mismo que fue aceptado y protestado en esta misma ciudad , el d??a 06 de Junio del dos mil cinco , mediante la junta de herederos prevista por el art??culo 776 del C??digo de  Procedimientos Civiles. ";    
       $str=iconv('UTF-8', 'windows-1252',$cadena);
	   $pdf->MultiCell(164,4,$str,0,'J');    
	}
	//////////////////////////////////////////////// FIN susesion a bienes...

    $pdf->Ln(2);	
    $cadena="e) Que es el leg??timo propietario del veh??culo materia de este contrato y que previamente a la celebraci??n del mismo, inform?? al comprador de todas y cada una de las condiciones generales del veh??culo, para que en su caso sea revisado por este ??ltimo. As?? como la informaci??n relativa al costo total del veh??culo, el costo del financiamiento, costo de apertura de cr??dito e investigaci??n y garant??a que debe otorgar.";
	$str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');


    //*********************//
    // Si es persona Moral //
   //*********************//

    if (trim($row_emp["persona"])=="Moral"){
        $epmor="__________";
        if (strlen(trim($row_emp["escritura_publica_moral"]))>=1)    
            $epmor=trim($row_emp["escritura_publica_moral"]);

        $fepmor="___________________";
        if (strlen(trim($row_emp["fecha_escritura_moral"]))>=1)    
            $fepmor=trim($row_emp["fecha_escritura_moral"]);

        $nnmor="___________________";
        if (strlen(trim($row_emp["nombre_notario_moral"]))>=1)    
            $nnmor=trim($row_emp["nombre_notario_moral"]);

        $numor="___________________";
        if (strlen(trim($row_emp["no_notario_moral"]))>=1)    
            $numor=trim($row_emp["no_notario_moral"]);

        $cinmor="___________________";
        if (strlen(trim($row_emp["ciudad_notario_moral"]))>=1)    
            $cinmor=trim($row_emp["ciudad_notario_moral"]);

        $nrpmor="___________________";
        if (strlen(trim($row_emp["no_registro_pub_moral"]))>=1)    
            $nrpmor=trim($row_emp["no_registro_pub_moral"]);

        $frmor="___________________";
        if (strlen(trim($row_emp["fecha_registro_pub_moral"]))>=1)    
            $frmor=trim($row_emp["fecha_registro_pub_moral"]);

        $pdf->Ln(2);	
        $cadena="f) Que es una sociedad legalmente constituida, tal como consta en la escritura p??blica No. ".$epmor." de fecha ".$fepmor." pasada ante la fe del Lic. ".$nnmor." Notario Publico ".$numor." inscrita en el Registro P??blico de la Propiedad y de Comercio de ".$cinmor." bajo el No. ".$nrpmor." de fecha ".$frmor.".";
	    $str=iconv('UTF-8', 'windows-1252',$cadena);
	    $pdf->MultiCell(164,4,$str,0,'J');

    }

	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(10);
	$str=iconv('UTF-8', 'windows-1252',"II.- DECLARA EL COMPRADOR:");
	$pdf->Cell(58,3,$str,0,0,'FJ');	
	
	$pdf->Ln(6);

    $tmovil="____________";
    if (strlen(trim($row_contra["tel_cliente_movil"]))>=1)    
        $tmovil=trim($row_contra["tel_cliente_movil"]);

    $thogar="____________";
    if (strlen(trim($row_contra["tel_cliente"]))>=1)    
        $thogar=trim($row_contra["tel_cliente"]);

    $ttrabajo="____________";
    if (strlen(trim($row_contra["tel_cliente_trabajo"]))>=1)    
        $ttrabajo=trim($row_contra["tel_cliente_trabajo"]);

    $emailc="____________";
    if (strlen(trim($row_contra["email_cliente"]))>=1)    
        $emailc=trim($row_contra["email_cliente"]);

    $cadena="a) Llamarse como ha quedado expresado, tener su domicilio en ".trim($row_contra["domicilio_cliente"].trim($row_contra["ciudad_cliente"]).",".trim($row_contra["estado_cliente"]).", con registro federal de contribuyentes ".trim($row_contra["rfc_cliente"])." y tener como n??meros telef??nicos los siguientes: M??vil ".$tmovil.", Domicilio ".$thogar.", Trabajo ".$ttrabajo.", Correo electr??nico ".$emailc.", asi como tener la capacidad legal y jur??dica para obligarse en los t??rminos del presente contrato. Asi mismo, manifiesta que dichos datos los aporta para que se practiquen en ellos cualquier tipo de notificaci??n.");
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $cadena="b) Que ha tenido y tiene a la vista el veh??culo materia de la compra venta el cual ha revisado f??sica y mec??nicamente, as?? como haber revisado toda la documentaci??n inherente a este, que ampara su propiedad a su entera y absoluta satisfacci??n.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(2);
    $cadena="c) Que es su deseo comprar el veh??culo descrito en la cl??usula segunda del presente contrato, en las condiciones de uso y estado en que se encuentra, y que lo conoce perfectamente por haber hecho una revisi??n f??sica y mec??nica del mismo en los t??rminos expuestos en la cl??usula mencionada.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $cadena="d) Estar de acuerdo en el importe por la compra venta del veh??culo usado descrito en la cl??usula segunda del presente contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->SetLeftMargin(20);
	$pdf->Ln(15);
	$str=iconv('UTF-8', 'windows-1252',"III.- DECLARAN EL VENDEDOR Y EL COMPRADOR:");
	$pdf->Cell(95,3,$str,0,0,'FJ');	

    $pdf->Ln(6);
    $cadena="a) Que la fecha de entrega del veh??culo citado en la cl??usula segunda, ser?? en la fecha de firma del presente contrato y una vez que el COMPRADOR haya pagado al VENDEDOR el enganche para el veh??culo en cuesti??n se fije en el presente contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(4);
    $cadena="En atenci??n a lo anterior, las partes comparecientes convienen en celebrar el presente contrato de acuerdo a las siguientes:";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

		
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',15);
	//$pdf->Cell(0,3,"CLAUSULAS",0,0,'C');	
	$pdf->MultiCell(164,4,"CLAUSULAS",0,'C');	
	$pdf->SetLeftMargin(20);
	$pdf->SetFont('Arial','',11);

    $pdf->Ln(8);
    $cadena="PRIMERA.- Las partes contratantes, expresan su conformidad con todas y cada una de las declaraciones mencionadas y las reproducen como si a la letra se insertasen, adem??s acuerdan las partes que el presente contrato es de compra venta a plazos y con reserva de dominio.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
	$cadena="SEGUNDA.- Objeto. El COMPRADOR adquiere del VENDEDOR, el veh??culo usado que cuenta con las siguientes caracter??sticas:";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->SetLeftMargin(24);
	$pdf->Ln(6);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(25,3,"MODELO ",0,0);$pdf->Cell(55,3,$row_autos_d["ano"],0,0);$pdf->Cell(25,3,"MARCA",0,0);$pdf->Cell(55,3,$row_autos_d["marca"]);
	
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
	$pdf->Cell(25,3,"TIPO ",0,0);$pdf->Cell(55,3,$i,0,0);$pdf->Cell(25,3,"SUB MARCA",0,0);$pdf->Cell(55,3,$row_autos_d["modelo"]);
	//$pdf->Cell(0,3,$row_autos_d["marca"]." ".$row_autos_d["modelo"]." ".$row_autos_d["ano"].", el cual tiene motor de ".$row_autos_d["motor"]." cilindros y odometro con ".$row_autos_d["km"]." millas.",0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ODOMETRO ",0,0);$pdf->Cell(55,3,number_format($row_autos_d["km"]),0,0);$pdf->Cell(25,3,"COLOR",0,0);$pdf->Cell(55,3,$row_autos_d["color"]);
	//$pdf->Cell(0,3,$row_autos_d["especificaciones"],0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"CILINDROS ",0,0);$pdf->Cell(55,3,$row_autos_d["motor"],0,0);$pdf->Cell(25,3,"SERIE",0,0);$pdf->Cell(55,3,$row_autos_d["serie"]);
	//$pdf->Cell(0,3,"No. serie: ".trim($row_autos_d["serie"]).", No. pedimento: ".trim($row_autos_d["pedimento"]).", Aduana: ".trim($row_autos_d["aduana"]),0,0,P);
	$pdf->Ln(4);
	$pdf->Cell(25,3,"ADUANA ",0,0);$pdf->Cell(55,3,$row_autos_d["aduana"],0,0);$pdf->Cell(25,3,"PEDIMENTO",0,0);$pdf->Cell(55,3,$row_autos_d["pedimento"]);
    
    $pdf->Ln(4);
    $pdf->Cell(25,3,"CONSTANCIA REPUVE ",0,0);$pdf->Cell(55,3,$row_autos_d["repuve"]);
	
	$pdf->SetFont('Arial','',11);
	$pdf->Ln(6);
	$pdf->Cell(0,3,"El cual cuenta con el siguiente inventario: ",0,0,'P');
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
	$pdf->SetFont('Arial','',11);

    $cadena="Las condiciones generales en que se encuentra el veh??culo usado material de esta compra venta son las siguientes:";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

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
	

	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(20);
	$pdf->Ln(10);
    
    $i="";
	//echo "Moneda: ".$row_contra["moneda"]."<BR>";
	switch ($row_contra["moneda"]) {
    case "Dolar":
        $i="USD";
        $i2="USD";    
        break;
    case "Peso":
        $i="M.N.";
        $i2="PESOS M.N.";    
        break;
	}
    
    $num= $row_contra["ctotal"];
    $letras = NumeroALetras::convertir($num,$i2,'Centavos');

    $cadena="TERCERA.- Precio. Pactan las partes qye el precio o monto total de la presente operaci??n de compra venta, ser?? por la cantidad de "."$".number_format($row_contra["ctotal"],2)." ".$i." (".$letras." ), cantidad que incluye los siguientes conceptos:";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	
    $str=iconv('UTF-8', 'windows-1252',"PRECIO DE LA UNIDAD ");
    $pdf->Cell(75,3,$str,0,0);
    $pdf->Cell(26,3,"$".number_format($row_contra["cprecio"],2)." ".$i,0,0,"R");	
    
    $pdf->Ln(4);
    $str=iconv('UTF-8', 'windows-1252',"ENGANCHE A LA FIRMA DEL CONTRATO ");
    $pdf->Cell(75,3,$str,0,0);
    $pdf->Cell(26,3,"("."$".number_format($row_contra["cenganche"],2).") ".$i,0,0,"R");	
	
    $pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"UNIDAD USADA A CUENTA ");
    $pdf->Cell(75,3,$str,0,0);
	$v=$row_contra["cacuenta"];if (is_int((int) $v)) {$v=$v.".00";}
	$pdf->Cell(26,3,"("."$".number_format($row_contra["cacuenta"],2).") ".$i,0,0,"R");	

	$pdf->Ln(4);
    $str=iconv('UTF-8', 'windows-1252',"SALDO INICIAL");
    $pdf->Cell(75,3,$str,0,0);
	$pdf->Cell(26,3,"$".number_format($row_contra["saldo_inicial"],2)." ".$i,0,0,"R");
	
    $pdf->Ln(6);
	$str=iconv('UTF-8', 'windows-1252',"INTERESES ");
	$pdf->Cell(75,3,$str,0,0);
	$pdf->Cell(26,3,"$".number_format($row_contra["cinteres"],2)." ".$i,0,0,"R");
	
    $pdf->Ln(4);
	$str=iconv('UTF-8', 'windows-1252',"IVA ");
	$pdf->Cell(75,3,$str,0,0);
	$pdf->Cell(26,3,"$".number_format($row_contra["civa"],2)." ".$i,0,0,"R");	

	$pdf->Ln(6);	
	$str=iconv('UTF-8', 'windows-1252',"SALDO ");
	$pdf->Cell(75,3,$str,0,0);
	$str=iconv('UTF-8', 'windows-1252',"$".number_format($row_contra["ctotal"],2)." ".$i);
	$pdf->Cell(26,3,$str,0,0,"R");


	$pdf->Ln(6);
	$cadena="Conceptos que quedan incluidos y detallados de manera especifica en la caratula del contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');
    
    $pdf->Ln(2);
	$cadena="Para lo cual, en el presente apartado las partes acuerdan que las comisiones que han quedado establecidas se calcularan de la manera siguiente:";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $num= $row_contra["ctotal"];
    $letras = NumeroALetras::convertir($num,$i2,'Centavos');
    $cadena="Precio de la unidad que es el que corresponde al precio de valuaci??n efectuado "."$".number_format($row_contra["ctotal"],2)." ".$i." (".$letras." ).";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $num= $row_contra["cinvest"];
    $letras = NumeroALetras::convertir($num,$i2,'Centavos');
	$cadena="a) Comisi??n por Gastos de Investigaci??n crediticia que se fija por la cantidad de $".number_format($row_contra["cinvest"],2)." ".$i." (".$letras." ). Mismo que ser?? pagado de forma ??nica a la firma del presente contrato, independientemente del enganche pactado por ambas partes.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $num= $row_contra["ctramite"];
    $letras = NumeroALetras::convertir($num,$i2,'Centavos');
	$cadena="b) Comisi??n por Gastos de tr??mites correspondientes a los efectuados por el o la VENDEDOR(A) para iniciar el expediente del COMPRADOR(A) y cualquier otro necesario para la integraci??n del mismo y el tiempo hombre que se toma para dicha actividad. Mismo que ser?? pagado de forma ??nica a la firma del presente contrato por la cantidad de $".number_format($row_contra["ctramite"],2)." ".$i." (".$letras." ), independientemente del enganche pactado.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $cadena="c) Comisi??n por apertura u otorgamiento de cr??dito correspondiente al ".number_format($row_contra["capertura"],2)."% del valor de la operaci??n crediticia a efecto de gestionar el cr??dito con la empresa o entidad comercial que aporte el cr??dito. Mismo que ser?? pagado de forma ??nica a la firma del presente contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $cadena="d) Comisi??n por gasto de investigaci??n en bur?? de cr??dito, que resulte del proceso de investigaci??n para el otorgamiento del cr??dito, mismo que ser?? pagado de forma ??nica a la firma del presente contrato por la cantidad de $".number_format($row_contra["cburo"],2)." ".$i." (".$letras." ), independientemente del enganche pactado. El monto de la comisi??n ser?? de acuerdo al n??mero de COMPRADORES Y/O AVALES. Cabe se??alar que el monto y n??mero de comisiones pactadas por ambas partes, no podr??n ser incrementados ni modificados, debiendo sujetarse ambas partes a lo pactado en el presente contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $cadena="e) IVA, que es el Impuesto al Valor Agregado que deber?? de pagar el COMPRADOR al VENDEDOR y que desde luego este repercutir?? fiscalmente, en sus enteros a la autoridad correspondiente. Pago que se generar?? de forma mensual por ser el presente contrato a plazos.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(2);
    $cadena="Para los efectos del presente contrato, los intereses ordinarios y moratorios que el COMPRADOR se fijara de acuerdo a lo siguiente:";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');    

	$pdf->Ln(2);
    $cadena="Intereses ordinarios a raz??n del ".number_format($row_contra["interes"],2)."% anual por todo el tiempo que dure el saldo insoluto, la vigencia del presente contrato o hasta que sea liquidado en su totalidad el monto o precio total pactado entre las partes para la presente operaci??n de compra venta y que corresponde a una tasa anual FIJA, misma que fue pactada de com??n acuerdo entre las partes a la firma del presente contrato. Y su pago se calcular?? multiplicando el monto del saldo insoluto del financiamiento, por el resultado de dividir la tasa anual (".number_format($row_contra["cinteres"],2)."%) entre 360 d??as de lo que se obtiene el inter??s diario, el que deber?? multiplicarse por el n??mero de d??as efectivamente transcurridos y de tal forma se obtiene el inter??s real a pagar en el periodo que se aplique.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');    

	$pdf->Ln(2);
    $cadena="Inter??s moratorio consiste en dividir el inter??s correspondiente al ".number_format($row_contra["interes"],2)."% anual entre 360 d??as, el resultado se multiplica por el saldo insoluto que exista al momento de incurrirse en mora, as?? mismo, este resultado por los d??as efectivamente transcurridos, en la inteligencia de que cada mensualidad no pagada devengar?? intereses moratorios hasta su pago total, debiendo de ser pagados preferentemente los intereses y el remanente del pago se aplicar?? al pago del principal.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');    

	$pdf->Ln(2);
    $cadena="El inter??s moratorio se generar?? por el retraso en el cumplimiento o pago de las mensualidades pactadas entre las partes a raz??n del porcentaje fijado con anterioridad, por todo el tiempo que dure el incumplimiento de los pagos, porcentaje fijado sobre saldos insolutos, y hasta que los mismos sean pagados. Cualquier cantidad que se pague al VENDEDOR por cualquier medio se entender?? pagada de forma expresa y directa a los intereses moratorios devengados y dejados de pagar, y el remanente si lo hubiere se destinar?? al inter??s ordinario en segundo lugar y posteriormente al saldo insoluto correspondiente m??s antiguo de la deuda.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');    

	$pdf->Ln(2);
    $cadena="El Costo Anual Total (CAT): Es el porcentaje anualizado que incluye los intereses y dem??s accesorios del financiamiento y el Impuesto al Valor Agregado, que se calcula para fines informativos y de comparaci??n, como se indica en la caratula del contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');    

	$pdf->Ln(4);
	$num= $row_contra["cenganche"]+$row_contra["cacuenta"];
    $letras = NumeroALetras::convertir($num,$i2,'Centavos');
    $cadena="CUARTA.- Anticipo y/o enganche. Ambas partes manifiestan, que el VENDEDOR recibe del COMPRADOR la cantidad de $".number_format($num,2)." ".$i." (".$letras." ), por concepto de anticipo y/o enganche a la firma del presente contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(4);
	$num= $row_contra["cenganche"]+$row_contra["cacuenta"];
    $letras = NumeroALetras::convertir($num,$i2,'Centavos');
    
    $num2= $row_contra["ctotal"];
    $letras2 = NumeroALetras::convertir($num2,$i2,'Centavos');

    $num3= $row_contra["cenganche"]+$row_contra["cacuenta"]+$row_contra["ctotal"];
    $letras3 = NumeroALetras::convertir($num3,$i2,'Centavos');

    $rec=nombre_fecha($row_contra["primerpago"]);
    $nf=suma_meses($row_contra["primerpago"],$row_contra["no_pagos"]-1);

    $rec2=nombre_fecha($nf);

    $cadena="QUINTA.- Financiamiento. Habiendo liquidado el COMPRADOR, la cantidad de  $".number_format($num,2)." ".$i." (".$letras." ), en los terminos precisados en la cl??usula que antecede, el VENDEDOR financia a petici??n expresa del COMPRADOR la cantidad de $".number_format($num2,2)." ".$i." (".$letras2." ), por lo cual, el monto total que el COMPRADOR deber?? de pagar al VENDEDOR ser?? de $".number_format($num3,2)." ".$i." (".$letras3." ), con un inter??s ordinario mensual del ".number_format($row_contra["interes"],2)."%, con base en un calendario de pagos en el cual se expresar?? el importe que ser?? pagadero en un t??rmino de ".$row_contra["no_pagos"]." amortizaciones mensuales (".$row_contra["no_pagos"]." meses) siendo pagadera la primera de ellas el dia ".$rec." y as?? sucesivamente hasta el dia ".$rec2.". De conformidad al calendario que se anexa el presente contrato como ap??ndice uno de este acuerdo y el cual sera parte integrante e indivisible y que se tiene aqui por reproducido en obvio de repeticiones innecesarias mismo que deber?? de estar firmado por ambas partes al margen del mismo.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(2);
	$cadena="Al efecto, el COMPRADOR podr?? asistir los dias de Lunes a S??bado de 9:00 A.M. a 7:00 P.M. a la empresa, negocio o sucursal ubicado en ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", donde consultar?? su estado de cuenta, en el que apreciar?? todos y cada uno de sus pagos o amortizaciones, as?? como, el saldo insoluto a vencerse, o vencido, el tiempo que falte para cubrir el adeudo, pago se intereses ordinarios o moratorios, IVA y cualquier otra informaci??n del cr??dito que contrajo, estado de cuenta que ser?? emitido de forma gratuita por el VENDEDOR y una vez que se le entregue el mismo, el COMPRADOR tendr?? 15 d??as para efectuar objeciones o aclaraciones al mismo, las que deber?? efectuar por escrito y de manera personal en las oficinas del VENDEDOR, teniendo la obligaci??n el VENDEDOR la de responder a dichas objeciones en un plazo m??ximo de 15 d??as, de manera verbal o por escrito y en el domicilio del COMPRADOR o a trav??s de los medios electr??nicos correspondientes (VER ANEXO B).";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(2);
	$cadena="As?? mismo, para cualquier aclaraci??n, duda, reclamaci??n, queja, sugerencia o servicios de orientaci??n que se proporcionan de manera gratuita, el VENDEDOR pone a su disposici??n el (los) tel??fono(s) ".$row_emp["tel_empresa"].", la direcci??n de su correo electr??nico ".$row_emp["email_empresa"]." o su domicilio ubicado en ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"])." a donde podr?? acudir de Lunes a S??bado de 9:00 A.M. a 7:00 P.M.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(4);
	$cadena="SEXTA.- Garant??a. Las partes convienen que el COMPRADOR, a efecto de garantizar el pago del financiamiento establecido en la clausula que antecede, suscribe en favor del VENDEDOR, ".$row_contra["no_pagos"]." pagar??s por la cantidad que se especifica en el calendario de pagos (VER ANEXO A).";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(2);
	$cadena="Los titulos de cr??dito antes precisados ser??n cubiertos en su totalidad juntamente con sus intereses, en el domicilio del VENDEDOR se??alado en la declaraci??n I, inciso d) del presente contrato y contra entrega del (los) pagar??(s) que corresponda(n) al(los) pago(s) efectuado(s) por el COMPRADOR.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="SEPTIMA.- Reserva de dominio. Para los efectos previstos por el art??culo 2312 del C??digo Civil para el Distrito Federal, las partes acuerdan que el veh??culo materia de este contrato, es vendido a el COMPRADOR con reserva de dominio, raz??n por la cual el VENDEDOR se reserva a su favor la propiedad del veh??culo citado, hasta que su precio, as?? como todas las anexidades legales y pactadas en este contrato hayan sido pagadas integramente por el COMPRADOR , raz??n por la cual el VENDEDOR retiene en su poder la factura original del veh??culo materia de este contrato, as?? como los comprobantes y dem??s documentos relativos al veh??culo meteria de este contrato, mismos que entregera el COMPRADOR al momento que ??ste haya finiquitado el importe total de las obligaciones que por este contrato ha contraido.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$num= $row_contra["cenganche"]+$row_contra["cacuenta"];
    $letras = NumeroALetras::convertir($num,$i2,'Centavos');
	$cadena="OCTAVA.- Entrega. El VENDEDOR har?? entrega al COMPRADOR del veh??culo adquirido y descrito en la cl??usula segunda del presente contrato, una vez que ??ste haya realizado el pago del anticipo y/o enganche por la cantidad de $".number_format($num,2)." ".$i." (".$letras." ), quien lo recibe a su m??s entera conformidad y en las condiciones de uso en que se encuentra el mismo.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(2);
	$dia=substr($row_contra["fecha_entrega"],0,2);
	$mes=substr($row_contra["fecha_entrega"],3,2);
	$ano=substr($row_contra["fecha_entrega"],6,4);
	$fecha_entrega=$dia."-".$mes."-".$ano;
	$fe="";
	$fe=nombre_fecha($fecha_entrega);
	if (intval($dia)==0 || intval($mes)==0 || intval($ano)==0) {$fe="";} 
	$cadena="La entrega se realiza en el domicilio del VENDEDOR el d??a ".$fe." en horas h??biles.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="NOVENA.- Documentaci??n. Las partes convienen que el VENDEDOR har?? entrega a el COMPRADOR, la documentaci??n que ampara la propiedad del veh??culo descrito en la cl??usula que antecede, en copia simple, una vez que ??ste haya recibiso el veh??culo y efectuado el pago del anticipo y/o enganche; as?? mismo, manifiesta BAJO PROTESTA DE DECIR VERDAD, que ha cotejado las copias simples entregadas con sus originales, cercior??ndose que la misma se encuentra en regla, manifestando el COMPRADOR su m??s entera conformidad, de que la documentaci??n original se quede en poder del VENDEDOR, hasta en tanto no sea liquidado totalmente el precio pactado. Dicha documentaci??n la constituye: ";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$pdf->SetLeftMargin(24);
	$str=iconv('UTF-8', 'windows-1252',"Factura Numero: ".$row_autos_d["factura"]);
		$pdf->Cell(75,3,$str,0,0);
	$str=iconv('UTF-8', 'windows-1252',"Expedida por: ".$row_autos_d["expedida"]);
		$pdf->Cell(65,3,$str,0,0);
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Pago de tenencia Vehicular por los a??os: ".$row_autos_d["tenencia"]);
		$pdf->Cell(145,3,$str,0,0);
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Tarjeta de circulaci??n n??mero: ".$row_autos_d["tcirculacion"]);
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Comprobante de verificaci??n veh??cular: ".$row_autos_d["verificacion"]);
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Engomados: ".$row_autos_d["engomados"]);
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"P??liza de seguro: ".$row_autos_d["poliza_seg"]);
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Pago de multas: ".$row_autos_d["pago_multas"]);
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Pago recargos: ".$row_autos_d["pago_recargos"]);
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Manual de usuario: ".$row_autos_d["manual_usuario"]);
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Otros documentos: ".$row_autos_d["otros_docs"]);
		$pdf->Cell(85,3,$str,0,0);	
	
	$pdf->Ln(8);
	$cadena="D??CIMA.- Forma de pago. Como qued?? expresado en la cl??usula quinta, las partes convienen que el costo total del veh??culo usado objeto del presente contrato, ser?? liquidado por el COMPRADOR mediante ".$row_contra["no_pagos"]." amortizaciones mensuales por la cantidad que se especifica en el calendario de pagos (VER ANEXO A), pagos que se obliga a realizar los dias ".$row_contra["dia_pagos"]." de cada mes, mediante dep??sito bancario ante la instituci??n y/o en el domicilio del VENDEDOR, ubicado en ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", C.P. ".trim($row_emp["cp_empresa"]).".";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="D??CIMA PRIMERA.- Vencimiento anticipado. El VENDEDOR podr?? dar por vencido anticipadamente el plazo de pleno derecho y sin necesidad de declaraci??n judicial, si el COMPRADOR faltare al cumplimiento de las obligaciones contra??das en este contrato, y los pagos parciales realizados se aplicar??n a intereses estipulados y da??os y perjuicios ocasionados por el incumplimiento.\n\nTambi??n as??, ambas partes manifiestan, que a falta de pago de cualquiera de los pagares, se podr?? dar por vencido anticipadamente el saldo pendiente y exigir su importe junto con los accesorios correspondientes.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="D??CIMA SEGUNDA.- Intereses. Las partes convienen que para el caso de que el COMPRADOR deje de cubrir cualquiera de los pagos en la forma y t??rminos convenidos, como se especifica en la cl??usula quinta.\n\nLas partes convienen que para el caso de que el COMPRADOR realice los pagos a que se ha obligado en el presente contrato en forma extempor??nea, dicho pago se aplicar?? primeramente a los intereses causados por la mora y el remanente se aplicar?? a capital.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	


	$pdf->Ln(4);
	$cadena="D??CIMA TERCERA.- Pagos anticipados. El COMPRADOR podr?? en cualquier momento liquidar anticipadamente el saldo del precio de la compra venta, siempre que se encuentre al corriente en sus pagos y dichos pagos ser??n aplicados al saldo insoluto del principal o a los pagos inmediatos siguientes seg??n corresponda, sin penalizaci??n alguna.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="D??CIMA CUARTA.- Garant??a del veh??culo. Ambas partes manifiestan y est??n de acuerdo que por tratarse de una unidad usada, la que adquiere el COMPRADOR ??ste la acepta y la recibe en el estado de uso y mec??nico en que se encuentra, el cual le ha sido facilitado para su revisi??n general, por cuyo motivo el veh??culo usado se vende: ";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	


	$marca_garantia="(   )  ";
	$marca_sin_garantia="( X )  ";
	if ($row_contra["garantia"]==1) {
		$marca_garantia="( X )  ";
		$marca_sin_garantia="(   )  ";
	}

	$pdf->Ln(4);
	$cadena=$marca_sin_garantia."Sin garant??a. en este caso, el VENDEDOR no est?? obligado a realizar ning??n tipo de reparaci??n, por lo que el COMPRADOR asumir?? los costos por reparaciones, suministro de refacciones, mano de obra calificada, entre otros.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena=$marca_garantia."Con garant??a por un plazo de 60 d??as, (Art. 77 de la Ley Federal de Protecci??n al COnsumidor, la garant??a no podr?? ser inferior a 60 d??as naturales) contados a partir de la entrega del veh??culo usado, excluy??ndose la correspondiente a partes el??ctricas y deber?? hacerse valida en el domicilio , tel??fonos y horarios de atenci??n se??alados en el presente contrato, siempre y cuando no se haya efectuado una reparaci??n por un tercero. Asimismo, el VENDEDOR ser?? el responsable por las descomposturas, da??os o p??rdidas parciales o totales imputables a ??l, mientras el veh??culo se encuentre bajo su responsabilidad para llevar a cabo el cumplimiento de la garant??a.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="D??CIMA QUINTA.- Para efectos de seguimiento de solicitudes, aclaraciones, inconformidades y quejas relacionados con la operaci??n o servicio contratado, le ser??n atendidas de forma inmediata y podr?? hacerlo por los siguientes medios: de manera escrita, entreg??ndola en la direcci??n: ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", C.P. ".trim($row_emp["cp_empresa"]).", por medio de s?? mismo, se le dar?? respuesta en ______ dias habiles, en quejas, comentarios o sugerencias, podr?? hacerlo en la direcci??n y tel??fonos de la empresa, negocio o sucursal, que se encuentra ubicado en: ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", C.P. ".trim($row_emp["cp_empresa"]).", Tel??fono(s) ".trim($row_emp["tel_empresa"]).".";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="D??CIMA SEXTA. Domicilio. Las partes se obligan a informar a su contraparte, durante la vigencia del contrato el cambio de domicilio que llegare a tener, en un plazo m??ximo de 5 (cinco) d??as posteriores a la verificaci??n del mismo.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="D??CIMA S??PTIMA. Rescisi??n. Las partes podr??n rescindir el presente contrato cuando:

Por causas imputables al COMPRADOR.

		a). Cuando el veh??culo objeto de la compra venta sufra destrucci??n total o da??os que afectan su naturaleza o este sea materia de embargo, secuestro judicial u otro acontecimiento semejante a los citados en esta cl??usula de lo que sea responsable el COMPRADOR.\n
		b). Por cesi??n o traspaso de derechos o arrendamiento del veh??culo y de cualquiera de los derechos que adquiere el COMPRADOR y sin que medie consentimiento otorgado por escrito del VENDEDOR.\n
		c). Por falta de pago, a la fecha de vencimiento de dos o m??s amortizaciones pactadas, con excepci??n de cuando el COMPRADOR haya cubierto m??s de la tercera parte del precio estipulado, en cuyo caso podr?? optar por el pago del adeudo vencido, en t??rminos de lo previsto por el art??culo 71 de la Ley Federal de Protecci??n al Consumidor.\n
		d). Por haber cambiado su domicilio sin dar aviso al VENDEDOR.
	
Por causas imputables al VENDEDOR.
	
		a). Por imcumpliento del VENDEDOR a cualesquiera de las obligaciones estipulados en el presente contrato.\n
		b). Si el veh??culo presentare vicios ocultos que no hayan sido informados al COMPRADOR y expresamente aceptados por el mismo, a trav??s del presente contrato.\n
		c). Si el veh??culo le fuera entregado al COMPRADOR en condiciones con caracter??sticas distintas a las se??aladas en la cl??usula SEGUNDA del presente contrato.

Si se rescinde el presente contrato, el VENDEDOR y el COMPRADOR deben restituirse mutuamente las prestaciones que se hubieren hecho, el VENDEDOR que hubiera entregado el veh??culo, tendr?? derecho a exigir por su uso, el pago de un alquiler o renta y, en su caso, una compensaci??n por el dem??rito que haya sufrido, situaciones que deber??n establecer las partes de com??n acuerdo.

El COMPRADOR que haya pagado parte del precio tiene derecho a recibir los intereses computados conforme a la tasa que, en su caso, se haya aplicado a su pago.

Cuando el COMPRADOR haya pagado m??s de la tercera parte del precio o del n??mero total de los pagos convenidos y el VENDEDOR exija la rescisi??n o cumplimiento del contrato por mora, el COMPRADOR tendr?? derecho a optar por la rescisi??n en t??rminos de lo establecido en el p??rrafo anterior o por el pago del adeudo vencido m??s las prestaciones que legalmente procedan. Los pagos que realice el COMPRADOR, a??n en forma extempor??nea y que sean aceptados por el VENDEDOR, liberan a aqu??l de las obligaciones inherentes a dichos pagos.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="D??CIMA OCTAVA. Obligaciones del VENDEDOR. El VENDEDOR se hace responsable de cualquier situaci??n legal que anteceda a la fecha de entrega del veh??culo, sin ninguna responsabilidad para el COMPRADOR.

Asimismo, el VENDEDOR libera al COMPRADOR de cualquier responsabilidad que hubiere surgido o pudiese surgir con relaci??n al origen, propiedad, posesi??n o cualquier otro derecho inherente al veh??culo o partes o componentes del mismo, hasta antes de ser entregado el veh??culo al COMPRADOR oblig??ndose asimismo a responder por el saneamiento para el caso de evicci??n.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="D??CIMA NOVENA. Pena convencional. Las partes convienen que por el incumplimiento de cualquiera de las obligaciones contenidas en el presente contrato, se aplicar?? al responsable una pena convencional, equivalente al 15%, del precio de la operaci??n materia del presente contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="VIG??SIMA. Deudor solidario y aval. Para garantizar y asegurar el cumplimiento de todas y cada una de las obligaciones por el COMPRADOR en el presente contrato, el (la) se??or (a) ".trim($row_ava2["nombre_aval"]).", con domicilioo en ".trim($row_ava["domicilio_aval"]).",  C.P. ".trim($row_ava["cp_aval"])." de la ciudad de ".trim($row_ava["ciudad_aval"]).", se constituye en deudor solidario y aval del COMPRADOR y se obliga con ??ste al cumplimiento de todas las obligaciones y acepta expresamente que su responsabilidad no terminar?? hasta que termine por cualquier causa el presente contrato. Como consecuencia de la obligaci??n que contrae en la presente cl??usula el fiador conviene y se obliga a firmar como aval los pagar??s expedidos por el VENDEDOR.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(5);
	do {
		
		$texto=iconv('UTF-8', 'windows-1252','Fiador: '.$row_ava["nombre_aval"]);
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(5);
		$texto=iconv('UTF-8', 'windows-1252','Nacionalidad: '.$row_ava["nacionalidad"]);
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(5);
		$texto=iconv('UTF-8', 'windows-1252','Estado Civil: '.$row_ava["edo_civil"]);
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(5);
		$texto=iconv('UTF-8', 'windows-1252','Ocupaci??n: '.$row_ava["ocupacion"]);
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(5);
		$texto=iconv('UTF-8', 'windows-1252','Domicilio: '.trim($row_ava["domicilio_aval"]).", ".trim($row_ava["ciudad_aval"]));
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(10);
	 } while ($row_ava = mysqli_fetch_assoc($ava));

	$pdf->Ln(4);
	$cadena="VIG??SIMA PRIMERA. Competencia. Para la interpretaci??n y cumplimiento del presente contrato de compra venta, en la v??a administrativa, ser?? competente la Procuradur??a Federal del Consumidor, sin perjuicio de lo anterior, las partes se someten a la jurisdicci??n de los tribunales competentes de la ciudad de Tijuana, renunciando expresamente a cualquier otra jurisdicci??n que pudiera corresponderles, por raz??n de sus domicilios presentes o futuros o por cualquier otra raz??n.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="Leido que fue el presente contrato y saber los alcances jur??dicos que del mismo se derivan, por haberlo leido de manera bastante y suficiente el COMPRADOR, y asimismo le fue explicado en todas y cada una de sus partes, en raz??n de lo cual firman las partes al margen y alcance, siendo las ".date("G")." horas con ".date("i")." minutos en la ciudad de "."Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"])." y quedando en poder de cada una de las partes un tanto del contrato, declaraciones, clausulas y anexos.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		





	$pdf->Ln(20);

	
	$texto=iconv('UTF-8', 'windows-1252',$row_contra["nombre_cliente"]);
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(2);
	$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------------------------------------");
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(3);
	$texto=iconv('UTF-8', 'windows-1252',"Comprador");
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(26);
	
	if (trim($row_emp["representante_empresa"])=="SUCESION A BIENES DE MARIA ANGELICA DIAZ DE LEON FLEURY") {
		$texto=iconv('UTF-8', 'windows-1252',"SR. C??SAR ANTONIO C??ZARES D??AZ DE LE??N, ALBACEA DE ");
		$pdf->Cell(164,4,$texto,0,0,'C');
		$pdf->Ln(4);
	}
	$texto=iconv('UTF-8', 'windows-1252',$row_emp["representante_empresa"]);
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(2);
	$texto=iconv('UTF-8', 'windows-1252',"---------------------------------------------------------------------------------------------");
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(3);
	$texto=iconv('UTF-8', 'windows-1252',"Vendedor");
	$pdf->Cell(164,4,$texto,0,0,'C');
	$pdf->Ln(26);
	
	$contador=1;
	do {
		
		/*if ($contador==2) {
			$pdf->Ln(15);
		}*/
		if ($contador==1) {
		
			$pos1      = strripos($row_ava2["nombre_aval"],"y se dice");
			
			if ($pos1 === false) {
				$texto=iconv('UTF-8', 'windows-1252',$row_ava2["nombre_aval"]);
				$pdf->Cell(70,4,$texto,0,0,'C');
			}
			else {
				$texto=iconv('UTF-8', 'windows-1252',substr($row_ava2["nombre_aval"],0,$pos1));
				$pdf->Cell(70,4,$texto,0,0,'C');
				$pdf->Ln(4);
				$texto=iconv('UTF-8', 'windows-1252',trim(substr($row_ava2["nombre_aval"],$pos1,40)));
				$pdf->Cell(70,4,$texto,0,0,'C');
			}
			
		}
		if ($contador==2) {
			$pos2      = strripos("se dice", $row_ava2["nombre_aval"]);
			
			if ($pos2 === false) {
				$texto=iconv('UTF-8', 'windows-1252',$row_ava2["nombre_aval"]);
				$pdf->Cell(0,4,$texto,0,0,'C');
			}
			else {
				$texto=iconv('UTF-8', 'windows-1252',substr($row_ava2["nombre_aval"],0,$pos1));
				$pdf->Cell(70,4,$texto,0,0,'C');
				$pdf->Ln(4);
				$texto=iconv('UTF-8', 'windows-1252',trim(substr($row_ava2["nombre_aval"],$pos2,40)));
				$pdf->Cell(70,4,$texto,0,0,'C');
			}
		}
		
		$contador=$contador+1;
	 } while ($row_ava2 = mysqli_fetch_assoc($ava2));
	 
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
	$pdf->Ln(26);
	
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

	 $pdf->Ln(20);
	 
	$texto=iconv('UTF-8', 'windows-1252',"CONTRATO REGISTRADO ANTE LA PROCURADURIA FEDERAL DEL CONSUMIDOR BAJO EL NUMERO DE REGISTRO 3257-2017 y EXPEDIENTE PFC.B.E.7/005026-2017 DE FECHA 17-AGOSTO-2017 Y SOLO PODRA SER UTILIZADO POR SOCIOS ACTIVOS DE LA ASOCIACION DE COMERCIANTES EN AUTOMOVILES Y CAMIONES NUEVOS Y USADOS, A. C., QUEDANDO ESTRICTAMENTE PROHIBIDO SU USO POR PARTICULARES O PERSONAS MORALES NO AFILIADAS A LA A. N. C. A. A. C.");
	$pdf->MultiCell(164,4,$texto,0,'J');
	$pdf->Ln(10);
	

	$pdf->Output();

	exit;
?>