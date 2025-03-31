#!/bin/bash
sudo yum update -y
sudo amazon-linux-extras enable php8.0
sudo yum install -y php-cli php-pdo php-fpm php-mysqlnd mariadb httpd git unzip
sudo systemctl enable httpd
sudo systemctl start httpd
