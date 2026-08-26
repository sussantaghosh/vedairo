<?php
namespace Vedairo\Payments;
class RazorpayGateway extends HttpGateway {
    public function __construct(private array $config){}
    public function createPayment(array $order): array { $token=base64_encode($this->config['key_id'].':'.$this->config['key_secret']); return $this->post('https://api.razorpay.com/v1/orders',['amount'=>(int)round($order['amount']*100),'currency'=>$order['currency']??'INR','receipt'=>(string)($order['id']??'')],['Authorization'=>'Basic '.$token]); }
    public function verifyWebhook(string $payload,array $headers): array { return ['verified'=>false,'payload'=>json_decode($payload,true),'note'=>'Use Razorpay webhook signature verification with the configured webhook secret.']; }
    public function refund(string $transactionId,?float $amount=null): array { $token=base64_encode($this->config['key_id'].':'.$this->config['key_secret']); return $this->post('https://api.razorpay.com/v1/payments/'.rawurlencode($transactionId).'/refund',$amount!==null?['amount'=>(int)round($amount*100)]:[],['Authorization'=>'Basic '.$token]); }
}
