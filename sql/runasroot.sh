#!/bin/bash

apt update
apt -y install mariadb-server
mariadb < db_init.sql
mariadb < auth_db.sql
mariadb < patient.sql
mariadb < tips.db