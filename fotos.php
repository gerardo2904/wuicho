<?php require_once('Connections/contratos_londres.php'); ?>
<?php require_once('Funciones/funciones.php'); ?>

<?php
$recordID=$_GET['carro'];

$conexion = $database_contratos_londres;
$linkbd = $contratos_londres;
$au=$recordID;

funciones_reemplazadas();

$maxRows_fotos = 50;
$pageNum_fotos = 0;
if (isset($_GET['pageNum_fotos'])) {
  $pageNum_fotos = $_GET['pageNum_fotos'];
}
$startRow_fotos = $pageNum_fotos * $maxRows_fotos;

mysqli_select_db($linkbd, $conexion);
$query_fotos = "SELECT * FROM fotos where clave_inv='$recordID'";
$query_limit_fotos = sprintf("%s LIMIT %d, %d", $query_fotos, $startRow_fotos, $maxRows_fotos);
$fotos = mysqli_query($contratos_londres, $query_limit_fotos) or die(mysql_error());
$row_fotos = mysqli_fetch_assoc($fotos);

if (isset($_GET['totalRows_fotos'])) {
  $totalRows_fotos = $_GET['totalRows_fotos'];
} else {
  $all_fotos = mysqli_query($contratos_londres, $query_fotos);
  $totalRows_fotos = mysqli_num_rows($all_fotos);
}
$totalPages_fotos = ceil($totalRows_fotos/$maxRows_fotos)-1;

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_numfotos = "SELECT count(*) as fotos FROM fotos WHERE clave_inv='$recordID'";
$numfotos = mysqli_query($contratos_londres, $query_numfotos) or die(mysql_error());
$row_numfotos = mysqli_fetch_assoc($numfotos);
$totalRows_numfotos = mysqli_num_rows($numfotos);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_especificaciones1 = "select marca.marca, tipo_auto.modelo, inventario_auto.ano,  inventario_auto.km,  inventario_auto.motor,  inventario_auto.puertas,  inventario_auto.especificaciones, empresa.nombre_empresa from fotos, marca, tipo_auto, inventario_auto, empresa  WHERE fotos.clave_inv='$recordID' AND fotos.clave_inv=inventario_auto.clave_inv AND inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca AND empresa.clave_empresa=inventario_auto.clave_empresa";
$especificaciones1 = mysqli_query($contratos_londres, $query_especificaciones1) or die(mysql_error());
$row_especificaciones1 = mysqli_fetch_assoc($especificaciones1);
$totalRows_especificaciones1 = mysqli_num_rows($especificaciones1);

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_especificaciones2 = "SELECT marca.marca, tipo_auto.modelo, inventario_auto.ano,  inventario_auto.km,  inventario_auto.motor,  inventario_auto.puertas,  inventario_auto.especificaciones, empresa.nombre_empresa FROM  marca, tipo_auto, inventario_auto, empresa WHERE inventario_auto.clave_inv='$recordID' AND  inventario_auto.clave_auto=tipo_auto.clave_auto AND tipo_auto.clave_marca=marca.clave_marca AND empresa.clave_empresa=inventario_auto.clave_empresa";
$especificaciones2 = mysqli_query($contratos_londres, $query_especificaciones2) or die(mysql_error());
$row_especificaciones2 = mysqli_fetch_assoc($especificaciones2);
$totalRows_especificaciones2 = mysqli_num_rows($especificaciones2);

/*
$link = mysqli_connect('localhost', 'alondres', 'atomicstatus');
if (!$link) die('Error al conectarse con MySQL: ' . mysql_error().' <br>Número del error: '.mysql_errno());
if (! @mysqli_select_db("contratos_londres",$link)){
  echo "No se pudo conectar correctamente con la Base de datos";
  exit();
}
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>Entertainment - Calendar</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<script type="text/javascript" src="lightbox.js"></script>

<script type="text/javascript">
function loadImg(img){
var imgName = "big4"; // name of the big image
var srcs = ["<?php echo $row_fotos['foto']; ?>","<?php echo $row_fotos['foto']; ?>"]; // array of SRC's for the big images
//var srcs = [$imagen];

document.images[imgName].src=srcs[img];
}
</script>
<style type="text/css">
<!--
#apDiv4 {
	position:absolute;
	left:443px;
	top:8px;
	width:246px;
	height:142px;
	z-index:2;
}
#apDiv5 {
	position:absolute;
	left:302px;
	top:21px;
	width:429px;
	height:107px;
	z-index:3;
}
-->
</style>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 10px}
.style2 {font-weight: bold}
.style3 {font-weight: bold}
.style4 {font-weight: bold}
.style5 {color: #FFFF00}
-->
</style>
</head>
<body>
<div id='cssmenu'>
  <?php 
  //Inserta el Menu
  require_once('menu.php'); ?>
</div>

<div id="apDiv3">
  <p style="margin-top: 0;"><span class="style2"><?php echo $row_especificaciones2['marca']; ?> <?php echo $row_especificaciones2['modelo']; ?> <?php echo $row_especificaciones2['ano']; ?></span>
    <?php
/*
Script de carga de archivos en el servidor.
Es importante que la directiva upload_max_filesize_size del fichero php.ini est┌ puesta
al valor adecuado.

Por ejemplo, si est▀ a 4M, cualquier fichero mayor que 4 megabytes, devolver▀ un error.

Asimismo, la directiva file_uploads debe estar a On para poder hacer upload (carga) de ficheros

Mete el fichero cargado dentro del directorio /uploads, que est▀ en la carpeta del script.
*/

if(!isset($HTTP_GET_VARS["upload"])){
	if(isset($HTTP_GET_VARS["borrar"])){
	
		$updateSQL = sprintf("UPDATE inventario_auto SET fotos=0 WHERE clave_inv='$recordID'");
		mysqli_select_db($contratos_londres, $database_contratos_londres);
  		$Result1 = mysqli_query($updateSQL, $contratos_londres) or die(mysql_error());
		
		borra_foto($recordID,$conexion,$linkbd);
		
		$updateSQL = sprintf("DELETE from fotos WHERE clave_inv='$recordID'");
		mysqli_select_db($contratos_londres, $database_contratos_londres);
  		$Result1 = mysqli_query($updateSQL, $contratos_londres) or die(mysql_error());

		//borra_foto($recordID,$conexion,$linkbd);

		 $updateGoTo = "fotos.php?carro=".$recordID;
         //$updateGoTo="javascript;";
		 Echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";
	}


?>
  </p>
  <form method="post" action="fotos.php?upload=1" enctype="multipart/form-data">
    <table width="304" border="1">
      <tr>
        <th width="294" bgcolor="#000099" scope="col"><span class="style17 style1 style5">Subir Fotos</span></th>
      </tr>
      <tr>
        <td><p class="style3 style1">
            <input name="portada" type="checkbox" id="portada" value="1" />
          ¿Portada?</p>
            <div align="justify" class="style3">
              <p><span class="style1">Archivo:
              
              </span>
                  <input name="fotosx" type="hidden" id="fotosx" value="<?php echo $row_numfotos['fotos']; ?>" />
                  <input name="carrito" type="hidden" id="carrito" value="<?php echo $recordID; ?>" />
              <span class="style1">
              <input name="archivo" type="file" class="style1" id="archivo" />
              </span></p>
              <p><span class="style1">Comentario:
                </span>
                <textarea name="comentario" cols="45" rows="5" class="style1" id="comentario"></textarea>
              </p>
            </div></td>
      </tr>
      <tr>
        <td><div align="justify">
            <input type="submit" class="style1" value="Procesar Archivo" />
        </div></td>
      </tr>
    </table>
    <br />
    <br />
  </form>
  <span class="style2"><a href="inventario_list.php">Regresar...</a>
  <?php
}
else {
$dir="d:/appserv/www/autoslondres.com.mx/contratos_londres/archivos/";
$ruta="archivos/";
$userfile = $archivo_name;
$parametro3 =$dir.$userfile;
$campo= $ruta.$userfile;
$com=$comentario;
$llave=$carrito;
$port=$portada;
$numerofotos=$fotosx;
$recordID=$llave;

if (is_null($portada)) {$portada=0;}
if (strlen($com)==0) {$com=" ";}
/*
echo "carrito:".$carrito."<BR>";
echo "recordID: ".$recordID."<BR>";
echo "parametro3:".$parametro3."<BR>";
echo "port: ".$port."<BR>";

echo "campo: ".$campo."<BR>";
echo "com: ".$com."<BR>";
echo "llave: ".$llave."<BR>";
echo "portada: ".$portada."<BR>";
*/

if(copy($archivo, $dir.$userfile)) {

	//echo "Copiado";
	//exit;
	mysqli_select_db($contratos_londres, $database_contratos_londres);
	if ($port==1) { 
	$result = mysqli_query("UPDATE fotos set portada=0 where clave_inv='$llave'");
	}

	//   $result = mysql_query("INSERT INTO fotos (foto,comentario,clave_inv,portada) VALUES('$campo','$com','$llave','$portada')") or die(mysql_error());

	$insertSQL = sprintf("INSERT INTO fotos (foto, comentario, clave_inv, portada) VALUES (%s , %s, %s, %s)",
                       GetSQLValueString($campo, "text"),
                       GetSQLValueString($com, "text"),					   
					   GetSQLValueString($llave, "text"),
					   GetSQLValueString($portada, "text"));	
//	echo $insertSQL;
	mysqli_select_db($contratos_londres, $database_contratos_londres);
	$Result1 = mysqli_query($insertSQL, $contratos_londres) or die(mysql_error());   
   
	$numerofotos=$numerofotos+1;
	$result = mysqli_query("UPDATE inventario_auto set fotos='$numerofotos' where clave_inv='$llave'");
   
	$updateGoTo = "fotos.php?carro=".$carrito;
	//  header(sprintf("Location: %s", $updateGoTo)); 
	Echo "<SCRIPT language=\"JavaScript\">
<!--
window.location=\"$updateGoTo\";
//-->
</SCRIPT>";

        }
else{
   echo "Error al tratar de subir archivo...";
    }
}

?>
&nbsp;  </span>
  <p></p>
  <strong><a href="fotos.php?borrar=1&amp;carro=<?php echo "$recordID"; ?>">Borrar todas las fotos de este auto</a></strong><br />
</div>
<div id="apDiv4">
  <table border="0" cellpadding="0" cellspacing="0" class="style1">
    <?php do { ?>
    <tr>
      <td><p class="style4"><a target="_blank" href="<?php echo $row_fotos['foto']; ?>" rel="lightbox"><img src="<?php echo $row_fotos['foto']; ?>" alt="" name="imagen" width="100" border="0" align="texttop" id="imagen" /></a></p>
          <p class="style1"> <?php echo $row_fotos['comentario']; ?></p></td>
    </tr>
    <?php } while ($row_fotos = mysqli_fetch_assoc($fotos)); ?>
  </table>
</div>

</body>
</html>
<?php
mysqli_free_result($fotos);

mysqli_free_result($numfotos);

mysqli_free_result($especificaciones1);

mysqli_free_result($especificaciones2);
?>
