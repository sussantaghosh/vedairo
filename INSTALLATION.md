# VEDAIRO Enterprise 5.0.0 — Installation Guide

This guide provides step-by-step instructions for installing, configuring, and deploying the **VEDAIRO Enterprise 5.0.0** PHP Framework on local development environments and production servers.

---

## 1. System Requirements

Ensure your server or development environment meets the following prerequisites:

| Component | Requirement |
| :--- | :--- |
| **PHP** | `^8.2` or `^8.3` (CLI & FPM/Web SAPI) |
| **Composer** | `v2.x` |
| **Database** | MySQL 8.0+ / MariaDB 10.4+ / SQLite 3 |
| **In-Memory Cache** *(Optional)* | Redis 6.0+ |
| **Web Server** | Nginx / Apache 2.4+ / Built-in PHP CLI Server |

### Required PHP Extensions
- `pdo` & `pdo_mysql` (or `pdo_sqlite`)
- `mbstring`
- `openssl`
- `json`
- `curl`
- `fileinfo`

---

## 2. Quick Installation (Development)

Follow these steps to set up VEDAIRO locally:

### Step 1: Clone the Repository
```bash
git clone https://github.com/your-username/vedairo.git
cd vedairo
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Configure Environment
Copy the example environment configuration file to `.env`:
```bash
cp .env.example .env
```
Open `.env` and configure your database credentials and application settings:
```ini
APP_NAME="VEDAIRO Enterprise"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vedairo
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Run Database Migrations
Create your database schema automatically using the built-in migration runner:
```bash
php vedairo migrate
```

### Step 5: Seed the Database
Populate initial roles, permissions, administrative users, and sample catalog items:
```bash
php vedairo db:seed
```

### Step 6: Start Local Server
Launch the built-in development server:
```bash
php vedairo serve 8000
```
Open your browser and navigate to **`http://127.0.0.1:8000`**.

Default administrative login credentials:
- **Email:** `admin@vedairo.local`
- **Password:** `Admin@12345`

---

## 3. Production Deployment

### Directory Permissions
Ensure the web server user (`www-data`, `nginx`, or `apache`) has write permissions to `storage/`:
```bash
chmod -R 775 storage
chown -R www-data:www-data storage
```

### Nginx Virtual Host Configuration
Configure your Nginx server block with the document root set to the `public/` directory:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name example.com www.example.com;
    root /var/www/vedairo/public;

    index index.php index.html;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Apache Configuration (`.htaccess`)
Ensure `mod_rewrite` is enabled. The `public/.htaccess` file routes all traffic through `public/index.php`:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>
```

---

## 4. Background Workers & Cron Automation

### Queue Worker (Supervisor Daemon)
To process asynchronous background jobs and transactional events in production, configure **Supervisor**:

Create `/etc/supervisor/conf.d/vedairo-worker.conf`:
```ini
[program:vedairo-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/vedairo/vedairo queue:work
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/vedairo/storage/logs/worker.log
```

Update Supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start vedairo-worker:*
```

### Scheduled Tasks (Crontab)
Add the VEDAIRO scheduler to your server's crontab:
```bash
crontab -e
```
Add the following line:
```cron
* * * * * php /var/www/vedairo/vedairo schedule:run >> /dev/null 2>&1
```

---

## 5. Enterprise Integrations Configuration

Edit your `.env` to activate enterprise services:

### AI Multi-Provider
```ini
AI_PROVIDER=openai # openai | gemini | ollama | anthropic

# OpenAI
OPENAI_API_KEY=your_openai_key
OPENAI_MODEL=gpt-4o-mini

# Google Gemini
GEMINI_API_KEY=your_gemini_key
GEMINI_MODEL=gemini-2.5-flash

# Anthropic Claude
ANTHROPIC_API_KEY=your_anthropic_key
ANTHROPIC_MODEL=claude-3-5-sonnet-latest

# Local Ollama
OLLAMA_BASE_URL=http://127.0.0.1:11434/v1
OLLAMA_MODEL=llama3.2
```

### Payment Gateways
```ini
# Stripe
STRIPE_SECRET_KEY=sk_live_...

# Razorpay
RAZORPAY_KEY_ID=rzp_live_...
RAZORPAY_KEY_SECRET=...
```

### S3-Compatible Cloud Storage
```ini
S3_ENDPOINT=https://s3.amazonaws.com
S3_BUCKET=my-vedairo-bucket
S3_ACCESS_KEY=...
S3_SECRET_KEY=...
```

---

## 6. CLI Commands Reference

VEDAIRO includes a complete CLI tool:

```bash
php vedairo about                 # View framework and runtime environment info
php vedairo route:list            # List all registered HTTP & API routes
php vedairo migrate               # Execute pending database migrations
php vedairo db:seed               # Seed database with initial data
php vedairo queue:work [--once]   # Process background jobs from queue
php vedairo schedule:run          # Run scheduled cron jobs
php vedairo cache:clear           # Clear application and file cache
php vedairo backup [filename]     # Create full SQL database backup
php vedairo test                  # Run test suite
php vedairo serve [port]          # Launch local web server (default: 8000)
```

---

## 7. Testing & Verification

Run the test suite and static analysis:

```bash
# Run unit, integration & runtime smoke tests
php vedairo test

# Run deep architectural reflection and route audit
php tests/test_suite.php

# Run PHPStan static analysis (Level 5)
vendor/bin/phpstan analyse core app --level=5
```

---

## 8. License

VEDAIRO™ Ecosystem License — Copyright (c) 2026 Cloud Soft Web LLP.  
Developed at Cloud Soft Web Lab (WB, India). Principal Architect: Susanta Ghosh.  
See [LICENSE](file:///c:/Users/Admin_Susanta/Downloads/VEDAIRO-ENTERPRISE-v5.0.0/vedairo/LICENSE) for full details.
