#!/bin/bash

BACKUP_DIR="$HOME/backups/ts-nop-vms"
DATE=$(date +%Y%m%d_%H%M%S)
mkdir -p "$BACKUP_DIR"

echo "Creating backup..."

# Backup files
tar -czf "$BACKUP_DIR/files_$DATE.tar.gz" \
    --exclude='node_modules' \
    --exclude='.git' \
    ./

# Backup database (if MySQL credentials available)
if [ -f "config/database.php" ]; then
    DB_HOST=$(grep "DB_HOST" config/database.php | cut -d"'" -f2)
    DB_NAME=$(grep "DB_NAME" config/database.php | cut -d"'" -f2)
    DB_USER=$(grep "DB_USER" config/database.php | cut -d"'" -f2)
    DB_PASS=$(grep "DB_PASS" config/database.php | cut -d"'" -f2)
    
    if [ ! -z "$DB_NAME" ]; then
        mysqldump -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_DIR/database_$DATE.sql"
        echo "✓ Database backed up"
    fi
fi

echo "✓ Backup saved to: $BACKUP_DIR"
echo "Keeping last 7 backups..."
ls -t "$BACKUP_DIR"/*.tar.gz | tail -n +8 | xargs rm -f
ls -t "$BACKUP_DIR"/*.sql | tail -n +8 | xargs rm -f 2>/dev/null
