<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	require_once('voicerss_tts.php');
	require_once('mysql.php');
	$type = $_GET["type"];
	$name = strtolower($_GET["requestName"]);
	
	$errorName = "";
	$errorRequest = "";
	$errorSelect = "";
	$error = 0;
	
	if($type == 0) {
		$request = $_GET["requestText"];
	} else {
		$deviceID = $_GET["device"];
		$function = $_GET["function"];
		if($function == -1 || $deviceID == -1) {
			$error = 1;
			$errorSelect = "Bitte wähle ein Gerät und eiene Funktion aus!";
		}
		$request = GetFunctionTextForType($function, $deviceID);
	}
	
	
	//Check name input
	if(trim($name) == "")
	{
		$errorName = "Bitte gebe einen Namen für die Funktion ein!";
		$error = 1;
	}
	else
	{
		$existingFunctions = Query("*","functions","LOWER(`name`) = LOWER('$name')");
		if(!checkAllowedChars($name)){
			$errorName = "Bitte nur Buchstaben, Leerzeichen und Zahlen verwenden!";
			$error = 1;
		} else {
			if(count($existingFunctions) > 0) {
				$errorName = "Bitte gebe einen eindeutigen Namen ein!";
				$error = 1;
			}
		}
	}
	
	//Check request input
	if(trim($request) == "")
	{
		$errorRequest = "Bitte gebe einen Anfragetext ein!";
		$error = 1;
	}
	
	//If there was an error return tzo the Form page
	if($error == 1)
	{
		header("Location: ../addFunction.php?errorName=$errorName&errorRequest=$errorRequest&name=$name&request=$request&errorSelect=$errorSelect");
	}
	else
	{
		//otherwise create the audio file if it does not exist yet!
		$existing = Query("*","requests","`requestString` = '$request'");
		if(count($existing) == 1) {
			$requestID = $existing[0]["id"];
		} else {
			$requestID = createAudio($request);
		}
		//then create the function with the correct audio id
		Insert("functions","(`id`, `name`, `request_id`)","(NULL, '$name', $requestID)");
		//and finally return to the functions view
		header("Location: ../functions.php");
	}
	
	function GetFunctionTextForType($functionType, $deviceID) {
		switch($functionType) {
			case 0:
				return "starte smater mit gerät ".$deviceID;
				
			case 1:
				return "starte smater mit frage nach ".$deviceID;
		}
		return "";
	}
	
	function createAudio($text) {
		$file = generateRandomString().".wav";
		while(count(Query("*","requests","`file` = '$file'")) >= 1)
		{
			$file = generateRandomString().".wav";
		}
		$tts = new VoiceRSS;
		$voice = $tts->speech([
		    'key' => '7fb52bd7bec24ac5a67c961dea9c0019',
		    'hl' => 'de-de',
		    'src' => $text,
		    'r' => '0',
		    'c' => 'WAV',
		    'f' => '16khz_16bit_mono',
		    'ssml' => 'false',
		    'b64' => 'false'
		]);
		
		$myfile = fopen("../requestAudio/".$file, "w") or die("Unable to open file!");
		fwrite($myfile, $voice['response']);
		fclose($myfile);
		Insert("requests","(`id`, `file`, `requestString`)","(NULL, '$file', '$text')");
		return insertId();
	}
	
	function checkAllowedChars($string) {
		$characters = 'abcdefghijklmnopqrstuvwxyzäöü1234567890 ';
		for($i = 0; $i < strlen($string); $i++) {
			$found = false;
			for($j = 0; $j < strlen($characters); $j++) {
				if($characters[$j] == $string[$i]) {
					$found = true;
				}
			}
			if($found == false) {
				return false;
			}
		}
		return true;
	}
	
	function generateRandomString($length = 10) {
	    $characters = 'abcdefghijklmnopqrstuvwxyz';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	?>