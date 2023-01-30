<?php

$diametro=1.27;
$altura_liquido=1.27;
$longitud=3;
$pi=PI();

$V=PI()*((($diametro/2)*10)*(($diametro/2)*10))*($altura_liquido*10);
//echo "Diametro: ".(($radio)^2))."<BR>";
echo "diametro :".$diametro."<BR>";
echo "altura_liquido :".$altura_liquido."<BR>";
echo "PI: ".$pi."<BR><BR>";


echo "radio al cuadrado en decimentros:".((($diametro/2)*10)*(($diametro/2)*10))."<BR>";
echo "($altura_liquido*10) :".($altura_liquido*10)."<BR>";
echo "PI()*((($diametro/2)*10)^2)*($altura_liquido*10) :".$V."<BR>";
echo "<BR><BR>";
echo "prisma rectangular.<BR><BR>";


$V2=($diametro*10)*($longitud*10)*($altura_liquido*10);

echo "Longitud: ".$longitud."<BR>";
echo "Ancho:    ".$diametro."<BR>";
echo "Altura:   ".$altura_liquido."<BR>";
echo "Volumen prisma: ".$V2;






?>