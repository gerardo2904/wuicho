<?php
//Conexion a MySQL, ya incluye la clase para conectarse a la B.D.
include("Connections/contratos_londres_poo.php"); 

//Clase del menu
include("classes/menu.class.php"); 

////////////////////////

// Ya hemos creado una instancia para base de datos llamada bd.  esto en el archivo contratos_londres_poo.php
$db->Query("select * from menu ") ;

//Obtenemos el numero de registros
$renglones=$db->RowCount();

//Matriz que contendra los datos del menu
$aregistros = array();

//Iniciamos en 0 el numero de elementos del menu
$i=0;

 while ($row = $db->Row()) {
	$i++;
	//Obtenemos el contenido del registro actual
	//$row = $db->Row();
	$aregistros[] = array($i,iconv("windows-1252", "UTF-8",$row->opcion),$row->id_padre,$row->link);
	
}

// Liberamos la base de datos para que no ocupe memoria
$db->Release();

$mnu = new menubuillder($aregistros);
$mnu->makemenu();
print_r($mnu->html);

?>



