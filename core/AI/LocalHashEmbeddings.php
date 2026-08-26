<?php
namespace Vedairo\AI;
final class LocalHashEmbeddings implements Embeddings {public function __construct(private int $dimensions=64){}public function embed(string $text):array{$v=array_fill(0,$this->dimensions,0.0);$tokens=preg_split('/\s+/u',mb_strtolower(trim($text)))?:[];foreach($tokens as $t){$h=hash('sha256',$t,true);for($i=0;$i<$this->dimensions;$i++)$v[$i]+=((ord($h[$i%strlen($h)])-127)/127);} $n = sqrt(array_sum(array_map(fn($x) => $x * $x, $v))) ?: 1;
        $normalized = array_map(fn($x) => $x / $n, $v);
        return array_values($normalized);
    }
}
