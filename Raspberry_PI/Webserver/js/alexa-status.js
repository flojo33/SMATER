var Frequency = 200; //MS
var curStatus = "";

SetStatus();
CheckStatus();

$('#ALEXAStatus').click(function(){
	startListening();
});

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

function CheckStatus()
{
	$.get('php/GetStatus.php', function (newStatus) {
		SetStatus(newStatus);
	});
	
	setTimeout(function(){
		CheckStatus();
	}, Frequency);
}


function SetStatus(newStatus)
{
	//console.log("Setting Status: "+newStatus);
	if(curStatus != newStatus)
	{
		curStatus = newStatus;
		switch(curStatus)
		{
			case "":
				$('#ALEXAStatus').removeClass("Listening");
				$('#ALEXAStatus').removeClass("Processing");
				$('#ALEXAStatus').removeClass("Talking");
			break;
			case "LISTENING":
				$('#ALEXAStatus').addClass("Listening");
			break;
			case "PROCESSING":
				$('#ALEXAStatus').addClass("Processing");
			break;
			case "TALKING":
				$('#ALEXAStatus').addClass("Talking");
			break;
			default:
				$('#ALEXAStatus').removeClass("Listening");
				$('#ALEXAStatus').removeClass("Processing");
				$('#ALEXAStatus').removeClass("Talking");
			break;
		}
	}
}