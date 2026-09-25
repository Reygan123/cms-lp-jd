<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WatzapService
{
    protected string $apiKey;
    protected string $numberKey;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey    = config('services.watzap.api_key');
        $this->numberKey = config('services.watzap.number_key');
        $this->apiUrl    = config('services.watzap.api_url', 'https://api.watzap.id/v1');
    }

    public function send(string $phone, string $message): bool
    {
        $phone = $this->formatPhone($phone);

        try {
            $response = Http::timeout(15)->post("{$this->apiUrl}/send_message", [
                'api_key'    => $this->apiKey,
                'number_key' => $this->numberKey,
                'phone_no'   => $phone,
                'message'    => $message,
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::warning('Watzap send failed', [
                'phone'  => $phone,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Watzap exception: ' . $e->getMessage(), ['phone' => $phone]);
        }

        return false;
    }

    protected function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }
        return $phone;
    }
}
