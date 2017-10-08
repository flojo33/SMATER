<?php
	include_once("php/AlexaCom.php");
	include_once("php/mysql.php");
	require_once('php/voicerss_tts.php');
	
	$alexa = new AlexaCom();
	
	function checkInput()
	{
		if(!isset($_POST["function"])&&!isset($_GET["function"]))
		{
			EchoError(1,"no function specified");
		}
		else
		{
			$function = $_POST["function"];
			$function .= $_GET["function"];
			
			if($function == "Trigger")
			{
				Trigger();
				return;
			}
			
			if($function == "StartListening")
			{
				startListening();
				return;
			}
			
			if($function == "TextCommand")
			{
				TextCommand();
				return;
			}
			
			if($function == "FunctionCommand")
			{
				FunctionCommand();
				return;
			}
			
			if($function == "DeviceList")
			{
				DeviceList();
				return;
			}
			EchoError(2,"unknown function");
			return;
		}
	}
	
	function TextCommand() {
		global $alexa;
		if(!isset($_POST["text"])&&!isset($_GET["text"]))	{
			EchoError(1,"no text specified");
		} else {
			$text = $_POST["text"];
			$text .= $_GET["text"];
			if($text == "") {
				EchoError(1,"no text specified");
			} else {
				$existing = Query("*","requests","`requestString` = '$text'");
				if(count($existing) == 1) {
					$filepath = $existing[0]["file"];
				} else {
					$filepath = createAudio($text);
				}
				$alexa->SendFunction("text_command ".$filepath." $text");
				EchoSuccess(array(),"told Alexa: '".$text."'. The generated Audio file is in '".$filepath."'. File Existed: ".count($existing));
			}
		}
	}
	
	function FunctionCommandInternal($function) {
		global $alexa;
		$cmd = Query("*","requests","`id` = $function")[0];
		$filepath = $cmd["file"];
		$text = $cmd["requestString"];
		$alexa->SendFunction("text_command ".$filepath." ".$text);
		EchoSuccess(array(),"executed Function with id $function");
	}
	
	function FunctionCommand() {
		global $alexa;
		if(!isset($_POST["function_id"])&&!isset($_GET["function_id"]))	{
			EchoError(1,"no function specified");
		} else {
			$function = $_POST["function_id"];
			$function .= $_GET["function_id"];
			if($function == "") {
				EchoError(1,"no function specified");
			} else {
				FunctionCommandInternal($function);
			}
		}
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
		
		$myfile = fopen("requestAudio/".$file, "w") or die("Unable to open file!");
		fwrite($myfile, $voice['response']);
		fclose($myfile);
		Insert("requests","(`id`, `file`, `requestString`)","(NULL, '$file', '$text')");
		return $file;
	}
	
	function StartListening()
	{
		global $alexa;
		$alexa->SendFunction("start_listening");
		EchoSuccess(array(),"told Alexa to start listening.");
	}
	
	function Trigger()
	{
		EchoSuccess(array(),"triggered device ".$_POST["device"]);
	}
	
	function DeviceList()
	{
		$device1 = array('id' => '214653214', 'name' => 'Table Lamp 1', 'type' => 'lamp_simple');
		$device2 = array('id' => '986414314', 'name' => 'Table Lamp 2', 'type' => 'lamp_hue');
		$device3 = array('id' => '986414314', 'name' => 'TV 1', 'type' => 'television');
		$devices = array($device1, $device2, $device3);
		EchoSuccess(array('devices' => $devices),"returned devicelist");
	}
	
	function EchoSuccess($data, $statusText)
	{
		header('Content-Type: application/json');
		echo json_encode(array('Responce' => 'Success' ,'Data' => $data, 'Status_Message' => $statusText));
	}
	
	function EchoError($errorCode, $message)
	{
		header('Content-Type: application/json');
		echo json_encode(array('Responce' => 'Error' ,'Data' => array('ErrorCode' => $errorCode,'ErrorMessage' => $message)));
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