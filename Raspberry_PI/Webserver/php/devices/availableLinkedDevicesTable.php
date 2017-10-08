<table class="table table-multiline-striped">
	<tr>
		<th></th>
		<th>Name</th>
		<th>Id</th>
		<th>Verbunden</th>
		<th>Typ</th>
		<th>Link Über</th>
		<th>Gerät Id</th>
	</tr>
	<tr>
		<th></th>
		<th colspan="6">Aktionen</th>
	</tr>
<?php
	include_once("../mysql.php");
	
	/*
		use <bridge ip address>/api/<username>/lights
		to get all hue brudge devices
	*/
	
	include_once("hue/hue.php");
	$HueLink = new HueLink();
	$deviceList = $HueLink->GetDeviceList();
	for($i = 0; $i < count($deviceList); $i++) {
		$device = $deviceList[$i];
		$toggleButton = "<a class='btn btn-success btn-sm btn-fixed-width' href='#' onClick='switchHueLight(\"".$device["bridge_ip"]."\",\"".$device["key"]."\",\"true\"); return false;'>Einschalten</a>";
		if($device["state"] == "on") {	
			$toggleButton = "<a class='btn btn-danger btn-sm btn-fixed-width' href='#' onClick='switchHueLight(\"".$device["bridge_ip"]."\",\"".$device["key"]."\",\"false\"); return false;'>Ausschalten</a>";
		}
		$triggerButton = "<a class='btn btn-warning btn-sm btn-fixed-width' href='#' onClick='SendText(\"starte smater mit gerät ".$device["internal_id"]."\"); return false;'>Triggern</a>";
		$reachable = "Ja";
		if($device["reachable"] != "1") {
			$triggerButton = "<a class='btn btn-warning btn-sm btn-fixed-width disabled' disabled href='#'>Triggern</a>";
			$toggleButton = "<a class='btn btn-success btn-sm btn-fixed-width disabled' disabled>Einschalten</a>";
			$reachable = "Nein";
		}
		$icon = "<td style='width: 120px !important;'><img src='img/Devices/hue.jpg' height='30px' style='display: inline-block;'> <img style='display: inline-block;' src='img/Devices/hue/".$HueLink->ModelIdToName($device["model"]).".svg' height='30px'></td>";
		echo "<tr>$icon</td><td>".$device["name"]."</td><td>".$device["internal_id"]."</td><td>$reachable</td><td>".$device["type"]."</td><td>".$device["bridge_name"]."</td><td>".$device["unique_id"]."</td></tr><tr><td></td><td colspan='6'>$toggleButton $triggerButton</td></tr>";
	}
	?>
</table>