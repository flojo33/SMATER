<table class="table table-striped">
	<tr>
		<th></th>
		<th>Link Typ</th>
		<th>Name</th>
		<th>IP Adresse</th>
		<th>Koppeln</th>
	</tr>
<?php
	include_once("hue/hue.php");
	include_once("../mysql.php");
	$HueLink = new HueLink();
	$hue = $HueLink->discover();
	for($i = 0; $i < count($hue); $i++) {
		$ip = $hue[$i]["ip"];
		$name = $hue[$i]["name"];
		$icon = "<td style='width: 120px !important;'><img src='img/Devices/hue.jpg' height='30px' style='display: inline-block;'> <img style='display: inline-block;' src='img/Devices/hue/bridge_v2.svg' height='30px'></td>";
		if(count(Query("*","hue","`ip` = '$ip'"))==0)
		{
			echo "<tr>$icon<td>Philips Hue Bridge</td><td>".$name."</td><td>".$ip."</td><td><a class='btn btn-primary btn-sm' href='#' onclick='linkHue(\"$ip\"); return false;'>Koppeln</a></td></tr>";
		}
		else
		{
			echo "<tr>$icon<td>Philips Hue Bridge</td><td>".$name."</td><td>".$ip."</td><td>Bereits gekoppelt.</td></tr>";
		}
	}
	?>
</table>