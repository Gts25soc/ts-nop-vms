<?php
$page_title = 'TS-NOP-VMS - AI-Powered Video Management System';
require_once 'config/database.php';
include 'includes/header.php';

// Fetch Features for Dynamic Image Loading
$conn = getDBConnection();
$features_map = [];
if ($conn) {
    $result = $conn->query("SELECT title, slug, category_id FROM features WHERE is_active = 1");
    while($row = $result->fetch_assoc()) {
        $features_map[strtolower(trim($row['title']))] = [
            'slug' => $row['slug'],
            'cat_id' => $row['category_id']
        ];
    }
}
?>

<style>
/* --- Existing Styles (Hero, Video, Features, CTA) --- */
.hero-video-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0; opacity: 0; transition: opacity 1s ease-in-out; }
.hero-video-bg.active { opacity: 0.3; }
.hero-section { position: relative; min-height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #0a0a0a; }
.hero-video-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; opacity: 0; transition: opacity 1s ease-in-out; pointer-events: none; }
.hero-video-slide.active { opacity: 1; pointer-events: auto; }
.hero-video-slide video { width: 100%; height: 100%; object-fit: cover; }
.hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1; }
.hero-content { position: relative; z-index: 2; text-align: center; padding: 0 20px; max-width: 1200px; }
.hero-slider-dots { position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); display: flex; gap: 12px; z-index: 10; }
.dot { width: 12px; height: 12px; background: rgba(255,255,255,0.3); border-radius: 50%; cursor: pointer; transition: all 0.3s ease; border: 2px solid transparent; }
.dot:hover { background: rgba(255,255,255,0.6); }
.dot.active { background: #f46800; transform: scale(1.2); border-color: #fff; }
.hero-content h1 { font-size: clamp(36px, 6vw, 72px); font-weight: 900; margin-bottom: 20px; line-height: 1.1; text-shadow: 0 4px 20px rgba(0,0,0,0.5); }
.hero-content h1 span { background: linear-gradient(135deg, #f46800 0%, #ff7a1a 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.hero-content p { font-size: 18px; color: #cccccc; max-width: 800px; margin: 0 auto 40px; line-height: 1.7; text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
.hero-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-bottom: 60px; }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 24px; max-width: 1000px; margin: 0 auto; }
.stat-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(244,104,0,0.2); border-radius: 12px; padding: 20px; text-align: center; }
.stat-card .number { font-size: 32px; font-weight: 800; color: var(--primary); font-family: 'JetBrains Mono', monospace; display: block; margin-bottom: 8px; }
.stat-card .label { font-size: 13px; color: #999; }
.video-demo-section { padding: 100px 50px; background: var(--dark-2); }
.section-header { text-align: center; margin-bottom: 50px; }
.section-header h2 { font-size: clamp(28px, 4vw, 42px); font-weight: 800; margin-bottom: 16px; }
.section-header p { font-size: 16px; color: var(--gray); max-width: 600px; margin: 0 auto; }
.video-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 24px; max-width: 1400px; margin: 0 auto; }
.video-card { background: var(--dark-3); border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease; }
.video-card:hover { border-color: rgba(244,104,0,0.3); transform: translateY(-4px); box-shadow: 0 20px 60px rgba(0,0,0,0.4); }
.video-wrapper { position: relative; aspect-ratio: 16/9; background: var(--dark); overflow: hidden; }
.video-wrapper video, .video-wrapper img { width: 100%; height: 100%; object-fit: cover; }
.video-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--dark-3) 0%, var(--dark-4) 100%); color: var(--gray); flex-direction: column; gap: 16px; text-align: center; padding: 20px; }
.video-placeholder i { font-size: 48px; opacity: 0.5; }
.video-info { padding: 20px; }
.video-info h3 { font-size: 18px; margin-bottom: 8px; }
.video-info p { font-size: 14px; color: var(--gray); line-height: 1.5; }
.video-badge { display: inline-block; padding: 4px 12px; background: rgba(244,104,0,0.1); border: 1px solid rgba(244,104,0,0.3); border-radius: 20px; font-size: 11px; color: var(--primary); font-weight: 600; margin-top: 12px; }
.features-section { padding: 100px 50px; background: var(--dark); }
.features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; max-width: 1400px; margin: 0 auto; }
.feature-box { background: var(--dark-2); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 32px; transition: all 0.3s ease; }
.feature-box:hover { border-color: rgba(244,104,0,0.3); transform: translateY(-4px); }
.feature-box .icon { width: 60px; height: 60px; border-radius: 12px; background: rgba(244,104,0,0.1); display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 20px; }
.feature-box h3 { font-size: 20px; margin-bottom: 12px; }
.feature-box p { font-size: 14px; color: var(--gray); line-height: 1.6; }
.cta-section { position: relative; padding: 120px 50px; background-image: url('/assets/images/ctb-background.png'); background-size: cover; background-position: center; background-repeat: no-repeat; text-align: center; overflow: hidden; }
.cta-section::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 1; }
.cta-section h2, .cta-section p, .cta-section > div { position: relative; z-index: 2; }
.cta-section h2 { font-size: clamp(32px, 5vw, 48px); font-weight: 800; margin-bottom: 20px; color: #ffffff; text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
.cta-section p { font-size: 16px; color: #cccccc; max-width: 600px; margin: 0 auto 30px; line-height: 1.6; }
@media (max-width: 768px) { .cta-section { padding: 80px 30px; background-position: center right; } }

/* ========== ADVANCED AI CHATBOT STYLES ========== */
#ai-chatbot { position: fixed; bottom: 30px; right: 30px; z-index: 9999; font-family: 'Inter', sans-serif; }
.chat-toggle { width: 80px; height: 80px; background: transparent; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; position: relative; border: none; animation: float 3s ease-in-out infinite; }
.chat-toggle:hover { animation: none; transform: scale(1.15); }
.chatbot-logo { width: 90px; height: 90px; object-fit: contain; filter: drop-shadow(0 8px 16px rgba(244, 104, 0, 0.4)); animation: logoPulse 2s ease-in-out infinite; }
.chat-badge { position: absolute; top: 0px; right: 0px; background: #FFAC1C; color: white; font-size: 11px; padding: 4px 9px; border-radius: 20px; font-weight: 700; border: 2px solid #111; animation: badgePulse 1.5s ease-in-out infinite; }
.chat-window { position: absolute; bottom: 80px; right: 0; width: 380px; height: 550px; background: #111; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.8); display: flex; flex-direction: column; overflow: hidden; opacity: 0; transform: translateY(20px) scale(0.95); pointer-events: none; transition: all 0.3s ease; border: 1px solid rgba(255,255,255,0.1); }
.chat-window.active { opacity: 1; transform: translateY(0) scale(1); pointer-events: all; }
.chat-header { background: linear-gradient(135deg, #f46800 0%, #ff7a1a 100%); padding: 18px 20px; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
.chat-header-info { display: flex; align-items: center; gap: 12px; color: white; }
.chat-header-info img { width: 50px; height: 50px; border-radius: 8px; background: rgba(255,255,255,0.2); padding: 4px; }
.chat-header-info .header-text { display: flex; flex-direction: column; }
.chat-header-info .header-title { font-weight: 700; font-size: 15px; line-height: 1.2; }
.chat-header-info .header-status { font-size: 11px; opacity: 0.9; display: flex; align-items: center; gap: 5px; }
.status-dot { width: 8px; height: 8px; background: #28c840; border-radius: 50%; box-shadow: 0 0 5px #28c840; }
.chat-close { background: rgba(255,255,255,0.2); border: none; width: 30px; height: 30px; border-radius: 8px; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s; font-size: 14px; }
.chat-close:hover { background: rgba(255,255,255,0.3); }
.chat-messages { flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 15px; background: #0a0a0a; }
.message { display: flex; animation: slideIn 0.3s ease; max-width: 90%; }
.user-message { justify-content: flex-end; align-self: flex-end; }
.bot-message { justify-content: flex-start; align-self: flex-start; }
.message-content { padding: 12px 16px; border-radius: 16px; font-size: 13px; line-height: 1.5; white-space: pre-line; /* Allows line breaks */ }
.user-message .message-content { background: linear-gradient(135deg, #f46800 0%, #ff7a1a 100%); color: white; border-bottom-right-radius: 4px; }
.bot-message .message-content { background: #1a1a1a; color: #e0e0e0; border-bottom-left-radius: 4px; border: 1px solid rgba(255,255,255,0.05); }
.bot-message .message-content strong { color: var(--primary); }
.chat-input-container { padding: 16px; background: #050505; display: flex; gap: 10px; border-top: 1px solid rgba(255,255,255,0.1); flex-shrink: 0; }
.chat-input { flex: 1; padding: 12px 16px; background: #1a1a1a; border: 1px solid rgba(255,255,255,0.1); border-radius: 25px; color: #ffffff; font-size: 13px; outline: none; transition: all 0.3s; }
.chat-input::placeholder { color: #666; }
.chat-input:focus { border-color: #f46800; background: #222; }
.chat-send { width: 42px; height: 42px; background: linear-gradient(135deg, #f46800 0%, #ff7a1a 100%); border: none; border-radius: 50%; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s; flex-shrink: 0; }
.chat-send:hover { transform: scale(1.05); }
.typing-indicator { display: flex; gap: 4px; padding: 10px 15px; background: #1a1a1a; border-radius: 16px; border-bottom-left-radius: 4px; width: fit-content; margin-bottom: 10px; }
.typing-dot { width: 6px; height: 6px; background: #888; border-radius: 50%; animation: typing 1.4s infinite ease-in-out both; }
.typing-dot:nth-child(1) { animation-delay: -0.32s; }
.typing-dot:nth-child(2) { animation-delay: -0.16s; }
@keyframes typing { 0%, 80%, 100% { transform: scale(0); } 40% { transform: scale(1); } }
@keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-15px); } }
@keyframes logoPulse { 0%, 100% { filter: drop-shadow(0 8px 16px rgba(244, 104, 0, 0.4)); transform: scale(1); } 50% { filter: drop-shadow(0 12px 24px rgba(244, 104, 0, 0.6)); transform: scale(1.05); } }
@keyframes badgePulse { 0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(40, 200, 64, 0.7); } 50% { transform: scale(1.1); box-shadow: 0 0 0 8px rgba(40, 200, 64, 0); } }
@keyframes slideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
.chat-messages::-webkit-scrollbar { width: 6px; }
.chat-messages::-webkit-scrollbar-track { background: #111; }
.chat-messages::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }
@media (max-width: 768px) { #ai-chatbot { bottom: 20px; right: 20px; } .chat-window { width: calc(100vw - 40px); height: 70vh; right: -10px; bottom: 75px; } }
</style>

<!-- HERO SECTION WITH VIDEO SLIDER -->
<section class="hero-section">
    <div class="hero-video-slide active" id="slide-1"><video autoplay muted loop playsinline><source src="assets/videos/hero-bg-1.mp4" type="video/mp4"></video></div>
    <div class="hero-video-slide" id="slide-2"><video autoplay muted loop playsinline><source src="assets/videos/hero-bg-2.mp4" type="video/mp4"></video></div>
    <div class="hero-video-slide" id="slide-3"><video autoplay muted loop playsinline><source src="assets/videos/hero-bg-3.mp4" type="video/mp4"></video></div>
    <div class="hero-overlay"></div>
    
    <div class="hero-content">
        <h1>Next-Gen <span>CCTV Surveillance</span><br>with 150+ AI Detections</h1>
        <p>Advanced video analytics for Indian traffic violations, smart cities, defence, healthcare, and industrial safety.</p>
        
        <div class="hero-buttons">
            <a href="#demo" class="btn btn-primary btn-large"><i class="fas fa-play-circle"></i> View Live Demo</a>
            <a href="/pages/features/index.php" class="btn btn-outline btn-large">Explore Features <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="stats-grid">
            <div class="stat-card"><span class="number">150+</span><div class="label">AI Models</div></div>
            <div class="stat-card"><span class="number">12,500+</span><div class="label">Cameras</div></div>
            <div class="stat-card"><span class="number">99%</span><div class="label">Accuracy</div></div>
            <div class="stat-card"><span class="number">85+</span><div class="label">Cities</div></div>
            <div class="stat-card"><span class="number">500K+</span><div class="label">Detections/Day</div></div>
        </div>
    </div>

    <div class="hero-slider-dots">
        <span class="dot active" onclick="goToSlide(0)"></span>
        <span class="dot" onclick="goToSlide(1)"></span>
        <span class="dot" onclick="goToSlide(2)"></span>
    </div>
</section>

<!-- VIDEO DEMO SECTION -->
<section class="video-demo-section" id="demo">
    <div class="section-header">
        <h2>See AI Detection in Action</h2>
        <p>Real-time CCTV footage with AI-powered object detection, tracking, and analytics</p>
    </div>

    <div class="video-grid">
        <!-- Video 1: Traffic -->
        <div class="video-card">
            <div class="video-wrapper">
                <?php 
                $traffic_video = 'assets/videos/features/traffic/demo.mp4';
                if (file_exists($traffic_video)): 
                ?>
                    <video autoplay muted loop playsinline><source src="<?php echo $traffic_video; ?>" type="video/mp4"></video>
                <?php else: ?>
                    <div class="video-placeholder"><i class="fas fa-video"></i><div><strong>Traffic Violation Detection</strong><br><small>Upload: assets/videos/traffic/demo.mp4</small></div></div>
                <?php endif; ?>
            </div>
            <div class="video-info">
                <h3>Traffic Intersection</h3>
                <p>Real-time detection of helmet violations, signal jumping, and overspeeding</p>
                <span class="video-badge">CAM-01 TRAFFIC</span>
            </div>
        </div>

        <!-- Video 2: Smart City -->
        <div class="video-card">
            <div class="video-wrapper">
                <?php 
                $smartcity_video = 'assets/videos/features/smart-city/demo.mp4';
                if (file_exists($smartcity_video)): 
                ?>
                    <video autoplay muted loop playsinline><source src="<?php echo $smartcity_video; ?>" type="video/mp4"></video>
                <?php else: ?>
                    <div class="video-placeholder"><i class="fas fa-video"></i><div><strong>Smart City Surveillance</strong><br><small>Upload: assets/videos/smart-city/demo.mp4</small></div></div>
                <?php endif; ?>
            </div>
            <div class="video-info">
                <h3>Parking Area</h3>
                <p>Crowd monitoring, waste management, and urban infrastructure tracking</p>
                <span class="video-badge">CAM-02 PARKING</span>
            </div>
        </div>

        <!-- Video 3: Industrial -->
        <div class="video-card">
            <div class="video-wrapper">
                <?php 
                $industrial_video = 'assets/videos/features/industrial/demo.mp4';
                if (file_exists($industrial_video)): 
                ?>
                    <video autoplay muted loop playsinline><source src="<?php echo $industrial_video; ?>" type="video/mp4"></video>
                <?php else: ?>
                    <div class="video-placeholder"><i class="fas fa-video"></i><div><strong>Industrial Safety</strong><br><small>Upload: assets/videos/industrial/demo.mp4</small></div></div>
                <?php endif; ?>
            </div>
            <div class="video-info">
                <h3>Industrial Monitor</h3>
                <p>PPE detection, fire & smoke alerts, and machinery monitoring</p>
                <span class="video-badge">CAM-03 Industrial</span>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features-section">
    <div class="section-header">
        <h2>Advanced AI Detection Capabilities</h2>
        <p>Comprehensive AI-powered detection systems for every surveillance need</p>
    </div>
    <div class="features-grid">
        <div class="feature-box"><div class="icon">🚗</div><h3>Traffic Violation Detection</h3><p>Automatic detection of helmet violations, seatbelt compliance, signal jumping, overspeeding, and wrong-side driving with MV Act compliance.</p></div>
        <div class="feature-box"><div class="icon">🏙️</div><h3>Smart City Surveillance</h3><p>Crowd monitoring, waste management, street light monitoring, waterlogging detection, and urban infrastructure management.</p></div>
        <div class="feature-box"><div class="icon">🛡️</div><h3>Defence & Security</h3><p>Perimeter breach detection, weapon detection, drone surveillance, thermal imaging, and border security monitoring.</p></div>
        <div class="feature-box"><div class="icon">🏥</div><h3>Healthcare Monitoring</h3><p>Mask detection, social distancing, fall detection, PPE compliance, patient monitoring, and hand hygiene tracking.</p></div>
        <div class="feature-box"><div class="icon">🏭</div><h3>Industrial Safety</h3><p>PPE detection, fire & smoke alerts, gas leak detection, machinery monitoring, and confined space safety.</p></div>
        <div class="feature-box"><div class="icon">🛒</div><h3>Retail Analytics</h3><p>People counting, heatmaps, dwell time analysis, queue management, shoplifting detection, and customer insights.</p></div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="cta-section">
    <h2>Ready to Transform Your Surveillance?</h2>
    <p>Join 85+ cities and 500+ organizations using TS-NOP-VMS for intelligent video management. Get started with a free demo today.</p>
    <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
        <a href="/pages/company/contact.php" class="btn btn-primary btn-large"><i class="fas fa-rocket"></i> Get Started</a>
        <a href="/ts-admin-panel/ts-admin-login.php" class="btn btn-outline btn-large"><i class="fas fa-lock"></i> Admin Login</a>
    </div>
</section>

<!-- ========== AI CHATBOT WIDGET ========== -->
<div id="ai-chatbot">
    <div class="chat-toggle" onclick="toggleChat()">
        <img src="assets/images/chatbot-logo.png" alt="AI Assistant" class="chatbot-logo">
        <span class="chat-badge">AI</span>
    </div>
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">
            <div class="chat-header-info">
                <img src="assets/images/chatbot-logo.png" alt="AI" class="chat-header-logo">
                <div>
                    <div style="font-weight: 700;">TS-NOP-VMS Agent</div>
                    <div class="header-status"><span class="status-dot"></span> Online - Solving Problems</div>
                </div>
            </div>
            <button class="chat-close" onclick="toggleChat()"><i class="fas fa-times"></i></button>
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="message bot-message">
                <div class="message-content">
                    👋 Hello! I'm your AI Solution Agent. I can help you choose the right surveillance system for your needs.<br><br>
                    Are you looking for solutions for:<br>
                    1️⃣ Traffic Management<br>
                    2️⃣ Smart Cities<br>
                    3️⃣ Industrial Safety<br>
                    4️⃣ Pricing & Demos
                </div>
            </div>
        </div>
        <div class="chat-input-container">
            <input type="text" class="chat-input" id="chatInput" placeholder="Ask me anything..." onkeypress="handleKeyPress(event)">
            <button class="chat-send" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
</div>

<script>
// Advanced AI Agent Logic
function toggleChat() {
    const chatWindow = document.getElementById('chatWindow');
    chatWindow.classList.toggle('active');
    if (chatWindow.classList.contains('active')) {
        document.getElementById('chatInput').focus();
    }
}

function handleKeyPress(event) {
    if (event.key === 'Enter') { sendMessage(); }
}

function showTyping() {
    const messagesContainer = document.getElementById('chatMessages');
    const typingDiv = document.createElement('div');
    typingDiv.className = 'typing-indicator';
    typingDiv.id = 'typingIndicator';
    typingDiv.innerHTML = '<div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>';
    messagesContainer.appendChild(typingDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function removeTyping() {
    const typingIndicator = document.getElementById('typingIndicator');
    if (typingIndicator) {
        typingIndicator.remove();
    }
}

function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    if (message === '') return;
    
    addMessage(message, 'user');
    input.value = '';
    
    // Show typing indicator
    showTyping();
    
    // Simulate AI thinking time (1-2 seconds)
    setTimeout(() => {
        removeTyping();
        const response = getAIResponse(message);
        addMessage(response, 'bot');
    }, 1000 + Math.random() * 1000);
}

function addMessage(text, sender) {
    const messagesContainer = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}-message`;
    messageDiv.innerHTML = `<div class="message-content">${text}</div>`;
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function getAIResponse(message) {
    message = message.toLowerCase();
    
    // 1. Traffic Solutions
    if (message.includes('traffic') || message.includes('violation') || message.includes('helmet') || message.includes('signal')) {
        return "<strong>🚦 Traffic Management Solution:</strong><br>We offer 35+ AI models for Indian roads, including:<br>• Helmet & Seatbelt Detection<br>• Signal Jump & Overspeeding<br>• Triple Riding & Wrong-Side Driving<br><br>✅ <strong>Key Benefit:</strong> Fully compliant with Indian MV Act and ready for e-Challan integration.<br><br>Would you like to see a <a href='/pages/features/category.php?slug=traffic' style='color:#f46800'>live demo</a>?";
    }
    
    // 2. Smart City Solutions
    else if (message.includes('smart city') || message.includes('crowd') || message.includes('waste') || message.includes('urban')) {
        return "<strong>🏙️ Smart City Solution:</strong><br>Transform urban monitoring with:<br>• Crowd Density & Queue Management<br>• Waste Bin Overflow Detection<br>• Street Light & Waterlogging Monitoring<br><br>✅ <strong>Key Benefit:</strong> Centralized command center for municipal operations.<br><br>Check out our <a href='/pages/features/category.php?slug=smart-city' style='color:#f46800'>Smart City features</a>.";
    }
    
    // 3. Industrial Safety
    else if (message.includes('industrial') || message.includes('factory') || message.includes('safety') || message.includes('ppe')) {
        return "<strong>🏭 Industrial Safety Solution:</strong><br>Ensure workplace safety with:<br>• Fire & Smoke Detection<br>• PPE (Helmet/Vest) Compliance<br>• Gas Leak & Machinery Monitoring<br><br>✅ <strong>Key Benefit:</strong> Reduces accidents by 90% and ensures OSHA compliance.<br><br>Explore <a href='/pages/features/category.php?slug=industrial' style='color:#f46800'>Industrial Safety</a>.";
    }
    
    // 4. Pricing & Cost
    else if (message.includes('price') || message.includes('cost') || message.includes('how much') || message.includes('budget')) {
        return "<strong>💰 Pricing Information:</strong><br>Our solutions are customized based on:<br>• Number of Cameras<br>• Required AI Models<br>• Deployment Type (Cloud/Edge)<br><br>📞 <strong>Contact Sales:</strong><br>For a custom quote, please call us at <strong>+91 8660160366</strong> or email <strong>info@tsglobe.com</strong>.<br><br>Or click <a href='/pages/company/contact.php' style='color:#f46800'>here</a> to request a callback.";
    }
    
    // 5. Demo Request
    else if (message.includes('demo') || message.includes('trial') || message.includes('see')) {
        return "<strong>🎥 Live Demo:</strong><br>I'd love to show you our system in action!<br><br>You can:<br>1️⃣ Watch pre-recorded demos on our <a href='/pages/features/index.php' style='color:#f46800'>Features Page</a>.<br>2️⃣ Schedule a live personalized demo with our experts.<br><br>Click <a href='/pages/company/contact.php' style='color:#f46800'>Get Started</a> to book your slot!";
    }
    
    // 6. Greetings
    else if (message.includes('hello') || message.includes('hi') || message.includes('hey')) {
        return "Hello! 👋 I'm here to help you find the perfect AI surveillance solution. What industry are you interested in? (Traffic, Smart City, Industrial, etc.)";
    }
    
    // 7. Default / Fallback
    else {
        return "That's an interesting question! 🤔<br><br>To give you the best answer, could you tell me more about your specific needs? For example:<br>• Are you managing a <strong>Traffic Intersection</strong>?<br>• Do you need <strong>Factory Safety</strong> monitoring?<br>• Or are you looking for <strong>Pricing</strong>?<br><br>Type one of these keywords, and I'll provide a detailed solution!";
    }
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-video-slide');
    const dots = document.querySelectorAll('.dot');
    let currentSlide = 0;
    const intervalTime = 5000;
    let slideInterval;

    function goToSlide(index) {
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        currentSlide = index;
        if (currentSlide >= slides.length) currentSlide = 0;
        if (currentSlide < 0) currentSlide = slides.length - 1;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    function nextSlide() { goToSlide(currentSlide + 1); }
    function startSlider() { slideInterval = setInterval(nextSlide, intervalTime); }
    function stopSlider() { clearInterval(slideInterval); }

    startSlider();

    window.goToSlide = function(index) {
        stopSlider();
        goToSlide(index);
        startSlider();
    };
});
</script>

<?php include 'includes/footer.php'; ?>