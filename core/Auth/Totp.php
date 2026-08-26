<?php
namespace Vedairo\Auth;
final class Totp {
 public static function secret(int $length=20): string { $alphabet='ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';$s='';for($i=0;$i<$length;$i++)$s.=$alphabet[random_int(0,31)];return $s; }
 public static function code(string $secret,?int $time=null): string { $time=$time??time();$counter=intdiv($time,30);$key=self::base32Decode($secret);$bin=pack('N*',0,$counter);$hash=hash_hmac('sha1',$bin,$key,true);$offset=ord($hash[19])&15;$n=((ord($hash[$offset])&127)<<24)|((ord($hash[$offset+1])&255)<<16)|((ord($hash[$offset+2])&255)<<8)|(ord($hash[$offset+3])&255);return str_pad((string)($n%1000000),6,'0',STR_PAD_LEFT); }
 public static function verify(string $secret,string $code,int $window=1): bool {for($i=-$window;$i<=$window;$i++)if(hash_equals(self::code($secret,time()+$i*30),$code))return true;return false;}
 public static function uri(string $issuer,string $account,string $secret): string{return 'otpauth://totp/'.rawurlencode($issuer.':'.$account).'?secret='.rawurlencode($secret).'&issuer='.rawurlencode($issuer).'&algorithm=SHA1&digits=6&period=30';}
 private static function base32Decode(string $s): string {
        $s = strtoupper(preg_replace('/[^A-Z2-7]/', '', $s));
        $bits = '';
        foreach (str_split($s) as $c) {
            $pos = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZ234567', $c);
            $pos = $pos === false ? 0 : (int) $pos;
            $bits .= str_pad(decbin($pos), 5, '0', STR_PAD_LEFT);
        }

        $out = '';
        for ($i = 0; $i + 8 <= strlen($bits); $i += 8) {
            $out .= chr((int) bindec(substr($bits, $i, 8)));
        }

        return $out;
    }
}
