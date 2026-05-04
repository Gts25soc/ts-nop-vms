<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/database.php';

$conn = getDBConnection();
$categories = [];
$features = [];

if ($conn) {
    $cat_result = $conn->query("SELECT * FROM feature_categories ORDER BY display_order");
    while($row = $cat_result->fetch_assoc()) {
        $categories[] = $row;
    }
    
    $feat_result = $conn->query("
        SELECT f.*, fc.slug as category_slug, fc.name as category_name, fc.icon as category_icon, fc.color
        FROM features f
        LEFT JOIN feature_categories fc ON f.category_id = fc.id
        WHERE f.is_active = 1
        ORDER BY fc.display_order, f.created_at DESC
    ");
    while($row = $feat_result->fetch_assoc()) {
        $features[] = $row;
    }
}

$category_counts = [];
foreach($categories as $cat) {
    $slug = $cat['slug'];
    $category_counts[$slug] = 0;
}
foreach($features as $feat) {
    if(isset($category_counts[$feat['category_slug']])) {
        $category_counts[$feat['category_slug']]++;
    }
}

$page_title = '150+ AI Detection Features | TS-NOP-VMS';
include '../../includes/header.php';
?>

<style>
/* --- Global Variables --- */
:root {
    --primary: #f46800;
    --dark: #0a0a0a;
    --dark2: #111;
    --dark3: #1a1a1a;
    --gray: #888;
    --light-gray: #ccc;
    --white: #fff;
}

.features-page { padding-top: 0; min-height: 100vh; background: var(--dark); }

/* --- Hero Section with Background Image (FROM OLD CODE) --- */
.features-hero {
    position: relative;
    background-image: url('/assets/images/features-hero-bg.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 120px 50px;
    text-align: center;
    overflow: hidden;
}

.features-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(10, 10, 10, 0.85);
    z-index: 1;
}

.features-hero h1, .features-hero p, .hero-stats-grid {
    position: relative;
    z-index: 2;
}

.features-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    margin-bottom: 20px;
    color: var(--white);
}

.features-hero h1 span {
    background: linear-gradient(135deg, #f46800 0%, #ff7a1a 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.features-hero p {
    font-size: 18px;
    color: #cccccc;
    max-width: 800px;
    margin: 0 auto 40px;
}

.hero-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 24px;
    max-width: 1000px;
    margin: 40px auto 0;
}

.hero-stat-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(244, 104, 0, 0.3);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    transition: transform 0.3s ease;
}

.hero-stat-card:hover { transform: translateY(-5px); border-color: #f46800; }

.hero-stat-card .number {
    font-size: 42px;
    font-weight: 800;
    color: var(--primary);
    font-family: 'JetBrains Mono', monospace;
    display: block;
    margin-bottom: 8px;
}

.hero-stat-card .label { font-size: 13px; color: var(--gray); }

/* --- Category Cards --- */
.category-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    max-width: 1400px;
    margin: 60px auto;
    padding: 0 50px;
}

.category-card {
    background: var(--dark2);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 16px;
    padding: 32px;
    text-align: center;
    cursor: pointer;
    transition: all 0.4s ease;
    text-decoration: none;
    color: inherit;
    display: block;
}

.category-card:hover {
    border-color: var(--primary);
    transform: translateY(-4px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}

.category-card .icon { font-size: 48px; margin-bottom: 16px; }
.category-card h3 { font-size: 20px; margin-bottom: 8px; }
.category-card p { font-size: 14px; color: var(--gray); margin-bottom: 16px; }
.category-card .count { color: var(--primary); font-weight: 700; }

/* --- Controls & Slider --- */
.features-controls {
    max-width: 1400px;
    margin: 0 auto;
    padding: 60px 50px 30px;
}

.section-header { text-align: center; margin-bottom: 40px; }
.section-header h2 { font-size: 32px; margin-bottom: 12px; }

/* Slider Styles */
.features-slider-container {
    position: relative;
    width: 100%;
    max-width: 1400px;
    margin: 0 auto 40px;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    aspect-ratio: 21/9;
}

.features-slider-wrapper { width: 100%; height: 100%; position: relative; }

.feature-slide {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    opacity: 0; transition: opacity 0.8s ease-in-out; z-index: 1;
}

.feature-slide.active { opacity: 1; z-index: 2; }
.feature-slide img { width: 100%; height: 100%; object-fit: cover; }

.slide-content {
    position: absolute; bottom: 0; left: 0; width: 100%;
    padding: 40px;
    background: linear-gradient(0deg, rgba(0,0,0,0.9) 0%, transparent 100%);
    color: white; z-index: 3;
}

.slide-content h3 { font-size: 28px; font-weight: 700; margin-bottom: 8px; color: var(--primary); }
.slide-content p { font-size: 16px; color: #ccc; max-width: 600px; }

.slider-btn {
    position: absolute; top: 50%; transform: translateY(-50%);
    background: rgba(0,0,0,0.5); color: white; border: none;
    width: 50px; height: 50px; border-radius: 50%;
    cursor: pointer; z-index: 10; transition: all 0.3s;
    display: flex; align-items: center; justify-content: center; font-size: 20px;
}
.slider-btn:hover { background: var(--primary); }
.prev { left: 20px; }
.next { right: 20px; }

.slider-dots {
    position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
    display: flex; gap: 10px; z-index: 10;
}
.dot {
    width: 10px; height: 10px; background: rgba(255,255,255,0.3);
    border-radius: 50%; cursor: pointer; transition: all 0.3s;
}
.dot.active { background: var(--primary); transform: scale(1.2); }

/* Filter Tabs */
.filter-tabs {
    display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; margin-bottom: 30px;
}
.filter-tab {
    padding: 12px 24px; background: var(--dark2); border: 1px solid rgba(255,255,255,0.1);
    border-radius: 50px; color: var(--light-gray); font-size: 14px; font-weight: 600;
    cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 10px;
}
.filter-tab:hover { border-color: var(--primary); transform: translateY(-2px); }
.filter-tab.active { background: var(--primary); border-color: transparent; color: white; }
.filter-tab .count { background: rgba(255,255,255,0.2); padding: 2px 10px; border-radius: 20px; font-size: 12px; }

.search-box {
    max-width: 600px; margin: 0 auto 40px; position: relative;
}
.search-box input {
    width: 100%; padding: 14px 18px 14px 48px; background: var(--dark2);
    border: 1px solid rgba(255,255,255,0.1); border-radius: 10px;
    color: white; font-size: 14px;
}
.search-box input:focus { outline: none; border-color: var(--primary); }
.search-box i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--gray); }

/* --- Features Grid --- */
.features-container { max-width: 1400px; margin: 0 auto; padding: 20px 50px 80px; }
.features-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 28px; }

.feature-card {
    background: var(--dark2); border: 1px solid rgba(255,255,255,0.05);
    border-radius: 16px; overflow: hidden; transition: all 0.4s ease;
    cursor: pointer; display: flex; flex-direction: column;
}
.feature-card:hover {
    border-color: rgba(244,104,0,0.3); transform: translateY(-6px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
}

.feature-media-box {
    position: relative; width: 100%; aspect-ratio: 16/9;
    background: var(--dark3); overflow: hidden;
}
.feature-media-box img, .feature-media-box video {
    width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;
}
.feature-card:hover .feature-media-box img,
.feature-card:hover .feature-media-box video { transform: scale(1.05); }

.play-overlay {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    width: 50px; height: 50px; background: rgba(244, 104, 0, 0.9);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    color: white; font-size: 20px; opacity: 0; transition: opacity 0.3s; pointer-events: none;
}
.feature-card:hover .play-overlay { opacity: 1; }

.media-placeholder {
    width: 100%; height: 100%; display: flex; flex-direction: column;
    align-items: center; justify-content: center; color: var(--gray); background: var(--dark3);
}
.media-placeholder i { font-size: 32px; margin-bottom: 8px; opacity: 0.5; }

.feature-content { padding: 24px; flex: 1; display: flex; flex-direction: column; }
.feature-header { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px; }
.feature-icon {
    width: 40px; height: 40px; border-radius: 10px; background: rgba(244,104,0,0.1);
    display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;
}
.feature-meta { flex: 1; }
.feature-category {
    font-size: 11px; text-transform: uppercase; letter-spacing: 1px;
    color: var(--primary); font-weight: 700; margin-bottom: 2px;
}
.feature-title { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
.feature-accuracy { font-size: 12px; color: #28c840; font-weight: 600; }
.feature-description { font-size: 14px; color: var(--gray); line-height: 1.6; margin-bottom: 16px; flex-grow: 1; }

.feature-specs { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
.spec-tag {
    padding: 4px 10px; background: rgba(255,255,255,0.05); border-radius: 4px;
    font-size: 11px; color: var(--light-gray);
}

.feature-footer {
    display: flex; justify-content: space-between; align-items: center;
    padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.05);
}
.feature-stats { display: flex; gap: 12px; font-size: 12px; color: var(--gray); }
.feature-stats span { display: flex; align-items: center; gap: 4px; }
.feature-link {
    color: var(--primary); font-weight: 600; font-size: 13px;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
}
.feature-link:hover { gap: 10px; }

.no-results { text-align: center; padding: 80px 20px; color: var(--gray); display: none; }
.no-results i { font-size: 64px; margin-bottom: 20px; opacity: 0.3; }

@media (max-width: 1024px) {
    .features-grid { grid-template-columns: 1fr; }
    .features-slider-container { aspect-ratio: 16/9; }
}
</style>

<div class="features-page">
    <!-- Hero -->
    <section class="features-hero">
        <h1>150+ <span>AI Detection</span> Models</h1>
        <p>Enterprise-grade computer vision solutions with automatic media detection for every feature</p>
        
        <div class="hero-stats-grid">
            <div class="hero-stat-card"><span class="number" data-counter="150">0</span><div class="label">AI Models</div></div>
            <div class="hero-stat-card"><span class="number" data-counter="6">0</span><div class="label">Industries</div></div>
            <div class="hero-stat-card"><span class="number">99.2%</span><div class="label">Accuracy</div></div>
            <div class="hero-stat-card"><span class="number">&lt;50ms</span><div class="label">Inference Time</div></div>
        </div>
    </section>

    <!-- Category Cards -->
    <div class="category-cards">
        <?php foreach($categories as $cat): ?>
            <a href="category.php?slug=<?php echo $cat['slug']; ?>" class="category-card">
                <div class="icon"><?php echo $cat['icon']; ?></div>
                <h3><?php echo $cat['name']; ?></h3>
                <p><?php echo substr($cat['description'], 0, 80) . '...'; ?></p>
                <div class="count"><?php echo $category_counts[$cat['slug']] ?? 0; ?> Features →</div>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Controls & Slider -->
    <div class="features-controls">
        <div class="section-header">
            <h2>All AI Detection Features</h2>
            <p style="color: var(--gray);">Click any feature to view details. Media loads automatically.</p>
        </div>

        <!-- PHOTO SLIDER -->
        <div class="features-slider-container">
            <div class="features-slider-wrapper" id="featuresSlider">
                <!-- Slide 1 -->
                <div class="feature-slide active">
                    <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=1200" alt="AI Traffic Detection">
                    <div class="slide-content">
                        <h3>Smart Traffic Management</h3>
                        <p>Real-time violation detection with 99% accuracy.</p>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="feature-slide">
                    <img src="https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=1200" alt="Smart City Surveillance">
                    <div class="slide-content">
                        <h3>Smart City Surveillance</h3>
                        <p>Crowd density, waste management, and safety analytics.</p>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="feature-slide">
                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee15a?w=1200" alt="Industrial Safety">
                    <div class="slide-content">
                        <h3>Industrial Safety & Compliance</h3>
                        <p>PPE detection, fire alerts, and machinery monitoring.</p>
                    </div>
                </div>
            </div>
            
            <button class="slider-btn prev" onclick="changeSlide(-1)"><i class="fas fa-chevron-left"></i></button>
            <button class="slider-btn next" onclick="changeSlide(1)"><i class="fas fa-chevron-right"></i></button>
            <div class="slider-dots" id="sliderDots"></div>
        </div>

        <div class="filter-tabs" id="filterTabs">
            <button class="filter-tab active" data-category="all">All Features <span class="count"><?php echo count($features); ?></span></button>
            <?php foreach($categories as $cat): ?>
                <button class="filter-tab" data-category="<?php echo $cat['slug']; ?>">
                    <?php echo $cat['icon'] . ' ' . $cat['name']; ?>
                    <span class="count"><?php echo $category_counts[$cat['slug']] ?? 0; ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search features (e.g., helmet, crowd, fire)...">
        </div>
    </div>

    <!-- Features Grid -->
    <div class="features-container">
        <div class="features-grid" id="featuresGrid">
            <?php foreach($features as $f): 
                // Smart Image Detection with Fallbacks
                $image_url = '';
                $category_slug = strtolower($f['category_slug']);
                $feature_title = strtolower($f['title']);
                
                // 1. Check database image_path
                if (!empty($f['image_path']) && file_exists('../../' . $f['image_path'])) {
                    $image_url = '/' . $f['image_path'];
                }
                // 2. Check demo_video_path (use placeholder)
                elseif (!empty($f['demo_video_path']) && file_exists('../../' . $f['demo_video_path'])) {
                    $image_url = 'https://images.unsplash.com/photo-1573790387438-b73e2729e498?w=600'; // Video placeholder
                }
                // 3. Check YouTube
                elseif (!empty($f['youtube_video_id'])) {
                    $image_url = 'https://img.youtube.com/vi/' . $f['youtube_video_id'] . '/maxresdefault.jpg';
                }
                // 4. Try local files
                else {
                    $possible_paths = [
                        "assets/images/features/{$category_slug}/{$feature_title}.png",
                        "assets/images/features/{$category_slug}/{$feature_title}.jpg",
                        "assets/images/features/{$category_slug}/demo.jpg",
                    ];
                    
                    $found = false;
                    foreach ($possible_paths as $path) {
                        if (file_exists('../../' . $path)) {
                            $image_url = '/' . $path;
                            $found = true;
                            break;
                        }
                    }
                    
                    // 5. Fallback to category-based Unsplash images
                    if (!$found) {
                        $category_images = [
                            'traffic' => 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=600',
                            'smart-city' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=600',
                            'defence' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600',
                            'healthcare' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?w=600',
                            'industrial' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee15a?w=600',
                            'retail' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600',
                        ];
                        
                        $image_url = $category_images[$category_slug] ?? 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=600';
                    }
                }
            ?>
                <div class="feature-card" 
                     data-category="<?php echo $f['category_slug']; ?>" 
                     data-title="<?php echo strtolower($f['title']); ?>" 
                     data-desc="<?php echo strtolower($f['short_description']); ?>"
                     onclick="window.location.href='feature-detail.php?slug=<?php echo $f['slug']; ?>'">
                    
                    <!-- Media Display Area -->
                    <div class="feature-media-box">
                        <img src="<?php echo $image_url; ?>" 
                             alt="<?php echo htmlspecialchars($f['title']); ?>" 
                             loading="lazy"
                             onerror="this.src='https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=600'">
                        
                        <?php if (!empty($f['demo_video_path']) || !empty($f['youtube_video_id'])): ?>
                            <div class="play-overlay"><i class="fas fa-play"></i></div>
                        <?php endif; ?>
                    </div>

                    <!-- Feature Content -->
                    <div class="feature-content">
                        <div class="feature-header">
                            <div class="feature-icon"><?php echo $f['category_icon']; ?></div>
                            <div class="feature-meta">
                                <div class="feature-category"><?php echo $f['category_name']; ?></div>
                                <h3 class="feature-title"><?php echo $f['title']; ?></h3>
                                <?php if($f['accuracy_rate']): ?>
                                    <div class="feature-accuracy"><i class="fas fa-check-circle"></i> <?php echo $f['accuracy_rate']; ?>% Accuracy</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <p class="feature-description"><?php echo $f['short_description']; ?></p>
                        <?php 
                        $specs = json_decode($f['technical_specs'], true);
                        if($specs): 
                        ?>
                            <div class="feature-specs">
                                <?php foreach(array_slice($specs, 0, 3) as $key => $val): ?>
                                    <span class="spec-tag"><?php echo ucfirst(str_replace('_', ' ', $key)); ?>: <?php echo is_array($val) ? 'Array' : $val; ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="feature-footer">
                            <div class="feature-stats">
                                <?php if($f['inference_time_ms']): ?><span><i class="fas fa-bolt"></i> <?php echo $f['inference_time_ms']; ?>ms</span><?php endif; ?>
                                <span><i class="fas fa-server"></i> Edge/Cloud</span>
                            </div>
                            <a href="feature-detail.php?slug=<?php echo $f['slug']; ?>" class="feature-link" onclick="event.stopPropagation()">Details <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="no-results" id="noResults"><i class="fas fa-search"></i><h3>No features found</h3><p>Try adjusting your search or filter criteria.</p></div>
    </div>
</div>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.filter-tab');
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.feature-card');
    const noResults = document.getElementById('noResults');
    let activeCategory = 'all';
    let searchQuery = '';

    function filterFeatures() {
        let visibleCount = 0;
        cards.forEach(card => {
            const matchCat = activeCategory === 'all' || card.dataset.category === activeCategory;
            const matchSearch = !searchQuery || card.dataset.title.includes(searchQuery) || card.dataset.desc.includes(searchQuery);
            if (matchCat && matchSearch) { card.style.display = 'block'; visibleCount++; } 
            else { card.style.display = 'none'; }
        });
        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            activeCategory = tab.dataset.category;
            filterFeatures();
        });
    });

    let searchTimeout;
    searchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchQuery = e.target.value.toLowerCase().trim();
            filterFeatures();
        }, 300);
    });
});

// Slider Logic
let currentSlide = 0;
const slides = document.querySelectorAll('.feature-slide');
const dotsContainer = document.getElementById('sliderDots');

// Create dots
slides.forEach((_, index) => {
    const dot = document.createElement('span');
    dot.classList.add('dot');
    if(index === 0) dot.classList.add('active');
    dot.onclick = () => goToSlide(index);
    dotsContainer.appendChild(dot);
});

function showSlide(n) {
    slides.forEach(slide => slide.classList.remove('active'));
    document.querySelectorAll('.dot').forEach(d => d.classList.remove('active'));
    currentSlide = (n + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
    document.querySelectorAll('.dot')[currentSlide].classList.add('active');
}

function changeSlide(n) { showSlide(currentSlide + n); }
function goToSlide(n) { showSlide(n); }
setInterval(() => { changeSlide(1); }, 5000);

// Counter animation
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-counter'));
    if (!target) return;
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target + (target > 100 ? '+' : '');
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}
document.querySelectorAll('[data-counter]').forEach(counter => { animateCounter(counter); });
</script>

<?php include '../../includes/footer.php'; ?>