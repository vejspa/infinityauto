FROM php:8.1-fpm-alpine

USER root

# Install system dependencies and PHP extensions
RUN apk add \
    git \
    zip \
    curl \
    unzip \
    # Install PHP extensions using PECL or from official repositories
    && docker-php-ext-install pdo pdo_mysql # Add more extensions as needed

COPY --chmod=755 --from=composer:latest /usr/bin/composer /usr/local/bin/

WORKDIR /var/www

ARG USER_ID
ARG GROUP_ID

    # Remove user with the same uid if it exists
RUN (deluser --remove-home $(getent passwd $USER_ID | cut -d: -f1) || true) \
    # Remove user php
    && (deluser --remove-home php || true) \
    && apk add shadow \
    # Add group for php if it does not already exist
    && groupadd -g $GROUP_ID -f php \
    # Add user php
    && useradd -u $USER_ID -g $GROUP_ID -s /bin/bash -d /home/php -m php

USER php

CMD ["php-fpm"]