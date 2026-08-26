<?php
namespace App\Services;

use Vedairo\Database\Model;

class OrderService {
    /**
     * @param array<int,array<string,mixed>> $items
     */
    public function checkout(int $userId, array $items, string $currency = 'INR'): int {
        return Model::transaction(function($db) use ($userId, $items, $currency) {
            if (!$items) throw new \InvalidArgumentException('Cart is empty');
            $total = 0.0;
            $lines = [];
            foreach ($items as $item) {
                $p = $db->table('products')->whereEq('id', (int)$item['product_id'])->first();
                if (!$p) throw new \RuntimeException('Product not found');
                $qty = max(1, (int)$item['qty']);
                if ((int)$p['stock'] < $qty) throw new \RuntimeException('Insufficient stock for ' . ($p['name'] ?? 'product'));
                $line = (float)$p['price'] * $qty;
                $total += $line;
                $lines[] = ['product' => $p, 'qty' => $qty, 'line' => $line];
            }

            $orderId = $db->table('orders')->insert([
                'user_id' => $userId,
                'subtotal' => $total,
                'total' => $total,
                'status' => 'pending',
                'currency' => $currency,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            foreach ($lines as $l) {
                $db->table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $l['product']['id'],
                    'product_name' => $l['product']['name'] ?? '',
                    'unit_price' => $l['product']['price'],
                    'price' => $l['product']['price'],
                    'qty' => $l['qty'],
                    'line_total' => $l['line']
                ]);
                $db->table('products')->whereEq('id', $l['product']['id'])->update([
                    'stock' => (int)$l['product']['stock'] - $l['qty'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            return $orderId;
        });
    }
}

