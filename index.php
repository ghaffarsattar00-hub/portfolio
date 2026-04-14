<?php
// ==========================================
// 1. PHP VISITOR COUNTER LOGIC
// ==========================================
$counter_file = 'views.txt';
if(!file_exists($counter_file)) { file_put_contents($counter_file, 0); }
$total_views = (int)file_get_contents($counter_file);
if(!isset($_COOKIE['has_visited'])) {
    $total_views++;
    file_put_contents($counter_file, $total_views);
    setcookie('has_visited', 'yes', time() + (86400 * 30)); // 30 days
}

// ==========================================
// 2. CONTACT FORM HANDLING (Live Email)
// ==========================================
$form_message = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $user_msg = htmlspecialchars(trim($_POST['message']));
    
    $to = "ghaffarsattar00@gmail.com";
    $subject = "Portfolio: Naya Message from $name";
    
    $email_content = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;'>
            <div style='background: #22d3ee; padding: 20px; text-align: center; color: #080c14;'>
                <h2 style='margin: 0;'>Naya Message Aaya Hai!</h2>
            </div>
            <div style='padding: 20px; background: #f8fafc; color: #0f172a;'>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <div style='background: #ffffff; padding: 15px; border-radius: 8px; border: 1px solid #cbd5e1; margin-top: 15px;'>
                    <p style='margin: 0;'>$user_msg</p>
                </div>
            </div>
        </div>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Portfolio Contact <no-reply@yourwebsite.com>" . "\r\n"; 
    $headers .= "Reply-To: $email" . "\r\n";

    if(mail($to, $subject, $email_content, $headers)) {
        $form_message = "<div class='form-success'>Assalam o Alaikum $name! Aapka message successfully send ho gaya hai. Main jald raabta karunga.</div>";
    } else {
        $form_message = "<div class='form-error' style='color:#ef4444; background:rgba(239,68,68,0.1); padding:15px; border-radius:12px; margin-bottom:20px; border:1px solid rgba(239,68,68,0.3); font-size: 0.9rem;'>Server mein thora masla hai aur email send nahi ho saki. Baraye meharbani WhatsApp par direct message karein.</div>";
    }
}

// ==========================================
// 3. DYNAMIC PROJECTS
// ==========================================
$projects = [
    [
        'title' => 'Sanjalika Water Park',
        'tag' => 'Website Development',
        'desc' => "Designed and developed the complete front-end website for Sanjalika Water Park — fully responsive, modern UI showcasing the park's attractions, facilities, and visitor experience.",
        'image' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?q=80&w=2070&auto=format&fit=crop',
        'link' => 'https://ghaffarsattar00-hub.github.io/sanjalika-waterpark/'
    ]
];
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth" data-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title>Abdul Ghaffar — Front-End Developer</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <style>
    /* ── RESET & BASE ── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    /* CSS VARIABLES */
    :root[data-theme="dark"] {
      --bg:       #080c14;
      --surface:  #0e1523;
      --card:     #111827;
      --border:   rgba(255,255,255,0.07);
      --cyan:     #22d3ee;
      --cyan-dim: rgba(34,211,238,0.15);
      --text:     #f8fafc; 
      --muted:    #94a3b8; 
      --white:    #ffffff;
      --invert:   0;
    }

    :root[data-theme="light"] {
      --bg:       #f8fafc;
      --surface:  #f1f5f9;
      --card:     #ffffff;
      --border:   rgba(0,0,0,0.1);
      --cyan:     #0284c7; 
      --cyan-dim: rgba(2,132,199,0.15);
      --text:     #0f172a; 
      --muted:    #64748b; 
      --white:    #020617; 
      --invert:   1;
    }

    body {
      background: var(--bg); color: var(--text);
      font-family: 'DM Sans', sans-serif; font-size: 16px; line-height: 1.7;
      overflow-x: hidden; width: 100%; position: relative;
      transition: background 0.3s, color 0.3s;
    }

    body::before {
      content: ''; position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none; z-index: 0; opacity: calc(0.15 - (var(--invert) * 0.1)); 
    }

    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: var(--bg); }
    ::-webkit-scrollbar-thumb { background: var(--cyan); border-radius: 99px; }

    /* ── PRELOADER ── */
    #preloader {
      position: fixed; inset: 0; background: var(--bg); z-index: 999999;
      display: flex; justify-content: center; align-items: center; transition: opacity 0.5s;
    }
    .spinner {
      width: 50px; height: 50px; border: 4px solid var(--border);
      border-top-color: var(--cyan); border-radius: 50%;
      animation: spin-load 1s linear infinite;
    }
    @keyframes spin-load { to { transform: rotate(360deg); } }

    /* ── UTILITY ── */
    .container { max-width: 1100px; margin: 0 auto; padding: 0 24px; }
    h1,h2,h3,h4 { font-family: 'Syne', sans-serif; }
    .section { padding: 100px 0; position: relative; z-index: 1; overflow: hidden; }
    .section-label { display: inline-block; font-size: 0.72rem; letter-spacing: 0.18em; text-transform: uppercase; color: var(--cyan); margin-bottom: 12px; font-weight: 600; }
    .section-title { font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; color: var(--white); margin-bottom: 60px; }
    .blob { position: absolute; border-radius: 50%; filter: blur(120px); pointer-events: none; }

    /* ── NAV ── */
    nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 16px 24px; background: rgba(var(--bg), 0.85); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; transition: 0.3s; }
    nav.scrolled { box-shadow: 0 4px 40px rgba(0,0,0,0.4); }
    .nav-logo { height: 48px; width: 48px; object-fit: cover; border-radius: 50%; border: 2px solid var(--cyan); transition: transform 0.3s; }
    .nav-logo:hover { transform: scale(1.05); }
    .nav-links { display: flex; align-items: center; gap: 36px; list-style: none; }
    .nav-links a { color: var(--text); font-size: 0.95rem; font-weight: 500; text-decoration: none; font-family: 'Syne', sans-serif; transition: color 0.2s; }
    .nav-links a:hover { color: var(--cyan); }
    
    #themeToggle { background: var(--cyan-dim); color: var(--cyan); border: none; padding: 8px; border-radius: 50%; cursor: pointer; width: 36px; height: 36px; transition: 0.3s; display: flex; justify-content: center; align-items: center; }
    #themeToggle:hover { transform: rotate(15deg) scale(1.1); }

    .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 4px; background: transparent; border: none; }
    .hamburger span { display: block; width: 24px; height: 2px; background: var(--text); border-radius: 2px; transition: all 0.3s; }
    .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    .hamburger.open span:nth-child(2) { opacity: 0; }
    .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    .mobile-menu { display: none; position: fixed; top: 80px; left: 0; right: 0; background: rgba(var(--bg), 0.97); backdrop-filter: blur(20px); z-index: 99; border-bottom: 1px solid var(--border); padding: 24px; flex-direction: column; gap: 20px; }
    .mobile-menu.open { display: flex; }
    .mobile-menu a { color: var(--text); text-decoration: none; font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 600; padding: 10px 0; border-bottom: 1px solid var(--border); }

    /* ── HERO ── */
    #home { min-height: 100vh; display: flex; align-items: center; padding-top: 80px; position: relative; }
    .hero-blob-1 { width: 600px; height: 600px; background: rgba(34,211,238,0.08); top: -100px; right: -200px; }
    .hero-blob-2 { width: 400px; height: 400px; background: rgba(99,102,241,0.07); bottom: 50px; left: -150px; }
    .hero-grid { display: grid; grid-template-columns: 1fr 1fr; align-items: center; gap: 60px; }
    
    .hero-eyebrow { font-size: 0.9rem; letter-spacing: 0.25em; text-transform: uppercase; color: var(--cyan); font-family: 'Syne', sans-serif; font-weight: 700; margin-bottom: 16px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; line-height: 1.5; }
    .hero-eyebrow::before { content: ''; display: block; width: 32px; height: 2px; background: var(--cyan); }
    
    .hero-name { font-size: clamp(2.8rem, 7vw, 5rem); font-weight: 800; color: var(--white); line-height: 1.05; letter-spacing: -0.02em; }
    .hero-name .highlight { background: linear-gradient(135deg, var(--cyan) 0%, #818cf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .hero-role { margin-top: 18px; font-size: 1.15rem; color: var(--muted); font-weight: 300; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .role-badge { background: var(--cyan-dim); color: var(--cyan); border: 1px solid var(--border); padding: 4px 14px; border-radius: 99px; font-size: 0.85rem; font-family: 'Syne', sans-serif; font-weight: 600; }
    
    .hero-desc { margin-top: 22px; font-size: 1.1rem; color: var(--muted); line-height: 1.8; max-width: 500px; }
    
    /* MODIFIED: position relative and z-index 10 added */
    .hero-cta { margin-top: 36px; display: flex; gap: 16px; flex-wrap: wrap; position: relative; z-index: 10; }
    
    .btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 14px 32px; background: var(--cyan); color: #080c14; font-family: 'Syne', sans-serif; font-weight: 700; border-radius: 99px; text-decoration: none; transition: 0.3s; cursor: pointer; }
    .btn-primary:hover { background: #67e8f9; transform: translateY(-2px); }
    .btn-ghost { display: inline-flex; align-items: center; gap: 8px; padding: 14px 32px; background: transparent; color: var(--text); border: 1px solid var(--border); border-radius: 99px; text-decoration: none; transition: 0.3s; font-family: 'Syne', sans-serif; font-weight: 600; cursor: pointer; }
    .btn-ghost:hover { border-color: var(--cyan); color: var(--cyan); background: var(--cyan-dim); }

    .hero-image-wrap { display: flex; justify-content: center; position: relative; }
    .hero-image-ring { position: relative; width: 320px; height: 320px; }
    .hero-image-ring::before { content: ''; position: absolute; inset: -4px; border-radius: 50%; background: conic-gradient(var(--cyan), #818cf8, #22d3ee, transparent); animation: spin 6s linear infinite; }
    .hero-image-inner { position: absolute; inset: 4px; border-radius: 50%; overflow: hidden; background: var(--surface); }
    .hero-image-inner img { width: 100%; height: 100%; object-fit: cover; }
    .hero-stat { position: absolute; background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 10px 18px; font-family: 'Syne', sans-serif; }
    .hero-stat-num { font-size: 1.4rem; font-weight: 800; color: var(--cyan); }
    .hero-stat-label { font-size: 0.75rem; color: var(--muted); }
    .stat-1 { top: 0; left: -20px; animation: float 4s ease-in-out infinite; }
    .stat-2 { bottom: 20px; right: -20px; animation: float 4s ease-in-out infinite 1.5s; }

    /* ── ABOUT / EDUCATION ── */
    #about { background: var(--surface); }
    .timeline { position: relative; }
    .timeline::before { content: ''; position: absolute; left: 22px; top: 0; bottom: 0; width: 2px; background: linear-gradient(to bottom, var(--cyan), transparent); }
    .tl-item { display: flex; gap: 24px; margin-bottom: 48px; position: relative; }
    .tl-dot { width: 46px; height: 46px; min-width: 46px; border-radius: 50%; background: var(--card); border: 2px solid var(--cyan); display: flex; align-items: center; justify-content: center; position: relative; z-index: 1; }
    .tl-dot svg { width: 18px; height: 18px; color: var(--cyan); }
    .tl-dot.muted { border-color: var(--muted); }
    .tl-dot.muted svg { color: var(--muted); }
    .tl-body { flex: 1; }
    .tl-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px 28px; transition: 0.3s; }
    .tl-card:hover { border-color: rgba(34,211,238,0.4); transform: translateX(4px); }
    .tl-title { font-size: 1.2rem; font-weight: 800; color: var(--white); margin-bottom: 4px; }
    .tl-sub { font-size: 0.88rem; color: var(--cyan); font-weight: 600; margin-bottom: 8px; }
    .tl-desc { font-size: 0.95rem; color: var(--muted); } 

    /* ── SKILLS ── */
    .skills-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 16px; }
    .skill-card { background: var(--card); border: 1px solid var(--border); border-radius: 20px; padding: 28px 20px; display: flex; flex-direction: column; align-items: center; gap: 14px; transition: 0.3s; }
    .skill-card:hover { transform: translateY(-8px); border-color: var(--cyan); }
    .skill-card.featured { border-color: rgba(34,211,238,0.35); }
    .skill-icon { font-size: 3rem; color: var(--muted); }
    .skill-card:hover .skill-icon { color: var(--cyan); }
    .skill-name { font-family: 'Syne', sans-serif; font-weight: 700; color: var(--white); }

    /* ── PROJECTS ── */
    #projects { background: var(--surface); }
    .project-card { background: var(--card); border: 1px solid var(--border); border-radius: 24px; overflow: hidden; display: grid; grid-template-columns: 1fr 1fr; transition: 0.3s; max-width: 900px; margin: 0 auto 40px auto; }
    .project-card:hover { border-color: var(--cyan); }
    .project-visual { min-height: 280px; position: relative; }
    .project-visual img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
    .project-body { padding: 40px 36px; display: flex; flex-direction: column; justify-content: center; gap: 16px; background: rgba(var(--card), 0.95); }
    .project-tag { display: inline-block; background: var(--cyan-dim); color: var(--cyan); border: 1px solid var(--border); padding: 4px 14px; border-radius: 99px; font-size: 0.8rem; font-weight: 700; width: fit-content; }
    .project-title { font-size: 1.7rem; font-weight: 800; color: var(--white); }
    .project-desc { font-size: 0.95rem; color: var(--muted); line-height: 1.7; }

    /* ── CONTACT ── */
    .contact-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; text-align: left; margin-top: 40px; }
    .contact-grid { display: flex; flex-direction: column; gap: 20px; }
    .contact-card { background: var(--card); border: 1px solid var(--border); padding: 24px; border-radius: 20px; display: flex; align-items: center; gap: 16px; text-decoration: none; transition: 0.3s; }
    .contact-card:hover { transform: translateX(10px); }
    .contact-icon { width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; }
    .contact-card.whatsapp { border-color: rgba(37,211,102,0.3); }
    .contact-card.whatsapp:hover { border-color: #25D366; }
    .contact-card.whatsapp .contact-icon { background: rgba(37,211,102,0.15); color: #25D366; }
    .contact-card.instagram { border-color: rgba(225,48,108,0.3); }
    .contact-card.instagram:hover { border-color: #e1306c; }
    .contact-card.instagram .contact-icon { background: rgba(225,48,108,0.15); color: #e1306c; }
    .contact-name { font-weight: 800; font-size: 1.15rem; color: var(--white); font-family: 'Syne', sans-serif;}
    .contact-desc { font-size: 0.9rem; color: var(--muted); }

    .php-form { background: var(--card); padding: 30px; border-radius: 24px; border: 1px solid var(--border); }
    .form-group { margin-bottom: 20px; }
    .form-control { width: 100%; padding: 14px 20px; background: var(--surface); border: 1px solid var(--border); border-radius: 12px; color: var(--text); font-family: inherit; transition: 0.3s; }
    .form-control:focus { outline: none; border-color: var(--cyan); }
    textarea.form-control { resize: vertical; min-height: 120px; }
    .btn-submit { width: 100%; border: none; cursor: pointer; justify-content: center; margin-top: 10px; }
    .form-success { background: rgba(37, 211, 102, 0.1); color: #25D366; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid rgba(37, 211, 102, 0.3); font-size: 0.9rem;}

    /* ── WHATSAPP WIDGET ── */
    .wa-widget { position: fixed; bottom: 28px; right: 28px; z-index: 9999; display: flex; flex-direction: column; align-items: flex-end; gap: 12px; }
    .wa-bubble-wrap { background: rgba(var(--bg), 0.98); backdrop-filter: blur(20px); border: 1px solid rgba(37,211,102,0.3); border-radius: 20px; padding: 20px; width: 300px; max-width: calc(100vw - 32px); box-shadow: 0 20px 60px rgba(0,0,0,0.5); transform-origin: bottom right; transform: scale(0.8) translateY(20px); opacity: 0; pointer-events: none; transition: 0.35s; max-height: 75vh; overflow-y: auto; }
    .wa-bubble-wrap.open { transform: scale(1) translateY(0); opacity: 1; pointer-events: all; }
    .wa-header { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding-bottom: 14px; border-bottom: 1px solid var(--border); }
    .wa-avatar { width: 44px; height: 44px; border-radius: 50%; overflow: hidden; border: 2px solid #25D366; }
    .wa-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .wa-info { flex: 1; }
    .wa-name { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.9rem; color: var(--white); }
    .wa-status { display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: #25D366; }
    .wa-dot { width: 7px; height: 7px; border-radius: 50%; background: #25D366; animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:0.4;} }
    .wa-greeting { background: rgba(37,211,102,0.08); border: 1px solid rgba(37,211,102,0.15); border-radius: 12px; padding: 12px 14px; font-size: 0.85rem; color: var(--muted); margin-bottom: 14px; }
    .wa-greeting strong { color: var(--white); display: block; margin-bottom: 4px; }
    .wa-prompts-label { font-size: 0.75rem; color: var(--muted); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 10px; }
    .wa-prompt-btn { display: block; width: 100%; text-align: left; background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 10px 14px; color: var(--text); font-size: 0.85rem; cursor: pointer; text-decoration: none; transition: 0.2s; margin-bottom: 8px; }
    .wa-prompt-btn:hover { border-color: rgba(37,211,102,0.5); background: rgba(37,211,102,0.08); color: var(--white); }
    .wa-prompt-btn::before { content: '→ '; color: #25D366; }
    .wa-fab { width: 60px; height: 60px; border-radius: 50%; background: #25D366; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 30px rgba(37,211,102,0.5); transition: 0.3s; position: relative; }
    .wa-fab:hover { transform: scale(1.1); }
    .wa-fab svg { width: 32px; height: 32px; fill: white; }
    .wa-fab-close { display: none; }
    .wa-fab.open .wa-fab-open { display: none; }
    .wa-fab.open .wa-fab-close { display: block; }
    .wa-notif { position: absolute; top: -2px; right: -2px; width: 14px; height: 14px; border-radius: 50%; background: #ef4444; border: 2px solid var(--bg); animation: bounce 2s infinite; }
    @keyframes bounce { 0%,100%{transform:scale(1);} 50%{transform:scale(1.3);} }

    /* AOS Animations */
    [data-aos] { transition: opacity 0.6s, transform 0.6s; will-change: opacity, transform; }
    [data-aos="fade-up"] { opacity: 0; transform: translateY(40px); }
    [data-aos="fade-up"].aos-animate { opacity: 1; transform: none; }
    [data-aos="zoom-in"] { opacity: 0; transform: scale(0.9); }
    [data-aos="zoom-in"].aos-animate { opacity: 1; transform: scale(1); }
    .stagger-1 { transition-delay: 0.1s; } .stagger-2 { transition-delay: 0.2s; }
    .stagger-3 { transition-delay: 0.3s; } .stagger-4 { transition-delay: 0.4s; }

    /* MODIFIED: RESPONSIVE */
    @media (max-width: 768px) {
      .section { padding: 60px 0; }
      [data-aos] { transition: opacity 0.4s, transform 0.4s !important; }
      .wa-bubble-wrap { transform: scale(0.75) translateY(30px); }
      .wa-bubble-wrap.open { transform: scale(1) translateY(0) !important; }
      .wa-fab { bottom: 20px; right: 20px; }
      .container { padding: 0 16px; }
      .hero-grid, .project-card, .contact-wrapper { grid-template-columns: 1fr; }
      .hero-image-wrap { order: -1; margin-top: 20px; }
      .nav-links { display: none; }
      .hamburger { display: flex; }
      .hero-name { font-size: 2.5rem; text-align: center; }
      .hero-eyebrow { justify-content: center; text-align: center; font-size: 0.75rem; letter-spacing: 0.15em; }
      .hero-eyebrow::before { display: none; }
      .hero-role, .hero-cta { justify-content: center; }
      .hero-desc { text-align: center; margin: 20px auto; }
      .hero-image-ring { width: 260px; height: 260px; }
    }
  </style>
</head>
<body>

<div id="preloader"><div class="spinner"></div></div>

<nav id="mainNav">
  <a href="#home">
    <img src="https://ui-avatars.com/api/?name=Abdul+Ghaffar&size=100&background=0e1523&color=22d3ee" alt="Abdul Ghaffar" class="nav-logo" />
  </a>
  <ul class="nav-links">
    <li><a href="#home">Home</a></li>
    <li><a href="#about">Education</a></li>
    <li><a href="#skills">Skills</a></li>
    <li><a href="#projects">Projects</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
  <div style="display: flex; align-items: center; gap: 16px;">
    <button id="themeToggle" aria-label="Toggle Theme"><i class="fa-solid fa-moon"></i></button>
    <button class="hamburger" id="hamburger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="#home">Home</a>
  <a href="#about">Education</a>
  <a href="#skills">Skills</a>
  <a href="#projects">Projects</a>
  <a href="#contact">Contact</a>
</div>

<section id="home" class="section">
  <div class="blob hero-blob-1"></div>
  <div class="blob hero-blob-2"></div>
  <div class="container">
    <div class="hero-grid">
      <div>
        <p class="hero-eyebrow" data-aos="fade-up">Front-End Developer & Prompt Engineer</p>
        <h1 class="hero-name" data-aos="fade-up">Hi, I'm<br/><span class="highlight">Abdul Ghaffar</span></h1>
        <div class="hero-role" data-aos="fade-up">
          <span class="role-badge">HTML · CSS · Tailwind</span>
          <span class="role-badge">AI Prompting</span>
        </div>
        <p class="hero-desc" data-aos="fade-up">I craft modern, pixel-perfect websites and single-page applications. Combining clean front-end code with advanced AI prompting to deliver seamless digital experiences.</p>
        <div class="hero-cta" data-aos="fade-up">
          <a href="#projects" class="btn-primary">See My Work</a>
          <a href="Abdul_Ghaffar_CV.pdf" download class="btn-ghost"><i class="fa-solid fa-download"></i> Download CV</a>
        </div>
      </div>
      <div class="hero-image-wrap" data-aos="zoom-in">
        <div class="hero-image-ring">
          <div class="hero-image-inner">
            <img src="https://scontent.cdninstagram.com/v/t51.82787-19/630919070_18067710878635378_6686318481637965203_n.jpg?stp=dst-jpg_s150x150_tt6&_nc_cat=107&ccb=7-5&_nc_sid=f7ccc5&efg=eyJ2ZW5jb2RlX3RhZyI6InByb2ZpbGVfcGlj.ww.w.1080.C3in0%3D&_nc_ohc=c3nTA81fjU8Q7kNvwENQqzf&_nc_oc=Adr4jmy1jkhRItCUSk109O4WHPVRf5o2a_qaWpiy5mxMiWvoCdipu9Xd-92umLTI3kU&_nc_zt=24&_nc_ht=scontent.cdninstagram.com&_nc_gid=uaxBSeT4WFYrKw0LGHw_uw&_nc_ss=7a2a8&oh=00_Af3_3iMBCFtVDfPofA02FZvZ5OKA_9_Ph2D9Anoev5SgQw&oe=69E29D81" onerror="this.src='https://ui-avatars.com/api/?name=AG&size=300'" alt="Abdul Ghaffar" />
          </div>
          <div class="hero-stat stat-1"><div class="hero-stat-num">1+</div><div class="hero-stat-label">Years Exp.</div></div>
          <div class="hero-stat stat-2"><div class="hero-stat-num"><?php echo $total_views; ?></div><div class="hero-stat-label">Profile Views</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="about" class="section">
  <div class="container">
    <span class="section-label" data-aos="fade-up">Background</span>
    <h2 class="section-title" data-aos="fade-up">My Education</h2>
    <div class="timeline">
      <div class="tl-item" data-aos="fade-up">
        <div class="tl-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 6 3 6 3s6-1 6-3v-5"/></svg></div>
        <div class="tl-body">
          <div class="tl-card">
            <div class="tl-title">Aptech Computer Education</div>
            <div class="tl-sub">3 Years Diploma Program</div>
            <div class="tl-desc">Professional training in software engineering and modern web development technologies.</div>
          </div>
        </div>
      </div>
      <div class="tl-item" data-aos="fade-up">
        <div class="tl-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></div>
        <div class="tl-body">
          <div class="tl-card">
            <div class="tl-title">Domino English Learning Centre</div>
            <div class="tl-sub">Advanced English Language</div>
            <div class="tl-desc">Developed strong communication, presentation, and professional language skills.</div>
          </div>
        </div>
      </div>
      <div class="tl-item" data-aos="fade-up">
        <div class="tl-dot muted"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg></div>
        <div class="tl-body">
          <div class="tl-card">
            <div class="tl-title">Intermediate</div>
            <div class="tl-sub" style="color:var(--muted)">College Level Education</div>
          </div>
        </div>
      </div>
      <div class="tl-item" data-aos="fade-up">
        <div class="tl-dot muted"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></div>
        <div class="tl-body">
          <div class="tl-card">
            <div class="tl-title">Matric</div>
            <div class="tl-sub" style="color:var(--muted)">Science Group</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="skills" class="section">
  <div class="container">
    <span class="section-label" data-aos="fade-up">What I Know</span>
    <h2 class="section-title" data-aos="fade-up">My Skills</h2>
    <div class="skills-grid">
      <div class="skill-card stagger-1" data-aos="zoom-in"><i class="fa-brands fa-html5 skill-icon"></i><div class="skill-name">HTML5</div></div>
      <div class="skill-card stagger-2" data-aos="zoom-in"><i class="fa-brands fa-css3-alt skill-icon"></i><div class="skill-name">CSS3</div></div>
      <div class="skill-card featured stagger-3" data-aos="zoom-in"><i class="fa-solid fa-wind skill-icon"></i><div class="skill-name">Tailwind CSS</div></div>
      <div class="skill-card stagger-4" data-aos="zoom-in"><i class="fa-brands fa-git-alt skill-icon"></i><div class="skill-name">Git</div></div>
      <div class="skill-card stagger-1" data-aos="zoom-in"><i class="fa-brands fa-github skill-icon"></i><div class="skill-name">GitHub</div></div>
      <div class="skill-card featured stagger-2" data-aos="zoom-in" style="border-color:rgba(129,140,248,0.35)"><i class="fa-solid fa-brain skill-icon"></i><div class="skill-name">Prompt Engineer</div></div>
    </div>
  </div>
</section>

<section id="projects" class="section">
  <div class="container">
    <span class="section-label" data-aos="fade-up">Portfolio</span>
    <h2 class="section-title" style="text-align:center" data-aos="fade-up">Featured Project</h2>
    
    <?php foreach($projects as $proj): ?>
    <div class="project-card" data-aos="zoom-in">
      <div class="project-visual"><img src="<?php echo $proj['image']; ?>" alt="Project"/></div>
      <div class="project-body">
        <span class="project-tag"><?php echo $proj['tag']; ?></span>
        <h3 class="project-title"><?php echo $proj['title']; ?></h3>
        <p class="project-desc"><?php echo $proj['desc']; ?></p>
        <a href="<?php echo $proj['link']; ?>" target="_blank" class="btn-primary" style="width:fit-content">Visit Website</a>
      </div>
    </div>
    <?php endforeach; ?>

  </div>
</section>

<section id="contact" class="section">
  <div class="container" style="text-align:center">
    <span class="section-label" data-aos="fade-up">Let's Connect</span>
    <h2 class="section-title" data-aos="fade-up">Ready to build something great?</h2>

    <div class="contact-wrapper" data-aos="fade-up">
      <div class="contact-grid">
        <a href="https://wa.me/923182253250" target="_blank" class="contact-card whatsapp">
          <div class="contact-icon"><i class="fa-brands fa-whatsapp fa-2x"></i></div>
          <div style="text-align:left">
            <div class="contact-name">WhatsApp</div>
            <div class="contact-desc">Chat directly — quick replies</div>
          </div>
        </a>
        <a href="https://ig.me/m/a_b_d_u_l_ghaffar" target="_blank" class="contact-card instagram">
          <div class="contact-icon"><i class="fa-brands fa-instagram fa-2x"></i></div>
          <div style="text-align:left">
            <div class="contact-name">Instagram DM</div>
            <div class="contact-desc">Slide into DMs</div>
          </div>
        </a>
      </div>

      <div class="php-form">
        <h3 style="text-align:left; margin-bottom:20px; font-family:'Syne';">Send a direct message</h3>
        <?php echo $form_message; ?>
        <form method="POST" action="#contact">
          <div class="form-group"><input type="text" name="name" class="form-control" placeholder="Your Name" required></div>
          <div class="form-group"><input type="email" name="email" class="form-control" placeholder="Your Email" required></div>
          <div class="form-group"><textarea name="message" class="form-control" placeholder="How can I help you?" required></textarea></div>
          <button type="submit" name="send_message" class="btn-primary btn-submit">Send Message <i class="fa-solid fa-paper-plane"></i></button>
        </form>
      </div>
    </div>
  </div>
</section>

<footer>
  <p>© 2026 <span>Abdul Ghaffar</span>. Crafted with Tailwind CSS & PHP.</p>
</footer>

<div class="wa-widget">
  <div class="wa-bubble-wrap" id="waBubble">
    <div class="wa-header">
      <div class="wa-avatar">
        <img src="https://scontent.cdninstagram.com/v/t51.82787-19/630919070_18067710878635378_6686318481637965203_n.jpg?stp=dst-jpg_s150x150_tt6&_nc_cat=107&ccb=7-5&_nc_sid=f7ccc5&efg=eyJ2ZW5jb2RlX3RhZyI6InByb2ZpbGVfcGlj.ww.w.1080.C3in0%3D&_nc_ohc=c3nTA81fjU8Q7kNvwENQqzf&_nc_oc=Adr4jmy1jkhRItCUSk109O4WHPVRf5o2a_qaWpiy5mxMiWvoCdipu9Xd-92umLTI3kU&_nc_zt=24&_nc_ht=scontent.cdninstagram.com&_nc_gid=uaxBSeT4WFYrKw0LGHw_uw&_nc_ss=7a2a8&oh=00_Af3_3iMBCFtVDfPofA02FZvZ5OKA_9_Ph2D9Anoev5SgQw&oe=69E29D81" onerror="this.src='https://ui-avatars.com/api/?name=AG&size=80&background=25D366&color=fff'" alt="Abdul" />
      </div>
      <div class="wa-info">
        <div class="wa-name">Abdul Ghaffar</div>
        <div class="wa-status"><span class="wa-dot"></span> Usually replies fast</div>
      </div>
    </div>
    <div class="wa-greeting">
      <strong>👋 Assalam o Alaikum!</strong> Koi bhi sawaal poochh saktay hain — I'm here to help.
    </div>
    <div class="wa-prompts-label">Quick Questions</div>
    <a class="wa-prompt-btn" href="https://wa.me/923182253250?text=Aap%20kitna%20charge%20kartay%20hain%20ek%20website%20ke%20liye%3F" target="_blank">Aap kitna charge kartay hain?</a>
    <a class="wa-prompt-btn" href="https://wa.me/923182253250?text=Kya%20aap%20ek%20din%20mein%20website%20bana%20kar%20de%20saktay%20hain%3F" target="_blank">Ek din mein website ban sakti hai?</a>
    <a class="wa-prompt-btn" href="https://wa.me/923182253250?text=Mujhe%20ek%20portfolio%20website%20chahiye%2C%20kya%20aap%20bana%20saktay%20hain%3F" target="_blank">Mujhe portfolio website chahiye</a>
    <a class="wa-prompt-btn" href="https://wa.me/923182253250?text=Kya%20aap%20business%20landing%20page%20bana%20saktay%20hain%3F" target="_blank">Business landing page chahiye</a>
    <a class="wa-prompt-btn" href="https://wa.me/923182253250?text=Aapki%20services%20ke%20baray%20mein%20baat%20karni%20thi" target="_blank">Services ke baray mein baat karni hai</a>
  </div>

  <button class="wa-fab" id="waFab" aria-label="Chat on WhatsApp">
    <span class="wa-notif" id="waNotif"></span>
    <svg class="wa-fab-open" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
      <path d="M28.15 3.85A15.88 15.88 0 0016.01 0C7.27 0 .14 7.13.14 15.87a15.82 15.82 0 002.13 7.94L0 32l8.39-2.2a15.86 15.86 0 007.59 1.93h.01c8.74 0 15.86-7.13 15.87-15.87a15.8 15.8 0 00-3.71-11.01zM16.01 29.03a13.17 13.17 0 01-6.71-1.83l-.48-.29-4.99 1.31 1.33-4.86-.31-.5a13.12 13.12 0 01-2.01-7c0-7.26 5.91-13.17 13.18-13.17a13.1 13.1 0 019.31 3.87 13.09 13.09 0 013.86 9.32c-.01 7.26-5.92 13.15-13.18 13.15zm7.23-9.86c-.39-.2-2.34-1.16-2.71-1.29-.36-.13-.63-.2-.89.2-.27.39-1.03 1.29-1.26 1.55-.23.27-.46.3-.86.1-.4-.2-1.67-.62-3.19-1.97-1.18-1.05-1.97-2.35-2.2-2.75-.23-.39-.02-.61.17-.81.18-.18.4-.46.6-.69.2-.23.26-.39.4-.65.13-.26.07-.5-.03-.69-.1-.2-.9-2.15-1.23-2.94-.32-.77-.65-.67-.89-.68h-.76c-.26 0-.69.1-1.05.49-.36.4-1.39 1.36-1.39 3.31s1.42 3.84 1.62 4.11c.2.26 2.8 4.27 6.78 5.99.95.41 1.69.65 2.27.84.95.3 1.82.26 2.5.16.76-.11 2.34-.96 2.67-1.88.33-.93.33-1.72.23-1.89-.1-.16-.36-.26-.76-.46z"/>
    </svg>
    <svg class="wa-fab-close" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg" width="26" height="26">
      <path d="M18 6L6 18M6 6l12 12" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
    </svg>
  </button>
</div>

<script>
  // ═══════════════════════════════════════════════════════════════
  // SIMPLE & RELIABLE INITIALIZATION
  // ═══════════════════════════════════════════════════════════════

  // ── PRELOADER ──
  const preloader = document.getElementById('preloader');
  if (preloader) {
    setTimeout(() => {
      preloader.style.opacity = '0';
      setTimeout(() => { preloader.style.display = 'none'; }, 500);
    }, 1000);
  }

  // ── NAV SCROLL EFFECT ──
  const nav = document.getElementById('mainNav');
  if (nav) {
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 50);
    });
  }

  // ── HAMBURGER MENU ──
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');

  if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', (e) => {
      e.stopPropagation();
      hamburger.classList.toggle('open');
      mobileMenu.classList.toggle('open');
    });

    // Close menu when clicking links
    const menuLinks = mobileMenu.querySelectorAll('a');
    menuLinks.forEach(link => {
      link.addEventListener('click', () => {
        hamburger.classList.remove('open');
        mobileMenu.classList.remove('open');
      });
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (mobileMenu.classList.contains('open') &&
          !hamburger.contains(e.target) &&
          !mobileMenu.contains(e.target)) {
        hamburger.classList.remove('open');
        mobileMenu.classList.remove('open');
      }
    });
  }

  // ── THEME TOGGLE ──
  const themeBtn = document.getElementById('themeToggle');
  if (themeBtn) {
    const icon = themeBtn.querySelector('i');
    const savedTheme = localStorage.getItem('theme') || 'dark';

    document.documentElement.setAttribute('data-theme', savedTheme);
    if (savedTheme === 'light' && icon) {
      icon.classList.replace('fa-moon', 'fa-sun');
    }

    themeBtn.addEventListener('click', () => {
      let currentTheme = document.documentElement.getAttribute('data-theme');
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

      document.documentElement.setAttribute('data-theme', newTheme);
      localStorage.setItem('theme', newTheme);

      if (icon) {
        if (newTheme === 'light') {
          icon.classList.replace('fa-moon', 'fa-sun');
        } else {
          icon.classList.replace('fa-sun', 'fa-moon');
        }
      }
    });
  }

  // ── WHATSAPP WIDGET ──
  const waFab = document.getElementById('waFab');
  const waBubble = document.getElementById('waBubble');
  const waNotif = document.getElementById('waNotif');

  if (waFab && waBubble) {
    // Show notification
    setTimeout(() => {
      if (waNotif) waNotif.style.display = 'block';
    }, 3000);

    // Toggle bubble
    waFab.addEventListener('click', (e) => {
      e.stopPropagation();
      waBubble.classList.toggle('open');
      waFab.classList.toggle('open');
      if (waNotif && waBubble.classList.contains('open')) {
        waNotif.style.display = 'none';
      }
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      const widget = document.querySelector('.wa-widget');
      if (widget && !widget.contains(e.target)) {
        waBubble.classList.remove('open');
        waFab.classList.remove('open');
      }
    });

    // Touch support
    document.addEventListener('touchstart', (e) => {
      const widget = document.querySelector('.wa-widget');
      if (widget && !widget.contains(e.target)) {
        waBubble.classList.remove('open');
        waFab.classList.remove('open');
      }
    });
  }

  // ── ANIMATIONS ──
  function initAnimations() {
    const elements = document.querySelectorAll('[data-aos]');
    const isMobile = window.innerWidth <= 768;
    const threshold = isMobile ? 0.05 : 0.12;
    const rootMargin = isMobile ? '0px 0px -10px 0px' : '0px 0px -40px 0px';

    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('aos-animate');
          }
        });
      }, { threshold: threshold, rootMargin: rootMargin });

      elements.forEach(el => observer.observe(el));
    }
  }

  // Initialize animations
  initAnimations();

  // Re-init on resize
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      document.querySelectorAll('.aos-animate').forEach(el => {
        el.classList.remove('aos-animate');
      });
      initAnimations();
    }, 250);
  });

  // ── MODIFIED: BULLETPROOF SMOOTH SCROLLING ──
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      // Get the target element (e.g., #projects)
      const targetId = this.getAttribute('href');
      
      // Ignore if it's just a "#" with no name
      if (targetId === '#') return;
      
      const targetElement = document.querySelector(targetId);
      
      if (targetElement) {
        e.preventDefault(); // Stop the default buggy mobile behavior
        
        // Scroll exactly to the section
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  console.log('✅ Portfolio Ready!');
</script>
</body>
</html>