<?php

namespace App\Http\Controllers\Payment;

use App\Services\Api\Payment\Stripe\StripePaymentWebHookService;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Sentry\Severity;
use Symfony\Component\HttpFoundation\Response;

class PaymentWebHookController extends CashierController
{
    public function handleChargeSucceeded($payload): Response
    {
        try {
            // Validate the request from stripe
            $this->checkSupportType($payload['type'], $payload['id']);
            $logs = (new StripePaymentWebHookService())->success($payload);
            $logs_as_string = implode(", ", $logs);
            return new Response($logs_as_string, 200);
        } catch (\Exception $exception) {
            return new Response('Webhook Not Handled ' . $exception->getMessage(), 400);
        }
    }

    public function handleChargeFailed($payload): Response
    {
        $this->checkSupportType($payload['type'], $payload['id']);
        (new StripePaymentWebHookService())->failed($payload);
        return $this->successMethod();
    }

    public function handleChargeRefundUpdated($payload): Response
    {
        $this->checkSupportType($payload['type'], $payload['id']);
        (new StripePaymentWebHookService())->chargeRefundUpdated($payload);
        return $this->successMethod();
    }

    private function checkSupportType(string $type, string $event_id)
    {
        $supported_types = ['charge.succeeded', 'charge.failed', 'charge.refund.updated'];
        if (!$type || !in_array($type, $supported_types) || !isset($event_id)) {
            throw new \Exception('not supported Type');
        }
    }
}
