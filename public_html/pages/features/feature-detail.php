<?php
// [Keep the same PHP code from before for database connection]
// Just replace the HTML/CSS section with this:
?>

<style>
/* [Keep all previous CSS] */

/* Add these new styles for image/video boxes */
.demo-gallery {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin: 32px 0;
}

.media-box {
    position: relative;
    aspect-ratio: 16/10;
    background: var(--dark-3);
    border-radius: 12px;
    overflow: hidden;
    border: 2px dashed rgba(244,104,0,0.3);
    cursor: pointer;
    transition: all 0.3s;
}

.media-box:hover {
    border-color: var(--primary);
    transform: translateY(-2px);
}

.media-box.has-content {
    border-style: solid;
    border-color: rgba(244,104,0,0.3);
}

.media-box img,
.media-box video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.media-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--gray);
    text-align: center;
    padding: 20px;
}

.media-placeholder i {
    font-size: 48px;
    margin-bottom: 12px;
    opacity: 0.5;
}

.media-placeholder span {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.media-placeholder small {
    font-size: 12px;
    opacity: 0.7;
}

.play-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.media-box:hover .play-overlay {
    opacity: 1;
}

.play-button {
    width: 60px;
    height: 60px;
    background: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.play-button i {
    color: white;
    font-size: 24px;
    margin-left: 4px;
}

/* Workflow Diagram Box */
.workflow-box {
    background: var(--dark-2);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 12px;
    padding: 32px;
    margin: 32px 0;
}

.workflow-placeholder {
    background: var(--dark-3);
    border: 2px dashed rgba(244,104,0,0.3);
    border-radius: 8px;
    padding: 60px 20px;
    text-align: center;
    color: var(--gray);
}

.workflow-placeholder i {
    font-size: 64px;
    margin-bottom: 16px;
    opacity: 0.5;
}

/* Comparison Table Box */
.comparison-box {
    background: var(--dark-2);
    border-radius: 12px;
    overflow: hidden;
    margin: 32px 0;
}

.comparison-placeholder {
    padding: 40px;
    text-align: center;
    color: var(--gray);
    border: 2px dashed rgba(244,104,0,0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .demo-gallery { grid-template-columns: 1fr; }
}
</style>

<!-- In the Overview Tab, add these boxes: -->
<div id="tab-overview" class="tab-content active">
    <h2 style="margin-bottom: 16px;">How <?php echo $feature['title']; ?> Works</h2>
    
    <div style="color: var(--light-gray); line-height: 1.8; font-size: 15px; margin-bottom: 32px;">
        <?php echo nl2br($feature['full_description'] ?? $feature['short_description']); ?>
    </div>

    <!-- Demo Gallery -->
    <h3 style="margin: 32px 0 16px;">Live Demo & Footage</h3>
    <div class="demo-gallery">
        <!-- Video Box 1 -->
        <div class="media-box <?php echo !empty($feature['demo_video_path']) ? 'has-content' : ''; ?>" 
             onclick="<?php echo !empty($feature['demo_video_path']) ? 'playVideo()' : 'alert(\'Video will be added soon\');'; ?>">
            <?php if(!empty($feature['demo_video_path'])): ?>
                <img src="/<?php echo $feature['video_thumbnail'] ?? 'assets/images/video-placeholder.jpg'; ?>" alt="Demo Video">
                <div class="play-overlay">
                    <div class="play-button"><i class="fas fa-play"></i></div>
                </div>
            <?php else: ?>
                <div class="media-placeholder">
                    <i class="fas fa-video"></i>
                    <span>Add Demo Video</span>
                    <small>Upload MP4 or YouTube link</small>
                </div>
            <?php endif; ?>
        </div>

        <!-- Image Box 1 -->
        <div class="media-box">
            <div class="media-placeholder">
                <i class="fas fa-image"></i>
                <span>Add Screenshot</span>
                <small>Real detection example</small>
            </div>
        </div>

        <!-- Image Box 2 -->
        <div class="media-box">
            <div class="media-placeholder">
                <i class="fas fa-image"></i>
                <span>Add Diagram</span>
                <small>System architecture</small>
            </div>
        </div>

        <!-- Video Box 2 -->
        <div class="media-box">
            <div class="media-placeholder">
                <i class="fas fa-film"></i>
                <span>Add Case Study</span>
                <small>Customer success story</small>
            </div>
        </div>
    </div>

    <!-- Workflow Diagram -->
    <h3 style="margin: 32px 0 16px;">Detection Workflow</h3>
    <div class="workflow-box">
        <div class="workflow-placeholder">
            <i class="fas fa-project-diagram"></i>
            <h4 style="margin-bottom: 8px;">Add Workflow Diagram</h4>
            <p>Upload a visual diagram showing the detection process flow</p>
            <small style="opacity: 0.7;">Recommended: 1200x600px PNG/SVG</small>
        </div>
    </div>

    <?php if(!empty($useCases)): ?>
    <h3 style="margin: 32px 0 16px;">Ideal For</h3>
    <div class="chips-container">
        <?php foreach($useCases as $use): ?>
            <span class="chip"><i class="fas fa-check" style="margin-right: 6px; color: var(--primary);"></i> <?php echo $use; ?></span>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- In the Specs Tab, add comparison box: -->
<div id="tab-specs" class="tab-content">
    <h3 style="margin-bottom: 20px;">Technical Specifications</h3>
    
    <div class="comparison-box">
        <div class="comparison-placeholder">
            <i class="fas fa-table" style="font-size: 48px; margin-bottom: 12px; opacity: 0.5;"></i>
            <h4>Add Detailed Comparison Table</h4>
            <p>Compare different models, configurations, and performance metrics</p>
        </div>
    </div>

    <!-- [Rest of specs grid from before] -->
</div>