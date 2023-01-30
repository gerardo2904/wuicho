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
		$str=iconv("UTF-8", "windows-1252","Contrato de compra venta a plazos con reserva de dominio de vehículo usado, que celebran por una parte la");
	}else{
		$str=iconv("UTF-8", "windows-1252","Contrato de compra venta a plazos con reserva de dominio de vehículo usado, que celebran por una parte el");
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
	$str=iconv("UTF-8", "windows-1252","apoderado y/o Representante Legal de la negociación denominada");
    //$pdf->Cell(163,3,$str,0,0,"FJ");
    $pdf->MultiCell(163,3,$str,0,'C');

	$pdf->SetLeftMargin(20);
	$pdf->Ln(2);
	
	//$str=iconv("UTF-8", "windows-1252","Legal de la negociación denominada ");
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
	$cadena="representada por conducto de su Albacea, el Sr. César Antonio Cázares Díaz de León, ";
    $cadena.="a quien en lo sucesivo se le denominara el vendedor y por la otra parte, el (la) señor(a)";    
        
    //$str=iconv("UTF-8", "windows-1252","representada por conducto de su Albacea, el Sr. César Antonio Cázares Díaz de León,");
		//$pdf->Cell(163,3,$str,0,0,"FJ");		
	
	//$pdf->Ln(4);
	//$str=iconv("UTF-8", "windows-1252","a quien en lo sucesivo se le denominara el vendedor y por otra parte el");
	//	$pdf->Cell(163,3,$str,0,0,"FJ");		
		
	}else{
	    //$str=iconv("UTF-8", "windows-1252","a quien en lo sucesivo se le denominara el vendedor y por otra parte el");
		//$pdf->Cell(163,3,$str,0,0,"FJ");	
        $cadena.="a quien en lo sucesivo se le denominara el vendedor y por la otra parte, el (la) señor(a)";    
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
	$str=iconv('UTF-8', 'windows-1252',"a quien en lo sucesivo, se le denominara el comprador, y el (la) señor(a)");
    $pdf->MultiCell(164,3,$str,0,'C');	

    $pdf->Ln(2);
	$pdf->SetFont('Arial','BIU',11);
	$pdf->SetLeftMargin(20);
	$str=iconv('UTF-8', 'windows-1252',"C. ".trim($row_ava["nombre_aval"]).",");
	$pdf->Cell(163,3,$str,0,0,"C");	

    $pdf->SetLeftMargin(20);
	$pdf->SetFont('Arial','',11);
	$pdf->Ln(5);
	$str=iconv('UTF-8', 'windows-1252',"en su carácter de deudor(a) solidario(a) y aval, para responder a todas las obligaciones contraídas en el presente acto, a quien en lo sucesivo se le denominara el deudor solidario, al tenor de las siguientes declaraciones y clausulas:");
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

    $cadena="a) Ser una persona ".trim($row_emp["persona"]).", cuya actividad preponderante es la compra venta de vehículos usados, que se encuentra debidamente registrada como socio activo en la Asociación Nacional de Comerciantes en Automoviles y Camiones Nuevos y Usados, A. C. (ANCA) con el número de asociado ".$asociado."; información que se puede consultar, asi como obtener servicios de orientación para la venta y/o adquisición de vehículos usados en el teléfono de ANCA: 018002602622; fax 5555352608; correo electrónico contacto@anca.com.mx de manera gratuita.";
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


    $cadena="b) Que esta representada por ".$rep." según testimonio notarial No.".$tnrep." pasado ante la fe del Notario Público No.".$nrep." de ".$crep.", Lic.".$nnrep;
	$str=iconv('UTF-8', 'windows-1252',$cadena);
    $pdf->MultiCell(164,4,$str,0,'J');


	$pdf->Ln(2);

    $cadena="c) Tener su domicilio en ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", con registro federal de contribuyentes ".trim($row_emp["rfc_empresa"]).", con teléfonos  ".trim($row_emp["tel_empresa"])." con horario de atención al público de LUNES A SABADO DE 9:00 A.M. A 7:00 P.M.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');


	$pdf->Ln(2);	
    $cadena="d) Que cuenta con la infraestructura y capacidad necesarias para la comercialización de vehículos usados y cuenta con las licencias, permisos, avisos o autorizaciones necesarias para llevar a cabo su actividad y que el vehículo usado cumple con los lineamientos en materia de control de emisión de contaminantes, protección al medio ambiente, todas las especificaciones legales y comerciales para poder ser comercializado.";
	$str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');



	//////////////////////////////////////////////// SI es susesion a bienes...
	if (trim($row_emp["representante_empresa"])=="SUCESION A BIENES DE MARIA ANGELICA DIAZ DE LEON FLEURY") {
	   $pdf->Ln(2);	
       $cadena="Que cuenta con personalidad jurídica toda vez que le fue designado el carácter de albacea por parte de la Señora María Angélica Díaz de León Fleury, mismo que fue aceptado y protestado en esta misma ciudad , el día 06 de Junio del dos mil cinco , mediante la junta de herederos prevista por el artículo 776 del Código de  Procedimientos Civiles. ";    
       $str=iconv('UTF-8', 'windows-1252',$cadena);
	   $pdf->MultiCell(164,4,$str,0,'J');    
	}
	//////////////////////////////////////////////// FIN susesion a bienes...

    $pdf->Ln(2);	
    $cadena="e) Que es el legítimo propietario del vehículo materia de este contrato y que previamente a la celebración del mismo, informó al comprador de todas y cada una de las condiciones generales del vehículo, para que en su caso sea revisado por este último. Así como la información relativa al costo total del vehículo, el costo del financiamiento, costo de apertura de crédito e investigación y garantía que debe otorgar.";
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
        $cadena="f) Que es una sociedad legalmente constituida, tal como consta en la escritura pública No. ".$epmor." de fecha ".$fepmor." pasada ante la fe del Lic. ".$nnmor." Notario Publico ".$numor." inscrita en el Registro Público de la Propiedad y de Comercio de ".$cinmor." bajo el No. ".$nrpmor." de fecha ".$frmor.".";
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

    $cadena="a) Llamarse como ha quedado expresado, tener su domicilio en ".trim($row_contra["domicilio_cliente"].trim($row_contra["ciudad_cliente"]).",".trim($row_contra["estado_cliente"]).", con registro federal de contribuyentes ".trim($row_contra["rfc_cliente"])." y tener como números telefónicos los siguientes: Móvil ".$tmovil.", Domicilio ".$thogar.", Trabajo ".$ttrabajo.", Correo electrónico ".$emailc.", asi como tener la capacidad legal y jurídica para obligarse en los términos del presente contrato. Asi mismo, manifiesta que dichos datos los aporta para que se practiquen en ellos cualquier tipo de notificación.");
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $cadena="b) Que ha tenido y tiene a la vista el vehículo materia de la compra venta el cual ha revisado física y mecánicamente, así como haber revisado toda la documentación inherente a este, que ampara su propiedad a su entera y absoluta satisfacción.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(2);
    $cadena="c) Que es su deseo comprar el vehículo descrito en la cláusula segunda del presente contrato, en las condiciones de uso y estado en que se encuentra, y que lo conoce perfectamente por haber hecho una revisión física y mecánica del mismo en los términos expuestos en la cláusula mencionada.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $cadena="d) Estar de acuerdo en el importe por la compra venta del vehículo usado descrito en la cláusula segunda del presente contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->SetLeftMargin(20);
	$pdf->Ln(15);
	$str=iconv('UTF-8', 'windows-1252',"III.- DECLARAN EL VENDEDOR Y EL COMPRADOR:");
	$pdf->Cell(95,3,$str,0,0,'FJ');	

    $pdf->Ln(6);
    $cadena="a) Que la fecha de entrega del vehículo citado en la cláusula segunda, será en la fecha de firma del presente contrato y una vez que el COMPRADOR haya pagado al VENDEDOR el enganche para el vehículo en cuestión se fije en el presente contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(4);
    $cadena="En atención a lo anterior, las partes comparecientes convienen en celebrar el presente contrato de acuerdo a las siguientes:";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

		
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',15);
	//$pdf->Cell(0,3,"CLAUSULAS",0,0,'C');	
	$pdf->MultiCell(164,4,"CLAUSULAS",0,'C');	
	$pdf->SetLeftMargin(20);
	$pdf->SetFont('Arial','',11);

    $pdf->Ln(8);
    $cadena="PRIMERA.- Las partes contratantes, expresan su conformidad con todas y cada una de las declaraciones mencionadas y las reproducen como si a la letra se insertasen, además acuerdan las partes que el presente contrato es de compra venta a plazos y con reserva de dominio.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
	$cadena="SEGUNDA.- Objeto. El COMPRADOR adquiere del VENDEDOR, el vehículo usado que cuenta con las siguientes características:";
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

    $cadena="Las condiciones generales en que se encuentra el vehículo usado material de esta compra venta son las siguientes:";
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

    $cadena="TERCERA.- Precio. Pactan las partes qye el precio o monto total de la presente operación de compra venta, será por la cantidad de "."$".number_format($row_contra["ctotal"],2)." ".$i." (".$letras." ), cantidad que incluye los siguientes conceptos:";
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
    $cadena="Precio de la unidad que es el que corresponde al precio de valuación efectuado "."$".number_format($row_contra["ctotal"],2)." ".$i." (".$letras." ).";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $num= $row_contra["cinvest"];
    $letras = NumeroALetras::convertir($num,$i2,'Centavos');
	$cadena="a) Comisión por Gastos de Investigación crediticia que se fija por la cantidad de $".number_format($row_contra["cinvest"],2)." ".$i." (".$letras." ). Mismo que será pagado de forma única a la firma del presente contrato, independientemente del enganche pactado por ambas partes.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $num= $row_contra["ctramite"];
    $letras = NumeroALetras::convertir($num,$i2,'Centavos');
	$cadena="b) Comisión por Gastos de trámites correspondientes a los efectuados por el o la VENDEDOR(A) para iniciar el expediente del COMPRADOR(A) y cualquier otro necesario para la integración del mismo y el tiempo hombre que se toma para dicha actividad. Mismo que será pagado de forma única a la firma del presente contrato por la cantidad de $".number_format($row_contra["ctramite"],2)." ".$i." (".$letras." ), independientemente del enganche pactado.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $cadena="c) Comisión por apertura u otorgamiento de crédito correspondiente al ".number_format($row_contra["capertura"],2)."% del valor de la operación crediticia a efecto de gestionar el crédito con la empresa o entidad comercial que aporte el crédito. Mismo que será pagado de forma única a la firma del presente contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $cadena="d) Comisión por gasto de investigación en buró de crédito, que resulte del proceso de investigación para el otorgamiento del crédito, mismo que será pagado de forma única a la firma del presente contrato por la cantidad de $".number_format($row_contra["cburo"],2)." ".$i." (".$letras." ), independientemente del enganche pactado. El monto de la comisión será de acuerdo al número de COMPRADORES Y/O AVALES. Cabe señalar que el monto y número de comisiones pactadas por ambas partes, no podrán ser incrementados ni modificados, debiendo sujetarse ambas partes a lo pactado en el presente contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

    $pdf->Ln(2);
    $cadena="e) IVA, que es el Impuesto al Valor Agregado que deberá de pagar el COMPRADOR al VENDEDOR y que desde luego este repercutirá fiscalmente, en sus enteros a la autoridad correspondiente. Pago que se generará de forma mensual por ser el presente contrato a plazos.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(2);
    $cadena="Para los efectos del presente contrato, los intereses ordinarios y moratorios que el COMPRADOR se fijara de acuerdo a lo siguiente:";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');    

	$pdf->Ln(2);
    $cadena="Intereses ordinarios a razón del ".number_format($row_contra["interes"],2)."% anual por todo el tiempo que dure el saldo insoluto, la vigencia del presente contrato o hasta que sea liquidado en su totalidad el monto o precio total pactado entre las partes para la presente operación de compra venta y que corresponde a una tasa anual FIJA, misma que fue pactada de común acuerdo entre las partes a la firma del presente contrato. Y su pago se calculará multiplicando el monto del saldo insoluto del financiamiento, por el resultado de dividir la tasa anual (".number_format($row_contra["cinteres"],2)."%) entre 360 días de lo que se obtiene el interés diario, el que deberá multiplicarse por el número de días efectivamente transcurridos y de tal forma se obtiene el interés real a pagar en el periodo que se aplique.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');    

	$pdf->Ln(2);
    $cadena="Interés moratorio consiste en dividir el interés correspondiente al ".number_format($row_contra["interes"],2)."% anual entre 360 días, el resultado se multiplica por el saldo insoluto que exista al momento de incurrirse en mora, así mismo, este resultado por los días efectivamente transcurridos, en la inteligencia de que cada mensualidad no pagada devengará intereses moratorios hasta su pago total, debiendo de ser pagados preferentemente los intereses y el remanente del pago se aplicará al pago del principal.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');    

	$pdf->Ln(2);
    $cadena="El interés moratorio se generará por el retraso en el cumplimiento o pago de las mensualidades pactadas entre las partes a razón del porcentaje fijado con anterioridad, por todo el tiempo que dure el incumplimiento de los pagos, porcentaje fijado sobre saldos insolutos, y hasta que los mismos sean pagados. Cualquier cantidad que se pague al VENDEDOR por cualquier medio se entenderá pagada de forma expresa y directa a los intereses moratorios devengados y dejados de pagar, y el remanente si lo hubiere se destinará al interés ordinario en segundo lugar y posteriormente al saldo insoluto correspondiente más antiguo de la deuda.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');    

	$pdf->Ln(2);
    $cadena="El Costo Anual Total (CAT): Es el porcentaje anualizado que incluye los intereses y demás accesorios del financiamiento y el Impuesto al Valor Agregado, que se calcula para fines informativos y de comparación, como se indica en la caratula del contrato.";
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

    $cadena="QUINTA.- Financiamiento. Habiendo liquidado el COMPRADOR, la cantidad de  $".number_format($num,2)." ".$i." (".$letras." ), en los terminos precisados en la cláusula que antecede, el VENDEDOR financia a petición expresa del COMPRADOR la cantidad de $".number_format($num2,2)." ".$i." (".$letras2." ), por lo cual, el monto total que el COMPRADOR deberá de pagar al VENDEDOR será de $".number_format($num3,2)." ".$i." (".$letras3." ), con un interés ordinario mensual del ".number_format($row_contra["interes"],2)."%, con base en un calendario de pagos en el cual se expresará el importe que será pagadero en un término de ".$row_contra["no_pagos"]." amortizaciones mensuales (".$row_contra["no_pagos"]." meses) siendo pagadera la primera de ellas el dia ".$rec." y así sucesivamente hasta el dia ".$rec2.". De conformidad al calendario que se anexa el presente contrato como apéndice uno de este acuerdo y el cual sera parte integrante e indivisible y que se tiene aqui por reproducido en obvio de repeticiones innecesarias mismo que deberá de estar firmado por ambas partes al margen del mismo.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(2);
	$cadena="Al efecto, el COMPRADOR podrá asistir los dias de Lunes a Sábado de 9:00 A.M. a 7:00 P.M. a la empresa, negocio o sucursal ubicado en ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", donde consultará su estado de cuenta, en el que apreciará todos y cada uno de sus pagos o amortizaciones, así como, el saldo insoluto a vencerse, o vencido, el tiempo que falte para cubrir el adeudo, pago se intereses ordinarios o moratorios, IVA y cualquier otra información del crédito que contrajo, estado de cuenta que será emitido de forma gratuita por el VENDEDOR y una vez que se le entregue el mismo, el COMPRADOR tendrá 15 días para efectuar objeciones o aclaraciones al mismo, las que deberá efectuar por escrito y de manera personal en las oficinas del VENDEDOR, teniendo la obligación el VENDEDOR la de responder a dichas objeciones en un plazo máximo de 15 días, de manera verbal o por escrito y en el domicilio del COMPRADOR o a través de los medios electrónicos correspondientes (VER ANEXO B).";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(2);
	$cadena="Así mismo, para cualquier aclaración, duda, reclamación, queja, sugerencia o servicios de orientación que se proporcionan de manera gratuita, el VENDEDOR pone a su disposición el (los) teléfono(s) ".$row_emp["tel_empresa"].", la dirección de su correo electrónico ".$row_emp["email_empresa"]." o su domicilio ubicado en ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"])." a donde podrá acudir de Lunes a Sábado de 9:00 A.M. a 7:00 P.M.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(4);
	$cadena="SEXTA.- Garantía. Las partes convienen que el COMPRADOR, a efecto de garantizar el pago del financiamiento establecido en la clausula que antecede, suscribe en favor del VENDEDOR, ".$row_contra["no_pagos"]." pagarés por la cantidad que se especifica en el calendario de pagos (VER ANEXO A).";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');

	$pdf->Ln(2);
	$cadena="Los titulos de crédito antes precisados serán cubiertos en su totalidad juntamente con sus intereses, en el domicilio del VENDEDOR señalado en la declaración I, inciso d) del presente contrato y contra entrega del (los) pagaré(s) que corresponda(n) al(los) pago(s) efectuado(s) por el COMPRADOR.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="SEPTIMA.- Reserva de dominio. Para los efectos previstos por el artículo 2312 del Código Civil para el Distrito Federal, las partes acuerdan que el vehículo materia de este contrato, es vendido a el COMPRADOR con reserva de dominio, razón por la cual el VENDEDOR se reserva a su favor la propiedad del vehículo citado, hasta que su precio, así como todas las anexidades legales y pactadas en este contrato hayan sido pagadas integramente por el COMPRADOR , razón por la cual el VENDEDOR retiene en su poder la factura original del vehículo materia de este contrato, así como los comprobantes y demás documentos relativos al vehículo meteria de este contrato, mismos que entregera el COMPRADOR al momento que éste haya finiquitado el importe total de las obligaciones que por este contrato ha contraido.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$num= $row_contra["cenganche"]+$row_contra["cacuenta"];
    $letras = NumeroALetras::convertir($num,$i2,'Centavos');
	$cadena="OCTAVA.- Entrega. El VENDEDOR hará entrega al COMPRADOR del vehículo adquirido y descrito en la cláusula segunda del presente contrato, una vez que éste haya realizado el pago del anticipo y/o enganche por la cantidad de $".number_format($num,2)." ".$i." (".$letras." ), quien lo recibe a su más entera conformidad y en las condiciones de uso en que se encuentra el mismo.";
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
	$cadena="La entrega se realiza en el domicilio del VENDEDOR el día ".$fe." en horas hábiles.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="NOVENA.- Documentación. Las partes convienen que el VENDEDOR hará entrega a el COMPRADOR, la documentación que ampara la propiedad del vehículo descrito en la cláusula que antecede, en copia simple, una vez que éste haya recibiso el vehículo y efectuado el pago del anticipo y/o enganche; así mismo, manifiesta BAJO PROTESTA DE DECIR VERDAD, que ha cotejado las copias simples entregadas con sus originales, cerciorándose que la misma se encuentra en regla, manifestando el COMPRADOR su más entera conformidad, de que la documentación original se quede en poder del VENDEDOR, hasta en tanto no sea liquidado totalmente el precio pactado. Dicha documentación la constituye: ";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$pdf->SetLeftMargin(24);
	$str=iconv('UTF-8', 'windows-1252',"Factura Numero: ".$row_autos_d["factura"]);
		$pdf->Cell(75,3,$str,0,0);
	$str=iconv('UTF-8', 'windows-1252',"Expedida por: ".$row_autos_d["expedida"]);
		$pdf->Cell(65,3,$str,0,0);
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Pago de tenencia Vehicular por los años: ".$row_autos_d["tenencia"]);
		$pdf->Cell(145,3,$str,0,0);
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Tarjeta de circulación número: ".$row_autos_d["tcirculacion"]);
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Comprobante de verificación vehícular: ".$row_autos_d["verificacion"]);
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Engomados: ".$row_autos_d["engomados"]);
		$pdf->Cell(85,3,$str,0,0);	
	$pdf->Ln(4);	
	$str=iconv('UTF-8', 'windows-1252',"Póliza de seguro: ".$row_autos_d["poliza_seg"]);
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
	$cadena="DÉCIMA.- Forma de pago. Como quedó expresado en la cláusula quinta, las partes convienen que el costo total del vehículo usado objeto del presente contrato, será liquidado por el COMPRADOR mediante ".$row_contra["no_pagos"]." amortizaciones mensuales por la cantidad que se especifica en el calendario de pagos (VER ANEXO A), pagos que se obliga a realizar los dias ".$row_contra["dia_pagos"]." de cada mes, mediante depósito bancario ante la institución y/o en el domicilio del VENDEDOR, ubicado en ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", C.P. ".trim($row_emp["cp_empresa"]).".";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="DÉCIMA PRIMERA.- Vencimiento anticipado. El VENDEDOR podrá dar por vencido anticipadamente el plazo de pleno derecho y sin necesidad de declaración judicial, si el COMPRADOR faltare al cumplimiento de las obligaciones contraídas en este contrato, y los pagos parciales realizados se aplicarán a intereses estipulados y daños y perjuicios ocasionados por el incumplimiento.\n\nTambién así, ambas partes manifiestan, que a falta de pago de cualquiera de los pagares, se podrá dar por vencido anticipadamente el saldo pendiente y exigir su importe junto con los accesorios correspondientes.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="DÉCIMA SEGUNDA.- Intereses. Las partes convienen que para el caso de que el COMPRADOR deje de cubrir cualquiera de los pagos en la forma y términos convenidos, como se especifica en la cláusula quinta.\n\nLas partes convienen que para el caso de que el COMPRADOR realice los pagos a que se ha obligado en el presente contrato en forma extemporánea, dicho pago se aplicará primeramente a los intereses causados por la mora y el remanente se aplicará a capital.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	


	$pdf->Ln(4);
	$cadena="DÉCIMA TERCERA.- Pagos anticipados. El COMPRADOR podrá en cualquier momento liquidar anticipadamente el saldo del precio de la compra venta, siempre que se encuentre al corriente en sus pagos y dichos pagos serán aplicados al saldo insoluto del principal o a los pagos inmediatos siguientes según corresponda, sin penalización alguna.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="DÉCIMA CUARTA.- Garantía del vehículo. Ambas partes manifiestan y están de acuerdo que por tratarse de una unidad usada, la que adquiere el COMPRADOR éste la acepta y la recibe en el estado de uso y mecánico en que se encuentra, el cual le ha sido facilitado para su revisión general, por cuyo motivo el vehículo usado se vende: ";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	


	$marca_garantia="(   )  ";
	$marca_sin_garantia="( X )  ";
	if ($row_contra["garantia"]==1) {
		$marca_garantia="( X )  ";
		$marca_sin_garantia="(   )  ";
	}

	$pdf->Ln(4);
	$cadena=$marca_sin_garantia."Sin garantía. en este caso, el VENDEDOR no está obligado a realizar ningún tipo de reparación, por lo que el COMPRADOR asumirá los costos por reparaciones, suministro de refacciones, mano de obra calificada, entre otros.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena=$marca_garantia."Con garantía por un plazo de 60 días, (Art. 77 de la Ley Federal de Protección al COnsumidor, la garantía no podrá ser inferior a 60 días naturales) contados a partir de la entrega del vehículo usado, excluyéndose la correspondiente a partes eléctricas y deberá hacerse valida en el domicilio , teléfonos y horarios de atención señalados en el presente contrato, siempre y cuando no se haya efectuado una reparación por un tercero. Asimismo, el VENDEDOR será el responsable por las descomposturas, daños o pérdidas parciales o totales imputables a él, mientras el vehículo se encuentre bajo su responsabilidad para llevar a cabo el cumplimiento de la garantía.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="DÉCIMA QUINTA.- Para efectos de seguimiento de solicitudes, aclaraciones, inconformidades y quejas relacionados con la operación o servicio contratado, le serán atendidas de forma inmediata y podrá hacerlo por los siguientes medios: de manera escrita, entregándola en la dirección: ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", C.P. ".trim($row_emp["cp_empresa"]).", por medio de sí mismo, se le dará respuesta en ______ dias habiles, en quejas, comentarios o sugerencias, podrá hacerlo en la dirección y teléfonos de la empresa, negocio o sucursal, que se encuentra ubicado en: ".trim($row_emp["domicilio_empresa"]).", ".trim($row_emp["ciudad_empresa"]).",".trim($row_emp["estado_empresa"]).", C.P. ".trim($row_emp["cp_empresa"]).", Teléfono(s) ".trim($row_emp["tel_empresa"]).".";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');	

	$pdf->Ln(4);
	$cadena="DÉCIMA SEXTA. Domicilio. Las partes se obligan a informar a su contraparte, durante la vigencia del contrato el cambio de domicilio que llegare a tener, en un plazo máximo de 5 (cinco) días posteriores a la verificación del mismo.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="DÉCIMA SÉPTIMA. Rescisión. Las partes podrán rescindir el presente contrato cuando:

Por causas imputables al COMPRADOR.

		a). Cuando el vehículo objeto de la compra venta sufra destrucción total o daños que afectan su naturaleza o este sea materia de embargo, secuestro judicial u otro acontecimiento semejante a los citados en esta cláusula de lo que sea responsable el COMPRADOR.\n
		b). Por cesión o traspaso de derechos o arrendamiento del vehículo y de cualquiera de los derechos que adquiere el COMPRADOR y sin que medie consentimiento otorgado por escrito del VENDEDOR.\n
		c). Por falta de pago, a la fecha de vencimiento de dos o más amortizaciones pactadas, con excepción de cuando el COMPRADOR haya cubierto más de la tercera parte del precio estipulado, en cuyo caso podrá optar por el pago del adeudo vencido, en términos de lo previsto por el artículo 71 de la Ley Federal de Protección al Consumidor.\n
		d). Por haber cambiado su domicilio sin dar aviso al VENDEDOR.
	
Por causas imputables al VENDEDOR.
	
		a). Por imcumpliento del VENDEDOR a cualesquiera de las obligaciones estipulados en el presente contrato.\n
		b). Si el vehículo presentare vicios ocultos que no hayan sido informados al COMPRADOR y expresamente aceptados por el mismo, a través del presente contrato.\n
		c). Si el vehículo le fuera entregado al COMPRADOR en condiciones con características distintas a las señaladas en la cláusula SEGUNDA del presente contrato.

Si se rescinde el presente contrato, el VENDEDOR y el COMPRADOR deben restituirse mutuamente las prestaciones que se hubieren hecho, el VENDEDOR que hubiera entregado el vehículo, tendrá derecho a exigir por su uso, el pago de un alquiler o renta y, en su caso, una compensación por el demérito que haya sufrido, situaciones que deberán establecer las partes de común acuerdo.

El COMPRADOR que haya pagado parte del precio tiene derecho a recibir los intereses computados conforme a la tasa que, en su caso, se haya aplicado a su pago.

Cuando el COMPRADOR haya pagado más de la tercera parte del precio o del número total de los pagos convenidos y el VENDEDOR exija la rescisión o cumplimiento del contrato por mora, el COMPRADOR tendrá derecho a optar por la rescisión en términos de lo establecido en el párrafo anterior o por el pago del adeudo vencido más las prestaciones que legalmente procedan. Los pagos que realice el COMPRADOR, aún en forma extemporánea y que sean aceptados por el VENDEDOR, liberan a aquél de las obligaciones inherentes a dichos pagos.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="DÉCIMA OCTAVA. Obligaciones del VENDEDOR. El VENDEDOR se hace responsable de cualquier situación legal que anteceda a la fecha de entrega del vehículo, sin ninguna responsabilidad para el COMPRADOR.

Asimismo, el VENDEDOR libera al COMPRADOR de cualquier responsabilidad que hubiere surgido o pudiese surgir con relación al origen, propiedad, posesión o cualquier otro derecho inherente al vehículo o partes o componentes del mismo, hasta antes de ser entregado el vehículo al COMPRADOR obligándose asimismo a responder por el saneamiento para el caso de evicción.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="DÉCIMA NOVENA. Pena convencional. Las partes convienen que por el incumplimiento de cualquiera de las obligaciones contenidas en el presente contrato, se aplicará al responsable una pena convencional, equivalente al 15%, del precio de la operación materia del presente contrato.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="VIGÉSIMA. Deudor solidario y aval. Para garantizar y asegurar el cumplimiento de todas y cada una de las obligaciones por el COMPRADOR en el presente contrato, el (la) señor (a) ".trim($row_ava2["nombre_aval"]).", con domicilioo en ".trim($row_ava["domicilio_aval"]).",  C.P. ".trim($row_ava["cp_aval"])." de la ciudad de ".trim($row_ava["ciudad_aval"]).", se constituye en deudor solidario y aval del COMPRADOR y se obliga con éste al cumplimiento de todas las obligaciones y acepta expresamente que su responsabilidad no terminará hasta que termine por cualquier causa el presente contrato. Como consecuencia de la obligación que contrae en la presente cláusula el fiador conviene y se obliga a firmar como aval los pagarés expedidos por el VENDEDOR.";
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
		$texto=iconv('UTF-8', 'windows-1252','Ocupación: '.$row_ava["ocupacion"]);
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(5);
		$texto=iconv('UTF-8', 'windows-1252','Domicilio: '.trim($row_ava["domicilio_aval"]).", ".trim($row_ava["ciudad_aval"]));
		$pdf->Cell(75,3,$texto,0,0);
		$pdf->Ln(10);
	 } while ($row_ava = mysqli_fetch_assoc($ava));

	$pdf->Ln(4);
	$cadena="VIGÉSIMA PRIMERA. Competencia. Para la interpretación y cumplimiento del presente contrato de compra venta, en la vía administrativa, será competente la Procuraduría Federal del Consumidor, sin perjuicio de lo anterior, las partes se someten a la jurisdicción de los tribunales competentes de la ciudad de Tijuana, renunciando expresamente a cualquier otra jurisdicción que pudiera corresponderles, por razón de sus domicilios presentes o futuros o por cualquier otra razón.";
    $str=iconv('UTF-8', 'windows-1252',$cadena);
	$pdf->MultiCell(164,4,$str,0,'J');		

	$pdf->Ln(4);
	$cadena="Leido que fue el presente contrato y saber los alcances jurídicos que del mismo se derivan, por haberlo leido de manera bastante y suficiente el COMPRADOR, y asimismo le fue explicado en todas y cada una de sus partes, en razón de lo cual firman las partes al margen y alcance, siendo las ".date("G")." horas con ".date("i")." minutos en la ciudad de "."Tijuana, B.C. a ".nombre_fecha($row_contra["fecha_contrato"])." y quedando en poder de cada una de las partes un tanto del contrato, declaraciones, clausulas y anexos.";
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
		$texto=iconv('UTF-8', 'windows-1252',"SR. CÉSAR ANTONIO CÁZARES DÍAZ DE LEÓN, ALBACEA DE ");
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