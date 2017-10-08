#!/bin/bash
# erstes Terminal
lxterminal -l -e "cd ~/Desktop/ALEXA/alexa-client/companionService && npm start;" &

# Warten
sleep 10s

# zweites Terminal
lxterminal -l -e "cd ~/Desktop/ALEXA/alexa-client/javaclient && mvn exec:exec;" &

# Warten
sleep 30s

# drittes Terminal
lxterminal -l -e "cd ~/Desktop/ALEXA/alexa-client/wakeWordAgent/src && ./wakeWordAgent -e kitt_ai;" &

sleep 1s

lxterminal -l -e "cd ~/Desktop/ALEXA/py_cron && python reloadPage.py;"

sleep 5s

#Open Chromium in fullscreen showing display.php

openbox &
openbox_pid=$!
/usr/bin/chromium-browser --kiosk http://127.0.0.1/display.php &
chrome_pid=$!

