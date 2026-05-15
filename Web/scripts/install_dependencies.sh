#!/bin/bash
# install_dependencies.sh
sudo apt-get update
sudo apt-get install -y apache2 php libapache2-mod-php php-mysql
sudo systemctl enable apache2
sudo systemctl start apache2
