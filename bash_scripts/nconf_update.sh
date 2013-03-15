#!/bin/bash
PATH=/usr/kerberos/sbin:/usr/kerberos/bin:/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin:/root/bin
#Copying files from Nconf output directory to Nagios objects directory
cd /var/www/nconf/output
rm -rf global Default_collector
tar zxvf NagiosConfig.tgz
mv /var/www/nconf/output/global/* /usr/local/nagios/etc/objects/
mv /var/www/nconf/output/Default_collector/* /usr/local/nagios/etc/objects/
chown nagios:nagios /usr/local/nagios/etc/objects/*
chmod 644 /usr/local/nagios/etc/objects/*
/etc/init.d/nagios restart
