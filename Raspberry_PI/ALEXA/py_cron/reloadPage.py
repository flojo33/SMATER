import datetime, threading
import urllib

curCount = 0

def deviceSync():
	link = "http://127.0.0.1/deviceSync.php"
	f = urllib.urlopen(link)
	myfile = f.read()
	if myfile != "nochange":
		print myfile

def generalSync():
	link = "http://127.0.0.1/cron.php"
	f = urllib.urlopen(link)
	myfile = f.read()
	if myfile != "nochange":
		print myfile

def foo():
	global curCount
	generalSync()
	curCount = curCount + 1
	if curCount == 2:
		deviceSync()
		curCount = 0
	threading.Timer(1, foo).start()
print "Starting SMATER Web connection"
foo()