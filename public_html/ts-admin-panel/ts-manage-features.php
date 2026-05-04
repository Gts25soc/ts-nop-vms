<?php
require_once '../config/database.php';
include 'includes/ts-header.php';

$conn = getDBConnection();
$message = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_feature'])) {
    $feature_id = $_POST['feature_id'];
    $image_path = trim($_POST['image_path']);
    $video_path = trim($_POST['video_path']);
    
    // Handle Image Upload if file is selected
    if (isset($_FILES['feature_image']) && $_FILES['feature_image']['error'] == 0) {
        $target_dir = "../assets/images/features/";
        // You might want to organize by category slug here, but for now, let's keep it simple or use a generic folder
        $file_ext = strtolower(pathinfo($_FILES["feature_image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_ext;
        $target_file = $target_dir . $new_filename;
        
        if (move_uploaded_file($_FILES["feature_image"]["tmp_name"], $target_file)) {
            $image_path = "assets/images/features/" . $new_filename;
        }
    }

    if ($conn) {
        $stmt = $conn->prepare("UPDATE features SET image_path = ?, demo_video_path = ? WHERE id = ?");
        $stmt->bind_param("ssi", $image_path, $video_path, $feature_id);
        
        if ($stmt->execute()) {
            $message = '✅ Feature media updated successfully!';
        } else {
            $message = '❌ Error updating database.';
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
?>

<div class="ts-top-bar">
    <h1>🖼️ Manage Feature Media</h1>
</div>

<?php if ($message): ?>
    <div style="background: rgba(40,200,64,0.1); border: 1px solid #28c840; color: #28c840; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<div style="background: var(--ts-dark2); border-radius: 12px; border: 1px solid #222; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--ts-dark3);">
                <th style="padding: 16px; text-align: left; color: var(--ts-gray);">Feature</th>
                <th style="padding: 16px; text-align: left; color: var(--ts-gray);">Current Media</th>
                <th style="padding: 16px; text-align: left; color: var(--ts-gray);">Update Media</th>
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
                            <span style="color: #28c840;">📷 Image</span>
                        <?php elseif(!empty($f['demo_video_path'])): ?>
                            <span style="color: #f46800;">🎥 Video</span>
                        <?php else: ?>
                            <span style="color: #666;">None</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 16px;">
                        <form method="POST" enctype="multipart/form-data" style="display: flex; gap: 10px; align-items: center;">
                            <input type="hidden" name="feature_id" value="<?php echo $f['id']; ?>">
                            
                            <!-- Image Upload -->
                            <input type="file" name="feature_image" accept="image/*" style="font-size: 12px; color: #fff;">
                            
                            <!-- OR Video Path -->
                            <input type="text" name="video_path" placeholder="Or Video Path" value="<?php echo htmlspecialchars($f['demo_video_path']); ?>" style="width: 150px; padding: 6px; background: var(--ts-dark3); border: 1px solid #333; color: #fff; border-radius: 4px; font-size: 12px;">
                            
                            <button type="submit" name="update_feature" style="padding: 6px 12px; background: var(--ts-primary); color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">Save</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/ts-footer.php'; ?>