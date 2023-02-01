#!/bin/bash

# check if we're running as root
if [ "$EUID" -ne 0 ]
  then echo "This script must be run with root permissions."
  exit
fi

# get user response
echo "This will install HackEMR and all dependencies to this server."
while true
do
    read -r -p 'Enter "y" to continue: ' choice
    case "$choice" in
      n|N) exit;;
      y|Y) break;;
      *) exit;;
    esac
done


# install dependencies
echo "-- Installing dependencies..."
apt update
apt -y install php php-mysql apache2 acl mariadb-server openssh-server vim htop tree zip rsync

# create working directory if it doesn't exist for some reason
mkdir -p /var/www/html/

# copy files to working directory and create test file structure
echo "-- Copying files..."
rsync -aPvr * /var/www/html/

echo "-- Setting up working directory..."
chown -R www-data /var/www 
chgrp -R www-data /var/www 
cd /var/www/html/
for i in {1..5}
do
    mkdir -p patient_files/$num
done

echo "-- Configuring SQL server..."
cd sql
chmod +x runasroot.sh
./runasroot.sh