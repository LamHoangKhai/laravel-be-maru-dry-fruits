<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
    {
        try {
            $order_pending_payment = Order::where([['user_id', auth('api')->user()->id], ['transaction_status', 2], ['status', "!=", 5]])->count();
            if ($order_pending_payment >= 3) {
                return response()->json([
                    'message' => 'Please pay for your order to continue shopping',
                    'status_code' => '910'
                ]);
            }
            // $order = Order::latest()->select('id')->first();
            $total = $request->total;
            $bank_code = $request->bank_code;
            $vnp_TmnCode = "VNA6LDMI"; // Mã website tại VNPAY
            $vnp_HashSecret = "IYGRVEUICTOQLKPPLPBKGIZARQXMXIHL"; // Chuỗi bí mật

            $vnp_TxnRef = rand(1,999999) . time() . rand(1000,99999);
            $vnp_OrderInfo = "Pay bills";
            $vnp_OrderType = "Hello Wolrd Dry Fruits";
            $vnp_Amount = $total * 100;
            $vnp_Locale = "VN";
            $vnp_BankCode = $bank_code;
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $vnp_Url = $this->generateVnpayUrl($vnp_TmnCode, $vnp_Amount, $vnp_TxnRef, $vnp_OrderInfo, $vnp_OrderType, $vnp_Locale, $vnp_BankCode, $vnp_IpAddr, $vnp_HashSecret);

            $returnData = [
                'code' => '00',
                'message' => 'success',
                'unique_code' => $vnp_TxnRef,
                'url' => $vnp_Url
            ];

            return response()->json($returnData);
        } catch (\Exception $e) {
            // Xử lý ngoại lệ theo cách phù hợp
            return response()->json(['code' => '01', 'message' => 'error', 'data' => null]);
        }
    }

    private function generateVnpayUrl($vnp_TmnCode, $vnp_Amount, $vnp_TxnRef, $vnp_OrderInfo, $vnp_OrderType, $vnp_Locale, $vnp_BankCode, $vnp_IpAddr, $vnp_HashSecret)
    {
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => route('check_payment'), // Giả sử bạn có một tuyến đường có tên là 'vnpay_return' cho URL trả về
            "vnp_TxnRef" => $vnp_TxnRef
        ];

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac('sha512', rtrim($hashData, '&'), $vnp_HashSecret);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html?" . $hashData . 'vnp_SecureHash=' . $vnpSecureHash;

        return $vnp_Url;
    }

    public function check_payment(Request $request)
    {
        $vnpResponseData = $request->all();

        // Kiểm tra trạng thái thanh toán từ dữ liệu
        $paymentStatus = $vnpResponseData['vnp_ResponseCode'];

        if ($paymentStatus == '00') {
            try {
                return redirect()->away('https://fe-mary-dry-fruits.vercel.app/cart/' . $vnpResponseData['vnp_TxnRef']);
            } catch (Exception) {
                return redirect()->away('https://fe-mary-dry-fruits.vercel.app/cart/2');
            }
        }
        return redirect()->away('https://fe-mary-dry-fruits.vercel.app/cart/2');
    }
}
