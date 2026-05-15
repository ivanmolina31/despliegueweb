#!/bin/bash
# cleanup.sh
# Emula el 'cleanTargetFolder: true' de la pipeline original
echo "Limpiando directorio de destino /var/www/html..."
sudo rm -rf /var/www/html/*
