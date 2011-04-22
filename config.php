<?php

define("SITE_NAME","Netcoders");//
define("DESCRIZIONE","Blog di informatica");//
define("PREFIX","Blog_");
define("SERVER_NAME","www.netcoders.org");

//Dati per la connessione al Database MySQL
$db_host = "mysql.netsons.com";
$db_user = "netcoder_admin";
$db_pass = "lolloasd";
$db_name = "netcoder_db";

mysql_connect ($db_host, $db_user, $db_pass) or die (mysql_error());
mysql_select_db ($db_name) or die (mysql_error());

?>