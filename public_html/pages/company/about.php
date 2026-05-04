<?php
$page_title = 'About Us | TS-NOP-VMS';
require_once '../../config/database.php';
include '../../includes/header.php';
?>

<style>
/* --- About Page Specific Styles --- */
.about-page {
    background-color: var(--dark);
    color: var(--white);
    overflow-x: hidden;
}

/* Hero Section */
.about-hero {
    position: relative;
    padding: 120px 50px 80px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 60px;
    min-height: 90vh;
    background: radial-gradient(circle at top right, rgba(244, 104, 0, 0.1), transparent 40%);
}

.hero-text {
    flex: 1;
    z-index: 2;
}

.hero-text h1 {
    font-size: clamp(40px, 5vw, 64px);
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 24px;
}

.hero-text h1 span { color: var(--primary); }

.hero-text p {
    font-size: 18px;
    color: var(--gray);
    line-height: 1.7;
    margin-bottom: 30px;
    max-width: 600px;
}

/* 3D Video Container - FIXED */
.hero-video-wrapper {
    flex: 1;
    position: relative;
    perspective: 1000px;
}

.video-card-3d {
    position: relative;
    width: 100%;
    aspect-ratio: 16/9; /* Forces correct shape */
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    transform: rotateY(-5deg) rotateX(5deg);
    transition: transform 0.5s ease;
    background: #111; /* Fallback color */
    border: 1px solid rgba(255,255,255,0.1);
}

.video-card-3d:hover {
    transform: rotateY(0deg) rotateX(0deg) scale(1.02);
    box-shadow: 0 30px 60px rgba(244, 104, 0, 0.2);
}

/* Force Video to Fill Container */
.video-card-3d video {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures no black bars */
    display: block;
}

.glossy-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 50%);
    pointer-events: none;
    z-index: 5;
}

/* Floating Badges */
.float-element {
    position: absolute;
    background: rgba(20, 20, 20, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    padding: 15px 25px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    z-index: 10;
    animation: float 6s ease-in-out infinite;
    color: white;
    font-weight: 600;
    font-size: 14px;
}

.float-1 { top: -20px; right: -20px; }
.float-2 { bottom: -30px; left: -30px; animation-delay: 3s; }

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}

@media (max-width: 1024px) {
    .about-hero { flex-direction: column; text-align: center; }
    .hero-text p { margin: 0 auto 30px; }
    .video-card-3d { transform: none; }
    .float-element { display: none; }
}
</style>

<div class="about-page">
    
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="hero-text">
            <h1>Making Surveillance <br><span>Intelligent</span></h1>
            <p>Pioneering AI-powered video analytics since 2018. We transform raw footage into actionable insights for safer cities and smarter industries.</p>
            
            <a href="#story" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                Watch Our Story <i class="fas fa-play-circle"></i>
            </a>
        </div>

        <div class="hero-video-wrapper">
            <!-- Floating Elements -->
            <div class="float-element float-1">
                <i class="fas fa-shield-alt" style="color: var(--primary);"></i> 99.9% Accuracy
            </div>
            <div class="float-element float-2">
                <i class="fas fa-video" style="color: #3b82f6;"></i> 150+ Models
            </div>

            <!-- Main Video Card -->
            <div class="video-card-3d">
                <div class="glossy-overlay"></div>
                
                <!-- LOCAL VIDEO PLAYER -->
                <video autoplay muted loop playsinline poster="/assets/images/video-placeholder.jpg">
                    <source src="/assets/videos/about/intro.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </section>

    <!-- Rest of your About Page Content (Stats, Mission, etc.) goes here -->

</div>

<?php include '../../includes/footer.php'; ?>