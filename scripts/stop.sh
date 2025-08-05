#!/bin/bash

echo "Stopping TeenUp Student Management System..."

# Stop Docker containers
echo "Stopping Docker containers..."
docker-compose down

echo "Application stopped successfully!" 