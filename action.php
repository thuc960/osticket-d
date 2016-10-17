<?php
	$action = isset($_REQUEST["action"])?$_REQUEST["action"]:"all";
		$file = "display_all_topics.php";
		
	if ($action =="close") 	
		$file = "display_close_topics.php";
		

	include $file;
			
?>