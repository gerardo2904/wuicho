<?php

    function esBisiesto($year=NULL) {
        $year = ($year==NULL)? date('Y'):$year;
        return ( ($year%4 == 0 && $year%100 != 0) || $year%400 == 0 );
    }

	
	function suma_meses($fecha,$nmeses)
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            list($dia,$mes,$a?o)=split("/", $fecha);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            list($dia,$mes,$a?o)=split("-",$fecha);

		$nuevomes=0;	
		$nuevomes=$mes+$nmeses;
		$a?ooriginal=$a?o;
		if ($nuevomes>12 && $nuevomes<24) {$nuevomes=$nuevomes-12; $a?o=$a?o+1;}
		if ($nuevomes>24 && $nuevomes<36) {$nuevomes=$nuevomes-24; $a?o=$a?o+2;}
		if ($nuevomes>36 && $nuevomes<48) {$nuevomes=$nuevomes-36; $a?o=$a?o+3;}
		if ($nuevomes>48 && $nuevomes<60) {$nuevomes=$nuevomes-48; $a?o=$a?o+4;}
		

		if ($nuevomes==2)
			{
				
				$ultimodia=0;
				if (esBisiesto($a?o))
				{
					$ultimodia=29;
				}
				else {
					$ultimodia=28;
				}
			if ($dia>$ultimodia)
				$dia=$ultimodia;
			}

		$nueva = mktime(0,0,0, $mes+$nmeses,$dia,$a?ooriginal);
		$nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
}


$fecha_del_primerpago="30-01-2013";
$numero_pagares=60;
for ($i=1;$i<=$numero_pagares;$i++) {
				$rec=suma_meses($fecha_del_primerpago, 1*($i-1));
				$dia=substr($rec,0,2);
				$mes=substr($rec,3,2);
				$ano=substr($rec,6,4);
				$fechaVence=$ano."-".$mes."-".$dia;
				
				echo "fechavence: ".$fechaVence."<BR>";
}
				
?>
