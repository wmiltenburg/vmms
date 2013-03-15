#!/bin/bash
#Author: Wouter Miltenburg

echo "VM removal tool"
while true
do
echo "Do you want to remove a vm? yes/no."
read a
case "$a" in
    "yes")
            echo "Which vm?"


                read b
                virsh destroy $b
                virsh undefine $b
                rm -rf /var/lib/libvirt/$b.img
                echo "Image is removed"
                echo "VM $b is removed"
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
