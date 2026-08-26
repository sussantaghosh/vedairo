<?php
namespace Vedairo\Payments;
class StripeGateway extends HttpGateway {
    public function __construct(private array $config){}
    public function createPayment(array $order): array { return $this->post('https://api.stripe.com/v1/payment_intents',['amount'=>(int)round($order['amount']*100),'currency'=>$order['currency']??'usd','metadata'=>['order_id'=>$order['id']??'']],['Authorization'=>'Bearer '.$this->config['secret_key']]); }
    public function verifyWebhook(string $payload,array $headers): array { return ['verified'=>true,'payload'=>json_decode($payload,true),'note'=>'Configure official signature verification before production.']; }
    public function refund(string $transactionId,?float $amount=null): array { return $this->post('https://api.stripe.com/v1/refunds',['payment_intent'=>$transactionId]+($amount!==null?['amount'=>(int)round($amount*100)]:[]),['Authorization'=>'Bearer '.$this->config['secret_key']]); }
}
