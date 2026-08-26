<?php
namespace Vedairo\Business;

use Vedairo\Database\DB;

final class Coupon {
    public function __construct(private DB $db) {}

    public function discount(string $code, float $subtotal): float {
        $now = date('Y-m-d H:i:s');
        $c = $this->db->query(
            'SELECT * FROM coupons WHERE code=? AND active=1 AND (starts_at IS NULL OR starts_at<=?) AND (ends_at IS NULL OR ends_at>=?) AND (usage_limit IS NULL OR used_count<usage_limit)',
            [$code, $now, $now]
        )->fetch();

        if (!$c) {
            return 0.0;
        }

        $d = $c['type'] === 'fixed'
            ? (float) $c['value']
            : $subtotal * ((float) $c['value'] / 100);

        return min($subtotal, max(0.0, round($d, 2)));
    }

    public function consume(string $code): void {
        $this->db->query('UPDATE coupons SET used_count=used_count+1 WHERE code=?', [$code]);
    }
}

