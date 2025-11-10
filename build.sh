#!/bin/bash
set -e

# Download Composer if not exists
if [ ! -f composer.phar ]; then
    curl -sS https://getcomposer.org/installer | php
fi

# Install PHP dependencies
php composer.phar install --no-dev --optimize-autoloader --no-interaction

