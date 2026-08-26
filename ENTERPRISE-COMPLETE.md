# VEDAIRO Enterprise 5.0.0

This release is the consolidated framework build. It includes the framework core plus internal implementations for HTTP/MVC, database/query builder/pagination, validation, sessions/authentication, RBAC, API tokens/resources/OpenAPI, CRUD/cart/checkout, payment gateway abstractions and webhook verification helpers, mail abstraction, file/Redis/S3-compatible storage adapters, cache/queue/worker, scheduler foundation, events, notifications, audit/security, tenancy, AI provider registry (OpenAI-compatible/Gemini/Anthropic/Ollama configuration), RAG storage/retrieval foundation, AI agent tool allow-list, SSE, i18n foundation, backups, CLI and tests.

External accounts/services are intentionally not embedded in the ZIP: provider credentials and servers remain operator-owned. VEDAIRO provides the integration interfaces and configuration.

Production checklist: configure HTTPS, APP_KEY, database credentials, mail, Redis/queue worker, object storage, payment credentials and verified webhooks, AI credentials, backups, monitoring, and run the full integration test suite against staging services before production.
