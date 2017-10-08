<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ALEXA PI</title>

	<?php include("elements/styles.php"); ?>
	
	<?php
		$errorName = $_GET["errorName"];
		$errorRequest = $_GET["errorRequest"];
		$errorSelect = $_GET["errorSelect"];
		$name = $_GET["name"];
		$request = $_GET["request"];
		include_once("php/mysql.php");
		include_once("php/devices/hue/hue.php");
		$HueLink = new HueLink();
		$deviceList = $HueLink->GetDeviceList();
		?>
  </head>

  <body>

	<?php include("elements/navigation.php"); ?>

    <div class="container">
    	<div class='row'>
	    	<div class='col-12'>
		    	<h1>Funktion hinzufügen</h1>
		    	<p>Hier kann eine neue Funktion erstellt werden.</p>
		    	<form>
			    	
			    	<div class="panel">
				    	<label for="requestName">Anfragename</label>
				    	<input type="text" class="form-control" placeholder="Beispiel: Witz" name="requestName" id="requestName" value="<?php echo $name;?>">
					    <?php if($errorName != "") echo "<span class='text-danger'>$errorName</span>";?>
			    	</div>
			    	
			    	<div class="panel">
				    	<label for="command_Type">Anfragetyp</label>
				    	<select class="form-control" name="command_Type" id='command_Type'>
					    	<option value="0">Text</option>
					    	<option value="1">Gerätefunktion</option>
				    	</select>
			    	</div>
			    	
			    	<div id="text_area" style="display: none;" class="panel">
				    	<label for="requestText">Anfragetext</label>
						<div class="input-group">
				    		<input type="text" class="form-control" placeholder="Beispiel: erzähle mir einen witz" name="requestText" id='textCommandInput' value="<?php echo $request;?>">
							<span class="input-group-btn">
								<button onclick="SendTextCommand();" class="btn btn-warning" type="button">Funktion testen</button>
							</span>
					    </div>
						<?php if($errorRequest != "") echo "<span class='text-danger'>$errorRequest</span><br>";?>
			    	</div>
			    	
			    	<div id="geraet_area" style="display: none;" class="panel">
				    	<label for="device_select">Gerät/Funktion Auswählen</label>
				    	<div class="row">
					    	<div class="col-12 col-sm-5">
						    	<select class="form-control" name="device_select" id='device_select'>
							    	<?php
								    	echo "<option value='-1'>Gerät</option>";
								    	for($i = 0; $i < count($deviceList); $i++) {
								    		echo "<option value='".$deviceList[$i]["internal_id"]."'>".$deviceList[$i]["name"]."</option>";
								    	}
								    	?>
						    	</select>
					    	</div>
					    	<div class="col-2 text-center">
						    	<i class="fa fa-arrow-right fa-2x" aria-hidden="true"></i>
					    	</div>
					    	<div class="col-10 col-sm-5">
						    	<select class="form-control" name="function_select" id="function_select">
						    	</select>
					    	</div>
				    	</div>
						<?php if($errorSelect != "") echo "<span class='text-danger'>$errorSelect</span><br>";?>
			    	</div>
			    	<br>
			    	<a href='#' class="btn btn-primary" onclick="submit(); return false;">Funktion erstellen</a>
		    	</form>
		    	<hr>
	    	</div>
    	</div>
    </div><!-- /.container -->

	<?php include("elements/footer.php"); ?>

	<?php include("elements/scripts.php"); ?>


	<script type="text/javascript">
		<?php
			if($errorSelect != "") {
				echo "var visible = 1;";
			} else {
				echo "var visible = 0;";
			}
			?>
		var curSelected = -1;
		var curFunctionSelect = -1;
		
		$( "#command_Type" ).change(function () {
			visible = $( "#command_Type option:selected" ).val();
			checkTypeSelect();
		});
		$( "#device_select" ).change(function () {
			curSelected = $( "#device_select option:selected" ).val();
			checkSelectedDevice();
		});
		$( "#function_select" ).change(function () {
			curFunctionSelect = $( "#function_select option:selected" ).val();
		});
		checkTypeSelect();
		checkSelectedDevice();
		
		function checkSelectedDevice() {
			
			curFunctionSelect = -1;
			if(curSelected != -1) {
				$('#function_select').html("<option>Funktion</option>");
				$('#function_select').prop('disabled', true);
				$('#function_select').load("php/getDeviceFunctions.php?deviceId="+curSelected,function(){
					$('#function_select').prop('disabled', false);
				});
			} else {
				$('#function_select').html("<option>Funktion</option>");
				$('#function_select').prop('disabled', true);
			}
		}
		
		function checkTypeSelect() {
			if(visible == 0) {
				$('#text_area').show();
				$('#geraet_area').hide();
			} else {
				$('#text_area').hide();
				$('#geraet_area').show();
			}
		}
		
		function submit() {
			var requestName = $("#requestName").val();
			var end = "&requestText="+$("#textCommandInput").val();
			if(visible == 1) {
				end = "&function="+curFunctionSelect+"&device="+curSelected;
			}
			window.location.href = "php/createFunction.php?requestName="+requestName+"&type="+visible+end;
		}
		
		function SendTextCommand(){
			var text = $('#textCommandInput').val();
			$.ajax({
			    type: 'POST',
			    url: 'server.php',
			    dataType: "json",
			    data: { 
			        'function': 'TextCommand',
			        'text': text
			    }
			}).done(function(responce) {
				if(responce.Responce == "Success") {
					console.log(responce.Status_Message);
				} else {
					console.log(responce.Error_Message);
				}
			});
		}
	</script>
  </body>
</html>
