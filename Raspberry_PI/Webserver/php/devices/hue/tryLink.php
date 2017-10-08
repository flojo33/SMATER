<?php
	include_once("hue.php");
	include_once("../../mysql.php");
	$ip = $_POST["ip"];
	$HueLink = new HueLink();
	$result = $HueLink->link($ip);
	if(json_decode($result)[0]->error != null)
	{
		echo "Beim koppeln ist ein Fehler aufgetreten. Bitte versuche es erneut. Achtung: vor dem koppeln muss der Runde Knopf auf der Bridge gedrückt werden!";
	}
	else
	{
		$username = json_decode($result)[0]->success->username;
		Insert("hue","(`id`,`ip`,`username`)","(NULL,'$ip','$username')");
		echo "success";
	}
	?>