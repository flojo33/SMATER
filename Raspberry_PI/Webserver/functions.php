<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMATER</title>
    <?php include("elements/styles.php");?>
  </head>

  <body>

    <?php include("elements/navigation.php");?>

    <div class="container">
    	<div class='row'>
	    	<div class='col-12'>
		    	<h1>Funktionen</h1>
		    	<p>Hier kann eine Funktion erstellt werden. Eine Funktion kann durch einen externen Trigger ausgelöst werden. Für mehr Informationen wenden Sie sich bitte an die <a href="api.php">Dokumentation</a></p>
		    	<a href='addFunction.php' class='btn btn-primary'><i class='fa fa-plus'></i> Neue Funktion erstellen</a><br>
		    	<hr>
		    	<p>Ihre aktiven Funktionen werden nachfolgend aufgelistet. Klicken Sie auf "Entfernen" um einen Funktion zu löschen. Klicken Sie auf "ausführen" um die Funktion zu testen.</p>
		    	<div id='functionsTable' class='table-responsive-container'></div>
	    	</div>
    	</div>
    </div><!-- /.container -->

    <?php include("elements/scripts.php");?>

    <?php include("elements/footer.php");?>

	<script type="text/javascript">
		$('#functionsTable').load("php/functionsTable.php");
		
		function SendText(command)
		{
			$('#textCommandInput').val(command);
			$.ajax({
			    type: 'POST',
			    url: 'server.php',
			    dataType: "json",
			    data: { 
			        'function': 'TextCommand',
			        'text': command
			    }
			}).done(function(responce) {
				if(responce.Responce == "Success") {
					console.log(responce.Status_Message);
				} else {
					console.log(responce.Error_Message);
				}
			});
		}
		
		function RemoveFunction(id)
		{
			$.ajax({
			    type: 'POST',
			    url: 'php/deleteFunction.php',
			    dataType: "json",
			    data: { 
			        'id': id
			    }
			}).done(function(responce) {
				console.log("deleted Function id: "+id);
				$('#functionsTable').load("php/functionsTable.php");
			});
		}
	</script>
  </body>
</html>
