#!/usr/bin/python
#coding: utf-8

import os
import re

# Clear Clients Signatures package
os.system('rm -f /var/clients/*/encrypted.data')


# AV Clamav - update
os.system('/usr/bin/freshclam')

# AV Sophos - update
os.system('/opt/sophos-av/bin/savupdate')
os.system('rm -Rf /home/conix/SOPHOS/')
os.system('mkdir /home/conix/SOPHOS/')
os.system('cp -Rf /opt/sophos-av/update/cache/Primary/ /home/conix/SOPHOS/')
os.system('chmod -R 755 /home/conix/SOPHOS/')


# AV COMODO - update
os.system('wget http://download.comodo.com/av/updates58/sigs/bases/bases.cav')
os.system('cp -f bases.cav /opt/COMODO/scanners/bases.cav')
os.system('rm -f bases.cav')

# Create Clients signature package
os.system('mkdir /var/clients/AV/')
os.system('mkdir /var/clients/AV/COMODO/')
os.system('mkdir /var/clients/AV/SOPHOS/')
os.system('mkdir /var/clients/AV/CLAMAV/')
os.system('cp -f /opt/COMODO/scanners/bases.cav /var/clients/AV/COMODO/')
os.system('cp -Rf /var/lib/clamav/*.c*d /var/clients/AV/CLAMAV/')
os.system('cp -Rf /home/conix/SOPHOS/* /var/clients/AV/SOPHOS/')


# Creating TAR with all AV signatures
os.system('tar -cvf /var/clients/CLIENT.tar -C /var/clients/AV/ .')
os.system('rm -Rf /var/clients/AV/')


# Creating TAR for each client within config_client.txt
with open("/root/scripts/config_clients.txt") as f:
  for line in f:
    infos = line.split(":")
    os.system("cp '/var/clients/CLIENT.tar' '/var/clients/" + infos[2].rstrip() + ".tar'")
    os.system("tar -rvf '/var/clients/" + infos[2].rstrip() + ".tar' -C '/var/clients/" + infos[2].rstrip() + "' .")
	os.system("gzip -9 '/var/clients/" + infos[2].rstrip() + ".tar'")
	os.system("mv '/var/clients/" + infos[2].rstrip() + ".tar.gz' '/var/clients/" + infos[2].rstrip() + ".tar'")
    os.system("echo " + infos[1] + infos[1] + "conix" + infos[1]  + " > '/var/clients/" + infos[2].rstrip() + "/key.txt'")
    os.system("openssl enc -aes-256-cbc -md md5 -salt -in '/var/clients/" + infos[2].rstrip() + ".tar' -out '/var/clients/" + infos[2].rstrip() + "/encrypted.data' -pass file:'/var/clients/" + infos[2].rstrip() + "/key.txt'")
    # On repousse les instructions originales au client dans le cas où elles auraient été modifiées
	os.system("cp -f '/var/clients/instructions-original.sh' '/var/clients/" + infos[2].rstrip() + "/instructions.sh'")


# Cleaning directories
os.system('rm -f /var/clients/*.tar')
os.system('rm -f /var/clients/*/key.txt')
os.system('rm -Rf /var/clients/*/www/*')
os.system('rm -Rf /var/clients/*/packages/*')
