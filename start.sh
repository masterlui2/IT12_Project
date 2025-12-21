#!/bin/bash

# --- Set up Nginx to listen on Render's dynamic PORT ---
# The PORT environment variable is provided by Render.
# This sed command dynamically updates nginx.conf at startup.
echo "Updating Nginx configuration to listen on port ${PORT}"
sed -i "s|listen 80;|listen ${PORT};|g" /etc/nginx/nginx.conf

# Verify the change (optional, for debugging)
cat /etc/nginx/nginx.conf

# --- Start PHP-FPM in the background ---
# This serves PHP requests that Nginx forwards
echo "Starting PHP-FPM..."
php-fpm -D

# --- Start Nginx in the foreground ---
# Render expects the main process to run in the foreground.
# This allows Render to monitor Nginx's health.
echo "Starting Nginx in foreground..."
nginx -g 'daemon off;'