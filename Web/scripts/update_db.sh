#!/bin/bash
# update_db.sh
# Se ejecuta DESPUÉS de copiar los archivos de la web

DB_HOST="10.20.1.240" # IP de imc-bbdd-pro
DB_PASS="Admin123!"

echo "Actualizando base de datos desde la instancia local..."
sudo mysql -h $DB_HOST -u root -p$DB_PASS < /var/www/html/db.sql
