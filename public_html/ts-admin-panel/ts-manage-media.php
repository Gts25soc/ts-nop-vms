<?php
session_start();
require_once '../config/database.php';

// Check login
if (!isset($_SESSION['ts_admin_logged_in'])) {
    header("Location: ts-admin-login.php");
    exit();
}

$conn = getDBConnection();
$message = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feature_id = $_POST['feature_id'];
    $action = $_POST['action']; // 'image' or 'video'
    
    if ($action === 'image' && isset($_FILES['feature_image']) && $_FILES['feature_image']['error'] == 0) {
        // --- IMAGE UPLOAD LOGIC ---
        $target_dir = "../assets/images/features/";
        $file_ext = strtolower(pathinfo($_FILES["feature_image"]["name"], PATHINFO_EXTENSION));
        
        // Validate Image
        $allowed_img = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($file_ext, $allowed_img)) {
            $message = '<div style="color:#ff5f57">❌ Invalid image type. Use JPG, PNG, or WEBP.</div>';
        } elseif ($_FILES["feature_image"]["size"] > 2000000) { // 2MB limit
            $message = '<div style="color:#ff5f57">❌ Image too large. Max 2MB.</div>';
        } else {
            $new_filename = uniqid() . '.' . $file_ext;
            $target_file = $target_dir . $new_filename;
            
            if (move_uploaded_file($_FILES["feature_image"]["tmp_name"], $target_file)) {
                $image_path = "assets/images/features/" . $new_filename;
                
                $stmt = $conn->prepare("UPDATE features SET image_path = ? WHERE id = ?");
                $stmt->bind_param("si", $image_path, $feature_id);
                if ($stmt->execute()) {
                    $message = '<div style="color:#28c840">✅ Image uploaded successfully!</div>';
                }
            } else {
                $message = '<div style="color:#ff5f57">❌ Error uploading image file.</div>';
            }
        }
    } 
    elseif ($action === 'video' && isset($_FILES['feature_video']) && $_FILES['feature_video']['error'] == 0) {
        // --- VIDEO UPLOAD LOGIC ---
        $target_dir = "../assets/videos/";
        $file_ext = strtolower(pathinfo($_FILES["feature_video"]["name"], PATHINFO_EXTENSION));
        
        // Validate Video
        $allowed_vid = ['mp4', 'mov', 'webm'];
        if (!in_array($file_ext, $allowed_vid)) {
            $message = '<div style="color:#ff5f57">❌ Invalid video type. Use MP4, MOV, or WEBM.</div>';
        } elseif ($_FILES["feature_video"]["size"] > 100000000) { // 100MB limit
            $message = '<div style="color:#ff5f57">❌ Video too large. Max 100MB.</div>';
        } else {
            $new_filename = uniqid() . '.' . $file_ext;
            $target_file = $target_dir . $new_filename;
            
            if (move_uploaded_file($_FILES["feature_video"]["tmp_name"], $target_file)) {
                $video_path = "assets/videos/" . $new_filename;
                
                $stmt = $conn->prepare("UPDATE features SET demo_video_path = ? WHERE id = ?");
                $stmt->bind_param("si", $video_path, $feature_id);
                if ($stmt->execute()) {
                    $message = '<div style="color:#28c840">✅ Video uploaded successfully!</div>';
                }
            } else {
                $message = '<div style="color:#ff5f57">❌ Error uploading video file.</div>';
            }
        }
    }
}

// Fetch all features
$features = [];
if ($conn) {
    $result = $conn->query("SELECT f.id, f.title, f.image_path, f.demo_video_path, fc.name as category_name 
                            FROM features f 
                            LEFT JOIN feature_categories fc ON f.category_id = fc.id 
                            ORDER BY fc.name, f.title");
    if ($result) {
        $features = $result->fetch_all(MYSQLI_ASSOC);
    }
}

include 'includes/ts-header.php';
?>

<div class="ts-top-bar">
    <h1>🖼️ Manage Feature Media</h1>
</div>

<?php if ($message): ?>
    <div style="background: rgba(40,200,64,0.1); border: 1px solid #28c840; color: #28c840; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<!-- Guidelines Box -->
<div style="background: var(--ts-dark2); border: 1px solid #3b82f6; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
    <h3 style="color: #3b82f6; margin-bottom: 15px;"><i class="fas fa-info-circle"></i> Media Guidelines & Dimensions</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
        <!-- Image Guidelines -->
        <div>
            <h4 style="color: #fff; margin-bottom: 10px;">📸 Image Specifications</h4>
            <ul style="color: var(--ts-gray); font-size: 13px; line-height: 1.6; margin: 0; padding-left: 20px;">
                <li><strong>Dimensions:</strong> 1920x1080px (16:9 Aspect Ratio)</li>
                <li><strong>Format:</strong> JPG, PNG, or WEBP</li>
                <li><strong>Max Size:</strong> 2 MB</li>
                <li><strong>Tip:</strong> Use high-contrast images showing AI bounding boxes if possible.</li>
            </ul>
        </div>
        <!-- Video Guidelines -->
        <div>
            <h4 style="color: #fff; margin-bottom: 10px;">🎥 Video Specifications</h4>
            <ul style="color: var(--ts-gray); font-size: 13px; line-height: 1.6; margin: 0; padding-left: 20px;">
                <li><strong>Dimensions:</strong> 1920x1080px (1080p) or 1280x720px (720p)</li>
                <li><strong>Format:</strong> MP4 (H.264 codec recommended)</li>
                <li><strong>Max Size:</strong> 100 MB</li>
                <li><strong>Duration:</strong> 10–30 seconds recommended for previews.</li>
            </ul>
        </div>
    </div>
</div>

<!-- Media Management Table -->
<div style="background: var(--ts-dark2); border-radius: 12px; border: 1px solid #222; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--ts-dark3);">
                <th style="padding: 16px; text-align: left; color: var(--ts-gray); width: 30%;">Feature Name</th>
                <th style="padding: 16px; text-align: left; color: var(--ts-gray); width: 20%;">Current Media</th>
                <th style="padding: 16px; text-align: left; color: var(--ts-gray); width: 50%;">Upload New Media</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($features as $f): ?>
                <tr style="border-bottom: 1px solid #222;">
                    <td style="padding: 16px; color: var(--ts-light);">
                        <strong><?php echo htmlspecialchars($f['title']); ?></strong><br>
                        <small style="color: var(--ts-gray);"><?php echo htmlspecialchars($f['category_name']); ?></small>
                    </td>
                    <td style="padding: 16px; color: var(--ts-gray); font-size: 13px;">
                        <?php if(!empty($f['image_path'])): ?>
                            <span style="color: #28c840;">📷 Image Set</span>
                        <?php elseif(!empty($f['demo_video_path'])): ?>
                            <span style="color: #f46800;">🎥 Video Set</span>
                        <?php else: ?>
                            <span style="color: #666;">None</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 16px;">
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            
                            <!-- Image Upload Form -->
                            <form method="POST" enctype="multipart/form-data" style="display: flex; align-items: center; gap: 10px;">
                                <input type="hidden" name="feature_id" value="<?php echo $f['id']; ?>">
                                <input type="hidden" name="action" value="image">
                                
                                <label style="font-size: 12px; color: var(--ts-gray); width: 60px;">Image:</label>
                                <input type="file" name="feature_image" accept="image/*" style="font-size: 12px; color: #fff; max-width: 200px;">
                                <button type="submit" style="padding: 6px 12px; background: #3b82f6; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">Upload Img</button>
                            </form>

                            <!-- Video Upload Form -->
                            <form method="POST" enctype="multipart/form-data" style="display: flex; align-items: center; gap: 10px;">
                                <input type="hidden" name="feature_id" value="<?php echo $f['id']; ?>">
                                <input type="hidden" name="action" value="video">
                                
                                <label style="font-size: 12px; color: var(--ts-gray); width: 60px;">Video:</label>
                                <input type="file" name="feature_video" accept="video/*" style="font-size: 12px; color: #fff; max-width: 200px;">
                                <button type="submit" style="padding: 6px 12px; background: var(--ts-primary); color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">Upload Vid</button>
                            </form>

                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/ts-footer.php'; ?>