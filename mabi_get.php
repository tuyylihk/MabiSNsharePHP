<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>取得序號</title>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
function selectEvent() {
	$("#selected_div").css('visibility', 'hidden');
	$("#getCode_button").css('visibility', 'hidden');
	$("#copyCode_button").css('visibility', 'hidden');
	$("#code_section").css('visibility', 'hidden');	
	$("#evtForm").submit();
}
function getItem(item) {
	$("#selected_div").css('visibility', 'visible');
	$("#getCode_button").css('visibility', 'visible');
	$("#copyCode_button").css('visibility', 'hidden');
	$("#code_section").css('visibility', 'hidden');	
	$("#item_name_hid").val(item);
	$("#item_name_text").html(item);
}

function getCode() {
	$("#getCode_button").css('visibility', 'hidden');
	item_txt=$("#item_name_hid").val();
	event_txt=$("#event_name_hid").val();
    $.post("mabi_get_code.php",{item_name:item_txt,event_name:event_txt},function(result){
		if (result == "!!!!") {
			$("#code").html("抱歉!序號已領完");
			$("#code_section").css('visibility', 'visible');
		}
		else {
			$("#code").html(result);
			$("#copyCode_button").css('visibility', 'visible');
			$("#code_section").css('visibility', 'visible');
		}
    });
}

function copyCode() {
	var el = document.getElementById("code");
    var range = document.createRange();
    range.selectNodeContents(el);
    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
    document.execCommand('copy');
}
</script>
</head>
<?php
require_once('mabi_connect.php');   

//$SQL_item_list = "SELECT serial_number, event_name, item_name, sn_id, used FROM sn_share WHERE event_name=:event_name";
$SQL_item_list = "SELECT DISTINCT item_name FROM sn_share WHERE event_name=:event_name and used=0 ORDER BY item_name";
$SQL_event_list = "SELECT DISTINCT event_name FROM sn_share ORDER BY event_name";
$SQL_latest_event = "SELECT event_name FROM sn_share WHERE SN_ID=(SELECT max(SN_ID) FROM sn_share)";

$QUE_event_list = $db->query($SQL_event_list);
$QUE_latest_event = $db->query($SQL_latest_event);

$DAT_event_list = $QUE_event_list->fetchAll();
$DAT_latest_event = $QUE_latest_event->fetchAll();

$default_event = $DAT_latest_event[0]['event_name'];
if (isset($_POST['event_name'])) {
	$cur_event_name = $_POST['event_name'];
}
else {
	$cur_event_name = $default_event;
}

$PRE_item_list = $db->prepare($SQL_item_list, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$PRE_item_list->execute(array(':event_name' => $cur_event_name));
$DAT_item_list = $PRE_item_list->fetchAll();
?>
<body>
移至頁面： <a href="mabi_post.php">添加序號</a><br /><br />
<div style="font-weight: bold;">取得序號</div>
<form method="post" id="evtForm" name="evtForm">
活動： <select name='event_name' onChange='selectEvent()'>
<?php
foreach ($DAT_event_list as $datainfo)
{
	$event_name = $datainfo['event_name'];
	if ($cur_event_name==$event_name) {
		echo '<option selected value="'.$event_name.'">';
	}
	else {
		echo '<option value="'.$event_name.'">';
	}
	echo $event_name . '</option>';
}
?>
</select>
</form>
<?php
?>
物品清單：<br />
<div style="background-color:#00FFFF;width:400px;height:400px;overflow-y:scroll;float:left;border:2px green solid;">
<?php
foreach ($DAT_item_list as $datainfo) {
	echo "<a href='#' onclick='getItem(\"".$datainfo['item_name']."\")'>". $datainfo['item_name'] . "</a><br/>";
}
?>
</div>
<input type="hidden" id="item_name_hid" />
<input type="hidden" id="event_name_hid" value="<?php echo $cur_event_name; ?>" />
<div id="selected_div" style="background-color:#FF00FF;float:left;visibility:hidden;">
你已選擇： <div id="item_name_text" style="font-weight: bold;"></div>
確定領取? <br />
<input id="getCode_button" type="button" style="width:400px;height:120px;" value="領取序號" onclick="getCode();"/><br />
<div id="code_section">序號： <div id="code" style="font-weight: bold;"></div></div>
<input id="copyCode_button" type="button" style="width:400px;height:120px;visibility:hidden;" value="複製序號" onclick="copyCode();"/>
</div>
</body>
</html>