<?php
	include_once("hue.php");
	include_once("../../mysql.php");
	$ip = $_POST["ip"];
	$id = $_POST["id"];
	$on = $_POST["on"];
	$HueLink = new HueLink();
	$result = json_decode($HueLink->SwitchLightOnOff($ip,$id,$on));
	$error = false;
	for($i = 0; $i < count($result); $i++) {
		if($result[$i]->error != null)
		{
			$error = true;
			//echo json_encode(json_decode($result)[$i]->error);
			//echo "Beim umschalten der Lampe ist ein Fehler aufgetreten. Bitte versuche es später erneut!";
		}
	}
	if($error) {
		echo "Error!";
	}
	else
	{
		echo "success";
	}
	?>