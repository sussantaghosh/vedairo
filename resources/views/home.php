<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VEDAIRO Enterprise 5.0.0 — Modern High-Velocity PHP Framework</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #070a13;
      --bg-surface: #0e1526;
      --card-bg: rgba(17, 24, 39, 0.7);
      --card-border: rgba(255, 255, 255, 0.08);
      --card-border-hover: rgba(99, 102, 241, 0.4);
      --text: #f1f5f9;
      --text-muted: #94a3b8;
      --primary: #6366f1;
      --primary-light: #818cf8;
      --cyan: #06b6d4;
      --emerald: #10b981;
      --amber: #f59e0b;
      --font-main: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      --font-mono: 'JetBrains Mono', monospace;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: var(--font-main);
      background-color: var(--bg);
      color: var(--text);
      line-height: 1.6;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }

    /* Ambient Background Glow */
    .ambient-glow {
      position: fixed;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 1000px;
      height: 600px;
      background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(6, 182, 212, 0.08) 40%, transparent 70%);
      pointer-events: none;
      z-index: 0;
    }

    /* Navigation Bar */
    .navbar {
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(7, 10, 19, 0.8);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--card-border);
      padding: 16px 24px;
    }
    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 20px;
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
    }
    .brand-logo {
      width: 38px;
      height: 38px;
      background: linear-gradient(135deg, #6366f1, #06b6d4);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      color: #fff;
      font-size: 1.2rem;
      box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
    }
    .brand-name {
      font-size: 1.25rem;
      font-weight: 800;
      letter-spacing: -0.5px;
      background: linear-gradient(135deg, #ffffff, #94a3b8);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .badge-version {
      font-size: 0.7rem;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 9999px;
      background: rgba(99, 102, 241, 0.15);
      color: var(--primary-light);
      border: 1px solid rgba(99, 102, 241, 0.3);
    }
    .nav-links {
      display: flex;
      align-items: center;
      gap: 24px;
      list-style: none;
    }
    .nav-links a {
      color: var(--text-muted);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      transition: color 0.2s ease;
    }
    .nav-links a:hover {
      color: #fff;
    }
    .nav-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .status-indicator {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--emerald);
      background: rgba(16, 185, 129, 0.1);
      border: 1px solid rgba(16, 185, 129, 0.2);
      padding: 4px 10px;
      border-radius: 9999px;
    }
    .status-dot {
      width: 7px;
      height: 7px;
      background-color: var(--emerald);
      border-radius: 50%;
      box-shadow: 0 0 8px var(--emerald);
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      font-size: 0.9rem;
      font-weight: 600;
      border-radius: 9px;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.25s ease;
      border: none;
      font-family: inherit;
    }
    .btn-primary {
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      color: #fff;
      box-shadow: 0 4px 18px rgba(99, 102, 241, 0.35);
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #4f46e5, #4338ca);
      box-shadow: 0 6px 24px rgba(99, 102, 241, 0.55);
      transform: translateY(-2px);
    }
    .btn-cyan {
      background: linear-gradient(135deg, #06b6d4, #0284c7);
      color: #fff;
      box-shadow: 0 4px 18px rgba(6, 182, 212, 0.35);
    }
    .btn-cyan:hover {
      background: linear-gradient(135deg, #0891b2, #0369a1);
      box-shadow: 0 6px 24px rgba(6, 182, 212, 0.55);
      transform: translateY(-2px);
    }
    .btn-outline {
      background: rgba(255, 255, 255, 0.05);
      color: var(--text);
      border: 1px solid var(--card-border);
      backdrop-filter: blur(10px);
    }
    .btn-outline:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: rgba(255, 255, 255, 0.2);
      transform: translateY(-1px);
    }

    /* Main Container */
    .container {
      position: relative;
      z-index: 1;
      max-width: 1200px;
      margin: 0 auto;
      padding: 60px 24px 100px;
    }

    /* Hero Section */
    .hero {
      text-align: center;
      padding: 40px 0 60px;
      max-width: 900px;
      margin: 0 auto;
    }
    .hero-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(99, 102, 241, 0.12);
      border: 1px solid rgba(99, 102, 241, 0.3);
      padding: 6px 16px;
      border-radius: 9999px;
      font-size: 0.85rem;
      font-weight: 600;
      color: #a5b4fc;
      margin-bottom: 24px;
    }
    .hero-title {
      font-size: 3.5rem;
      font-weight: 800;
      line-height: 1.15;
      letter-spacing: -1.5px;
      margin-bottom: 20px;
      background: linear-gradient(135deg, #ffffff 40%, #94a3b8 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .hero-highlight {
      background: linear-gradient(135deg, #818cf8, #38bdf8);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .hero-desc {
      font-size: 1.2rem;
      color: var(--text-muted);
      max-width: 740px;
      margin: 0 auto 36px;
      line-height: 1.7;
    }
    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 16px;
      margin-bottom: 48px;
    }

    /* Interactive Terminal Banner */
    .terminal-box {
      background: #090e1a;
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
      overflow: hidden;
      max-width: 820px;
      margin: 0 auto 80px;
      text-align: left;
    }
    .terminal-header {
      background: #0f172a;
      padding: 12px 18px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .terminal-dots {
      display: flex;
      gap: 8px;
    }
    .dot {
      width: 11px;
      height: 11px;
      border-radius: 50%;
    }
    .dot-red { background: #ef4444; }
    .dot-yellow { background: #f59e0b; }
    .dot-green { background: #10b981; }
    .terminal-title {
      font-size: 0.8rem;
      color: var(--text-muted);
      font-family: var(--font-mono);
    }
    .terminal-body {
      padding: 20px 24px;
      font-family: var(--font-mono);
      font-size: 0.9rem;
      line-height: 1.8;
    }
    .terminal-line {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 6px 0;
      color: #94a3b8;
    }
    .terminal-cmd {
      color: #38bdf8;
    }
    .copy-btn {
      background: rgba(255, 255, 255, 0.06);
      color: #94a3b8;
      border: 1px solid rgba(255, 255, 255, 0.1);
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 0.75rem;
      cursor: pointer;
      font-family: var(--font-main);
      transition: all 0.2s;
    }
    .copy-btn:hover {
      background: rgba(255, 255, 255, 0.15);
      color: #fff;
    }

    /* Section Headers */
    .section-head {
      text-align: center;
      max-width: 700px;
      margin: 0 auto 48px;
    }
    .section-badge {
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--cyan);
      margin-bottom: 12px;
      display: inline-block;
    }
    .section-title {
      font-size: 2.2rem;
      font-weight: 800;
      letter-spacing: -0.5px;
      margin-bottom: 12px;
      color: #fff;
    }
    .section-desc {
      color: var(--text-muted);
      font-size: 1.05rem;
    }

    /* Features Grid */
    .grid-features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 24px;
      margin-bottom: 80px;
    }
    .card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 16px;
      padding: 30px;
      backdrop-filter: blur(16px);
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
    }
    .card:hover {
      border-color: var(--card-border-hover);
      transform: translateY(-4px);
      box-shadow: 0 16px 36px rgba(0, 0, 0, 0.4);
    }
    .card-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      background: rgba(99, 102, 241, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      color: var(--primary-light);
    }
    .card-title {
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 10px;
      color: #fff;
    }
    .card-desc {
      font-size: 0.95rem;
      color: var(--text-muted);
      line-height: 1.6;
    }

    /* PDF / Support Showcase Banner */
    .showcase-banner {
      background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(6, 182, 212, 0.1));
      border: 1px solid rgba(99, 102, 241, 0.3);
      border-radius: 20px;
      padding: 44px 40px;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      gap: 32px;
      margin-bottom: 80px;
    }
    .showcase-content {
      max-width: 620px;
    }
    .showcase-title {
      font-size: 1.85rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 12px;
    }
    .showcase-desc {
      color: #cbd5e1;
      font-size: 1.05rem;
      margin-bottom: 24px;
    }
    .showcase-actions {
      display: flex;
      gap: 14px;
      flex-wrap: wrap;
    }

    /* Live Health Check Widget */
    .health-widget {
      background: #090e1a;
      border: 1px solid var(--card-border);
      border-radius: 16px;
      padding: 24px;
      margin-bottom: 80px;
    }
    .health-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
    }
    .health-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .health-output {
      background: #040711;
      border: 1px solid rgba(255, 255, 255, 0.05);
      border-radius: 8px;
      padding: 14px 18px;
      font-family: var(--font-mono);
      font-size: 0.85rem;
      color: #38bdf8;
      overflow-x: auto;
    }

    /* Help & Support Section */
    .support-section {
      background: rgba(14, 21, 38, 0.7);
      border: 1px solid var(--card-border);
      border-radius: 20px;
      padding: 48px 40px;
      margin-bottom: 80px;
    }
    .support-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 24px;
      margin-top: 32px;
    }
    .support-card {
      background: rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.06);
      border-radius: 12px;
      padding: 24px;
    }
    .support-card h4 {
      font-size: 1.1rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 8px;
    }
    .support-card p {
      font-size: 0.9rem;
      color: var(--text-muted);
      margin-bottom: 16px;
    }

    /* Footer */
    footer {
      border-top: 1px solid var(--card-border);
      padding: 40px 24px 60px;
      text-align: center;
      color: var(--text-muted);
      font-size: 0.9rem;
    }
    .footer-links {
      display: flex;
      justify-content: center;
      gap: 24px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }
    .footer-links a {
      color: var(--text-muted);
      text-decoration: none;
      transition: color 0.2s;
    }
    .footer-links a:hover {
      color: #fff;
    }

    @media (max-width: 768px) {
      .hero-title { font-size: 2.5rem; }
      .nav-links { display: none; }
      .showcase-banner { padding: 30px 20px; }
      .support-section { padding: 30px 20px; }
    }
  </style>
</head>
<body>

  <div class="ambient-glow"></div>

  <!-- Navigation Bar -->
  <nav class="navbar">
    <div class="nav-container">
      <a href="/" class="brand">
        <div class="brand-logo">V</div>
        <div>
          <span class="brand-name">VEDAIRO</span>
          <span class="badge-version">v5.0.0</span>
        </div>
      </a>

      <ul class="nav-links">
        <li><a href="#features">Features</a></li>
        <li><a href="/docs">Developer Manual</a></li>
        <li><a href="/pdf" target="_blank">PDF User Guide</a></li>
        <li><a href="#support">Help & Support</a></li>
        <li><a href="#health">API Status</a></li>
      </ul>

      <div class="nav-actions">
        <div class="status-indicator">
          <span class="status-dot"></span>
          PHP <?=PHP_VERSION?> (Port 8000)
        </div>
        <a href="/pdf" target="_blank" class="btn btn-outline" title="Open VEDAIRO-Enterprise-Complete-User-Guide-v5.0.0.pdf">
          <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          PDF Guide
        </a>
        <a href="/login" class="btn btn-primary">Sign In</a>
      </div>
    </div>
  </nav>

  <div class="container">

    <!-- Hero Section -->
    <header class="hero">
      <div class="hero-pill">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
        Enterprise PHP 8.2+ Application Kernel
      </div>
      <h1 class="hero-title">
        High-Velocity Architecture for <span class="hero-highlight">Modern Enterprise PHP</span>
      </h1>
      <p class="hero-desc">
        A zero-bloat, production-ready framework foundation equipped with native DI container, multi-provider AI gateway, asynchronous job queues, TOTP 2FA, fluent PDO query builder, and enterprise observability.
      </p>

      <div class="hero-actions">
        <a href="/pdf" download="VEDAIRO-Enterprise-Complete-User-Guide-v5.0.0.pdf" class="btn btn-cyan" style="font-size: 1rem; padding: 12px 24px;">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
          Download User Guide PDF (v5.0.0)
        </a>
        <a href="/docs/manual" class="btn btn-outline" style="font-size: 1rem; padding: 12px 24px;">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          Developer Manual
        </a>
        <a href="/login" class="btn btn-primary" style="font-size: 1rem; padding: 12px 24px;">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
          Admin Login
        </a>
        <a href="#support" class="btn btn-outline" style="font-size: 1rem; padding: 12px 22px;">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          Help & Support
        </a>
      </div>
    </header>

    <!-- Quick Terminal Copy Box -->
    <div class="terminal-box">
      <div class="terminal-header">
        <div class="terminal-dots">
          <span class="dot dot-red"></span>
          <span class="dot dot-yellow"></span>
          <span class="dot dot-green"></span>
        </div>
        <span class="terminal-title">bash / powershell — VEDAIRO CLI</span>
      </div>
      <div class="terminal-body">
        <div class="terminal-line">
          <div><span style="color:#64748b;">$</span> <span class="terminal-cmd">php vedairo serve 8000</span></div>
          <button class="copy-btn" onclick="navigator.clipboard.writeText('php vedairo serve 8000'); this.innerText='Copied!'; setTimeout(()=>this.innerText='Copy', 2000)">Copy</button>
        </div>
        <div class="terminal-line">
          <div><span style="color:#64748b;">$</span> <span class="terminal-cmd">php vedairo migrate</span></div>
          <button class="copy-btn" onclick="navigator.clipboard.writeText('php vedairo migrate'); this.innerText='Copied!'; setTimeout(()=>this.innerText='Copy', 2000)">Copy</button>
        </div>
        <div class="terminal-line">
          <div><span style="color:#64748b;">$</span> <span class="terminal-cmd">php vedairo db:seed</span></div>
          <button class="copy-btn" onclick="navigator.clipboard.writeText('php vedairo db:seed'); this.innerText='Copied!'; setTimeout(()=>this.innerText='Copy', 2000)">Copy</button>
        </div>
        <div class="terminal-line">
          <div><span style="color:#64748b;">$</span> <span class="terminal-cmd">php vedairo test</span></div>
          <button class="copy-btn" onclick="navigator.clipboard.writeText('php vedairo test'); this.innerText='Copied!'; setTimeout(()=>this.innerText='Copy', 2000)">Copy</button>
        </div>
      </div>
    </div>

    <!-- Official PDF & Documentation Banner -->
    <div class="showcase-banner">
      <div class="showcase-content">
        <div style="color: var(--cyan); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Official Enterprise Reference</div>
        <h2 class="showcase-title">Complete Developer Manual & PDF Reference</h2>
        <p class="showcase-desc">
          Access the full developer manual covering system architecture, database schema, route specifications, multi-provider AI setups, background queues, and production security audits.
        </p>
        <div class="showcase-actions">
          <a href="/pdf" download="VEDAIRO-Enterprise-Complete-User-Guide-v5.0.0.pdf" class="btn btn-cyan">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download PDF Guide (.pdf)
          </a>
          <a href="/docs/manual" class="btn btn-outline">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            Printable Manual / Web PDF
          </a>
        </div>
      </div>
      <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 20px; font-size: 0.85rem; color: #cbd5e1; min-width: 260px;">
        <div style="font-weight: 700; color: #fff; margin-bottom: 10px;">📋 Quick Credentials:</div>
        <div style="margin-bottom: 6px;">• <strong>URL:</strong> <a href="/login" style="color: #38bdf8;">/login</a></div>
        <div style="margin-bottom: 6px;">• <strong>Email:</strong> <code>admin@vedairo.local</code></div>
        <div style="margin-bottom: 12px;">• <strong>Password:</strong> <code>Admin@12345</code></div>
        <a href="/login" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 8px;">Direct Login</a>
      </div>
    </div>

    <!-- Core Features Grid -->
    <section id="features">
      <div class="section-head">
        <span class="section-badge">Enterprise Engine</span>
        <h2 class="section-title">Engineered for Reliability & Speed</h2>
        <p class="section-desc">Everything needed to build scalable, audit-ready mission-critical PHP enterprise services.</p>
      </div>

      <div class="grid-features">
        <div class="card">
          <div class="card-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
          <h3 class="card-title">Dependency Injection Container</h3>
          <p class="card-desc">Native singleton, factory, and reflection auto-wiring for complete decoupling and testability.</p>
        </div>

        <div class="card">
          <div class="card-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          </div>
          <h3 class="card-title">Multi-Provider AI Gateway</h3>
          <p class="card-desc">Unified interface for OpenAI, Google Gemini, Anthropic Claude, and local Ollama inference models.</p>
        </div>

        <div class="card">
          <div class="card-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          </div>
          <h3 class="card-title">TOTP 2FA & Granular RBAC</h3>
          <p class="card-desc">RFC 6238 two-factor authentication with QR codes, role permissions, and OAuth 2.0 authorization server.</p>
        </div>

        <div class="card">
          <div class="card-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7zm0 4h16M9 4v4"/></svg>
          </div>
          <h3 class="card-title">Fluent Query Builder & Migrations</h3>
          <p class="card-desc">Safe parameterized queries, automatic migration tracking, transactions, and pagination engine.</p>
        </div>

        <div class="card">
          <div class="card-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
          </div>
          <h3 class="card-title">Queue Worker & Cron Scheduler</h3>
          <p class="card-desc">Database-backed asynchronous job processing with dead-letter retry logic and scheduler ticks.</p>
        </div>

        <div class="card">
          <div class="card-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
          </div>
          <h3 class="card-title">Observability & Request IDs</h3>
          <p class="card-desc">Automatic distributed request correlation IDs, security headers, rate limiting, and audit trail logs.</p>
        </div>
      </div>
    </section>

    <!-- Live Health Check Section -->
    <section id="health" class="health-widget">
      <div class="health-head">
        <div class="health-title">
          <span class="status-dot"></span>
          Live Health Endpoint Verification (<code>/api/v1/health</code>)
        </div>
        <button onclick="testHealth()" class="btn btn-outline" style="padding: 6px 14px; font-size: 0.8rem;">
          Run Ping Test
        </button>
      </div>
      <div id="healthResult" class="health-output">
        Click "Run Ping Test" or send GET to /api/v1/health to verify runtime health status.
      </div>
    </section>

    <!-- Help & Support Center -->
    <section id="support" class="support-section">
      <div class="section-head" style="margin-bottom: 24px;">
        <span class="section-badge">Support & Certification</span>
        <h2 class="section-title">Help, Support & Contact Information</h2>
        <p class="section-desc">Certified Enterprise PHP framework foundation developed at Cloud Soft Web Lab.</p>
      </div>

      <div class="support-grid">
        <div class="support-card">
          <h4>📄 PDF Developer Manual</h4>
          <p>Official full technical specification, developer guide, and complete API handbook.</p>
          <div style="display: flex; flex-direction: column; gap: 8px;">
            <a href="/pdf" download="VEDAIRO-Enterprise-Complete-User-Guide-v5.0.0.pdf" class="btn btn-cyan" style="justify-content: center; padding: 8px;">
              📥 Download PDF Guide
            </a>
            <a href="/docs/manual" class="btn btn-outline" style="justify-content: center; padding: 8px;">
              📖 Open Web Manual
            </a>
          </div>
        </div>

        <div class="support-card">
          <h4>👨‍💻 Principal Architect</h4>
          <p><strong>Susanta Ghosh</strong><br>CEO, Cloud Soft Web LLP<br>Lead Framework & Ecosystem Architect</p>
          <div style="font-size: 0.85rem; color: #a5b4fc;">Cloud Soft Web Lab (WB, India)</div>
        </div>

        <div class="support-card">
          <h4>🐙 Source & Repository</h4>
          <p>Official Git repository, release notes, bug tracking, and architectural pull requests.</p>
          <a href="https://github.com/sussantaghosh/vedairo" target="_blank" class="btn btn-outline" style="width: 100%; justify-content: center; padding: 8px;">
            GitHub: sussantaghosh/vedairo
          </a>
        </div>

        <div class="support-card">
          <h4>⚖️ Ecosystem License</h4>
          <p>Released under the VEDAIRO™ Ecosystem License (c) 2026 Cloud Soft Web LLP.</p>
          <a href="/docs/manual#support-contact" class="btn btn-outline" style="width: 100%; justify-content: center; padding: 8px;">
            License & Terms Reference
          </a>
        </div>
      </div>
    </section>

  </div>

  <!-- Footer -->
  <footer>
    <div class="footer-links">
      <a href="/">Home</a>
      <a href="/docs/manual">PDF Developer Manual</a>
      <a href="/docs">Interactive Documentation</a>
      <a href="#support">Help & Support</a>
      <a href="/login">Admin Login</a>
      <a href="https://github.com/sussantaghosh/vedairo" target="_blank">GitHub</a>
    </div>
    <p>VEDAIRO™ Enterprise 5.0.0 — Ecosystem License © 2026 Cloud Soft Web LLP. All rights reserved.</p>
    <p style="margin-top: 4px; font-size: 0.8rem; color: #64748b;">Developed at Cloud Soft Web Lab (WB, India). Principal Architect: Susanta Ghosh.</p>
  </footer>

  <script>
    async function testHealth() {
      const box = document.getElementById('healthResult');
      box.innerText = 'Connecting to /api/v1/health ...';
      try {
        const res = await fetch('/api/v1/health');
        const data = await res.json();
        box.innerText = JSON.stringify(data, null, 2);
      } catch (err) {
        box.innerText = 'Health check response: ' + err.message;
      }
    }
  </script>

</body>
</html>
