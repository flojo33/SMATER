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
		    	<h1>Geräte</h1>
		    	<p>Hier werden alle Geräte angezeigt die Sie momentan mit SMATER verwenden können.</p>
		    	<div id='linkedDeviceTable' class='table-responsive-container'></div>
		    	<hr>
		    	<p>Alle verknüpfbaren SmartHome Links erscheinen hier.</p>
		    	<div id='deviceTable' class='table-responsive-container'></div>
	    	</div>
    	</div>
    </div><!-- /.container -->

    <?php include("elements/scripts.php");?>

    <?php include("elements/footer.php");?>

	<script type="text/javascript">
		$('#linkedDeviceTable').load("php/devices/availableLinkedDevicesTable.php");
		$('#deviceTable').load("php/devices/availableDevicesTable.php");
		
		CheckReload();
		
		function switchHueLight(ip, id, on)
		{
			$.ajax({
			    type: 'POST',
			    url: 'php/devices/hue/switchLight.php',
			    data: { 
			        'ip': ip,
			        'id': id,
			        'on': on
			    }
			}).done(function(responce) {
				if(responce == "success")
				{
					$('#linkedDeviceTable').load("php/devices/availableLinkedDevicesTable.php");
				}
				else
				{
					alert(responce);
				}
			});
		}
		
		function linkHue(ip)
		{
			$.ajax({
			    type: 'POST',
			    url: 'php/devices/hue/tryLink.php',
			    data: { 
			        'ip': ip
			    }
			}).done(function(responce) {
				if(responce == "success")
				{
					$('#linkedDeviceTable').load("php/devices/availableLinkedDevicesTable.php");
					$('#deviceTable').load("php/devices/availableDevicesTable.php");
				}
				else
				{
					alert(responce);
				}
			});
		}
		
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
		function CheckReload()
		{
			$.ajax({
			    type: 'POST',
			    url: 'php/checkReload.php'
			}).done(function(responce) {
				if(responce == "true")
				{
					console.log("reloading");
					$('#linkedDeviceTable').load("php/devices/availableLinkedDevicesTable.php");
				}
			});
			setTimeout(function(){CheckReload()}, 500);
		}
	</script>
  </body>
</html>
