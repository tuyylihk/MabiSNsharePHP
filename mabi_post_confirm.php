<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>添加序號</title>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
</script>
<style>
.table_div{
width:280px;
display: table-cell;
border-style:solid;
border-width:2px;
}

.table_div_head{
background-color:#00FFFF;
font-weight: bold;
}

.table_div_list{
background-color:#FFFF77;
}
</style>
</head>
<body>
移至頁面： <a href="mabi_get.php">取得序號</a><br /><br />
<div style="font-weight: bold;">添加序號</div>
請確認內容然後按送出
<form method="post" name="evtForm" action="mabi_post_code.php">
<input type="button" value="回上頁" onclick="history.go(-1)" />　<input type="submit" value="送出"> <br/>
<div style="width:900px;">
<div>
<div class="table_div table_div_head" style="">活動名稱</div>
<div class="table_div table_div_head" style="">道具名稱</div>
<div class="table_div table_div_head" style="">序號</div>
</div>
<?php 
$item_txt_all="";
$line_arr = explode("\n",$_REQUEST['item_text']);
foreach ($line_arr as $line) {
	if (trim($line)=="") continue;
    $txt_arr = explode("\t",$line);
	$event_name=trim($txt_arr[0]);
	if (trim($event_name)=="") break;
	$item_name=trim($txt_arr[1]);
	if (trim($item_name)=="") break;
	$code=trim($txt_arr[2]);
	if (trim($code)=="") break;
	echo "<div style=\"display: table-row;\">";
	echo "<div class=\"table_div table_div_list\">".$event_name."</div>";
	echo "<div class=\"table_div table_div_list\">".$item_name."</div>";
	echo "<div class=\"table_div table_div_list\">".$code."</div>";
	echo "</div>";
	$item_txt_all .= $event_name."|".$item_name."|".$code.";";
}
 ?>
<input type="hidden" name="item_txt_all" value="<?php echo $item_txt_all; ?>" />
</div>
</form>
</body>
</html>