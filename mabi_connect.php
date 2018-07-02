<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db_name="mabi";

$db=new PDO("mysql:host=".$hostname.";
			dbname=".$db_name, $username, $password,
			array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$db->query("SET NAMES utf8");
?>