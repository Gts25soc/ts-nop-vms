<?php
session_start();
session_unset();
session_destroy();
header("Location: ts-admin-login.php");
exit();
?>