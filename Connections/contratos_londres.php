<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_contratos_londres = "db:3306";
$database_contratos_londres = "wuicho";
$username_contratos_londres = "root";
$password_contratos_londres = "atomicstatus";
$contratos_londres = mysqli_connect($hostname_contratos_londres, $username_contratos_londres, $password_contratos_londres,$database_contratos_londres) or trigger_error(mysql_error(),E_USER_ERROR); 





?>