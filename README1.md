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

    sudo apt install -y php libapache2-mod-php8.4 php8.4-mbstring php8.4-xmlrpc php8.4-gd php8.4-xml php8.4-intl php8.4-mysql php8.4-cli php8.4-zip php8.4-curl php8.4-posix php8.4-dev php8.4-redis php8.4-gmagick php8.4-gmp

Install packages to support data cache and proccessing media files

    apt install -y ghostscript libgraphicsmagick1-dev libpoppler-dev poppler-utils dcraw redis-server ffmpeg libimage-exiftool-perl libreoffice mediainfo 

Install Mysql and configure it. 

    sudo apt install -y mysql-server
    sudo systemctl start mysql
    sudo systemctl enable mysql

The following code should be run as root user.
database name: "acervo"
database user: "user"
database pass: "1123"

    mysql -uroot

the following code should be run in mysql console. 
    
    CREATE DATABASE acervo;
    CREATE USER user@localhost identified by '1123';
    GRANT ALL on acervo.* to user@localhost;

Install the package git and execute the command git clone. 
    sudo apt install git 
    sudo /var/www/html/
    
    sudo git clone https://github.com/reynaldocv/collectiveaccess-wikidata-ulan.git
    

    








