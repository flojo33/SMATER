
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ALEXA PI</title>

	<?php include("elements/styles.php"); ?>
  </head>

  <body>

    <?php include("elements/navigation.php");?>

    <div class="container">

      <div class="starter-template">
        
        <div class="row">
			<div class="col-12">
				<h1 class='text-primary'>TUM - Fakultät für Informatik</h1>
				<br>
			</div>
			<div class="col-md-6 col-12">
				 <h4>Verknüpfung von Sprachsteuerungen mit anderen Steuerungsmethoden in intelligenten Umgebungen</h4>
			</div>
			<div class="col-md-6 col-12">
				<h4 class="text-muted">Connecting speech assistants to other control methods in intelligent spaces</h4>
			</div>
		</div>
		<br>
		<div class="row justify-content-md-center">
			<div class="col-md-6 col-12">
				<table class="table">
					<tr><td class="text-right">Bearbeiter</td><td class="text-left">Florian Bayer</td></tr>
					<tr><td class="text-right">Aufgabensteller</td><td class="text-left">Prof. Gudrun Klinker, Ph.D.</td></tr>
					<tr><td class="text-right">Betreuer</td><td class="text-left">Sandro Weber</td></tr>
					<tr><td class="text-right">Abgabedatum</td><td class="text-left">15. Oktober 2017</td></tr>
				</table>
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<h2 class='text-primary'>Abstrakt</h2>
			</div>
			<div class="col-md-6 col-12">
				<p class="text-justify">
		In der Arbeit soll es darum gehen, einen Sprachassistenten mit einem neuartigen Interface zu verbinden, welches es ermöglicht, bestimmte Funktionen des Sprachassistenten durch externe Steuerungsmethoden auszulösen. Im ersten Schritt muss die Verwendbarkeit der aktuellen Sprachassistenten geprüft und verglichen werden. Im nächsten Schritt soll der Sprachassistent auf einem kleinen Entwicklungsboard wie z.B. einem Raspberry Pi zum Laufen gebracht werden und folgend so modifiziert werden, dass er durch ein einfaches Webinterface getriggert und gesteuert werden kann. Sobald diese Funktionalität geschaffen ist, kann das Webinterface so erweitert werden, dass andere Steuerungsmethoden einfach auf das System zugreifen können. Hierbei soll es zudem möglich sein, Geräte über das Webinterface zu konfigurieren und deren Auslösemöglichkeiten einzustellen.</p>
			</div>
			<div class="col-md-6 col-12">
				<p class="text-justify text-muted">The focus of this thesis is to create a new type of interface, allowing speech assistants to be triggered and controlled by external control methods. At first the usability of the different available speech assistants have to be compared. In the next step the speech assistant should be implemented on a small development board like the Raspberry Pi. After that the speech assistant should be modified so that it can be triggered and controlled from an external web interface. As soon as this functionality has been implemented, the web interface can be expanded, making it easy for other control methods to interact with the speech assistant. Configuring devices and setting up their triggering behavior over the web interface should also be made possible in further development.
				</p>
			</div>
		</div>
		<br>
		<br>
		<div class="row justify-content-md-center">
			<div class="col-12">
				<h2 class='text-primary'>Referenzen</h2>
			</div>
			<div class="col-md-6 col-12">
				<table class="table">
					<tr><td class="text-right">Amazon ALEXA</td><td class="text-left"><a href="https://www.amazon.de/dp/B01GAGVCUY/">ECHO Produkt Seite</a></td></tr>
					<tr><td class="text-right">Amazon AVS Quellcode</td><td class="text-left"><a href="https://github.com/alexa/alexa-avs-sample-app">Github Projekt</a></td></tr>
					<tr><td class="text-right">TTS Sprachsynthese</td><td class="text-left"><a href="http://www.voicerss.org/tts/">Voice RSS</a></td></tr>
				</table>
				<br>
			</div>
		</div>
      </div>

    </div><!-- /.container -->
    
    <?php include("elements/footer.php");?>

    <?php include("elements/scripts.php");?>
    
	</script>
  </body>
</html>
