#!/bin/bash
# change_permissions.sh
# Se asume que el usuario de Apache es 'apache' (RHEL/CentOS)
# Si es Debian/Ubuntu, usar 'www-data'

echo "Cambiando permisos para el servidor web (www-data)..."
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
