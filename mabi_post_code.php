<?php
require_once('mabi_connect.php');

if (isset($_REQUEST['item_txt_all'])) {
	$item_txt_all = $_REQUEST['item_txt_all'];
}
else {
	echo "!!!!";
	exit;
}

$success_count=0;
$line_arr = explode(";",$item_txt_all);
foreach ($line_arr as $line) {
	if (trim($line)=="") continue;
    $txt_arr = explode("|",$line);
	$event_name=trim($txt_arr[0]);
	$item_name=trim($txt_arr[1]);
	$code=trim($txt_arr[2]);
	
	$SQL_code_used = "INSERT INTO sn_share (serial_number, event_name, item_name) VALUES (:code, :event_name, :item_name)";
	$PRE_code_used = $db->prepare($SQL_code_used, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$PRE_code_used->execute(array(':code' => $code, ':event_name' => $event_name, ':item_name' => $item_name));
	
	$success_count += $PRE_code_used->rowCount();
}

echo "成功添加序號共".$success_count."條<br/>";
require_once('mabi_post.php');
?>