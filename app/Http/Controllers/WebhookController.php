<?php

// app/Http/Controllers/WebhookController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret'); // Add this to your .env

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('Invalid signature', 400);
        }

        // Log event or handle specific event types
        Log::info('Received Stripe event: ' . $event->type);

        // Example: Handle payment success
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // You can fetch order info from $session->metadata or $session->id
        }

        return response('Webhook handled', 200);
    }
}
