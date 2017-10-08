/**
 * @module
 * This module defines the settings that need to be configured for a new
 * environment.
 * The clientId and clientSecret are provided when you create
 * a new security profile in Login with Amazon.  
 * 
 * You will also need to specify
 * the redirect url under allowed settings as the return url that LWA
 * will call back to with the authorization code.  The authresponse endpoint
 * is setup in app.js, and should not be changed.  
 * 
 * lwaRedirectHost and lwaApiHost are setup for login with Amazon, and you should
 * not need to modify those elements.
 */
var config = {
    clientId: "amzn1.application-oa2-client.ad0807807e764a2ba27cfa68da0b2a93",
    clientSecret: "0ee21fb50568669bc6ad5e3b84b96a57030df2410278fc3e1de14474f9196d12",
    redirectUrl: 'https://localhost:3000/authresponse',
    lwaRedirectHost: "amazon.com",
    lwaApiHost: "api.amazon.com",
    validateCertChain: true,
    sslKey: "/home/pi/Desktop/ALEXA/alexa-client/javaclient/certs/server/node.key",
    sslCert: "/home/pi/Desktop/ALEXA/alexa-client/javaclient/certs/server/node.crt",
    sslCaCert: "/home/pi/Desktop/ALEXA/alexa-client/javaclient/certs/ca/ca.crt",
    products: {
        "alexa_raspberry_pi": ["123456789"],
    },
};

module.exports = config;
