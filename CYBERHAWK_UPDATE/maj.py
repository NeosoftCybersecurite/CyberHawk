#!/usr/bin/python

import ConfigParser, os, time

logfile = '/root/scripts/updates.log'


#
# Affiche une chaine donnee et l'ecrit dans le fichier de logs
#
# @str : chaine entree
#
def LogFile(str):
	f = open(logfile, 'a')
	f.write(time.strftime('%d/%m/%y %H:%M:%S',time.localtime()) + " " + str + "\n")
	f.close()

	
#
# Supprime un fichier existant avec le nom specifie
#
# @name : nom du fichier a supprimer
#
def removeLogFile():
	if (os.path.isfile(logfile)):
		os.remove(logfile)

	
					
######################################
#        PROGRAMME PRINCIPAL         #
######################################
try:
	# Suppression du fichier de log s'il depasse les 10Mo
	if (os.path.isfile(logfile)):
		if (os.path.getsize(logfile) > 10000000):
			removeLogFile()
			
	LogFile("####################")
	LogFile("#                  #")
	LogFile("####################")


	# Lecture du fichier de configuration et recuperation des donnees
	print "Chargement du fichier de configuration..."
	Config = ConfigParser.ConfigParser()					
	Config.read("/root/scripts/config.cfg")
	srv, cid, ips = Config.get('CONIX', 'servers').split(","), Config.get('CID', 'cid').split(","), Config.get('CYBERHAWK', 'ips').split(",")	
	print "Chargement du fichier de configuration... OK !"


	# Debut de la recuperation des fichiers de MAJ sur Internet
	print time.strftime('%d/%m/%y %H:%M:%S',time.localtime()) + " Recuperation de la MAJ sur Internet..."
	LogFile("Recuperation de la MAJ sur Internet...")

	# Tentative de recuperation sur le premier serveur, puis le deuxieme si un fichier echoue, etc.
	for s in srv:
		print time.strftime('%d/%m/%y %H:%M:%S',time.localtime()) + " http://" + s + "/download.php?ID=" + cid[0]
		LogFile("http://" + s + "/download.php?ID=" + cid[0])						
		os.system("wget http://" + s + "/download.php?ID=" + cid[0] + " -o out.log -t 2 -T 120 -O /root/scripts/encrypted.data")
		os.system("cat out.log >> " + logfile)
		os.system("rm out.log")
				
		if (os.path.getsize("/root/scripts/encrypted.data") > 0):
			print time.strftime('%d/%m/%y %H:%M:%S',time.localtime()) + " Fichier 'encrypted.data' telecharge (" + str(os.path.getsize("/root/scripts/encrypted.data")) + "b)"
			LogFile("Fichier 'encrypted.data' telecharge (" + str(os.path.getsize("/root/scripts/encrypted.data")) + "b)")		
			break	

	for ip in ips:
		print time.strftime('%d/%m/%y %H:%M:%S',time.localtime()) + " Pushing 'encrypted.data' to " + ip + " with account 'cyberhawkmaj'"
		LogFile("Pushing 'encrypted.data' to " + ip + " with account 'cyberhawkmaj'")						
		os.system("/usr/bin/scp -o StrictHostKeyChecking=no -i /root/.ssh/id_rsa /root/scripts/encrypted.data cyberhawkmaj@" + ip + ":/home/cyberhawkmaj/")

	print time.strftime('%d/%m/%y %H:%M:%S',time.localtime()) + " Removing 'encrypted.data' from the system!"
	LogFile("Removing 'encrypted.data' from the system!")
	os.system("rm -f /root/scripts/encrypted.data")

	
except ConfigParser.NoSectionError:			# Gestion des erreurs dans le fichier de configuration
	LogFile("Le fichier de configuration n'est pas au format attendu ou n'est pas present")
	print time.strftime('%d/%m/%y %H:%M:%S',time.localtime()) + " Le fichier de configuration n'est pas au format attendu ou n'est pas present"

print time.strftime('%d/%m/%y %H:%M:%S',time.localtime()) + " Pushing '/root/scripts/updates.log' to " + ip + " with account 'cyberhawkmaj'"
LogFile("Pushing '/root/scripts/updates.log' to " + ip + " with account 'cyberhawkmaj'")	
os.system("/usr/bin/scp -o StrictHostKeyChecking=no -i /root/.ssh/id_rsa /root/scripts/updates.log cyberhawkmaj@" + ip + ":/home/cyberhawkmaj/updates-srvmaj.log")
