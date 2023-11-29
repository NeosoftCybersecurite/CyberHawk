#!/bin/sh

echo "Applying best security practices for SSH connection: Disallow root connection"
sed -i 's/PermitRootLogin yes/PermitRootLogin no/' /etc/ssh/sshd_config

echo ""
echo ""
echo "Setting Firewall rules for preventing intrusions"
echo "#!/bin/sh -e" > /etc/rc.local
echo /sbin/iptables -F >> /etc/rc.local
echo /sbin/iptables -X >> /etc/rc.local
echo /sbin/iptables -A INPUT -i lo -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A INPUT -p TCP --dport 22 -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A INPUT -m state --state  RELATED,ESTABLISHED -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -o lo -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -m state --state  RELATED,ESTABLISHED -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -p TCP --dport 22 -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -p TCP --dport 80 -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -p UDP --dport 53 -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -A OUTPUT -p icmp -j ACCEPT >> /etc/rc.local
echo /sbin/iptables -P INPUT DROP >> /etc/rc.local
echo /sbin/iptables -P OUTPUT DROP >> /etc/rc.local
echo /sbin/iptables -P FORWARD DROP >> /etc/rc.local
echo exit 0 >> /etc/rc.local

mv -f ./cyberhawk/CYBERHAWK_UPDATE/rc-local.service /etc/systemd/system/rc-local.service
chmod +x /etc/rc.local
systemctl enable rc-local


echo ""
echo ""
echo "Creating /root/scripts directory to store useful scripts"
mkdir /root/scripts/
cp ./cyberhawk/CYBERHAWK_UPDATE/* /root/scripts/


echo ""
echo ""
echo "Configuring crontab..."
echo -n "Please enter frequency of update (default 1) in days (1/2/3/etc.) and press [ENTER]: "
read day
day=${day:-1}
echo -n "Please enter hour of update (default 0) in hour (1/2/3/.../12/13/etc.) and press [ENTER]: "
read hour
hour=${hour:-0}
echo "Configuring crontab: antivirus update each $day day(s) at $hour:00"
echo "0 $hour */$day * * python /root/scripts/maj.py" > /root/scripts/crontab.file
crontab /root/scripts/crontab.file

echo ""
echo ""
echo -n "Please enter unique customer ID (Generated on CONIX MIRROR SERVER) and press [ENTER]: "
read cid
echo "\n\n[CID]" >> /root/scripts/config.cfg
echo "cid = " $cid >> /root/scripts/config.cfg

echo ""
echo ""
echo -n "Please enter CyberHawk IP address and press [ENTER]: "
read ip
echo "\n\n[CYBERHAWK]" >> /root/scripts/config.cfg
echo "ips = " $ip >> /root/scripts/config.cfg

echo ""
echo ""
echo ""
echo ""
echo "Configuring SSH Key and automatic connections with CyberHawk..."
echo "Press [ENTER] when prompted for Passphrase !"
echo "Enter Cyberhawk 'cyberhawkmaj' password when prompted !"
mkdir /root/.ssh/
cd /root/.ssh/
ssh-keygen -t rsa -b 2048 -q -N ""
ssh-copy-id -i id_rsa.pub cyberhawkmaj@$ip


echo Restarting computer in 10 seconds...
sleep 1
echo Restarting computer in  9 seconds...
sleep 1
echo Restarting computer in  8 seconds...
sleep 1
echo Restarting computer in  7 seconds...
sleep 1
echo Restarting computer in  6 seconds...
sleep 1
echo Restarting computer in  5 seconds...
sleep 1
echo Restarting computer in  4 seconds...
sleep 1
echo Restarting computer in  3 seconds...
sleep 1
echo Restarting computer in  2 seconds...
sleep 1
echo Restarting computer in  1 seconds...
sleep 1

echo ""
echo ""
echo "Cleaning..."
rm -Rf /root/cyberhawk

reboot
