<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/database.php';

$slug = $_GET['slug'] ?? 'traffic';
$conn = getDBConnection();

if (!$conn) {
    die("Database connection failed.");
}

// Get category info
$stmt = $conn->prepare("SELECT * FROM feature_categories WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();

if (!$category) {
    header("Location: /pages/features/index.php");
    exit;
}

// Get all features for this category
$stmt = $conn->prepare("
    SELECT * FROM features 
    WHERE category_id = ? AND is_active = 1 
    ORDER BY created_at DESC
");
$stmt->bind_param("i", $category['id']);
$stmt->execute();
$features = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$page_title = $category['name'] . ' | TS-NOP-VMS';
include '../../includes/header.php';
?>

<style>
.category-page { padding-top: 80px; min-height: 100vh; }

.category-hero {
    background: linear-gradient(135deg, <?php echo $category['color']; ?>20 0%, rgba(10,10,10,1) 100%);
    padding: 100px 50px;
    text-align: center;
    border-bottom: 3px solid <?php echo $category['color']; ?>;
}

.category-hero .back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--light-gray);
    text-decoration: none;
    margin-bottom: 20px;
    font-weight: 600;
    transition: color 0.3s;
}

.category-hero .back-link:hover { color: var(--primary); }

.category-hero .icon {
    font-size: 72px;
    margin-bottom: 20px;
    display: block;
}

.category-hero h1 {
    font-size: clamp(36px, 5vw, 56px);
    font-weight: 900;
    margin-bottom: 16px;
    color: var(--white);
}

.category-hero p {
    font-size: 18px;
    color: var(--gray);
    max-width: 800px;
    margin: 0 auto 24px;
    line-height: 1.7;
}

.category-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
    margin-top: 32px;
}

.stat-box {
    background: rgba(255,255,255,0.05);
    padding: 16px 32px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.1);
}

.stat-box .number {
    font-size: 32px;
    font-weight: 800;
    color: var(--primary);
    display: block;
}

.stat-box .label {
    font-size: 13px;
    color: var(--gray);
}

/* Features Grid */
.category-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 60px 50px;
}

.section-header {
    margin-bottom: 40px;
}

.section-header h2 {
    font-size: 28px;
    margin-bottom: 8px;
}

.section-header p {
    color: var(--gray);
    font-size: 15px;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 24px;
}

.feature-card {
    background: var(--dark-2);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.4s ease;
    text-decoration: none;
    color: inherit;
    display: block;
    cursor: pointer;
}

.feature-card:hover {
    border-color: <?php echo $category['color']; ?>;
    transform: translateY(-4px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}

.feature-image-box {
    width: 100%;
    aspect-ratio: 16/9;
    background: var(--dark-3);
    position: relative;
    overflow: hidden;
}

.feature-image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.feature-card:hover .feature-image-box img {
    transform: scale(1.05);
}

.image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--dark-3) 0%, var(--dark-4) 100%);
    color: var(--gray);
    font-size: 14px;
    flex-direction: column;
    gap: 10px;
}

.image-placeholder i {
    font-size: 48px;
    opacity: 0.5;
}

.feature-content {
    padding: 24px;
}

.feature-content h3 {
    font-size: 20px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.feature-content p {
    font-size: 14px;
    color: var(--gray);
    line-height: 1.6;
    margin-bottom: 16px;
}

.feature-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid rgba(255,255,255,0.05);
}

.accuracy-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #28c840;
    font-weight: 600;
}

.view-link {
    color: var(--primary);
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

@media (max-width: 1024px) {
    .features-grid { grid-template-columns: 1fr; }
    .category-hero, .category-content { padding-left: 30px; padding-right: 30px; }
}
</style>

<div class="category-page">
    <!-- Hero -->
    <section class="category-hero">
        <a href="/pages/features/index.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to All Features
        </a>
        <span class="icon"><?php echo $category['icon']; ?></span>
        <h1><?php echo $category['name']; ?></h1>
        <p><?php echo $category['description']; ?></p>
        
        <div class="category-stats">
            <div class="stat-box">
                <span class="number"><?php echo count($features); ?>+</span>
                <span class="label">AI Models</span>
            </div>
            <div class="stat-box">
                <span class="number">99%+</span>
                <span class="label">Accuracy</span>
            </div>
            <div class="stat-box">
                <span class="number">&lt;50ms</span>
                <span class="label">Response Time</span>
            </div>
        </div>
    </section>

    <!-- Features -->
    <div class="category-content">
        <div class="section-header">
            <h2>All <?php echo $category['name']; ?> Solutions</h2>
            <p>Comprehensive AI-powered detection systems for <?php echo strtolower($category['name']); ?></p>
        </div>

        <div class="features-grid">
            <?php foreach($features as $f): 
    // Determine image path - USE CATEGORY NAME (with spaces)
    $image_path = '';
    
    if (!empty($f['video_thumbnail'])) {
        $image_path = $f['video_thumbnail'];
    } else {
        // Use category NAME (with spaces like "traffic violation detection")
        $category_folder = $category['name'];  
        $feature_title = $f['title'];
        
        // Try multiple possible paths with spaces in folder name
        $possible_paths = [
            // Exact match with spaces
            "assets/images/features/traffic/seatbelt.png",
            "assets/images/features/{$category_folder}/{$feature_title}.jpg",
            "assets/images/features/{$category_folder}/{$feature_title}.webp",
            "assets/images/features/{$category_folder}/{$feature_title}.jpeg",
            
            // Lowercase version
            "assets/images/features/{$category_folder}/" . strtolower($feature_title) . ".png",
            "assets/images/features/{$category_folder}/" . strtolower($feature_title) . ".jpg",
            
            // Demo/default
            "assets/images/features/{$category_folder}/demo.png",
            "assets/images/features/{$category_folder}/demo.jpg",
            
            // Fallback
            "assets/images/video-placeholder.jpg"
        ];
        
        // Check each path
        foreach ($possible_paths as $path) {
            $full_path = '../../' . $path;
            if (file_exists($full_path)) {
                $image_path = $path;
                break;
            }
        }
        
        if (empty($image_path)) {
            $image_path = 'assets/images/video-placeholder.jpg';
        }
    }
?>
                <a href="feature-detail.php?slug=<?php echo $f['slug']; ?>" class="feature-card">
                    <!-- Image Box -->
                    <div class="feature-image-box">
                        <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($f['title']); ?>" onerror="this.src='assets/images/video-placeholder.jpg'">
                    </div>

                    <!-- Content -->
                    <div class="feature-content">
                        <h3><?php echo $f['title']; ?></h3>
                        <p><?php echo $f['short_description']; ?></p>
                        
                        <div class="feature-meta">
                            <?php if($f['accuracy_rate']): ?>
                                <span class="accuracy-badge">
                                    <i class="fas fa-check-circle"></i> <?php echo $f['accuracy_rate']; ?>% Accuracy
                                </span>
                            <?php endif; ?>
                            <span class="view-link">View Details <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>