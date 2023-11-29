#!/bin/sh

echo ""
echo ""
echo "Deactivating Sophos automatic scans"
/opt/sophos-av/bin/savconfig set LiveProtection false

echo ""
echo ""
echo "Removing installation files"
rm -Rf /root/cyberhawk-test/
rm -Rf /root/scripts/
rm -Rf /var/clients/
rm -Rf *.deb
rm -Rf sophos-av/

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
echo "Adding necessary files to '/var/www'"
mv ./libssl0.9.8_0.9.8o-7_amd64.deb /var/www
mv ./oletools.tar.gz /var/www
mv ./savdi-linux-64bit.tar /var/www
mv ./scan-sophos-sssp.sh /var/www
mv ./cav-linux_x64.deb /var/www
mv ./sav-linux-free-9.tgz /var/www


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


echo ""
echo ""
echo "Applying best security practices for PHP Server"
sed -i 's/expose_php = On/expose_php = Off/' /etc/php5/apache2/php.ini
sed -i 's/= 128M/= 1024M/' /etc/php5/apache2/php.ini
sed -i 's/= 2M/= 1024M/' /etc/php5/apache2/php.ini
sed -i 's/= 8M/= 1024M/' /etc/php5/apache2/php.ini
sed -i 's/= 200M/= 1024M/' /etc/php5/apache2/php.ini

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
echo /sbin/iptables -A INPUT -p TCP --dport 22 -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A INPUT -m state --state  RELATED,ESTABLISHED -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -o lo -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -m state --state  RELATED,ESTABLISHED -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -p TCP --dport 25 -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -p TCP --dport 587 -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -p TCP --dport 465 -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -P INPUT DROP >> /etc/rc.local
echo /sbin/iptables -P FORWARD DROP >> /etc/rc.local
echo exit 0 >> /etc/rc.local

mv -f ./cyberhawk/CYBERHAWK_UPDATE/rc-local.service /etc/systemd/system/rc-local.service
chmod +x /etc/rc.local
systemctl enable rc-local


mv -f ./cyberhawk/CYBERHAWK_MIRROR/ssmtp.conf /etc/ssmtp/ssmtp.conf
echo ""
echo ""
echo "Creating /root/scripts directory to store useful scripts"
mkdir /root/scripts/
cp ./cyberhawk/CYBERHAWK_MIRROR/* /root/scripts/

chmod +x /root/scripts/send_mail.sh


echo ""
echo ""
echo "Creating clients directory within /var/clients/"
mkdir -m 777 /var/clients/
mkdir -m 777 /var/files/


echo ""
echo ""
echo "Configuring CyberHawk..."
echo -n "Please enter www folder (default '/var/www/') and press [ENTER]: "
read www
www=${www:-/var/www/}


echo ""
echo ""
echo "Configuring crontab: antivirus update each day at 00:00"
echo "0 21 * * * python /root/scripts/av_updates_client.py >/dev/null 2>&1" >> /root/scripts/crontab.file
echo "0 12 * * * sh /root/scripts/send_mail.sh >/dev/null 2>&1" >> /root/scripts/crontab.file


crontab /root/scripts/crontab.file


echo ""
echo ""
echo "Configuring HTTP Server with directories"
mv -f /root/scripts/download.php /var/www/
chown -R www-data:www-data /var/www/


chfn -f "CyberHawk" root



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
