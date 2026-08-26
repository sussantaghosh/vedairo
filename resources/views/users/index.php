<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VEDAIRO Enterprise — User Account Governance</title>
  <link rel="icon" type="image/png" href="/logo.png">
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
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
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

    .grid-layout {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 28px;
    }

    .card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 16px;
      padding: 24px;
    }
    .card-title {
      font-size: 1.15rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 18px;
    }

    /* Table */
    .table-responsive {
      overflow-x: auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.9rem;
    }
    th, td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    th {
      background: rgba(0, 0, 0, 0.2);
      color: var(--text-muted);
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
    }
    tr:hover td {
      background: rgba(255, 255, 255, 0.02);
    }

    .badge {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
    }
    .badge-admin {
      background: rgba(99, 102, 241, 0.18);
      color: #a5b4fc;
      border: 1px solid rgba(99, 102, 241, 0.35);
    }
    .badge-user {
      background: rgba(16, 185, 129, 0.15);
      color: #6ee7b7;
      border: 1px solid rgba(16, 185, 129, 0.3);
    }

    /* Form */
    .form-group {
      margin-bottom: 16px;
    }
    .form-label {
      display: block;
      font-size: 0.85rem;
      font-weight: 600;
      color: #cbd5e1;
      margin-bottom: 6px;
    }
    .form-input {
      width: 100%;
      background: rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 8px;
      padding: 10px 14px;
      font-size: 0.9rem;
      color: #fff;
      font-family: inherit;
    }
    .form-input:focus {
      outline: none;
      border-color: var(--primary);
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 10px 18px;
      font-size: 0.875rem;
      font-weight: 600;
      border-radius: 8px;
      text-decoration: none;
      cursor: pointer;
      border: none;
      transition: all 0.2s;
      font-family: inherit;
    }
    .btn-primary {
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      color: #fff;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #4f46e5, #4338ca);
    }
    .btn-outline {
      background: rgba(255, 255, 255, 0.05);
      color: #cbd5e1;
      border: 1px solid var(--card-border);
    }

    @media (max-width: 900px) {
      .grid-layout { grid-template-columns: 1fr; }
      .nav-menu { display: none; }
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
        <li><a href="/users" class="active">Users</a></li>
        <li><a href="/products">Products</a></li>
        <li><a href="/cart">Cart</a></li>
        <li><a href="/admin">Admin KPI</a></li>
        <li><a href="/docs">Docs</a></li>
        <li><a href="/pdf" target="_blank">PDF Guide</a></li>
      </ul>

      <div style="display: flex; gap: 10px;">
        <a href="/dashboard" class="btn btn-outline">← Back to Dashboard</a>
      </div>
    </div>
  </header>

  <main class="main-container">
    <div class="page-head">
      <div>
        <h1 class="page-title">User Account Governance</h1>
        <p class="page-desc">Directory of all provisioned accounts, roles, and credential records.</p>
      </div>
    </div>

    <div class="grid-layout">
      <!-- Users Table Card -->
      <div class="card">
        <h2 class="card-title">Provisioned Accounts (<?= count($users) ?> Total)</h2>
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Access Role</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $u): ?>
              <tr>
                <td><span style="font-family: var(--font-mono); color: var(--cyan);">#<?= e($u['id']) ?></span></td>
                <td><strong><?= e($u['name']) ?></strong></td>
                <td><?= e($u['email']) ?></td>
                <td>
                  <span class="badge <?= ($u['role'] ?? '') === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                    <?= e($u['role'] ?? 'user') ?>
                  </span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Add User Card -->
      <div class="card">
        <h2 class="card-title">Provision New Account</h2>
        <form method="post" action="/users">
          <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">

          <div class="form-group">
            <label class="form-label" for="name">Full Name</label>
            <input class="form-input" id="name" name="name" placeholder="John Doe" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="email">Work Email</label>
            <input class="form-input" id="email" name="email" type="email" placeholder="user@company.com" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="password">Initial Password</label>
            <input class="form-input" id="password" name="password" type="password" placeholder="••••••••••••" required>
          </div>

          <button type="submit" class="btn btn-primary" style="width: 100%;">
            Create User Record →
          </button>
        </form>
      </div>
    </div>
  </main>

</body>
</html>
