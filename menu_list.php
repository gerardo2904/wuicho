<?php
//include("Connections/contratos_londres_poo.php"); 
//Cabecera de pagina HTML
include("cabecera.html");
?>


<?php

// Ya hemos creado una instancia para base de datos llamada bd.  esto en el archivo contratos_londres_poo.php
$db->Query("select * from menu where id_padre=0") ;

//Obtenemos el numero de registros
$renglones=$db->RowCount();
echo "Aqui, damos de alta y/o modificamos el menu principal. <BR><BR>";
echo "<p><a href='menu_edit.php'><strong>Agregar</strong></a></p>";
echo "<table>";
echo "<TR><td bgcolor='#000033' class='enc_tabla'><div align='center'>MENU</div></td></TR>";

 while ($row = $db->Row()) {
	echo "<TR><TD class='txt_tabla'>";
	echo "<A HREF='menu_edit.php?parametro1=".$row->id."'>".iconv("windows-1252", "UTF-8",$row->opcion)."	--> ".$row->link."<BR></A>";
	
	echo "</TD></TR>";
	$db2->Query("select * from menu where id_padre='$row->id'") ;
	while ($row2 = $db2->Row()) {
		echo "<TR><TD class='txt_tabla'>".$row2->opcion." -->	".$row2->link."</TD></TR>";
	}
	$db2->Release();
	
}
echo "</table>";
echo "<BR>";
echo "<BR>";
echo "El simbolo #, significa que el link esta vacio.";
echo "<BR>";
echo "<p><a href='menu_edit.php'><strong>Agregar</strong></a></p>";
// Liberamos la base de datos para que no ocupe memoria
$db->Release();

//Pie de pagina HTML
include("pie.html");
?>

