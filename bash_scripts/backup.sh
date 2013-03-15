#!/bin/bash
#Author: Wouter Miltenburg

echo "VM backup tool"
while true
do
echo "Do you want to backup a vm? yes/no."
read a
case "$a" in
    "yes")
            echo "Which vm?"


                read b
                echo "Which version?"
                read c
                virsh suspend $b
                mkdir /backup_images/$b.$c
                cp /var/lib/libvirt/images/$b.img /backup_images/$b.$c/
                echo Make a backup of the image
                cp /etc/libvirt/qemu/$b.xml /backup_images/$b.$c/
                echo Make a backup of the xml file
                virsh resume $b                
                echo "Backup is complete"
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
