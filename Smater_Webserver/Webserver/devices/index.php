<?php
	include_once("../mysql.php");
	$outer_ip = $_SERVER['REMOTE_ADDR'];
	if(isset($_GET["ip"])) {
		$inner_ip = $_GET["ip"];
		Remove("ip_link","`ip_outer` = '$outer_ip'");
		Insert("ip_link","(`id`, `ip_outer`, `ip_inner`)","(NULL, '$outer_ip', '$inner_ip')");
		echo "success";
	}
	else
	{
		$rows = Query("*","ip_link","`ip_outer` = '$outer_ip'");
		if(count($rows) == 1) {
			header("Location: http://".$rows[0]["ip_inner"]);
		} else {
			echo "Error: No devices listed in this Network!";
		}
	}
	?>