#!/bin/bash

# Main automation menu
while true; do
    clear
    echo "================================"
    echo "  TS-NOP-VMS Automation Suite  "
    echo "================================"
    echo ""
    echo "1) 🚀 Deploy to Hostinger"
    echo "2) 📝 Generate New Files"
    echo "3) 💾 Create Backup"
    echo "4) 🔄 Sync from Hostinger"
    echo "5) 🧪 Run Tests"
    echo "6) 📊 View Project Stats"
    echo "7) ⚙️  Update Configuration"
    echo "0) Exit"
    echo ""
    read -p "Select option (0-7): " option
    
    case $option in
        1)
            ./deploy.sh
            read -p "Press Enter to continue..."
            ;;
        2)
            ./generate-files.sh
            read -p "Press Enter to continue..."
            ;;
        3)
            ./backup.sh
            read -p "Press Enter to continue..."
            ;;
        4)
            echo "Downloading from Hostinger..."
            # Add lftp mirror command here
            read -p "Press Enter to continue..."
            ;;
        5)
            echo "Running tests..."
            # Add test commands here
            read -p "Press Enter to continue..."
            ;;
        6)
            echo "Project Statistics:"
            echo "==================="
            echo "Total PHP files: $(find . -name "*.php" | wc -l)"
            echo "Total CSS files: $(find . -name "*.css" | wc -l)"
            echo "Total JS files: $(find . -name "*.js" | wc -l)"
            echo "Total Images: $(find ./assets/images -type f | wc -l)"
            echo ""
            read -p "Press Enter to continue..."
            ;;
        7)
            nano config.json
            echo "Configuration updated!"
            read -p "Press Enter to continue..."
            ;;
        0)
            echo "Goodbye!"
            exit 0
            ;;
        *)
            echo "Invalid option"
            read -p "Press Enter to continue..."
            ;;
    esac
done
