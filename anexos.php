<?php require_once('Connections/contratos_londres.php'); 

if (!isset($_SESSION)) {
  session_start();
}

$MM_authorizedUsers = "2,1";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "conectar_empresa.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

?>

<?php

$recordID=$_GET['parametro1'];   // clave_contrato
$recordID0=$_GET['parametro2'];  // clave_empresa
$recordID1=$_GET['parametro3'];  // clave_cliente

//echo "parametro1= ".$recordID;
//echo "parametro2= ".$recordID0;
//echo "parametro3= ".$recordID1;




 if ($_POST["Imprimir"]) {
  $updateGoTo = "imp_anexos.php?parametro1=".$recordID."&parametro2=".$recordID0."&parametro3=".$recordID1."&autorizacion=".$_POST["autorizacion"]."&moneda=".$_POST["moneda"]."&bomba=".$_POST["bomba"]."&pedido=".$_POST["pedido"]."&apertura=".$_POST["apertura"]."&costo_apertura=".$_POST["costo_apertura"]."&placas=".$_POST["placas"]."&calendario=".$_POST["calendario"]."&vendedor=".$_POST["vendedor"]."&doc_contratos=".$_POST["doc_contratos"]."&doc_pagares=".$_POST["doc_pagares"]."&doc_solcredcliente=".$_POST["doc_solcredcliente"]."&doc_solcredaval=".$_POST["doc_solcredaval"]."&doc_identiclientes=".$_POST["doc_identiclientes"]."&doc_identiaval=".$_POST["doc_identiaval"]."&doc_comprodomicilio=".$_POST["doc_comprodomicilio"]."&doc_predial=".$_POST["doc_predial"]."&ventas=".$_POST["ventas"]."&puntualidad=".$_POST["puntualidad"]."&bono_puntualidad=".$_POST["bono_puntualidad"]."&cobranza_tardia=".$_POST["cobranza_tardia"]."&doc_observaciones=".$_POST["doc_observaciones"]."&domicilio_lote=".$_POST["domicilio_lote"];
  echo "<SCRIPT language=\"JavaScript\">
		 <!--	
		window.location=\"$updateGoTo\";
		//-->
		</SCRIPT>";
}

 if ($_POST["Cancelar"]) {
  $updateGoTo = "contrato.php?parametro1=".$recordID;
  echo "<SCRIPT language=\"JavaScript\">
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
<title>Documento sin título</title>
<link href="cuscosky.css" rel="stylesheet" type="text/css" />
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.texto_tabla {
	color: #000;
	font-size: 10px;
}
encabezado_texto_tabla {
	color: #FF0;
}
.texto_tabla tr td .texto_tabla {
	color: #FF0;
	font-size: 12px;
}
.texto_tabla tr .texto_tabla div {
	font-size: 12px;
}
.encabezado_tabla {
	font-size: 10px;
	font-weight: bold;
	color: #FF0;
}
.style6 {	color:#000000;
	font-weight:bold;
	font-size:10px;
}
#form1 .texto_tabla tr .texto_tabla {
	text-align: left;
}
.texto_tabla1 {	color: #000;
	font-size: 10px;
}
</style></head>

<body>
<div id='cssmenu'>
  <?php 
  //Inserta el Menu
  require_once('menu.php'); ?>
</div>
<p><strong>Anexos</strong></p>
<form id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>">
  <table width="981" height="349" border="1" class="texto_tabla">
    <tr>
      <td align="center" bgcolor="#000033" class="encabezado_tabla">Anexo</td>
      <td align="center" bgcolor="#000033" class="encabezado_tabla">&nbsp;</td>
      <td colspan="16" align="center" bgcolor="#000033" class="encabezado_tabla">Parametros</td>
    </tr>
    <tr>
      <td width="105" class="texto_tabla">Autorización del Cliente para Investigación</td>
      <td width="26" class="texto_tabla"><div align="left">
        <input name="autorizacion" type="checkbox" id="autorizacion" value="1" checked="checked" />
      </div></td>
      <td colspan="16" class="texto_tabla"><div align="left">
        <label for="autorizacion"></label>
      </div></td>
    </tr>
    <tr>
      <td class="texto_tabla">Moneda del Contrato</td>
      <td class="texto_tabla"><div align="left">
        <input name="moneda" type="checkbox" id="moneda" value="1" checked="checked" />
      </div></td>
      <td colspan="16" class="texto_tabla"><div align="left">
        <label for="moneda"></label>
      </div></td>
    </tr>
    <tr>
      <td class="texto_tabla">Bomba de Gasolina y Catalizadores</td>
      <td class="texto_tabla"><div align="left">
        <input name="bomba" type="checkbox" id="bomba" value="1" checked="checked" />
      </div></td>
      <td colspan="16" class="texto_tabla"><div align="left">
        <label for="bomba"></label>
      </div></td>
    </tr>
    <tr>
      <td class="texto_tabla">Pedido</td>
      <td class="texto_tabla"><div align="left">
        <input name="pedido" type="checkbox" id="pedido" value="1" checked="checked" />
      </div></td>
      <td colspan="16" class="texto_tabla"><div align="left">
        <label for="pedido"></label>
      </div></td>
    </tr>
    <tr>
      <td class="texto_tabla">Apertura de Crédito</td>
      <td class="texto_tabla"><div align="left">
        <input name="apertura" type="checkbox" id="apertura" value="1" checked="checked" />
      </div></td>
      <td colspan="16" class="texto_tabla"><div align="left">
        <label for="apertura"></label>
        <span class="texto_tabla1">Costo Apertura Crédito: </span><span class="texto_tabla1">
          <input name="costo_apertura" type="text" class="texto_tabla1" id="costo_apertura" size="20" />
        </span></div>        <label for="costo_apertura"></label></td>
    </tr>
    <tr>
      <td class="texto_tabla">Tramite de Placas</td>
      <td class="texto_tabla"><div align="left">
        <input name="placas" type="checkbox" id="placas" value="1" checked="checked" />
      </div></td>
      <td colspan="16" class="texto_tabla"><div align="left">
        <label for="placas"></label>
      </div></td>
    </tr>
    <tr>
      <td class="texto_tabla">Calendario de Pagos</td>
      <td class="texto_tabla"><div align="left">
        <input name="calendario" type="checkbox" id="calendario" value="1" checked="checked" />
      </div></td>
      <td colspan="16" class="texto_tabla"><div align="left">
        <label for="calendario"></label>
      </div></td>
    </tr>
    <tr>
      <td rowspan="3" class="texto_tabla">Reporte del Vendedor</td>
      <td rowspan="3" class="texto_tabla"><div align="left">
        <input name="vendedor" type="checkbox" id="vendedor" value="1" checked="checked" />
      </div></td>
      <td colspan="16" class="texto_tabla">Documentación que se envía</td>
    </tr>
    <tr>
      <td width="49" class="texto_tabla">Contratos</td>
      <td width="28" class="texto_tabla"><input name="doc_contratos" type="checkbox" id="doc_contratos" value="1" checked="checked" />
      <label for="doc_contratos"></label></td>
      <td width="43" class="texto_tabla">Pagares</td>
      <td width="28" class="texto_tabla"><span class="texto_tabla1">
        <input name="doc_pagares" type="checkbox" id="doc_pagares" value="1" checked="checked" />
      </span></td>
      <td width="45" class="texto_tabla">Sol. Credito Cliente</td>
      <td width="28" class="texto_tabla"><span class="texto_tabla1">
        <input name="doc_solcredcliente" type="checkbox" id="doc_solcredcliente" value="1" checked="checked" />
      </span></td>
      <td width="45" class="texto_tabla">Sol. Credito Aval</td>
      <td width="28" class="texto_tabla"><span class="texto_tabla1">
        <input name="doc_solcredaval" type="checkbox" id="doc_solcredaval" value="1" checked="checked" />
      </span></td>
      <td width="81" class="texto_tabla">Identificaciones Cliente</td>
      <td width="28" class="texto_tabla"><span class="texto_tabla1">
        <input name="doc_identiclientes" type="checkbox" id="doc_identiclientes" value="1" checked="checked" />
      </span></td>
      <td width="81" class="texto_tabla">Identificaciones Aval</td>
      <td width="28" class="texto_tabla"><span class="texto_tabla1">
        <input name="doc_identiaval" type="checkbox" id="doc_identiaval" value="1" checked="checked" />
      </span></td>
      <td width="75" class="texto_tabla">Comprobantes Domicilio</td>
      <td width="28" class="texto_tabla"><span class="texto_tabla1">
        <input name="doc_comprodomicilio" type="checkbox" id="doc_comprodomicilio" value="1" checked="checked" />
      </span></td>
      <td width="59" class="texto_tabla">Predial Actualizado</td>
      <td width="64" class="texto_tabla"><span class="texto_tabla1">
        <input name="doc_predial" type="checkbox" id="doc_predial" value="1" checked="checked" />
      </span></td>
    </tr>
    <tr>
      <td colspan="16" class="texto_tabla">Observaciones: 
        <label for="doc_observaciones"></label>
      <input name="doc_observaciones" type="text" class="texto_tabla1" id="doc_observaciones" size="130" /></td>
    </tr>
    <tr>
      <td class="texto_tabla">Reporte de Ventas</td>
      <td class="texto_tabla"><div align="left">
        <input name="ventas" type="checkbox" id="ventas" value="1" checked="checked" />
      </div></td>
      <td colspan="16" class="texto_tabla"><div align="left">
        <label for="ventas"></label>
      </div></td>
    </tr>
    <tr>
      <td class="texto_tabla">Puntualidad o Cobranza Tardia</td>
      <td class="texto_tabla"><div align="left">
        <input name="puntualidad" type="checkbox" id="puntualidad" value="1" checked="checked" />
      </div></td>
      <td colspan="16" class="texto_tabla"><div align="left" class="texto_tabla1">
        <label for="puntualidad"></label>
      Bono Puntualidad 
      <label for="bono_puntualidad2"></label>
      <input name="bono_puntualidad" type="text" class="texto_tabla1" id="bono_puntualidad2" size="20" />
      <label for="bono_puntualidad"></label>
      Cobranza Tardía 
      <label for="cobranza_tardia"></label>
      <input name="cobranza_tardia" type="text" class="texto_tabla1" id="cobranza_tardia" />
       Domicilio Lote 
       <input name="domicilio_lote" type="text" class="texto_tabla1" id="domicilio_lote" />
      </div></td>
    </tr>
  </table>
  <p>
    <input name="Imprimir" type="submit" class="style6" id="Imprimir" value="Imprimir" />
    <span class="style6">
    <input type="submit" name="Cancelar" id="Cancelar" value="Regresar al Contrato" class="style6"/>
  </span></p>
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>

