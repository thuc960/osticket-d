<?php

$db_server = "localhost";

$db_name = "itservice_prod2";

$db_user = "root";

$db_passwd = "9604845";


if(!@mysql_connect($db_server, $db_user, $db_passwd))
        die("Can not connect database");


//mysql_query("SET NAMES utf8");

if(!@mysql_select_db($db_name))
        die("Can not find database");   

        
        

?> 


<?php 
mysql_query("SET NAMES 'utf8'");

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	
	$offset = ($page-1)*$rows;
	$result = array();
	/*
	$date_submitted = isset($_POST['startdate']) ? mysql_real_escape_string($_POST['startdate']) : '';
	$enddate_submitted = isset($_POST['enddate']) ? mysql_real_escape_string($_POST['enddate']) : '';
	$getUser = isset($_POST['needs']) ? mysql_real_escape_string($_POST['needs']) : '';
	$categoryid = isset($_POST['cate']) ? mysql_real_escape_string($_POST['cate']) : '';
	$status = isset($_POST['status']) ? mysql_real_escape_string($_POST['status']) : '';
	$getSummary = isset($_POST['summary']) ? mysql_real_escape_string($_POST['summary']) : '';
	*/
	//$sd = new DateTime('-1 month');
	//$ed = new DateTime('NOW');
	$date = new DateTime('NOW', new DateTimeZone('Asia/Ho_Chi_Minh'));
	$date->format('Y-m-d');
	$d = $date->modify('-1 month');
	
	//$d = $datenow->format('Y-m-d');
	
	
	echo $d;
	
	
	echo "tes";
	//if($date_submitted =="" && $enddate_submitted =="")
	//{
	//	$date_submitted =  $sd->format('Y-m-d');
	//	$enddate_submitted = $ed->format('Y-m-d');
	//	
	//	echo $date_submitted;
	//	echo $enddate_submitted;
	//}
	
	//$where ="and `getwebsite` LIKE '%$category_id%' AND `getdate` LIKE '%$date_submitted%' AND `username` LIKE '%$suser%'";
	//$where =" where FROM_UNIXTIME(B.value, '%Y-%m-%d') between '$date_submitted' and '$enddate_submitted' and C.value like '%$getUser%' and F.field_id = 13";
	
	/*if($date_submitted =="" && $enddate_submitted =="")
	{
		$date_submitted =  $sd->format('Y-m-d');
		$enddate_submitted = $ed->format('Y-m-d');
	}*/
	
	
	$rs = mysql_query("SELECT COUNT(*)
FROM
ost_ticket
LEFT JOIN ost_staff ON ost_ticket.staff_id = ost_staff.staff_id
INNER JOIN ost_user ON ost_ticket.user_id = ost_user.id
INNER JOIN ost_ticket__cdata ON ost_ticket.ticket_id = ost_ticket__cdata.ticket_id
INNER JOIN ost_ticket_status ON ost_ticket.status_id = ost_ticket_status.id
				
ORDER BY
ost_ticket.created DESC,
ost_ticket.number DESC,
ost_ticket.lastupdate DESC
");
	
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	

	$rs = mysql_query("SELECT
ost_ticket.number,
ost_ticket.closed,
DATE_FORMAT(ost_ticket.created, '%Y-%m-%d') as created,
ost_user.`name` as username,
DATE_FORMAT(ost_ticket.lastupdate, '%Y-%m-%d') as lastupdate,
ost_ticket__cdata.`subject` as subject,
ost_ticket_status.`name` as statusname,
ost_staff.firstname
FROM
ost_ticket
LEFT JOIN ost_staff ON ost_ticket.staff_id = ost_staff.staff_id
INNER JOIN ost_user ON ost_ticket.user_id = ost_user.id
INNER JOIN ost_ticket__cdata ON ost_ticket.ticket_id = ost_ticket__cdata.ticket_id
INNER JOIN ost_ticket_status ON ost_ticket.status_id = ost_ticket_status.id
			
ORDER BY
ost_ticket.created DESC,
ost_ticket.number DESC,
ost_ticket.lastupdate DESC
LIMIT $offset, $rows");
		
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;
	//print_r($item);
	echo json_encode($result);
?>