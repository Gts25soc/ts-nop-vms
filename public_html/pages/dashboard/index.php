<?php
$page_title = 'Live Command Center | TS-NOP-VMS';
include '../../includes/header.php';
?>

<style>
/* VMS Dashboard Specific Styles */
.vms-dashboard {
    display: flex;
    height: calc(100vh - 80px);
    background: #0a0a0a;
    color: #fff;
    font-family: 'Inter', sans-serif;
    overflow: hidden;
}

.dashboard-sidebar {
    width: 260px;
    background: #111;
    border-right: 1px solid #222;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

.sidebar-header {
    padding: 20px;
    border-bottom: 1px solid #222;
    font-weight: 700;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--primary);
}

.camera-tree {
    flex: 1;
    overflow-y: auto;
    padding: 10px;
}

.tree-group { margin-bottom: 10px; }

.tree-title {
    padding: 8px 12px;
    font-size: 13px;
    font-weight: 600;
    color: #ccc;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    border-radius: 4px;
}

.tree-title:hover { background: #222; }
.tree-title i { font-size: 12px; color: var(--primary); }

.tree-item {
    padding: 8px 12px 8px 32px;
    font-size: 12px;
    color: #888;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    border-radius: 4px;
    transition: all 0.2s;
}

.tree-item:hover { background: #222; color: #fff; }
.tree-item.active { background: rgba(244,104,0,0.1); color: var(--primary); border-left: 3px solid var(--primary); }
.tree-status { width: 8px; height: 8px; border-radius: 50%; background: #28c840; }

.dashboard-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #0a0a0a;
}

.top-bar {
    height: 50px;
    background: #111;
    border-bottom: 1px solid #222;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
}

.top-left { display: flex; align-items: center; gap: 15px; }
.top-right { display: flex; align-items: center; gap: 15px; }

.system-time {
    font-family: 'JetBrains Mono', monospace;
    font-size: 14px;
    color: var(--primary);
}

.alert-badge {
    position: relative;
    cursor: pointer;
}

.alert-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff0000;
    color: white;
    font-size: 10px;
    padding: 2px 5px;
    border-radius: 10px;
    animation: pulse 1s infinite;
}

.video-grid-container {
    flex: 1;
    padding: 10px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: repeat(2, 1fr);
    gap: 10px;
    overflow: hidden;
}

.video-cell {
    background: #000;
    border: 1px solid #333;
    border-radius: 4px;
    position: relative;
    overflow: hidden;
    cursor: pointer;
    transition: border-color 0.3s;
}

.video-cell:hover { border-color: var(--primary); }
.video-cell.active { border: 2px solid var(--primary); }

/* Video Container */
.video-container {
    width: 100%;
    height: 100%;
    position: relative;
    background: #000;
}

.video-container video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #444;
    font-size: 12px;
    text-align: center;
    flex-direction: column;
}

.ai-overlay {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 2;
}

.bounding-box {
    position: absolute;
    border: 2px solid #00ff00;
    box-shadow: 0 0 10px rgba(0,255,0,0.3);
    animation: detect-pulse 2s infinite;
}

.bounding-box::after {
    content: attr(data-label);
    position: absolute;
    top: -20px;
    left: 0;
    background: #00ff00;
    color: black;
    font-size: 10px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 2px;
}

.bounding-box.red { border-color: #ff0000; box-shadow: 0 0 10px rgba(255,0,0,0.3); }
.bounding-box.red::after { background: #ff0000; color: white; }

.cell-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.8);
    padding: 8px 10px;
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    font-family: 'JetBrains Mono', monospace;
    z-index: 3;
}

.rec-indicator {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #ff0000;
    font-weight: bold;
}

.rec-dot {
    width: 8px;
    height: 8px;
    background: #ff0000;
    border-radius: 50%;
    animation: blink 1s infinite;
}

.dashboard-right-panel {
    width: 300px;
    background: #111;
    border-left: 1px solid #222;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

.panel-header {
    padding: 15px;
    border-bottom: 1px solid #222;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.alert-feed {
    flex: 1;
    overflow-y: auto;
    padding: 10px;
}

.alert-item {
    background: #1a1a1a;
    border-left: 3px solid #444;
    padding: 10px;
    margin-bottom: 8px;
    border-radius: 0 4px 4px 0;
    font-size: 12px;
    animation: slide-in 0.3s ease;
}

.alert-item.critical { border-left-color: #ff0000; background: rgba(255,0,0,0.05); }
.alert-item.warning { border-left-color: #ffbd2e; background: rgba(255,189,46,0.05); }
.alert-item.info { border-left-color: #28c840; }

.alert-time { font-family: 'JetBrains Mono', monospace; color: #888; font-size: 10px; margin-bottom: 4px; }
.alert-msg { color: #ccc; line-height: 1.4; }
.alert-camera { color: var(--primary); font-weight: 600; margin-top: 4px; display: block; }

@keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
@keyframes detect-pulse { 0% { opacity: 0.8; } 50% { opacity: 1; box-shadow: 0 0 15px currentColor; } 100% { opacity: 0.8; } }
@keyframes slide-in { from { transform: translateX(20px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

@media (max-width: 1200px) {
    .dashboard-right-panel { display: none; }
    .video-grid-container { grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .dashboard-sidebar { display: none; }
    .video-grid-container { grid-template-columns: 1fr; grid-template-rows: repeat(6, 1fr); }
}
</style>

<div class="vms-dashboard">
    <!-- Sidebar -->
    <aside class="dashboard-sidebar">
        <div class="sidebar-header">
            <i class="fas fa-video"></i> Camera Tree
        </div>
        <div class="camera-tree">
            <div class="tree-group">
                <div class="tree-title"><i class="fas fa-chevron-down"></i> Traffic Zone A</div>
                <div class="tree-item active"><span class="tree-status"></span>CAM-01 Main Gate</div>
                <div class="tree-item"><span class="tree-status"></span>CAM-02 Highway Entry</div>
                <div class="tree-item"><span class="tree-status"></span>CAM-03 Toll Plaza</div>
            </div>
            <div class="tree-group">
                <div class="tree-title"><i class="fas fa-chevron-right"></i> Smart City Zone B</div>
                <div class="tree-item"><span class="tree-status"></span>CAM-04 Market Square</div>
                <div class="tree-item"><span class="tree-status"></span>CAM-05 Park Area</div>
            </div>
            <div class="tree-group">
                <div class="tree-title"><i class="fas fa-chevron-right"></i> Industrial Zone C</div>
                <div class="tree-item"><span class="tree-status"></span>CAM-06 Factory Floor</div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">
        <header class="top-bar">
            <div class="top-left">
                <span style="font-weight: 700; color: var(--primary);">LIVE COMMAND CENTER</span>
                <span style="font-size: 12px; color: #888;">| System Online</span>
            </div>
            <div class="system-time" id="clock">00:00:00</div>
            <div class="top-right">
                <div class="alert-badge">
                    <i class="fas fa-bell" style="color: #ccc;"></i>
                    <span class="alert-count" id="alertCount">3</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 30px; height: 30px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">A</div>
                    <span style="font-size: 13px;">Admin User</span>
                </div>
            </div>
        </header>

        <div class="video-grid-container" id="videoGrid">
            <!-- Video Cell 1: Traffic Intersection -->
            <div class="video-cell active" onclick="selectCamera(this, 'CAM-01')">
                <div class="video-container">
                    <video autoplay muted loop playsinline poster="assets/images/video-placeholder.jpg">
                        <source src="assets/videos/dashboard/cam-01.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="ai-overlay">
                        <div class="bounding-box red" style="top: 30%; left: 40%; width: 20%; height: 40%;" data-label="Helmet: NO"></div>
                        <div class="bounding-box" style="top: 50%; left: 60%; width: 15%; height: 30%;" data-label="Car: 85km/h"></div>
                    </div>
                    <div class="cell-info">
                        <span>CAM-01 | 1080p | 30fps</span>
                        <span class="rec-indicator"><span class="rec-dot"></span> REC</span>
                    </div>
                </div>
            </div>

            <!-- Video Cell 2: Parking Lot -->
            <div class="video-cell" onclick="selectCamera(this, 'CAM-02')">
                <div class="video-container">
                    <video autoplay muted loop playsinline poster="assets/images/video-placeholder.jpg">
                        <source src="assets/videos/dashboard/cam-02.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="ai-overlay">
                        <div class="bounding-box" style="top: 40%; left: 20%; width: 25%; height: 35%;" data-label="Person"></div>
                    </div>
                    <div class="cell-info">
                        <span>CAM-02 | 1080p | 30fps</span>
                        <span class="rec-indicator"><span class="rec-dot"></span> REC</span>
                    </div>
                </div>
            </div>

            <!-- Video Cell 3: Highway Monitor -->
            <div class="video-cell" onclick="selectCamera(this, 'CAM-03')">
                <div class="video-container">
                    <video autoplay muted loop playsinline poster="assets/images/video-placeholder.jpg">
                        <source src="assets/videos/dashboard/cam-03.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="ai-overlay">
                        <div class="bounding-box red" style="top: 60%; left: 10%; width: 30%; height: 20%;" data-label="Speed: 120km/h"></div>
                    </div>
                    <div class="cell-info">
                        <span>CAM-03 | 1080p | 30fps</span>
                        <span class="rec-indicator"><span class="rec-dot"></span> REC</span>
                    </div>
                </div>
            </div>

            <!-- Video Cell 4: Market Square -->
            <div class="video-cell" onclick="selectCamera(this, 'CAM-04')">
                <div class="video-container">
                    <video autoplay muted loop playsinline poster="assets/images/video-placeholder.jpg">
                        <source src="assets/videos/dashboard/cam-04.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="ai-overlay">
                        <div class="bounding-box" style="top: 20%; left: 50%; width: 10%; height: 20%;" data-label="Crowd: High"></div>
                    </div>
                    <div class="cell-info">
                        <span>CAM-04 | 1080p | 30fps</span>
                        <span class="rec-indicator"><span class="rec-dot"></span> REC</span>
                    </div>
                </div>
            </div>

            <!-- Video Cell 5: Factory Floor -->
            <div class="video-cell" onclick="selectCamera(this, 'CAM-05')">
                <div class="video-container">
                    <video autoplay muted loop playsinline poster="assets/images/video-placeholder.jpg">
                        <source src="assets/videos/dashboard/cam-05.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="ai-overlay">
                        <div class="bounding-box red" style="top: 50%; left: 30%; width: 15%; height: 25%;" data-label="No Helmet"></div>
                    </div>
                    <div class="cell-info">
                        <span>CAM-05 | 1080p | 30fps</span>
                        <span class="rec-indicator"><span class="rec-dot"></span> REC</span>
                    </div>
                </div>
            </div>

            <!-- Video Cell 6: Warehouse -->
            <div class="video-cell" onclick="selectCamera(this, 'CAM-06')">
                <div class="video-container">
                    <video autoplay muted loop playsinline poster="assets/images/video-placeholder.jpg">
                        <source src="assets/videos/dashboard/cam-06.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="cell-info">
                        <span>CAM-06 | 1080p | 30fps</span>
                        <span class="rec-indicator"><span class="rec-dot"></span> REC</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Right Panel -->
    <aside class="dashboard-right-panel">
        <div class="panel-header">
            <span>AI Alert Feed</span>
            <button style="background: none; border: none; color: var(--primary); cursor: pointer;"><i class="fas fa-filter"></i></button>
        </div>
        <div class="alert-feed" id="alertFeed">
            <!-- Alerts injected by JS -->
        </div>
    </aside>
</div>

<script>
// Clock
function updateClock() {
    const now = new Date();
    document.getElementById('clock').textContent = now.toLocaleTimeString('en-US', { hour12: false });
}
setInterval(updateClock, 1000);
updateClock();

// Camera Selection
function selectCamera(element, camId) {
    document.querySelectorAll('.video-cell').forEach(c => c.classList.remove('active'));
    element.classList.add('active');
    
    // Update sidebar active state
    document.querySelectorAll('.tree-item').forEach(item => {
        item.classList.remove('active');
        if(item.textContent.includes(camId)) {
            item.classList.add('active');
        }
    });
}

// Simulated Alerts
const alertTypes = [
    { type: 'critical', msg: 'Helmet Violation Detected', cam: 'CAM-01' },
    { type: 'warning', msg: 'Overspeeding: 110 km/h', cam: 'CAM-03' },
    { type: 'info', msg: 'Vehicle Entered Zone', cam: 'CAM-02' },
    { type: 'critical', msg: 'Fire Smoke Detected', cam: 'CAM-05' },
    { type: 'warning', msg: 'Crowd Density > 80%', cam: 'CAM-04' },
    { type: 'info', msg: 'PPE Compliance Check', cam: 'CAM-06' }
];

function addAlert() {
    const feed = document.getElementById('alertFeed');
    const randomAlert = alertTypes[Math.floor(Math.random() * alertTypes.length)];
    const time = new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' });
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert-item ${randomAlert.type}`;
    alertDiv.innerHTML = `
        <div class="alert-time">${time}</div>
        <div class="alert-msg">${randomAlert.msg}</div>
        <span class="alert-camera">${randomAlert.cam}</span>
    `;
    
    feed.insertBefore(alertDiv, feed.firstChild);
    
    if (feed.children.length > 20) {
        feed.removeChild(feed.lastChild);
    }
    
    const count = parseInt(document.getElementById('alertCount').textContent) + 1;
    document.getElementById('alertCount').textContent = count > 9 ? '9+' : count;
}

for(let i=0; i<5; i++) addAlert();
setInterval(addAlert, 3000);
</script>

<?php include '../../includes/footer.php'; ?>