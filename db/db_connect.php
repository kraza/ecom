<?php

$host_name = 'localhost';
$user_name = 'rajan';
$password = 'panthers';

$db = mysql_connect($host_name,$user_name,$password);
if (!$db) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("rajan");
session_start();
?>
