#!/bin/bash

if [ "$EUID" -ne 0 ]
  then echo "This script must be run with root permissions."
  exit
fi


apt update
apt -y install php php-mysql apache2 acl mariadb-server openssh-server vim htop tree zip rsync
cd /var/www/html/
for i in {1..5}
do
    mkdir -p patient_files/$num
done

