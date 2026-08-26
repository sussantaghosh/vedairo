# VEDAIRO Enterprise 5.0.0

> **VEDAIRO** is a modern, modular PHP 8.2 / 8.3+ Enterprise Framework and Application Kernel engineered for high-performance MVC applications, REST APIs, commerce platforms, background queue processing, event-driven architectures, and AI model orchestration.

---

## Key Features

- **Kernel & DI Container:** Lightweight, zero-overhead dependency injection container with Reflection-based auto-wiring and singleton management.
- **High-Performance Routing:** Dynamic routing engine with parameter matching, group prefixes, middleware pipelines, and auto-dispatching.
- **Database Abstraction:** Fluent Query Builder, Active-Record Model ORM, transactional concurrency, and cross-database migration tracker.
- **Security Suite:** First-class CSRF protection, TOTP Two-Factor Authentication (2FA), Role-Based Access Control (RBAC), API Bearer tokens, and AES-256-GCM encryption.
- **OAuth 2.0 Server:** Built-in authorization-code grant flow, token issue, client credential management, and token validation.
- **Commerce & Billing Engine:** Transactional cart and order services with inventory locking, multi-currency support, tax calculation, coupon discounts, and invoice generation.
- **Asynchronous Queue & Scheduler:** Database/Sync queue drivers, retry logic, failed-job tracking, worker daemon, and cron task scheduler.
- **AI Model Orchestration:** Multi-provider AI interface supporting OpenAI, Google Gemini, Anthropic Claude, and local Ollama models with embedding support.
- **Cloud & Infrastructure Integrations:** S3-compatible cloud storage, Stripe, Razorpay, Redis caching, and SMTP mail drivers.

---

## Documentation & Installation

- 📖 **[Comprehensive Installation Guide](file:///c:/Users/Admin_Susanta/Downloads/VEDAIRO-ENTERPRISE-v5.0.0/vedairo/INSTALLATION.md)** — Step-by-step setup for development and production (Nginx, Apache, Supervisor, Crontab).
- 🛠️ **[Complete Developer Guide](file:///c:/Users/Admin_Susanta/Downloads/VEDAIRO-ENTERPRISE-v5.0.0/vedairo/COMPLETE-DEVELOPER-GUIDE.md)** — Architecture, components, controllers, services, and coding patterns.

---

## Quick Start (Local Development)

```bash
# 1. Clone the repository
git clone https://github.com/sussantaghosh/vedairo.git
cd vedairo

# 2. Install dependencies
composer install

# 3. Configure environment
cp .env.example .env

# 4. Run database migrations and seed initial data
php vedairo migrate
php vedairo db:seed

# 5. Start the development server
php vedairo serve 8000
```

Open **`http://127.0.0.1:8000`** in your browser.

Default admin credentials:
- **Email:** `admin@vedairo.local`
- **Password:** `Admin@12345`

---

## CLI Commands

```bash
php vedairo about                 # View framework and runtime environment info
php vedairo route:list            # List all registered HTTP & API routes
php vedairo migrate               # Execute pending database migrations
php vedairo db:seed               # Seed database with initial data
php vedairo queue:work [--once]   # Process background jobs from queue
php vedairo schedule:run          # Run scheduled cron jobs
php vedairo cache:clear           # Clear application cache
php vedairo backup [filename]     # Create SQL database backup
php vedairo test                  # Run test suite
php vedairo serve [port]          # Launch local web server (default: 8000)
```

---

## Testing & Quality Assurance

```bash
# Run unit & integration test suite
php vedairo test

# Run deep architectural reflection and route audit
php tests/test_suite.php

# Run PHPStan static analysis (Level 5)
vendor/bin/phpstan analyse core app --level=5
```

---

## License

VEDAIRO™ Ecosystem License — Copyright (c) 2026 Cloud Soft Web LLP.  
Developed at Cloud Soft Web Lab (WB, India).  
Author & Principal Architect: Susanta Ghosh (CEO, Cloud Soft Web LLP).  
See [LICENSE](file:///c:/Users/Admin_Susanta/Downloads/VEDAIRO-ENTERPRISE-v5.0.0/vedairo/LICENSE) for full details.


