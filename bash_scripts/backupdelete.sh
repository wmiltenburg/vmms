#!/bin/bash
#Author: Koen Veelenturf
# $vmname

if [ -f /etc/backup.d/$1.rdiff ]
then
    rm /etc/backup.d/$1.rdiff
fi

