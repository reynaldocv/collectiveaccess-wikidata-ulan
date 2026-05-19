## Collectiveaccess 2.0.11 - wikidata and ulan plugin 

### Install Collectiveaccess 2.0.11 on Ubuntu 22.04

Install apache2 

    sudo apt install -y apache2
    sudo systemctl enable apache2.service
    sudo systemctl start apache2.service

Install repository 

    sudo apt -y install software-properties-common
    sudo add-apt-repository ppa:ondrej/php

Install PHP 8.2

    sudo apt install -y php libapache2-mod-php8.2 php8.2-mbstring php8.2-xmlrpc php8.2-gd php8.2-xml php8.2-intl php8.2-mysql php8.2-cli php8.2-zip php8.2-curl php8.2-posix php8.2-dev php8.2-redis php8.2-gmagick php8.2-gmp

Install Mysql and configure it. 

