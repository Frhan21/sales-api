<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(array $orderDetails)
    {
        // Create transaction payload
        $transactionDetails = [
            'order_id' => $orderDetails['order_id'],
            'gross_amount' => $orderDetails['gross_amount'],
        ];

        $customerDetails = [
            'first_name' => $orderDetails['customer_name'],
        ];

        $transactionData = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        ];

        // Get Snap Token
        return Snap::getSnapToken($transactionData);
    }
}
