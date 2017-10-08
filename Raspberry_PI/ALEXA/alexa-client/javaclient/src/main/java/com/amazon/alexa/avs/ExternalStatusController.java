package com.amazon.alexa.avs;

import java.io.*;
import java.util.Timer;
import java.util.TimerTask;

public class ExternalStatusController {
    
    static String COM_FILE_LOCATION = "/home/pi/Desktop/ALEXA/StatusFile.txt";
    
    public static void SetStatus(String Status)
    {
	    System.out.println("Setting External Status: "+Status);
	    ClearComFile();
	    WriteComFile(Status);
    }
    
    private static void ClearComFile()
    {
	    try{
			PrintWriter writer = new PrintWriter(COM_FILE_LOCATION, "UTF-8");
			writer.print("");
			writer.close();
		} catch (IOException e) {
			System.out.println("Error Clearing " + COM_FILE_LOCATION + ": " + e.getMessage());
		}
    }
    
    private static void WriteComFile(String Text)
    {
	    try{
			PrintWriter writer = new PrintWriter(COM_FILE_LOCATION, "UTF-8");
			writer.print(Text);
			writer.close();
		} catch (IOException e) {
			System.out.println("Error Clearing " + COM_FILE_LOCATION + ": " + e.getMessage());
		}
    }
}