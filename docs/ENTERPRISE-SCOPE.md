# VEDAIRO Enterprise 2.0 Scope

This release adds the enterprise integration foundation: RBAC schema, API-token schema, audit logs, multi-tenancy schema, payment gateway adapters, SMTP mail, Redis cache adapter, scheduler foundation, notifications, encryption, health reporting, S3-compatible storage configuration, OpenAI-compatible AI provider abstraction, embeddings/RAG storage schema and AI usage logging.

Provider accounts are intentionally not fabricated or silently created. The installer/admin UI should collect credentials supplied by the operator, encrypt secrets at rest, test the connection, and store provider status. Production payment webhook signature verification must use each provider's official signing algorithm and secret before enabling live settlement.

## Production gates
- Configure HTTPS and secure cookies.
- Configure provider secrets through environment/secret management.
- Run all migrations and automated tests.
- Configure webhook endpoints and signature verification.
- Configure queue workers and scheduler.
- Configure Redis/S3/SMTP where selected.
- Back up database and test restore.
