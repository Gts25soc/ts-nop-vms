<?php
// CORRECTED PATH: ../config/database.php (One level up)
require_once '../config/database.php';
include 'includes/ts-header.php';

// Get stats
$conn = getDBConnection();
$total_features = 0;
$total_leads = 0;

if ($conn) {
    $res = $conn->query("SELECT COUNT(*) as total FROM features");
    if ($res) $total_features = $res->fetch_assoc()['total'];
    
    $res = $conn->query("SELECT COUNT(*) as total FROM contact_leads");
    if ($res) $total_leads = $res->fetch_assoc()['total'];
}
?>

<div class="ts-top-bar">
    <h1>📊 Dashboard Overview</h1>
    <div class="ts-user-info">
        <div class="ts-avatar">A</div>
        <span>Admin User</span>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div style="background: var(--ts-dark2); padding: 24px; border-radius: 12px; border: 1px solid #222;">
        <div style="width: 48px; height: 48px; background: rgba(244,104,0,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--ts-primary); font-size: 20px; margin-bottom: 16px;">
            <i class="fas fa-microchip"></i>
        </div>
        <h3 style="font-size: 32px; font-weight: 700; margin-bottom: 8px; font-family: 'Courier New', monospace;"><?php echo $total_features; ?></h3>
        <p style="color: var(--ts-gray); font-size: 14px;">AI Features Active</p>
    </div>
    
    <div style="background: var(--ts-dark2); padding: 24px; border-radius: 12px; border: 1px solid #222;">
        <div style="width: 48px; height: 48px; background: rgba(40,200,64,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #28c840; font-size: 20px; margin-bottom: 16px;">
            <i class="fas fa-inbox"></i>
        </div>
        <h3 style="font-size: 32px; font-weight: 700; margin-bottom: 8px; font-family: 'Courier New', monospace;"><?php echo $total_leads; ?></h3>
        <p style="color: var(--ts-gray); font-size: 14px;">Total Leads Received</p>
    </div>
    
    <div style="background: var(--ts-dark2); padding: 24px; border-radius: 12px; border: 1px solid #222;">
        <div style="width: 48px; height: 48px; background: rgba(59,130,246,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #3b82f6; font-size: 20px; margin-bottom: 16px;">
            <i class="fas fa-layer-group"></i>
        </div>
        <h3 style="font-size: 32px; font-weight: 700; margin-bottom: 8px; font-family: 'Courier New', monospace;">6</h3>
        <p style="color: var(--ts-gray); font-size: 14px;">Industry Categories</p>
    </div>
    
    <div style="background: var(--ts-dark2); padding: 24px; border-radius: 12px; border: 1px solid #222;">
        <div style="width: 48px; height: 48px; background: rgba(139,92,246,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #8b5cf6; font-size: 20px; margin-bottom: 16px;">
            <i class="fas fa-video"></i>
        </div>
        <h3 style="font-size: 32px; font-weight: 700; margin-bottom: 8px; font-family: 'Courier New', monospace;">Ready</h3>
        <p style="color: var(--ts-gray); font-size: 14px;">Video System Status</p>
    </div>
</div>

<!-- Recent Leads -->
<div style="background: var(--ts-dark2); border-radius: 12px; border: 1px solid #222; overflow: hidden;">
    <div style="padding: 20px; border-bottom: 1px solid #222; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 18px;">📬 Recent Leads</h3>
        <a href="ts-admin-leads.php" style="padding: 8px 16px; background: rgba(255,255,255,0.1); color: #fff; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500;">View All</a>
    </div>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--ts-dark3);">
                <th style="padding: 16px 20px; text-align: left; color: var(--ts-gray); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Date</th>
                <th style="padding: 16px 20px; text-align: left; color: var(--ts-gray); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Name</th>
                <th style="padding: 16px 20px; text-align: left; color: var(--ts-gray); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Email</th>
                <th style="padding: 16px 20px; text-align: left; color: var(--ts-gray); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Interest</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($conn) {
                $leads = $conn->query("SELECT * FROM contact_leads ORDER BY submitted_at DESC LIMIT 5");
                if ($leads && $leads->num_rows > 0) {
                    while($lead = $leads->fetch_assoc()):
            ?>
                    <tr style="border-bottom: 1px solid #222;">
                        <td style="padding: 16px 20px; color: var(--ts-light); font-size: 14px;"><?php echo date('M d, Y', strtotime($lead['submitted_at'])); ?></td>
                        <td style="padding: 16px 20px; color: var(--ts-light); font-size: 14px;"><?php echo htmlspecialchars($lead['name']); ?></td>
                        <td style="padding: 16px 20px; color: var(--ts-light); font-size: 14px;"><?php echo htmlspecialchars($lead['email']); ?></td>
                        <td style="padding: 16px 20px; color: var(--ts-light); font-size: 14px;"><span style="padding: 4px 10px; background: rgba(244,104,0,0.1); color: var(--ts-primary); border-radius: 20px; font-size: 11px; font-weight: 600;"><?php echo ucfirst($lead['interest_type']); ?></span></td>
                    </tr>
            <?php 
                    endwhile;
                } else {
                    echo "<tr><td colspan='4' style='text-align:center;padding:40px;color:var(--ts-gray);'>No leads yet. Test the contact form!</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/ts-footer.php'; ?>