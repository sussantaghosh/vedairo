# VEDAIRO Enterprise Production Deployment

1. Set Apache/Nginx document root to `public/`.
2. Copy `.env.enterprise.example` to `.env` and set secrets.
3. Create the MySQL/MariaDB database and least-privilege database user.
4. Run `php vedairo migrate` and `php vedairo db:seed` only when seed data is appropriate.
5. Configure HTTPS and secure cookies.
6. Configure Redis if using Redis cache/queue/session.
7. Configure SMTP and test mail delivery.
8. Configure S3-compatible storage if required.
9. Configure payment provider credentials and verify webhook signatures in staging.
10. Configure AI providers and usage limits.
11. Run `php vedairo test`.
12. Start a supervised queue worker: `php vedairo queue:work`.
13. Schedule `php vedairo schedule:run` from cron if scheduled tasks are registered.
14. Configure database backups: `php vedairo backup storage/backups/backup.sql`.
15. Delete `public/install.php` after installation.
16. Set `APP_DEBUG=false` in production.
