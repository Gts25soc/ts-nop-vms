<?php
require_once '../config/database.php';
include 'includes/ts-header.php';

$conn = getDBConnection();
$leads = [];

if ($conn) {
    $result = $conn->query("SELECT * FROM contact_leads ORDER BY submitted_at DESC");
    if ($result) {
        $leads = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<div class="ts-top-bar">
    <h1>📬 Leads & Contact Forms</h1>
    <div class="ts-user-info">
        <div class="ts-avatar">A</div>
        <span>Admin User</span>
    </div>
</div>

<!-- Stats Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px;">
    <div style="background: var(--ts-dark2); padding: 20px; border-radius: 10px; border: 1px solid #222;">
        <div style="color: var(--ts-gray); font-size: 13px; margin-bottom: 8px;">Total Leads</div>
        <div style="font-size: 28px; font-weight: 700; color: var(--ts-primary); font-family: 'Courier New', monospace;"><?php echo count($leads); ?></div>
    </div>
    <div style="background: var(--ts-dark2); padding: 20px; border-radius: 10px; border: 1px solid #222;">
        <div style="color: var(--ts-gray); font-size: 13px; margin-bottom: 8px;">This Month</div>
        <div style="font-size: 28px; font-weight: 700; color: #28c840; font-family: 'Courier New', monospace;">
            <?php 
            if ($conn) {
                $monthly = $conn->query("SELECT COUNT(*) as total FROM contact_leads WHERE MONTH(submitted_at) = MONTH(CURRENT_DATE())");
                echo $monthly->fetch_assoc()['total'];
            }
            ?>
        </div>
    </div>
</div>

<!-- Leads Table -->
<div style="background: var(--ts-dark2); border-radius: 12px; border: 1px solid #222; overflow: hidden;">
    <div style="padding: 20px; border-bottom: 1px solid #222;">
        <h3 style="font-size: 18px;">All Contact Submissions</h3>
    </div>
    
    <?php if (count($leads) > 0): ?>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--ts-dark3);">
                    <th style="padding: 16px 20px; text-align: left; color: var(--ts-gray); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Date & Time</th>
                    <th style="padding: 16px 20px; text-align: left; color: var(--ts-gray); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Name</th>
                    <th style="padding: 16px 20px; text-align: left; color: var(--ts-gray); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Email</th>
                    <th style="padding: 16px 20px; text-align: left; color: var(--ts-gray); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Phone</th>
                    <th style="padding: 16px 20px; text-align: left; color: var(--ts-gray); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Interest</th>
                    <th style="padding: 16px 20px; text-align: left; color: var(--ts-gray); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Message</th>
                    <th style="padding: 16px 20px; text-align: left; color: var(--ts-gray); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($leads as $lead): ?>
                    <tr style="border-bottom: 1px solid #222;">
                        <td style="padding: 16px 20px; color: var(--ts-light); font-size: 13px; white-space: nowrap;">
                            <?php echo date('M d, Y H:i', strtotime($lead['submitted_at'])); ?>
                        </td>
                        <td style="padding: 16px 20px; color: var(--ts-light); font-size: 14px; font-weight: 500;">
                            <?php echo htmlspecialchars($lead['name']); ?>
                        </td>
                        <td style="padding: 16px 20px; color: var(--ts-light); font-size: 14px;">
                            <a href="mailto:<?php echo htmlspecialchars($lead['email']); ?>" style="color: var(--ts-primary); text-decoration: none;">
                                <?php echo htmlspecialchars($lead['email']); ?>
                            </a>
                        </td>
                        <td style="padding: 16px 20px; color: var(--ts-light); font-size: 14px;">
                            <?php echo htmlspecialchars($lead['phone']); ?>
                        </td>
                        <td style="padding: 16px 20px;">
                            <span style="padding: 4px 10px; background: rgba(244,104,0,0.1); color: var(--ts-primary); border-radius: 20px; font-size: 11px; font-weight: 600;">
                                <?php echo ucfirst($lead['interest_type']); ?>
                            </span>
                        </td>
                        <td style="padding: 16px 20px; color: var(--ts-gray); font-size: 13px; max-width: 200px;">
                            <?php echo substr(htmlspecialchars($lead['message']), 0, 50); ?>...
                        </td>
                        <td style="padding: 16px 20px;">
                            <button onclick="viewLead(<?php echo htmlspecialchars(json_encode($lead)); ?>)" 
                                    style="padding: 6px 12px; background: rgba(255,255,255,0.1); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 12px;">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div style="padding: 60px 20px; text-align: center; color: var(--ts-gray);">
            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
            <p>No leads found yet. Test your contact form!</p>
        </div>
    <?php endif; ?>
</div>

<!-- View Lead Modal -->
<div id="leadModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--ts-dark2); padding: 30px; border-radius: 12px; max-width: 600px; width: 90%; border: 1px solid #222;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #222;">
            <h3 style="font-size: 20px;">Lead Details</h3>
            <button onclick="closeModal()" style="background: none; border: none; color: var(--ts-gray); cursor: pointer; font-size: 20px;">&times;</button>
        </div>
        <div id="leadContent"></div>
    </div>
</div>

<script>
function viewLead(lead) {
    const content = `
        <div style="margin-bottom: 15px;">
            <div style="color: var(--ts-gray); font-size: 12px; margin-bottom: 4px;">Name</div>
            <div style="color: #fff; font-size: 15px; font-weight: 600;">${lead.name}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="color: var(--ts-gray); font-size: 12px; margin-bottom: 4px;">Email</div>
            <div style="color: var(--ts-primary); font-size: 15px;"><a href="mailto:${lead.email}" style="color: var(--ts-primary); text-decoration: none;">${lead.email}</a></div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="color: var(--ts-gray); font-size: 12px; margin-bottom: 4px;">Phone</div>
            <div style="color: #fff; font-size: 15px;">${lead.phone || 'N/A'}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="color: var(--ts-gray); font-size: 12px; margin-bottom: 4px;">Company</div>
            <div style="color: #fff; font-size: 15px;">${lead.company || 'N/A'}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="color: var(--ts-gray); font-size: 12px; margin-bottom: 4px;">Interest Type</div>
            <div style="color: #fff; font-size: 15px;">${lead.interest_type}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="color: var(--ts-gray); font-size: 12px; margin-bottom: 4px;">Subject</div>
            <div style="color: #fff; font-size: 15px;">${lead.subject || 'N/A'}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="color: var(--ts-gray); font-size: 12px; margin-bottom: 4px;">Message</div>
            <div style="background: var(--ts-dark3); padding: 15px; border-radius: 8px; color: #fff; font-size: 14px; line-height: 1.6;">${lead.message}</div>
        </div>
        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #222;">
            <div style="color: var(--ts-gray); font-size: 12px;">Submitted: ${new Date(lead.submitted_at).toLocaleString()}</div>
        </div>
        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <a href="mailto:${lead.email}?subject=Re: ${lead.subject || 'Your inquiry'}" 
               style="flex: 1; padding: 12px; background: var(--ts-primary); color: #fff; text-align: center; border-radius: 8px; text-decoration: none; font-weight: 600;">
                <i class="fas fa-reply"></i> Reply via Email
            </a>
        </div>
    `;
    document.getElementById('leadContent').innerHTML = content;
    document.getElementById('leadModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('leadModal').style.display = 'none';
}

// Close modal on outside click
document.getElementById('leadModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

<?php include 'includes/ts-footer.php'; ?>