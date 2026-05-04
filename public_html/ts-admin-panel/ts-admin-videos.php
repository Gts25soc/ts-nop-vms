<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/database.php';
// ... rest of code
require_once '../config/database.php';
include 'includes/ts-header.php';

$conn = getDBConnection();
$message = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_video'])) {
    $feature_id = $_POST['feature_id'];
    $youtube_id = trim($_POST['youtube_id']);
    $video_path = trim($_POST['video_path']);
    
    if ($conn) {
        $stmt = $conn->prepare("UPDATE features SET youtube_video_id = ?, demo_video_path = ? WHERE id = ?");
        $stmt->bind_param("ssi", $youtube_id, $video_path, $feature_id);
        
        if ($stmt->execute()) {
            $message = '✅ Video updated successfully!';
        } else {
            $message = '❌ Error updating video.';
        }
    }
}

// Fetch all features
$features = [];
if ($conn) {
    $result = $conn->query("SELECT id, title, youtube_video_id, demo_video_path FROM features ORDER BY title LIMIT 50");
    if ($result) {
        $features = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<div class="ts-top-bar">
    <h1>🎥 Manage Feature Videos</h1>
</div>

<?php if ($message): ?>
    <div style="background: rgba(40,200,64,0.1); border: 1px solid #28c840; color: #28c840; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<div style="background: var(--ts-dark2); border-radius: 12px; border: 1px solid #222; padding: 20px;">
    <p style="color: var(--ts-gray); margin-bottom: 20px; font-size: 14px;">
        <strong>Instructions:</strong> Enter YouTube Video ID (e.g., dQw4w9WgXcQ) OR local file path (e.g., assets/videos/test.mp4)
    </p>
    
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--ts-dark3); border-bottom: 1px solid #222;">
                <th style="padding: 12px; text-align: left; color: var(--ts-gray); font-size: 12px;">ID</th>
                <th style="padding: 12px; text-align: left; color: var(--ts-gray); font-size: 12px;">Feature Name</th>
                <th style="padding: 12px; text-align: left; color: var(--ts-gray); font-size: 12px;">YouTube ID</th>
                <th style="padding: 12px; text-align: left; color: var(--ts-gray); font-size: 12px;">Video Path</th>
                <th style="padding: 12px; text-align: left; color: var(--ts-gray); font-size: 12px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($features) > 0): ?>
                <?php foreach($features as $f): ?>
                    <tr style="border-bottom: 1px solid #222;">
                        <td style="padding: 12px; color: var(--ts-light);"><?php echo $f['id']; ?></td>
                        <td style="padding: 12px; color: var(--ts-light); font-weight: 500;"><?php echo htmlspecialchars($f['title']); ?></td>
                        <td style="padding: 12px;">
                            <form method="POST" style="display: flex; gap: 8px;">
                                <input type="hidden" name="feature_id" value="<?php echo $f['id']; ?>">
                                <input type="text" name="youtube_id" placeholder="YouTube ID" 
                                       value="<?php echo htmlspecialchars($f['youtube_video_id']); ?>" 
                                       style="flex: 1; padding: 8px; background: var(--ts-dark3); border: 1px solid #333; color: #fff; border-radius: 4px; font-size: 12px;">
                        </td>
                        <td style="padding: 12px;">
                                <input type="text" name="video_path" placeholder="File path" 
                                       value="<?php echo htmlspecialchars($f['demo_video_path']); ?>" 
                                       style="flex: 1; padding: 8px; background: var(--ts-dark3); border: 1px solid #333; color: #fff; border-radius: 4px; font-size: 12px;">
                        </td>
                        <td style="padding: 12px;">
                                <button type="submit" name="update_video" 
                                        style="padding: 8px 12px; background: var(--ts-primary); color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                    Save
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: var(--ts-gray);">
                        No features found. Check your database connection.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/ts-footer.php'; ?>