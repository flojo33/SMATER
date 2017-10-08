<?php
	include_once("php/mysql.php");
	include_once("php/devices/hue/hue.php");
	
	$HueLink = new HueLink();
	
	$command="/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";
	$localIP = exec ($command);
	
	if(file_get_contents("http://smater.diebayers.de/devices/index.php?ip=".$localIP) != "success") {
		echo "Error Updating ip!";
	}
	
	$curDeviceDB = Query("*","devices");
	$hueDeviceList = $HueLink->GetDeviceList();
	
	$countCur = count($curDeviceDB);
	$countHue = count($hueDeviceList);
	if($countCur != $countHue) {
		SetData($hueDeviceList);
	} else {
		$same = true;
		for($i = 0; $i < $countCur; $i++) {
			if($curDeviceDB[$i]["unique_id"] != $hueDeviceList[$i]["unique_id"]) {
				$same = false;
			}
			if($curDeviceDB[$i]["name"] != $hueDeviceList[$i]["name"]) {
				$same = false;
			}
			if($curDeviceDB[$i]["state"] != $hueDeviceList[$i]["state"]) {
				$same = false;
			}
			if($curDeviceDB[$i]["reachable"] != $hueDeviceList[$i]["reachable"]) {
				$same = false;
			}
		}
		if(!$same) {
			SetData($hueDeviceList);
			Update("settings","`value` = 'true'","`name` = 'needs_reload'");
		} else {
			echo "nochange";
		}
	}
	
	function SetData($hueDeviceList) {
		
		echo "Updating Internal Database...";
		
		Remove("devices","1 = 1");
		
		for($i = 0; $i < count($hueDeviceList); $i++) {
			$device = $hueDeviceList[$i];
			$internal_id = $device["internal_id"];
			$unique_id = $device["unique_id"];
			$name = $device["name"];
			$state = $device["state"];
			$type = $device["type"];
			$model = $device["model"];
			$bridge_name = $device["bridge_name"];
			$bridge_ip = $device["bridge_ip"];
			$key = $device["key"];
			$reachable = $device["reachable"];
			Insert("devices","(`internal_id`, `unique_id`, `name`, `state`, `reachable`, `type`, `model`, `bridge_name`, `bridge_ip`, `key`)","($internal_id, '$unique_id', '$name', '$state', '$reachable', '$type', '$model', '$bridge_name', '$bridge_ip', '$key')");
		}
		
		echo "Uploading Database to Smater Server...";
		$settings = Query("*","settings");
		$apiKey = $settings[0]["value"];
		
		//extract data from the post
		//set POST variables
		$url = "http://smater.diebayers.de/?f=update_list&key=$apiKey";
		$fields = array(
			"deviceList" => $hueDeviceList
		);
		
		$fields_string = http_build_query($fields);
		
		$ch = curl_init();
		
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		
		curl_close($ch);
		echo "Upload Result: ".$result;
	}
?>