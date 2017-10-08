<?php
	$host_name  = "127.0.0.1";
    $database   = "ALEXA";
    $user_name  = "root";
    $password   = "12345";
    
	$mysqli = mysqli_connect($host_name, $user_name, $password, $database);
	if (!$mysqli->set_charset("utf8")) {
    	printf("Error loading character set utf8: %s\n", $mysqli->error);
		exit();
	}
    function Query($select, $from, $where)
	{
    	global $mysqli;
	    if(mysqli_connect_errno())
	    {
	    	return "ERROR: ".mysqli_connect_errno()." ".mysqli_connect_error();
	    }
	    else
	    {
		    $qstring = "SELECT $select FROM $from WHERE $where";
		    if($where == null)
		    {
			    $qstring = "SELECT $select FROM $from";
		    }
			$res = mysqli_query($mysqli, $qstring);
			$rows = Array();
			$i = 0;
			while ($row = $res->fetch_assoc()) {
				$rows[$i] = $row;
				$i++;
			}
			return $rows;
	    }
	}
	function Update($table, $set, $where)
	{
    	global $mysqli;
	    if(mysqli_connect_errno())
	    {
	    	return "ERROR: ".mysqli_connect_errno()." ".mysqli_connect_error();
	    }
	    else
	    {
		    $qstring = "UPDATE $table SET $set WHERE $where";
			$res = mysqli_query($mysqli, $qstring) or die(mysqli_error($mysqli));
			return $res;
	    }
	}
	function Insert($into, $keys, $values)
	{
		global $mysqli;
	    if(mysqli_connect_errno())
	    {
	    	return "ERROR: ".mysqli_connect_errno()." ".mysqli_connect_error();
	    }
	    else
	    {
			$qstring = "INSERT INTO $into $keys VALUES $values;";
			mysqli_query($mysqli, $qstring) or die(mysqli_error($mysqli));
			return $mysqli->insert_id;
	    }
	}
	function Remove($from, $where)
	{
		global $mysqli;
	    if(mysqli_connect_errno())
	    {
	    	return "ERROR: ".mysqli_connect_errno()." ".mysqli_connect_error();
	    }
	    else
	    {
			$qstring = "DELETE FROM $from WHERE $where";
			//echo $qstring;
			$res = mysqli_query($mysqli, $qstring) or die(mysqli_error($mysqli));
			return $res;
	    }
	}
	function insertId()
	{
		global $mysqli;
		return $mysqli->insert_id;
	}
	?>