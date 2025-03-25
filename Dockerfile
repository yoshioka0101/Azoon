# Laravelに最適なPHP 8.1とApache環境
FROM php:8.1-apache

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd bcmath

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ドキュメントルートを設定
WORKDIR /var/www/html

# Laravelプロジェクトをコピー
COPY ./src /var/www/html

# Apacheの設定を修正
RUN a2enmod rewrite

# 権限の設定（ディレクトリが存在しなくてもスキップ可能にする）
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
