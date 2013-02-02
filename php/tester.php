<?php
include("Database.class.php");

$a = Database::connect();
$b = Database::mysql_table_exists("nodes");
echo $a.' '.$b;
?>
