<?php
// Website Header - Used by all public pages
if (!isset($page_title)) {
    $page_title = 'TS-NOP-VMS - AI-Powered Video Management System';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #f46800;
            --primary-hover: #ff7a1a;
            --dark: #0a0a0a;
            --dark2: #111111;
            --gray: #888888;
            --light-gray: #cccccc;
            --white: #ffffff;
            --border-color: rgba(255, 255, 255, 0.1);
            --header-height: 80px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--dark);
            color: var(--white);
            line-height: 1.6;
            overflow-x: hidden;
            padding-top: var(--header-height);
        }

        /* --- Navigation Bar --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 5%;
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            height: var(--header-height);
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .navbar-logo img {
            height: 45px;
            width: auto;
            max-width: 150px;
            object-fit: contain;
            transition: transform 0.3s;
        }

        .navbar-logo:hover img { transform: scale(1.05); }

        .navbar-logo .logo-text { display: flex; flex-direction: column; line-height: 1.2; }
        .navbar-logo .logo-title { font-size: 20px; font-weight: 800; color: var(--white); }
        .navbar-logo .logo-title span { color: var(--primary); }
        .navbar-logo .logo-subtitle { font-size: 9px; color: var(--gray); text-transform: uppercase; letter-spacing: 1px; }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 28px;
            align-items: center;
        }

        .nav-links a {
            color: var(--light-gray);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 8px 0;
        }

        .nav-links a:hover,
        .nav-links a.active { color: var(--primary); }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after { width: 100%; }

        .auth-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
            white-space: nowrap;
        }

        .btn-outline {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: 1px solid var(--primary);
            box-shadow: 0 4px 15px rgba(244, 104, 0, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(244, 104, 0, 0.4);
        }

        .mobile-toggle {
            display: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .mobile-toggle:hover { background: rgba(255,255,255,0.1); }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            position: fixed;
            top: var(--header-height);
            left: 0;
            right: 0;
            background: rgba(10, 10, 10, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            padding: 20px 5%;
            z-index: 999;
            flex-direction: column;
            gap: 15px;
            animation: slideDown 0.3s ease;
        }

        .mobile-menu.active { display: flex; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .mobile-menu a {
            color: var(--light-gray);
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            transition: color 0.3s;
        }

        .mobile-menu a:hover,
        .mobile-menu a.active { color: var(--primary); }

        .mobile-auth {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 10px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }

        .mobile-auth .btn {
            width: 100%;
            justify-content: center;
            padding: 12px;
            font-size: 15px;
        }

        /* ========== RESPONSIVE BREAKPOINTS ========== */
        
        /* Large Desktop (1440px+) */
        @media (min-width: 1440px) {
            .navbar { padding: 12px 8%; }
            .nav-links { gap: 35px; }
            .nav-links a { font-size: 15px; }
        }

        /* Desktop (1025px - 1439px) */
        @media (min-width: 1025px) and (max-width: 1439px) {
            .navbar { padding: 12px 4%; }
            .nav-links { gap: 24px; }
        }

        /* Tablet Landscape (769px - 1024px) */
        @media (min-width: 769px) and (max-width: 1024px) {
            .navbar { padding: 12px 3%; }
            .nav-links { gap: 18px; }
            .nav-links a { font-size: 13px; }
            .btn { padding: 8px 16px; font-size: 13px; }
            .navbar-logo img { height: 40px; }
            .navbar-logo .logo-title { font-size: 18px; }
            .navbar-logo .logo-subtitle { display: none; }
        }

        /* Tablet Portrait (577px - 768px) */
        @media (min-width: 577px) and (max-width: 768px) {
            .nav-links { display: none; }
            .auth-buttons { display: none; }
            .mobile-toggle { display: block; }
            .navbar-logo img { height: 40px; }
            .navbar-logo .logo-title { font-size: 18px; }
            .navbar-logo .logo-subtitle { display: none; }
        }

        /* Mobile (320px - 576px) */
        @media (max-width: 576px) {
            .navbar { padding: 10px 4%; height: 70px; }
            body { padding-top: 70px; }
            
            .nav-links { display: none; }
            .auth-buttons { display: none; }
            .mobile-toggle { display: block; font-size: 22px; }
            
            .navbar-logo img { height: 36px; max-width: 120px; }
            .navbar-logo .logo-title { font-size: 16px; }
            .navbar-logo .logo-subtitle { display: none; }
            
            .mobile-menu { top: 70px; padding: 15px 4%; }
            .mobile-menu a { font-size: 15px; padding: 10px 0; }
            .mobile-auth .btn { padding: 10px; font-size: 14px; }
        }

        /* Small Mobile (320px - 375px) */
        @media (max-width: 375px) {
            .navbar-logo .logo-title { font-size: 14px; }
            .btn { padding: 8px 14px; font-size: 12px; }
            .mobile-auth .btn { padding: 10px; font-size: 13px; }
        }

        /* Touch Optimization */
        @media (hover: none) and (pointer: coarse) {
            .nav-links a,
            .btn,
            .mobile-toggle,
            .mobile-menu a {
                min-height: 44px;
                display: flex;
                align-items: center;
            }
        }
    </style>
</head>
<body>

    <!-- Website Navigation Bar -->
    <nav class="navbar">
        <!-- Logo Section -->
        <a href="/" class="navbar-logo">
            <img src="/logo.png" alt="TS-NOP-VMS">
            <div class="logo-text">
                <div class="logo-title">TS-NOP<span>VMS</span></div>
                <div class="logo-subtitle">TECHNO SUPPORT CORE INNOVATIONS</div>
            </div>
        </a>
        
        <!-- Desktop Navigation Links -->
        <ul class="nav-links">
            <li><a href="/" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
            <li><a href="/pages/features/index.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'features') !== false ? 'active' : ''; ?>">Features</a></li>
            <li><a href="/pages/solutions/index.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'solutions') !== false ? 'active' : ''; ?>">Solutions</a></li>
            <li><a href="/pages/company/about.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'about') !== false ? 'active' : ''; ?>">About Us</a></li>
            <li><a href="/pages/company/contact.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'contact') !== false ? 'active' : ''; ?>">Contact</a></li>
        </ul>
        
        <!-- Desktop Auth Buttons -->
        <div class="auth-buttons">
            <a href="/ts-admin-panel/ts-admin-login.php" class="btn btn-outline">
                <i class="fas fa-lock"></i> <span class="hide-mobile">Admin</span>
            </a>
            <a href="/pages/company/contact.php" class="btn btn-primary">
                Get Started <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Toggle menu">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="/" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">🏠 Home</a>
        <a href="/pages/features/index.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'features') !== false ? 'active' : ''; ?>">⚙️ Features</a>
        <a href="/pages/solutions/index.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'solutions') !== false ? 'active' : ''; ?>">💡 Solutions</a>
        <a href="/pages/company/about.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'about') !== false ? 'active' : ''; ?>">👥 About Us</a>
        <a href="/pages/company/contact.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'contact') !== false ? 'active' : ''; ?>">📞 Contact</a>
        
        <div class="mobile-auth">
            <a href="/ts-admin-panel/ts-admin-login.php" class="btn btn-outline">
                <i class="fas fa-lock"></i> Admin Login
            </a>
            <a href="/pages/company/contact.php" class="btn btn-primary">
                Get Started <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const toggleBtn = document.querySelector('.mobile-toggle i');
            
            mobileMenu.classList.toggle('active');
            
            // Toggle icon
            if (mobileMenu.classList.contains('active')) {
                toggleBtn.classList.remove('fa-bars');
                toggleBtn.classList.add('fa-times');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            } else {
                toggleBtn.classList.remove('fa-times');
                toggleBtn.classList.add('fa-bars');
                document.body.style.overflow = '';
            }
        }

        // Close mobile menu when clicking a link
        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                const mobileMenu = document.getElementById('mobileMenu');
                const toggleBtn = document.querySelector('.mobile-toggle i');
                mobileMenu.classList.remove('active');
                toggleBtn.classList.remove('fa-times');
                toggleBtn.classList.add('fa-bars');
                document.body.style.overflow = '';
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            const mobileMenu = document.getElementById('mobileMenu');
            const toggleBtn = document.querySelector('.mobile-toggle');
            
            if (!mobileMenu.contains(e.target) && !toggleBtn.contains(e.target) && mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                toggleBtn.querySelector('i').classList.remove('fa-times');
                toggleBtn.querySelector('i').classList.add('fa-bars');
                document.body.style.overflow = '';
            }
        });

        // Handle resize - close mobile menu if screen gets larger
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                const mobileMenu = document.getElementById('mobileMenu');
                mobileMenu.classList.remove('active');
                document.querySelector('.mobile-toggle i').classList.remove('fa-times');
                document.querySelector('.mobile-toggle i').classList.add('fa-bars');
                document.body.style.overflow = '';
            }
        });
    </script>