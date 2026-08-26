<?php
namespace Vedairo\Payments;
class PaymentManager { public function __construct(private array $config){} public function gateway(string $name): PaymentGateway { $c=$this->config[$name]??null; if(!$c) throw new \InvalidArgumentException("Unknown payment gateway: $name"); return match($name){ 'stripe'=>new StripeGateway($c), 'razorpay'=>new RazorpayGateway($c), default=>throw new \InvalidArgumentException("Gateway adapter not installed: $name") }; } }
