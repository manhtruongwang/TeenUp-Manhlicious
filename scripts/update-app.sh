#!/bin/bash

echo "Copying application files to container..."

# Copy application files to the container
docker cp . teenup_app:/var/www/

# Set proper permissions
docker-compose exec app chown -R www-data:www-data /var/www
docker-compose exec app chmod -R 755 /var/www/storage
docker-compose exec app chmod -R 755 /var/www/bootstrap/cache

echo "Application files updated in container!" 