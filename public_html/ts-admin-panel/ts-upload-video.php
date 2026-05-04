<?php
session_start();

// Direct database connection (no config file needed)
$host = 'localhost';
$user = 'u633257833_admin';  // Your Hostinger DB username
$pass = 'TechnoVMS2026!'; // ← PUT YOUR DATABASE PASSWORD HERE
$dbname = 'u633257833_vms';   // Your database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['ts_admin_logged_in'])) {
    header("Location: ts-admin-login.php");
    exit();
}

$message = '';
$upload_dir = '../assets/videos/';

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video_file'])) {
    $category = $_POST['category'];
    $feature_id = $_POST['feature_id'];
    $file = $_FILES['video_file'];
    
    $target_dir = $upload_dir . $category . '/';
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = array('mp4', 'avi', 'mov', 'wmv', 'webm');
    
    if (!in_array($file_ext, $allowed)) {
        $message = '<div style="background:rgba(255,95,87,0.1);border:1px solid #ff5f57;color:#ff5f57;padding:16px;border-radius:8px;margin-bottom:20px;">❌ Invalid file type.</div>';
    } elseif ($file['size'] > 100000000) {
        $message = '<div style="background:rgba(255,95,87,0.1);border:1px solid #ff5f57;color:#ff5f57;padding:16px;border-radius:8px;margin-bottom:20px;">❌ File too large.</div>';
    } else {
        $new_filename = uniqid() . '.' . $file_ext;
        $target_file = $target_dir . $new_filename;
        $video_path = 'assets/videos/' . $category . '/' . $new_filename;
        
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("UPDATE features SET demo_video_path = ? WHERE id = ?");
            $stmt->bind_param("si", $video_path, $feature_id);
            if ($stmt->execute()) {
                $message = '<div style="background:rgba(40,200,64,0.1);border:1px solid #28c840;color:#28c840;padding:16px;border-radius:8px;margin-bottom:20px;">✅ Video uploaded successfully!</div>';
            }
        }
    }
}

// Get features
$features = [];
$result = $conn->query("SELECT f.id, f.title, f.category_id, fc.name as category_name FROM features f LEFT JOIN feature_categories fc ON f.category_id = fc.id ORDER BY fc.name, f.title");
if ($result) {
    while($row = $result->fetch_assoc()) {
        $features[] = $row;
    }
}

// Get categories
$categories = [];
$result = $conn->query("SELECT slug, name FROM feature_categories ORDER BY name");
if ($result) {
    while($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video - TS-NOP-VMS Admin</title>
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
        .sidebar { 
            width: 260px; 
            background: var(--ts-dark2); 
            border-right: 1px solid #222; 
            padding: 25px; 
            flex-shrink: 0; 
            position: fixed;
            height: 100vh;
        }
        .sidebar .logo { 
            font-size: 22px; 
            font-weight: 800; 
            margin-bottom: 40px; 
            color: var(--ts-primary); 
            padding-bottom: 20px;
            border-bottom: 1px solid #222;
        }
        .sidebar .logo span { color: var(--ts-white); }
        .nav-item { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 14px; 
            border-radius: 8px; 
            color: var(--ts-gray); 
            text-decoration: none; 
            margin-bottom: 6px; 
            font-size: 14px;
        }
        .nav-item:hover, .nav-item.active { 
            background: rgba(244,104,0,0.15); 
            color: var(--ts-primary); 
        }
        .nav-item i { width: 20px; text-align: center; }
        .logout { margin-top: 30px; color: #ff5f57 !important; border-top: 1px solid #222; padding-top: 15px; }
        .main { flex: 1; padding: 30px; margin-left: 260px; }
        .top-bar { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #222;
        }
        .top-bar h1 { font-size: 26px; font-weight: 700; }
        .content-box { 
            background: var(--ts-dark2); 
            border-radius: 12px; 
            border: 1px solid #222; 
            padding: 30px;
            max-width: 800px;
        }
        .debug-box {
            background: #1a1a1a;
            border: 1px solid #0f0;
            color: #0f0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-family: monospace;
            font-size: 12px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { 
            display: block; 
            color: var(--ts-gray); 
            margin-bottom: 8px; 
            font-weight: 500;
        }
        .form-group select, .form-group input { 
            width: 100%; 
            padding: 12px; 
            background: var(--ts-dark3); 
            border: 1px solid #333; 
            color: #fff; 
            border-radius: 8px; 
            font-size: 14px;
        }
        .btn-upload { 
            width: 100%;
            padding: 14px; 
            background: linear-gradient(135deg, #f46800 0%, #ff7a1a 100%); 
            color: #fff; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-size: 15px; 
            font-weight: 600;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">TS-NOP<span>VMS</span></div>
        <nav>
            <a href="ts-admin-dashboard.php" class="nav-item"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a href="ts-admin-leads.php" class="nav-item"><i class="fas fa-inbox"></i> Leads</a>
            <a href="ts-admin-videos.php" class="nav-item"><i class="fas fa-video"></i> Manage Videos</a>
            <a href="ts-upload-video.php" class="nav-item active"><i class="fas fa-upload"></i> Upload Video</a>
            <a href="/" target="_blank" class="nav-item"><i class="fas fa-external-link-alt"></i> Website</a>
            <a href="ts-admin-logout.php" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <main class="main">
        <div class="top-bar">
            <h1>📤 Upload Video</h1>
        </div>

        <div class="content-box">
            <h3 style="margin-bottom: 20px;">Upload New Video</h3>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Select Feature *</label>
                    <select name="feature_id" required>
                        <option value="">-- Choose a feature --</option>
                        <?php foreach($features as $f): ?>
                            <option value="<?php echo $f['id']; ?>">
                                <?php echo htmlspecialchars($f['category_name'] ?? 'No Category') . ' - ' . htmlspecialchars($f['title']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Category (for folder) *</label>
                    <select name="category" required>
                        <option value="">-- Choose category --</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?php echo $cat['slug']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Video File (Max 100MB) *</label>
                    <input type="file" name="video_file" accept="video/*" required>
                </div>
                
                <button type="submit" class="btn-upload">
                    <i class="fas fa-upload"></i> Upload Video
                </button>
            </form>
        </div>
    </main>
</body>
</html>