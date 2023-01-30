<?php
include ( Funciones. '/numerosALetras.class.php' ) ; 
 $n = new numerosALetras ( 300) ;
 echo $n -> resultado."<BR>" ; 
echo $n -> convertir ( 3.1416 )."<BR>" ; 
echo $n -> convertir ( 254.34 )."<BR>" ; 
echo $n -> convertir ( 300 )."<BR>" ; 
echo $n -> convertir ( 100 )."<BR>" ; 
echo $n -> convertir ( 100.45 )."<BR>" ; 
?>
