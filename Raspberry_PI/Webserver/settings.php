
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMATER</title>

	<?php include("elements/styles.php"); ?>
	<?php 
		include_once("php/mysql.php");
		$curKey = Query("*","settings")[0]["value"];
		?>
  </head>

  <body>

    <?php include("elements/navigation.php");?>

     <div class="container">
    	<div class='row'>
	    	<div class='col-12'>
		    	<h1>Einstellungen</h1>
		    	<div class="panel">
		    		<h2>API Schlüssel</h2>
					<p>Bitte gebe hier deinen API Schlüssel ein. Ohne Ihn kann ALEXA keine Verbindung zu diesem Gerät herstellen. Falls du dich noch nicht für einen API Schlüssel registriert hast kannst du dies unter <a href='http://smater.diebayers.de/register.php'>http://smater.diebayers.de/register.php</a> tun.</p>
					<div class="input-group">
						<input type="text" class="form-control" id='key_input' onClick='this.setSelectionRange(0, this.value.length)' value="<?php echo $curKey; ?>">
						<span class="input-group-addon bg-white" id="status"><i class="fa fa-refresh fa-spin fa-fw"></i></span>
					</div>
					
		    	</div>
	    	</div>
    	</div>
    </div><!-- /.container -->

    </div><!-- /.container -->
    
    <?php include("elements/footer.php");?>

    <?php include("elements/scripts.php");?>
    <script>
	    checkAPI();
	    $("#key_input").on("change paste keyup", function() {
		    checkAPI();
		});
		function checkAPI()
		{
		    $("#status").html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
			$.ajax({
			    type: 'POST',
			    url: 'php/update_api_key.php?key='+$("#key_input").val(),
			    data: {
			    }
			}).done(function(responce) {
				if(responce == "success")
				{
					$("#status").html('<i class="fa fa-check text-success" aria-hidden="true"></i>');
				}
				else
				{
					$("#status").html('<i class="fa fa-times text-danger" aria-hidden="true"></i>');
				}
			});
		}
	</script>
  </body>
</html>
