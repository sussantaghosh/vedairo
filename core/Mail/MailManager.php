<?php
namespace Vedairo\Mail;
class MailManager {
    public function __construct(private array $config){}
    public function send(string $to,string $subject,string $html,?string $from=null): bool {
        $c=$this->config; $from=$from?:($c['from']??'no-reply@example.com');
        if(($c['driver']??'mail')==='smtp') return $this->smtp($to,$subject,$html,$from,$c);
        $headers="MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\nFrom: {$from}\r\n"; return mail($to,$subject,$html,$headers);
    }
    private function smtp(string $to,string $subject,string $html,string $from,array $c): bool {
        $fp=@fsockopen($c['host'],(int)($c['port']??587),$e,$s,10); if(!$fp) throw new \RuntimeException("SMTP connection failed: $s");
        $read=function()use($fp){return fgets($fp,515);}; $read(); $write=function($x)use($fp,$read){fwrite($fp,$x."\r\n"); $r=$read(); if(!$r||isset($r[0])&&$r[0]>='4') throw new \RuntimeException('SMTP error: '.$r);};
        $write('EHLO vedairo'); if((int)($c['port']??587)===587){$write('STARTTLS'); stream_socket_enable_crypto($fp,true,STREAM_CRYPTO_METHOD_TLS_CLIENT); $write('EHLO vedairo');}
        $write('AUTH LOGIN'); $write(base64_encode($c['username']??'')); $write(base64_encode($c['password']??'')); $write('MAIL FROM:<'.$from.'>'); $write('RCPT TO:<'.$to.'>'); $write('DATA');
        fwrite($fp,"Subject: {$subject}\r\nFrom: {$from}\r\nTo: {$to}\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n{$html}\r\n.\r\n"); $read(); $write('QUIT'); fclose($fp); return true;
    }
}
