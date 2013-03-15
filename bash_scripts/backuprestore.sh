#!/bin/bash
#Author: Koen Veelenturf

#$1 = vmnaam
#$2 = backup location ipaddress

#virsh suspend $1
scp $2:/backup/$1/etc/libvirt/qemu/$1.xml /etc/libvirt/qemu/$1.xml
scp $2:/backup/$1/var/lib/libvirt/images/$1.img /var/lib/libvirt/images/$1.img
#virsh start $1

