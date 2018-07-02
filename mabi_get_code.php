<?php
$hostname = 'localhost';
$username = 'mabi_sn_share_ptrs';
$password = 'mabi_sn_share_pass';
$db_name="mabi";


$db=new PDO("mysql:host=".$hostname.";
			dbname=".$db_name, $username, $password,
			array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$db->query("SET NAMES utf8");

if (isset($_REQUEST['item_name']) && isset($_REQUEST['event_name'])) {
	$item_name = $_REQUEST['item_name'];
	$event_name = $_REQUEST['event_name'];
}
else {
	echo "!!!!";
	exit;
}

$SQL_code = "SELECT serial_number, min(sn_id) as snid FROM sn_share WHERE event_name=:event_name AND item_name=:item_name AND used=0";
$PRE_code = $db->prepare($SQL_code, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$PRE_code->execute(array(':event_name' => $event_name, ':item_name' => $item_name));
$DAT_code = $PRE_code->fetch();


if ($DAT_code && isset($DAT_code['serial_number'])){
	$SQL_code_used = "UPDATE sn_share SET used=1 WHERE sn_id=:sn_id";
	$PRE_code_used = $db->prepare($SQL_code_used, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$PRE_code_used->execute(array(':sn_id' => $DAT_code['snid']));
	echo $DAT_code['serial_number'];
}
else echo "!!!!";
?>