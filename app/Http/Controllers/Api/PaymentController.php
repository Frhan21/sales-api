<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }
    public function createPayment(Request $request)
    {
        // Validasi input
        $request->validate([
            'order_id' => 'required',
            'gross_amount' => 'required|numeric',
        ]);

        $orderDetails = [
            'order_id' => $request->input('order_id'),
            'gross_amount' => $request->input('gross_amount'),
        ];

        $customersDetails = [
            'customer_name' => $request->input('customer_name'),
        ];

        $transactionData = [
            'transaction_details' => $orderDetails,
            'customer_details' => $customersDetails,
        ];

        $snapToken = $this->midtransService->createTransaction($transactionData);

        return response()->json([
            'status' => 'success',
            'token' => $snapToken,
        ]);
    }
}
