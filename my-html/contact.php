<?php
// 1. SETUP
// require 'includes/db_connect.php'; // COMMENTED OUT: So you can view UI without DB
require 'includes/header.php';

// 2. FORM HANDLING (Simulation Only)
$msg = "";
$msgClass = "";
$subjectVal = "";

// Check URL for book parameter (Simulation)
if (isset($_GET['book'])) {
    $subjectVal = htmlspecialchars($_GET['book']);
}

if (isset($_POST['send_message'])) {
    $name = htmlspecialchars($_POST['name']);
    // Since we have no DB, we just show the success message directly
    $msg = "Message sent! We'll get back to you soon, $name.";
    $msgClass = "active";
}
?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<style>
    /* =========================================
       1. VARIABLES & RESET
       ========================================= */
    :root {
        --primary: #0a192f;
        --accent-gold: #FDB913;
        --accent-green: #64ffda;
        --accent-red: #C8102E;
        --white: #ffffff;
        --off-white: #f9f9f9;
        --text-gray: #8892b0;
        --font-serif: 'Playfair Display', serif;
        --font-sans: 'Poppins', sans-serif;
    }

    body {
        font-family: var(--font-sans);
        background-color: var(--white);
        overflow-x: hidden;
        margin: 0; padding: 0;
    }

    /* NUCLEAR LOGO FIX */
    .nav-logo img, header img, nav img {
        max-height: 60px !important;
        width: auto !important;
        max-width: 180px !important;
        object-fit: contain !important;
    }

    main { margin-top: 80px; } 

    /* =========================================
       2. SPLIT ARTISTIC LAYOUT
       ========================================= */
    .split-container {
        display: grid;
        grid-template-columns: 1fr 1.3fr;
        min-height: calc(100vh - 80px);
        position: relative;
    }

    /* --- LEFT PANEL: THE CANVAS --- */
    .info-panel {
        background-color: var(--primary);
        /* Subtle Canvas Texture Overlay */
        background-image: radial-gradient( rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        background-size: 20px 20px;
        color: var(--white);
        padding: 80px 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    /* ORGANIC PAINT BLOBS (CSS Shapes) */
    .blob {
        position: absolute;
        background: rgba(253, 185, 19, 0.1);
        border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        animation: morph 8s ease-in-out infinite;
        z-index: 1;
    }
    .blob-1 {
        top: -10%; right: -10%; width: 300px; height: 300px;
        background: linear-gradient(45deg, rgba(253, 185, 19, 0.15), rgba(200, 16, 46, 0.1));
    }
    .blob-2 {
        bottom: -5%; left: -10%; width: 400px; height: 400px;
        border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
        background: rgba(100, 255, 218, 0.05);
        animation-direction: reverse;
    }

    @keyframes morph {
        0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        50% { border-radius: 50% 60% 30% 60% / 60% 30% 70% 40%; }
        100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
    }

    .panel-content { position: relative; z-index: 2; }

    .big-title {
        font-family: var(--font-serif);
        font-size: 3.5rem;
        line-height: 1.1;
        margin-bottom: 25px;
        position: relative;
        display: inline-block;
    }
    
    /* Brush Stroke Underline */
    .big-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 6px;
        background: var(--accent-gold);
        margin-top: 15px;
        border-radius: 4px;
        border-bottom-right-radius: 1px;
        border-top-left-radius: 1px;
    }

    .panel-desc {
        color: var(--text-gray);
        font-size: 1.1rem;
        margin-bottom: 50px;
        max-width: 450px;
        line-height: 1.8;
    }

    /* Contact Items with Icon Backgrounds */
    .contact-list { list-style: none; padding: 0; margin: 0; }
    .contact-item {
        display: flex; align-items: center; gap: 20px;
        margin-bottom: 35px;
        font-size: 1.1rem;
    }
    .icon-box {
        width: 60px; height: 60px;
        background: rgba(255,255,255,0.05);
        border-radius: 15px; /* Softer square */
        display: flex; align-items: center; justify-content: center;
        color: var(--accent-gold);
        font-size: 1.4rem;
        transition: 0.3s;
        border: 1px solid rgba(255,255,255,0.1);
        transform: rotate(-5deg); /* Artistic tilt */
    }
    .contact-item:hover .icon-box {
        background: var(--accent-gold); color: var(--primary);
        transform: rotate(0deg) scale(1.1);
    }
    .contact-link { 
        color: var(--white); text-decoration: none; transition: 0.3s; 
        font-weight: 300; letter-spacing: 0.5px;
    }
    .contact-link:hover { color: var(--accent-gold); padding-left: 5px; }

    /* --- RIGHT PANEL: THE WORKSPACE --- */
    .form-panel {
        background: var(--white);
        padding: 80px 10%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
    }
    
    /* Watermark Logo */
    .watermark {
        position: absolute; top: 20px; right: 20px;
        font-family: 'Permanent Marker', cursive;
        font-size: 5rem; color: rgba(0,0,0,0.03);
        pointer-events: none; z-index: 0;
        transform: rotate(-10deg);
    }

    .form-header { margin-bottom: 50px; position: relative; z-index: 1; }
    .form-header h2 { font-family: var(--font-serif); font-size: 2.8rem; color: var(--primary); margin-bottom: 10px; }
    .form-header p { color: #666; font-size: 1.1rem; }

    /* Sketchbook Inputs */
    .input-group {
        position: relative;
        margin-bottom: 45px;
        z-index: 1;
    }
    
    .clean-input {
        width: 100%;
        padding: 15px 0;
        border: none;
        border-bottom: 2px solid #eee;
        background: transparent;
        font-family: var(--font-sans);
        font-size: 1.1rem;
        color: var(--primary);
        transition: 0.3s;
        outline: none;
    }
    /* Input border highlight animates from center */
    .input-highlight {
        position: absolute; bottom: 0; left: 50%; width: 0; height: 2px;
        background: var(--accent-gold); transition: 0.4s ease;
    }
    .clean-input:focus ~ .input-highlight { width: 100%; left: 0; }

    .clean-label {
        position: absolute; top: 15px; left: 0;
        color: #aaa; font-size: 1rem; pointer-events: none;
        transition: 0.3s ease all;
        font-weight: 400;
    }
    
    .clean-input:focus ~ .clean-label,
    .clean-input:valid ~ .clean-label {
        top: -10px;
        font-size: 0.85rem;
        color: var(--primary);
        font-weight: 700;
    }

    .btn-submit {
        background: var(--primary);
        color: var(--white);
        padding: 18px 40px;
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
        transition: 0.4s;
        display: inline-block;
        margin-top: 10px;
        position: relative;
        overflow: hidden;
        border-radius: 5px 20px 5px 20px; 
    }
    .btn-submit:hover {
        background: var(--accent-gold);
        color: var(--primary);
        border-radius: 20px 5px 20px 5px;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    .msg-box {
        background: rgba(100, 255, 218, 0.1); 
        color: #006400; 
        border-left: 4px solid var(--accent-green);
        padding: 20px;
        margin-bottom: 30px; display: none;
    }
    .msg-box.active { display: block; animation: slideDown 0.5s ease; }

    /* --- 3. TORN PAPER MAP EDGE --- */
    .map-container {
        position: relative;
        height: 400px;
        width: 100%;
        margin-top: -2px; /* Connect seamlessly */
    }
    .paper-edge {
        position: absolute; top: -20px; left: 0; width: 100%; height: 40px;
        background: var(--white);
        clip-path: polygon(0% 50%, 5% 70%, 10% 50%, 15% 70%, 20% 50%, 25% 70%, 30% 50%, 35% 70%, 40% 50%, 45% 70%, 50% 50%, 55% 70%, 60% 50%, 65% 70%, 70% 50%, 75% 70%, 80% 50%, 85% 70%, 90% 50%, 95% 70%, 100% 50%, 100% 100%, 0% 100%);
        z-index: 10;
        transform: rotate(180deg);
    }

    .map-frame {
        width: 100%; height: 100%; border: 0;
        filter: grayscale(100%) contrast(1.1);
        transition: 0.5s;
    }
    .map-container:hover .map-frame { filter: grayscale(0%); }

    /* RESPONSIVE */
    @media (max-width: 992px) {
        .split-container { grid-template-columns: 1fr; }
        .info-panel { padding: 60px 30px; }
        .form-panel { padding: 60px 30px; }
        .big-title { font-size: 2.8rem; }
    }
    @keyframes slideDown { from { opacity:0; transform: translateY(-10px); } to { opacity:1; transform: translateY(0); } }
</style>

<main>
    
    <div class="split-container">
        
        <div class="info-panel" data-aos="fade-right">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>

            <div class="panel-content">
                <h1 class="big-title">Let's Create<br>Something.</h1>
                <p class="panel-desc">
                    Whether you are a student, an artist, or a patron of the arts, Inkingi is your creative home. Reach out to us.
                </p>

                <ul class="contact-list">
                    <li class="contact-item">
                        <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <span style="display:block; font-size:0.8rem; opacity:0.6; text-transform:uppercase;">Visit the Studio</span>
                            <a href="#" class="contact-link">Kigali, Kacyiru, 24 KG 550 St</a>
                        </div>
                    </li>
                    <li class="contact-item">
                        <div class="icon-box"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <span style="display:block; font-size:0.8rem; opacity:0.6; text-transform:uppercase;">Talk to Us</span>
                            <a href="tel:+250787177805" class="contact-link">+250 787 177 805</a>
                        </div>
                    </li>
                    <li class="contact-item">
                        <div class="icon-box"><i class="fas fa-envelope-open-text"></i></div>
                        <div>
                            <span style="display:block; font-size:0.8rem; opacity:0.6; text-transform:uppercase;">Email Inquiries</span>
                            <a href="mailto:yamwamba01@gmail.com" class="contact-link">yamwamba01@gmail.com</a>
                        </div>
                    </li>
                </ul>

                <div style="margin-top: 40px; display:flex; gap:20px;">
                    <a href="#" style="color:white; font-size:1.5rem; transition:0.3s;" onmouseover="this.style.color='#FDB913'" onmouseout="this.style.color='white'"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color:white; font-size:1.5rem; transition:0.3s;" onmouseover="this.style.color='#FDB913'" onmouseout="this.style.color='white'"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color:white; font-size:1.5rem; transition:0.3s;" onmouseover="this.style.color='#FDB913'" onmouseout="this.style.color='white'"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>

        <div class="form-panel" data-aos="fade-left">
            <div class="watermark">Art</div>
            
            <div class="form-header">
                <h2>Drop a Line</h2>
                <p>Fill out the form below. We usually reply within 24 hours.</p>
            </div>

            <div class="msg-box <?= $msgClass ?>"><?= $msg ?></div>

            <form method="POST">
                <div class="input-group">
                    <input type="text" name="name" class="clean-input" required>
                    <span class="input-highlight"></span>
                    <label class="clean-label">Your Name</label>
                </div>

                <div class="input-group">
                    <input type="email" name="email" class="clean-input" required>
                    <span class="input-highlight"></span>
                    <label class="clean-label">Email Address</label>
                </div>

                <div class="input-group">
                    <input type="text" name="subject" class="clean-input" value="<?= $subjectVal ?>" required>
                    <span class="input-highlight"></span>
                    <label class="clean-label">Subject / Program Interest</label>
                </div>

                <div class="input-group">
                    <textarea name="message" class="clean-input" rows="1" style="resize:none; height:auto; min-height:40px;" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'" required></textarea>
                    <span class="input-highlight"></span>
                    <label class="clean-label">Your Message</label>
                </div>

                <button type="submit" name="send_message" class="btn-submit">
                    Send Message
                </button>
            </form>

        </div>

    </div>

    <div class="map-container">
        <div class="paper-edge"></div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.532726322982!2d30.0881!3d-1.9351!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMsKwNTYnMDYuNCJTIDMwwrAwNScxNy4yIkU!5e0!3m2!1sen!2srw!4v1635000000000!5m2!1sen!2srw" class="map-frame" allowfullscreen="" loading="lazy"></iframe>
    </div>

</main>

<?php include 'includes/footer.php'; ?>

<script>
    AOS.init({ duration: 1000, once: true });
</script>