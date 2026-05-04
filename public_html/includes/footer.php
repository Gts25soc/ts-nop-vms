<!-- Final Polished AI Footer with Full Responsiveness -->
<footer style="position: relative; background-color: #080808; border-top: 1px solid rgba(255,255,255,0.05); overflow: hidden;">
    
    <!-- Subtle Background Glow -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 20% 20%, rgba(244,104,0,0.08) 0%, transparent 40%), radial-gradient(circle at 80% 80%, rgba(59,130,246,0.05) 0%, transparent 40%); pointer-events: none;"></div>

    <div class="footer-wrapper" style="max-width: 1440px; margin: 0 auto; padding: 80px 5% 40px; position: relative; z-index: 2;">
        
        <!-- Main Grid Layout -->
        <div class="footer-grid" style="display: grid; grid-template-columns: 1.4fr 1fr 1fr 1fr 1fr; gap: 40px; align-items: start; margin-bottom: 60px;">
            
            <!-- Column 1: Brand & Contact (Wider) -->
            <div class="footer-brand" style="padding-right: 20px;">
                <!-- Logo -->
                <a href="/" style="display: flex; align-items: center; gap: 12px; text-decoration: none; margin-bottom: 24px;">
                    <img src="/logo.png" alt="TS-NOP-VMS" style="height: 42px; width: auto;">
                    <div style="font-size: 23px; font-weight: 800; color: white; letter-spacing: -0.5px; line-height: 1;">
                        TS-NOP<span style="color: var(--primary);">VMS</span>
                    </div>
                </a>
                
                <!-- Glassmorphism Contact Card -->
                <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 20px; backdrop-filter: blur(10px); margin-bottom: 24px;">
                    <h5 style="color: white; font-size: 14px; font-weight: 600; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-headset" style="color: var(--primary);"></i> Connect With Us
                    </h5>
                    <a href="tel:+918660160366" style="display: flex; align-items: center; gap: 10px; color: #ccc; text-decoration: none; font-size: 14px; margin-bottom: 10px; transition: 0.3s;">
                        <i class="fas fa-phone-alt" style="width: 16px; color: var(--primary);"></i> +91 8660160366
                    </a>
                    <a href="mailto:info@tsglobe.com" style="display: flex; align-items: center; gap: 10px; color: #ccc; text-decoration: none; font-size: 14px; transition: 0.3s;">
                        <i class="fas fa-envelope" style="width: 16px; color: var(--primary);"></i> info@tsglobe.com
                    </a>
                </div>
            </div>

            <!-- Columns 2-5: Links -->
            <?php 
            $links = [
                'Product' => [['Features', '/pages/features/index.php'], ['Live Dashboard', '/pages/dashboard/'], ['Traffic AI', '/pages/features/category.php?slug=traffic'], ['Smart City', '/pages/features/category.php?slug=smart-city'], ['Defence', '/pages/features/category.php?slug=defence']],
                'Solutions' => [['Government', '/pages/solutions/index.php#government'], ['Enterprise', '/pages/solutions/index.php#enterprise'], ['SMEs', '/pages/solutions/index.php#smes'], ['Partners', '/pages/solutions/index.php#partners']],
                'Company' => [['About Us', '/pages/company/about.php'], ['Careers', '/pages/company/careers.php'], ['Contact', '/pages/company/contact.php'], ['Blog', '#']],
                'Support' => [['Documentation', '#'], ['API Reference', '#'], ['Help Center', '#'], ['Privacy Policy', '/pages/company/privacy.php']]
            ];

            foreach($links as $title => $items): 
            ?>
                <div class="footer-col">
                    <h4 style="color: white; font-size: 14px; font-weight: 700; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 1px; position: relative; display: inline-block;">
                        <?php echo $title; ?>
                        <span style="position: absolute; bottom: -8px; left: 0; width: 24px; height: 2px; background: var(--primary); border-radius: 2px;"></span>
                    </h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <?php foreach($items as $item): ?>
                            <li style="margin-bottom: 14px;">
                                <a href="<?php echo $item[1]; ?>" style="color: #888; text-decoration: none; font-size: 14px; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 6px;">
                                    <span style="width: 0; height: 1px; background: var(--primary); transition: width 0.3s ease;"></span>
                                    <?php echo $item[0]; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Side-by-Side Addresses -->
        <div class="footer-addresses" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 60px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.05);">
            
            <!-- Vijayapur Address -->
            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <div style="min-width: 40px; height: 40px; background: rgba(244,104,0,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 18px;">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <h6 style="color: white; font-size: 14px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Vijayapur HQ</h6>
                    <p style="color: #888; font-size: 13px; line-height: 1.6; margin: 0;">
                        Opp Al Ameen 2nd Gate, Athani Road,<br>
                        Navarspur, Vijayapur - 586108, Karnataka
                    </p>
                </div>
            </div>

            <!-- Bangalore Address -->
            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <div style="min-width: 40px; height: 40px; background: rgba(59,130,246,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #3b82f6; font-size: 18px;">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <h6 style="color: white; font-size: 14px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Bangalore Branch</h6>
                    <p style="color: #888; font-size: 13px; line-height: 1.6; margin: 0;">
                        Techno Support, Railway Parallel Rd, 4th Block,<br>
                        Kumara Park West, Sampangiram Nagar,<br>
                        Bengaluru, Karnataka 560020
                    </p>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom" style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div style="color: #666; font-size: 13px;">
                © <?php echo date('Y'); ?> <strong style="color: #fff;">Techno Support Core Innovations Pvt. Ltd.</strong> All rights reserved.
            </div>
            
            <!-- Social Icons -->
            <div class="social-links" style="display: flex; gap: 12px;">
                <?php 
                $socials = [
                    ['fab fa-linkedin-in', '#'],
                    ['fab fa-twitter', '#'],
                    ['fab fa-youtube', '#'],
                    ['fab fa-github', '#']
                ];
                foreach($socials as $icon): 
                ?>
                    <a href="<?php echo $icon[1]; ?>" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.05); border-radius: 50%; color: #fff; font-size: 14px; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: 1px solid rgba(255,255,255,0.1);" aria-label="<?php echo $icon[0]; ?>">
                        <i class="<?php echo $icon[0]; ?>"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Hover Effects */
    .footer-col ul li a:hover {
        color: #fff !important;
        transform: translateX(4px);
    }
    .footer-col ul li a:hover span { width: 8px; }
    
    .footer-wrapper a[style*="width: 36px"]:hover {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(244, 104, 0, 0.3);
    }

    /* ========== RESPONSIVE BREAKPOINTS ========== */
    
    /* Large Desktop (1440px+) */
    @media (min-width: 1440px) {
        .footer-wrapper { padding: 100px 8% 50px; }
        .footer-grid { gap: 50px; }
    }

    /* Desktop (1025px - 1439px) */
    @media (min-width: 1025px) and (max-width: 1439px) {
        .footer-wrapper { padding: 80px 4% 40px; }
        .footer-grid { gap: 35px; }
    }

    /* Tablet Landscape (769px - 1024px) */
    @media (min-width: 769px) and (max-width: 1024px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr 1fr;
            gap: 30px;
        }
        .footer-brand { grid-column: span 3; padding-right: 0; margin-bottom: 20px; }
        .footer-addresses { grid-template-columns: 1fr 1fr; gap: 25px; }
    }

    /* Tablet Portrait (577px - 768px) */
    @media (min-width: 577px) and (max-width: 768px) {
        .footer-wrapper { padding: 60px 4% 30px; }
        
        .footer-grid {
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .footer-brand { grid-column: span 2; margin-bottom: 30px; }
        
        .footer-addresses {
            grid-template-columns: 1fr;
            gap: 25px;
        }
        
        .footer-bottom {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }
        .footer-bottom > div:first-child { order: 2; }
        .footer-bottom > div:last-child { order: 1; }
    }

    /* Mobile (320px - 576px) */
    @media (max-width: 576px) {
        .footer-wrapper { padding: 50px 4% 30px; }
        
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 35px;
        }
        .footer-brand { grid-column: span 1; margin-bottom: 25px; }
        
        .footer-addresses {
            grid-template-columns: 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .footer-bottom {
            flex-direction: column;
            text-align: center;
            gap: 15px;
            padding-top: 25px;
        }
        .footer-bottom > div:first-child { order: 2; }
        .footer-bottom > div:last-child { order: 1; }
        
        /* Increase touch targets */
        .footer-col ul li a {
            min-height: 40px;
            display: flex;
            align-items: center;
        }
        .social-links a {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
    }

    /* Small Mobile (320px - 375px) */
    @media (max-width: 375px) {
        .footer-wrapper { padding: 40px 4% 25px; }
        .footer-brand img { height: 38px; }
        .footer-brand div[style*="font-size: 23px"] { font-size: 20px; }
        .footer-addresses p { font-size: 12px; }
        .social-links { gap: 10px; }
        .social-links a { width: 36px; height: 36px; font-size: 14px; }
    }

    /* Touch Optimization */
    @media (hover: none) and (pointer: coarse) {
        .footer-col ul li a,
        .social-links a {
            min-height: 44px;
        }
    }
</style>