#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}==================================${NC}"
echo -e "${GREEN}TS-NOP-VMS Deployment Script${NC}"
echo -e "${GREEN}==================================${NC}"

# Configuration - UPDATE THESE WITH YOUR DETAILS
FTP_HOST="your-hostinger-ftp-host"  # e.g., ftp.hostingersite.com
FTP_USER="your-ftp-username"
FTP_PASS="your-ftp-password"
REMOTE_PATH="/public_html"

# Ask for confirmation
echo -e "${YELLOW}This will deploy to:${NC}"
echo -e "  Host: $FTP_HOST"
echo -e "  User: $FTP_USER"
echo -e "  Path: $REMOTE_PATH"
echo ""
read -p "Continue deployment? (y/n): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${RED}Deployment cancelled.${NC}"
    exit 1
fi

# Create deployment package
echo -e "${YELLOW}Creating deployment package...${NC}"
TEMP_DIR=$(mktemp -d)
rsync -av --exclude-from='.gitignore' ./ "$TEMP_DIR/"

# Upload via lftp
echo -e "${GREEN}Uploading files to Hostinger...${NC}"
lftp -c "
set ssl:verify-certificate no
open ftp://$FTP_USER:$FTP_PASS@$FTP_HOST
mirror --reverse --delete --verbose --only-glob='*' $TEMP_DIR $REMOTE_PATH
bye
"

# Cleanup
rm -rf "$TEMP_DIR"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}==================================${NC}"
    echo -e "${GREEN}✅ Deployment Successful!${NC}"
    echo -e "${GREEN}==================================${NC}"
    echo -e "Visit: https://your-domain.com"
else
    echo -e "${RED}==================================${NC}"
    echo -e "${RED}❌ Deployment Failed!${NC}"
    echo -e "${RED}==================================${NC}"
    exit 1
fi
