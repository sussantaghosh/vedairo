<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VEDAIRO Enterprise — Executive KPI Analytics</title>
  <link rel="icon" type="image/png" href="/logo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #090d16;
      --card-bg: #101726;
      --card-border: rgba(255, 255, 255, 0.08);
      --text: #f1f5f9;
      --text-muted: #94a3b8;
      --primary: #6366f1;
      --cyan: #06b6d4;
      --emerald: #10b981;
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
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
    }
    .brand-logo-img {
      height: 38px;
      width: auto;
      object-fit: contain;
      border-radius: 8px;
      display: block;
    }
    .brand-icon {
      width: 38px;
      height: 38px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--card-border);
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .brand-name {
      font-size: 1.2rem;
      font-weight: 800;
      color: #fff;
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
    .nav-menu a:hover, .nav-menu a.active { color: #fff; }

    .main-container {
      max-width: 1300px;
      width: 100%;
      margin: 0 auto;
      padding: 36px 28px 80px;
      flex: 1;
    }

    .page-head {
      margin-bottom: 30px;
    }
    .page-title {
      font-size: 1.85rem;
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.5px;
    }
    .page-desc {
      color: var(--text-muted);
      font-size: 0.95rem;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
      margin-bottom: 32px;
    }
    .card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 16px;
      padding: 24px;
      transition: all 0.2s;
    }
    .card:hover {
      border-color: rgba(99, 102, 241, 0.35);
      transform: translateY(-2px);
    }
    .card-label {
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 8px;
    }
    .card-number {
      font-size: 2.5rem;
      font-weight: 800;
      color: #fff;
      line-height: 1;
      font-family: var(--font-mono);
    }

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
      transition: all 0.2s;
      font-family: inherit;
    }
    .btn-outline {
      background: rgba(255, 255, 255, 0.05);
      color: #cbd5e1;
      border: 1px solid var(--card-border);
    }
  </style>
</head>
<body>

  <header class="header">
    <div class="header-container">
      <a href="/dashboard" class="brand">
        <img src="/logo.png" alt="VEDAIRO Logo" class="brand-logo-img">
        <div class="brand-name">VEDAIRO</div>
      </a>

      <ul class="nav-menu">
        <li><a href="/dashboard">Overview</a></li>
        <li><a href="/users">Users</a></li>
        <li><a href="/products">Products</a></li>
        <li><a href="/cart">Cart</a></li>
        <li><a href="/admin" class="active">Admin KPI</a></li>
        <li><a href="/docs">Docs</a></li>
        <li><a href="/pdf" target="_blank">PDF Guide</a></li>
      </ul>

      <div>
        <a href="/dashboard" class="btn btn-outline">← Back to Dashboard</a>
      </div>
    </div>
  </header>

  <main class="main-container">
    <div class="page-head">
      <h1 class="page-title">Executive KPI & System Telemetry</h1>
      <p class="page-desc">Aggregated metrics, database record counts, and tenant telemetry.</p>
    </div>

    <div class="grid">
      <?php foreach ($data as $k => $v): ?>
      <div class="card">
        <div class="card-label"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $k))) ?></div>
        <div class="card-number"><?= htmlspecialchars((string)$v) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </main>

</body>
</html>
