
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMATER</title>

	<?php include("elements/styles.php"); ?>
  </head>

  <body>

    <?php include("elements/navigation.php");?>

     <div class="container">
    	<div class='row'>
	    	<div class='col-12'>
		    	<h1>Dokumentation</h1>
		    	<div class="panel">
		    		<h2>Requests</h2>
					<p>Eine "Request" wird hier als eine anfrage an den ALEXA dienst bezeichnet. "Requests" werden automatisch beim einrichten und testen von Funktionen erstellt.</p>
		    	</div>
		    	<div class="panel">
		    		<h2>Functions</h2>
					<p>Funktionen werden durch drei Eigenschaften beschrieben. Die Funktions-ID (id), den Funktionsnamen (name) und die Funktionsanfrage (request).</p>
					<ul>
			    		<li>
			    			<span class="text-tertiary">id:</span>
			    			<p>Die id wird verwendet um Funktionen von externen Triggern auszuführen</p>
			    		</li>
			    		<li>
			    			<span class="text-tertiary">name:</span>
			    			<p>Der name einer Funktion wird verwendet um diese zu beschreiben</p>
			    		</li>
			    		<li>
			    			<span class="text-tertiary">request:</span>
			    			<p>Die Anfrage wird verwendet um ALEXA zu sagen was Sie tun soll. Sie besteht aus dem Anfragetext und der Sprachdatei. Die Sprachdatei wird automatisch beim erstellen einer Funktion kreiert</p>
			    		</li>
		    		</ul>
		    	</div>
	    	</div>
    	</div>
    </div><!-- /.container -->

    </div><!-- /.container -->
    
    <?php include("elements/footer.php");?>

    <?php include("elements/scripts.php");?>
    
	</script>
  </body>
</html>
