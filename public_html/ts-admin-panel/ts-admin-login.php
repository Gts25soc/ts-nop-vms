<?php
session_start();

// If already logged in, redirect
if (isset($_SESSION['ts_admin_logged_in'])) {
    header("Location: ts-admin-dashboard.php");
    exit();
}

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['ts_username'];
    $password = $_POST['ts_password'];
    
    // Check credentials
    if ($username === 'technosupport' && $password === 'VMS@2026Secure!') {
        $_SESSION['ts_admin_logged_in'] = true;
        $_SESSION['ts_admin_user'] = $username;
        header("Location: ts-admin-dashboard.php");
        exit();
    } else {
        $error_msg = 'Invalid credentials. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TS-NOP-VMS Admin Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%); 
            color: #fff; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
        }
        .login-container { 
            background: #111; 
            padding: 40px; 
            border-radius: 16px; 
            width: 100%; 
            max-width: 420px; 
            border: 1px solid #222;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .logo-area { 
            text-align: center; 
            margin-bottom: 30px; 
        }
        .logo-area h1 { 
            font-size: 28px; 
            color: #f46800; 
            margin-bottom: 5px;
        }
        .logo-area span { color: #fff; }
        .logo-area p { color: #888; font-size: 14px; }
        .error-box { 
            background: rgba(255,0,0,0.1); 
            border: 1px solid #ff0000; 
            color: #ff5f57; 
            padding: 12px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            font-size: 14px; 
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            color: #ccc; 
            font-size: 14px;
            font-weight: 500;
        }
        .form-group input { 
            width: 100%; 
            padding: 14px; 
            background: #222; 
            border: 1px solid #333; 
            color: #fff; 
            border-radius: 8px; 
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .form-group input:focus { 
            outline: none; 
            border-color: #f46800; 
        }
        .login-btn { 
            width: 100%; 
            padding: 14px; 
            background: linear-gradient(135deg, #f46800 0%, #ff7a1a 100%); 
            color: #fff; 
            border: none; 
            border-radius: 8px; 
            font-weight: 600; 
            cursor: pointer; 
            font-size: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .login-btn:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(244,104,0,0.4);
        }
        .back-link { 
            display: block; 
            margin-top: 20px; 
            color: #888; 
            text-decoration: none; 
            font-size: 13px; 
            text-align: center;
        }
        .back-link:hover { color: #f46800; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-area">
            <h1>TS-NOP<span>VMS</span></h1>
            <p>Admin Control Panel</p>
        </div>
        
        <?php if ($error_msg): ?>
            <div class="error-box">⚠️ <?php echo $error_msg; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="ts_username" placeholder="Enter username" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="ts_password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="login-btn">🔐 Login to Admin Panel</button>
        </form>

        <a href="/" class="back-link">← Back to Main Website</a>
    </div>
</body>
</html>