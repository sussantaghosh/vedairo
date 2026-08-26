<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VEDAIRO Enterprise 5.0.0 — Official Developer Manual & Architecture Guide</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #0b0f19;
      --card-bg: #111827;
      --border: #1f293d;
      --text: #e2e8f0;
      --text-muted: #94a3b8;
      --primary: #6366f1;
      --primary-light: #818cf8;
      --cyan: #06b6d4;
      --emerald: #10b981;
      --rose: #f43f5e;
      --amber: #f59e0b;
      --font-main: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      --font-mono: 'JetBrains Mono', monospace;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: var(--font-main);
      background-color: var(--bg);
      color: var(--text);
      line-height: 1.65;
      -webkit-font-smoothing: antialiased;
    }

    /* Top Action Bar (hidden on print) */
    .top-bar {
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(11, 15, 25, 0.85);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      padding: 14px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
    }
    .top-bar-left {
      display: flex;
      align-items: center;
      gap: 14px;
    }
    .badge-logo {
      font-weight: 800;
      font-size: 1.1rem;
      letter-spacing: -0.5px;
      background: linear-gradient(135deg, #a5b4fc, #38bdf8);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-decoration: none;
    }
    .doc-pill {
      background: rgba(99, 102, 241, 0.15);
      color: var(--primary-light);
      border: 1px solid rgba(99, 102, 241, 0.3);
      padding: 3px 10px;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .top-bar-actions {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 9px 18px;
      font-size: 0.875rem;
      font-weight: 600;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s ease;
      border: none;
      font-family: inherit;
    }
    .btn-primary {
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      color: #fff;
      box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #4f46e5, #4338ca);
      box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
      transform: translateY(-1px);
    }
    .btn-outline {
      background: rgba(255, 255, 255, 0.05);
      color: var(--text);
      border: 1px solid var(--border);
    }
    .btn-outline:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: #334155;
    }

    /* Container Layout */
    .container {
      max-width: 1000px;
      margin: 0 auto;
      padding: 48px 24px 80px;
    }

    /* Manual Header */
    .manual-header {
      border-bottom: 2px solid var(--border);
      padding-bottom: 32px;
      margin-bottom: 40px;
      position: relative;
    }
    .manual-title {
      font-size: 2.5rem;
      font-weight: 800;
      letter-spacing: -1px;
      line-height: 1.2;
      margin-bottom: 12px;
      background: linear-gradient(135deg, #ffffff 40%, #94a3b8 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .manual-subtitle {
      font-size: 1.15rem;
      color: var(--text-muted);
      margin-bottom: 20px;
    }
    .meta-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 16px;
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 18px;
    }
    .meta-item span {
      display: block;
      font-size: 0.75rem;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-weight: 600;
    }
    .meta-item strong {
      font-size: 0.95rem;
      color: #fff;
      font-weight: 600;
    }

    /* Table of Contents */
    .toc {
      background: rgba(17, 24, 39, 0.6);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 24px;
      margin-bottom: 48px;
    }
    .toc-title {
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      color: #38bdf8;
    }
    .toc-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 10px 24px;
      list-style: none;
    }
    .toc-list li a {
      color: var(--text-muted);
      text-decoration: none;
      font-size: 0.9rem;
      transition: color 0.2s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .toc-list li a:hover {
      color: var(--cyan);
      text-decoration: underline;
    }
    .toc-num {
      color: var(--primary-light);
      font-family: var(--font-mono);
      font-weight: 600;
      font-size: 0.8rem;
    }

    /* Document Sections */
    section {
      margin-bottom: 54px;
      scroll-margin-top: 80px;
    }
    h2 {
      font-size: 1.75rem;
      font-weight: 700;
      letter-spacing: -0.5px;
      margin-bottom: 16px;
      color: #f8fafc;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid var(--border);
      padding-bottom: 10px;
    }
    h2::before {
      content: "";
      display: inline-block;
      width: 6px;
      height: 24px;
      background: linear-gradient(180deg, var(--primary), var(--cyan));
      border-radius: 3px;
    }
    h3 {
      font-size: 1.2rem;
      font-weight: 600;
      margin: 24px 0 10px;
      color: #cbd5e1;
    }
    p {
      margin-bottom: 14px;
      color: #cbd5e1;
    }
    ul, ol {
      margin: 12px 0 16px 24px;
      color: #cbd5e1;
    }
    li {
      margin-bottom: 6px;
    }

    /* Code Blocks */
    pre {
      background: #060911;
      border: 1px solid #1e293b;
      border-radius: 10px;
      padding: 16px 20px;
      overflow-x: auto;
      font-family: var(--font-mono);
      font-size: 0.875rem;
      color: #38bdf8;
      margin: 14px 0 20px;
      position: relative;
    }
    code {
      font-family: var(--font-mono);
      font-size: 0.875em;
      background: rgba(255, 255, 255, 0.08);
      padding: 2px 6px;
      border-radius: 4px;
      color: #7dd3fc;
    }
    pre code {
      background: none;
      padding: 0;
      color: inherit;
    }

    /* Callout Boxes */
    .callout {
      border-left: 4px solid var(--primary);
      background: rgba(99, 102, 241, 0.08);
      border-radius: 0 10px 10px 0;
      padding: 16px 20px;
      margin: 18px 0;
    }
    .callout-success {
      border-color: var(--emerald);
      background: rgba(16, 185, 129, 0.08);
    }
    .callout-warning {
      border-color: var(--amber);
      background: rgba(245, 158, 11, 0.08);
    }
    .callout-title {
      font-weight: 700;
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Tables */
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 18px 0 24px;
      font-size: 0.9rem;
    }
    th, td {
      border: 1px solid var(--border);
      padding: 12px 16px;
      text-align: left;
    }
    th {
      background: #111827;
      color: #94a3b8;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
    }
    tr:nth-child(even) td {
      background: rgba(255, 255, 255, 0.02);
    }

    /* Support Card */
    .support-box {
      background: linear-gradient(135deg, rgba(99, 102, 241, 0.12), rgba(6, 182, 212, 0.08));
      border: 1px solid rgba(99, 102, 241, 0.3);
      border-radius: 14px;
      padding: 24px;
      margin-top: 32px;
    }
    .support-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 16px;
      margin-top: 16px;
    }
    .support-item {
      background: rgba(0, 0, 0, 0.25);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 8px;
      padding: 14px;
    }
    .support-item label {
      display: block;
      font-size: 0.75rem;
      color: var(--text-muted);
      margin-bottom: 4px;
    }
    .support-item strong {
      color: #fff;
      font-size: 0.95rem;
    }

    /* PRINT STYLES FOR PDF GENERATION */
    @media print {
      body {
        background: #ffffff !important;
        color: #0f172a !important;
        font-size: 11pt;
      }
      .top-bar, .no-print {
        display: none !important;
      }
      .container {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
      }
      .manual-title {
        background: none !important;
        -webkit-text-fill-color: #0f172a !important;
        color: #0f172a !important;
      }
      .meta-grid, .toc, .support-box, .support-item {
        background: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
      }
      .meta-item strong, .support-item strong, h2, h3 {
        color: #0f172a !important;
      }
      p, li, .manual-subtitle, .toc-list li a {
        color: #334155 !important;
      }
      pre {
        background: #f1f5f9 !important;
        border: 1px solid #cbd5e1 !important;
        color: #090d16 !important;
        page-break-inside: avoid;
      }
      code {
        background: #e2e8f0 !important;
        color: #0f172a !important;
      }
      table, th, td {
        border-color: #cbd5e1 !important;
      }
      th {
        background: #e2e8f0 !important;
        color: #334155 !important;
      }
      section {
        page-break-inside: avoid;
        margin-bottom: 30px;
      }
      h2 {
        border-color: #cbd5e1 !important;
        color: #0f172a !important;
      }
      .btn {
        display: none !important;
      }
    }
  </style>
</head>
<body>

  <!-- Top Action Navigation Bar -->
  <div class="top-bar">
    <div class="top-bar-left">
      <a href="/" class="badge-logo">VEDAIRO™ Enterprise</a>
      <span class="doc-pill">v5.0.0 Manual</span>
    </div>
    <div class="top-bar-actions">
      <a href="/" class="btn btn-outline">← Back to Home</a>
      <a href="/docs/guide.pdf" download="VEDAIRO-Enterprise-Complete-User-Guide-v5.0.0.pdf" class="btn btn-outline">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        Download .PDF
      </a>
      <button onclick="window.print()" class="btn btn-primary">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Print / Save to PDF
      </button>
      <a href="/login" class="btn btn-outline">Sign In</a>
    </div>
  </div>

  <div class="container">

    <!-- Header Section -->
    <header class="manual-header">
      <h1 class="manual-title">VEDAIRO Enterprise 5.0.0</h1>
      <p class="manual-subtitle">Official Architecture, Developer Manual & Deployment Reference</p>
      
      <div class="meta-grid">
        <div class="meta-item">
          <span>Principal Architect</span>
          <strong>Susanta Ghosh (CEO)</strong>
        </div>
        <div class="meta-item">
          <span>Organization</span>
          <strong>Cloud Soft Web Lab (WB, India)</strong>
        </div>
        <div class="meta-item">
          <span>Release Version</span>
          <strong>v5.0.0 (LTS Production)</strong>
        </div>
        <div class="meta-item">
          <span>Supported Runtime</span>
          <strong>PHP 8.2+ / 8.3+ (CLI & SAPI)</strong>
        </div>
      </div>
    </header>

    <!-- Table of Contents -->
    <nav class="toc">
      <div class="toc-title">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
        Table of Contents
      </div>
      <ul class="toc-list">
        <li><a href="#quick-start"><span class="toc-num">01.</span> Quick Start & Server Run</a></li>
        <li><a href="#cli-reference"><span class="toc-num">02.</span> CLI Tool Reference</a></li>
        <li><a href="#routing"><span class="toc-num">03.</span> Routing & Middleware</a></li>
        <li><a href="#database"><span class="toc-num">04.</span> Database & Migrations</a></li>
        <li><a href="#auth-security"><span class="toc-num">05.</span> Authentication & 2FA</a></li>
        <li><a href="#ai-engine"><span class="toc-num">06.</span> Multi-Provider AI Engine</a></li>
        <li><a href="#queues-scheduler"><span class="toc-num">07.</span> Queues & Task Scheduler</a></li>
        <li><a href="#support-contact"><span class="toc-num">08.</span> Help & Support Center</a></li>
      </ul>
    </nav>

    <!-- 1. Quick Start -->
    <section id="quick-start">
      <h2>1. Quick Start & Server Setup</h2>
      <p>VEDAIRO requires PHP 8.2 or 8.3 with standard extensions (<code>pdo</code>, <code>pdo_mysql</code> or <code>pdo_sqlite</code>, <code>mbstring</code>, <code>openssl</code>, <code>json</code>, <code>curl</code>).</p>
      
      <h3>Step-by-Step Installation:</h3>
      <pre><code># 1. Clone & enter directory
git clone https://github.com/sussantaghosh/vedairo.git
cd vedairo

# 2. Setup environment config
cp .env.example .env

# 3. Run database migrations
php vedairo migrate

# 4. Seed initial admin user & demo records
php vedairo db:seed

# 5. Start development web server
php vedairo serve 8000</code></pre>

      <div class="callout callout-success">
        <div class="callout-title">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Default Administrative Credentials
        </div>
        <p>After running <code>php vedairo db:seed</code>, access the admin portal at <strong>http://127.0.0.1:8000/login</strong> with:</p>
        <p>• <strong>Email:</strong> <code>admin@vedairo.local</code> &nbsp;|&nbsp; • <strong>Password:</strong> <code>Admin@12345</code></p>
      </div>
    </section>

    <!-- 2. CLI Tool Reference -->
    <section id="cli-reference">
      <h2>2. CLI Tool Reference (`php vedairo`)</h2>
      <p>VEDAIRO ships with a unified zero-overhead CLI orchestrator for administrative and maintenance tasks:</p>

      <table>
        <thead>
          <tr>
            <th>Command</th>
            <th>Parameters</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><code>php vedairo serve</code></td>
            <td><code>[port]</code> (default: 8000)</td>
            <td>Launches the local development web server</td>
          </tr>
          <tr>
            <td><code>php vedairo migrate</code></td>
            <td>None</td>
            <td>Applies pending SQL migrations from <code>database/migrations/</code></td>
          </tr>
          <tr>
            <td><code>php vedairo db:seed</code></td>
            <td>None</td>
            <td>Executes the database seeders for users, roles, and products</td>
          </tr>
          <tr>
            <td><code>php vedairo route:list</code></td>
            <td>None</td>
            <td>Lists all registered HTTP and API routes</td>
          </tr>
          <tr>
            <td><code>php vedairo queue:work</code></td>
            <td><code>[--once]</code></td>
            <td>Processes asynchronous background jobs from the queue</td>
          </tr>
          <tr>
            <td><code>php vedairo schedule:run</code></td>
            <td>None</td>
            <td>Evaluates and triggers due cron tasks and automated jobs</td>
          </tr>
          <tr>
            <td><code>php vedairo backup</code></td>
            <td><code>[file.sql]</code></td>
            <td>Generates a full SQL database backup archive</td>
          </tr>
          <tr>
            <td><code>php vedairo test</code></td>
            <td>None</td>
            <td>Runs syntax, unit, and runtime validation suite</td>
          </tr>
          <tr>
            <td><code>php vedairo cache:clear</code></td>
            <td>None</td>
            <td>Flushes file-based cache and compiled templates</td>
          </tr>
          <tr>
            <td><code>php vedairo about</code></td>
            <td>None</td>
            <td>Displays framework release version, PHP environment, and loaded extensions</td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- 3. Routing & Middleware -->
    <section id="routing">
      <h2>3. Routing & Middleware Architecture</h2>
      <p>Routes are declared in <code>routes/web.php</code> and <code>routes/api.php</code>:</p>
      <pre><code>$r = \Vedairo\Application::$container->get('router');

// Web Routes
$r->get('/', 'App\Controllers\HomeController@index');
$r->get('/login', 'App\Controllers\AuthController@showLogin', ['guest']);
$r->post('/login', 'App\Controllers\AuthController@login', ['guest', 'csrf']);
$r->get('/dashboard', 'App\Controllers\HomeController@dashboard', ['auth']);

// Resource CRUD Routes
$r->get('/products', 'App\Controllers\ProductController@index', ['auth']);
$r->post('/products', 'App\Controllers\ProductController@store', ['auth', 'csrf']);
$r->put('/products/{id}', 'App\Controllers\ProductController@update', ['auth', 'csrf']);
$r->delete('/products/{id}', 'App\Controllers\ProductController@destroy', ['auth', 'csrf']);</code></pre>
    </section>

    <!-- 4. Database & Migrations -->
    <section id="database">
      <h2>4. Database Engine & Query Builder</h2>
      <p>VEDAIRO features a zero-dependency, ultra-fast PDO Query Builder with support for MySQL, MariaDB, and SQLite:</p>
      <pre><code>use App\Models\Product;

// Query Builder pagination & search
$products = Product::query()
    ->whereEq('status', 1)
    ->whereLike('name', 'laptop')
    ->orderBy('price', 'ASC')
    ->paginate(15, 1, '/products');</code></pre>
    </section>

    <!-- 5. Authentication & 2FA -->
    <section id="auth-security">
      <h2>5. Authentication, RBAC & TOTP 2FA</h2>
      <p>Built-in security features include:</p>
      <ul>
        <li><strong>Session Authentication & Token Security:</strong> Automatic session regeneration and CSRF protection on all mutating requests.</li>
        <li><strong>TOTP Two-Factor Authentication:</strong> RFC 6238 compliant authenticator app support with QR code pairing.</li>
        <li><strong>Role-Based Access Control (RBAC):</strong> Granular permissions and role checks via <code>Vedairo\Authorization\Rbac</code>.</li>
        <li><strong>Security Headers:</strong> Automatic application of <code>X-Content-Type-Options</code>, <code>X-Frame-Options</code>, <code>Referrer-Policy</code>, and <code>Permissions-Policy</code>.</li>
      </ul>
    </section>

    <!-- 6. AI Engine -->
    <section id="ai-engine">
      <h2>6. Multi-Provider AI Gateway</h2>
      <p>VEDAIRO integrates a unified AI abstraction layer supporting OpenAI, Google Gemini, Anthropic Claude, and local Ollama:</p>
      <pre><code>// In application code:
$ai = \Vedairo\Application::$container->get('ai');
$result = $ai->chat([
    ['role' => 'user', 'content' => 'Summarize the enterprise metrics for Q3.']
]);</code></pre>
    </section>

    <!-- 7. Queues & Schedulers -->
    <section id="queues-scheduler">
      <h2>7. Background Queues & Cron Automation</h2>
      <p>For production deployments, run the background worker as a daemon using Supervisor and configure the cron scheduler:</p>
      <pre><code># Supervisor Worker Config (/etc/supervisor/conf.d/vedairo.conf)
[program:vedairo-worker]
command=php /var/www/vedairo/vedairo queue:work
autostart=true
autorestart=true
user=www-data

# System Crontab (crontab -e)
* * * * * php /var/www/vedairo/vedairo schedule:run >> /dev/null 2>&1</code></pre>
    </section>

    <!-- 8. Help & Support Center -->
    <section id="support-contact">
      <h2>8. Help & Support Center</h2>
      <p>For technical support, licensing inquiries, or enterprise architecture consultation:</p>

      <div class="support-box">
        <h3 style="margin-top: 0; color: #fff;">Cloud Soft Web Lab — Technical Support</h3>
        <p>Enterprise PHP Framework foundation maintained and certified by Cloud Soft Web LLP.</p>
        
        <div class="support-grid">
          <div class="support-item">
            <label>Author & Principal Architect</label>
            <strong>Susanta Ghosh</strong>
          </div>
          <div class="support-item">
            <label>Executive Role</label>
            <strong>CEO, Cloud Soft Web LLP</strong>
          </div>
          <div class="support-item">
            <label>Lab Location</label>
            <strong>West Bengal (WB), India</strong>
          </div>
          <div class="support-item">
            <label>Official Repository</label>
            <strong>github.com/sussantaghosh/vedairo</strong>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer style="margin-top: 60px; padding-top: 24px; border-top: 1px solid var(--border); text-align: center; color: var(--text-muted); font-size: 0.85rem;">
      <p>VEDAIRO™ Enterprise 5.0.0 — Ecosystem License © 2026 Cloud Soft Web LLP. All rights reserved.</p>
      <p style="margin-top: 4px;">Developed at Cloud Soft Web Lab (WB, India).</p>
    </footer>

  </div>

</body>
</html>
