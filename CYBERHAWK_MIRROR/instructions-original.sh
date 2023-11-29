#!/bin/bash

# Instructions can be added for one client in that file
# Instruction file and files within folder will be sent to client on next request
# Client will execute instructions at 00:00 the next day (or not ?)

PATH=/usr/bin:/bin:/usr/sbin:/sbin

/usr/bin/pkill savdid

cp -f /home/cyberhawkmaj/COMODO/bases.cav /opt/COMODO/scanners/bases.cav
cp -Rf /home/cyberhawkmaj/CLAMAV/* /var/lib/clamav/
chmod -R 755 /opt/COMODO/scanners/bases.cav
chmod -R 755 /home/cyberhawkmaj/SOPHOS/
chmod -R 755 /var/lib/clamav/*.c*d
rm -Rf /home/cyberhawkmaj/CLAMAV/
rm -Rf /home/cyberhawkmaj/COMODO
rm -Rf /home/cyberhawkmaj/updates.tar
rm -Rf /home/cyberhawkmaj/encrypted.data
/opt/sophos-av/bin/savupdate


# Update source code
rm -f /home/cyberhawkmaj/www/config.php
rm -f /home/cyberhawkmaj/www/install.sql
rm -f /home/cyberhawkmaj/www/installation.php
rm -Rf /home/cyberhawkmaj/www/scripts/
cp -Rf /home/cyberhawkmaj/www/* /var/www/
chown -R www-data:www-data /var/www/
rm -Rf /home/cyberhawkmaj/www/
rm -Rf /home/cyberhawkmaj/packages/

/usr/local/bin/savdid -d

sh /etc/rc.local
exit 0
