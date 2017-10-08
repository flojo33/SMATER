<?php
	require_once('mysql.php');
	$id = $_POST["id"];
	
	Remove("functions","id = $id");
	echo EchoSuccess(null,"Removed function with id ".id);
	
	function EchoSuccess($data, $statusText)
	{
		header('Content-Type: application/json');
		echo json_encode(array('Responce' => 'Success' ,'Data' => $data, 'Status_Message' => $statusText));
	}
	?>