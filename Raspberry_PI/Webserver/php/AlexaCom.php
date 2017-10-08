<?php
	class AlexaCom { 
		
		function SendFunction($function)
		{
			$file = '/home/pi/Desktop/ALEXA/ComFile.txt';
			// Öffnet die Datei, um den vorhandenen Inhalt zu laden
			$current = file_get_contents($file);
			// Fügt eine neue Person zur Datei hinzu
			$current .= $function;
			// Schreibt den Inhalt in die Datei zurück
			file_put_contents($file, $current);
		}
		
		function GetStatus()
		{
			$file = '/home/pi/Desktop/ALEXA/StatusFile.txt';
			// Öffnet die Datei, um den vorhandenen Inhalt zu laden
			$status = file_get_contents($file);
			return $status;
		}
	}
?>