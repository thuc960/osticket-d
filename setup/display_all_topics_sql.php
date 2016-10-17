<?php
//資料庫設定
//資料庫位置
$db_server = "localhost";
//資料庫名稱
$db_name = "itservice_prod2";
//資料庫管理者帳號
$db_user = "root";
//資料庫管理者密碼
$db_passwd = "9604845";

//對資料庫連線
if(!@mysql_connect($db_server, $db_user, $db_passwd))
        die("Can not connect database");

//資料庫連線採UTF8
//mysql_query("SET NAMES utf8");

if(!@mysql_select_db($db_name))
        die("Can not find database");   

        
        

?> 


<?php
mysql_query("SET NAMES 'utf8'");

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
/*	
	$date_submitted = isset($_POST['startdate']) ? mysql_real_escape_string($_POST['startdate']) : '';
	$enddate_submitted = isset($_POST['enddate']) ? mysql_real_escape_string($_POST['enddate']) : '';
	$getUser = isset($_POST['needs']) ? mysql_real_escape_string($_POST['needs']) : '';
	$categoryid = isset($_POST['cate']) ? mysql_real_escape_string($_POST['cate']) : '';
	$status = isset($_POST['status']) ? mysql_real_escape_string($_POST['status']) : '';
	$getSummary = isset($_POST['summary']) ? mysql_real_escape_string($_POST['summary']) : '';
	
	$sd = new DateTime('-6 month');
	$ed = new DateTime();
	
	$offset = ($page-1)*$rows;
	$result = array();
	
	if($date_submitted =="" && $enddate_submitted =="")
	{
		$date_submitted =  $sd->format('Y-m-d');
		$enddate_submitted = $ed->format('Y-m-d');
		//echo $date_submitted;
		//echo $enddate_submitted;
	}
	
	//$where ="and `getwebsite` LIKE '%$category_id%' AND `getdate` LIKE '%$date_submitted%' AND `username` LIKE '%$suser%'";
	//$where =" where FROM_UNIXTIME(B.value, '%Y-%m-%d') between '$date_submitted' and '$enddate_submitted' and C.value like '%$getUser%' and F.field_id = 13";
	
	*/
	echo "test";
	/*
	//$rs = mysql_query("SELECT COUNT(*) FROM `record`,userlist WHERE `getip` = ip ". $where." order by `getdate`");
	$rs = mysql_query("SELECT COUNT(*) from ost_ticket order BY created DESC");
	
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	
	//$rs = mysql_query("SELECT * FROM `record`,userlist WHERE `getip` = ip ". $where ." order by `getdate` DESC limit $offset,$rows");
	
	$rs = mysql_query("select * from ost_ticket order BY created DESC limit $offset,$rows");
	
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;
	
	echo json_encode($result);*/
?>