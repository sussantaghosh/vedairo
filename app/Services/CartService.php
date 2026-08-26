<?php
namespace App\Services;
use App\Models\Product;
class CartService {
 /**
 * @return array<int,int>
 */
    private function &cart(): array {
        if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
            @session_start();
        }
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        return $_SESSION['cart'];
    }

 public function add(int $id,int $qty=1):void { $p=Product::find($id); if(!$p) throw new \RuntimeException('Product not found'); if((int)$p['status']!==1) throw new \RuntimeException('Product unavailable'); $c=&$this->cart(); $c[$id]=($c[$id]??0)+max(1,$qty); if($c[$id]>(int)$p['stock'])$c[$id]=(int)$p['stock']; }
 public function update(int $id,int $qty):void { $c=&$this->cart(); if(!isset($c[$id]))return; $p=Product::find($id);$qty=max(0,$qty);if($p)$qty=min($qty,(int)$p['stock']);if($qty===0)unset($c[$id]);else$c[$id]=$qty; }
 public function remove(int $id):void{$c=&$this->cart();unset($c[$id]);}
 public function clear():void{$c=&$this->cart();$c=[];}
 /**
 * @return array<string,mixed>
 */
public function items(): array {
    $c = $this->cart();
    $out = [];
    $subtotal = 0;
    foreach ($c as $id => $qty) {
        $p = Product::find((int)$id);
        if (!$p) continue;
        $line = (float)$p['price'] * $qty;
        $subtotal += $line;
        $out[] = ['product' => $p, 'product_id' => (int)$id, 'qty' => $qty, 'line_total' => $line];
    }

    return ['items' => $out, 'subtotal' => $subtotal, 'count' => array_sum($c)];
}
}
