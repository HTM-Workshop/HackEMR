#!/bin/bash

mariadb < db_init.sql
mariadb < auth_db.sql
mariadb < patient.sql
mariadb < tips.sql