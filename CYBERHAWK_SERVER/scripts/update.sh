#!/bin/sh


FILE=$(cat /root/scripts/folder.cfg)

if [ -f /home/cyberhawkmaj/updates-srvchx.log ];
then
	find /home/cyberhawkmaj/updates-srvchx.log -size +10240k -delete
fi


if [ -f ${FILE}encrypted.data ];
then
	echo $(date) ": File ${FILE}encrypted.data exists. Updates pushed from Administrator interface." | tee /home/cyberhawkmaj/updates-srvchx.log -a
	mv ${FILE}encrypted.data /home/cyberhawkmaj/encrypted.data
else
	FILE2=/home/cyberhawkmaj/encrypted.data

	if [ -f $FILE2 ];
	then
		echo $(date) ": File $FILE2 exists. Updates pushed from Update Server." | tee /home/cyberhawkmaj/updates-srvchx.log -a
	else
		echo $(date) ": File $FILE2 does not exist. Updates are not available." | tee /home/cyberhawkmaj/updates-srvchx.log -a
		cp -f /home/cyberhawkmaj/updates-srvchx.log ${FILE}updates-srvchx.log
		exit 1
	fi
fi

rm -Rf /home/cyberhawkmaj/SOPHOS/
cp -f /home/cyberhawkmaj/updates-srvmaj.log ${FILE}updates-srvmaj.log


openssl enc -aes-256-cbc -d -md md5 -in /home/cyberhawkmaj/encrypted.data -out /home/cyberhawkmaj/updates.tar -pass file:/root/scripts/key.cfg

if [ $? -eq 0 ]; 
then
    	echo $(date) ": Decryption successful." | tee /home/cyberhawkmaj/updates-srvchx.log -a
	
	cd /home/cyberhawkmaj/
	tar -xvf ./updates.tar

	if [ $? -eq 0 ]; 
	then
		echo $(date) ": Un-tar successful." | tee /home/cyberhawkmaj/updates-srvchx.log -a

		sh instructions.sh

		if [ $? -eq 0 ]; 
		then
			echo $(date) ": Instructions execution successful." | tee /home/cyberhawkmaj/updates-srvchx.log -a
			rm instructions.sh
			cp -f /home/cyberhawkmaj/updates-srvchx.log ${FILE}updates-srvchx.log
		else
			echo $(date) ": Instructions execution failure." | tee /home/cyberhawkmaj/updates-srvchx.log -a
			rm /home/cyberhawkmaj/updates.tar
			rm /home/cyberhawkmaj/encrypted.data
			rm instructions.sh
			cp -f /home/cyberhawkmaj/updates-srvchx.log ${FILE}updates-srvchx.log
			exit 4
		fi
	else
		echo $(date) ": Un-tar failure." | tee /home/cyberhawkmaj/updates-srvchx.log -a
		rm /home/cyberhawkmaj/updates.tar
		rm /home/cyberhawkmaj/encrypted.data
		cp -f /home/cyberhawkmaj/updates-srvchx.log ${FILE}updates-srvchx.log
		exit 3
	fi


else
    	echo $(date) ": Decryption failure." | tee /home/cyberhawkmaj/updates-srvchx.log -a
	rm /home/cyberhawkmaj/updates.tar
	rm /home/cyberhawkmaj/encrypted.data
	cp -f /home/cyberhawkmaj/updates-srvchx.log ${FILE}updates-srvchx.log
	exit 2
fi

exit 0
