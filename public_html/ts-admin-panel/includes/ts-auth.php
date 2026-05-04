<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['ts_admin_logged_in']) || $_SESSION['ts_admin_logged_in'] !== true) {
    header("Location: /ts-admin-panel/ts-admin-login.php");
    exit();
}

// Admin credentials - CHANGE THESE!
define('TS_ADMIN_USER', 'technosupport');
define('TS_ADMIN_PASS', 'VMS@2026Secure!');
?>