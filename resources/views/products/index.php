<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VEDAIRO Enterprise — Product Inventory & Stock</title>
  <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #090d16;
      --card-bg: #101726;
      --card-border: rgba(255, 255, 255, 0.08);
      --card-border-hover: rgba(99, 102, 241, 0.35);
      --text: #f1f5f9;
      --text-muted: #94a3b8;
      --primary: #6366f1;
      --primary-hover: #4f46e5;
      --cyan: #06b6d4;
      --emerald: #10b981;
      --amber: #f59e0b;
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
      max-width: 1300px;
      width: 100%;
      margin: 0 auto;
      padding: 36px 28px 80px;
      flex: 1;
    }

    .page-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
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
      padding: 24px;
      margin-bottom: 24px;
    }

    /* Forms */
    .form-row {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }
    .form-input {
      background: rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 8px;
      padding: 10px 14px;
      font-size: 0.9rem;
      color: #fff;
      font-family: inherit;
      flex: 1;
      min-width: 160px;
    }
    .form-input:focus {
      outline: none;
      border-color: var(--primary);
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 10px 18px;
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
    .btn-primary:hover { background: linear-gradient(135deg, #4f46e5, #4338ca); }
    .btn-success {
      background: linear-gradient(135deg, #10b981, #059669);
      color: #fff;
    }
    .btn-outline {
      background: rgba(255, 255, 255, 0.05);
      color: #cbd5e1;
      border: 1px solid var(--card-border);
    }
    .btn-outline:hover { background: rgba(255, 255, 255, 0.1); color: #fff; }
    .btn-danger {
      background: rgba(244, 63, 94, 0.15);
      color: #fda4af;
      border: 1px solid rgba(244, 63, 94, 0.3);
    }
    .btn-danger:hover { background: rgba(244, 63, 94, 0.3); color: #fff; }
    .btn-cyan {
      background: rgba(6, 182, 212, 0.15);
      color: #7dd3fc;
      border: 1px solid rgba(6, 182, 212, 0.3);
    }
    .btn-cyan:hover { background: rgba(6, 182, 212, 0.3); color: #fff; }

    /* Table */
    .table-responsive { overflow-x: auto; }
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
    tr:hover td { background: rgba(255, 255, 255, 0.02); }

    .price-tag {
      font-family: var(--font-mono);
      font-weight: 700;
      color: #38bdf8;
    }
    .stock-badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 700;
    }
    .stock-in { background: rgba(16, 185, 129, 0.15); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.3); }
    .stock-low { background: rgba(245, 158, 11, 0.15); color: #fde68a; border: 1px solid rgba(245, 158, 11, 0.3); }

    .pagination-wrap {
      display: flex;
      justify-content: center;
      margin-top: 24px;
    }
    .pagination-wrap a, .pagination-wrap span {
      padding: 6px 12px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--card-border);
      color: var(--text);
      text-decoration: none;
      border-radius: 6px;
      margin: 0 3px;
      font-size: 0.85rem;
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
        <li><a href="/products" class="active">Products</a></li>
        <li><a href="/cart">Cart</a></li>
        <li><a href="/admin">Admin KPI</a></li>
        <li><a href="/docs">Docs</a></li>
        <li><a href="/pdf" target="_blank">PDF Guide</a></li>
      </ul>

      <div style="display: flex; gap: 10px;">
        <a href="/cart" class="btn btn-cyan">🛒 View Cart</a>
        <a href="/dashboard" class="btn btn-outline">← Dashboard</a>
      </div>
    </div>
  </header>

  <main class="main-container">
    <div class="page-head">
      <div>
        <h1 class="page-title">Product Catalog & Inventory</h1>
        <p class="page-desc">Manage commercial product SKU catalog, price points, and active warehouse stock.</p>
      </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="card">
      <form class="form-row" method="get">
        <input class="form-input" name="q" value="<?= e($q ?? '') ?>" placeholder="Search product name or SKU...">
        <button class="btn btn-primary" type="submit">Search Catalog</button>
        <?php if (!empty($q)): ?>
          <a href="/products" class="btn btn-outline">Reset Filter</a>
        <?php endif; ?>
      </form>
    </div>

    <!-- Quick Product Add Card -->
    <div class="card">
      <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 14px;">+ Add New Inventory Item</h3>
      <form method="post" action="/products" class="form-row">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <input class="form-input" name="name" placeholder="Item Name (e.g. Dell UltraSharp 32)" required>
        <input class="form-input" name="price" type="number" step="0.01" placeholder="Price (USD)" required style="max-width: 140px;">
        <input class="form-input" name="stock" type="number" placeholder="Stock Qty" required style="max-width: 120px;">
        <button class="btn btn-success" type="submit">Add Product Item</button>
      </form>
    </div>

    <!-- Products Catalog Table -->
    <div class="card">
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Product Name</th>
              <th>Unit Price</th>
              <th>Inventory Stock</th>
              <th style="text-align: right;">Operations</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($p->items)): ?>
              <tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">No product items found.</td></tr>
            <?php else: ?>
              <?php foreach ($p->items as $x): ?>
              <tr>
                <td><span style="font-family: var(--font-mono); color: var(--cyan);">#<?= e($x['id']) ?></span></td>
                <td><strong><?= e($x['name']) ?></strong></td>
                <td><span class="price-tag">$<?= number_format((float)$x['price'], 2) ?></span></td>
                <td>
                  <span class="stock-badge <?= (int)$x['stock'] > 5 ? 'stock-in' : 'stock-low' ?>">
                    <?= (int)$x['stock'] ?> units available
                  </span>
                </td>
                <td style="text-align: right;">
                  <button class="btn btn-cyan addcart" data-id="<?= e($x['id']) ?>" style="padding: 6px 12px; font-size: 0.8rem;">
                    + Add to Cart
                  </button>
                  <button class="btn btn-danger del ms-1" data-id="<?= e($x['id']) ?>" style="padding: 6px 12px; font-size: 0.8rem;">
                    Delete
                  </button>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="pagination-wrap">
        <?= $p->links() ?>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $('.del').click(function(){
      if (!confirm('Are you sure you want to remove this product?')) return;
      let id = $(this).data('id');
      $.ajax({
        url: '/products/' + id,
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
        success: () => location.reload()
      });
    });

    $('.addcart').click(function(){
      let btn = $(this);
      btn.text('Adding...');
      $.post('/cart/add', {
        _token: $('meta[name=csrf-token]').attr('content'),
        product_id: btn.data('id'),
        qty: 1
      }, function(res) {
        btn.text('✓ Added!');
        setTimeout(() => btn.text('+ Add to Cart'), 1800);
      });
    });
  </script>

</body>
</html>
