#!/bin/bash
# update_db.sh
# Se ejecuta DESPUÉS de copiar los archivos de la web

DB_HOST="IP_DE_TU_BBDD" # Cámbiala por la IP de imc-bbdd-pro
DB_PASS="Admin123!"

echo "Actualizando base de datos desde la instancia local..."
sudo mysql -h $DB_HOST -u root -p$DB_PASS < /var/www/html/db.sql
