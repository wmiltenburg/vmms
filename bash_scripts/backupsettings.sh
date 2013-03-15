#!/bin/bash
#Author: Koen Veelenturf
# $vmname $username $ipaddress $when1 $days $vmlocation $xmllocation $directory $when2 $when3

case "$4" in
    "hourly")
    ;;

    "everyday")
    ;;

    *)
        $4="$4 at $9:$a"
    ;;
esac

if [ -f /etc/backup.d/$1.rdiff ]
then
    rm /etc/backup.d/$1.rdiff
echo "
# options = --force
when = $4

[source]
type = local
keep = $5D

# A few notes about includes and excludes:
# 1. include, exclude and vsinclude statements support globbing with '*'
# 2. Symlinks are not dereferenced. Moreover, an include line whose path
#    contains, at any level, a symlink to a directory, will only have the
#    symlink backed-up, not the target directory's content. Yes, you have to
#    dereference yourself the symlinks, or to use 'mount --bind' instead.
#    Example: let's say /home is a symlink to /mnt/crypt/home ; the following
#    line will only backup a "/home" symlink ; neither /home/user nor
#    /home/user/Mail will be backed-up :
#      include = /home/user/Mail
#    A workaround is to 'mount --bind /mnt/crypt/home /home' ; another one is to
#    write :
#      include = /mnt/crypt/home/user/Mail
# 3. All the excludes come after all the includes. The order is not otherwise
#    taken into account.

# files to include in the backup
include = $6
include = $7

######################################################
## destination section
## (where the files are copied to)

[dest]
type = remote
directory = $8
host = $3
user = $2" > /etc/backup.d/$1.rdiff
fi

if [ ! -f /etc/backup.d ]
then
echo "
# options = --force
when = $4

[source]
type = local
keep = $5D

# A few notes about includes and excludes:
# 1. include, exclude and vsinclude statements support globbing with '*'
# 2. Symlinks are not dereferenced. Moreover, an include line whose path
#    contains, at any level, a symlink to a directory, will only have the
#    symlink backed-up, not the target directory's content. Yes, you have to
#    dereference yourself the symlinks, or to use 'mount --bind' instead.
#    Example: let's say /home is a symlink to /mnt/crypt/home ; the following
#    line will only backup a "/home" symlink ; neither /home/user nor
#    /home/user/Mail will be backed-up :
#      include = /home/user/Mail
#    A workaround is to 'mount --bind /mnt/crypt/home /home' ; another one is to
#    write :
#      include = /mnt/crypt/home/user/Mail
# 3. All the excludes come after all the includes. The order is not otherwise
#    taken into account.

# files to include in the backup
include = $6
include = $7

######################################################
## destination section
## (where the files are copied to)

[dest]
type = remote
directory = $8
host = $3
user = $2" > /etc/backup.d/$1.rdiff
fi

chmod 600 /etc/backup.d/$1.rdiff

