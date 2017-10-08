var https = require('https');
var http = require("http");

var asked = false;
var DeviceName = "";
var DeviceState = "";
var deviceId = -1;

var APIKEY = "";

//Main Handler 
exports.handler = (event, context) => {
    'use strict';
	try {
		if (event.session.new) {
			// New Session
			console.log("NEW SESSION");
			reset();
		}
		switch (event.request.type) {
			case "LaunchRequest":
				// Launch Request
				context.succeed(
					generateResponse(
						buildSpeechletResponse("willkommen bei smater", true),{}
					)
				);
			break;
			case "IntentRequest":
				switch(event.request.intent.name) {
					//Initial Case incl. asking color.   
					case "fragend_mit":
						console.log("Gerät: "+event.request.intent.slots.device.value);
						if(event.request.intent.slots.device.value !== null) {
							deviceId = event.request.intent.slots.device.value;
							getDevices(context,APIKEY,true);
						} else {
							exitError(context);
						}
					break;
					//Initial Case without asking color just turn on.
					case "mit":
						console.log("Gerät: "+event.request.intent.slots.device.value);
						if(event.request.intent.slots.device.value !== null) {
							deviceId = event.request.intent.slots.device.value;
							getDevices(context,APIKEY,false);
						} else {
							exitError(context);
						}
					break;
					
					case "colorTold":
					//Answer to the Question what color a light should have. Returns an error if the user hasent asked for a light to be switched.
						if(asked) {
							var color = event.request.intent.slots.color.value;
							setColor(context,color,APIKEY);
						} else {
							context.succeed(
								generateResponse(
									buildSpeechletResponse(`Bitte sage mir zuerst um welche lampe es sich handeln soll.`, true),{}
								)
							);
						}
					break;
					//Unknown Case... Tell the user that there was a misunderstanding
					default:
						exitError("Ich weiss nicht was das bedeuten soll.");
					break;
				}
			break;
			case "SessionEndedRequest":
				exitError("Auf wiederhören.");
			break;
			default:
				exitError("Ich weiss nicht was das bedeuten soll.");
			break;
		}
	} catch(error) {
		exitError(`Ein Fehler ist aufgetreten. ${error}`);
	}
};

// Helpers

buildSpeechletResponse = (outputText, shouldEndSession) => {
    'use strict';
	return {
		outputSpeech: {
			type: "PlainText",
			text: outputText
		},
		shouldEndSession: shouldEndSession
	};
};

getDevices = (context, apiKey, ask) => {
    'use strict';
    var url = "http://smater.diebayers.de/?f=deviceList&key=" + apiKey;
    console.log('start request to ' + url);
    http.get(url, function(res) {
        res.on("data", function(chunk) {
            var data = JSON.parse(chunk);
            console.log("Responce type: "+data.responce.type);
            if(data.responce.type == "SUCCESS") {
                var deviceArray = data.responce.data;
                deviceArray.forEach(function(value){
                    var id = value.internalId;
                    
                    if(""+id === ""+deviceId) {
                        DeviceName = value.name;
                        DeviceState = value.state;
                    }
                });
                if(DeviceName === "") {
                    exitError(context, "Das Gerät konnte nicht gefunden werden.");
                } else {
                    if(DeviceState == "on") {
                        setState(context,APIKEY,"off");
                    } else {
                        if(ask) {
                            asked = true;
                            context.succeed(
                                generateResponse(
                                    buildSpeechletResponse(`Welche farbe soll ${DeviceName} haben?`, false),{}
                                )
                            );
                        } else {
                            setState(context,APIKEY,"on");
                        }
                    }
                }
            } else {
                exitError(context, "Der smater server hat nicht richtig geantwortet");
            }
        });
    }).on('error', function(e) {
        exitError(context, "Die verbindung mit dem smater server konnte nicht hergesetellt werden.");
    });
};

setState = (context, apiKey, state) => {
    'use strict';
    var url = "http://smater.diebayers.de/?f=execute&state="+state+"&deviceid="+deviceId+"&key="+apiKey;
    console.log('start request to ' + url);
    http.get(url, function(res) {
        res.on("data", function(chunk) {
            console.log("Responce raw: "+chunk);
            var data = JSON.parse(chunk);
            console.log("Responce type: "+data.responce.type);
            var stateText = "aus";
            if(state === "on") {
                stateText = "an";
            }
            if(data.responce.type == "SUCCESS") {
                context.succeed(
                    generateResponse(
                        buildSpeechletResponse(`Ich mache ${DeviceName} ${stateText}`, true),{}
                    )
                );
            } else {
                exitError(context, "Der smater server hat nicht richtig geantwortet");
            }
        });
    }).on('error', function(e) {
        exitError(context, "Die verbindung mit dem smater server konnte nicht hergesetellt werden.");
    });
};

setColor = (context, color, apiKey) => {
    'use strict';
    var r = 255;
    var g = 255;
    var b = 255;
    switch(color.toLowerCase()){
        case "grün":
            r = 0;
            b = 0;
        break;
        case "rot":
            g = 0;
            b = 0;
        break;
        case "blau":
            r = 0;
            g = 0;
        break;
        case "lila":
            g = 0;
            r = 145;
        break;
        case "pink":
            g = 0;
            b = 200;
        break;
        case "orange":
            g = 50;
            b = 0;
        break;
        case "gelb":
            g = 150;
            b = 0;
        break;
        case "weiß":
        break;
        case "weiss":
        break;
        case "weis":
        break;
        default:
            exitError(context, "ich kenne die farbe " + color + " leider nicht.");
        break;
    }
    
    var url = "http://smater.diebayers.de/?f=execute&state=on&r=" + r + "&g=" + g + "&b=" + b + "&deviceid=" + deviceId + "&key=" + apiKey;
    console.log("start request to '" + url + "'");
    http.get(url, function(res) {
        res.on("data", function(chunk) {
            console.log("Responce raw: "+chunk);
            var data = JSON.parse(chunk);
            console.log("Responce type: "+data.responce.type);
            if(data.responce.type == "SUCCESS") {
                context.succeed(
                    generateResponse(
                        buildSpeechletResponse(`Ok. Ich setze die Farbe von ${DeviceName} auf ${color}`, true),{}
                    )
                );
            } else {
                exitError(context, "Der smater server hat nicht richtig geantwortet");
            }
        });
    }).on('error', function(e) {
        exitError(context, "Die verbindung mit dem smater server konnte nicht hergesetellt werden.");
    });
};

exitError = (context, errorMessage) => {
    'use strict';
    reset();
    context.succeed(
        generateResponse(
            buildSpeechletResponse(`Ein Fehler ist aufgetreten. ${errorMessage}`, true),{}
        )
    );
};

generateResponse = (speechletResponse, sessionAttributes) => {
    'use strict';
	return {
		version: "1.0",
		sessionAttributes: sessionAttributes,
		response: speechletResponse
	};
};

reset = () => {
    'use strict';
	asked = false;
	deviceId = -1;
	DeviceName = "";
	DeviceState = "";
};