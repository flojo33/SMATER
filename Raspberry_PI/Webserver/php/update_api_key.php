<?php
	include_once("mysql.php");
	$newKey = $_GET["key"];
	$checkUrl = "http://smater.diebayers.de/?f=verifyKey&key=$newKey";
	$responce = json_decode(file_get_contents($checkUrl),true);
	if($responce["responce"]["type"] == "SUCCESS") {
		Update("settings","`value` = '$newKey'","`name` = 'API_Key'");
		echo "success";
	} else {
		echo "incorrect";
	}
	?>