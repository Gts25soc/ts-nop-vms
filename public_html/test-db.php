<?php
echo "<h1>Database Connection Test</h1>";

// Try direct connection
$conn = new mysqli('localhost', 'u633257833_admin', 'TechnoVMS2026!', 'u633257833_vms');

if ($conn->connect_error) {
    echo "<p style='color:red'>❌ Connection FAILED: " . $conn->connect_error . "</p>";
    echo "<p><strong>Debug Info:</strong></p>";
    echo "<ul>";
    echo "<li>Host: localhost</li>";
    echo "<li>User: u633257833_admin</li>";
    echo "<li>Database: u633257833_vms</li>";
    echo "</ul>";
} else {
    echo "<p style='color:green'>✅ Connection SUCCESSFUL!</p>";
    
    // Check if features table exists
    $result = $conn->query("SELECT COUNT(*) as total FROM features");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>Features in database: <strong>" . $row['total'] . "</strong></p>";
    } else {
        echo "<p style='color:orange'>⚠️ Features table not found!</p>";
    }
}

$conn->close();
?>