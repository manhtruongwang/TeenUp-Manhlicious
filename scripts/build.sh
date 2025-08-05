#!/bin/bash

echo "Building TeenUp Student Management System..."

# Create .env file if it doesn't exist
if [ ! -f .env-docker ]; then
    echo "Creating .env-docker file..."
    cp .env.example .env-docker
fi

# Build Docker images
echo "Building Docker images..."
docker-compose build

echo "Build completed successfully!"

echo "Starting TeenUp Student Management System..."

# Start Docker containers
echo "Starting Docker containers..."
docker-compose up -d

# Wait for database to be ready
echo "Waiting for database to be ready..."
sleep 15

# Run migrations
echo "Running database migrations..."
docker-compose exec app php artisan migrate --force

# Run seeders
echo "Running database seeders..."
docker-compose exec app php artisan db:seed --force

# Clear and cache config
echo "Optimizing application..."
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

echo "Application is running!"
echo "Access the application at: http://localhost:8000"
echo "Database is accessible at: localhost:5432"
echo ""
echo "To stop the application, run: scripts/stop.sh" 