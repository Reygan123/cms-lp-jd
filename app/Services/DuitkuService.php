<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DuitkuService
{
    protected string $merchantCode;
    protected string $apiKey;
    protected string $callbackUrl;
    protected string $returnUrl;
    protected string $inquiryUrl;
    protected string $statusUrl;

    public function __construct()
    {
        $this->merchantCode = env('DUITKU_MERCHANT_CODE', 'D15218');
        $this->apiKey       = env('DUITKU_API_KEY', 'cdc8f0fdf141307071bf6a5fa58a0ac3');
        $this->callbackUrl  = env('DUITKU_CALLBACK_URL', 'https://api.jatidiri.hexagon.co.id/preparation/payment-assessments/cek-order');
        $this->returnUrl    = env('DUITKU_RETURN_URL', 'https://cek.jatidiri.app/pembayaran/cek');
        $this->inquiryUrl   = env('DUITKU_URL', 'https://passport.duitku.com/webapi/api/merchant/v2/inquiry');
        $this->statusUrl    = env('DUITKU_STATUS_URL', 'https://passport.duitku.com/webapi/api/merchant/transactionStatus');
    }

    /**
     * Map our internal channel code to Duitku payment code.
     */
    public function mapPaymentChannel(string $channel): string
    {
        $map = [
            'QRIS'       => 'NQ', // QRIS Dinamis
            'BCA_VA'     => 'BC', // BCA Virtual Account
            'MANDIRI_VA' => 'M2', // Mandiri Virtual Account
            'BRI_VA'     => 'BR', // BRI Virtual Account (BRIVA)
            'BNI_VA'     => 'B1', // BNI Virtual Account
            'PERMATA_VA' => 'BT', // Permata Virtual Account
            'SHOPEEPAY'  => 'SP', // ShopeePay
            'GOPAY'      => 'SP', // GoPay / E-wallet
            'DANA'       => 'DA', // DANA
        ];

        return $map[$channel] ?? ($channel ?: 'NQ');
    }

    /**
     * Create inquiry request to Duitku.
     */
    public function createInquiry(
        string $orderId,
        int $amount,
        string $paymentChannel,
        string $productDetails,
        array $customer,
        array $additionalParam = []
    ): array {
        $duitkuMethod = $this->mapPaymentChannel($paymentChannel);
        $signature = md5($this->merchantCode . $orderId . $amount . $this->apiKey);

        $payload = [
            'merchantCode'     => $this->merchantCode,
            'paymentAmount'    => (int) $amount,
            'paymentMethod'    => $duitkuMethod,
            'merchantOrderId'  => $orderId,
            'productDetails'   => $productDetails,
            'additionalParam'  => json_encode($additionalParam),
            'merchantUserInfo' => $customer['name'] ?? 'Peserta Jatidiri',
            'customerVaName'   => $customer['name'] ?? 'Peserta Jatidiri',
            'email'            => $customer['email'] ?? 'info.jatidiri@gmail.com',
            'phoneNumber'      => $customer['phone'] ?? '081234567890',
            'callbackUrl'      => $this->callbackUrl,
            'returnUrl'        => $this->returnUrl,
            'signature'        => $signature,
            'expiryPeriod'     => 1440, // 24 hours in minutes
        ];

        Log::info('Duitku Inquiry Request:', ['orderId' => $orderId, 'payload' => $payload]);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ])->timeout(30)->post($this->inquiryUrl, $payload);

            $data = $response->json();
            Log::info('Duitku Inquiry Response:', ['orderId' => $orderId, 'response' => $data]);

            if (isset($data['statusCode']) && $data['statusCode'] === '00') {
                return [
                    'success'            => true,
                    'order_id'           => $orderId,
                    'reference'          => $data['reference'] ?? null,
                    'payment_url'        => $data['paymentUrl'] ?? null,
                    'va_number'          => $data['vaNumber'] ?? null,
                    'qr_string'          => $data['qrString'] ?? null,
                    'amount'             => $amount,
                    'status_code'        => $data['statusCode'],
                    'status_message'     => $data['statusMessage'] ?? 'Inquiry Success',
                ];
            }

            return [
                'success'        => false,
                'status_code'    => $data['statusCode'] ?? 'ERR',
                'status_message' => $data['statusMessage'] ?? ($response->body() ?: 'Failed to create Duitku invoice'),
                'raw'            => $data,
            ];
        } catch (\Throwable $e) {
            Log::error('Duitku Inquiry Exception:', ['orderId' => $orderId, 'error' => $e->getMessage()]);
            return [
                'success'        => false,
                'status_code'    => 'EXC',
                'status_message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check transaction status on Duitku.
     */
    public function checkTransactionStatus(string $orderId): array
    {
        $signature = md5($this->merchantCode . $orderId . $this->apiKey);

        $payload = [
            'merchantCode'    => $this->merchantCode,
            'merchantOrderId' => $orderId,
            'signature'       => $signature,
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ])->timeout(20)->post($this->statusUrl, $payload);

            $data = $response->json();

            $statusCode = $data['statusCode'] ?? '01';
            $isPaid = ($statusCode === '00');
            $isExpired = ($statusCode === '02');

            return [
                'success'        => true,
                'order_id'       => $orderId,
                'is_paid'        => $isPaid,
                'is_expired'     => $isExpired,
                'status_code'    => $statusCode,
                'status_message' => $data['statusMessage'] ?? ($isPaid ? 'SUCCESS' : 'PENDING'),
                'amount'         => $data['amount'] ?? 0,
                'raw'            => $data,
            ];
        } catch (\Throwable $e) {
            return [
                'success'        => false,
                'order_id'       => $orderId,
                'is_paid'        => false,
                'status_message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Validate incoming webhook callback signature from Duitku.
     */
    public function validateCallback(array $params): bool
    {
        $merchantCode    = $params['merchantCode'] ?? '';
        $amount          = $params['amount'] ?? '';
        $merchantOrderId = $params['merchantOrderId'] ?? '';
        $signature       = $params['signature'] ?? '';

        if (!$merchantCode || !$amount || !$merchantOrderId || !$signature) {
            return false;
        }

        $expectedSignature = md5($this->merchantCode . $amount . $merchantOrderId . $this->apiKey);
        return hash_equals($expectedSignature, $signature);
    }
}

