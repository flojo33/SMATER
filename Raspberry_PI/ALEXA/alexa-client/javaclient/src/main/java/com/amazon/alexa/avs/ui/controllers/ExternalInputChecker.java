package com.amazon.alexa.avs.ui.controllers;

import java.io.*;
import java.util.Timer;
import java.util.TimerTask;
import java.io.InputStream;

public class ExternalInputChecker {
    
    static String COM_FILE_LOCATION = "/home/pi/Desktop/ALEXA/ComFile.txt";
    
    private ListenViewController mainViewController;
    
    public ExternalInputChecker(ListenViewController mainViewController)
    {
	    this.mainViewController = mainViewController;
        InitTimer();
        System.out.println("ExternalInputChecker initialized");
    }
    
    private void InitTimer()
    {
	    Timer t = new Timer();
		t.schedule(new TimerTask() {
		    @Override
		    public void run() {
		       CheckComFile();
		    }
		}, 0, 500);
    }
    
    private void CheckComFile()
    {
	    try{
		    // Open the file that is the first
		    // command line parameter
		    FileInputStream fstream = new FileInputStream(COM_FILE_LOCATION);
		    // Get the object of DataInputStream
		    DataInputStream in = new DataInputStream(fstream);
		    BufferedReader br = new BufferedReader(new InputStreamReader(in));
		    String strLine;
		    //Read File Line By Line
		    while ((strLine = br.readLine()) != null)   {
				// Print the content on the console
				ExecuteCommand(strLine);
			}
			//Close the input stream
			in.close();
		} catch (Exception e){ //Catch exception if any
			System.out.println("Error: " + e.getMessage());
		}
		ClearComFile();
    }
    
    private void ClearComFile()
    {
	    try{
			PrintWriter writer = new PrintWriter(COM_FILE_LOCATION, "UTF-8");
			writer.print("");
			writer.close();
		} catch (IOException e) {
			System.out.println("Error Clearing " + COM_FILE_LOCATION + ": " + e.getMessage());
		}
    }
    
    /*private InputStream createMP3InputStream(String filename)
    {
	    String totalFilename = "/var/www/html/requestAudio/" + filename;
	    System.out.println("Trying to create input stream from '" + totalFilename + "'");
	    InputStream is;
		try {
		    is = new FileInputStream(totalFilename);
		    return is;
		} catch (Exception e) {
			System.out.println("error creating mp3 input stream!");
			return null;
		}
    }*/
    
    private void ExecuteCommand(String command)
    {
    	String[] cmdSplit = command.split(" ");
	    int cmdCount = cmdSplit.length;
	    if(cmdCount >= 1)
	    {
		    switch(cmdSplit[0])
		    {
			    case "start_listening":
			    	System.out.println("Telling ALEXA to start listening from external command!");
			    	mainViewController.StartListening();
			    	break;
			    case "text_command":
			    	if(cmdCount >= 3)
			    	{
				    	String cmdAudioFile = cmdSplit[1];
				    	String text = "";
				    	for(int i = 2; i < cmdCount; i++) {
							if(i != 2)
								text += " ";
					    	text += cmdSplit[i];
				    	}
				    	System.out.println("Received Voice Command. (Text: '" + text + "'; AudioFileLocation: '"+cmdAudioFile + "')");
				    	mainViewController.SendPrerecordedAudio(cmdAudioFile);
			    	}
			    	else
			    	{
				    	System.out.println("no text command given!");
			    	}
			    	break;
			    default:
			    	System.out.println("Received unknown external command '"+command+"'.");
		    }
	    }
	    else
	    {
			System.out.println("Received empty external command.");
	    }
    }
}