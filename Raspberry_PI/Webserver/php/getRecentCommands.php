<?php
	include_once("php/mysql.php");
	$rows = Query("*","requests","1 ORDER BY id DESC");
	for($i = 0; $i < count($rows); $i++) {
		if($i != 0) {
			echo "<hr>";
		}
		$str = $rows[$i]["requestString"];
		echo '<a class="btn btn-secondary" href="#" onclick="SendText(\'' . $str . '\');">' . $str . '</a>';
	}
	?>