#!/usr/bin/python
# coding: utf-8

import random
import string
import os

iD      = '-'.join(''.join( random.choice(string.ascii_uppercase + string.digits) for _ in range(5) ) for _ in range(5) )
cle     = ''.join( random.choice(string.ascii_uppercase + string.digits) for _ in range(15) )
client  = raw_input("Nom du client à ajouter : ")

file = open("/var/clients/config_clients.php","a")
file.write("<?php\n\t$_ENV['%s']['NAME'] = '%s';\n\t$_ENV['%s']['KEY'] = '%s';\n?>\n"%(iD,client,iD,cle))
file.close()

file = open("/root/scripts/config_clients.txt","a")
file.write("%s:%s:%s\n"%(iD,cle,client))
file.close()

print("\n\n--Récapitulatif--")
print("\tNom du client : %s")%client
print("\tIDentifiant client (à ajouter dans le Serveur de MAJ) : %s")%iD
print("\tClé du client (à ajouter dans l'installation CyberHawk) : %s")%cle

os.chmod("/var/clients/config_clients.php", 0777)
os.mkdir("/var/clients/" + client)
os.chmod("/var/clients/" + client, 0777)
os.mkdir("/var/clients/" + client + "/www")
os.chmod("/var/clients/" + client + "/www", 0777)
os.mkdir("/var/clients/" + client + "/pakages")
os.chmod("/var/clients/" + client + "/packages", 0777)


os.system("cp /root/scripts/instructions-original.sh /var/clients/" + client + "/instructions.sh")
os.chmod("/var/clients/" + client + "/instructions.sh", 0777)
os.system("cp /root/scripts/instructions-original.sh /var/clients/")
os.chmod("/var/clients/instructions-original.sh", 0777)

