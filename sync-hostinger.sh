#!/bin/bash

# ==========================================
# TS-NOP-VMS Auto-Sync to Hostinger (SFTP + IPv4 Fix)
# ==========================================

SFTP_HOST="linen-starling-198005.hostingersite.com"
SFTP_USER="u633257833.linen-starling-198005.hostingersite.com"
SFTP_PASS="Technosupport@2026"
REMOTE_DIR="/public_html"
LOCAL_DIR="./public_html"

echo "🚀 Starting SFTP Sync to Hostinger..."

if [ ! -d "$LOCAL_DIR" ]; then
    echo "❌ Error: Local directory $LOCAL_DIR not found!"
    exit 1
fi

# Run LFTP Mirror via SFTP Protocol with IPv4 forced
lftp -c "
set sftp:auto-confirm yes
set net:timeout 60
set dns:order inet           # <--- THIS FORCES IPV4
open sftp://$SFTP_USER:$SFTP_PASS@$SFTP_HOST
mirror --reverse --delete --verbose \
    --exclude-glob=*.log \
    --exclude-glob=.git* \
    --exclude-glob=sync-hostinger.sh \
    --exclude-glob=.gitignore \
    --exclude-glob=node_modules \
    $LOCAL_DIR $REMOTE_DIR
bye
"

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ SUCCESS! Files synced to Hostinger via SFTP."
else
    echo ""
    echo "❌ FAILED! Check credentials or network."
    exit 1
fi
