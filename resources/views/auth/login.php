<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VEDAIRO Enterprise — Executive Authentication</title>
  <link rel="icon" type="image/png" href="/logo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #090d16;
      --card-bg: rgba(16, 23, 38, 0.85);
      --card-border: rgba(255, 255, 255, 0.08);
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
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 24px;
      position: relative;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }

    .ambient-glow {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(6, 182, 212, 0.06) 50%, transparent 70%);
      pointer-events: none;
      z-index: 0;
    }

    .login-container {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 440px;
    }

    .brand-header {
      text-align: center;
      margin-bottom: 28px;
    }
    .login-logo-img {
      height: 64px;
      width: auto;
      object-fit: contain;
      border-radius: 12px;
      display: inline-block;
      margin-bottom: 12px;
    }
    .brand-icon {
      width: 54px;
      height: 54px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--card-border);
      border-radius: 14px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 12px;
      overflow: hidden;
    }
    .brand-title {
      font-size: 1.6rem;
      font-weight: 800;
      letter-spacing: -0.5px;
      color: #fff;
    }
    .brand-subtitle {
      font-size: 0.9rem;
      color: var(--text-muted);
      margin-top: 4px;
    }

    .card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 20px;
      padding: 36px 32px;
      backdrop-filter: blur(20px);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    }

    .form-group {
      margin-bottom: 20px;
    }
    .form-label {
      display: block;
      font-size: 0.85rem;
      font-weight: 600;
      color: #cbd5e1;
      margin-bottom: 8px;
    }
    .form-input {
      width: 100%;
      background: rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 0.95rem;
      color: #fff;
      font-family: inherit;
      transition: all 0.2s;
    }
    .form-input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
    }

    .btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      padding: 12px;
      font-size: 0.95rem;
      font-weight: 600;
      border-radius: 10px;
      cursor: pointer;
      border: none;
      transition: all 0.2s ease;
      font-family: inherit;
    }
    .btn-primary {
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      color: #fff;
      box-shadow: 0 4px 16px rgba(99, 102, 241, 0.4);
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #4f46e5, #4338ca);
      transform: translateY(-1px);
    }

    .demo-box {
      margin-top: 24px;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--card-border);
      border-radius: 12px;
      padding: 14px 16px;
      font-size: 0.8rem;
      color: var(--text-muted);
    }
    .demo-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 8px;
      font-weight: 700;
      color: #cbd5e1;
    }
    .fill-btn {
      background: rgba(99, 102, 241, 0.2);
      color: #a5b4fc;
      border: 1px solid rgba(99, 102, 241, 0.3);
      padding: 2px 8px;
      border-radius: 4px;
      font-size: 0.75rem;
      cursor: pointer;
    }
    .fill-btn:hover {
      background: rgba(99, 102, 241, 0.35);
      color: #fff;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: var(--text-muted);
      text-decoration: none;
      font-size: 0.85rem;
      transition: color 0.2s;
    }
    .back-link:hover {
      color: #fff;
    }
  </style>
</head>
<body>

  <div class="ambient-glow"></div>

  <div class="login-container">
    <div class="brand-header">
      <img src="/logo.png" alt="VEDAIRO Logo" class="login-logo-img">
      <h1 class="brand-title">VEDAIRO Enterprise</h1>
      <p class="brand-subtitle">Executive Access Portal & Security Gateway</p>
    </div>

    <div class="card">
      <form method="post" action="/login" id="loginForm">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">

        <div class="form-group">
          <label class="form-label" for="email">Work Email Address</label>
          <input class="form-input" id="email" name="email" type="email" placeholder="admin@vedairo.local" required autofocus>
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Security Password</label>
          <input class="form-input" id="password" name="password" type="password" placeholder="••••••••••••" required>
        </div>

        <button type="submit" class="btn btn-primary">
          Sign In to Control Center →
        </button>
      </form>

      <div class="demo-box">
        <div class="demo-header">
          <span>📋 Default Seed Account:</span>
          <button type="button" class="fill-btn" onclick="fillAdmin()">Auto-Fill</button>
        </div>
        <div>Email: <code>admin@vedairo.local</code></div>
        <div>Password: <code>Admin@12345</code></div>
      </div>
    </div>

    <a href="/" class="back-link">← Return to Public Homepage</a>
  </div>

  <script>
    function fillAdmin() {
      document.getElementById('email').value = 'admin@vedairo.local';
      document.getElementById('password').value = 'Admin@12345';
    }
  </script>

</body>
</html>
