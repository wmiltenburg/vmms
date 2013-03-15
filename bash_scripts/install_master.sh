#!/bin/bash
#Author: Wouter Miltenburg

echo "Install the master server"
while true
do
echo "Is this a master server?"
echo "Everything needs to be installed."
echo "This is going automatically, you only need to answer some questions."
echo "To answer this questions you need to read the manual?"
echo "Did you read the manual? (yes/no/2nd/3rd)"
read a
case "$a" in
    "yes")
                echo "Installation is in progress"
                apt-get update -y
                apt-get upgrade -y
                apt-get	install apache2 php5 mysql-server mysql-client phpmyadmin qemu-kvm libvirt-bin ssh virtinst libssh2-1-dev libssh2-php clamav libapache2-mod-php5 build-essential libgd2-xpm-dev unzip -y
                useradd -m scan
                mkdir /home/scan/public_html
                echo "Installation is complete, you need to reboot the server"
                echo "Run this script again and answer the virst question with 2nd"
                break
                ;;



        "2nd")
                echo "Installation is in progress, now we are going to edit some configuration files"
                a2enmod userdir
                /etc/init.d/apache2 restart
                echo "
<IfModule mod_php5.c>
    <FilesMatch \"\.ph(p3?|tml)$\">
        SetHandler application/x-httpd-php
    </FilesMatch>
    <FilesMatch \"\.phps$\">
        SetHandler application/x-httpd-php-source
    </FilesMatch>
    # To re-enable php in user directories comment the following lines
    # (from <IfModule ...> to </IfModule>.) Do NOT set it to On as it
    # prevents .htaccess files from disabling it.
#    <IfModule mod_userdir.c>
#        <Directory /home/*/public_html>
#            php_admin_value engine Off
#        </Directory>
#    </IfModule>
</IfModule>" > /etc/apache2/mods-available/php5.conf

                cd /root
                wget http://www.iamotor.nl/vmms/vmms.zip
                unzip vmms.zip



if [ $(id -u) -eq 0 ]; then
	read -s -p "Wachtwoord voor de user : " password

		pass=$(perl -e 'print crypt($ARGV[0], "password")' $password)
		useradd -m -p $pass team7
		[ $? -eq 0 ] && echo "User has been added to system!" || echo "Failed to add a user!"

else
	echo "Only root may add a user to the system"
	exit 1
fi

if [ $(id -u) -eq 0 ]; then
	read -s -p "Wachtwoord voor nagios : " password

		pass=$(perl -e 'print crypt($ARGV[0], "password")' $password)
		useradd -m -p $pass nagios
		[ $? -eq 0 ] && echo "User has been added to system!" || echo "Failed to add a user!"

else
	echo "Only root may add a user to the system"
	exit 1
fi                
                
                groupadd nagios
                usermod -G nagios nagios
                groupadd nagcmd
                usermod -a -G nagcmd nagios
                usermod -a -G nagcmd www-data

                mkdir /home/team7/public_html
                cp -fvR /root/trunk/* /home/team7/public_html/
                chmod 777 -vfR /home/team7/public_html/bash_script
                mkdir /images
                adduser team7 kvm
                adduser team7 libvirtd
                

                chown -vR team7:team7 /images
                mkdir ~/downloads
                cd ~/downloads
                wget http://prdownloads.sourceforge.net/webadmin/webmin-1.570.tar.gz
                tar -xvf webmin-1.570.tar.gz
                wget http://prdownloads.sourceforge.net/sourceforge/nagios/nagios-3.2.3.tar.gz
                wget http://prdownloads.sourceforge.net/sourceforge/nagiosplug/nagios-plugins-1.4.11.tar.gz
                wget http://sourceforge.net/projects/nconf/files/nconf/1.3.0-0/nconf-1.3.0-0.tgz
                tar -xvzf nagios-3.2.3.tar.gz
                tar -xvzf nagios-plugins-1.4.11.tar.gz
                tar xzvf nconf-1.3.0-0.tgz -C /var/www
                



                
                
                echo "Unpacking scripts right now, run this script again and answer the first question with 3rd"



                break

                ;;

        "3rd")

                chown -R www-data:www-data /var/www/nconf
                cd ~/downloads/webmin-1.570
                ./setup.sh /usr/local/webmin
                cd ~/downloads/nagios-3.2.3
                ./configure --with-command-group=nagcmd
                make all
                make install
                make install-init
                make install-config
                make install-commandmode

echo "
###############################################################################
# CONTACTS.CFG - SAMPLE CONTACT/CONTACTGROUP DEFINITIONS
#
# Last Modified: 05-31-2007
#
# NOTES: This config file provides you with some example contact and contact
#        group definitions that you can reference in host and service
#        definitions.
#
#        You don't need to keep these definitions in a separate file from your
#        other object definitions.  This has been done just to make things
#        easier to understand.
#
###############################################################################



###############################################################################
###############################################################################
#
# CONTACTS
#
###############################################################################
###############################################################################

# Just one contact defined by default - the Nagios admin (that's you)
# This contact definition inherits a lot of default values from the 'generic-contact'
# template which is defined elsewhere.

define contact{
        contact_name                    nagiosadmin             ; Short name of user
        use                             generic-contact         ; Inherit default values from generic-contact template (defined above)
        alias                           Nagios Admin            ; Full name of user

        email                           nagios@localhost        ; <<***** CHANGE THIS TO YOUR EMAIL ADDRESS ******
        }



###############################################################################
###############################################################################
#
# CONTACT GROUPS
#
###############################################################################
###############################################################################

# We only have one contact in this simple configuration file, so there is
# no need to create more than one contact group.

define contactgroup{
        contactgroup_name       admins
        alias                   Nagios Administrators
        members                 nagiosadmin
        }" > /usr/local/nagios/etc/objects/contacts.cfg

                make install-webconf
                htpasswd -c /usr/local/nagios/etc/htpasswd.users nagiosadmin
                /etc/init.d/apache2 reload
                

                cd ~/downloads/nagios-plugins-1.4.11
                ./configure --with-nagios-user=nagios --with-nagios-group=nagios
                make
                make install
                ln -s /etc/init.d/nagios /etc/rcS.d/S99nagios
                /etc/init.d/nagios start

                echo "You can now login into Nagios with this url:"
                echo "http://localhost/nagios"
                echo "You can now login into Webmin with this url:"
                echo "http://localhost:10000"
                echo "Installation is complete."
                
                
                break
                ;;




        
        "no")
                echo "Have a nice day!"
                break

                ;;

        "exit")
            break
            ;;
        *)
        echo "Invalid input"
        ;;
esac
done