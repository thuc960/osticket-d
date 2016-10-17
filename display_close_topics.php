Những vấn đề chưa giải quyết<br/>等處理案件
  <div id="openticks">
<?php
/*********************************************************************
    display_open_topics.php

    Displays a block of the last X number of open tickets.

    Neil Tozier <tmib@tmib.net>
    Copyright (c)  2010-2013
    For use with osTicket version 1.7ST (http://www.osticket.com)

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See osTickets's LICENSE.TXT for details.
**********************************************************************/
# configure this area with your database connection information
$dbhost = 'localhost';   // FQDN server name or IP (or localhost for local machine)
$dbname = 'itservice_prod2';   // database name
$dbuser = 'root';    // database username
$dbpass = '9604845';    // database password for username (above)

# make the connection to the MySQL server
mysql_connect($dbhost,$dbuser,$dbpass);
@mysql_select_db($dbname) or die("DB Error: Unable to select database");

// The columns that you want to collect data for from the db
$columns = "number, user_email, ost_ticket.staff_id, subject, ost_ticket.created, lastupdate, ip_address,topic,ost_ticket_status.name,ost_ticket.user_id";

mysql_query("set names 'utf8'");

// The maximum amount of open tickets that you want to display.
$limit ='10';

// mysql query.  The columns tha
/*$query = "SELECT $columns
			 FROM ost_ticket
			 WHERE status='open' AND dept_id != 3
			 ORDER BY created DESC
			 LIMIT 0,$limit"; */
			 $query = "SELECT
$columns

FROM
ost_ticket
INNER JOIN ost_ticket__cdata ON ost_ticket.ticket_id = ost_ticket__cdata.ticket_id
INNER JOIN ost_help_topic ON ost_ticket.topic_id = ost_help_topic.topic_id
INNER JOIN ost_ticket_status ON ost_ticket_status.id = ost_ticket.status_id
WHERE ost_ticket.closed IS NULL
ORDER BY ost_ticket.created DESC
";
			 
//echo $query;
$result=mysql_query($query);
$num = mysql_num_rows($result);

if ($num >> 0) {

// table headers, if you add or remove columns edit this
echo "<table style='width: 100%;' border-color=#BFBFBF border=0 cell-spacing=2 style='font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: xx-small;'><tr style='background-color: #BFBFBF;' align='center'>";
echo "<td id='openticks-a'><b>ID</b><td id='openticks-a'><b>Email</b></td><td id='openticks-a'><b>Issue</b></td><td id='openticks-a'><b>Opened on</b></td><td id='openticks-b'><b>Last updated</b></td><td id='openticks-b'><b>Status</b></td><td id='openticks-b'><b>Assigned To</b></td></tr>";

$i=0;
while ($i < $num) {
 
 // You will need one line below for each column name that you collect and want to display.
 // If you are unfamiliar with php its  essentially $uniqueVariable = mysql junk ( columnName );
 // Just copy one of the lines below and change the $uniqueVariable and columnName

 $ticketid = mysql_result($result,$i,"number");
$name = mysql_result($result,$i,"user_email");
 $subject = mysql_result($result,$i,"subject");
 $created = mysql_result($result,$i,"ost_ticket.created");
 $updated = mysql_result($result,$i,"lastupdate");
 $topic = mysql_result($result,$i,"topic");
$user_id = mysql_result($result,$i,"ost_ticket.user_id");
$status = mysql_result($result,$i,"ost_ticket_status.name");
 $staff_id  = mysql_result($result,$i,"ost_ticket.staff_id");
 
 //echo "Staff id = $staff_id";
 if ($staff_id > 0)
 {
 	$staff_firstname = "SELECT firstname FROM ost_staff WHERE staff_id='$staff_id'";
 	$staff_firstname_result = mysql_query($staff_firstname);
 	$staff_name = mysql_result($staff_firstname_result,0,"firstname");
 	
 	$staff = $staff_name;
 }
 else 
 {
 	$staff = "No resolve yet";
 }
 	
 if ($staff_id > 0)
 {
 	$user_name = "SELECT name FROM ost_user WHERE ost_user.id='$user_id'";
 	$user_name_result = mysql_query($user_name);
 	$user_name = mysql_result($user_name_result,0,"name");
 
 	$name = $user_name;
 }
 else
 {
 	$name = "No name";
 }
 
 
 // if no update say so, and make the date format more human friendly
 if ($updated == null) 
 {
   $updated_date = 'No update yet';
 }
 else 
 {
 $updated_date = date("Y-m-d H:i", strtotime($updated));
 }
 
 //make the created date format more human friendly
 $created_date = date("Y-m-d H:i", strtotime($created));
 
 
  // look up department and then cross refference to get department's name
  $getdept_names = "SELECT * FROM ost_department WHERE dept_id='$department_id'";
  $deptresult = mysql_query($getdept_names);
  $dept = mysql_result($deptresult,0,"dept_name");
  
 
	// change row back ground color to make more readable
	if(($i % 2) == 1)  //odd
      {$bgcolour = '#F6F6F6';}
  else   //even
      {$bgcolour = '#FEFEFE';}
 
 //populate the table with data
/* echo "<tr align=center><td BGCOLOR=$bgcolour id='openticks-a' nowrap>$ticketid</td><td BGCOLOR=$bgcolour id='openticks-a' nowrap>$name</td>"
	."<td BGCOLOR=$bgcolour id='openticks-a' nowrap> &nbsp; $topic &nbsp; </td><td BGCOLOR=$bgcolour id='openticks-a'>&nbsp;$subject&nbsp;</td>"
	."<td BGCOLOR=$bgcolour id='openticks-a'> &nbsp; $created_date &nbsp; </td><td BGCOLOR=$bgcolour id='openticks-b'>"
	." &nbsp; $updated_date &nbsp; </td><td BGCOLOR=$bgcolour id='openticks-b'>"
	."$status </td>"
	."<td BGCOLOR=$bgcolour id='openticks-a'> &nbsp; $staff &nbsp; </td></tr>";
*/
      
      echo "<tr align=center><td BGCOLOR=$bgcolour id='openticks-a' nowrap>$ticketid</td><td BGCOLOR=$bgcolour id='openticks-a' nowrap>$name</td>"
      ."<td BGCOLOR=$bgcolour id='openticks-a'>&nbsp;$subject&nbsp;</td>"
      ."<td BGCOLOR=$bgcolour id='openticks-a'> &nbsp; $created_date &nbsp; </td><td BGCOLOR=$bgcolour id='openticks-b'>"
      ." &nbsp; $updated_date &nbsp; </td><td BGCOLOR=$bgcolour id='openticks-b'>"
      ."$status </td>"
      ."<td BGCOLOR=$bgcolour id='openticks-a'> &nbsp; $staff &nbsp; </td></tr>";
 	++$i;
}
echo "</table>";
}

else {
 echo "<p style='text-align:center;'><span id='msg_warning'>No ticket are waiting to resolve.</span></p>";
}

?>
</div>