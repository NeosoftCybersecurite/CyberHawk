#!/bin/sh

# Today's downloads
cp /root/scripts/mail.txt /root/scripts/mail.tmp

echo "Bonjour,\n" >> /root/scripts/mail.tmp

touch /var/clients/download.log         # Create empty if not existing (/!\ means no clients  came for updates)
nb_clients=$(wc -l < /var/clients/download.log)

echo "Aujourd'hui, $nb_clients clients sont venus chercher leur mise à jour :" >> /root/scripts/mail.tmp

# For each line, read Key and find client
while read p; do
        client_name=$(echo $p | perl -nle 'm/([0-9A-Za-z\-]*);/; print $1')
        client_time=$(echo $p | perl -nle 'm/;([0-9:]*)/; print $1')
        echo "\t- $client_name ($client_time)" >> /root/scripts/mail.tmp
done </var/clients/download.log

nb_defaut=$(wc -l < /root/scripts/config_clients.txt)
nb_defaut=$(($nb_defaut-$nb_clients))

echo "\nCi-dessous, la liste des clients ($nb_defaut) ayant un défaut de mise à jour :" >> /root/scripts/mail.tmp

while read p; do
        client_name_f=$(echo $p | perl -nle 'print $1 if /.*\:.*:(.*)/')
        if ! grep -q $client_name_f /root/scripts/mail.tmp; then
                echo "\t- $client_name_f" >> /root/scripts/mail.tmp
        fi
done </root/scripts/config_clients.txt

echo "\nInformation : Lorsque des clients isolés ne viennent pas chercher leur mise à jour, le problème vient de chez eux (réseau, client ID mal configuré, etc.). Lorsqu'aucun client ne vient chercher ses mises$

echo "\nCordialement,\nCyberHawk" >> /root/scripts/mail.tmp

/usr/sbin/sendmail -vt < /root/scripts/mail.tmp

cat /root/scripts/mail.tmp

rm /root/scripts/mail.tmp
rm /var/clients/download.log