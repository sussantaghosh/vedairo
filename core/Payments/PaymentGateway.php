<?php
namespace Vedairo\Payments;
interface PaymentGateway {
    public function createPayment(array $order): array;
    public function verifyWebhook(string $payload, array $headers): array;
    public function refund(string $transactionId, ?float $amount=null): array;
}
