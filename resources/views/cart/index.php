<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VEDAIRO Enterprise — Commercial Cart & Checkout</title>
  <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #090d16;
      --card-bg: #101726;
      --card-border: rgba(255, 255, 255, 0.08);
      --text: #f1f5f9;
      --text-muted: #94a3b8;
      --primary: #6366f1;
      --cyan: #06b6d4;
      --emerald: #10b981;
      --rose: #f43f5e;
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
    .brand-icon {
      width: 36px;
      height: 36px;
      background: linear-gradient(135deg, #6366f1, #06b6d4);
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: 800;
      font-size: 1.1rem;
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
      max-width: 1000px;
      width: 100%;
      margin: 0 auto;
      padding: 36px 28px 80px;
      flex: 1;
    }

    .page-head {
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

    .card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 16px;
      padding: 28px;
      margin-bottom: 24px;
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

    .price-col {
      font-family: var(--font-mono);
      font-weight: 700;
      color: #38bdf8;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 10px 20px;
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
    .btn-success {
      background: linear-gradient(135deg, #10b981, #059669);
      color: #fff;
    }
    .btn-outline {
      background: rgba(255, 255, 255, 0.05);
      color: #cbd5e1;
      border: 1px solid var(--card-border);
    }
    .btn-danger {
      background: rgba(244, 63, 94, 0.15);
      color: #fda4af;
      border: 1px solid rgba(244, 63, 94, 0.3);
    }

    .cart-summary {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      margin-top: 10px;
    }
    .subtotal-val {
      font-size: 1.5rem;
      font-weight: 800;
      color: #fff;
      font-family: var(--font-mono);
    }
  </style>
</head>
<body>

  <header class="header">
    <div class="header-container">
      <a href="/dashboard" class="brand">
        <div class="brand-icon">V</div>
        <div class="brand-name">VEDAIRO</div>
      </a>

      <ul class="nav-menu">
        <li><a href="/dashboard">Overview</a></li>
        <li><a href="/users">Users</a></li>
        <li><a href="/products">Products</a></li>
        <li><a href="/cart" class="active">Cart</a></li>
        <li><a href="/admin">Admin KPI</a></li>
        <li><a href="/docs">Docs</a></li>
        <li><a href="/pdf" target="_blank">PDF Guide</a></li>
      </ul>

      <div style="display: flex; gap: 10px;">
        <a href="/products" class="btn btn-outline">+ Browse Catalog</a>
      </div>
    </div>
  </header>

  <main class="main-container">
    <div class="page-head">
      <h1 class="page-title">Commercial Cart & Checkout</h1>
      <p class="page-desc">Transactional order calculation and inventory reservation session.</p>
    </div>

    <div class="card">
      <?php if (empty($data['items'])): ?>
        <div style="text-align: center; padding: 40px 20px;">
          <div style="font-size: 2.5rem; margin-bottom: 12px;">🛒</div>
          <h3 style="color: #fff; margin-bottom: 8px;">Your Shopping Cart is Empty</h3>
          <p style="color: var(--text-muted); margin-bottom: 20px;">Add items from the product inventory catalog to simulate transactional checkout.</p>
          <a href="/products" class="btn btn-primary">Browse Product Catalog →</a>
        </div>
      <?php else: ?>
        <table style="margin-bottom: 20px;">
          <thead>
            <tr>
              <th>Product Line Item</th>
              <th style="width: 100px; text-align: center;">Quantity</th>
              <th style="text-align: right;">Line Total</th>
              <th style="width: 80px; text-align: right;"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['items'] as $i): ?>
            <tr>
              <td><strong><?= e($i['product']['name']) ?></strong></td>
              <td style="text-align: center; font-family: var(--font-mono);"><?= e($i['qty']) ?></td>
              <td style="text-align: right;" class="price-col">$<?= number_format((float)$i['line_total'], 2) ?></td>
              <td style="text-align: right;">
                <button class="btn btn-danger" onclick="removeFromCart(<?= e($i['product_id']) ?>)" style="padding: 4px 8px; font-size: 0.75rem;">✕</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <div class="cart-summary">
          <div>
            <span style="color: var(--text-muted); font-size: 0.9rem;">Cart Subtotal:</span>
            <div class="subtotal-val">$<?= number_format((float)($data['subtotal'] ?? 0), 2) ?></div>
          </div>
          <div style="display: flex; gap: 10px;">
            <button onclick="clearCart()" class="btn btn-outline">Clear Cart</button>
            <form method="post" action="/checkout" style="display:inline;">
              <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
              <button type="submit" class="btn btn-success">Proceed to Checkout →</button>
            </form>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    function removeFromCart(id) {
      $.ajax({
        url: '/cart/' + id,
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
        success: () => location.reload()
      });
    }
    function clearCart() {
      if (!confirm('Clear all items from cart?')) return;
      $.ajax({
        url: '/cart',
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
        success: () => location.reload()
      });
    }
  </script>

</body>
</html>
