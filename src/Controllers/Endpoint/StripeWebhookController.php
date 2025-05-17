<?php

namespace Fiado\Controllers\Endpoint;

use Fiado\Core\Controller;
use Fiado\Helpers\StripeWrapper;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Invoice;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function index()
    {
        $this->redirect($_SERVER["BASE_URL"]);
    }

    public function handler()
    {
        Stripe::setApiKey($_SERVER["STRIPE_SECRETKEY"]);
        $endpoint_secret = $_SERVER["STRIPE_WEBHOOK_SECRETKEY"];

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            echo '⚠️  Webhook error while parsing basic request.';
            http_response_code(400);
            // echo json_encode(['Error parsing payload: ' => $e->getMessage()]);
            exit();
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            echo '⚠️  Webhook error while validating signature.';
            http_response_code(400);
            // echo json_encode(['Error verifying webhook signature: ' => $e->getMessage()]);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'invoice.paid':
                $this->invoice($event->data->object);
                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }

    /**
     * @param Invoice $invoice
     */
    private function invoice(#[\SensitiveParameter] Invoice $invoice)
    {
        StripeWrapper::checkInvoice($invoice);
    }
}