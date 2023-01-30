<?php

    function esBisiesto($year=NULL) {
        $year = ($year==NULL)? date('Y'):$year;
        return ( ($year%4 == 0 && $year%100 != 0) || $year%400 == 0 );
    }

	function suma_meses($fecha,$nmeses)
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            list($dia,$mes,$año)=split("/", $fecha);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            list($dia,$mes,$año)=split("-",$fecha);
		$nuevomes=0;	
		$nuevomes=$mes+$nmeses;
		if ($nuevomes>12 && $nuevomes<24) {$nuevomes=$nuevomes-12; $año=$año+1;}
		if ($nuevomes>24 && $nuevomes<36) {$nuevomes=$nuevomes-24; $año=$año+2;}
		if ($nuevomes>36 && $nuevomes<48) {$nuevomes=$nuevomes-36; $año=$año+3;}
		if ($nuevomes>48 && $nuevomes<60) {$nuevomes=$nuevomes-48; $año=$año+4;}
		
		echo "Mes: ".$nuevomes."<BR>";
		echo "Año: ".$año."<BR>";
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
		echo "Dia: ".$dia."<BR>";
        //$nueva = mktime(0,0,0, $mes+$nmeses,$dia,$a?o);
		$nueva = mktime(0,0,0, $mes+$nmeses,$dia);
		$nuevafecha=date("d-m-Y",$nueva);
            
      return ($nuevafecha);  
}


	if (esBisiesto(12))
	{
		echo "Es bisiesto...<BR>";
	}
	echo "Fecha 30/10/2012    Nueva fecha: ".suma_meses("30/10/2012",4)." Se incrementaron 4 meses <BR>";
	echo "Fecha 30/10/2012    Nueva fecha: ".suma_meses("30/10/2012",16)." Se incrementaron 16 meses <BR>";
	echo "Fecha 30/10/2012    Nueva fecha: ".suma_meses("30/10/2012",28)." Se incrementaron 28 meses <BR>";
	echo "Fecha 30/10/2012    Nueva fecha: ".suma_meses("30/10/2012",29)." Se incrementaron 29 meses <BR>";
	echo "Fecha 30/10/2012    Nueva fecha: ".suma_meses("30/10/2012",40)." Se incrementaron 40 meses <BR>";

?>	