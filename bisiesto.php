<?php

    function esBisiesto($year=NULL) {
        $year = ($year==NULL)? date('Y'):$year;
        return ( ($year%4 == 0 && $year%100 != 0) || $year%400 == 0 );
    }

	function suma_meses($fecha,$nmeses)
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            list($dia,$mes,$a�o)=split("/", $fecha);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            list($dia,$mes,$a�o)=split("-",$fecha);
		$nuevomes=0;	
		$nuevomes=$mes+$nmeses;
		if ($nuevomes>12 && $nuevomes<24) {$nuevomes=$nuevomes-12; $a�o=$a�o+1;}
		if ($nuevomes>24 && $nuevomes<36) {$nuevomes=$nuevomes-24; $a�o=$a�o+2;}
		if ($nuevomes>36 && $nuevomes<48) {$nuevomes=$nuevomes-36; $a�o=$a�o+3;}
		if ($nuevomes>48 && $nuevomes<60) {$nuevomes=$nuevomes-48; $a�o=$a�o+4;}
		
		echo "Mes: ".$nuevomes."<BR>";
		echo "A�o: ".$a�o."<BR>";
		if ($nuevomes==2)
			{
				
				$ultimodia=0;
				if (esBisiesto($a�o))
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