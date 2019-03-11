#!/bin/bash

# Needs to be copied into "Startup Script" section of Settings.
if [ -e /var/www/html/codevolve/apache/default.conf ]
then
    cp /var/www/html/codevolve/apache/default.conf /etc/apache2/sites-enabled/
    rm /etc/apache2/sites-enabled/000-default.conf
    sudo service apache2 restart
fi

if [ -e /var/www/html/codevolve/app/config.php ]
then
    cp /var/www/html/codevolve/app/config.php /var/www/html/config/config.php
fi

if [ -e /var/www/html/codevolve/app/config_db.php ]
then
    cp /var/www/html/codevolve/app/config_db.php /var/www/html/config/config_db.php
fi

touch /root/.bashrcs/setBashDirectory.sh
printf '#!bin/bash\ncd /var/www/html' >> /root/.bashrcs/setBashDirectory.sh