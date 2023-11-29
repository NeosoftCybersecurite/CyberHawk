#!/bin/sh

echo ""
echo ""
echo "Deactivating Sophos automatic scans"
/opt/sophos-av/bin/savconfig set LiveProtection false

echo ""
echo ""
echo "Removing installation files"
rm -Rf /var/files/
rm -Rf /root/scripts/
rm -Rf *.deb
rm -Rf sav-linux-free-9.tgz
rm -Rf sophos-av/


echo ""
echo ""
echo "Pushing Sophos Daemon and OleTools"
tar -xvf ./savdi-linux-64bit.tar
sh ./savdi-install/savdi_install.sh
rm ./savdi-linux-64bit.tar
rm -rf ./savdi-install/
mkdir /opt/cyberhawk/
mv ./scan-sophos-sssp.sh /opt/cyberhawk/scan-sophos-sssp.sh
chmod +x /opt/cyberhawk/scan-sophos-sssp.sh
tar -xzvf ./oletools.tar.gz -C /opt/cyberhawk/
rm ./oletools.tar.gz
chown -R www-data:www-data /opt/cyberhawk/



echo ""
echo ""
echo "Applying best security practices for SSH connection: Disallow root connection"
sed -i 's/PermitRootLogin yes/PermitRootLogin no/' /etc/ssh/sshd_config

echo ""
echo ""
echo "Cleaning /var/www/* directory"
rm -Rf /var/www/*

echo ""
echo ""
echo "Applying best security practices for Apache Server"
if [ -f /etc/apache2/conf.d/security ];
then
	sed -i 's/ServerTokens OS/ServerTokens Prod/' /etc/apache2/conf.d/security
	sed -i 's/ServerSignature On/ServerSignature Off/' /etc/apache2/conf.d/security
	sed -i 's/Options Indexes FollowSymLinks/Options FollowSymLinks/' /etc/apache2/apache2.conf
else
	sed -i 's/ServerTokens OS/ServerTokens Prod/' /etc/apache2/conf-available/security.conf
	sed -i 's/ServerSignature On/ServerSignature Off/' /etc/apache2/conf-available/security.conf
	sed -i 's/Options Indexes FollowSymLinks/Options FollowSymLinks/' /etc/apache2/conf-available/security.conf
fi

sed -i 's/Options Indexes FollowSymLinks/Options FollowSymLinks/' /etc/apache2/apache2.conf

sed -i 's/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www/' /etc/apache2/sites-available/000-default.conf

echo ""
echo ""
echo "Applying best security practices for PHP Server"

if [ -f /etc/php5/apache2/php.ini ]; then
	sed -i 's/expose_php = On/expose_php = Off/' /etc/php5/apache2/php.ini
	sed -i 's/= 128M/= 1024M/' /etc/php5/apache2/php.ini
	sed -i 's/= 2M/= 1024M/' /etc/php5/apache2/php.ini
	sed -i 's/= 8M/= 1024M/' /etc/php5/apache2/php.ini
	sed -i 's/= 200M/= 1024M/' /etc/php5/apache2/php.ini
fi

if [ -f /etc/php/7.0/apache2/php.ini ]; then
	sed -i 's/expose_php = On/expose_php = Off/' /etc/php/7.0/apache2/php.ini
	sed -i 's/= 128M/= 1024M/' /etc/php/7.0/apache2/php.ini
	sed -i 's/= 2M/= 1024M/' /etc/php/7.0/apache2/php.ini
	sed -i 's/= 8M/= 1024M/' /etc/php/7.0/apache2/php.ini
	sed -i 's/= 200M/= 1024M/' /etc/php/7.0/apache2/php.ini
fi



sed -i 's/PrivateTmp=true/PrivateTmp=false/' /lib/systemd/system/apache2.service
cp /lib/systemd/system/apache2.service /etc/systemd/system/
systemctl daemon-reload
systemctl restart apache2.service


echo ""
echo ""
echo "Restarting Apache Server"
service apache2 restart

echo ""
echo ""
echo "Setting Firewall rules for preventing intrusions"
echo "#!/bin/sh -e" > /etc/rc.local
echo /sbin/iptables -F >> /etc/rc.local
echo /sbin/iptables -X >> /etc/rc.local
echo /sbin/iptables -A INPUT -i lo -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A INPUT -p TCP --dport 80 -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A INPUT -p TCP --dport 443 -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A INPUT -p TCP --dport 22 -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A INPUT -m state --state  RELATED,ESTABLISHED -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -o lo -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -m state --state  RELATED,ESTABLISHED -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -P INPUT DROP >> /etc/rc.local
echo /sbin/iptables -P OUTPUT DROP >> /etc/rc.local
echo /sbin/iptables -P FORWARD DROP >> /etc/rc.local
echo chown cyberhawkmaj:cyberhawkmaj /home/cyberhawkmaj/ >> /etc/rc.local
echo chmod go-w /home/cyberhawkmaj/ >> /etc/rc.local
echo chmod 700 /home/cyberhawkmaj/.ssh >> /etc/rc.local
echo chmod 600 /home/cyberhawkmaj/.ssh/authorized_keys >> /etc/rc.local
echo /usr/local/bin/savdid -d >> /etc/rc.local
echo service clamav-daemon start >> /etc/rc.local
echo exit 0 >> /etc/rc.local


mv -f ./cyberhawk/CYBERHAWK_SERVER/scripts/rc-local.service /etc/systemd/system/rc-local.service
chmod +x /etc/rc.local
systemctl enable rc-local


echo ""
echo ""
echo "Creating /root/scripts directory to store useful scripts"
mv -f ./cyberhawk/CYBERHAWK_SERVER/scripts /root/


echo ""
echo ""
echo "Creating files directory within /var/files/"
mkdir -m 755 /var/files/


echo ""
echo ""
echo "Configuring CyberHawk..."
echo -n "Please enter unique customer Key (Generated on CONIX MIRROR SERVER) and press [ENTER]: "
read key
echo ${key}${key}conix${key} > /root/scripts/key.cfg
echo -n "Please enter users files folder (default '/var/files/') and press [ENTER]: "
read folder
folder=${folder:-/var/files/}
echo $folder"Administrator/" > /root/scripts/folder.cfg
echo -n "Please enter www folder (default '/var/www/') and press [ENTER]: "
read www
www=${www:-/var/www/}


echo ""
echo ""
echo "Configuring crontab..."
echo "IMPORTANT: If UPDATE SERVER receive updates at 00:00, wait an hour at least to run cron jobs on CyberHawk"
echo -n "Please enter frequency of update (default 1) in days (1/2/3/etc.) and press [ENTER]: "
read day
day=${day:-1}
echo -n "Please enter hour of update (default 2) in hour (1/2/3/.../12/13/etc.) and press [ENTER]: "
read hour
hour=${hour:-2}
echo "Configuring crontab: CyberHawk update each $day day(s) at $hour:00"
echo "0 $hour */$day * * sh /root/scripts/update.sh" > /root/scripts/crontab.file
echo "15 $hour */$day * * sh /etc/rc.local" >> /root/scripts/crontab.file
echo "0 0 * * * php -f ${www}clear.php" >> /root/scripts/crontab.file
crontab /root/scripts/crontab.file



echo ""
echo ""
echo "Configuring HTTP Server with directories"
cp -Rf ./cyberhawk/CYBERHAWK_SERVER/* /var/www/
chown -R www-data:www-data /var/www/
chown -R www-data:www-data /var/files/


echo ""
echo ""
echo "Restarting computer in 10 seconds..."
sleep 1
echo "Restarting computer in  9 seconds..."
sleep 1
echo "Restarting computer in  8 seconds..."
sleep 1
echo "Restarting computer in  7 seconds..."
sleep 1
echo "Restarting computer in  6 seconds..."
sleep 1
echo "Restarting computer in  5 seconds..."
sleep 1
echo "Restarting computer in  4 seconds..."
sleep 1
echo "Restarting computer in  3 seconds..."
sleep 1
echo "Restarting computer in  2 seconds..."
sleep 1
echo "Restarting computer in  1 seconds..."
sleep 1

echo ""
echo ""
echo "Cleaning..."
rm -Rf ./cyberhawk

reboot
