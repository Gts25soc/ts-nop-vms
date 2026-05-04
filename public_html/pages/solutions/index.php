<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/database.php';

$type = $_GET['type'] ?? 'traffic';

$industries = [
    'traffic' => [
        'name' => 'Traffic Management',
        'icon' => '🚦',
        'color' => '#f46800',
        'bg_image' => '/assets/images/solution/smart_traffic.png', 
        // REPLACE WITH YOUR TRAFFIC YOUTUBE VIDEO ID (e.g., dQw4w9WgXcQ)
        'youtube_id' => 'JiU_MXwSY3Y', 
        'title' => 'Smart Traffic Management Solutions',
        'subtitle' => 'Automate enforcement, optimize flow, and reduce accidents with 35+ AI detection models.',
        'description' => 'Our Traffic Management solution uses advanced computer vision to detect violations, count vehicles, and manage signals in real-time. Fully compliant with Indian MV Act and ready for integration with e-Challan systems.',
        'benefits' => [
            ['icon' => 'fa-shield-alt', 'text' => '99% Violation Accuracy'],
            ['icon' => 'fa-file-invoice', 'text' => 'e-Challan Integration'],
            ['icon' => 'fa-chart-line', 'text' => 'Real-time Analytics'],
            ['icon' => 'fa-clock', 'text' => '24/7 Monitoring']
        ],
        'screenshots' => [
            ['src' => 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=800', 'label' => 'Helmet Detection', 'acc' => '99.2%'],
            ['src' => 'https://images.unsplash.com/photo-1596773823425-3822a4b0c122?w=800', 'label' => 'Signal Jump', 'acc' => '99.5%'],
            ['src' => 'https://images.unsplash.com/photo-1566008885218-90abf9200ddb?w=800', 'label' => 'Overspeeding', 'acc' => '98.8%'],
            ['src' => 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=800', 'label' => 'Triple Riding', 'acc' => '97.5%']
        ]
    ],
    'smart-city' => [
        'name' => 'Smart City',
        'icon' => '🏙️',
        'color' => '#3b82f6',
        'bg_image' => '/assets/images/solution/smart_City.png',
        // REPLACE WITH YOUR SMART CITY YOUTUBE VIDEO ID
        'youtube_id' => '6wrK7S23-YU',
        'title' => 'Smart City Surveillance & Management',
        'subtitle' => 'Comprehensive urban monitoring for safety, sanitation, and infrastructure.',
        'description' => 'Transform your city with AI-powered monitoring of public spaces, waste management, crowd control, and infrastructure health. A unified command center for municipal operations.',
        'benefits' => [
            ['icon' => 'fa-users', 'text' => 'Crowd Control'],
            ['icon' => 'fa-trash', 'text' => 'Waste Optimization'],
            ['icon' => 'fa-lightbulb', 'text' => 'Street Light Monitoring'],
            ['icon' => 'fa-water', 'text' => 'Waterlogging Detection']
        ],
        'screenshots' => [
            ['src' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=800', 'label' => 'Crowd Density', 'acc' => '98.5%'],
            ['src' => 'https://images.unsplash.com/photo-1518005020951-ecc868433a45?w=800', 'label' => 'Waste Bin Overflow', 'acc' => '99.0%'],
            ['src' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=800', 'label' => 'Traffic Flow', 'acc' => '99.2%'],
            ['src' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=800', 'label' => 'Public Safety', 'acc' => '98.8%']
        ]
    ],
    'defence' => [
        'name' => 'Defence & Security',
        'icon' => '🛡️',
        'color' => '#ef4444',
        'bg_image' => '/assets/images/solution/defence_border_security.png',
        // REPLACE WITH YOUR DEFENCE YOUTUBE VIDEO ID
        'youtube_id' => 'dQw4w9WgXcQ',
        'title' => 'Defence & Border Security Solutions',
        'subtitle' => 'Military-grade surveillance with perimeter breach detection and threat analysis.',
        'description' => 'Secure critical assets and borders with AI that detects intrusions, weapons, and unauthorized drones. Features thermal imaging support and low-latency alerts for immediate response.',
        'benefits' => [
            ['icon' => 'fa-border-all', 'text' => 'Perimeter Breach'],
            ['icon' => 'fa-crosshairs', 'text' => 'Weapon Detection'],
            ['icon' => 'fa-plane', 'text' => 'Drone Tracking'],
            ['icon' => 'fa-temperature-high', 'text' => 'Thermal Support']
        ],
        'screenshots' => [
            ['src' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800', 'label' => 'Perimeter Alert', 'acc' => '99.9%'],
            ['src' => 'https://images.unsplash.com/photo-1595590424283-b8f17842773f?w=800', 'label' => 'Weapon ID', 'acc' => '98.5%'],
            ['src' => 'https://images.unsplash.com/photo-1473968512647-3e447244af8f?w=800', 'label' => 'Drone Detect', 'acc' => '99.0%'],
            ['src' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800', 'label' => 'Night Vision', 'acc' => '99.5%']
        ]
    ],
    'healthcare' => [
        'name' => 'Healthcare',
        'icon' => '🏥',
        'color' => '#10b981',
        'bg_image' => '/assets/images/solution/healthcare_safety.png',
        // REPLACE WITH YOUR HEALTHCARE YOUTUBE VIDEO ID
        'youtube_id' => 'susm_CoU-PE',
        'title' => 'Healthcare Safety & Compliance',
        'subtitle' => 'Ensure patient safety and staff compliance with intelligent monitoring.',
        'description' => 'Monitor PPE usage, fall detection, social distancing, and restricted area access in hospitals and clinics. Protect patients and staff with non-intrusive AI surveillance.',
        'benefits' => [
            ['icon' => 'fa-user-injured', 'text' => 'Fall Detection'],
            ['icon' => 'fa-head-side-mask', 'text' => 'Mask/PPE Compliance'],
            ['icon' => 'fa-virus', 'text' => 'Infection Control'],
            ['icon' => 'fa-bed', 'text' => 'Patient Monitoring']
        ],
        'screenshots' => [
            ['src' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?w=800', 'label' => 'PPE Check', 'acc' => '99.2%'],
            ['src' => 'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?w=800', 'label' => 'Social Distancing', 'acc' => '98.5%'],
            ['src' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?w=800', 'label' => 'Fall Alert', 'acc' => '99.0%'],
            ['src' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?w=800', 'label' => 'Hygiene Track', 'acc' => '98.8%']
        ]
    ],
    'industrial' => [
        'name' => 'Industrial Safety',
        'icon' => '🏭',
        'color' => '#f59e0b',
        'bg_image' => '/assets/images/solution/industrial_safety.png',
        // REPLACE WITH YOUR INDUSTRIAL YOUTUBE VIDEO ID
        'youtube_id' => 'Xb9QOo614-g',
        'title' => 'Industrial Safety & Hazard Detection',
        'subtitle' => 'Prevent accidents and ensure compliance in factories and construction sites.',
        'description' => 'Detect fire, smoke, gas leaks, and safety gear violations instantly. Our AI works in harsh environments to keep workers safe and operations running smoothly.',
        'benefits' => [
            ['icon' => 'fa-fire-extinguisher', 'text' => 'Fire & Smoke'],
            ['icon' => 'fa-hard-hat', 'text' => 'PPE Monitoring'],
            ['icon' => 'fa-exclamation-triangle', 'text' => 'Hazard Alerts'],
            ['icon' => 'fa-clipboard-check', 'text' => 'Compliance Reporting']
        ],
        'screenshots' => [
            ['src' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee15a?w=800', 'label' => 'Fire Detect', 'acc' => '99.8%'],
            ['src' => 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=800', 'label' => 'Hard Hat Check', 'acc' => '99.2%'],
            ['src' => 'https://images.unsplash.com/photo-1565514020176-db792fa2cf47?w=800', 'label' => 'Gas Leak', 'acc' => '98.5%'],
            ['src' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee15a?w=800', 'label' => 'Machinery Safe', 'acc' => '99.0%']
        ]
    ],
    'retail' => [
        'name' => 'Retail Analytics',
        'icon' => '🛒',
        'color' => '#8b5cf6',
        'bg_image' => '/assets/images/solution/retail_intelligence.png',
        // REPLACE WITH YOUR RETAIL YOUTUBE VIDEO ID
        'youtube_id' => 'xW36hiQUOXg',
        'title' => 'Retail Intelligence & Analytics',
        'subtitle' => 'Boost sales and prevent loss with customer behavior analytics.',
        'description' => 'Understand customer journeys, optimize store layouts, and prevent shoplifting. Get actionable insights on footfall, dwell time, and queue management to maximize revenue.',
        'benefits' => [
            ['icon' => 'fa-users', 'text' => 'Customer Insights'],
            ['icon' => 'fa-shield-alt', 'text' => 'Loss Prevention'],
            ['icon' => 'fa-hourglass-half', 'text' => 'Queue Management'],
            ['icon' => 'fa-map-marked-alt', 'text' => 'Heatmaps']
        ],
        'screenshots' => [
            ['src' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800', 'label' => 'Footfall Count', 'acc' => '99.5%'],
            ['src' => 'https://images.unsplash.com/photo-1556740758-90de374c12ad?w=800', 'label' => 'Shoplift Alert', 'acc' => '98.8%'],
            ['src' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800', 'label' => 'Queue Length', 'acc' => '99.0%'],
            ['src' => 'https://images.unsplash.com/photo-1556740758-90de374c12ad?w=800', 'label' => 'Shelf Stock', 'acc' => '98.5%']
        ]
    ]
];

$current = $industries[$type] ?? $industries['traffic'];

$conn = getDBConnection();
$features = [];
if ($conn) {
    $catStmt = $conn->prepare("SELECT id FROM feature_categories WHERE slug = ?");
    $catStmt->bind_param("s", $type);
    $catStmt->execute();
    $catResult = $catStmt->get_result();
    
    if ($catResult->num_rows > 0) {
        $catId = $catResult->fetch_assoc()['id'];
        $featStmt = $conn->prepare("SELECT * FROM features WHERE category_id = ? AND is_active = 1 LIMIT 6");
        $featStmt->bind_param("i", $catId);
        $featStmt->execute();
        $features = $featStmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

$page_title = $current['name'] . ' Solutions | TS-NOP-VMS';
include '../../includes/header.php';
?>

<style>
.solutions-page { padding-top: 0; min-height: 100vh; background: var(--dark); }

.solutions-hero {
    position: relative;
    padding: 100px 50px 80px;
    text-align: center;
    background-color: #0a0a0a; 
    border-bottom: 1px solid rgba(255,255,255,0.05);
    overflow: hidden;
}

.solutions-hero::before {
    content: ''; 
    position: absolute; 
    top: 0; left: 0; width: 100%; height: 100%;
    background-image: url('<?php echo $current['bg_image']; ?>');
    background-size: cover; 
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0.25;
    z-index: 0;
    transition: background-image 0.5s ease-in-out;
}

.solutions-hero::after {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(to bottom, rgba(10,10,10,0.7) 0%, rgba(10,10,10,1) 100%);
    z-index: 1;
}

.solutions-hero h1, .solutions-hero p { position: relative; z-index: 2; }
.solutions-hero h1 { font-size: clamp(32px, 5vw, 56px); font-weight: 900; margin-bottom: 16px; color: white; }
.solutions-hero h1 span { color: <?php echo $current['color']; ?>; }
.solutions-hero p { font-size: 18px; color: var(--gray); max-width: 800px; margin: 0 auto; }

.industry-tabs {
    display: flex; justify-content: center; flex-wrap: wrap; gap: 12px;
    padding: 20px 50px; background: var(--dark-2);
    border-bottom: 1px solid rgba(255,255,255,0.05);
    position: sticky; top: 80px; z-index: 100; backdrop-filter: blur(10px);
}

.tab-link {
    padding: 10px 20px; background: transparent;
    border: 1px solid rgba(255,255,255,0.1); border-radius: 50px;
    color: var(--light-gray); text-decoration: none; font-size: 14px; font-weight: 600;
    display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;
}
.tab-link:hover { border-color: <?php echo $current['color']; ?>; color: white; transform: translateY(-2px); }
.tab-link.active {
    background: <?php echo $current['color']; ?>; border-color: <?php echo $current['color']; ?>;
    color: white; box-shadow: 0 4px 15px <?php echo $current['color']; ?>40;
}

.solutions-container { max-width: 1400px; margin: 0 auto; padding: 60px 50px; }

/* Overview Section */
.overview-section {
    display: grid; grid-template-columns: 1fr 1fr; gap: 60px; margin-bottom: 80px; align-items: start;
}
.solution-text h2 { font-size: 32px; margin-bottom: 20px; color: white; }
.solution-text p { font-size: 16px; color: var(--gray); line-height: 1.8; margin-bottom: 30px; }
.benefits-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 30px; }
.benefit-item {
    display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 500; color: var(--light-gray);
    background: var(--dark-2); padding: 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);
}
.benefit-item i { color: <?php echo $current['color']; ?>; font-size: 18px; }
.cta-box {
    background: linear-gradient(135deg, <?php echo $current['color']; ?>20 0%, var(--dark-2) 100%);
    border: 1px solid <?php echo $current['color']; ?>40; border-radius: 16px; padding: 30px; text-align: center;
}
.cta-box h3 { font-size: 20px; margin-bottom: 12px; color: white; }
.cta-box p { font-size: 14px; color: var(--gray); margin-bottom: 20px; }

/* NEW LAYOUT: Side-by-Side Sections */
.split-layout {
    display: grid;
    grid-template-columns: 1.2fr 1fr; /* Left side slightly wider for the big video */
    gap: 40px;
    margin-bottom: 80px;
    align-items: start;
}

/* Left Side: Big AI Detection Video Showcase */
.ai-detection-showcase {
    background: var(--dark-2);
    border-radius: 20px;
    padding: 20px;
    border: 1px solid rgba(255,255,255,0.05);
    position: relative;
}

.showcase-header {
    text-align: center;
    margin-bottom: 20px;
}
.showcase-header h2 { font-size: 28px; margin-bottom: 8px; color: white; }
.showcase-header p { color: var(--gray); font-size: 14px; }

/* Video Wrapper - Maintains Aspect Ratio */
.main-video-wrapper {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    aspect-ratio: 16/9; /* Standard YouTube Ratio */
    background: #000;
}

.main-video-wrapper iframe {
    width: 100%;
    height: 100%;
    border: none;
}

/* Floating AI Badge on Video */
.float-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(0,0,0,0.8);
    backdrop-filter: blur(5px);
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #28c840;
    color: #28c840;
    font-family: monospace;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
    animation: pulse-badge 2s infinite;
    z-index: 10;
}

@keyframes pulse-badge {
    0%, 100% { box-shadow: 0 0 0 0 rgba(40, 200, 64, 0.4); }
    50% { box-shadow: 0 0 0 10px rgba(40, 200, 64, 0); }
}

.video-caption {
    margin-top: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.video-caption h4 { font-size: 18px; color: white; }
.video-caption span { color: var(--gray); font-size: 13px; }

/* Right Side: Core Capabilities Grid */
.capabilities-panel h2 {
    font-size: 28px;
    margin-bottom: 25px;
    color: white;
    text-align: center;
}

.capabilities-grid {
    display: grid;
    grid-template-columns: 1fr 1fr; /* 2 columns */
    gap: 16px;
}

.capability-card {
    background: var(--dark-2);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 12px;
    padding: 20px;
    transition: all 0.3s;
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.capability-card:hover {
    border-color: <?php echo $current['color']; ?>;
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
}

.capability-card h3 {
    font-size: 16px;
    margin-bottom: 8px;
    color: white;
    line-height: 1.3;
}

.capability-card p {
    font-size: 12px;
    color: var(--gray);
    line-height: 1.4;
    margin-bottom: 12px;
    flex-grow: 1;
}

.capability-card .accuracy {
    font-size: 12px;
    color: #28c840;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
}

@media (max-width: 1024px) {
    .overview-section, .split-layout { grid-template-columns: 1fr; }
    .industry-tabs { position: relative; top: 0; }
    .capabilities-grid { grid-template-columns: 1fr; }
}
</style>

<div class="solutions-page">
    <section class="solutions-hero">
        <h1><?php echo $current['icon'] . ' ' . $current['title']; ?></h1>
        <p><?php echo $current['subtitle']; ?></p>
    </section>

    <div class="industry-tabs">
        <?php foreach($industries as $key => $ind): ?>
            <a href="?type=<?php echo $key; ?>" class="tab-link <?php echo $key === $type ? 'active' : ''; ?>">
                <span><?php echo $ind['icon']; ?></span> <?php echo $ind['name']; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="solutions-container">
        
        <!-- Overview & Benefits -->
        <div class="overview-section">
            <div class="solution-text">
                <h2>Overview</h2>
                <p><?php echo $current['description']; ?></p>
                <h3 style="margin-bottom: 20px; color: white;">Key Benefits</h3>
                <div class="benefits-grid">
                    <?php foreach($current['benefits'] as $benefit): ?>
                        <div class="benefit-item">
                            <i class="fas <?php echo $benefit['icon']; ?>"></i> <?php echo $benefit['text']; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="cta-box">
                    <h3>Need a Custom Integration?</h3>
                    <p>We can tailor our AI models to your specific infrastructure.</p>
                    <a href="/pages/company/contact.php?solution=<?php echo $type; ?>" class="btn btn-primary" style="background: <?php echo $current['color']; ?>; border-color: <?php echo $current['color']; ?>;">
                        Request Custom Solution <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <!-- Dashboard Screenshot -->
            <div style="background: var(--dark-2); border-radius: 16px; padding: 20px; border: 1px solid rgba(255,255,255,0.05);">
                <?php 
                $dashboard_map = [
                    'traffic' => 'dashboard-traffic.webp',
                    'smart-city' => 'dashboard-smartcity.webp',
                    'defence' => 'dashboard-defence.webp',
                    'healthcare' => 'dashboard-healthcare.webp',
                    'industrial' => 'dashboard-industrial.webp',
                    'retail' => 'dashboard-retail.webp'
                ];
                $dashboard_file = $dashboard_map[$type] ?? 'dashboard-traffic.webp';
                ?>
                <img src="/assets/images/solution/<?php echo $dashboard_file; ?>" 
                     alt="<?php echo $current['name']; ?> Dashboard" 
                     style="width: 100%; border-radius: 8px; opacity: 0.9;"
                     onerror="this.src='https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80'">
                <div style="text-align: center; margin-top: 15px; color: var(--gray); font-size: 14px;">
                    <i class="fas fa-chart-line"></i> <?php echo $current['name']; ?> Analytics Dashboard
                </div>
            </div>
        </div>

        <!-- NEW SPLIT LAYOUT: AI Video & Core Capabilities -->
        <div class="split-layout">
            
            <!-- LEFT: Big AI Video Showcase -->
            <div class="ai-detection-showcase">
                <div class="showcase-header">
                    <h2>AI Detection in Action</h2>
                    <p>Live demonstration of our CCTV AI capabilities</p>
                </div>
                
                <div class="main-video-wrapper">
                    <!-- YouTube Embed -->
                    <iframe 
                        src="https://www.youtube.com/embed/<?php echo $current['youtube_id']; ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo $current['youtube_id']; ?>" 
                        title="YouTube video player" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                    
                    <div class="float-badge">
                        <i class="fas fa-circle" style="font-size: 8px;"></i> AI ACTIVE: LIVE
                    </div>
                </div>
                
                <div class="video-caption">
                    <div>
                        <h4><?php echo $current['title']; ?> Demo</h4>
                        <span>Real-time Processing</span>
                    </div>
                    <a href="#" style="color: <?php echo $current['color']; ?>; font-size: 14px; font-weight: 600;">Watch Full Demo <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- RIGHT: Core AI Capabilities Grid -->
            <div class="capabilities-panel">
                <h2>Core AI Capabilities</h2>
                <div class="capabilities-grid">
                    <?php if(!empty($features)): ?>
                        <?php foreach($features as $f): ?>
                            <a href="/pages/features/feature-detail.php?slug=<?php echo $f['slug']; ?>" class="capability-card">
                                <h3><?php echo $f['title']; ?></h3>
                                <p><?php echo $f['short_description']; ?></p>
                                <?php if($f['accuracy_rate']): ?>
                                    <div class="accuracy"><i class="fas fa-check-circle"></i> <?php echo $f['accuracy_rate']; ?>% Accuracy</div>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: var(--gray); text-align: center; grid-column: 1/-1;">Loading capabilities...</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>
</div>

<?php include '../../includes/footer.php'; ?>