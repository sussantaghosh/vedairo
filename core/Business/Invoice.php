<?php
namespace Vedairo\Business;
use Vedairo\Database\DB;
final class Invoice {public function __construct(private DB $db){}public function create(int $orderId,float $subtotal,float $tax,float $discount,float $total):int{$no='INV-'.date('Ymd').'-'.strtoupper(bin2hex(random_bytes(4)));return $this->db->table('invoices')->insert(['order_id'=>$orderId,'invoice_no'=>$no,'subtotal'=>$subtotal,'tax'=>$tax,'discount'=>$discount,'total'=>$total,'status'=>'issued']);}}
