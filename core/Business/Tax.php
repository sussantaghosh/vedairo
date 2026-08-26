<?php
namespace Vedairo\Business;
use Vedairo\Database\DB;
final class Tax {public function __construct(private DB $db){}public function rate(float $subtotal,?int $taxId=null):float{$r=$taxId?$this->db->query('SELECT rate FROM tax_rates WHERE id=? AND active=1',[$taxId])->fetch():$this->db->query('SELECT rate FROM tax_rates WHERE active=1 ORDER BY id LIMIT 1')->fetch();return $r?round($subtotal*((float)$r['rate']/100),2):0.0;}}
