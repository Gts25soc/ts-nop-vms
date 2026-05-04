<?php require_once 'ts-auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TS-NOP-VMS Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { 
            --ts-primary: #f46800; 
            --ts-dark: #0a0a0a; 
            --ts-dark2: #111; 
            --ts-dark3: #1a1a1a; 
            --ts-gray: #888; 
            --ts-light: #ccc; 
            --ts-white: #fff; 
        }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: var(--ts-dark); 
            color: var(--ts-white); 
            min-height: 100vh; 
            display: flex; 
        }
        
        /* Sidebar */
        .ts-sidebar { 
            width: 260px; 
            background: var(--ts-dark2); 
            border-right: 1px solid #222; 
            padding: 25px; 
            flex-shrink: 0; 
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .ts-sidebar .ts-logo { 
            font-size: 22px; 
            font-weight: 800; 
            margin-bottom: 40px; 
            color: var(--ts-primary); 
            padding-bottom: 20px;
            border-bottom: 1px solid #222;
        }
        .ts-sidebar .ts-logo span { color: var(--ts-white); }
        .ts-nav-item { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 14px; 
            border-radius: 8px; 
            color: var(--ts-gray); 
            text-decoration: none; 
            margin-bottom: 6px; 
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }
        .ts-nav-item:hover, .ts-nav-item.active { 
            background: rgba(244,104,0,0.15); 
            color: var(--ts-primary); 
        }
        .ts-nav-item i { width: 20px; text-align: center; }
        .ts-logout { 
            margin-top: 30px; 
            color: #ff5f57 !important; 
            border-top: 1px solid #222;
            padding-top: 15px;
        }
        
        /* Main Content */
        .ts-main { 
            flex: 1; 
            padding: 30px; 
            margin-left: 260px;
        }
        .ts-top-bar { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #222;
        }
        .ts-top-bar h1 { font-size: 26px; font-weight: 700; }
        .ts-user-info { 
            display: flex; 
            align-items: center; 
            gap: 12px;
            background: var(--ts-dark2);
            padding: 10px 20px;
            border-radius: 8px;
        }
        .ts-avatar { 
            width: 40px; 
            height: 40px; 
            border-radius: 50%; 
            background: var(--ts-primary); 
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
    <div class="logo">
        <img src="/logo.png" alt="TS-NOP-VMS" style="height: 50px; width: auto;">
        <span style="color: #fff;">TS-NOP<span style="color: #f46800;">VMS</span></span>
    </div>
    <!-- rest of sidebar -->
</aside>
            <a href="/ts-admin-panel/ts-admin-dashboard.php" class="ts-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'ts-admin-dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="/ts-admin-panel/ts-admin-leads.php" class="ts-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'ts-admin-leads.php' ? 'active' : ''; ?>">
                <i class="fas fa-inbox"></i> Leads & Contacts
            </a>
            <a href="/ts-admin-panel/ts-admin-videos.php" class="ts-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'ts-admin-videos.php' ? 'active' : ''; ?>">
                <i class="fas fa-video"></i> Manage Videos
            </a>
            <a href="/ts-admin-panel/ts-upload-video.php" class="ts-nav-item">
                <i class="fas fa-upload"></i> Upload Video
            </a>
            <a href="/" target="_blank" class="ts-nav-item">
                <i class="fas fa-external-link-alt"></i> View Website
            </a>
            <a href="/ts-admin-panel/ts-admin-logout.php" class="ts-nav-item ts-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="ts-main">