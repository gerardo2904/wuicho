<?php

function funciones_reemplazadas(){
    
    if (!function_exists("GetSQLValueString")) {
        function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
        {
            $contratos_londres= mysqli_connect('db:3306', 'macpresc_root', 'atomicstatus',"macpresc_contratos_londres");
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


function opciones($valor1,$valor2,$tip,$bd) {
	mysql_select_db($database_londres, $bd);
	$query_tipo = "SELECT marca.marca, tipo_auto.estilo, tipo_auto.modelo FROM tipo_auto, marca WHERE marca.clave_marca=tipo_auto.clave_marca AND marca.marca='$valor1' AND tipo_auto.estilo='$valor2' group by modelo order by modelo";
	$tiposx = mysql_query($query_tipo, $bd) or die(mysql_error());
	$totalRows_tipo = mysql_num_rows($tiposx);

	// echo $totalRows_tipo;
	
	if ($totalRows_tipo > 0 ) {
	$vector_tipo = array();
	$ren=0;

	
	$cad1="<script> addOption('$tip', 'Selecciona un modelo', '');</script>";
	echo $cad1;
	

	while ($row_tipo = mysql_fetch_assoc($tiposx)) {
		$contenidox=$row_tipo["modelo"];
		//echo $contenido;
		array_push($vector_tipo,$contenidox);

		$row_area2=$vector_tipo[$ren];
		//echo $row_area2;
		//echo $ren;
		$variable3="<script language='javascript'> var $row_area2 = <?php echo '$row_area2'; ?> </script> ";	
		echo $variable3;
		$cad3 = "<script> addOption('$tip', '$row_area2', '$row_area2');</script>";
		echo "$cad3";
		$ren=$ren+1;
}
}
mysql_free_result($tiposx);	
}

///

function tipos($valor,$bd) {
	mysql_select_db($database_londres, $bd);
	$query_tipo = "SELECT marca.marca, tipo_auto.estilo FROM tipo_auto,marca WHERE marca.clave_marca=tipo_auto.clave_marca AND marca.marca='$valor' group by estilo order by estilo";
	$tipos = mysql_query($query_tipo, $bd) or die(mysql_error());
	$totalRows_tipo = mysql_num_rows($tipos);
	
	if ($totalRows_tipo > 0 ) {
	$vector_tipo = array();
	$ren=0;

$dum='dummy-'.$valor;
$cad1="<script> addList('$valor', 'Selecciona un modelo', '', '$dum');</script>";

echo $cad1;

	while ($row_tipo = mysql_fetch_assoc($tipos)) {
		$contenidox=$row_tipo["estilo"];
		//echo $contenido;
		array_push($vector_tipo,$contenidox);

		$row_area2=$vector_tipo[$ren];
		$tip=$valor.'-'.$row_area2;
		$variable3="<script language='javascript'> var $row_area2 = <?php echo '$row_area2'; ?> </script> ";	
		echo $variable3;
		$cad3 = "<script> addList('$valor', '$row_area2', '$row_area2','$tip');</script>";
		echo "$cad3";
		opciones($valor,$row_area2,$tip,$bd);
		$ren=$ren+1;
}
$cad1="<script> addOption('$dum', 'No disponible', '');</script>";

}
mysql_free_result($tipos);	
}


function send_mail($to, $body, $subject, $fromaddress, $fromname, $attachments=false)
{
  $eol="\r\n";
  $mime_boundary=md5(time());

  # Common Headers
  $headers .= "From: ".$fromname."<".$fromaddress.">".$eol;
  $headers .= "Reply-To: ".$fromname."<".$fromaddress.">".$eol;
  $headers .= "Return-Path: ".$fromname."<".$fromaddress.">".$eol;    // these two to set reply address
  $headers .= "Message-ID: <".time()."-".$fromaddress.">".$eol;
  $headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters

  # Boundry for marking the split & Multitype Headers
  $headers .= 'MIME-Version: 1.0'.$eol.$eol;
  $headers .= "Content-Type: multipart/mixed; boundary=\"".$mime_boundary."\"".$eol.$eol;

  # Open the first part of the mail
  $msg = "--".$mime_boundary.$eol;

  $htmlalt_mime_boundary = $mime_boundary."_htmlalt"; //we must define a different MIME boundary for this section
  # Setup for text OR html -
  $msg .= "Content-Type: multipart/alternative; boundary=\"".$htmlalt_mime_boundary."\"".$eol.$eol;

  # Text Version
  $msg .= "--".$htmlalt_mime_boundary.$eol;
  $msg .= "Content-Type: text/plain; charset=iso-8859-1".$eol;
  $msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
  $msg .= strip_tags(str_replace("<br>", "\n", substr($body, (strpos($body, "<body>")+6)))).$eol.$eol;

  # HTML Version
  $msg .= "--".$htmlalt_mime_boundary.$eol;
  $msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;
  $msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
  $msg .= $body.$eol.$eol;

  //close the html/plain text alternate portion
  $msg .= "--".$htmlalt_mime_boundary."--".$eol.$eol;

  if ($attachments !== false)
  {
    for($i=0; $i < count($attachments); $i++)
    {
      if (is_file($attachments[$i]["file"]))
      {
        # File for Attachment
        $file_name = substr($attachments[$i]["file"], (strrpos($attachments[$i]["file"], "/")+1));

        $handle=fopen($attachments[$i]["file"], 'rb');
        $f_contents=fread($handle, filesize($attachments[$i]["file"]));
        $f_contents=chunk_split(base64_encode($f_contents));    //Encode The Data For Transition using base64_encode();
        $f_type=filetype($attachments[$i]["file"]);
        fclose($handle);

        # Attachment
        $msg .= "--".$mime_boundary.$eol;
        $msg .= "Content-Type: ".$attachments[$i]["content_type"]."; name=\"".$file_name."\"".$eol;  // sometimes i have to send
        $msg .= "Content-Transfer-Encoding: base64".$eol;
        $msg .= "Content-Description: ".$file_name.$eol;
        $msg .= "Content-Disposition: attachment; filename=\"".$file_name."\"".$eol.$eol; // !! This line needs TWO end of lines
        $msg .= $f_contents.$eol.$eol;
      }
    }
  }

  # Finished
  $msg .= "--".$mime_boundary."--".$eol.$eol;  // finish with two eol's for better security. see Injection.

  # SEND THE EMAIL
  ini_set(sendmail_from,$fromaddress);  // the INI lines are to force the From Address to be used !
  $mail_sent = mail($to, $subject, $msg, $headers);

  ini_restore(sendmail_from);

  return $mail_sent;
}

function form_mail($sPara, $sAsunto, $sTexto, $sDe){

    if ($sDe)$sDe = "From:".$sDe;

    return(mail($sPara, $sAsunto, $sTexto, $sDe));
}


//// Funcion para borrar archivos de fotos..
function borra_foto($valor1,$conexion,$linkbd) {
	mysqli_select_db($linkbd, $conexion);
	$query_borrar = "SELECT * FROM fotos WHERE fotos.clave_inv=".$valor1;
	$borrarx = mysqli_query($linkbd, $query_borrar) or die(mysql_error());
	$totalRows_borrar = mysqli_num_rows($borrarx);

	
	if ($totalRows_borrar > 0 ) {
	$vector_borrar = array();
	$ren=0;

	while ($row_borrar = mysqli_fetch_assoc($borrarx)) {
		$contenidox=$row_borrar["foto"];
		array_push($vector_borrar,$contenidox);
		$row_area2=$vector_borrar[$ren];
		$variable3="del '$row_area2'";	
		echo "<pre>$variable3</pre>";
		echo exec($variable3);
		$ren=$ren+1;
}
}
mysqli_free_result($borrarx);	
}

//////////////////NUEVAS FUNCIONEAS AGREGADAS..


//funcion que suma dias a una fecha
function suma_fechas($fecha,$ndias)
            
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$año)=preg_split("/\/|-/",$fecha); 
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$año)=preg_split("/\/|-/",$fecha); 
    
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
}

function nombre_fecha($fecha, $solomes=0) {
$d1="";
	$d2="";
	$d3="";
	
	if ( preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha)) {
	
        list($dia,$mes,$año)=array_pad( explode( '/', $fecha ),3,'');

    }
    
    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha)) {
            
              list($dia,$mes,$año)=array_pad( explode( '-', $fecha ),3,'');
    }
        
	$d1=$dia;
	$d2=$mes;
    $d3=$año;
        
                
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
	$d3=$año;
	//}
	if($solomes==0)
		$fecha=iconv('UTF-8', 'windows-1252',$d1." de ".$d2." del ".$d3);
	else
		$fecha=iconv('UTF-8', 'windows-1252',$d1."/".$d2."/".$d3);
	return $fecha;
}


/*
//*********************************************************************************
 // FUNCIONES DE CONVERSION DE NUMEROS A LETRAS.                                                      
 // Se llama a la función principal: convertir_a_letras($numero)                                      
                                                                                                      
 function centimos()                                                                                  
 {                                                                                                    
 global $importe_parcial;                                                                             
                                                                                                      
 $importe_parcial = number_format($importe_parcial, 2, ".", "") * 100;                                
                                                                                                      
 if ($importe_parcial > 0)                                                                            
	$num_letra = " con ".decena_centimos($importe_parcial);                                              
 else                                                                                                 
	$num_letra = "";                                                                                     
                                                                                                      
 return $num_letra;                                                                                   
 }                                                                                                    
                                                                                                      
                                                                                                      
 function unidad_centimos($numero)                                                                    
 {                                                                                                    
 switch ($numero) {                                                                                                    
	case 9: {$num_letra = "nueve centavos";break;}                                                                                                    
	case 8: {$num_letra = "ocho centavos"; break;}                                                                                                    
 case 7:                                                                                              
 {                                                                                                    
 $num_letra = "siete centavos";                                                                       
 break;                                                                                               
 }                                                                                                    
 case 6:                                                                                              
 {                                                                                                    
 $num_letra = "seis centavos";                                                                        
 break;                                                                                               
 }                                                                                                    
 case 5:                                                                                              
 {                                                                                                    
 $num_letra = "cinco centavos";                                                                       
 break;                                                                                               
 }                                                                                                    
 case 4:                                                                                              
 {                                                                                                    
 $num_letra = "cuatro centavos";                                                                      
 break;                                                                                               
 }                                                                                                    
 case 3:                                                                                              
 {                                                                                                    
 $num_letra = "tres centavos";                                                                        
 break;                                                                                               
 }                                                                                                    
 case 2:                                                                                              
 {                                                                                                    
 $num_letra = "dos centavos";                                                                         
 break;                                                                                               
 }                                                                                                    
 case 1:                                                                                              
 {                                                                                                    
 $num_letra = "un céntimo";                                                                           
 break;                                                                                               
 }                                                                                                    
 }                                                                                                    
 return $num_letra;                                                                                   
 }                                                                                                    
                                                                                                      
                                                                                                      
 function decena_centimos($numero)                                                                    
 {                                                                                                    
 if ($numero >= 10)                                                                                   
 {                                                                                                    
 if ($numero >= 90 && $numero <= 99)                                                                  
 {                                                                                                    
 if ($numero == 90)                                                                                   
 return "noventa centavos";                                                                           
 else if ($numero == 91)                                                                              
 return "noventa y un centavos";                                                                      
 else                                                                                                 
 return "noventa y ".unidad_centimos($numero - 90);                                                   
 }                                                                                                    
 if ($numero >= 80 && $numero <= 89)                                                                  
 {                                                                                                    
 if ($numero == 80)                                                                                   
 return "ochenta centavos";                                                                           
 else if ($numero == 81)                                                                              
 return "ochenta y un centavos";                                                                      
 else                                                                                                 
 return "ochenta y ".unidad_centimos($numero - 80);                                                   
 }                                                                                                    
 if ($numero >= 70 && $numero <= 79)                                                                  
 {                                                                                                    
 if ($numero == 70)                                                                                   
 return "setenta centavos";                                                                           
 else if ($numero == 71)                                                                              
 return "setenta y un centavos";                                                                      
 else                                                                                                 
 return "setenta y ".unidad_centimos($numero - 70);                                                   
 }                                                                                                    
 if ($numero >= 60 && $numero <= 69)                                                                  
 {                                                                                                    
 if ($numero == 60)                                                                                   
 return "sesenta centavos";                                                                           
 else if ($numero == 61)                                                                              
 return "sesenta y un centavos";                                                                      
 else                                                                                                 
 return "sesenta y ".unidad_centimos($numero - 60);                                                   
 }                                                                                                    
 if ($numero >= 50 && $numero <= 59)                                                                  
 {                                                                                                    
 if ($numero == 50)                                                                                   
 return "cincuenta centavos";                                                                         
 else if ($numero == 51)                                                                              
 return "cincuenta y un centavos";                                                                    
 else                                                                                                 
 return "cincuenta y ".unidad_centimos($numero - 50);                                                 
 }                                                                                                    
 if ($numero >= 40 && $numero <= 49)                                                                  
 {                                                                                                    
 if ($numero == 40)                                                                                   
 return "cuarenta centavos";                                                                          
 else if ($numero == 41)                                                                              
 return "cuarenta y un centavos";                                                                     
 else                                                                                                 
 return "cuarenta y ".unidad_centimos($numero - 40);                                                  
 }                                                                                                    
 if ($numero >= 30 && $numero <= 39)                                                                  
 {                                                                                                    
 if ($numero == 30)                                                                                   
 return "treinta centavos";                                                                           
 else if ($numero == 91)                                                                              
 return "treinta y un centavos";                                                                      
 else                                                                                                 
 return "treinta y ".unidad_centimos($numero - 30);                                                   
 }                                                                                                    
 if ($numero >= 20 && $numero <= 29)                                                                  
 {                                                                                                    
 if ($numero == 20)                                                                                   
 return "veinte centavos";                                                                            
 else if ($numero == 21)                                                                              
 return "veintiun centavos";                                                                          
 else                                                                                                 
 return "veinti".unidad_centimos($numero - 20);                                                       
 }                                                                                                    
 if ($numero >= 10 && $numero <= 19)                                                                  
 {                                                                                                    
 if ($numero == 10)                                                                                   
 return "diez centavos";                                                                              
 else if ($numero == 11)                                                                              
 return "once centavos";                                                                              
 else if ($numero == 11)                                                                              
 return "doce centavos";                                                                              
 else if ($numero == 11)                                                                              
 return "trece centavos";                                                                             
 else if ($numero == 11)                                                                              
 return "catorce centavos";                                                                           
 else if ($numero == 11)                                                                              
 return "quince centavos";                                                                            
 else if ($numero == 11)                                                                              
 return "dieciseis centavos";                                                                         
 else if ($numero == 11)                                                                              
 return "diecisiete centavos";                                                                        
 else if ($numero == 11)                                                                              
 return "dieciocho centavos";                                                                         
 else if ($numero == 11)                                                                              
 return "diecinueve centavos";                                                                        
 }                                                                                                    
 }                                                                                                    
 else                                                                                                 
 return unidad_centimos($numero);                                                                     
 }                                                                                                    
                                                                                                      
                                                                                                      
 function unidad($numero)                                                                             
 {                                                                                                    
 switch ($numero)                                                                                     
 {                                                                                                    
 case 9:                                                                                              
 {                                                                                                    
 $num = "nueve";                                                                                      
 break;                                                                                               
 }                                                                                                    
 case 8:                                                                                              
 {                                                                                                    
 $num = "ocho";                                                                                       
 break;                                                                                               
 }                                                                                                    
 case 7:                                                                                              
 {                                                                                                    
 $num = "siete";                                                                                      
 break;                                                                                               
 }                                                                                                    
 case 6:                                                                                              
 {                                                                                                    
 $num = "seis";                                                                                       
 break;                                                                                               
 }                                                                                                    
 case 5:                                                                                              
 {                                                                                                    
 $num = "cinco";                                                                                      
 break;                                                                                               
 }                                                                                                    
 case 4:                                                                                              
 {                                                                                                    
 $num = "cuatro";                                                                                     
 break;                                                                                               
 }                                                                                                    
 case 3:                                                                                              
 {                                                                                                    
 $num = "tres";                                                                                       
 break;                                                                                               
 }                                                                                                    
 case 2:                                                                                              
 {                                                                                                    
 $num = "dos";                                                                                        
 break;                                                                                               
 }                                                                                                    
 case 1:                                                                                              
 {                                                                                                    
 $num = "uno";                                                                                        
 break;                                                                                               
 }                                                                                                    
 }                                                                                                    
 return $num;                                                                                         
 }                                                                                                    
                                                                                                      
                                                                                                      
 function decena($numero)                                                                             
 {                                                                                                    
 if ($numero >= 90 && $numero <= 99)                                                                  
 {                                                                                                    
 $num_letra = "noventa ";                                                                             
                                                                                                      
 if ($numero > 90)                                                                                    
 $num_letra = $num_letra."y ".unidad($numero - 90);                                                   
 }                                                                                                    
 else if ($numero >= 80 && $numero <= 89)                                                             
 {                                                                                                    
 $num_letra = "ochenta ";                                                                             
                                                                                                      
 if ($numero > 80)                                                                                    
 $num_letra = $num_letra."y ".unidad($numero - 80);                                                   
 }                                                                                                    
 else if ($numero >= 70 && $numero <= 79)                                                             
 {                                                                                                    
 $num_letra = "setenta ";                                                                             
                                                                                                      
 if ($numero > 70)                                                                                    
 $num_letra = $num_letra."y ".unidad($numero - 70);                                                   
 }                                                                                                    
 else if ($numero >= 60 && $numero <= 69)                                                             
 {                                                                                                    
 $num_letra = "sesenta ";                                                                             
                                                                                                      
 if ($numero > 60)                                                                                    
 $num_letra = $num_letra."y ".unidad($numero - 60);                                                   
 }                                                                                                    
 else if ($numero >= 50 && $numero <= 59)                                                             
 {                                                                                                    
 $num_letra = "cincuenta ";                                                                           
                                                                                                      
 if ($numero > 50)                                                                                    
 $num_letra = $num_letra."y ".unidad($numero - 50);                                                   
 }                                                                                                    
 else if ($numero >= 40 && $numero <= 49)                                                             
 {                                                                                                    
 $num_letra = "cuarenta ";                                                                            
                                                                                                      
 if ($numero > 40)                                                                                    
 $num_letra = $num_letra."y ".unidad($numero - 40);                                                   
 }                                                                                                    
 else if ($numero >= 30 && $numero <= 39)                                                             
 {                                                                                                    
 $num_letra = "treinta ";                                                                             
                                                                                                      
 if ($numero > 30)                                                                                    
 $num_letra = $num_letra."y ".unidad($numero - 30);                                                   
 }                                                                                                    
 else if ($numero >= 20 && $numero <= 29)                                                             
 {                                                                                                    
 if ($numero == 20)                                                                                   
 $num_letra = "veinte ";                                                                              
 else                                                                                                 
 $num_letra = "veinti".unidad($numero - 20);                                                          
 }                                                                                                    
 else if ($numero >= 10 && $numero <= 19)                                                             
 {                                                                                                    
 switch ($numero)                                                                                     
 {                                                                                                    
 case 10:                                                                                             
 {                                                                                                    
 $num_letra = "diez ";                                                                                
 break;                                                                                               
 }                                                                                                    
 case 11:                                                                                             
 {                                                                                                    
 $num_letra = "once ";                                                                                
 break;                                                                                               
 }                                                                                                    
 case 12:                                                                                             
 {                                                                                                    
 $num_letra = "doce ";                                                                                
 break;                                                                                               
 }                                                                                                    
 case 13:                                                                                             
 {                                                                                                    
 $num_letra = "trece ";                                                                               
 break;                                                                                               
 }                                                                                                    
 case 14:                                                                                             
 {                                                                                                    
 $num_letra = "catorce ";                                                                             
 break;                                                                                               
 }                                                                                                    
 case 15:                                                                                             
 {                                                                                                    
 $num_letra = "quince ";                                                                              
 break;                                                                                               
 }                                                                                                    
 case 16:                                                                                             
 {                                                                                                    
 $num_letra = "dieciseis ";                                                                           
 break;                                                                                               
 }                                                                                                    
 case 17:                                                                                             
 {                                                                                                    
 $num_letra = "diecisiete ";                                                                          
 break;                                                                                               
 }                                                                                                    
 case 18:                                                                                             
 {                                                                                                    
 $num_letra = "dieciocho ";                                                                           
 break;                                                                                               
 }                                                                                                    
 case 19:                                                                                             
 {                                                                                                    
 $num_letra = "diecinueve ";                                                                          
 break;                                                                                               
 }                                                                                                    
 }                                                                                                    
 }                                                                                                    
 else                                                                                                 
 $num_letra = unidad($numero);                                                                        
                                                                                                      
 return $num_letra;                                                                                   
 }                                                                                                    
                                                                                                      
                                                                                                      
 function centena($numero)                                                                            
 {                                                                                                    
	if ($numero >= 100)                                                                                  
	{                                                                                                    
		if ($numero >= 900 & $numero <= 999)                                                                 
			{                                                                                                    
				$num_letra = "novecientos ";                                                                         
                                                                                                      
				if ($numero > 900)                                                                                   
					$num_letra = $num_letra.decena($numero - 900);                                                       
			}                                                                                                    
		else if ($numero >= 800 && $numero <= 899)                                                           
			{                                                                                                    
				$num_letra = "ochocientos ";                                                                         
                                                                                                      
				if ($numero > 800)                                                                                   
					$num_letra = $num_letra.decena($numero - 800);                                                       
			}                                                                                                    
		else if ($numero >= 700 && $numero <= 799)                                                           
			{                                                                                                    
				$num_letra = "setecientos ";                                                                         
                                                                                                      
				if ($numero > 700)                                                                                   
					$num_letra = $num_letra.decena($numero - 700);                                                       
			}                                                                                                    
		else if ($numero >= 600 && $numero <= 699)                                                           
			{                                                                                                    
				$num_letra = "seiscientos ";                                                                         
                                                                                                      
				if ($numero > 600)                                                                                   
					$num_letra = $num_letra.decena($numero - 600);                                                       
			}                                                                                                    
		else if ($numero >= 500 && $numero <= 599)                                                           
			{                                                                                                    
				$num_letra = "quinientos ";                                                                          
                                                                                                      
				if ($numero > 500)                                                                                   
					$num_letra = $num_letra.decena($numero - 500);                                                       
			}                                                                                                    
		else if ($numero >= 400 && $numero <= 499)                                                           
			{                                                                                                    
				$num_letra = "cuatrocientos ";                                                                       
                                                                                                      
				if ($numero > 400)                                                                                   
					$num_letra = $num_letra.decena($numero - 400);                                                       
			}                                                                                                    
		else if ($numero >= 300 && $numero <= 399)                                                           
			{                                                                                                    
				$num_letra = "trescientos ";                                                                         
                                                                                                      
				if ($numero > 300)                                                                                   
					$num_letra = $num_letra.decena($numero - 300);                                                       
			}                                                                                                    
		else if ($numero >= 200 && $numero <= 299)                                                           
			{                                                                                                    
				$num_letra = "doscientos ";                                                                          
                                                                                                      
				if ($numero > 200)                                                                                   
					$num_letra = $num_letra.decena($numero - 200);                                                       
			}                                                                                                    
		else if ($numero >= 100 && $numero <= 199)                                                           
			{                                                                                                    
				if ($numero == 100)                                                                                  
					$num_letra = "cien ";                                                                                
				else                                                                                                 
					$num_letra = "ciento ".decena($numero - 100);                                                        
			}                                                                                                    
	}                                                                                                    
	else                                                                                                 
		$num_letra = decena($numero);                                                                        
                                                                                                      
	return $num_letra;                                                                                   
 }                                                                                                    
                                                                                                      
                                                                                                      
 function cien()                                                                                      
 {                                                                                                    
	global $importe_parcial;                                                                             
                                                                                                      
	$parcial = 0; $car = 0;                                                                              
                                                                                                      
	while (substr($importe_parcial, 0, 1) == 0)                                                          
		$importe_parcial = substr($importe_parcial, 1, strlen($importe_parcial) - 1);                                                                                                  
                                                                                                      
	if ($importe_parcial >= 1 && $importe_parcial <= 9.99)                                               
		$car = 1;                                                                                            
	else if ($importe_parcial >= 10 && $importe_parcial <= 99.99)                                        
		$car = 2;                                                                                            
		else if ($importe_parcial >= 100 && $importe_parcial <= 999.99)                                      
			$car = 3;                                                                                            
                                                                                                      
	$parcial = substr($importe_parcial, 0, $car);                                                        
	$importe_parcial = substr($importe_parcial, $car);                                                   
                                                                                                      
	$num_letra = centena($parcial).centimos();                                                           
                                                                                                      
	return $num_letra;                                                                                   
 }                                                                                                    
                                                                                                      
                                                                                                      
 function cien_mil()                                                                                  
 {                                                                                                    
	global $importe_parcial;                                                                             
                                                                                                      
	$parcial = 0; $car = 0;                                                                              
                                                                                                      
	while (substr($importe_parcial, 0, 1) == 0)                                                          
		$importe_parcial = substr($importe_parcial, 1, strlen($importe_parcial) - 1);                                                                                                  
                                                                                                      
	if ($importe_parcial >= 1000 && $importe_parcial <= 9999.99)                                         
	$car = 1;                                                                                            
	else if ($importe_parcial >= 10000 && $importe_parcial <= 99999.99)                                  
		$car = 2;                                                                                            
		else if ($importe_parcial >= 100000 && $importe_parcial <= 999999.99)                                
			$car = 3;                                                                                            
                                                                                                      
	$parcial = substr($importe_parcial, 0, $car);                                                        
	$importe_parcial = substr($importe_parcial, $car);                                                   
                                                                                                      
	if ($parcial > 0)                                                                                    
	{                                                                                                    
		if ($parcial == 1)                                                                                   
			$num_letra = "mil ";                                                                                 
		else                                                                                                 
			$num_letra = centena($parcial)." mil ";                                                              
	}                                                                                                    
                                                                                                      
	return $num_letra;                                                                                   
 }                                                                                                    
                                                                                                      
                                                                                                      
 function millon()                                                                                    
 {                                                                                                    
	global $importe_parcial;                                                                             
                                                                                                      
	$parcial = 0; $car = 0;                                                                              
                                                                                                      
	while (substr($importe_parcial, 0, 1) == 0)                                                          
		$importe_parcial = substr($importe_parcial, 1, strlen($importe_parcial) - 1);                                                                                                  

	if ($importe_parcial >= 1000000 && $importe_parcial <= 9999999.99)                                   
		$car = 1;                                                                                            
	else if ($importe_parcial >= 10000000 && $importe_parcial <= 99999999.99)                            
		$car = 2;                                                                                            
		else if ($importe_parcial >= 100000000 && $importe_parcial <=999999999.99)                                                                                         
			$car = 3;                                                                                            
                                                                                                      
	$parcial = substr($importe_parcial, 0, $car);                                                        
	$importe_parcial = substr($importe_parcial, $car);                                                   
                                                                                                      
	if ($parcial == 1)                                                                                   
		$num_letras = "un millón ";                                                                          
	else                                                                                                 
		$num_letras = centena($parcial)." millones ";                                                        

	return $num_letras; 
 }                                                                                                    

                                                                                                      
 function convertir_a_letras($numero)                                                                 
 {                                                                                                    
	global $importe_parcial;                                                                             
                                                                                                      
	$importe_parcial = $numero;                                                                          
                                                                                                      
	if ($numero < 1000000000)                                                                            
		{                                                                                                    
			if ($numero >= 1000000 && $numero <= 999999999.99)                                                   
				$num_letras = millon().cien_mil().cien();                                                            
			else if ($numero >= 1000 && $numero <= 999999.99)                                                    
				$num_letras = cien_mil().cien();                                                                     
				else if ($numero >= 1 && $numero <= 999.99)                                                          
					$num_letras = cien();                                                                                
					else if ($numero >= 0.01 && $numero <= 0.99)                                                         
						{                                                                                                    
							if ($numero == 0.01)                                                                                 
								$num_letras = "un céntimo";                                                                          
							else                                                                                                 
								$num_letras = convertir_a_letras(($numero * 100)."/100")." centavos";                                
						}                                                                                                    
		}                                                                                                    
	return $num_letras;                                                                                  
 } 
//*********************************************************************************
*/
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
        //$this->Cell(40,7,$col,1);
    $this->Ln();

}


//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-10);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    //$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}
/// Terminan funciones para generacion de PDFs

///************Conversion de numeros a letras
function unidad($numuero){
switch ($numuero)
{
case 9:
{
$numu = "NUEVE";
break;
}
case 8:
{
$numu = "OCHO";
break;
}
case 7:
{
$numu = "SIETE";
break;
}
case 6:
{
$numu = "SEIS";
break;
}
case 5:
{
$numu = "CINCO";
break;
}
case 4:
{
$numu = "CUATRO";
break;
}
case 3:
{
$numu = "TRES";
break;
}
case 2:
{
$numu = "DOS";
break;
}
case 1:
{
$numu = "UN";
break;
}
case 0:
{
$numu = "";
break;
}
}
return $numu;
}

function decena($numdero){

if ($numdero >= 90 && $numdero <= 99)
{
$numd = "NOVENTA ";
if ($numdero > 90)
$numd = $numd."Y ".(unidad($numdero - 90));
}
else if ($numdero >= 80 && $numdero <= 89)
{
$numd = "OCHENTA ";
if ($numdero > 80)
$numd = $numd."Y ".(unidad($numdero - 80));
}
else if ($numdero >= 70 && $numdero <= 79)
{
$numd = "SETENTA ";
if ($numdero > 70)
$numd = $numd."Y ".(unidad($numdero - 70));
}
else if ($numdero >= 60 && $numdero <= 69)
{
$numd = "SESENTA ";
if ($numdero > 60)
$numd = $numd."Y ".(unidad($numdero - 60));
}
else if ($numdero >= 50 && $numdero <= 59)
{
$numd = "CINCUENTA ";
if ($numdero > 50)
$numd = $numd."Y ".(unidad($numdero - 50));
}
else if ($numdero >= 40 && $numdero <= 49)
{
$numd = "CUARENTA ";
if ($numdero > 40)
$numd = $numd."Y ".(unidad($numdero - 40));
}
else if ($numdero >= 30 && $numdero <= 39)
{
$numd = "TREINTA ";
if ($numdero > 30)
$numd = $numd."Y ".(unidad($numdero - 30));
}
else if ($numdero >= 20 && $numdero <= 29)
{
if ($numdero == 20)
$numd = "VEINTE ";
else
$numd = "VEINTI".(unidad($numdero - 20));
}
else if ($numdero >= 10 && $numdero <= 19)
{
switch ($numdero){
case 10:
{
$numd = "DIEZ ";
break;
}
case 11:
{
$numd = "ONCE ";
break;
}
case 12:
{
$numd = "DOCE ";
break;
}
case 13:
{
$numd = "TRECE ";
break;
}
case 14:
{
$numd = "CATORCE ";
break;
}
case 15:
{
$numd = "QUINCE ";
break;
}
case 16:
{
$numd = "DIECISEIS ";
break;
}
case 17:
{
$numd = "DIECISIETE ";
break;
}
case 18:
{
$numd = "DIECIOCHO ";
break;
}
case 19:
{
$numd = "DIECINUEVE ";
break;
}
}
}
else
$numd = unidad($numdero);
return $numd;
}

function centena($numc){
if ($numc >= 100)
{
if ($numc >= 900 && $numc <= 999)
{
$numce = "NOVECIENTOS ";
if ($numc > 900)
$numce = $numce.(decena($numc - 900));
}
else if ($numc >= 800 && $numc <= 899)
{
$numce = "OCHOCIENTOS ";
if ($numc > 800)
$numce = $numce.(decena($numc - 800));
}
else if ($numc >= 700 && $numc <= 799)
{
$numce = "SETECIENTOS ";
if ($numc > 700)
$numce = $numce.(decena($numc - 700));
}
else if ($numc >= 600 && $numc <= 699)
{
$numce = "SEISCIENTOS ";
if ($numc > 600)
$numce = $numce.(decena($numc - 600));
}
else if ($numc >= 500 && $numc <= 599)
{
$numce = "QUINIENTOS ";
if ($numc > 500)
$numce = $numce.(decena($numc - 500));
}
else if ($numc >= 400 && $numc <= 499)
{
$numce = "CUATROCIENTOS ";
if ($numc > 400)
$numce = $numce.(decena($numc - 400));
}
else if ($numc >= 300 && $numc <= 399)
{
$numce = "TRESCIENTOS ";
if ($numc > 300)
$numce = $numce.(decena($numc - 300));
}
else if ($numc >= 200 && $numc <= 299)
{
$numce = "DOSCIENTOS ";
if ($numc > 200)
$numce = $numce.(decena($numc - 200));
}
else if ($numc >= 100 && $numc <= 199)
{
if ($numc == 100)
$numce = "CIEN ";
else
$numce = "CIENTO ".(decena($numc - 100));
}
}
else
$numce = decena($numc);

return $numce;
}

function miles($nummero){
if ($nummero >= 1000 && $nummero < 2000){
$numm = "MIL ".(centena($nummero%1000));
}
if ($nummero >= 2000 && $nummero <10000){
$numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
}
if ($nummero < 1000)
$numm = centena($nummero);

return $numm;
}

function decmiles($numdmero){
if ($numdmero == 10000)
$numde = "DIEZ MIL";
if ($numdmero > 10000 && $numdmero <20000){
$numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
}
if ($numdmero >= 20000 && $numdmero <100000){
$numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));
}
if ($numdmero < 10000)
$numde = miles($numdmero);

return $numde;
}

function cienmiles($numcmero){
if ($numcmero == 100000)
$num_letracm = "CIEN MIL";
if ($numcmero >= 100000 && $numcmero <1000000){
$num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));
}
if ($numcmero < 100000)
$num_letracm = decmiles($numcmero);
return $num_letracm;
}

function millon($nummiero){
if ($nummiero >= 1000000 && $nummiero <2000000){
$num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
}
if ($nummiero >= 2000000 && $nummiero <10000000){
$num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
}
if ($nummiero < 1000000)
$num_letramm = cienmiles($nummiero);

return $num_letramm;
}

function decmillon($numerodm){
if ($numerodm == 10000000)
$num_letradmm = "DIEZ MILLONES";
if ($numerodm > 10000000 && $numerodm <20000000){
$num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
}
if ($numerodm >= 20000000 && $numerodm <100000000){
$num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));
}
if ($numerodm < 10000000)
$num_letradmm = millon($numerodm);

return $num_letradmm;
}

function cienmillon($numcmeros){
if ($numcmeros == 100000000)
$num_letracms = "CIEN MILLONES";
if ($numcmeros >= 100000000 && $numcmeros <1000000000){
$num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));
}
if ($numcmeros < 100000000)
$num_letracms = decmillon($numcmeros);
return $num_letracms;
}

function milmillon($nummierod){
if ($nummierod >= 1000000000 && $nummierod <2000000000){
$num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod >= 2000000000 && $nummierod <10000000000){
$num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod < 1000000000)
$num_letrammd = cienmillon($nummierod);

return $num_letrammd;
}


function convertir($numero){
$numf = milmillon($numero);
return $numf;
}
///************Termina conversion de numeros a letras



function num2letras($num, $fem = false, $dec = true, $mon = 1) { 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 
   
   //Zi hack
   $float=explode('.',$num);
   $num=$float[0];

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' una' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'una'; 
         $subcent = 'as'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   //Zi hack --> return ucfirst($tex);
   
   $textmon="DLLS";
   if ($mon==1)
		$textmon="DLLS";
	else
		$textmon="PESOS";
		
    if ($float["1"]==0)
		$end_num=ucfirst($tex).' '.$textmon.' '.$float[1]. '';
    else
		$end_num=ucfirst($tex).' '.$textmon.' con '.$float[1].' centavos';
	
   //$end_num=ucfirst($tex).' '.$float[1].'Centavos';
//   $end_num=ucfirst($tex).' '.$float[1].'Centavos';
   return $end_num; 
} 
?>
