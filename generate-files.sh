#!/bin/bash

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}TS-NOP-VMS File Generator${NC}"
echo "=========================="
echo ""

# Ask what to generate
echo "What would you like to generate?"
echo "1) New Feature Page"
echo "2) New Solution Category"
echo "3) Admin Panel Page"
echo "4) Database Migration"
echo "5) All (Complete Setup)"
echo ""
read -p "Enter choice (1-5): " choice

case $choice in
    1)
        read -p "Enter feature name (e.g., Helmet Detection): " feature_name
        feature_slug=$(echo "$feature_name" | tr '[:upper:]' '[:lower:]' | tr ' ' '-')
        
        # Create files
        mkdir -p "pages/features/$feature_slug"
        cat > "pages/features/$feature_slug/index.php" << PHPEOF
<?php
\$page_title = '$feature_name | TS-NOP-VMS';
require_once '../../config/database.php';
include '../../includes/header.php';
?>

<div class="feature-page" style="padding: 100px 5%;">
    <h1>$feature_name</h1>
    <p>Feature details coming soon...</p>
</div>

<?php include '../../includes/footer.php'; ?>
PHPEOF
        echo -e "${GREEN}✓ Created: pages/features/$feature_slug/index.php${NC}"
        ;;
        
    2)
        read -p "Enter solution name: " solution_name
        solution_slug=$(echo "$solution_name" | tr '[:upper:]' '[:lower:]' | tr ' ' '-')
        
        mkdir -p "pages/solutions/$solution_slug"
        echo "Created solution: $solution_slug"
        ;;
        
    3)
        read -p "Enter admin page name: " page_name
        page_slug=$(echo "$page_name" | tr '[:upper:]' '[:lower:]' | tr ' ' '_')
        
        cat > "ts-admin-panel/$page_slug.php" << PHPEOF
<?php
session_start();
if (!isset(\$_SESSION['admin_logged_in'])) {
    header("Location: ts-admin-login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>$page_name - Admin Panel</title>
</head>
<body>
    <h1>$page_name</h1>
</body>
</html>
PHPEOF
        echo -e "${GREEN}✓ Created: ts-admin-panel/$page_slug.php${NC}"
        ;;
        
    5)
        echo -e "${BLUE}Generating complete file structure...${NC}"
        # Run all generators
        source "$0" 1
        source "$0" 2
        source "$0" 3
        ;;
        
    *)
        echo "Invalid choice"
        ;;
esac
