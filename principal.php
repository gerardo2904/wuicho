<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/menu_assets/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:200px;
	top:203px;
	width:246px;
	height:254px;
	z-index:1;
}
-->
</style>
</head>

<body>
<div id='cssmenu'>
  <?php 
  //Inserta el Menu
  require_once('menu.php'); ?>
</div>

<div id="apDiv1"><img src="Imagenes/jedda-logo.jpeg" width="500" height="256" /></div>
</body>
</html>
