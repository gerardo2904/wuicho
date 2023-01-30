<?php

echo "hola <BR>";
$fecha1="10-10-2011";
echo date('d-m-Y')."<BR>";

//echo date($fecha1,'d-m-Y')

//echo date('10','10','2011','d-m-Y');

$dia=substr($fecha1,0,2);
$mes=substr($fecha1,3,2);
$ano=substr($fecha1,6,4);
echo $dia."-".$mes."-".$ano."<BR>";
$fecha=mktime(0,0,0,$dia,$mes,$ano);

echo $fecha;
?>
