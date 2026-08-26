# VEDAIRO 1.1.0 — Complete Developer Guide

## 1. Run

```bash
cp .env.example .env
php vedairo about
php vedairo migrate
php vedairo db:seed
php vedairo serve 8000
```

Open `http://127.0.0.1:8000`.

Apache/Nginx document root must be `public/`.

## 2. Database

`.env`:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vedairo
DB_USERNAME=root
DB_PASSWORD=
```

Migrations are SQL files in `database/migrations/`. VEDAIRO records executed files in `vedairo_migrations` so the same migration is not executed twice.

## 3. Routes

```php
Route::get('/products', 'ProductController@index');
Route::post('/products', 'ProductController@store');
Route::put('/products/{id}', 'ProductController@update');
Route::delete('/products/{id}', 'ProductController@destroy');
```

Middleware is supplied as an array: `['auth','csrf']`, and parameterized middleware can use `role:admin`.

## 4. CRUD

Product CRUD is the reference module.

- `GET /products` — list/search/sort/paginate
- `POST /products` — create
- `PUT /products/{id}` — update
- `DELETE /products/{id}` — delete

Use the Query Builder instead of string-concatenating user input into SQL.

## 5. Pagination

```php
$p = Product::query()
    ->whereEq('status', 1)
    ->orderBy('id', 'DESC')
    ->paginate(20, (int)$request->input('page', 1), '/products');
```

`$p->items`, `$p->total`, `$p->page`, `$p->perPage`, `$p->lastPage()` and `$p->links()` are available.

## 6. AJAX

Send CSRF in `X-CSRF-TOKEN` and expect JSON from AJAX endpoints. PUT/PATCH/DELETE requests can send JSON or URL-encoded bodies.

## 7. Sessions/Auth

```php
Auth::login($user);
Auth::check();
Auth::user();
Auth::logout();
```

Session IDs are regenerated after login.

## 8. Cart

`CartService` stores product IDs and quantities in the session. It re-reads product price/stock from the database. At checkout, always recalculate all totals server-side.

Endpoints:

```text
GET    /cart
POST   /cart/add
PUT    /cart/{id}
DELETE /cart/{id}
DELETE /cart
```

## 9. API

Health:

```text
GET /api/v1/health
```

Products:

```text
GET /api/v1/products?page=1&per_page=20&q=phone
```

Token:

```text
POST /api/v1/auth/token
```

Then:

```http
Authorization: Bearer YOUR_TOKEN
```

for `/api/v1/me`.

## 10. AI

AI is an optional provider abstraction. Configure an OpenAI-compatible endpoint:

```env
AI_PROVIDER=openai
OPENAI_API_KEY=...
OPENAI_BASE_URL=https://api.openai.com/v1/chat/completions
OPENAI_MODEL=gpt-4o-mini
```

Then application code can use:

```php
$response = ai()->chat([
    ['role' => 'user', 'content' => 'Write a product description']
]);
```

Do not allow an LLM to execute arbitrary PHP, shell commands or unrestricted SQL. Expose explicit, permission-checked tools.

## 11. Security

- Keep `public/` as web root.
- Never commit `.env` secrets.
- Use CSRF on browser state changes.
- Hash passwords.
- Use parameterized queries.
- Validate uploads.
- Rate-limit authentication/API endpoints.
- Recalculate cart/order totals on the server.
- Set `APP_DEBUG=false` in production.
- Use HTTPS.

## 12. Development workflow

Database → migration → model → service → controller → routes → views → validation/CSRF → AJAX → pagination/search → authorization → API → tests → deployment.
