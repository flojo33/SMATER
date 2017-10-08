<html>
	<head>
	<style>
		body
		{
			background-color: black;
		}
		/* Status Display */
		.Status
		{
			cursor: pointer;
			vertical-align: top;
			width: 100px;
			height: 100px;
			left: -75px;
			top: -75px;
			position: relative;
			border-radius: 75px;
			background-color: #0569A6;
			border: 25px double #2b2b2b;
			-webkit-transition: all 0.5s ease;
			-moz-transition: all 0.5s ease;
			-o-transition: all 0.5s ease;
			transition: all 0.5s ease;
			box-shadow: 0px 0px 3px black;
		}
		
		.Status:hover
		{
			background-color: #25B8D5;
		}
		.Status.Listening,.Status.Processing,.Status.Talking
		{
			border: 5px double #2b2b2b;
			width: 140px;
			height: 140px;
			-webkit-transition: all 0.5s ease;
			-moz-transition: all 0.5s ease;
			-o-transition: all 0.5s ease;
			transition: all 0.5s ease;
		}
		
		.container {
			left:50%;
			top:50%;
			width: 0;
			height: 0;
			position: relative;
			overflow: visible;
		}
		
		.Status.Listening {
		  -webkit-animation: Listening 1s linear infinite; /* Safari 4+ */
		  -moz-animation:    Listening 1s linear infinite; /* Fx 5+ */
		  -o-animation:      Listening 1s linear infinite; /* Opera 12+ */
		  animation:         Listening 1s linear infinite; /* IE 10+, Fx 29+ */
		}
		
		.Status.Processing {
		  -webkit-animation: Processing 1s linear infinite; /* Safari 4+ */
		  -moz-animation:    Processing 1s linear infinite; /* Fx 5+ */
		  -o-animation:      Processing 1s linear infinite; /* Opera 12+ */
		  animation:         Processing 1s linear infinite; /* IE 10+, Fx 29+ */
		}
		
		.Status.Talking {
		  -webkit-animation: Talking 0.5s linear infinite; /* Safari 4+ */
		  -moz-animation:    Talking 0.5s linear infinite; /* Fx 5+ */
		  -o-animation:      Talking 0.5s linear infinite; /* Opera 12+ */
		  animation:         Talking 0.5s linear infinite; /* IE 10+, Fx 29+ */
		}
		
		@-webkit-keyframes Listening {
		  0%   { background-color: #F29717; }
		  50%   { background-color: #000000; }
		  100%   { background-color: #F29717; }
		}
		@-moz-keyframes Listening {
		  0%   { background-color: #F29717; }
		  50%   { background-color: #000000; }
		  100%   { background-color: #F29717; }
		}
		@-o-keyframes Listening {
		  0%   { background-color: #F29717; }
		  50%   { background-color: #000000; }
		  100%   { background-color: #F29717; }
		}
		@keyframes Listening {
		  0%   { background-color: #F29717; }
		  50%   { background-color: #000000; }
		  100%   { background-color: #F29717; }
		}
		
		@-webkit-keyframes Processing {
		  0%   { background-color: #00eaff; }
		  100%   { background-color: #001fff; }
		}
		@-moz-keyframes Processing {
		  0%   { background-color: #00eaff; }
		  100%   { background-color: #001fff; }
		}
		@-o-keyframes Processing {
		  0%   { background-color: #00eaff; }
		  100%   { background-color: #001fff; }
		}
		@keyframes Processing {
		  0%   { background-color: #00eaff; }
		  100%   { background-color: #001fff; }
		}
		
		@-webkit-keyframes Talking {
		  0%   { background-color: #00ff12; }
		  50%   { background-color: #eeff00; }
		  100%   { background-color: #00ff12; }
		}
		@-moz-keyframes Talking {
		  0%   { background-color: #00ff12; }
		  50%   { background-color: #eeff00; }
		  100%   { background-color: #00ff12; }
		}
		@-o-keyframes Talking {
		  0%   { background-color: #00ff12; }
		  50%   { background-color: #eeff00; }
		  100%   { background-color: #00ff12; }
		}
		@keyframes Talking {
		  0%   { background-color: #00ff12; }
		  50%   { background-color: #eeff00; }
		  100%   { background-color: #00ff12; }
		}
	</style>
	</head>
	<body>
		<div class="container">
			<div id="ALEXAStatus" class="Status"></div>
		</div>
		<?php include("elements/scripts.php");?>
	</body>
</html>