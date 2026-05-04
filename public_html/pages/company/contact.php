<?php
// Include database config
require_once '../../config/database.php';

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $data = [
        'name' => sanitizeInput($_POST['name']),
        'email' => sanitizeInput($_POST['email']),
        'phone' => sanitizeInput($_POST['phone']),
        'company' => sanitizeInput($_POST['company']),
        'subject' => sanitizeInput($_POST['subject']),
        'message' => sanitizeInput($_POST['message']),
        'interest_type' => sanitizeInput($_POST['interest_type'])
    ];
    
    // Validation
    if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
        $error_message = 'Please fill in all required fields.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Please enter a valid email address.';
    } else {
        if (insertContactLead($data)) {
            $success_message = 'Thank you for contacting us! We will get back to you within 24 hours.';
            
            // Send email notification (optional)
            $to = 'info@tsglobe.com';
            $email_subject = "New Contact Form: " . $data['subject'];
            $email_body = "Name: {$data['name']}\n";
            $email_body .= "Email: {$data['email']}\n";
            $email_body .= "Phone: {$data['phone']}\n";
            $email_body .= "Company: {$data['company']}\n";
            $email_body .= "Interest: {$data['interest_type']}\n";
            $email_body .= "Message:\n{$data['message']}";
            
            $headers = "From: {$data['email']}\r\n";
            $headers .= "Reply-To: {$data['email']}\r\n";
            
            @mail($to, $email_subject, $email_body, $headers);
        } else {
            $error_message = 'Something went wrong. Please try again or contact us directly.';
        }
    }
}

$page_title = 'Contact Us';
include '../../includes/header.php';
?>

<style>
.contact-page {
    padding-top: 80px;
    min-height: 100vh;
}

.contact-hero {
    background: linear-gradient(135deg, rgba(244,104,0,0.1) 0%, rgba(10,10,10,1) 100%);
    padding: 80px 50px;
    text-align: center;
}

.contact-hero h1 {
    font-size: clamp(32px, 5vw, 48px);
    font-weight: 800;
    margin-bottom: 16px;
}

.contact-hero p {
    font-size: 16px;
    color: var(--gray);
    max-width: 600px;
    margin: 0 auto;
}

.contact-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 50px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
}

.contact-info h2 {
    font-size: 28px;
    margin-bottom: 24px;
}

.contact-info > p {
    color: var(--gray);
    margin-bottom: 32px;
    line-height: 1.7;
}

.contact-details {
    margin-bottom: 40px;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
}

.contact-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: rgba(244,104,0,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 20px;
    flex-shrink: 0;
}

.contact-text h3 {
    font-size: 16px;
    margin-bottom: 4px;
}

.contact-text p, .contact-text a {
    color: var(--light-gray);
    text-decoration: none;
    font-size: 14px;
    line-height: 1.6;
}

.contact-text a:hover {
    color: var(--primary);
}

.social-links-contact {
    display: flex;
    gap: 12px;
    margin-top: 32px;
}

.social-links-contact a {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: var(--dark-3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray);
    transition: all 0.3s ease;
}

.social-links-contact a:hover {
    background: var(--primary);
    color: var(--white);
    transform: translateY(-3px);
}

.contact-form-container {
    background: var(--dark-2);
    border-radius: 16px;
    padding: 40px;
    border: 1px solid rgba(244,104,0,0.2);
}

.contact-form-container h2 {
    font-size: 24px;
    margin-bottom: 8px;
}

.contact-form-container > p {
    color: var(--gray);
    font-size: 14px;
    margin-bottom: 32px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 500;
}

.form-group label .required {
    color: var(--primary);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px 16px;
    background: var(--dark-3);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    color: var(--white);
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(244,104,0,0.1);
}

.form-group textarea {
    min-height: 120px;
    resize: vertical;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.alert {
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 24px;
    font-size: 14px;
}

.alert-success {
    background: rgba(40, 200, 64, 0.1);
    border: 1px solid rgba(40, 200, 64, 0.3);
    color: #28c840;
}

.alert-error {
    background: rgba(255, 95, 87, 0.1);
    border: 1px solid rgba(255, 95, 87, 0.3);
    color: #ff5f57;
}

.map-container {
    margin-top: 60px;
    padding: 0 50px 60px;
}

.map-container h2 {
    text-align: center;
    margin-bottom: 24px;
}

.map-wrapper {
    background: var(--dark-2);
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(244,104,0,0.2);
    height: 400px;
}

.map-wrapper iframe {
    width: 100%;
    height: 100%;
    border: none;
}

@media (max-width: 1024px) {
    .contact-container {
        grid-template-columns: 1fr;
        padding: 40px 30px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="contact-page">
    <!-- Hero Section -->
    <section class="contact-hero">
        <h1>Get In Touch</h1>
        <p>Ready to transform your surveillance with AI? Contact us for demos, pricing, or any questions.</p>
    </section>

    <!-- Contact Section -->
    <div class="contact-container">
        <!-- Contact Information -->
        <div class="contact-info">
            <h2>Contact Information</h2>
            <p>Fill out the form and our team will get back to you within 24 hours.</p>

            <div class="contact-details">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Office Address</h3>
                        <p>Techno Support Core Innovations Pvt. Ltd.<br>
                        Opp Al Ameen 2nd gate, Athani Road,<br>
                        Navarspur, Vijayapur - 586108<br>
                        Karnataka, India</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Phone</h3>
                        <p><a href="tel:+918660160366">+91 8660160366</a></p>
                        <p style="font-size: 12px; margin-top: 4px;">Mon - Sat: 9:00 AM - 6:00 PM</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Email</h3>
                        <p><a href="mailto:info@tsglobe.com">info@tsglobe.com</a></p>
                        <p style="font-size: 12px; margin-top: 4px;">We'll respond within 24 hours</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Company</h3>
                        <p>Techno Support Core Innovations Pvt. Ltd.<br>
                        CIN: U72200KA2020PTC123456<br>
                        GST: 29AABCT1234A1Z5</p>
                    </div>
                </div>
            </div>

            <div class="social-links-contact">
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form-container">
            <h2>Send us a Message</h2>
            <p>We'd love to hear from you. Please fill out the form below.</p>

            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" id="contactForm">
                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name <span class="required">*</span></label>
                        <input type="text" name="name" required placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label>Email Address <span class="required">*</span></label>
                        <input type="email" name="email" required placeholder="john@example.com">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" placeholder="+91 98765 43210">
                    </div>
                    <div class="form-group">
                        <label>Company/Organization</label>
                        <input type="text" name="company" placeholder="Your Company">
                    </div>
                </div>

                <div class="form-group">
                    <label>Interested In</label>
                    <select name="interest_type">
                        <option value="general">General Inquiry</option>
                        <option value="traffic">Traffic Violation Detection</option>
                        <option value="smart-city">Smart City Solutions</option>
                        <option value="defence">Defence & Security</option>
                        <option value="healthcare">Healthcare Monitoring</option>
                        <option value="industrial">Industrial Safety</option>
                        <option value="retail">Retail Analytics</option>
                        <option value="demo">Request Demo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Subject <span class="required">*</span></label>
                    <input type="text" name="subject" required placeholder="How can we help?">
                </div>

                <div class="form-group">
                    <label>Message <span class="required">*</span></label>
                    <textarea name="message" required placeholder="Tell us about your requirements..."></textarea>
                </div>

                <button type="submit" name="submit_contact" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 16px;">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>
    </div>

    <!-- Map Section -->
    <div class="map-container">
        <h2>Visit Our Office</h2>
        <div class="map-wrapper">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3039.386577808723!2d75.66454537924807!3d16.827966200678556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc6ff4f90d9de53%3A0xaf9554dc34a8969c!2sTECHNO%20SUPPORT%20CCTV%20CAMERAS!5e0!3m2!1sen!2sin!4v1777124639887!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </iframe>
        </div>
    </div>
</div>

<script>
// Form validation
document.getElementById('contactForm').addEventListener('submit', function(e) {
    const name = this.querySelector('[name="name"]').value.trim();
    const email = this.querySelector('[name="email"]').value.trim();
    const message = this.querySelector('[name="message"]').value.trim();
    
    if (!name || !email || !message) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return false;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address.');
        return false;
    }
});
</script>

<?php include '../../includes/footer.php'; ?>