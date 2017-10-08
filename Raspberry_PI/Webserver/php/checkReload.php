<?php
	include_once("mysql.php");
	$value = Query("*","settings","`name` = 'needs_reload'")[0]["value"];
	if($value == "true") {
		Update("settings","`value` = 'false'","`name` = 'needs_reload'");
		echo "true";
	}
	else
	{
		echo "false";
	}
	?>