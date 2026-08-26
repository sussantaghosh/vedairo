<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VEDAIRO Enterprise — Executive Control Center</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #090d16;
      --card-bg: #101726;
      --card-border: rgba(255, 255, 255, 0.08);
      --card-border-hover: rgba(99, 102, 241, 0.35);
      --text: #f1f5f9;
      --text-muted: #94a3b8;
      --primary: #6366f1;
      --primary-hover: #4f46e5;
      --cyan: #06b6d4;
      --emerald: #10b981;
      --amber: #f59e0b;
      --rose: #f43f5e;
      --font-main: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      --font-mono: 'JetBrains Mono', monospace;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: var(--font-main);
      background-color: var(--bg);
      color: var(--text);
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      -webkit-font-smoothing: antialiased;
    }

    /* Top Corporate Navigation */
    .header {
      background: rgba(16, 23, 38, 0.85);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--card-border);
      padding: 14px 28px;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .header-container {
      max-width: 1300px;
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
    .brand-icon {
      width: 36px;
      height: 36px;
      background: linear-gradient(135deg, #6366f1, #06b6d4);
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: 800;
      font-size: 1.1rem;
      box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    }
    .brand-name {
      font-size: 1.2rem;
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.5px;
    }
    .brand-pill {
      font-size: 0.7rem;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 9999px;
      background: rgba(99, 102, 241, 0.15);
      color: #a5b4fc;
      border: 1px solid rgba(99, 102, 241, 0.3);
    }

    .nav-menu {
      display: flex;
      align-items: center;
      gap: 20px;
      list-style: none;
    }
    .nav-menu a {
      color: var(--text-muted);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      transition: color 0.2s;
    }
    .nav-menu a:hover, .nav-menu a.active {
      color: #fff;
    }

    .header-user {
      display: flex;
      align-items: center;
      gap: 14px;
    }
    .user-pill {
      display: flex;
      align-items: center;
      gap: 10px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--card-border);
      padding: 5px 12px;
      border-radius: 9999px;
    }
    .user-avatar {
      width: 24px;
      height: 24px;
      background: linear-gradient(135deg, #10b981, #06b6d4);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      font-weight: 700;
      color: #fff;
    }
    .user-info {
      font-size: 0.85rem;
      font-weight: 600;
      color: #e2e8f0;
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 16px;
      font-size: 0.875rem;
      font-weight: 600;
      border-radius: 8px;
      text-decoration: none;
      cursor: pointer;
      border: none;
      transition: all 0.2s ease;
      font-family: inherit;
    }
    .btn-primary {
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      color: #fff;
      box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #4f46e5, #4338ca);
      transform: translateY(-1px);
    }
    .btn-outline {
      background: rgba(255, 255, 255, 0.05);
      color: #cbd5e1;
      border: 1px solid var(--card-border);
    }
    .btn-outline:hover {
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
    }
    .btn-danger {
      background: rgba(244, 63, 94, 0.15);
      color: #fda4af;
      border: 1px solid rgba(244, 63, 94, 0.3);
    }
    .btn-danger:hover {
      background: rgba(244, 63, 94, 0.25);
      color: #fff;
    }

    /* Main Content */
    .main-container {
      max-width: 1300px;
      width: 100%;
      margin: 0 auto;
      padding: 36px 28px 80px;
      flex: 1;
    }

    /* Welcome Banner */
    .welcome-banner {
      background: linear-gradient(135deg, rgba(99, 102, 241, 0.12), rgba(6, 182, 212, 0.08));
      border: 1px solid rgba(99, 102, 241, 0.25);
      border-radius: 16px;
      padding: 28px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 32px;
    }
    .welcome-text h1 {
      font-size: 1.85rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 6px;
      letter-spacing: -0.5px;
    }
    .welcome-text p {
      color: var(--text-muted);
      font-size: 0.95rem;
    }
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--emerald);
      background: rgba(16, 185, 129, 0.12);
      border: 1px solid rgba(16, 185, 129, 0.25);
      padding: 4px 12px;
      border-radius: 9999px;
    }
    .status-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: var(--emerald);
      box-shadow: 0 0 8px var(--emerald);
    }

    /* Metrics Grid */
    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
      margin-bottom: 36px;
    }
    .metric-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 14px;
      padding: 22px;
      transition: all 0.2s;
    }
    .metric-card:hover {
      border-color: var(--card-border-hover);
      transform: translateY(-2px);
    }
    .metric-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
    }
    .metric-title {
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .metric-icon {
      width: 36px;
      height: 36px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.05);
      color: var(--primary-light);
    }
    .metric-value {
      font-size: 2.2rem;
      font-weight: 800;
      color: #fff;
      line-height: 1;
      margin-bottom: 8px;
    }
    .metric-link {
      font-size: 0.8rem;
      color: var(--cyan);
      text-decoration: none;
      font-weight: 600;
    }
    .metric-link:hover {
      text-decoration: underline;
    }

    /* Operations Section Grid */
    .section-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .operations-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 20px;
      margin-bottom: 36px;
    }
    .op-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 14px;
      padding: 24px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.2s;
    }
    .op-card:hover {
      border-color: var(--card-border-hover);
    }
    .op-card h3 {
      font-size: 1.15rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .op-card p {
      font-size: 0.9rem;
      color: var(--text-muted);
      margin-bottom: 20px;
      line-height: 1.5;
    }
    .op-actions {
      display: flex;
      gap: 10px;
    }

    /* System Telemetry & Metadata Card */
    .meta-card {
      background: rgba(16, 23, 38, 0.5);
      border: 1px solid var(--card-border);
      border-radius: 14px;
      padding: 24px;
    }
    .meta-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.85rem;
    }
    .meta-table td {
      padding: 10px 14px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }
    .meta-table td:first-child {
      color: var(--text-muted);
      width: 220px;
      font-weight: 600;
    }
    .meta-table td:last-child {
      color: #e2e8f0;
      font-family: var(--font-mono);
    }

    /* Footer */
    footer {
      border-top: 1px solid var(--card-border);
      padding: 24px 28px;
      text-align: center;
      color: var(--text-muted);
      font-size: 0.85rem;
    }
    footer a {
      color: var(--cyan);
      text-decoration: none;
    }

    @media (max-width: 768px) {
      .nav-menu { display: none; }
      .welcome-banner { padding: 20px; }
      .main-container { padding: 20px 16px; }
    }
  </style>
</head>
<body>

  <!-- Corporate Header -->
  <header class="header">
    <div class="header-container">
      <a href="/dashboard" class="brand">
        <div class="brand-icon">V</div>
        <div>
          <span class="brand-name">VEDAIRO</span>
          <span class="brand-pill">Enterprise v5.0.0</span>
        </div>
      </a>

      <ul class="nav-menu">
        <li><a href="/dashboard" class="active">Overview</a></li>
        <li><a href="/users">Users</a></li>
        <li><a href="/products">Products</a></li>
        <li><a href="/cart">Cart</a></li>
        <li><a href="/orders">Orders</a></li>
        <li><a href="/admin">Admin KPI</a></li>
        <li><a href="/docs">Developer Docs</a></li>
        <li><a href="/pdf" target="_blank">PDF Guide</a></li>
      </ul>

      <div class="header-user">
        <div class="user-pill">
          <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'A', 0, 1)) ?></div>
          <div class="user-info"><?= htmlspecialchars($user['name'] ?? 'Administrator') ?></div>
        </div>

        <form method="post" action="/logout" style="display:inline;">
          <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
          <button class="btn btn-danger" title="Sign out of current session">Logout</button>
        </form>
      </div>
    </div>
  </header>

  <!-- Main Body Container -->
  <main class="main-container">

    <!-- Welcome Executive Banner -->
    <div class="welcome-banner">
      <div class="welcome-text">
        <div class="status-badge" style="margin-bottom: 8px;">
          <span class="status-dot"></span>
          Authenticated Session Active
        </div>
        <h1>Welcome, <?= htmlspecialchars($user['name'] ?? 'Executive') ?></h1>
        <p>VEDAIRO Enterprise Core Engine is operational with full security and multi-tenant telemetry.</p>
      </div>

      <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="/pdf" target="_blank" class="btn btn-outline">
          <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          Download PDF Guide
        </a>
        <a href="/docs/manual" class="btn btn-primary">
          <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          System Architecture Docs
        </a>
      </div>
    </div>

    <!-- Metrics Cards -->
    <div class="metrics-grid">
      <div class="metric-card">
        <div class="metric-header">
          <span class="metric-title">System Users</span>
          <div class="metric-icon">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          </div>
        </div>
        <div class="metric-value"><?= (int)($stats['users'] ?? 0) ?></div>
        <a href="/users" class="metric-link">Manage System Accounts →</a>
      </div>

      <div class="metric-card">
        <div class="metric-header">
          <span class="metric-title">Product Inventory</span>
          <div class="metric-icon">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
          </div>
        </div>
        <div class="metric-value"><?= (int)($stats['products'] ?? 0) ?></div>
        <a href="/products" class="metric-link">View Catalog & Stock →</a>
      </div>

      <div class="metric-card">
        <div class="metric-header">
          <span class="metric-title">Orders Processed</span>
          <div class="metric-icon">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
          </div>
        </div>
        <div class="metric-value"><?= (int)($stats['orders'] ?? 0) ?></div>
        <a href="/orders" class="metric-link">Inspect Orders & Cart →</a>
      </div>

      <div class="metric-card">
        <div class="metric-header">
          <span class="metric-title">Security & 2FA</span>
          <div class="metric-icon">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
          </div>
        </div>
        <div class="metric-value" style="font-size: 1.5rem; color: #10b981; margin-top: 6px;">RFC 6238</div>
        <a href="/security/2fa/setup" class="metric-link">Configure Authenticator App →</a>
      </div>
    </div>

    <!-- Quick Operations Command Center -->
    <h2 class="section-title">
      <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
      Enterprise Management Modules
    </h2>

    <div class="operations-grid">
      <div class="op-card">
        <div>
          <h3>👥 User Account Governance</h3>
          <p>Full user CRUD with password hashing, roles, and granular RBAC permission assignments.</p>
        </div>
        <div class="op-actions">
          <a href="/users" class="btn btn-primary">Open Users Module</a>
        </div>
      </div>

      <div class="op-card">
        <div>
          <h3>📦 Products & Stock Control</h3>
          <p>Product catalog management, price indexing, inventory stock deductions, and search filters.</p>
        </div>
        <div class="op-actions">
          <a href="/products" class="btn btn-primary">Open Product Manager</a>
          <a href="/cart" class="btn btn-outline">View Cart</a>
        </div>
      </div>

      <div class="op-card">
        <div>
          <h3>📊 Executive Admin KPI</h3>
          <p>High-level dashboard metrics, multi-tenant statistics, revenue aggregation, and server telemetry.</p>
        </div>
        <div class="op-actions">
          <a href="/admin" class="btn btn-primary">Open Admin KPI</a>
        </div>
      </div>

      <div class="op-card">
        <div>
          <h3>🔐 Two-Factor & OAuth Server</h3>
          <p>Setup RFC 6238 TOTP authenticators, manage 2FA backup codes, and issue OAuth 2.0 bearer tokens.</p>
        </div>
        <div class="op-actions">
          <a href="/security/2fa/setup" class="btn btn-outline">2FA Setup</a>
          <a href="/oauth/authorize" class="btn btn-outline">OAuth 2.0</a>
        </div>
      </div>

      <div class="op-card">
        <div>
          <h3>🧠 Multi-Provider AI Engine</h3>
          <p>Unified AI abstraction supporting OpenAI, Google Gemini, Anthropic Claude, and local Ollama.</p>
        </div>
        <div class="op-actions">
          <a href="/docs/manual#ai-engine" class="btn btn-outline">AI Engine Spec</a>
        </div>
      </div>

      <div class="op-card">
        <div>
          <h3>📄 Official Developer Manual</h3>
          <p>Download the official documentation PDF or inspect the complete online technical handbook.</p>
        </div>
        <div class="op-actions">
          <a href="/pdf" download="VEDAIRO-Enterprise-Complete-User-Guide-v5.0.0.pdf" class="btn btn-primary">Download PDF</a>
          <a href="/docs" class="btn btn-outline">Web Manual</a>
        </div>
      </div>
    </div>

    <!-- System Telemetry Metadata Card -->
    <div class="meta-card">
      <h3 style="font-size: 1.05rem; font-weight: 700; color: #fff; margin-bottom: 14px;">
        ⚙️ Session & System Runtime Telemetry
      </h3>
      <table class="meta-table">
        <tbody>
          <tr>
            <td>Active Identity</td>
            <td><?= htmlspecialchars($user['email'] ?? 'admin@vedairo.local') ?> (Role: <strong><?= htmlspecialchars($user['role'] ?? 'user') ?></strong>)</td>
          </tr>
          <tr>
            <td>Runtime Engine</td>
            <td>PHP <?= PHP_VERSION ?> (SAPI: <?= php_sapi_name() ?>)</td>
          </tr>
          <tr>
            <td>Database Engine</td>
            <td>MySQL 8.0+ / SQLite PDO Driver Active</td>
          </tr>
          <tr>
            <td>CSRF Session Protection</td>
            <td><span style="color: #10b981;">✓ ACTIVE</span> — Token: <code><?= substr(csrf_token(), 0, 16) ?>...</code></td>
          </tr>
          <tr>
            <td>Official Documentation</td>
            <td><a href="/pdf" target="_blank" style="color: #38bdf8;">VEDAIRO-Enterprise-Complete-User-Guide-v5.0.0.pdf</a></td>
          </tr>
        </tbody>
      </table>
    </div>

  </main>

  <!-- Corporate Footer -->
  <footer>
    <p>VEDAIRO™ Enterprise 5.0.0 — Ecosystem License © 2026 Cloud Soft Web LLP. Developed at Cloud Soft Web Lab (WB, India).</p>
  </footer>

</body>
</html>
