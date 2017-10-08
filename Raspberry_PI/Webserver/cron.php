<?php
	include_once("php/mysql.php");
	include_once("php/devices/hue/hue.php");
	include_once("server_handler.php");
	$settings = Query("*","settings");
	$apiKey = $settings[0]["value"];
	$actions = json_decode(file_get_contents("http://smater.diebayers.de/?f=actions&key=$apiKey"),true);
	if(count($actions) > 0)
	{
		if($actions["responce"]["type"] == "SUCCESS") {
			$data = $actions["responce"]["data"];
			if(count($data) > 0) {
				for($i = 0; $i < count($data); $i++) {
					if($i != 0) {
						echo "\n";
					}
					if($data[$i]["device"] != "-1")
					{
						//Set a Light
						setLight($data[$i]["device"], $data[$i]["state"], $data[$i]["r"], $data[$i]["g"], $data[$i] ["b"]);
						Update("settings","`value` = 'true'","`name` = 'needs_reload'");
					} else {
						//Execute a function
						$funcId = $data[$i]["state"];
						$rows = Query("*","functions","id = $funcId");
						if(count($rows) == 1){
							echo "Execute function '".$rows[0]["name"]."'";
							FunctionCommandInternal($rows[0]["request_id"]);
						} else {
							echo "Wants to execute Function with ID $funcId but it does not exist!";
						}
					}
				}
			} else {
				echo "nochange";
			}
		} else {
			echo "nochange";
		}
	}
	else
	{
		echo "nochange";
	}
	
	function setLight($id, $state, $r, $g, $b)
	{
		$key = Query("*","devices","internal_id = $id")[0]["key"];
		$ip = Query("*","devices","internal_id = $id")[0]["bridge_ip"];
		$on = "false";
		if($state == "on") {
			$on = "true";
		}
		$HueLink = new HueLink();
		$result = $HueLink->SwitchLight($ip,$key,$on, $r, $g, $b);
		if(json_decode($result)[0]->error != null)
		{
			echo json_encode(json_decode($result)[0]->error);
			//echo "Beim umschalten der Lampe ist ein Fehler aufgetreten. Bitte versuche es später erneut!";
		}
		else
		{
			echo "Set light $id to RGB($r, $g, $b)";
		}
	}
	?>