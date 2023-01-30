<?php
require("./classes/mysql.class.php");

$db = new MySQL();
$db2 = new MySQL();

$usuario="root";
$contra="atomicstatus";

if (! $db->Open("wuicho", "db:3306", $usuario, $contra)) {
    $db->Kill();
}

if (! $db2->Open("wuicho", "db:3306", $usuario, $contra)) {
    $db2->Kill();
}

//echo "You are connected to the database<br />\n";

?>
