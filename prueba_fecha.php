<?php

$hostname_contratos_londres = "localhost";
$database_contratos_londres = "contratos_londres";
$username_contratos_londres = "alondres";
$password_contratos_londres = "atomicstatus";
$contratos_londres = mysqli_connect($hostname_contratos_londres, $username_contratos_londres, $password_contratos_londres,$database_contratos_londres) or trigger_error(mysql_error(),E_USER_ERROR); 

    function suma_fechas($fecha,$ndias)
            
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$año)=array_pad( explode( '/', $fecha ),3,'');
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
              list($dia,$mes,$año)=array_pad( explode( '-', $fecha ),3,'');
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

$x=suma_fechas("01-02-2010",5);
echo $x."<BR>";
echo nombre_fecha("01/02/2010")."<BR>";


$recordID=2;

$filtro="";
$filtro=" where clave_combo_pagare='$recordID'";
mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_contra = "select clave_combo_pagare,  clave_empresa, combo_pagare.clave_cliente, numero_pagares, 
DATE_FORMAT(fecha_pagare, '%d-%m-%Y') AS fecha_pagare, clientes.nombre_cliente, clientes.rfc_cliente,
clientes.domicilio_cliente, clientes.ciudad_cliente, clientes.estado_cliente, clientes.cp_cliente, clientes.tel_cliente, clientes.fax_cliente, 
clientes.email_cliente, monedas.moneda from combo_pagare, clientes, monedas  ".$filtro." AND combo_pagare.clave_cliente=clientes.clave_cliente AND combo_pagare.clave_moneda=monedas.clave_moneda ";
$contra = mysqli_query($contratos_londres, $query_contra) or die(mysqli_error($contratos_londres));
$row_contra = mysqli_fetch_assoc($contra);
$totalRows_contra = mysqli_num_rows($contra);

echo "fecha: ".$row_contra["fecha_pagare"];
echo nombre_fecha($row_contra["fecha_pagare"],1);

?>