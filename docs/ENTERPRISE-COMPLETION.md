# VEDAIRO Enterprise 5.0 – Completion & Operations Guide

VEDAIRO is a modular PHP/MySQL framework. This release consolidates the enterprise foundation and adds working services for authentication, TOTP 2FA, OAuth-style authorization-code tokens, RBAC, API resources, queue workers, scheduler hooks, cache, storage, payments, mail, notifications, multi-tenancy, AI providers, RAG, metrics, backups and business operations.

## Installation
1. Point Apache DocumentRoot to `public/`.
2. Copy `.env.enterprise.example` to `.env`.
3. Create the MySQL database.
4. Run `php vedairo migrate`.
5. Run `php vedairo db:seed`.
6. Configure HTTPS, SMTP, Redis/S3/payment/AI credentials as needed.
7. Run `php vedairo test`.

## Configuration
Secrets belong in `.env` or an external secret manager. Never commit secrets.

## Authentication
- Session authentication
- Remember-me tokens
- Password hashing
- Password reset/email verification tables
- TOTP 2FA with recovery codes
- API bearer tokens

TOTP uses RFC 6238-compatible 30-second SHA-1 codes and a configurable recovery-code set.

## OAuth
The built-in OAuth module implements a first-party authorization-code style flow for applications controlled by the same VEDAIRO installation. Validate exact redirect URIs and use HTTPS in production. For a public OAuth provider with consent UI, PKCE, dynamic client registration and third-party federation, use the documented extension points and an audited OAuth library.

## WebAuthn / Passkeys
The framework exposes credential storage and security extension points. A production passkey deployment should use a maintained WebAuthn/CTAP2 implementation for CBOR/COSE parsing and authenticator verification rather than a handwritten parser. Do not ship an unverified custom passkey verifier.

## Payments
Provider adapters are isolated behind `PaymentGateway`. Configure provider credentials, create payment intents/orders, verify webhook signatures, persist webhook event IDs for idempotency, and reconcile provider status before fulfilling orders.

## Queue
Use `php vedairo queue:work` under Supervisor/systemd. Failed jobs are persisted and retried with bounded backoff.

## Scheduler
Run `php vedairo schedule:run` from cron every minute. Scheduled jobs must be idempotent.

## Redis / S3 / SMTP
Adapters are provider-neutral. Connection health should be checked during deployment and after credential rotation.

## AI
Providers are registered through `AIManager`. The architecture supports OpenAI-compatible APIs, Gemini, Anthropic-compatible APIs and local Ollama-style deployments. Usage should be logged, rate limited and budget limited before enabling untrusted users.

## RAG
Documents are chunked and stored with metadata. The included lexical retrieval works without an external vector service. For semantic retrieval, implement the `Embeddings` contract with a configured embedding provider and persist vectors in a compatible vector store.

## Multi-tenancy
Every tenant-scoped query must include tenant isolation. Prefer database-level enforcement where supported. Never trust a tenant ID supplied by an untrusted client.

## Security checklist
- HTTPS
- `APP_DEBUG=false`
- Secure/HttpOnly/SameSite cookies
- CSRF for browser state changes
- Parameterized SQL
- Output escaping
- Rate limiting
- Strong password policy
- 2FA for privileged users
- Encrypted secrets
- Verified payment webhooks
- Audit logging
- Backups + restore drills
- Least-privilege DB/service accounts

## Testing
Run syntax checks and framework smoke tests. External integrations require staging credentials and real provider test environments; no framework can truthfully certify those without access to the external service.
