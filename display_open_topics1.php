<?php 
/*********************************************************************
    display_open_topics.php

    Displays a block of the last X number of open tickets.

    Neil Tozier <tmib@tmib.net>
    Copyright (c)  2010-2015
    For use with osTicket version 1.9.x and 1.10 (http://www.osticket.com)

	This release was tested with both 1.9.7 and 1.10rc2.
	
    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See osTickets's LICENSE.TXT for details.
**********************************************************************/

// EDIT THIS!  The maximum amount of open tickets that you want to display. 
$limit ='10';

// OPTIONAL: if you know the id for Open in your database put it here.  If you do not you can look 
// it up in DBPREFIX_ticktet_status, or this script will look it up for you.  This is 1 in all my installations.
// changing this to a number will save you a SQL query. If you are running 1.8 or prior change this to "open".
// NOTE: Backwards compatibility has not been tested.
$openid = '1';

// OPTIONAL: if you use multiple 'open' statuses and would like them ALL to be displayed set this to 1.  Example:
// We use a Pending status which is a type of open.  Setting this to 1 displays Open and Pending.
$multiple = '1';

// If you are running 1.8 or prior change this to "status".  If you are running 1.9 or 1.10 change this to "status_id"
// NOTE: Backwards compatibility has not been tested.
$status = 'status_id';

// OPTIONAL: 
if (null !== TABLE_PREFIX) {
  define('TABLE_PREFIX','ost_');
}

// needed for 1.8+ for now until we tie this back into the built in DB query
$username="root";
$password="9604845";
$database="itservice_prod2";

mysql_connect('localhost',$username,$password) or die(mysql_error());
@mysql_select_db($database) or die( "Unable to select database");
// end 1.8+ fix for now

if($multiple) { 

	// The columns that you want to collect data for from the db
	// Please note that due to db structure changes in 1.8.x you can only include columns from the ost_ticket table
	// and this script does not handle custom fields at this time.
	$columns = "ost_ticket.ticket_id, ost_ticket.status_id, ost_ticket.user_id, ost_ticket.created, ost_ticket.updated";
	
	$query = "SELECT ".$columns." FROM ".TABLE_PREFIX."ticket
			INNER JOIN ".TABLE_PREFIX."ticket_status ON ".TABLE_PREFIX."ticket.status_id = ".TABLE_PREFIX."ticket_status.id
			WHERE ".TABLE_PREFIX."ticket_status.state = 'open'
			ORDER BY ".TABLE_PREFIX."ticket.created DESC
			LIMIT 0,$limit";

}
else {
	if(empty($openid)) { 
		// get Open id (which is usually 1)
		$opensql = "SELECT id FROM ".TABLE_PREFIX."ticket_status WHERE name='Open'";
		$openresult = mysql_query($opensql);
		$openid = mysql_result($openresult,0,"id");
	}

	// The columns that you want to collect data for from the db
	// Please note that due to db structure changes in 1.8.x you can only include columns from the ost_ticket table
	// and this script does not handle custom fields at this time.
	$columns = "ticket_id, user_id, created, updated";

	// mysql query.  The columns tha
	$query = "SELECT $columns
			 FROM ".TABLE_PREFIX."ticket
			 WHERE $status = $openid
			 ORDER BY created DESC
			 LIMIT 0,$limit";
}

if($result=mysql_query($query)) { 
  $num = mysql_numrows($result);
}
//echo "query: ".$query."<br>";  // uncomment to debug
//echo "num: ".$num."<br>";  // uncomment to debug

if ($num >> 0) {

// table headers, if you add or remove columns edit this
echo "<table border-color=#BFBFBF border=0 cell-spacing=2><tr style='background-color: #BFBFBF;'>";
echo "<td id='openticks-a' style='min-width:75px;'><b>Priority</b></td><td id='openticks-a' style='min-width:150px;'><b>Name</b></td><td id='openticks-a' style='min-width:250px;'><b>Issue</b></td><td id='openticks-a' style='min-width:150px;'><b>Opened on</b></td><td id='openticks-b' style='min-width:150px;'><b>Last Update</b></td></tr>";

$i=0;
while ($i < $num) {
 
 // You will need one line below for each column name that you collect and want to display.
 // If you are unfamiliar with php its  essentially $uniqueVariable = mysql junk ( columnName );
 // Just copy one of the lines below and change the $uniqueVariable and columnName
 $user_id = mysql_result($result,$i,"user_id");
 $ticket_id = mysql_result($result,$i,"ticket_id");
 //$created = date_format(date_create(mysql_result($result,$i,"created")),myGetDateTimeFormat());
 $created = mysql_result($result,$i,"created");
 $updated = mysql_result($result,$i,"updated");

 // additional variables you might want
 //$agency = mysql_result($result,$i,"agency");
 //$priority  = mysql_result($result,$i,"priority_id");
 
 // if no update say so
 if ($updated == '0000-00-00 00:00:00') {
   $updated = 'not updated yet';
 }
 
  // look up internal form id
  $entryIdsql = "SELECT id,form_id FROM ".TABLE_PREFIX."form_entry WHERE object_id=$ticket_id LIMIT 1";
  $entryIdresult = mysql_query($entryIdsql);
  $entry_id = mysql_result($entryIdresult,0,"id");
  $form_id = mysql_result($entryIdresult,0,"form_id");
  
  // get subject
  $subjectsql = "SELECT value FROM ".TABLE_PREFIX."form_entry_values WHERE entry_id=$entry_id and field_id=5";
  //echo "SubSQL: ".$subjectsql."<br>";  // uncomment to debug
  $subjectresult = mysql_query($subjectsql);
  $subject = mysql_result($subjectresult,0,"value");
  
  // get priority
  $prioritysql = "SELECT value FROM ".TABLE_PREFIX."form_entry_values WHERE entry_id=$entry_id and field_id=7";
  //echo "PriSQL: ".$prioritysql."<br>";  // uncomment to debug
  $priorityresult = mysql_query($prioritysql);
  $priority = mysql_result($priorityresult,0,"value");
  if(is_null($priority)) {
	  $priority = 'Normal';
  }

  // get ticket openers name
  $namesql = "SELECT name FROM ".TABLE_PREFIX."user WHERE id=$user_id";
  $nameresult = mysql_query($namesql);
  $name = mysql_result($nameresult,0,"name");
  
  //mysql_close();

	// change row back ground color to make more readable
	if(($i % 2) == 1)  //odd
      {$bgcolour = '#F6F6F6';}
    else   //even
      {$bgcolour = '#FEFEFE';}
 
  //populate the table with data
  echo "<tr align=center><td BGCOLOR=$bgcolour id='openticks-a' nowrap> &nbsp; $priority &nbsp; </td>"
    ."<td BGCOLOR=$bgcolour id='openticks-a' nowrap style='min-width:150px;'> &nbsp; $name &nbsp; </td>"
    ."<td BGCOLOR=$bgcolour id='openticks-a' style='min-width:200px;'> &nbsp; $subject &nbsp; </td>"
    ."<td BGCOLOR=$bgcolour id='openticks-a'> $created </td>"
	."<td BGCOLOR=$bgcolour id='openticks-b'> $updated </td></tr>";
 
 	++$i;
}
echo "</table>";
}

else {
 echo "<p style='text-align:center;'><span id='msg_warning'>There are no tickets open at this time.</span></p>";
}
?>
<?php
function myGetDateTimeFormat() {
  $timesql = "SELECT value FROM ".TABLE_PREFIX."config WHERE `namespace`='core' AND `key`='datetime_format'";
  $timeresult = mysql_query($timesql);
  $dateTimeFormat = mysql_result($timeresult,0,"value");
  return $dateTimeFormat;
} ?>