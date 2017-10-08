<?php
	//Obtain all ip addresses of all bridges
	//in network and return a json array of addresses
	class HueLink {
		function discover() {
			$data = json_decode(file_get_contents("https://www.meethue.com/api/nupnp"));
			$output = array();
			for($i = 0; $i < count($data); $i++) {
				$ip = $data[$i]->internalipaddress;
				$deviceData = json_decode(file_get_contents("http://".$ip."/api/smater/config"));
				$deviceName = $deviceData->name;
				$output[$i] = array("name"=>$deviceName, "ip"=>$ip);
			}
			return $output;
		}
		
		//Link a hue by pressing the button and calling this function.
		//The userdata is automaticly stored in the mysql db.
		function link($ip) {
			$url = "http://".$ip."/api";
			$data = array('devicetype' => 'my_hue_app#smater');
			
			// use key 'http' even if you send the request to https://...
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => json_encode($data)
			    )
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			if ($result === FALSE) { /* Handle error */ }
			
			return $result;
		}
		
		function SwitchLightOnOff($ip, $id, $on) {
			include_once("../../mysql.php");
			$username = Query("*","hue","`ip` = '$ip'")[0]["username"];
			$url = "http://".$ip."/api/".$username."/lights/".$id."/state";
			$on = "".$on;
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'PUT',
			        'content' => "{\"on\":$on}"
			    )
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			if ($result === FALSE) { /* Handle error */ }
			
			return $result;

		}
		
		//Switch a lights state on or off and set Color
		function SwitchLight($ip, $id, $on, $r = 0, $g = 0, $b = 0) {
			include_once("../../mysql.php");
			$username = Query("*","hue","`ip` = '$ip'")[0]["username"];
			$url = "http://".$ip."/api/".$username."/lights/".$id."/state";
			$xy = $this->RGBtoXY($r,$g,$b);
			$X = $xy["X"];
			$Y = $xy["Y"];
			if($X == "") $X = "0.0";
			if($Y == "") $Y = "0.0";
			$splitx = explode(".", "".$X);
			if(count($splitx) != 2){
				$X .= ".0";
			}
			$splity = explode(".", "".$Y);
			if(count($splity) != 2){
				$Y .= ".0";
			}
			$on = "".$on;
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'PUT',
			        'content' => "{\"on\":$on, \"xy\":[$X,$Y], \"bri\":255}"
			    )
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			if ($result === FALSE) { /* Handle error */ }
			
			return $result;
		}
		
		function GetDeviceList() {
			include_once("../../mysql.php");
			$hueBridges = Query("*","hue");
			$availableBridges = $this->discover();
			$foundBridgesCount = count($availableBridges);
			$deviceList = array();
			$curId = 0;
			for($i = 0; $i < count($hueBridges); $i++) {
				$ip = $hueBridges[$i]["ip"];
				$found = false;
				for($k = 0; $k < $foundBridgesCount; $k++) {
					if($availableBridges[$k]["ip"] == $ip) {
						$found = true;
						break;
					}
				}
				if($found)
				{
					$bridgeData = json_decode(file_get_contents("http://".$ip."/api/smater/config"));
					$bridgeName = $bridgeData->name;
					$raw = file_get_contents("http://".$ip."/api/".$hueBridges[$i]["username"]."/lights");
					$hueLights = json_decode($raw,true);
					for($j = 0; $j < count($hueLights); $j++) {
						$key = array_keys($hueLights)[$j];
						$deviceName = $hueLights[$key]["name"];
						$deviceOn = $hueLights[$key]["state"]["on"];
						$hueType = $hueLights[$key]["type"];
						$deviceModel = $hueLights[$key]["modelid"];
						$internalType = "hue_rgb";
						$deviceId = $hueLights[$key]["uniqueid"];
						$reachable = $hueLights[$key]["state"]["reachable"];
						$deviceState = "off";
						if($deviceOn == "true") {
							$deviceState = "on";
						}
						$deviceList[$curId] = array(
							"internal_id"=>($curId+1),
							"unique_id"=>$deviceId,
							"name"=>$deviceName,
							"state"=>$deviceState,
							"type"=>$internalType,
							"model"=>$deviceModel,
							"bridge_name"=>$bridgeName,
							"bridge_ip"=>$ip,
							"key"=>$key,
							"reachable"=>$reachable
						);
						$curId++;
					}
				}
			}
			return $deviceList;
		}
		
		function ModelIdToName($modelId) {
			switch(1) {
				case $modelId == "LST001" || $modelId == "LST002":
					return "lightstrip";
				case $modelId == "LCT001" || $modelId == "LCT007" || $modelId == "LCT010" || $modelId == "LCT014" || $modelId == "LTW010" || $modelId == "LTW001" || $modelId == "LTW004" || $modelId == "LTW015" || $modelId == "LWB004" || $modelId == "LWB006":
					return "e27_waca";
				case $modelId == "LWB010" || $modelId == "LWB014":
					return "e27_white";
				case $modelId == "LCT002":
					return "br30";
				default:
					return "gu10";
			}
		}
		
		function RGBtoXY($r,$g,$b){
			$x = 0.4124*$r + 0.3576*$g + 0.1805*$b;
			$y = 0.2126*$r + 0.7152*$g + 0.0722*$b;
			$z = 0.0193*$r + 0.1192*$g + 0.9505*$b;
			$X = $x / ($x + $y + $z);
			$Y = $y / ($x + $y + $z);
			return array("X"=>$X,"Y"=>$Y);
		}
		
		
	}
	?>