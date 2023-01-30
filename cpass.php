<?php 
require_once('Connections/contratos_londres.php'); 
require_once('Funciones/funciones.php');


funciones_reemplazadas();

$recordID1=$_GET['parametro1'];	// Tipo de dato a borrar

mysqli_select_db($contratos_londres, $database_contratos_londres);
$query_verifica_usuario = "select * from usuarios WHERE clave_usuario=".$recordID1;
$verifica_usuario = mysqli_query($contratos_londres, $query_verifica_usuario) or die(mysqli_error($contratos_londres));
$row_verifica_usuario = mysqli_fetch_assoc($verifica_usuario);
$totalRows_verifica_usuario = mysqli_num_rows($verifica_usuario);
mysqli_free_result($verifica_usuario);

if ($_POST["Cambiar"]) {
		if ($_POST["pass1"]==$_POST["pass2"]) {
		//echo $_POST['pass1']."<BR>";
		//echo $_POST['pass2']."<BR>";
		//echo md5(trim($_POST['pass1']))."<BR>";exit;
		
	  		$updateSQL = sprintf("UPDATE usuarios SET pass_usuario=%s WHERE clave_usuario='$recordID1'",
            	           GetSQLValueString(md5(trim($_POST['pass1'])), "text"));
  			mysqli_select_db($contratos_londres, $database_contratos_londres);
  			$Result1 = mysqli_query($contratos_londres, $updateSQL) or die(mysqli_error($contratos_londres));
			
			// redirige a pagina de listado de contratos...
			$updateGoTo = "usuarios_edit.php?parametro1=".$recordID1;
			Echo "<SCRIPT language=\"JavaScript\">
			<!--	
			window.location=\"$updateGoTo\";
			//-->
			</SCRIPT>";	
		
		}
		else {
			echo "<script language='javascript'> alert('El Password nuevo es diferente a la confirmacion de mismo. Por favor intenta de nuevo.'); </script> ";
		}
}

if ($_POST["Cancelar"]) {
		// redirige a pagina de listado de contratos...
		$updateGoTo = "usuarios_edit.php?parametro1=".$recordID1;
		Echo "<SCRIPT language=\"JavaScript\">
		<!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>
<p>Cambiar contraseña para: <?php echo trim($row_verifica_usuario['nombre_usuario']); ?></p>
<form id="form1" name="form1" method="post" action="">
  Nueva Contraseña
  <label>
  <input type="password" name="pass1" id="pass1" />
  </label>
  <p>Repetir Nueva Contraseña 
    <input type="password" name="pass2" id="pass2" />
  </p>
  <p>
    <label>
    <input type="submit" name="Cambiar" id="Cambiar" value="Cambiar" />
    </label>
    <label>
    <input type="submit" name="Cancelar" id="Cancelar" value="Cancelar" />
    </label>
  </p>
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
</body>
</html>

<?php

//mysqli_free_result($verifica_usuario);
?>