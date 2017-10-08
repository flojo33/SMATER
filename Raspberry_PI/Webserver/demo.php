<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ALEXA PI</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">ALEXA PI</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">About</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="functions.php">Functions <span class="sr-only">(current)</span></a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container">
    	<div class='row'>
	    	<div class='col-12'>
		    	<h1>Functions</h1>
		    	<p>All the capabilities of the ALEXA PI app have been collected for testing below.</p>
		    	<hr>
		    	<h2>Start Listening</h2>
		    	<p>Press the button below to tell Alexa to start listening to what you say.</p>
		    	<a href="#" class='btn btn-primary' onclick="startListening();">Start Listening</a>
		    	<hr>
		    	<h2>Send Text Command</h2>
		    	<p>Type in a text in the field below then press the send button. Alexa will respond to the text as if you said it.</p>
		    	<div class="input-group">
					<input type="text" class="form-control" placeholder="Enter text command here" aria-label="Enter text command here" id="textCommandInput">
					<span class="input-group-btn">
						<button onclick="SendTextCommand();" class="btn btn-primary hover" type="button">Send Text Command</button>
					</span>
				</div>
				<br>
				<div class="card">
				    <h4 class="card-header">Recently used</h4>
				    <div class="card-body">
				    	<div id="recents"></div>
				    </div>
				</div>
	    	</div>
    	</div>
    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


	<script type="text/javascript">
		reloadRecents();		
		function startListening() {
			$.ajax({
			    type: 'POST',
			    url: 'server.php',
			    dataType: "json",
			    data: { 
			        'function': 'StartListening'
			    }
			}).done(function(responce) {
				if(responce.Responce == "Success") {
					console.log(responce.Status_Message);
				} else {
					console.log(responce.Error_Message);
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
					reloadRecents();
					console.log(responce.Status_Message);
				} else {
					console.log(responce.Error_Message);
				}
			});
		}
		
		function reloadRecents()
		{
			$("#recents").load("getRecentCommands.php");
		}
	</script>
  </body>
</html>
