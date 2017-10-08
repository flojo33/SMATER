<?php
	include_once("mysql.php");
	include_once("devices/hue/hue.php");
	$HueLink = new HueLink();
	$deviceList = $HueLink->GetDeviceList();
	$device = $_GET["deviceId"];
	$functions = GetFunctionsForType(GetDeviceType($deviceList, $device));
	if(count($functions) == 0){
		echo "<option value='-1'>Keine Funktionen</option>";
		
	} else {
		echo "<option value='-1'>Funktion</option>";
		for($i = 0; $i < count($functions); $i++) {
			echo "<option value='$i'>".$functions[$i]."</option>";
		}
	}
	
	function GetFunctionsForType($type) {
		$functions = array();
		switch($type){
			case "hue_rgb":
				$functions = ["An / Aus","Farbe Fragen / Aus"];
			break;
		}
		return $functions;
	}
	
	function GetDeviceType($deviceList, $deviceId) {
		if(count($deviceList) == 0 || $deviceId == -1) {
			return "";
		}
		
		for($i = 0; $i < count($deviceList); $i++) {
			if($deviceList[$i]["internal_id"] == $deviceId) {
				return $deviceList[$i]["type"];
			}
		}
		return "";
	}
?>