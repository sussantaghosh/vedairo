<?php
namespace Vedairo\Mail;
final class NativeMailer {public function send(string $to,string $subject,string $html,string $from=''):bool{$from=$from?:env('MAIL_FROM','');if($from==='')throw new \RuntimeException('MAIL_FROM not configured');$headers="MIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\nFrom: {$from}\r\n";return mail($to,$subject,$html,$headers);}}
