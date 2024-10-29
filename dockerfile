# PHP 8.2.10 Apacheイメージをベースに使用
FROM php:8.2.10-apache

# 必要なライブラリと拡張機能のインストール
RUN apt update \
    && apt install -y \
        g++ \
        libicu-dev \
        libpq-dev \
        libzip-dev \
        zip \
        zlib1g-dev \
        npm \
        nodejs \
        vim \
    && docker-php-ext-install \
        intl \
        opcache \
        pdo \
        pdo_pgsql \
        pdo_mysql \
        pgsql \
    && a2enmod rewrite  # mod_rewriteを有効にする

# 作業ディレクトリを設定
WORKDIR /var/www/test

# Apacheの設定ファイルをコピー
COPY ./apache/default.conf /etc/apache2/sites-available/000-default.conf

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# アプリケーションコードをコンテナにコピー
COPY . .

# composerを使う前にユーザーをrootに戻す
USER root

# Composerで依存関係をインストール
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# www-dataユーザーに戻す
USER www-data

# コンテナ起動時のデフォルトコマンド
CMD ["apache2-foreground"]
