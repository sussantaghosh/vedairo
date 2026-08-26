<?php
namespace Vedairo\Payments;
abstract class HttpGateway implements PaymentGateway {
    protected function post(string $url,array $payload,array $headers=[]): array {
        $ch=curl_init($url); curl_setopt_array($ch,[CURLOPT_POST=>true,CURLOPT_RETURNTRANSFER=>true,CURLOPT_HTTPHEADER=>array_merge(['Content-Type: application/json'],$headers),CURLOPT_POSTFIELDS=>json_encode($payload),CURLOPT_TIMEOUT=>30]);
        $raw=curl_exec($ch); if($raw===false) throw new \RuntimeException(curl_error($ch)); $code=curl_getinfo($ch,CURLINFO_HTTP_CODE); curl_close($ch); $data=json_decode($raw,true); return ['status'=>$code,'data'=>$data??['raw'=>$raw]];
    }
    protected function get(string $url,array $headers=[]): array { $ch=curl_init($url); curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_HTTPHEADER=>$headers,CURLOPT_TIMEOUT=>30]); $raw=curl_exec($ch); if($raw===false) throw new \RuntimeException(curl_error($ch)); $code=curl_getinfo($ch,CURLINFO_HTTP_CODE); curl_close($ch); return ['status'=>$code,'data'=>json_decode($raw,true)??['raw'=>$raw]]; }
}
