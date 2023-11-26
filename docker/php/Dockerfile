FROM php:8.1-fpm

USER root

# Install system dependencies including gnupg for key management
RUN apt-get update && apt-get install -y \
    git \
    zip \
    curl \
    unzip \
    unixodbc-dev \
    g++ \
    make \
    gnupg

# Install Microsoft ODBC Driver for SQL Server
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql17

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql \
    && pecl install pdo_sqlsrv sqlsrv \
    && docker-php-ext-enable pdo_sqlsrv sqlsrv

# Copy Composer from the official Composer image
COPY --chmod=755 --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www

ARG USER_ID
ARG GROUP_ID

# Configure the user and group for Debian
RUN groupadd -g $GROUP_ID php \
    && useradd -u $USER_ID -g $GROUP_ID -s /bin/bash -m php

USER php

CMD ["php-fpm"]
