<?php
	
	include_once("mysql.php");
	
	$function = $_POST["f"];
	$function .= $_GET["f"];
	
	if($function != "")
	{
		header("Content-Type: application/JSON");
		switch($function) {
			case "deviceList":
				getDevices();
				break;
			case "obtainKey":
				getKey();
				break;
			case "actions":
				getActions();
				break;
			case "update_list":
				updateList();
				break;
			case "verifyKey":
				verifyKeyReturn();
				break;
			case "execute":
				executeAction();
				break;
			case "function":
				executeFunction();
				break;
			default:
				returnError("UnknownFunction");
			break;
		}
	}
	
	function updateList() {
		$id = verifyKey();
		if($id == -1) {
			returnError("Invalid Api Key");
		} else {
			$deviceList = $_POST["deviceList"];
			Remove("devices","user_id = $id");
			for($i = 0; $i < count($deviceList); $i++) {
				$device = $deviceList[$i];
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
				Insert("devices","(`id`, `user_id`, `internal_id`, `unique_id`, `name`, `state`, `reachable`, `type`, `model`, `bridge_name`, `bridge_ip`, `key`)","(NULL, $id, $internal_id, '$unique_id', '$name', '$state', '$reachable', '$type', '$model', '$bridge_name', '$bridge_ip', '$key')");
			}
			returnSuccess("Updated List");
		}
	}
	
	function verifyKeyReturn() {
		if(verifyKey() != -1){
			returnSuccess("success");
		} else {
			returnError("Der API Key ist nicht gültig.");
		}
	}
	
	function verifyKey() {
		$key = $_POST["key"].$_GET["key"];
		$rows = Query("*","users","`key` = '$key'");
		if(count($rows) == 1) {
			return $rows[0]["id"];
		} else {
			return -1;
		}
	}
	
	function getActions() {
		$id = verifyKey();
		if($id == -1) {
			returnError("Invalid Api Key");
		} else {
			$actionsQuery = Query("*","actions","user_id = $id");
			for($i = 0; $i < count($actionsQuery); $i++) {
				Remove("actions","id = ".$actionsQuery[$i]["id"]);
			}
			returnSuccess($actionsQuery);
		}

	}
	
	function getKey() {
		$username = $_POST["user"].$_GET["user"];
		$password = $_POST["pass"].$_GET["pass"];
		$rows = Query("*","users","`username` = '$username' and `password` = '$password'");
		if(count($rows) == 1)
		{
			returnSuccess($rows[0]["key"]);
		}
		else
		{
			returnError("IncorrectLogin");
		}
	}
	
	function getDevices() {
		$id = verifyKey();
		if($id == -1) {
			returnError("Invalid Api Key");
		} else {
			$deviceQuery = Query("*","devices","user_id = $id");
			$devices = array();
			if(count($deviceQuery) > 0) {
				for($i = 0; $i < count($deviceQuery); $i++) {
					$devices[$i] = array(
						"name"=>$deviceQuery[$i]["name"],
						"type"=>$deviceQuery[$i]["type"],
						"state"=>$deviceQuery[$i]["state"],
						"internalId"=>$deviceQuery[$i]["internal_id"]
					);
				}
				returnSuccess($devices);
			} else {
				returnError("NoDevices");
			}
		}
	}
	
	function executeAction() {
		$id = verifyKey();
		if($id == -1) {
			returnError("Invalid Api Key");
		} else {
			$state = $_GET["state"].$_POST["state"];
			$deviceid = $_GET["deviceid"].$_POST["deviceid"];
			$r = $_GET["r"].$_POST["r"];
			$g = $_GET["g"].$_POST["g"];
			$b = $_GET["b"].$_POST["b"];
			if($r == ""){
				$r = "255";
			}
			if($g == ""){
				$g = "255";
			}
			if($b == ""){
				$b = "255";
			}
			if($state == "off") {
				//Turn off action
				Insert("actions","(`id`, `user_id`, `device`, `state`, `r`, `g`, `b`, `actionText`)","(NULL,$id,$deviceid,'off',0,0,0,'Turn $deviceid Off')");
			} else {
				//Turn on action / Set Color Action
				Insert("actions","(`id`, `user_id`, `device`, `state`, `r`, `g`, `b`, `actionText`)","(NULL,$id,$deviceid,'on',$r,$g,$b,'Turn $deviceid on RGB($r,$g,$b)')");
			}
			returnSuccess("created Action");
		}
	}
	
	function executeFunction() {
		$id = verifyKey();
		if($id == -1) {
			returnError("Invalid Api Key");
		} else {
			$state = $_GET["func_id"].$_POST["func_id"];
			if(trim($state) == "") {
				returnError("Please enter a valid function ID under 'func_id'");
			} else {
				$deviceid = "-1";
				Insert("actions","(`id`, `user_id`, `device`, `state`, `r`, `g`, `b`, `actionText`)","(NULL,$id,$deviceid,'$state',0,0,0,'Execute Function with ID $state')");
				returnSuccess("created Action");
			}
		}
	}
	
	function returnSuccess($data) {
		echo json_encode(array("responce"=>array("type"=>"SUCCESS","data"=>$data)));
		return;
	}
	
	function returnError($message) {
		echo json_encode(array("responce"=>array("type"=>"ERROR","message"=>$message)));
		return;
	}
?>

<?php if($function == "") {?>
<html>
	<head>
		  <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="css/bootstrap.min.css">
	    <style>
		    body {
			    padding-top: 25px;
		    }
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1>SMATER Webserver</h1>
					<div id='keyOutput'>
						<form>
							<label>Benutzername</label>
							<input type="text" id="username" class="form-control">
							<br>
							<label>Passwort</label>
							<input type="password" id="password" class="form-control"><br>
							<p class="text-danger" id='error_text'></p>
							<a href='#' onclick="submitForm(); return false;" class="btn btn-primary">API Schlüssel anfragen</a>
							<a href='register.php' class="btn btn-secondary">Registrieren</a>
						</form>
						<br>
						
					</div>
				</div>
			</div>
		</div>
		<script>
			
			function submitForm() {
				var xmlhttp=false;
				loadXMLDoc('index.php?f=obtainKey&user='+document.getElementById("username").value+'&pass='+document.getElementById("password").value);
			}
			
			function loadXMLDoc(theURL)
		    {
		        if (window.XMLHttpRequest)
		        {// code for IE7+, Firefox, Chrome, Opera, Safari, SeaMonkey
		            xmlhttp=new XMLHttpRequest();
		        }
		        else
		        {// code for IE6, IE5
		            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		        }
		        xmlhttp.onreadystatechange=function()
		        {
		            if (xmlhttp.readyState==4 && xmlhttp.status==200)
		            {
		                var data = JSON.parse(xmlhttp.responseText);
		                if(data.responce.type == "ERROR") {
			                document.getElementById("error_text").innerHTML = "Falsche Benutzername/Passwort Kombination";
		                } else {
			                document.getElementById("keyOutput").innerHTML = "<h3>API Key:</h3>"+data.responce.data;
		                }
		            }
		        }
		        xmlhttp.open("GET", theURL, false);
		        xmlhttp.send();
		    }
		</script>
	</body>
<html>
<?php } ?>