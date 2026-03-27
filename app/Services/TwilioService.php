<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected Client $client;
    protected string $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->from = config('services.twilio.from');
    }

    public function sendSms(string $to, string $message): bool
    {
        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Twilio SMS error: ' . $e->getMessage());
            return false;
        }
    }
}