#!/bin/bash

# BlizzCMS SSL Certificate Setup Script
# This script helps you obtain and renew SSL certificates using Certbot

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Load environment variables
if [ -f .env ]; then
    export $(cat .env | grep -v '^#' | xargs)
else
    echo -e "${RED}Error: .env file not found!${NC}"
    echo "Please copy .env.example to .env and configure your domain:"
    echo "  cp .env.example .env"
    exit 1
fi

# Check if DOMAIN is set
if [ -z "$DOMAIN" ]; then
    echo -e "${RED}Error: DOMAIN is not set in .env file!${NC}"
    echo "Please add DOMAIN=yourdomain.com to your .env file"
    exit 1
fi

# Check if EMAIL is set
if [ -z "$CERTBOT_EMAIL" ]; then
    echo -e "${RED}Error: CERTBOT_EMAIL is not set in .env file!${NC}"
    echo "Please add CERTBOT_EMAIL=your@email.com to your .env file"
    exit 1
fi

echo -e "${GREEN}=== BlizzCMS SSL Setup ===${NC}"
echo "Domain: $DOMAIN"
echo "Email: $CERTBOT_EMAIL"
echo ""

case "$1" in
    init)
        echo -e "${YELLOW}Step 1: Starting services with HTTP-only configuration...${NC}"
        
        # Use initial config (HTTP only)
        cp docker/nginx/conf.d/default-initial.conf docker/nginx/conf.d/active.conf
        
        # Create required directories
        mkdir -p docker/certbot/conf
        mkdir -p docker/certbot/www
        
        # Start nginx with HTTP only
        docker compose up -d nginx
        
        echo ""
        echo -e "${YELLOW}Step 2: Obtaining SSL certificate...${NC}"
        
        # Request certificate
        docker compose run --rm certbot certonly \
            --webroot \
            --webroot-path=/var/www/certbot \
            --email "$CERTBOT_EMAIL" \
            --agree-tos \
            --no-eff-email \
            -d "$DOMAIN" \
            -d "www.$DOMAIN"
        
        echo ""
        echo -e "${YELLOW}Step 3: Switching to HTTPS configuration...${NC}"
        
        # Use SSL config
        cp docker/nginx/conf.d/default.conf docker/nginx/conf.d/active.conf
        
        # Reload nginx with new config
        docker compose exec nginx nginx -s reload
        
        echo ""
        echo -e "${GREEN}=== SSL Setup Complete! ===${NC}"
        echo "Your site should now be available at https://$DOMAIN"
        ;;
        
    renew)
        echo -e "${YELLOW}Renewing SSL certificates...${NC}"
        docker compose run --rm certbot renew
        docker compose exec nginx nginx -s reload
        echo -e "${GREEN}Certificate renewal complete!${NC}"
        ;;
        
    dry-run)
        echo -e "${YELLOW}Testing certificate renewal (dry run)...${NC}"
        docker compose run --rm certbot renew --dry-run
        ;;
        
    status)
        echo -e "${YELLOW}Certificate status:${NC}"
        docker compose run --rm certbot certificates
        ;;
        
    *)
        echo "Usage: $0 {init|renew|dry-run|status}"
        echo ""
        echo "Commands:"
        echo "  init     - Initial SSL setup (run this first)"
        echo "  renew    - Renew SSL certificates"
        echo "  dry-run  - Test certificate renewal without making changes"
        echo "  status   - Show certificate status"
        exit 1
        ;;
esac
