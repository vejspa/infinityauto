FROM php:8.2-fpm

# Run as root user
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

# Copy Composer from the official Composer image
COPY --chmod=755 --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Create the php user and group before changing file ownerships
ARG USER_ID
ARG GROUP_ID
RUN groupadd -g $GROUP_ID php && \
    useradd -u $USER_ID -g $GROUP_ID -s /bin/bash -m php

# Set the working directory
WORKDIR /var/www

# Copy your application's source code into the image
COPY . /var/www

# Set the correct permissions for Symfony, suppressing errors if directories don't exist
RUN if [ -d "var" ] && [ -d "vendor" ]; then chown -R $USER_ID:$GROUP_ID var vendor; fi

# Switch to the non-root user for security
USER php

CMD ["php-fpm"]
